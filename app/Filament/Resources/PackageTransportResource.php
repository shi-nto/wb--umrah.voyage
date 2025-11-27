<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageTransportResource\Pages;
use App\Filament\Resources\PackageTransportResource\RelationManagers;
use App\Models\PackageTransport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PackageTransportResource extends Resource
{
    protected static ?string $model = PackageTransport::class;

    protected static ?string $navigationGroup = 'Travel';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('package_id')
                    ->label('Package')
                    ->relationship('package', 'typePack')
                    ->required(),
                Forms\Components\Select::make('transport_id')
                    ->label('Transport')
                    ->relationship('transport', 'type')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('package.typePack')
                    ->label('Package'),
                Tables\Columns\TextColumn::make('transport.type')
                    ->label('Transport Type'),
                Tables\Columns\TextColumn::make('transport.provider')
                    ->label('Provider'),
                Tables\Columns\TextColumn::make('transport.departCity')
                    ->label('From'),
                Tables\Columns\TextColumn::make('transport.arriveCity')
                    ->label('To'),
                Tables\Columns\TextColumn::make('transport.departDate')
                    ->label('Depart Date'),
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
            'index' => Pages\ListPackageTransports::route('/'),
            'create' => Pages\CreatePackageTransport::route('/create'),
            'edit' => Pages\EditPackageTransport::route('/{record}/edit'),
        ];
    }
}
