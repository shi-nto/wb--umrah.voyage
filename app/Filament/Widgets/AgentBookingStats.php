<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Reservation;
use App\Models\Pilgrim;
use App\Models\Package;

class AgentBookingStats extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();
        
        if ($user->role !== 'agent') {
            return [];
        }

        // Get agent's reservations
        $totalReservations = Reservation::count();
        $totalRevenue = Reservation::sum('totalPrix');
        $totalPaid = Reservation::sum('montantPaye');
        $pendingPayment = $totalRevenue - $totalPaid;

        return [
            Stat::make('Total Reservations', $totalReservations)
                ->description('Bookings created')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success'),
            
            Stat::make('Total Revenue', 'SAR ' . number_format($totalRevenue, 2))
                ->description('Total booking value')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),
            
            Stat::make('Collected', 'SAR ' . number_format($totalPaid, 2))
                ->description('Payments received')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            
            Stat::make('Pending', 'SAR ' . number_format($pendingPayment, 2))
                ->description('Outstanding payments')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->role === 'agent';
    }
}
