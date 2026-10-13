<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Products;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_pelanggan')
                    ->required(),
                Select::make('product_id')
                    ->label('Produk')
                    ->relationship('product', 'nama_produk')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, $set, $get) {
                        $set('total_harga', self::calculateTotalHarga($state, $get('qty')));
                    }),
                TextInput::make('qty')
                    ->required()
                    ->numeric()
                    ->default(1)
                    ->live()
                    ->afterStateUpdated(function ($state, $set, $get) {
                        $set('total_harga', self::calculateTotalHarga($get('product_id'), $state));
                    }),
                TextInput::make('total_harga')
                    ->label('Total Harga')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->readOnly(),
                Textarea::make('catatan')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('status')
                    ->options([
                        'Menunggu' => 'Menunggu',
                        'Diproses' => 'Diproses',
                        'Selesai' => 'Selesai',
                    ])
                    ->default('Menunggu'),
            ]);
    }

    public static function calculateTotalHarga(?int $productId, ?int $qty): ?string
    {
        if (blank($productId) || blank($qty) || $qty < 1) {
            return null;
        }

        $product = Products::find($productId);

        if (! $product) {
            return null;
        }

        return (string) ($product->harga_produk * $qty);
    }
}
