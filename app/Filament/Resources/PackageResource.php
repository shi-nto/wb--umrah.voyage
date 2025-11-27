<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages;
use App\Filament\Resources\PackageResource\RelationManagers;
use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationGroup = 'Bookings';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function canViewAny(): bool
    {
        return auth()->check() && in_array(auth()->user()->role, ['admin', 'agent']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('typePack')
                    ->label('Package Type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('category')
                    ->label('Category')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('programme')
                    ->label('Program Description')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('event_id')
                    ->label('Event')
                    ->relationship('event', 'code')
                    ->required(),
                Forms\Components\Select::make('transports')
                    ->label('Transports')
                    ->relationship('transports', 'type')
                    ->multiple()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->type} - {$record->provider} - {$record->departCity} to {$record->arriveCity} - {$record->reference}"),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('typePack')
                    ->label('Package Type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Category'),
                Tables\Columns\TextColumn::make('programme')
                    ->label('Program')
                    ->limit(50),
                Tables\Columns\TextColumn::make('event.code')
                    ->label('Event Code')
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
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}
