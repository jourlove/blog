<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
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
                'name'=>'百度',
                'url'=>'http://www.baidu.com',
                'title'=>'全球中文搜索引擎',
                'order'=>'1',
            ],
            [
                'name'=>'新浪',
                'url'=>'http://www.sina.com',
                'title'=>'全球中文新闻平台',
                'order'=>'2',
            ]
        ];
        DB::table('links')->insert($data);
        //php artisan db:seed
    }
}
