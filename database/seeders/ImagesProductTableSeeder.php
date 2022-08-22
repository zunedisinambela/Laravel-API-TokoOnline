<?php

namespace Database\Seeders;

use App\Models\ImagesProduct;
use Illuminate\Database\Seeder;

class ImagesProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images_product = array(
            array('id' => '1', 'product_id' => '1', 'image' => 'product/H2MliUiyIRd13XdCpddso3Ea0LfqskSq6NPwWCmz.webp', 'created_at' => \Carbon\Carbon::now()),
            array('id' => '2', 'product_id' => '2', 'image' => 'product/ejulsPGb03VI2hTh92oWyD1yPniYZaE41WHCc7WK.webp', 'created_at' => \Carbon\Carbon::now())
        );

        ImagesProduct::insert($images_product);
    }
}
