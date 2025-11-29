<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Filament\Resources\ReservationResource\RelationManagers;
use App\Models\Reservation;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationGroup = 'Bookings';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && in_array(auth()->user()->role, ['admin', 'agent']);
    }

    public static function canViewAny(): bool
    {
        // Allow admin and agent to view, but navigation is hidden for agents
        return auth()->check() && in_array(auth()->user()->role, ['admin', 'agent']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Pilgrim Information')
                    ->schema([
                        Forms\Components\Select::make('pilgrim_id')
                            ->label('Select Pilgrim')
                            ->relationship('pilgrim', 'nomFrancais')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                if ($state) {
                                    $pilgrim = \App\Models\Pilgrim::with(['passports', 'relationshipsFrom.pilgrimB', 'relationshipsTo.pilgrimA', 'reservations.package'])->find($state);
                                    $set('pilgrim_info', $pilgrim ? "Name: {$pilgrim->nomFrancais} | Phone: {$pilgrim->tel_1} | City: {$pilgrim->ville}" : '');
                                    
                                    // Passport(s)
                                    $passportInfo = 'No passport information available';
                                    if ($pilgrim->passports && $pilgrim->passports->count()) {
                                        $passportInfo = $pilgrim->passports->map(function ($p) {
                                            return "Number: {$p->numeroPasseport}, Issue: {$p->dateDelivrance}, Expiry: {$p->dateExpiration}";
                                        })->join("\n");
                                    }
                                    $set('pilgrim_passport', $passportInfo);
                                    
                                    // Relationships
                                    $relationships = collect($pilgrim->relationshipsFrom)->merge($pilgrim->relationshipsTo);
                                    $relInfo = $relationships->map(function ($rel) use ($pilgrim) {
                                        $other = $rel->pilgrim_a_id == $pilgrim->id ? $rel->pilgrimB : $rel->pilgrimA;
                                        return "- {$rel->relationType}: {$other->nomFrancais}";
                                    })->join("\n");
                                    $set('pilgrim_relationships', $relInfo ?: 'No family relationships');
                                    
                                    // Other Reservations
                                    $currentId = $get('id');
                                    $reservations = $pilgrim->reservations->filter(function ($res) use ($currentId) {
                                        return $res->id != $currentId;
                                    });
                                    $resInfo = $reservations->map(function ($res) {
                                        return "- Package: {$res->package->typePack}, Confirmed: " . ($res->selectionne ? 'Yes' : 'No');
                                    })->join("\n");
                                    $set('pilgrim_reservations', $resInfo ?: 'No other reservations');
                                } else {
                                    $set('pilgrim_info', '');
                                    $set('pilgrim_passport', '');
                                    $set('pilgrim_relationships', '');
                                    $set('pilgrim_reservations', '');
                                }
                            }),
                        
                        // Passport validation removed per request
                        Forms\Components\TextInput::make('pilgrim_info')
                            ->label('Pilgrim Details')
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('pilgrim_passport')
                            ->label('Passport Information')
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull()
                            ->rows(3),
                        Forms\Components\Textarea::make('pilgrim_relationships')
                            ->label('Family Relationships')
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull()
                            ->rows(2),
                        Forms\Components\Textarea::make('pilgrim_reservations')
                            ->label('Other Reservations')
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull()
                            ->rows(3),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Package & Room Selection')
                    ->schema([
                        Forms\Components\Hidden::make('transport_total'),
                        Forms\Components\Hidden::make('event_days'),
                        
                        Forms\Components\Select::make('package_id')
                            ->label('Umrah Package')
                            ->relationship('package', 'typePack')
                            ->required()
                            ->reactive()
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->typePack} - {$record->category} - {$record->programme}")
                            ->afterStateHydrated(function ($state, callable $set, callable $get) {
                                if ($state) {
                                    $package = \App\Models\Package::with('transports', 'event')->find($state);
                                    if ($package) {
                                        $transportTotal = $package->transports->sum('price');
                                        $set('transport_total', $transportTotal);
                                        if ($package->event) {
                                            $start = Carbon::parse($package->event->start_date);
                                            $end = Carbon::parse($package->event->end_date);
                                            $days = $end->diffInDays($start) + 1;
                                            $set('event_days', $days);
                                        }
                                        // If a room is already selected, update total
                                        $roomId = $get('room_id');
                                        if ($roomId) {
                                            $room = \App\Models\Room::find($roomId);
                                            $days = $get('event_days') ?? 0;
                                            $hotelTotal = $room ? $room->pricePerNight * $days : 0;
                                            $set('totalPrix', $transportTotal + $hotelTotal);
                                        }
                                    }
                                }
                            })
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                if ($state) {
                                    $package = \App\Models\Package::with('transports', 'event')->find($state);
                                    if ($package) {
                                        $transportTotal = $package->transports->sum('price');
                                        $set('transport_total', $transportTotal);
                                        
                                        if ($package->event) {
                                            $start = Carbon::parse($package->event->start_date);
                                            $end = Carbon::parse($package->event->end_date);
                                            $days = $end->diffInDays($start) + 1; // number of days
                                            $set('event_days', $days);
                                        }
                                        
                                        // Update total if room is selected
                                        $roomId = $get('room_id');
                                        if ($roomId) {
                                            $room = \App\Models\Room::find($roomId);
                                            $days = $get('event_days') ?? 0;
                                            $hotelTotal = $room ? $room->pricePerNight * $days : 0;
                                            $set('totalPrix', $transportTotal + $hotelTotal);
                                        }
                                    }
                                } else {
                                    $set('transport_total', 0);
                                    $set('event_days', 0);
                                    $set('totalPrix', 0);
                                }
                            }),
                        
                        Forms\Components\Select::make('selected_hotel')
                            ->label('Select Hotel from Package')
                            ->options(function (callable $get) {
                                $packageId = $get('package_id');
                                $options = [];
                                if ($packageId) {
                                    $package = \App\Models\Package::with('hotels')->find($packageId);
                                    if ($package) {
                                        $options = $package->hotels->pluck('nom', 'id')->toArray();
                                    }
                                }
                                // If editing an existing reservation and its room's hotel isn't among the package hotels,
                                // include that hotel so the selection shows correctly.
                                $roomId = $get('room_id');
                                if ($roomId) {
                                    $room = \App\Models\Room::find($roomId);
                                    if ($room && !isset($options[$room->hotel_id])) {
                                        $options[$room->hotel_id] = $room->hotel->nom ?? 'Hotel ' . $room->hotel_id;
                                    }
                                }
                                return $options;
                            })
                            ->required()
                            ->placeholder('Select a package first')
                            ->reactive()
                            ->afterStateHydrated(function ($state, callable $set, callable $get) {
                                // On edit, if selected_hotel is empty but room_id is set, prefill selected_hotel
                                if (empty($state)) {
                                    $roomId = $get('room_id');
                                    if ($roomId) {
                                        $room = \App\Models\Room::find($roomId);
                                        if ($room) {
                                            $set('selected_hotel', $room->hotel_id);
                                        }
                                    }
                                }
                            })
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                // Reset room when hotel changes
                                $set('room_id', null);
                                $transportTotal = $get('transport_total') ?? 0;
                                $set('totalPrix', $transportTotal);
                            }),
                        
                        Forms\Components\Select::make('room_id')
                            ->label('Select Room')
                            ->options(function (callable $get) {
                                $hotelId = $get('selected_hotel');
                                if ($hotelId) {
                                    return \App\Models\Room::where('hotel_id', $hotelId)
                                        ->get()
                                        ->mapWithKeys(function ($room) {
                                            return [
                                                $room->id => sprintf(
                                                    '%s (Capacity: %d) - SAR %s/night',
                                                    $room->type,
                                                    $room->capacity,
                                                    number_format($room->pricePerNight, 2)
                                                )
                                            ];
                                        });
                                }
                                return [];
                            })
                            ->required()
                            ->placeholder('Select a hotel first')
                            ->reactive()
                            ->afterStateHydrated(function ($state, callable $set, callable $get) {
                                // On form load, if room_id is already set, ensure totals update
                                if ($state) {
                                    $room = \App\Models\Room::find($state);
                                    $days = $get('event_days') ?? 0;
                                    $hotelTotal = $room ? $room->pricePerNight * $days : 0;
                                    $transportTotal = $get('transport_total') ?? 0;
                                    $set('totalPrix', $transportTotal + $hotelTotal);
                                }
                            })
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                if ($state) {
                                    $room = \App\Models\Room::find($state);
                                    $days = $get('event_days') ?? 0;
                                    $hotelTotal = $room ? $room->pricePerNight * $days : 0;
                                    $transportTotal = $get('transport_total') ?? 0;
                                    $set('totalPrix', $transportTotal + $hotelTotal);
                                }
                            }),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Payment Details')
                    ->schema([
                        Forms\Components\TextInput::make('totalPrix')
                            ->label('Total Price (SAR)')
                            ->required()
                            ->numeric()
                            ->prefix('SAR')
                            ->default(0)
                            ->disabled()
                            ->dehydrated(true)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $paid = (float) ($get('montantPaye') ?? 0);
                                $balance = (float) $state - $paid;
                                $set('balance_display', number_format($balance, 2));
                            }),
                        
                        Forms\Components\TextInput::make('montantPaye')
                            ->label('Amount Paid (SAR)')
                            ->numeric()
                            ->prefix('SAR')
                            ->default(0)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $total = (float) ($get('totalPrix') ?? 0);
                                $paid = (float) ($state ?? 0);
                                $balance = $total - $paid;
                                $set('balance_display', number_format($balance, 2));
                            }),
                        
                        Forms\Components\Placeholder::make('balance_display')
                            ->label('Remaining Balance (SAR)')
                            ->content(function (callable $get) {
                                $total = (float) ($get('totalPrix') ?? 0);
                                $paid = (float) ($get('montantPaye') ?? 0);
                                $balance = $total - $paid;
                                return 'SAR ' . number_format($balance, 2);
                            }),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Booking Status')
                    ->schema([
                        Forms\Components\Toggle::make('selectionne')
                            ->label('Confirmed Booking')
                            ->helperText('Mark this reservation as confirmed')
                            ->default(false),
                    ])
                    ->columns(1),
            ]);
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->check() && in_array(auth()->user()->role, ['admin', 'agent']);
    }

    public static function table(Table $table): Table
    {
        $viewMode = session('reservation_view', 'table');

        $table = $table
            ->modifyQueryUsing(function ($query) {
                $query->with(['pilgrim', 'package', 'room.hotel']);
                $search = request('search', '');
                if ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->whereHas('pilgrim', function ($pq) use ($search) {
                            $pq->where('nomFrancais', 'like', '%' . $search . '%')
                               ->orWhere('nomArabe', 'like', '%' . $search . '%');
                        })->orWhereHas('room.hotel', function ($hq) use ($search) {
                            $hq->where('nom', 'like', '%' . $search . '%');
                        })->orWhereHas('package', function ($pq) use ($search) {
                            $pq->where('typePack', 'like', '%' . $search . '%');
                        });
                    });
                }
                return $query;
            })
            ->headerActions([
                Tables\Actions\Action::make('switch_view')
                    ->label($viewMode == 'table' ? 'Card View' : 'Table View')
                    ->action(function () use ($viewMode) {
                        session(['reservation_view' => $viewMode == 'table' ? 'cards' : 'table']);
                    })
                    ->icon($viewMode == 'table' ? 'heroicon-o-squares-2x2' : 'heroicon-o-table-cells')
                    ->color('gray'),
            ]);

        if ($viewMode == 'cards') {
            $table = $table
                ->contentGrid([
                    'default' => 1,
                    'sm' => 1,
                    'md' => 2,
                    'lg' => 3,
                    'xl' => 5,
                    '2xl' => 5,
                ])
                ->columns([
                    Tables\Columns\TextColumn::make('pilgrim.nomFrancais')
                        ->searchable()
                        ->hidden(),
                    Tables\Columns\TextColumn::make('card')
                        ->label('')
                        ->html()
                        ->state(function ($record) {
                            return view('filament.tables.reservation-card', compact('record'))->render();
                        }),
                ])
                ->actions([
                    Tables\Actions\Action::make('download_pdf')
                        ->label('Download PDF')
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('info')
                        ->action(function ($record) {
                            $pdf = app('dompdf.wrapper')->loadView('pdf.reservation', compact('record'));
                            return response()->streamDownload(function () use ($pdf) {
                                echo $pdf->output();
                            }, 'reservation-' . $record->id . '.pdf');
                        })
                        ->visible(fn ($record) => $record->selectionne),
                    Tables\Actions\Action::make('confirm')
                        ->label('Confirm Booking')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($record) {
                                $balance = ($record->totalPrix ?? 0) - ($record->montantPaye ?? 0);
                                if ($balance > 0) {
                                    Notification::make()
                                        ->danger()
                                        ->title('Payment not complete')
                                        ->body("Remaining balance: SAR " . number_format($balance, 2) . ". This pilgrim hasn't completed payment.")
                                        ->send();

                                    return; // Don't confirm if balance is not fully paid
                                }

                                $record->update(['selectionne' => true]);
                                \App\Models\Alert::create([
                                    'pilgrim_id' => $record->pilgrim_id,
                                    'type' => 'Booking Confirmed',
                                    'message' => 'Your Umrah booking has been confirmed.',
                                ]);
                                Notification::make()
                                    ->success()
                                    ->title('Booking confirmed')
                                    ->body('The reservation has been confirmed.')
                                    ->send();
                            })
                        ->visible(fn ($record) => !$record->selectionne)
                        ->requiresConfirmation()
                        ->modalHeading('Confirm Booking')
                        ->modalDescription('Are you sure you want to confirm this booking?')
                        ->modalSubmitActionLabel('Yes, Confirm'),
                    Tables\Actions\EditAction::make(),
                ]);
        } else {
            $table = $table
                ->columns([
                    Tables\Columns\TextColumn::make('pilgrim.nomFrancais')
                        ->label('Pilgrim')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('package.typePack')
                        ->label('Package')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('room.type')
                        ->label('Room Type')
                        ->formatStateUsing(function ($record) {
                            return sprintf(
                                '%s (%s)',
                                $record->room->type,
                                $record->room->hotel->nom ?? 'N/A'
                            );
                        }),
                    Tables\Columns\TextColumn::make('totalPrix')
                        ->label('Total Price')
                        ->money('SAR')
                        ->sortable(),
                    Tables\Columns\TextColumn::make('montantPaye')
                        ->label('Paid')
                        ->money('SAR')
                        ->sortable(),
                    Tables\Columns\TextColumn::make('balance')
                        ->label('Balance')
                        ->getStateUsing(function ($record) {
                            return $record->totalPrix - $record->montantPaye;
                        })
                        ->money('SAR')
                        ->color(fn ($state) => $state > 0 ? 'warning' : 'success'),
                    Tables\Columns\IconColumn::make('selectionne')
                        ->label('Confirmed')
                        ->boolean()
                        ->sortable(),
                ])
                ->actions([
                    Tables\Actions\Action::make('download_pdf')
                        ->label('Download PDF')
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('info')
                        ->action(function ($record) {
                            $pdf = app('dompdf.wrapper')->loadView('pdf.reservation', compact('record'));
                            return response()->streamDownload(function () use ($pdf) {
                                echo $pdf->output();
                            }, 'reservation-' . $record->id . '.pdf');
                        })
                        ->visible(fn ($record) => $record->selectionne),
                    Tables\Actions\Action::make('confirm')
                        ->label('Confirm Booking')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($record) {
                                $balance = ($record->totalPrix ?? 0) - ($record->montantPaye ?? 0);
                                if ($balance > 0) {
                                    Notification::make()
                                        ->danger()
                                        ->title('Payment not complete')
                                        ->body("Remaining balance: SAR " . number_format($balance, 2) . ". This pilgrim hasn't completed payment.")
                                        ->send();

                                    return; // Don't confirm if balance is not fully paid
                                }

                                $record->update(['selectionne' => true]);
                                \App\Models\Alert::create([
                                    'pilgrim_id' => $record->pilgrim_id,
                                    'type' => 'Booking Confirmed',
                                    'message' => 'Your Umrah booking has been confirmed.',
                                ]);
                                Notification::make()
                                    ->success()
                                    ->title('Booking confirmed')
                                    ->body('The reservation has been confirmed.')
                                    ->send();
                            })
                        ->visible(fn ($record) => !$record->selectionne)
                        ->requiresConfirmation()
                        ->modalHeading('Confirm Booking')
                        ->modalDescription('Are you sure you want to confirm this booking?')
                        ->modalSubmitActionLabel('Yes, Confirm'),
                    Tables\Actions\EditAction::make(),
                ]);
        }

        return $table
            ->filters([
                Tables\Filters\SelectFilter::make('selectionne')
                    ->label('Status')
                    ->options([
                        1 => 'Confirmed',
                        0 => 'Pending',
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }
}
