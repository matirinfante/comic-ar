<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Volume;
use App\Models\Edition;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'a@a.com',
            'password' => Hash::make('admin123')
        ]);

        foreach (range(1, 10) as $index) {
            User::factory()->create();
        }

        foreach (range(1, 10) as $index) {
            Edition::factory()->create();
        }
        
        foreach (range(1, 10) as $index) {
            Volume::factory()->create();
        }
        
        foreach (range(1, 20) as $index) {
            Review::factory()->create();
        }
    }
}
