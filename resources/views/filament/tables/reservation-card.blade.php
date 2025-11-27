@php
    $editUrl = \App\Filament\Resources\ReservationResource::getUrl('edit', ['record' => $record]);
    $pdfUrl = url("/admin/reservations/{$record->id}/pdf");
    $confirmUrl = url("/admin/reservations/{$record->id}/confirm");
    $paidRatio = $record->totalPrix > 0 ? min(1, $record->montantPaye / $record->totalPrix) : 0;
    $badgeClass = $record->selectionne ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';
    $borderClass = $record->selectionne ? 'border-green-200' : 'border-yellow-100';
@endphp

<div class="w-full bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 border {{ $borderClass }} dark:border-gray-700 hover:shadow-lg transition-shadow duration-200 ml-0">
    <div class="flex items-start justify-between gap-3">
                <a href="{{ $editUrl }}" class="group block w-full">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-600 to-pink-500 flex items-center justify-center text-white text-lg font-bold">
                    {{ strtoupper(substr($record->pilgrim->nomFrancais, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-base font-semibold text-gray-900 group-hover:text-indigo-600 truncate">{{ $record->pilgrim->nomFrancais }}</h3>
                    <p class="text-sm text-gray-500 truncate">{{ $record->pilgrim->ville }} • {{ $record->package->typePack }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeClass }}">
                        {{ $record->selectionne ? 'Confirmed' : 'Pending' }}
                    </span>
                </div>
            </div>
            <div class="mt-3">
                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $paidRatio * 100 }}%"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-500 mt-2">
                    <span>Total: SAR {{ number_format($record->totalPrix, 2) }}</span>
                    <span>Paid: SAR {{ number_format($record->montantPaye, 2) }}</span>
                </div>
            </div>
        </a>
    </div>

    <div class="mt-4 flex items-center justify-between gap-2">
        <div class="flex items-center gap-2">
            <a href="{{ $editUrl }}" class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-gray-200 rounded-md text-sm text-gray-700 hover:bg-gray-50 transition">
                <x-heroicon-o-pencil class="w-4 h-4" />
                <span>Edit</span>
            </a>
            @if($record->selectionne)
                <a href="{{ $pdfUrl }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700 transition">
                    <x-heroicon-o-document-arrow-down class="w-4 h-4" />
                    <span>Download</span>
                </a>
            @endif
        </div>

        <div>
            @if(!$record->selectionne)
                <form method="POST" action="{{ $confirmUrl }}" class="inline-block">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-3 py-1.5 bg-green-600 text-white rounded-md text-sm hover:bg-green-700 transition" onclick="return confirm('Confirm this booking?')">
                        <x-heroicon-o-check class="w-4 h-4" />
                        <span>Confirm</span>
                    </button>
                </form>
            @else
                <a href="{{ $pdfUrl }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700 transition">
                    <x-heroicon-o-document-arrow-down class="w-4 h-4" />
                    <span>Download</span>
                </a>
            @endif
        </div>
    </div>
</div>