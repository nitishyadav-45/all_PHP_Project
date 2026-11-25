<?php

namespace App\Livewire;

use App\Models\Deposit;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;


class listDeposits extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Deposit::query()->where('user_id', Auth::user()->id))
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Nouveau dépot')
                    ->url(route('deposits.create')),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('#')
                    ->sortable()
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('adress')
                    ->label('Adresse')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->label('Province')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('area')
                    ->label('Surface')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('image'),
                Tables\Columns\TextColumn::make('maxCapacity')
                    ->label('Capacité maximale')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Propriétaire')
                    ->numeric()
                    ->sortable(),
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
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->label('Voir')
                        ->url(fn ($record): string => route('deposits.show', $record)),
                    Tables\Actions\EditAction::make()
                        ->label('Modifier')
                        ->url(fn ($record): string => route('deposits.edit', $record)),
                    Tables\Actions\DeleteAction::make()
                        ->label('Supprimer')
                        ->requiresConfirmation()
                        ->url(fn ($record): string => route('deposits.edit', $record)),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    /* public function render(): View
    {
        return view('deposit.index');
    } */
}
