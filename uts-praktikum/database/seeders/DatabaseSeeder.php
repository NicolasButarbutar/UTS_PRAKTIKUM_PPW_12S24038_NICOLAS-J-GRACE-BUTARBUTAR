<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $cat1 = Category::create(['name' => 'Server & Cloud', 'code' => 'SRV']);
        $cat2 = Category::create(['name' => 'Internet of Things', 'code' => 'IOT']);
        $cat3 = Category::create(['name' => 'Multimedia & Drone', 'code' => 'DRN']);

        Equipment::create([
            'category_id' => $cat1->id,
            'asset_code' => 'EQ-SRV-001',
            'name' => 'Dell PowerEdge R740 Server',
            'specification' => '',
            'condition' => 'baik',
            'status' => 'tersedia',
            'daily_rental_fee' => 150000,
            'image_path' => null,
        ]);

        Equipment::create([
            'category_id' => $cat1->id,
            'asset_code' => 'EQ-SRV-002',
            'name' => 'Cisco Catalyst 3850 Switch',
            'specification' => '',
            'condition' => 'baik',
            'status' => 'dipinjam',
            'daily_rental_fee' => 75000,
            'image_path' => null,
        ]);

        Equipment::create([
            'category_id' => $cat2->id,
            'asset_code' => 'EQ-IOT-001',
            'name' => 'Raspberry Pi 4 Model B (8GB RAM) Starter Kit',
            'specification' => '',
            'condition' => 'baik',
            'status' => 'tersedia',
            'daily_rental_fee' => 25000,
            'image_path' => null,
        ]);

        Equipment::create([
            'category_id' => $cat2->id,
            'asset_code' => 'EQ-IOT-002',
            'name' => 'NVIDIA Jetson Nano Developer Kit',
            'specification' => '',
            'condition' => 'rusak_ringan',
            'status' => 'dalam_perbaikan',
            'daily_rental_fee' => 50000,
            'image_path' => null,
        ]);

        Equipment::create([
            'category_id' => $cat3->id,
            'asset_code' => 'EQ-DRN-001',
            'name' => 'DJI Mavic 3 Pro',
            'specification' => '',
            'condition' => 'baik',
            'status' => 'tersedia',
            'daily_rental_fee' => 200000,
            'image_path' => null,
        ]);

        Equipment::create([
            'category_id' => $cat3->id,
            'asset_code' => 'EQ-DRN-002',
            'name' => 'Sony A7 IV Camera',
            'specification' => '',
            'condition' => 'rusak_berat',
            'status' => 'dalam_perbaikan',
            'daily_rental_fee' => 175000,
            'image_path' => null,
        ]);
    }
}