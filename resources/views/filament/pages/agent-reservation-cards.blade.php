<x-filament-panels::page>
    {{-- Remove default page padding for this content to align with the sidebar --}}
    <div class="w-full mx-0 px-0 max-w-full -mx-4 md:-mx-6 lg:-mx-8">
        <div class="flex items-center justify-between mb-4">
            <div>
                {{-- Page header left-space intentionally left blank; Filament shows the page title by default --}}
            </div>
            <div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <label for="search" class="text-sm text-gray-600">Search</label>
                        <input type="text" id="search" wire:model.live="search" placeholder="Search by name, hotel, package..." class="rounded-md border-gray-300 text-sm py-1 px-2">
                    </div>
                    <div class="flex items-center gap-2">
                        <label for="status" class="text-sm text-gray-600">Status</label>
                        <select id="status" wire:model="status" class="rounded-md border-gray-300 text-sm py-1 px-2">
                            <option value="all">All</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        @include('filament.tables.reservation-table-cards', ['records' => $records])
    </div>
</x-filament-panels::page>
