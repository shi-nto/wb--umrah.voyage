<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ReservationActionController extends Controller
{
    public function confirm(Request $request, Reservation $reservation): RedirectResponse
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'agent'])) {
            abort(403);
        }

        // Check if payment is complete
        if ($reservation->montantPaye < $reservation->totalPrix) {
            // Create payment reminder alert
            \App\Models\Alert::create([
                'pilgrim_id' => $reservation->pilgrim_id,
                'type' => 'Payment Reminder',
                'message' => 'Your payment is incomplete. Remaining balance: SAR ' . number_format($reservation->totalPrix - $reservation->montantPaye, 2),
            ]);
            return back()->with('error', 'Payment incomplete. Alert sent to pilgrim.');
        }

        if (! $reservation->selectionne) {
            $reservation->update(['selectionne' => true]);
            \App\Models\Alert::create([
                'pilgrim_id' => $reservation->pilgrim_id,
                'type' => 'Booking Confirmed',
                'message' => 'Your Umrah booking has been confirmed.',
            ]);
        }

        return back()->with('success', 'Reservation confirmed.');
    }

    public function pdf(Request $request, Reservation $reservation)
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'agent'])) {
            abort(403);
        }
        // Render the reservation Blade view to HTML
        $html = view('pdf.reservation', ['record' => $reservation])->render();

        // Ensure temporary directory for mPDF
        $tmpDir = storage_path('app/mpdf_tmp');
        if (! file_exists($tmpDir)) {
            @mkdir($tmpDir, 0755, true);
        }

        // Try to discover an Arabic-capable font file in common locations
        $fontCandidates = [
            public_path('fonts/NotoNaskhArabic-Regular.ttf'),
            public_path('storage/NotoNaskhArabic-VariableFont_wght.ttf'),
            public_path('fonts/Amiri-Regular.ttf'),
        ];
        $fontFile = null;
        foreach ($fontCandidates as $f) {
            if (file_exists($f)) {
                $fontFile = $f;
                break;
            }
        }

        // mPDF configuration
        $mpdfConfig = [
            'mode' => 'utf-8',
            'format' => 'A4',
            'tempDir' => $tmpDir,
        ];

        if ($fontFile) {
            // Register custom font directory and font data so mPDF can use the TTF
            $fontDirDefaults = (new \Mpdf\Config\FontVariables())->getDefaults();
            $mpdfConfig['fontDir'] = array_merge($fontDirDefaults['fontDir'], [dirname($fontFile)]);

            $fontDataDefaults = $fontDirDefaults['fontdata'];
            $fontName = 'NotoNaskhArabic';
            $mpdfConfig['fontdata'] = $fontDataDefaults + [
                $fontName => [
                    'R' => basename($fontFile),
                ],
            ];
            $mpdfConfig['default_font'] = $fontName;
        }

        try {
            $mpdf = new \Mpdf\Mpdf($mpdfConfig);

            // Write the HTML. The Blade view contains dir=rtl and appropriate CSS for Arabic blocks.
            $mpdf->WriteHTML($html);
            $pdf = $mpdf->Output('', 'S'); // return PDF as string

            return response($pdf, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="reservation-' . $reservation->id . '.pdf"',
            ]);
        } catch (\Throwable $e) {
            \Log::error('mPDF generation failed', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            abort(500, 'Failed to generate PDF (mPDF). Check logs for details.');
        }
    }
}
