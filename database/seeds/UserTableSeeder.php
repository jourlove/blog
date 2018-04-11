<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'=>'admin',
                'password'=>'eyJpdiI6IkFlcnA0bFhBVEhIbmtoMXM3MzJyVGc9PSIsInZhbHVlIjoiTUFkZ2NKMTFOeWpGNDdQOThcL1Fhd0E9PSIsIm1hYyI6Ijc1NjFmMGE5ZWRmNDY4MzgzMzliYzlhODI3MjBlZjA2MTg1N2IxZTAwZTZlNzE4MzA2M2YzNTNiZjVkZGU4MjAifQ=',
            ],
            [
                'name'=>'test',
                'password'=>'eyJpdiI6IkFlcnA0bFhBVEhIbmtoMXM3MzJyVGc9PSIsInZhbHVlIjoiTUFkZ2NKMTFOeWpGNDdQOThcL1Fhd0E9PSIsIm1hYyI6Ijc1NjFmMGE5ZWRmNDY4MzgzMzliYzlhODI3MjBlZjA2MTg1N2IxZTAwZTZlNzE4MzA2M2YzNTNiZjVkZGU4MjAifQ=',
            ],
        ];
        DB::table('user')->insert($data);
        //php artisan db:seed
    }
}
