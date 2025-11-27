<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reservation Details - {{ $record->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
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
        <p>Reservation ID: {{ $record->id }}</p>
    </div>

    <div class="section">
        <h3>Pilgrim Information</h3>
        <div class="info">
            <span class="label">Name:</span> {{ $record->pilgrim->nomFrancais }}<br>
            <span class="label">Arabic Name:</span> {{ $record->pilgrim->nomArabe }} {{ $record->pilgrim->prenomArabe }}<br>
            <span class="label">Phone:</span> {{ $record->pilgrim->tel_1 }}<br>
            <span class="label">City:</span> {{ $record->pilgrim->ville }}<br>
            <span class="label">Date of Birth:</span> {{ $record->pilgrim->dateNaissance }}<br>
        </div>
    </div>

    <div class="section">
        <h3>Passport Information</h3>
        <div class="info">
            @if($record->pilgrim->passportInfo)
                <span class="label">Passport Number:</span> {{ $record->pilgrim->passportInfo->numeroPasseport }}<br>
                <span class="label">Issue Date:</span> {{ $record->pilgrim->passportInfo->dateDelivrance }}<br>
                <span class="label">Expiry Date:</span> {{ $record->pilgrim->passportInfo->dateExpiration }}<br>
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
            <span class="label">Capacity:</span> {{ $record->room->capacity }}<br>
            <span class="label">Price per Night:</span> SAR {{ number_format($record->room->pricePerNight, 2) }}<br>
        </div>
    </div>

    <div class="section">
        <h3>Payment Information</h3>
        <div class="info">
            <span class="label">Total Price:</span> SAR {{ number_format($record->totalPrix, 2) }}<br>
            <span class="label">Amount Paid:</span> SAR {{ number_format($record->montantPaye, 2) }}<br>
            <span class="label">Balance:</span> SAR {{ number_format($record->totalPrix - $record->montantPaye, 2) }}<br>
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
                    <td>{{ $transport->departDate }}</td>
                    <td>{{ $transport->arriveDate }}</td>
                    <td>SAR {{ number_format($transport->price, 2) }}</td>
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
                    <td>{{ $hotel->pivot->nights ?? 'N/A' }}</td>
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
        <p>Generated on {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>
</body>
</html>