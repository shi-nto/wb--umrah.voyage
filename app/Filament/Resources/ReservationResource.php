<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Filament\Resources\ReservationResource\RelationManagers;
use App\Models\Reservation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationGroup = 'Bookings';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function canViewAny(): bool
    {
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
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nomFrancais')
                                    ->label('French Name')
                                    ->required(),
                                Forms\Components\TextInput::make('nomArabe')
                                    ->label('Arabic Last Name')
                                    ->required(),
                                Forms\Components\TextInput::make('prenomArabe')
                                    ->label('Arabic First Name')
                                    ->required(),
                                Forms\Components\DatePicker::make('dateNaissance')
                                    ->label('Date of Birth')
                                    ->required(),
                                Forms\Components\TextInput::make('ville')
                                    ->label('City')
                                    ->required(),
                                Forms\Components\TextInput::make('tel_1')
                                    ->label('Phone 1')
                                    ->required(),
                                Forms\Components\TextInput::make('tel_2')
                                    ->label('Phone 2 (Optional)'),
                            ]),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Package & Room Selection')
                    ->schema([
                        Forms\Components\Select::make('selected_event')
                            ->label('Select Event')
                            ->options(\App\Models\Event::pluck('code', 'id'))
                            ->reactive()
                            ->required()
                            ->placeholder('Choose an event first'),
                        
                        Forms\Components\Select::make('package_id')
                            ->label('Umrah Package')
                            ->options(function (callable $get) {
                                $eventId = $get('selected_event');
                                if ($eventId) {
                                    return \App\Models\Package::where('event_id', $eventId)->pluck('typePack', 'id');
                                }
                                return [];
                            })
                            ->required()
                            ->placeholder('Select an event first')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $package = \App\Models\Package::find($state);
                                    // You can auto-calculate price based on package here
                                }
                            }),
                        
                        Forms\Components\Select::make('selected_hotel')
                            ->label('Select Hotel')
                            ->options(\App\Models\Hotel::pluck('nom', 'id'))
                            ->reactive()
                            ->required()
                            ->placeholder('Choose a hotel first'),
                        
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
                            ->placeholder('Select a hotel first'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Payment Details')
                    ->schema([
                        Forms\Components\TextInput::make('totalPrix')
                            ->label('Total Price (SAR)')
                            ->required()
                            ->numeric()
                            ->prefix('SAR')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $paid = $get('montantPaye') ?? 0;
                                $balance = $state - $paid;
                                $set('balance_display', number_format($balance, 2));
                            }),
                        
                        Forms\Components\TextInput::make('montantPaye')
                            ->label('Amount Paid (SAR)')
                            ->numeric()
                            ->prefix('SAR')
                            ->default(0)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $total = $get('totalPrix') ?? 0;
                                $balance = $total - $state;
                                $set('balance_display', number_format($balance, 2));
                            }),
                        
                        Forms\Components\Placeholder::make('balance_display')
                            ->label('Remaining Balance (SAR)')
                            ->content(function (callable $get) {
                                $total = $get('totalPrix') ?? 0;
                                $paid = $get('montantPaye') ?? 0;
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

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with(['pilgrim', 'package', 'room.hotel']))
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
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
