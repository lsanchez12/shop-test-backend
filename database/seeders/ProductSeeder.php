<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::insert([[
            'name' => "Ball Adidas 2022",
            'description' => "BALÓN AL HILM PRO",
            'image_url' => "https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/ae4874fa8d2b40d483f5ae88012a2af4_9366/Balon_Al_Hilm_Pro_Dorado_HC0437_01_standard.jpg",
            'amount' => "699950"
        ],
        [
            'name' => "Adidas X",
            'description' => "Prepárate para subir la temperatura en la cancha con una precisión, velocidad y toque inigualables.",
            'image_url' => "https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/1c4c911d5ced4d60af28afa800e41ddb_9366/Guayos_X_Speedportal.4_Pasto_Sintetico_Dorado_GZ2444_22_model.jpg",
            'amount' => "299950",
        ],
        [
            'name' => "Tenis Racer TR21",
            'description' => "Tenis para correr",
            'image_url' => "https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/f46cd2ec7899449597b9af8c00fc3983_9366/Tenis_Racer_TR21_Cloudfoam_Negro_HP2726_01_standard.jpg",
            'amount' => "247771",
        ]]);
    }
}
