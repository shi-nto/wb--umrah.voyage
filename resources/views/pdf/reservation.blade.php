<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reservation Details - {{ $record->id }}</title>
    <style>
          /* Arabic font support: a variable NotoNaskhArabic font is available at storage/app/public and linked to public/storage
              (NotoNaskhArabic-VariableFont_wght.ttf). dompdf requires fonts to be local, so this view uses public/storage path. */
          @font-face {
                /* Prefer HTTP asset path (for Puppeteer/Chrome rendering). Keep file:// fallback for dompdf.
                    Place the font in public/storage (run php artisan storage:link) or public/fonts. */
                font-family: 'NotoNaskhArabic';
                src: url("{{ asset('storage/NotoNaskhArabic-VariableFont_wght.ttf') }}") format('truetype'),
                      url("file://{{ str_replace('\\', '/', public_path('storage/NotoNaskhArabic-VariableFont_wght.ttf')) }}") format('truetype');
                font-weight: 100 900;
                font-style: normal;
          }

          /* Embed DejaVu Sans directly for dompdf to force Latin digits. */
          @font-face {
              font-family: 'DejaVuSansPDF';
              src: url("{{ public_path('fonts/DejaVuSans.ttf') }}") format('truetype');
              font-weight: normal;
              font-style: normal;
          }
          body { font-family: 'NotoNaskhArabic', 'DejaVuSansPDF', Arial, sans-serif; margin: 20px; }
          .arabic { font-family: 'NotoNaskhArabic', 'DejaVuSansPDF', Arial, sans-serif; direction: rtl; text-align: right; }
          .latin {
              font-family: 'DejaVuSansPDF';
              direction: ltr;
              unicode-bidi: isolate;
              -webkit-font-smoothing: antialiased;
          }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .section { margin-bottom: 20px; }
        .section h3 { color: #333; border-bottom: 1px solid #ccc; padding-bottom: 5px; }
        .info { margin: 10px 0; }
        .label { font-weight: bold; display: inline-block; width: 150px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Umrah Reservation Details</h1>
        <p>Reservation ID: <span class="latin">{{ numerals_to_latin($record->id) }}</span></p>
    </div>

    <div class="section">
        <h3>Pilgrim Information</h3>
        <div class="info">
            <span class="label">Name:</span> {{ $record->pilgrim->nomFrancais }}<br>
            <span class="label">Arabic Name:</span> <span class="arabic">{{ $record->pilgrim->nomArabe }} {{ $record->pilgrim->prenomArabe }}</span><br>
            <span class="label">Phone:</span> <span class="latin">{{ numerals_to_latin($record->pilgrim->tel_1) }}</span><br>
            <span class="label">City:</span> {{ $record->pilgrim->ville }}<br>
            <span class="label">Date of Birth:</span> <span class="latin">{{ numerals_to_latin($record->pilgrim->dateNaissance) }}</span><br>
        </div>
    </div>

    <div class="section">
        <h3>Passport Information</h3>
        <div class="info">
            @if($record->pilgrim->passports && $record->pilgrim->passports->count())
                @foreach($record->pilgrim->passports as $passport)
                    <span class="label">Passport Number:</span> <span class="latin">{{ numerals_to_latin($passport->numeroPasseport) }}</span><br>
                    <span class="label">Issue Date:</span> <span class="latin">{{ numerals_to_latin($passport->dateDelivrance) }}</span><br>
                    <span class="label">Expiry Date:</span> <span class="latin">{{ numerals_to_latin($passport->dateExpiration) }}</span><br>
                    <br />
                @endforeach
            @else
                No passport information available
            @endif
        </div>
    </div>

    <div class="section">
        <h3>Package Details</h3>
        <div class="info">
            <span class="label">Package Type:</span> {{ $record->package->typePack }}<br>
            <span class="label">Category:</span> {{ $record->package->category }}<br>
            <span class="label">Programme:</span> {{ $record->package->programme }}<br>
            <span class="label">Event:</span> {{ $record->package->event->code ?? 'N/A' }}<br>
        </div>
    </div>

    <div class="section">
        <h3>Room Information</h3>
        <div class="info">
            <span class="label">Hotel:</span> {{ $record->room->hotel->nom }}<br>
            <span class="label">Room Type:</span> {{ $record->room->type }}<br>
            <span class="label">Capacity:</span> <span class="latin">{{ numerals_to_latin($record->room->capacity) }}</span><br>
            <span class="label">Price per Night:</span> SAR <span class="latin">{{ numerals_to_latin(number_format($record->room->pricePerNight, 2)) }}</span><br>
        </div>
    </div>

    <div class="section">
        <h3>Payment Information</h3>
        <div class="info">
            <span class="label">Total Price:</span> SAR <span class="latin">{{ numerals_to_latin(number_format($record->totalPrix, 2)) }}</span><br>
            <span class="label">Amount Paid:</span> SAR <span class="latin">{{ numerals_to_latin(number_format($record->montantPaye, 2)) }}</span><br>
            <span class="label">Balance:</span> SAR <span class="latin">{{ numerals_to_latin(number_format($record->totalPrix - $record->montantPaye, 2)) }}</span><br>
            <span class="label">Status:</span> {{ $record->selectionne ? 'Confirmed' : 'Pending' }}<br>
        </div>
    </div>

    <div class="section">
        <h3>Transports Included</h3>
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Provider</th>
                    <th>Route</th>
                    <th>Departure</th>
                    <th>Arrival</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($record->package->transports as $transport)
                <tr>
                    <td>{{ $transport->type }}</td>
                    <td>{{ $transport->provider }}</td>
                    <td>{{ $transport->departCity }} to {{ $transport->arriveCity }}</td>
                    <td><span class="latin">{{ numerals_to_latin($transport->departDate) }}</span></td>
                    <td><span class="latin">{{ numerals_to_latin($transport->arriveDate) }}</span></td>
                    <td>SAR <span class="latin">{{ numerals_to_latin(number_format($transport->price, 2)) }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>Hotels Included</h3>
        <table>
            <thead>
                <tr>
                    <th>Hotel</th>
                    <th>City</th>
                    <th>Nights</th>
                </tr>
            </thead>
            <tbody>
                @foreach($record->package->hotels as $hotel)
                <tr>
                    <td>{{ $hotel->nom }}</td>
                    <td>{{ $hotel->ville }}</td>
                    <td><span class="latin">{{ isset($hotel->pivot->nights) ? numerals_to_latin($hotel->pivot->nights) : 'N/A' }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>Family Relationships</h3>
        <div class="info">
            @php
                $relationships = collect($record->pilgrim->relationshipsFrom)->merge($record->pilgrim->relationshipsTo);
            @endphp
            @if($relationships->count() > 0)
                @foreach($relationships as $rel)
                    @php
                        $other = $rel->pilgrim_a_id == $record->pilgrim->id ? $rel->pilgrimB : $rel->pilgrimA;
                    @endphp
                    - {{ $rel->relationType }}: {{ $other->nomFrancais }}<br>
                @endforeach
            @else
                No family relationships
            @endif
        </div>
    </div>

    <div class="footer" style="margin-top: 40px; text-align: center; font-size: 12px; color: #666;">
        <p>Generated on <span class="latin">{{ numerals_to_latin(now()->format('Y-m-d H:i:s')) }}</span></p>
    </div>
</body>
</html>