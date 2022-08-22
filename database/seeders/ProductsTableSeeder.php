<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = array(
            array('id' => '1', 'product' => 'Gambar 1', 'price' => '100000.00', 'stock' => '100', 'description' => '<p>

          </p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin eros eros, tincidunt auctor enim a, tincidunt tincidunt turpis. Nullam euismod ante eget mauris bibendum egestas. Nam vitae mi augue. Vivamus sagittis ac erat sit amet maximus. Donec semper velit at massa pellentesque imperdiet. Aliquam suscipit urna a nunc luctus pellentesque. Nam tellus tellus, tincidunt at risus id, varius commodo ante</p><p></p>', 'created_at' => \Carbon\Carbon::now()),
            array('id' => '2', 'product' => 'Gambar 2', 'price' => '200000.00', 'stock' => '200', 'description' => '<p>

          </p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin eros eros, tincidunt auctor enim a, tincidunt tincidunt turpis. Nullam euismod ante eget mauris bibendum egestas. Nam vitae mi augue. Vivamus sagittis ac erat sit amet maximus. Donec semper velit at massa pellentesque imperdiet. Aliquam suscipit urna a nunc luctus pellentesque. Nam tellus tellus, tincidunt at risus id, varius commodo ante</p><p></p>', 'created_at' => \Carbon\Carbon::now())
        );

        Product::insert($products);
    }
}
