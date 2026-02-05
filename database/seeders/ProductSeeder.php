<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'product_id' => 'PROD-001',
                'product_name' => 'Modern Office Chair',
                'description' => 'Ergonomic office chair with adjustable height, lumbar support, and breathable mesh back. Perfect for long working hours with maximum comfort and style.',
                'model_url' => 'https://modelviewer.dev/shared-assets/models/Astronaut.glb', // Demo model
                'poster_url' => null,
                'category' => 'Furniture',
                'metadata' => json_encode([
                    'material' => 'Premium Mesh & Aluminum',
                    'weight' => '15 kg',
                    'dimensions' => '65 x 65 x 120 cm',
                    'color' => 'Charcoal Black',
                ]),
                'is_active' => true,
            ],
            [
                'product_id' => 'PROD-002',
                'product_name' => 'Smart Home Speaker',
                'description' => 'Premium wireless speaker with 360° sound, voice assistant integration, and smart home control capabilities. Experience crystal-clear audio in any room.',
                'model_url' => 'https://modelviewer.dev/shared-assets/models/RobotExpressive.glb', // Demo model
                'poster_url' => null,
                'category' => 'Electronics',
                'metadata' => json_encode([
                    'connectivity' => 'WiFi, Bluetooth 5.0',
                    'battery' => '12 hours playback',
                    'weight' => '1.2 kg',
                    'voice_assistant' => 'Alexa, Google Assistant',
                ]),
                'is_active' => true,
            ],
            [
                'product_id' => 'PROD-003',
                'product_name' => 'Luxury Watch Collection',
                'description' => 'Handcrafted Swiss timepiece featuring automatic movement, sapphire crystal glass, and genuine leather strap. A statement of elegance and precision.',
                'model_url' => 'https://modelviewer.dev/shared-assets/models/MaterialsVariantsShoe.glb', // Demo model
                'poster_url' => null,
                'category' => 'Accessories',
                'metadata' => json_encode([
                    'movement' => 'Swiss Automatic',
                    'water_resistance' => '50 meters',
                    'case_diameter' => '42 mm',
                    'warranty' => '5 years',
                ]),
                'is_active' => true,
            ],
            [
                'product_id' => 'PROD-004',
                'product_name' => 'Electric Motorcycle',
                'description' => 'High-performance electric motorcycle with instant torque, 200km range, and cutting-edge design. The future of urban mobility is here.',
                'model_url' => 'https://modelviewer.dev/shared-assets/models/NeilArmstrong.glb', // Demo model
                'poster_url' => null,
                'category' => 'Vehicles',
                'metadata' => json_encode([
                    'range' => '200 km',
                    'top_speed' => '180 km/h',
                    'charging_time' => '2 hours (fast charge)',
                    'motor_power' => '75 kW',
                ]),
                'is_active' => true,
            ],
            [
                'product_id' => 'PROD-005',
                'product_name' => 'AR Headset Pro',
                'description' => 'Next-generation augmented reality headset with 4K displays, spatial audio, and hand tracking. Transform how you work, play, and create.',
                'model_url' => 'https://modelviewer.dev/shared-assets/models/Astronaut.glb', // Demo model
                'poster_url' => null,
                'category' => 'Technology',
                'metadata' => json_encode([
                    'display' => 'Dual 4K OLED',
                    'field_of_view' => '110 degrees',
                    'tracking' => '6DoF + Hand Tracking',
                    'battery' => '4 hours',
                ]),
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->command->info('Created ' . count($products) . ' sample products.');
    }
}
