<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->truncate();
        DB::table('products')->insert([
            [
            'image' => 'car.jpg',
            'name'  => 'Car',
            'price'  => 500.50,
            'user_id' => 1,
            'description' => 'This is car, I love this car',
            ],
            
            [
            'image' => 'football.jpg',
            'name'  => 'Football',
            'price'  => 20,
            'user_id' => 1,
            'description' => ' Ashok dai is Football Player',
            ],
            
            [
            'image' => 'motorbike.jpg',
            'name'  => 'MotorBike',
            'price'  => 123.90,
            'user_id' => 1,
            'description' => 'Hey This is motorbike',
            ],
            
            [
            'image' => 'television.jpg',
            'name'  => 'Television',
            'price'  => 45,
            'user_id' => 1,
            'description' => 'I always Watch Serial in Television',
            ]
        ]);
    }
}
