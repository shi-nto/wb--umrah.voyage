<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Support\Enums\MaxWidth;
use App\Models\Reservation;

class AgentReservationCards extends Page
{
    protected function getViewData(): array
    {
        return [
            'records' => $this->records,
        ];
    }
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static string $view = 'filament.pages.agent-reservation-cards';
    protected static ?string $title = 'Agent Reservations';
    protected static ?string $navigationGroup = 'Bookings';
    protected static ?int $navigationSort = 2;

    public $records;
    public $status = 'all';
    public $search = '';
    protected $queryString = ['status', 'search'];

    public function mount()
    {
        $this->status = request('status', $this->status);
        $this->search = request('search', $this->search);
        $this->updateRecords();
    }

    public function updatedStatus($value): void
    {
        $this->updateRecords();
    }

    public function updatedSearch($value): void
    {
        $this->updateRecords();
    }

    private function updateRecords()
    {
        $query = Reservation::with(['pilgrim', 'package', 'room.hotel'])->latest();
        if ($this->status === 'confirmed') {
            $query->where('selectionne', true);
        } elseif ($this->status === 'pending') {
            $query->where('selectionne', false);
        }
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('pilgrim', function ($pq) {
                    $pq->where('nomFrancais', 'like', '%' . $this->search . '%')
                       ->orWhere('nomArabe', 'like', '%' . $this->search . '%');
                })->orWhereHas('room.hotel', function ($hq) {
                    $hq->where('nom', 'like', '%' . $this->search . '%');
                })->orWhereHas('package', function ($pq) {
                    $pq->where('typePack', 'like', '%' . $this->search . '%');
                });
            });
        }
        $this->records = $query->get();
    }

    public function getMaxContentWidth(): MaxWidth | string | null
    {
        return MaxWidth::Full;
    }

    public static function canAccess(): bool
    {
        return auth()->check() && in_array(auth()->user()->role, ['admin', 'agent']);
    }
}
