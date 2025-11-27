<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RelationshipResource\Pages;
use App\Filament\Resources\RelationshipResource\RelationManagers;
use App\Models\Relationship;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RelationshipResource extends Resource
{
    protected static ?string $model = Relationship::class;

    protected static ?string $navigationGroup = 'Pilgrims';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('pilgrim_a_id')
                    ->relationship('pilgrimA', 'nomFrancais')
                    ->required(),
                Forms\Components\Select::make('pilgrim_b_id')
                    ->relationship('pilgrimB', 'nomFrancais')
                    ->required(),
                Forms\Components\TextInput::make('relationType')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pilgrimA.nomFrancais'),
                Tables\Columns\TextColumn::make('pilgrimB.nomFrancais'),
                Tables\Columns\TextColumn::make('relationType'),
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
            'index' => Pages\ListRelationships::route('/'),
            'create' => Pages\CreateRelationship::route('/create'),
            'edit' => Pages\EditRelationship::route('/{record}/edit'),
        ];
    }
}
