<?php

namespace App\Filament\Resources\GameScores;

use App\Filament\Resources\GameScores\Pages\ManageGameScores;
use App\Models\GameScore;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class GameScoreResource extends Resource
{
    protected static ?string $model = GameScore::class;

    protected static ?string $modelLabel = 'Leaderboard Game';

    protected static ?string $pluralModelLabel = 'Leaderboard Game';

    protected static ?string $navigationLabel = 'Leaderboard';

    protected static string|UnitEnum|null $navigationGroup = 'School Fair';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $recordTitleAttribute = 'player_name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('player_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('score')
                    ->numeric()
                    ->required(),
                TextInput::make('game_type')
                    ->required(),
                TextInput::make('school_year'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('player_name')
            ->columns([
                TextColumn::make('player_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('score')
                    ->sortable(),
                TextColumn::make('game_type')
                    ->badge()
                    ->color('info'),
                TextColumn::make('school_year'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('score', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageGameScores::route('/'),
        ];
    }
}
