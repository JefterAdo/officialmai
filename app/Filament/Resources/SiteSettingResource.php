<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    
    protected static ?string $navigationGroup = 'Administration';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'text' => 'Text',
                        'textarea' => 'Textarea',
                        'image' => 'Image',
                        'boolean' => 'Boolean',
                        'json' => 'JSON',
                    ])
                    ->default('text'),
                Forms\Components\Select::make('group')
                    ->required()
                    ->options([
                        'general' => 'General',
                        'contact' => 'Contact',
                        'social' => 'Social Media',
                        'seo' => 'SEO',
                        'analytics' => 'Analytics',
                    ])
                    ->default('general'),
                Forms\Components\Textarea::make('description')
                    ->maxLength(255),
                Forms\Components\KeyValue::make('value')
                    ->keyLabel('Clé')
                    ->valueLabel('Valeur')
                    ->reorderable()
                    ->columnSpanFull()
                    ->visible(fn (Forms\Get $get) => $get('type') === 'json'),
                Forms\Components\Textarea::make('value')
                    ->columnSpanFull()
                    ->visible(fn (Forms\Get $get) => $get('type') === 'textarea'),
                Forms\Components\TextInput::make('value')
                    ->columnSpanFull()
                    ->visible(fn (Forms\Get $get) => $get('type') === 'text'),
                Forms\Components\FileUpload::make('value')
                    ->image()
                    ->columnSpanFull()
                    ->visible(fn (Forms\Get $get) => $get('type') === 'image'),
                Forms\Components\Toggle::make('value')
                    ->columnSpanFull()
                    ->visible(fn (Forms\Get $get) => $get('type') === 'boolean'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('group')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'text' => 'Text',
                        'textarea' => 'Textarea',
                        'image' => 'Image',
                        'boolean' => 'Boolean',
                        'json' => 'JSON',
                    ]),
                Tables\Filters\SelectFilter::make('group')
                    ->options([
                        'general' => 'General',
                        'contact' => 'Contact',
                        'social' => 'Social Media',
                        'seo' => 'SEO',
                        'analytics' => 'Analytics',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
} 