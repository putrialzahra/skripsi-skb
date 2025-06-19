<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CalonPesertaDidikResource\Pages;
use App\Models\CalonPesertaDidik;
use App\Models\User;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Illuminate\Support\Facades\Auth;





class CalonPesertaDidikResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = CalonPesertaDidik::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'accept_transfer',
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_lengkap')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('jenis_kelamin')
                    ->required(),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_lahir')
                    ->required(),
                Forms\Components\TextInput::make('agama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pekerjaan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kebangsaan')
                    ->required()
                    ->maxLength(255)
                    ->default('WNI'),
                Forms\Components\Textarea::make('alamat')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('no_hp')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('paket')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_lembaga')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat_lembaga')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_ayah')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pekerjaan_ayah')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_ibu')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pekerjaan_ibu')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_hp_ortu')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kk')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('akta')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('ijazah')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('foto')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Toggle::make('pernyataan')
                    ->required(),
                Forms\Components\TextInput::make('academic_year_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('user_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'terima' => 'Terima',
                        'tidak_terima' => 'Tidak Terima',
                    ])
                    ->required()
                    ->default('pending'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_hp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('paket')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'terima',
                        'danger' => 'tidak terima',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'pending',
                        'accepted' => 'terima',
                        'rejected' => 'tidak terima',
                    ]),

    
            ])->selectable()
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('acceptAndTransfer')
                    ->label('Terima & Transfer ke User')
                    ->icon('heroicon-s-user-plus')
                    ->action(function (CalonPesertaDidik $record) {
                        if ($record->status !== 'terima') {
                            // Create user account
                            $user = User::create([
                                'name' => $record->nama_lengkap,
                                'email' => $record->email,
                                'password' => bcrypt('password123'), // Default password
                                'phone' => $record->no_hp,
                            ]);
                            
                            // Assign student role using Shield
                            $user->assignRole('student');
                            
                            // Update status
                            $record->update(['status' => 'terima']);
                        }
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Terima Calon Peserta Didik')
                    ->modalSubheading('Apakah Anda yakin ingin menerima dan mentransfer calon peserta didik terpilih?')
                    ->modalButton('Ya, Terima & Transfer')
                    ->deselectRecordsAfterCompletion()            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('acceptAndTransfer')
                        ->label('Terima & Transfer ke User')
                        ->icon('heroicon-s-user-plus')
                        ->action(function (Collection $records) {
                            $records->each(function (CalonPesertaDidik $record) {
                                if ($record->status !== 'terima') {
                                    // Create user account
                                    $user = User::create([
                                        'name' => $record->nama_lengkap,
                                        'email' => $record->email,
                                        'password' => bcrypt('password123'), // Default password
                                        'phone' => $record->no_hp,
                                    ]);
                                    
                                    // Assign student role using Shield
                                    $user->assignRole('student');
                                    
                                    // Update status
                                    $record->update(['status' => 'terima']);
                                }
                            });
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Terima Calon Peserta Didik')
                        ->modalSubheading('Apakah Anda yakin ingin menerima dan mentransfer calon peserta didik terpilih?')
                        ->modalButton('Ya, Terima & Transfer')
                        ->deselectRecordsAfterCompletion()
                        
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
            'index' => Pages\ListCalonPesertaDidiks::route('/'),
            'create' => Pages\CreateCalonPesertaDidik::route('/create'),
            'edit' => Pages\EditCalonPesertaDidik::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
{
    return Auth::user()->hasRole('super_admin');
}
}