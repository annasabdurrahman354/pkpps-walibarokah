<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagihanAdministrasiResource\Pages;
use App\Filament\Resources\TagihanAdministrasiResource\RelationManagers;
use App\Models\TagihanAdministrasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TagihanAdministrasiResource extends Resource
{
    protected static ?string $model = TagihanAdministrasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(TagihanAdministrasi::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(TagihanAdministrasi::getColumns())
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListTagihanAdministrasis::route('/'),
            'create' => Pages\CreateTagihanAdministrasi::route('/create'),
            'view' => Pages\ViewTagihanAdministrasi::route('/{record}'),
            'edit' => Pages\EditTagihanAdministrasi::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
