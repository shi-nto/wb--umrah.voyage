<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HotelResource\Pages;
use App\Filament\Resources\HotelResource\RelationManagers;
use App\Models\Hotel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class HotelResource extends Resource
{
    protected static ?string $model = Hotel::class;

    protected static ?string $navigationGroup = 'Travel';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nom')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ville')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('distanceMasjid')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom'),
                Tables\Columns\TextColumn::make('ville'),
                Tables\Columns\TextColumn::make('distanceMasjid'),
                Tables\Columns\TextColumn::make('rooms_count')
                    ->label('Rooms')
                    ->counts('rooms'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('view_rooms')
                    ->label('View Rooms')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => route('filament.admin.resources.hotels.view', $record))
                    ->openUrlInNewTab(false),
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
            RelationManagers\RoomsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHotels::route('/'),
            'create' => Pages\CreateHotel::route('/create'),
            'view' => Pages\ViewHotel::route('/{record}'),
            'edit' => Pages\EditHotel::route('/{record}/edit'),
        ];
    }
}
