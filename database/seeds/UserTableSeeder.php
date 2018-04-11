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
                'password'=>'eyJpdiI6InFIdGlvdVcyRGgyOU05THpCXC9saGlRPT0iLCJ2YWx1ZSI6ImYzc1ZvbGNId1I2MFwvRWRoVFRiRmdnPT0iLCJtYWMiOiIyOGQ3MDQ5ZGNjMzQ3Y2M0YzIwZDc2MDhmYjAzMTQ0MDc0ZDdhYzZhNDNiZTdiYjE3YWQxNzQ4ZjRlZDFmMGJmIn0=',
            ]
        ];
        DB::table('user')->insert($data);
        //php artisan db:seed
    }
}
