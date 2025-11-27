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

        $pdf = app('dompdf.wrapper')->loadView('pdf.reservation', ['record' => $reservation]); // pdf view expects $record variable
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'reservation-' . $reservation->id . '.pdf');
    }
}
