<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PassportInfoResource\Pages;
use App\Filament\Resources\PassportInfoResource\RelationManagers;
use App\Models\PassportInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PassportInfoResource extends Resource
{
    protected static ?string $model = PassportInfo::class;

    protected static ?string $navigationGroup = 'Pilgrims';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('pilgrim_id')
                    ->relationship('pilgrim', 'nomFrancais')
                    ->required(),
                Forms\Components\TextInput::make('numeroPasseport')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('dateDelivrance')
                    ->required(),
                Forms\Components\DatePicker::make('dateExpiration')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pilgrim.nomFrancais'),
                Tables\Columns\TextColumn::make('numeroPasseport'),
                Tables\Columns\TextColumn::make('dateDelivrance'),
                Tables\Columns\TextColumn::make('dateExpiration'),
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
            'index' => Pages\ListPassportInfos::route('/'),
            'create' => Pages\CreatePassportInfo::route('/create'),
            'edit' => Pages\EditPassportInfo::route('/{record}/edit'),
        ];
    }
}
