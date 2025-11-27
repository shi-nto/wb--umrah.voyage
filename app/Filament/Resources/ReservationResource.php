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

    protected static ?string $navigationGroup = 'Travel';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('pilgrim_id')
                    ->relationship('pilgrim', 'nomFrancais')
                    ->required(),
                Forms\Components\Select::make('package_id')
                    ->relationship('package', 'typePack')
                    ->required(),
                Forms\Components\Select::make('room_id')
                    ->relationship('room', 'type')
                    ->required(),
                Forms\Components\TextInput::make('totalPrix')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('montantPaye')
                    ->numeric(),
                Forms\Components\Toggle::make('selectionne'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pilgrim.nomFrancais'),
                Tables\Columns\TextColumn::make('package.typePack'),
                Tables\Columns\TextColumn::make('room.type'),
                Tables\Columns\TextColumn::make('totalPrix'),
                Tables\Columns\TextColumn::make('montantPaye'),
                Tables\Columns\BooleanColumn::make('selectionne'),
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
