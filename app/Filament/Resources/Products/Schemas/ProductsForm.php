<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;

class ProductsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
               FileUpload::make('gambar_produk')
                    ->image()
                    ->disk('public')
                    ->directory('products')
                    ->required(),
                TextInput::make('nama_produk')
                    ->required(),
                Textarea::make('deskripsi_produk')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('harga_produk')
                    ->required()
                    ->numeric(),
            ]);
    }
}
