<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SellerBuyerProfile;
use App\Models\RiceListing;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create 2 Sellers
        $seller1 = User::create([
            'name' => 'Juan dela Cruz',
            'email' => 'juan@seller.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'status' => 'approved',
        ]);

        SellerBuyerProfile::create([
            'user_id' => $seller1->id,
            'user_type' => 'seller',
            'business_name' => 'Juan Rice Farm',
            'phone' => '09123456789',
            'barangay' => 'Centro',
            'municipality' => 'Tuguegarao City',
            'province' => 'Cagayan',
            'rating' => 4.5,
        ]);

        RiceListing::create([
            'seller_id' => $seller1->id,
            'rice_variety' => 'C-18',
            'price_per_kg' => 45.00,
            'quantity_available' => 500,
            'location' => 'Barangay Centro, Tuguegarao City',
            'harvest_date' => 'December 2025',
            'quality_grade' => 'premium',
            'description' => 'Fresh harvest premium C-18 rice. High quality grains perfect for daily consumption.',
            'status' => 'active',
        ]);

        RiceListing::create([
            'seller_id' => $seller1->id,
            'rice_variety' => 'Sinandomeng',
            'price_per_kg' => 42.00,
            'quantity_available' => 300,
            'location' => 'Barangay Centro, Tuguegarao City',
            'harvest_date' => 'January 2026',
            'quality_grade' => 'standard',
            'description' => 'Standard quality Sinandomeng rice. Great value for money.',
            'status' => 'active',
        ]);

        $seller2 = User::create([
            'name' => 'Maria Santos',
            'email' => 'maria@seller.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'status' => 'approved',
        ]);

        SellerBuyerProfile::create([
            'user_id' => $seller2->id,
            'user_type' => 'seller',
            'business_name' => 'Santos Rice Trading',
            'phone' => '09198765432',
            'barangay' => 'Ugac',
            'municipality' => 'Tuguegarao City',
            'province' => 'Cagayan',
            'rating' => 4.8,
        ]);

        RiceListing::create([
            'seller_id' => $seller2->id,
            'rice_variety' => 'Dinorado',
            'price_per_kg' => 55.00,
            'quantity_available' => 200,
            'location' => 'Barangay Ugac, Tuguegarao City',
            'harvest_date' => 'December 2025',
            'quality_grade' => 'premium',
            'description' => 'Premium Dinorado rice with excellent aroma and texture. Perfect for special occasions.',
            'status' => 'active',
        ]);

        RiceListing::create([
            'seller_id' => $seller2->id,
            'rice_variety' => 'Jasmine Rice',
            'price_per_kg' => 48.00,
            'quantity_available' => 400,
            'location' => 'Barangay Ugac, Tuguegarao City',
            'quality_grade' => 'standard',
            'description' => 'Fragrant Jasmine rice. Popular choice for Filipino households.',
            'status' => 'active',
        ]);

        // Create 2 Buyers
        User::create([
            'name' => 'Pedro Reyes',
            'email' => 'pedro@buyer.com',
            'password' => Hash::make('password'),
            'role' => 'buyer',
            'status' => 'approved',
        ]);

        User::create([
            'name' => 'Anna Garcia',
            'email' => 'anna@buyer.com',
            'password' => Hash::make('password'),
            'role' => 'buyer',
            'status' => 'approved',
        ]);
    }
}
