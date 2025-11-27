<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransportResource\Pages;
use App\Filament\Resources\TransportResource\RelationManagers;
use App\Models\Transport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransportResource extends Resource
{
    protected static ?string $model = Transport::class;

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
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('provider')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('departCity')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('arriveCity')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('departDate')
                    ->required(),
                Forms\Components\DatePicker::make('arriveDate')
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('reference')
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->label('Price (SAR)')
                    ->numeric()
                    ->prefix('SAR')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('provider'),
                Tables\Columns\TextColumn::make('departCity'),
                Tables\Columns\TextColumn::make('arriveCity'),
                Tables\Columns\TextColumn::make('departDate'),
                Tables\Columns\TextColumn::make('arriveDate'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('reference'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('SAR'),
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
            'index' => Pages\ListTransports::route('/'),
            'create' => Pages\CreateTransport::route('/create'),
            'edit' => Pages\EditTransport::route('/{record}/edit'),
        ];
    }
}
