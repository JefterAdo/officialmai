<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FlashInfoResource\Pages;
use App\Filament\Resources\FlashInfoResource\RelationManagers;
use App\Models\FlashInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FlashInfoResource extends Resource
{
    protected static ?string $model = FlashInfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationGroup = 'Site Web';

    protected static ?string $navigationLabel = 'Flash Infos';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('message')
                            ->required()
                            ->maxLength(255)
                            ->label('Message du flash info'),
                        
                        Forms\Components\Toggle::make('is_active')
                            ->label('Actif')
                            ->default(true),
                        
                        Forms\Components\DateTimePicker::make('start_date')
                            ->label('Date de début')
                            ->nullable(),
                        
                        Forms\Components\DateTimePicker::make('end_date')
                            ->label('Date de fin')
                            ->nullable()
                            ->afterOrEqual('start_date'),
                        
                        Forms\Components\Select::make('display_mode')
                            ->options(FlashInfo::DISPLAY_MODES)
                            ->default('static')
                            ->required()
                            ->helperText('Choisissez le mode d\'affichage du flash info'),
                        
                        Forms\Components\TextInput::make('display_order')
                            ->label('Ordre d\'affichage')
                            ->integer()
                            ->default(0)
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('message')
                    ->label('Message')
                    ->searchable()
                    ->limit(50),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Date de début')
                    ->dateTime()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Date de fin')
                    ->dateTime()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('display_mode')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'static' => 'gray',
                        'scroll' => 'success',
                        'fade' => 'warning',
                        default => 'gray',
                    }),
                
                Tables\Columns\TextColumn::make('display_order')
                    ->label('Ordre')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Dernière modification')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('display_order')
            ->filters([
                Tables\Filters\Filter::make('active')
                    ->label('Actifs uniquement')
                    ->query(fn (Builder $query): Builder => $query->active()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListFlashInfos::route('/'),
            'create' => Pages\CreateFlashInfo::route('/create'),
            'edit' => Pages\EditFlashInfo::route('/{record}/edit'),
        ];
    }
}
