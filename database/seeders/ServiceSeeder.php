<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service; // <-- important

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::create([
            'title' => 'Web Development',
            'description' => 'Custom web application development...',
            'price' => 50000.00,
            'is_active' => true,
        ]);

        Service::create([
            'title' => 'Mobile App Development',
            'description' => 'iOS and Android app solutions...',
            'price' => 75000.00,
            'is_active' => true,
        ]);

        Service::create([
            'title' => 'SEO Optimization',
            'description' => 'Improve search engine rankings...',
            'price' => 20000.00,
            'is_active' => true,
        ]);
    }
}