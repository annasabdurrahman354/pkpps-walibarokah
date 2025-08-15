<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use App\Models\TagihanAdministrasi;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class ManageSiswaTagihanAdministrasi extends ManageRelatedRecords
{
    protected static string $resource = SiswaResource::class;

    protected static string $relationship = 'tagihanAdministrasi';

    protected static ?string $navigationIcon = 'fluentui-people-list-24';
    public function getTitle(): string | Htmlable
    {
        $recordTitle = $this->getRecordTitle();

        $recordTitle = $recordTitle instanceof Htmlable ? $recordTitle->toHtml() : $recordTitle;

        return "Kelola Tagihan {$recordTitle}";
    }

    public function getBreadcrumb(): string
    {
        return 'Kelola Tagihan';
    }

    public static function getNavigationLabel(): string
    {
        return 'Kelola Tagihan';
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->columns(1)
            ->schema([
                TextEntry::make('administrasi.jenisAdministrasi.nama'),
                TextEntry::make('siswa.nama'),
                TextEntry::make('siswa.kelas_sekolah'),
                TextEntry::make('siswa.rombel_kelas_sekolah'),
                TextEntry::make('nominal_tagihan')
                    ->money('IDR'),
                TextEntry::make('status_tagihan')
                    ->badge(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns(TagihanAdministrasi::getColumns())
            ->filters([
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->groupedBulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
