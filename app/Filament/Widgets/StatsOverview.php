<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Pilgrim;
use App\Models\Package;
use App\Models\Reservation;
use App\Models\Hotel;
use App\Models\Room;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pilgrims', Pilgrim::count())
                ->description('Total registered pilgrims')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            Stat::make('Total Packages', Package::count())
                ->description('Available packages')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('primary'),
            Stat::make('Total Reservations', Reservation::count())
                ->description('Bookings made')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('warning'),
            Stat::make('Total Hotels', Hotel::count())
                ->description('Hotels available')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('info'),
            Stat::make('Total Rooms', Room::count())
                ->description('Rooms across hotels')
                ->descriptionIcon('heroicon-m-home-modern')
                ->color('gray'),
            Stat::make('Total Revenue', 'SAR ' . number_format(Reservation::sum('totalPrix'), 2))
                ->description('Total from reservations')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }
}