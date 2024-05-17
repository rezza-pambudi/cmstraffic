<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Document;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\DocumentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DocumentResource\RelationManagers;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static ?string $navigationGroup = 'Operations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')->unique(ignorable: fn ($record) => $record)->hidden()->afterStateUpdated(function (?string $state, ?string $old) {
                    $state()->update();
                }),
                TextInput::make('nama')->required(),
                Select::make('kanal')->searchable()->options([
                    'Detikcom' => 'Detikcom',
                    'CNN Indonesia' => 'CNN Indonesia',
                    'CNBC Indonesia' => 'CNBC Indonesia',
                    'Haibunda & Insertlive' => 'Haibunda & Insertlive',
                    'All Kanal' => 'All Kanal',
                ])->preload(),
                Select::make('web')->searchable()->options([
                    'Detikcom' => 'Detikcom',
                    'CNN Indonesia' => 'CNN Indonesia',
                    'CNBC Indonesia' => 'CNBC Indonesia',
                    'Haibunda & Insertlive' => 'Haibunda & Insertlive',
                    'All Kanal' => 'All Kanal',
                ])->preload(),
                MarkdownEditor::make('deskripsi')->required()->columnSpanFull()->label('Deskripsi'),
                MarkdownEditor::make('link')->required()->columnSpanFull()->label('Link')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'view' => Pages\ViewDocument::route('/{record}'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
