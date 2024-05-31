<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VacancyResource\Pages;
use App\Filament\Resources\VacancyResource\RelationManagers;
use App\Models\Occupation;
use App\Models\Skyll;
use App\Models\Vacancy;
use Closure;
use Doctrine\DBAL\Schema\Column;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action as ActionsAction;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Actions\Action;
use Filament\Support\RawJs;

class VacancyResource extends Resource
{
    protected static ?string $model = Vacancy::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __('Vacancie');
    }

    public static function form(Form $form): Form
    {
        return $form

            ->columns(1)
            ->schema([

                Wizard::make([
                    Wizard\Step::make('Pesquisar Vaga')
                        ->schema([
                            Forms\Components\Select::make('occupation_id')
                                ->searchable()
                                ->live()
                                ->required()
                                ->afterStateUpdated(fn (Set $set) => $set('skyll_id', null))
                                ->preload(true)
                                ->getSearchResultsUsing(fn (string $search): array => Occupation::getOccupationCustom($search))
                                ->getOptionLabelUsing(fn ($value): ?string => Occupation::find($value)?->name),
                        ])->columns(1),

                    Wizard\Step::make('Dados da Vaga')
                        ->schema([
                            Forms\Components\Select::make('work_regime_id')
                                ->options([
                                    1 => "CLT",
                                    2 => "PJ",
                                ])
                                ->required()
                                ->default(null),
                            Forms\Components\Select::make('work_model_id')
                                ->options([
                                    1 => "Presencial",
                                    2 => "Remoto",
                                    3 => "Híbrido",
                                ])
                                ->required()
                                ->default(null),
                            Forms\Components\Select::make('work_start_time')
                                ->options([
                                    '09:00',
                                    '09:30',
                                    '10:00',
                                    '10:30',
                                    '11:00',
                                    '11:30',
                                    '12:00',
                                ]),
                            Forms\Components\Select::make('work_end_time')
                                ->options([
                                    '13:00',
                                    '13:30',
                                    '14:00',
                                    '14:30',
                                    '15:00',
                                    '15:30',
                                    '16:00',
                                    '16:30',
                                    '17:00',
                                    '17:30',
                                    '18:00',
                                ]),
                            Forms\Components\TextInput::make('salary')
                                ->numeric()
                                ->required()
                                ->maxLength(9)
                                ->default(null),
                            Forms\Components\Toggle::make('has_benefits')
                                ->required(),
                            Forms\Components\Textarea::make('extra_information')
                                ->columnSpanFull(),
                        ])->columns(2),

                    Wizard\Step::make('Preferências')
                        ->schema([

                            Forms\Components\TextInput::make('min_age')
                                ->numeric()
                                ->required()
                                ->default(null),
                            Forms\Components\TextInput::make('max_age')
                                ->numeric()
                                ->required()
                                ->default(null),
                            Forms\Components\Select::make('education_id')
                                ->options([
                                    1 => "Ensino Fundamental Incompleto",
                                    2 => "Ensino Fundamental Completo",
                                    3 => "Ensino Médio Incompleto",
                                    4 => "Ensino Médio Completo",
                                    5 => "Ensino Técnico",
                                    6 => "Ensino Superior Incompleto",
                                    7 => "Ensino Superior Completo",
                                    8 => "Pós-graduação Incompleta",
                                    9 => "Pós-graduação Completa",
                                    10 => "Mestrado Incompleto",
                                    11 => "Mestrado Completo",
                                    12 => "Doutorado Incompleto",
                                    13 => "Doutorado Completo"
                                ])
                                ->required()
                                ->default(null),
                            Forms\Components\Select::make('ethnicity_id')
                                ->options([
                                    1 => "Branco",
                                    2 => "Negro",
                                    3 => "Pardo",
                                    4 => "Amarelo",
                                    5 => "Indígena",
                                    6 => "Outro",
                                    7 => "Prefiro não responder"
                                ])
                                ->required()
                                ->default(null),
                            Forms\Components\Toggle::make('has_experience')
                                ->required(),
                            Forms\Components\Radio::make('experience_id')
                                ->options([
                                    '1' => 'Pouco',
                                    '2' => 'Médio',
                                    '3' => 'Muito',
                                ])
                                ->requiredWith('has_experience')
                                ->visible(fn ($get) => $get('has_experience')),
                            Forms\Components\Toggle::make('has_disability')
                                ->required(),
                            Forms\Components\Toggle::make('has_travel')
                                ->required(),
                            Forms\Components\Toggle::make('has_language')
                                ->required(),
                            Forms\Components\Select::make('language_id')
                                ->options([
                                    '1' => 'Português',
                                    '2' => 'Inglês',
                                    '3' => 'Espanhol',
                                    '4' => 'Francês',
                                    '5' => 'Alemão',
                                    '6' => 'Italiano',
                                    '7' => 'Mandarim',
                                    '8' => 'Japonês',
                                    '9' => 'Coreano',
                                    '10' => 'Russo'
                                ])
                                ->multiple()
                                ->searchable()
                                ->requiredWith('has_language')
                                ->visible(fn ($get) => $get('has_language')),
                            Forms\Components\Select::make('skylls')
                                ->relationship('skylls', 'description')
                                ->options(fn (Get $get): Collection => Skyll::query()
                                    ->where('occupation_id', $get('occupation_id'))
                                    ->pluck('description', 'id'))
                                ->searchable()
                                ->required()
                                ->live()
                                ->multiple()
                                ->preload(true),

                        ])->columns(2),

                    Wizard\Step::make('Empregador')
                        ->schema([
                            Forms\Components\TextInput::make('company')
                                ->maxLength(255)
                                ->required()
                                ->default(null),
                            Forms\Components\TextInput::make('responsible_person')
                                ->maxLength(255)
                                ->required()
                                ->default(null),
                            Forms\Components\Textarea::make('about')
                                ->columnSpanFull(),
                            Forms\Components\TextInput::make('postal_code')
                                ->maxLength(8)
                                ->mask('99999999')
                                ->required()
                                ->suffixAction(
                                    Action::make('resetStars')
                                        ->icon('heroicon-o-magnifying-glass')
                                        ->action(function ($get, $set) {
                                            //$set('address', $get('postal_code'));
                                            $cepData = Http::get("https://viacep.com.br/ws/{$get('postal_code')}/json/")
                                                ->throw()
                                                ->json();
                                            $set('address', $cepData['logradouro']);
                                            $set('neighborhood', $cepData['bairro']);
                                            $set('city', $cepData['localidade']);
                                            $set('state', $cepData['uf']);
                                        })
                                )
                                ->default(null),
                            Forms\Components\TextInput::make('address')
                                ->maxLength(255)
                                ->required()
                                ->default(null),
                            Forms\Components\TextInput::make('number')
                                ->maxLength(255)
                                ->required()
                                ->default(null),
                            Forms\Components\TextInput::make('complement')
                                ->maxLength(255)
                                ->default(null),
                            Forms\Components\TextInput::make('neighborhood')
                                ->maxLength(255)
                                ->required()
                                ->default(null),
                            Forms\Components\TextInput::make('city')
                                ->maxLength(255)
                                ->required()
                                ->default(null),
                            Forms\Components\TextInput::make('state')
                                ->maxLength(255)
                                ->required()
                                ->default(null),
                        ])->columns(3),
                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('occupation.name')
                    ->numeric()
                    ->translateLabel()
                    ->sortable(),
                Tables\Columns\TextColumn::make('work_regime_id')
                    ->numeric()
                    ->translateLabel()
                    ->sortable(),
                Tables\Columns\TextColumn::make('work_model_id')
                    ->numeric()
                    ->translateLabel()
                    ->sortable(),
                Tables\Columns\TextColumn::make('work_start_time')
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('work_end_time')
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('salary')
                    ->numeric()
                    ->translateLabel()
                    ->sortable(),
                Tables\Columns\IconColumn::make('has_benefits')
                    ->translateLabel()
                    ->boolean(),
                Tables\Columns\TextColumn::make('min_age')
                    ->numeric()
                    ->translateLabel()
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_age')
                    ->numeric()
                    ->translateLabel()
                    ->sortable(),
                Tables\Columns\TextColumn::make('education_id')
                    ->numeric()
                    ->translateLabel()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ethnicity_id')
                    ->numeric()
                    ->translateLabel()
                    ->sortable(),
                Tables\Columns\IconColumn::make('has_experience')
                    ->translateLabel()
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_disability')
                    ->translateLabel()
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_travel')
                    ->translateLabel()
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_language')
                    ->translateLabel()
                    ->boolean(),
                Tables\Columns\TextColumn::make('company')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('responsible_person')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('postal_code')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('number')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('complement')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('neighborhood')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('state')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListVacancies::route('/'),
            'create' => Pages\CreateVacancy::route('/create'),
            'edit' => Pages\EditVacancy::route('/{record}/edit'),
        ];
    }
}
