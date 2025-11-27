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

    protected static ?string $navigationGroup = 'Travel';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('typePack')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('typePelerin')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('programme')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('agent_id')
                    ->relationship('agent', 'nom')
                    ->default(function () {
                        $user = auth()->user();
                        if ($user && $user->role === 'agent') {
                            $agent = \App\Models\Agent::where('nom', $user->name)->first();
                            return $agent ? $agent->id : null;
                        }
                        return null;
                    })
                    ->visible(fn () => auth()->user()->role !== 'agent')
                    ->required(fn () => auth()->user()->role === 'admin'),
                Forms\Components\Select::make('event_id')
                    ->relationship('event', 'code')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('typePack'),
                Tables\Columns\TextColumn::make('typePelerin'),
                Tables\Columns\TextColumn::make('programme'),
                Tables\Columns\TextColumn::make('agent.nom'),
                Tables\Columns\TextColumn::make('event.code'),
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
