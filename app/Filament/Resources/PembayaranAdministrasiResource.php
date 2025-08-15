<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembayaranAdministrasiResource\Pages;
use App\Filament\Resources\PembayaranAdministrasiResource\RelationManagers;
use App\Models\PembayaranAdministrasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PembayaranAdministrasiResource extends Resource
{
    protected static ?string $model = PembayaranAdministrasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(PembayaranAdministrasi::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(PembayaranAdministrasi::getColumns())
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
            'index' => Pages\ListPembayaranAdministrasis::route('/'),
            'create' => Pages\CreatePembayaranAdministrasi::route('/create'),
            'view' => Pages\ViewPembayaranAdministrasi::route('/{record}'),
            'edit' => Pages\EditPembayaranAdministrasi::route('/{record}/edit'),
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
