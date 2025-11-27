<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PilgrimResource\Pages;
use App\Filament\Resources\PilgrimResource\RelationManagers;
use App\Models\Pilgrim;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PilgrimResource extends Resource
{
    protected static ?string $model = Pilgrim::class;

    protected static ?string $navigationGroup = 'Pilgrims';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nomFrancais')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomArabe')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('prenomArabe')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('dateNaissance')
                    ->required(),
                Forms\Components\TextInput::make('ville')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tel_1')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tel_2')
                    ->maxLength(255),
                Forms\Components\TextInput::make('typeDiabete')
                    ->maxLength(255),
                Forms\Components\Textarea::make('commentaire'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomFrancais'),
                Tables\Columns\TextColumn::make('nomArabe'),
                Tables\Columns\TextColumn::make('prenomArabe'),
                Tables\Columns\TextColumn::make('dateNaissance'),
                Tables\Columns\TextColumn::make('ville'),
                Tables\Columns\TextColumn::make('tel_1'),
                Tables\Columns\TextColumn::make('tel_2'),
                Tables\Columns\TextColumn::make('typeDiabete'),
                Tables\Columns\TextColumn::make('commentaire'),
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
            'index' => Pages\ListPilgrims::route('/'),
            'create' => Pages\CreatePilgrim::route('/create'),
            'edit' => Pages\EditPilgrim::route('/{record}/edit'),
        ];
    }
}
