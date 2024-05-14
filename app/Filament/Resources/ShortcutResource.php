<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Shortcut;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\ShortcutResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ShortcutResource\RelationManagers;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;

class ShortcutResource extends Resource
{
    protected static ?string $model = Shortcut::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                TextColumn::make('nama')->sortable()->searchable()->label('Nama')->color('primary'),
                TextColumn::make('kanal')->sortable()->searchable()->label('Kanal')->color('primary'),
                TextColumn::make('deskripsi')->sortable()->searchable()->label('Deskripsi')->color('primary'),
                TextColumn::make('link')->sortable()->searchable()->label('Link')->color('primary')
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make()
                    ->form([
                        TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('kanal')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('deskripsi')
                            ->required()
                            ->maxLength(255),
                            MarkdownEditor::make('link'),
                    ]),
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
            'index' => Pages\ListShortcuts::route('/'),
            'create' => Pages\CreateShortcut::route('/create'),
            'edit' => Pages\EditShortcut::route('/{record}/edit'),
        ];
    }
}
