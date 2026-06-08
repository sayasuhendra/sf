<?php

namespace App\Filament\Resources\FrontendTexts;

use App\Filament\Resources\FrontendTexts\Pages\CreateFrontendText;
use App\Filament\Resources\FrontendTexts\Pages\EditFrontendText;
use App\Filament\Resources\FrontendTexts\Pages\ListFrontendTexts;
use App\Filament\Resources\FrontendTexts\Schemas\FrontendTextForm;
use App\Filament\Resources\FrontendTexts\Tables\FrontendTextsTable;
use App\Models\FrontendText;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class FrontendTextResource extends Resource
{
    protected static ?string $model = FrontendText::class;

    protected static ?string $navigationLabel = 'Teks Website';

    protected static ?string $pluralModelLabel = 'Teks Website';

    protected static ?string $modelLabel = 'Teks Website';

    protected static string|UnitEnum|null $navigationGroup = 'School Fair';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPencilSquare;

    public static function form(Schema $schema): Schema
    {
        return FrontendTextForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FrontendTextsTable::configure($table);
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
            'index' => ListFrontendTexts::route('/'),
            'create' => CreateFrontendText::route('/create'),
            'edit' => EditFrontendText::route('/{record}/edit'),
        ];
    }
}
