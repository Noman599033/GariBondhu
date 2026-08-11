<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarImage;
use App\Models\CarCategory;
// Removed CarPrice import
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummyCarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryIds = CarCategory::pluck('id')->toArray();
        if (empty($categoryIds)) {
            $this->command->info('No categories found. Creating some default categories...');
            CarCategory::insert([
                ['name' => 'Sedan', 'slug' => 'sedan'],
                ['name' => 'SUV', 'slug' => 'suv'],
                ['name' => 'Luxury', 'slug' => 'luxury'],
                ['name' => 'Economy', 'slug' => 'economy'],
            ]);
            $categoryIds = CarCategory::pluck('id')->toArray();
        }

        $carBrands = ['Toyota', 'Honda', 'Nissan', 'Hyundai', 'Kia', 'Ford', 'BMW', 'Mercedes-Benz', 'Audi', 'Lexus'];
        $carModels = ['Corolla', 'Civic', 'Altima', 'Elantra', 'Forte', 'Focus', '3 Series', 'C-Class', 'A4', 'IS'];
        
        $this->command->info('Generating 20 dummy cars...');

        for ($i = 0; $i < 20; $i++) {
            $brand = $carBrands[array_rand($carBrands)];
            $model = $carModels[array_rand($carModels)];
            $name = $brand;
            $slug = Str::slug($name . '-' . $model . '-' . Str::random(5));
            
            // Create car
            $car = Car::create([
                'category_id' => $categoryIds[array_rand($categoryIds)],
                'name' => $name,
                'model' => $model,
                'slug' => $slug,
                'year' => rand(2018, 2026),
                'registration_number' => 'DHA-' . rand(10, 99) . '-' . rand(1000, 9999),
                'transmission' => (rand(0, 1) == 1) ? 'Automatic' : 'Manual',
                'fuel_type' => ['Petrol', 'Octane', 'Hybrid', 'Diesel'][rand(0, 3)],
                'seats' => [4, 5, 7][rand(0, 2)],
                'status' => 'active',
                'security_deposit_amount' => rand(5, 20) * 1000,
            ]);

            // Pricing is now managed globally via PricingRule

            // Generate dynamic SVG image for the car
            $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="600" height="400">
                <rect width="100%" height="100%" fill="#f8f9fa" />
                <rect width="100%" height="20" fill="' . $color . '" />
                <text x="50%" y="40%" font-family="Arial, sans-serif" font-size="32" font-weight="bold" fill="#333" dominant-baseline="middle" text-anchor="middle">' . $name . ' ' . $model . '</text>
                <text x="50%" y="55%" font-family="Arial, sans-serif" font-size="16" fill="#666" dominant-baseline="middle" text-anchor="middle">' . $car->year . ' | ' . $car->transmission . '</text>
                <text x="50%" y="75%" font-family="Arial, sans-serif" font-size="80" dominant-baseline="middle" text-anchor="middle">🚗</text>
            </svg>';
            
            $base64Image = 'data:image/svg+xml;base64,' . base64_encode($svg);

            CarImage::create([
                'car_id' => $car->id,
                'image' => $base64Image,
                'is_primary' => true,
            ]);
        }
        
        $this->command->info('Successfully created 20 dummy cars with images!');
    }
}
