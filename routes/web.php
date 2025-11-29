<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationActionController;

Route::get('/', function () {
    return view('welcome');
});

// Quick test route to render an Arabic-friendly PDF HTML view
Route::get('/pdf/test-ar', function () {
    return view('pdf.test-ar');
});

// Public signed route for server-side PDF rendering (used by Puppeteer)
use Illuminate\Http\Request;
use App\Models\Reservation;

Route::get('/pdf/public/reservation/{reservation}', function (Request $request, Reservation $reservation) {
    if (! $request->hasValidSignature()) {
        abort(403);
    }
    return view('pdf.reservation', ['record' => $reservation]);
})->name('pdf.public.reservation');

// Diagnostic route: check ArPHP / dompdf Arabic shaping availability
Route::get('/debug/dompdf-ar', function () {
    $pharPath = public_path('../vendor/dompdf/dompdf/lib/I18N/Arabic/ArPHP.phar');
    // normalize
    $pharPath = realpath(dirname(__DIR__, 1) . '/vendor/dompdf/dompdf/lib/I18N/Arabic/ArPHP.phar') ?: (file_exists($pharPath) ? $pharPath : null);

    $data = [
        'I18N_Arabic_Glyphs_exists' => class_exists('I18N_Arabic_Glyphs'),
        'I18N_Arabic_exists' => class_exists('I18N_Arabic'),
        'ArPHP_phar_path' => $pharPath ?: 'not found',
    ];

    // If classes exist, test shaping on a sample Arabic string
    $sample = 'السلام عليكم ورحمة الله وبركاته';
    if (class_exists('I18N_Arabic_Glyphs')) {
        try {
            $a = new \I18N_Arabic_Glyphs('Glyphs');
            $shaped = method_exists($a, 'utf8Glyphs') ? $a->utf8Glyphs($sample, 150) : null;
            $data['shaped_by_I18N_Arabic_Glyphs'] = $shaped;
        } catch (\Throwable $e) {
            $data['shaped_by_I18N_Arabic_Glyphs_error'] = $e->getMessage();
        }
    }

    if (class_exists('I18N_Arabic')) {
        try {
            $a2 = new \I18N_Arabic('Glyphs');
            if (method_exists($a2, 'utf8Glyphs')) {
                $data['shaped_by_I18N_Arabic_utf8Glyphs'] = $a2->utf8Glyphs($sample, 150);
            } elseif (method_exists($a2, 'utf8')) {
                $data['shaped_by_I18N_Arabic_utf8'] = $a2->utf8($sample);
            }
        } catch (\Throwable $e) {
            $data['shaped_by_I18N_Arabic_error'] = $e->getMessage();
        }
    }

    // Attempt to list PHAR internal files if exists
    if ($pharPath && file_exists($pharPath)) {
        try {
            $list = [];
            if (class_exists('Phar')) {
                $ph = new Phar($pharPath);
                foreach (new RecursiveIteratorIterator($ph) as $file) {
                    $list[] = $file->getPathName();
                }
            } else {
                $list = 'Phar extension not available in PHP';
            }
            $data['phar_files'] = array_slice($list, 0, 200);
        } catch (\Throwable $e) {
            $data['phar_list_error'] = $e->getMessage();
        }
    }

    return response()->json($data);
});

Route::get('/debug/dompdf-ar/inspect', function () {
    $pharPath = base_path('vendor/dompdf/dompdf/lib/I18N/Arabic/ArPHP.phar');
    if (! file_exists($pharPath)) {
        return response('PHAR not found at ' . $pharPath, 404);
    }

    try {
        // Try common internal filenames
        $candidates = ['Arabic.php', 'I18N/Arabic.php', 'I18N/Arabic/Glyphs.php', 'src/Arabic.php'];
        $found = null;
        foreach ($candidates as $c) {
            $internal = 'phar://' . str_replace('\\', '/', $pharPath) . '/' . $c;
            if (@file_exists($internal)) {
                $found = $internal;
                break;
            }
        }

        if (! $found) {
            return response('No candidate file found inside PHAR', 404);
        }

        $content = @file_get_contents($found);
        if ($content === false) {
            return response('Could not read ' . $found, 500);
        }

        // Return first 5000 characters to avoid huge responses
        return response(substr($content, 0, 5000), 200, ['Content-Type' => 'text/plain; charset=utf-8']);
    } catch (\Throwable $e) {
        return response('Error: ' . $e->getMessage(), 500);
    }
});
// Admin reservation actions for confirm & PDF, protected by auth.
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::post('/reservations/{reservation}/confirm', [ReservationActionController::class, 'confirm'])
        ->name('admin.reservations.confirm');
    Route::get('/reservations/{reservation}/pdf', [ReservationActionController::class, 'pdf'])
        ->name('admin.reservations.pdf');
});
