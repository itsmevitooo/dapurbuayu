<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker; 
use Filament\Forms\Components\Repeater;   
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload; 
use Filament\Forms\Components\RichEditor;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema; 
use Filament\Schemas\Components\Section;
use BackedEnum;
use Illuminate\Support\Facades\Storage;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string | null $title = 'Pengaturan Operasional';
    protected static string | null $navigationLabel = 'Pengaturan';
    protected static string | null $slug = 'pengaturan-operasional';

    public static function getNavigationGroup(): ?string
    {
        return 'Pengaturan';
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
    }

    protected string $view = 'filament.pages.manage-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $settingsPath = storage_path('app/settings.json');
        
        if (!file_exists($settingsPath)) {
            file_put_contents($settingsPath, json_encode([]));
        }

        $settingsData = json_decode(file_get_contents($settingsPath), true) ?? [];

        $holidaysPath = storage_path('app/holidays.json');
        $holidaysData = file_exists($holidaysPath) ? json_decode(file_get_contents($holidaysPath), true) : [];

        $datesForRepeater = [];
        if (is_array($holidaysData)) {
            foreach ($holidaysData as $date) {
                $datesForRepeater[] = ['date' => $date];
            }
        }

        $this->form->fill([
            'banner_image'          => $settingsData['banner_image'] ?? '',
            'banner_title'          => $settingsData['banner_title'] ?? 'Selamat Datang',
            'banner_subtitle'       => $settingsData['banner_subtitle'] ?? 'Pesan katering terbaik untuk acara Anda.',
            'whatsapp_number'       => $settingsData['whatsapp_number'] ?? '',
            'instagram_url'         => $settingsData['instagram_url'] ?? '',
            'facebook_url'          => $settingsData['facebook_url'] ?? '',
            'google_maps_url'       => $settingsData['google_maps_url'] ?? '',
            'google_maps_embed_url' => $settingsData['google_maps_embed_url'] ?? '',
            'alamat_toko'           => $settingsData['alamat_toko'] ?? '',
            'terms_content'         => $settingsData['terms_content'] ?? '',
            'privacy_content'       => $settingsData['privacy_content'] ?? '',
            'dates'                 => $datesForRepeater,
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->components([
                Section::make('Pengaturan Banner Utama (Hero Section)')
                    ->description('Sesuaikan tampilan banner promosi terdepan pada halaman beranda.')
                    ->schema([
                        FileUpload::make('banner_image')
                            ->label('Gambar Background Banner')
                            ->image()
                            ->directory('banners')
                            ->disk('public')
                            ->visibility('public')
                            ->columnSpan('full')
                            ->required(),
                        TextInput::make('banner_title')
                            ->label('Judul Utama Banner (Font Estetik)')
                            ->placeholder('Contoh: Selamat Datang')
                            ->required(),
                        TextInput::make('banner_subtitle')
                            ->label('Sub-Judul Banner')
                            ->placeholder('Contoh: Pesan katering terbaik untuk acara Anda.')
                            ->required(),
                    ])->columns(2),

                Section::make('Informasi Kontak & Sosial Media')
                    ->description('Atur kontak operasional Dapur Bu Ayu yang akan muncul di halaman depan.')
                    ->schema([
                        TextInput::make('whatsapp_number')
                            ->label('Nomor WhatsApp')
                            ->placeholder('Contoh: 6285711398972')
                            ->required(),
                        TextInput::make('instagram_url')
                            ->label('Link Instagram')
                            ->placeholder('Contoh: https://instagram.com/dapurbuayu')
                            ->required(),
                        TextInput::make('facebook_url')
                            ->label('Link Facebook')
                            ->placeholder('Contoh: https://facebook.com/dapurbuayu')
                            ->required(),
                        
                        Textarea::make('google_maps_url')
                            ->label('Link Direct Google Maps')
                            ->placeholder('Masukkan link share dari Google Maps')
                            ->rows(2)
                            ->columnSpan('full')
                            ->required(),
                        Textarea::make('google_maps_embed_url')
                            ->label('Link Embed Google Maps')
                            ->placeholder('Masukkan kode link/iframe dari Google Maps')
                            ->rows(2)
                            ->columnSpan('full')
                            ->required(),
                        Textarea::make('alamat_toko')
                            ->label('Alamat Fisik Toko')
                            ->placeholder('Masukkan alamat lengkap toko...')
                            ->rows(2)
                            ->columnSpan('full')
                            ->required(),
                    ])->columns(2),

                Section::make('Konten Legal (Footer)')
                    ->description('Atur isi Syarat & Ketentuan serta Kebijakan Privasi.')
                    ->schema([
                        RichEditor::make('terms_content')
                            ->label('Syarat & Ketentuan')
                            ->columnSpanFull()
                            ->required(),
                        RichEditor::make('privacy_content')
                            ->label('Kebijakan Privasi')
                            ->columnSpanFull()
                            ->required(),
                    ]),

                Section::make('Manajemen Tanggal Libur / Tutup Slot')
                    ->description('Gunakan tombol tambah untuk memunculkan kalender pilihan tanggal libur baru.')
                    ->schema([
                        Repeater::make('dates')
                            ->label('Daftar Tanggal Libur')
                            ->schema([
                                DatePicker::make('date')
                                    ->label('Pilih Tanggal')
                                    ->displayFormat('Y-m-d'), // Hapus required agar opsional
                            ])
                            ->addActionLabel('Tambah Tanggal Libur Baru')
                            ->columns(1)
                            ->grid(3)
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Perubahan')
                ->color('primary')
                ->action('submit'),
        ];
    }

    public function submit(): void
    {
        $formData = $this->form->getState();
        $oldSettings = json_decode(file_get_contents(storage_path('app/settings.json')), true) ?? [];

        if (!empty($oldSettings['banner_image']) && ($oldSettings['banner_image'] !== ($formData['banner_image'] ?? ''))) {
            Storage::disk('public')->delete($oldSettings['banner_image']);
        }

        $settingsData = [
            'banner_image'          => $formData['banner_image'] ?? '',
            'banner_title'          => $formData['banner_title'] ?? '',
            'banner_subtitle'       => $formData['banner_subtitle'] ?? '',
            'whatsapp_number'       => $formData['whatsapp_number'] ?? '',
            'instagram_url'         => $formData['instagram_url'] ?? '',
            'facebook_url'          => $formData['facebook_url'] ?? '',
            'google_maps_url'       => $formData['google_maps_url'] ?? '',
            'google_maps_embed_url' => $formData['google_maps_embed_url'] ?? '',
            'alamat_toko'           => $formData['alamat_toko'] ?? '',
            'terms_content'         => $formData['terms_content'] ?? '',
            'privacy_content'       => $formData['privacy_content'] ?? '',
        ];
        
        file_put_contents(storage_path('app/settings.json'), json_encode($settingsData, JSON_PRETTY_PRINT));

        $holidaysData = [];
        if (isset($formData['dates']) && is_array($formData['dates'])) {
            foreach ($formData['dates'] as $item) {
                if (!empty($item['date'])) {
                    $holidaysData[] = substr($item['date'], 0, 10);
                }
            }
        }
        file_put_contents(storage_path('app/holidays.json'), json_encode($holidaysData, JSON_PRETTY_PRINT));

        Notification::make()
            ->title('Pengaturan Berhasil Disimpan!')
            ->success()
            ->send();
    }
}