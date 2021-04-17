<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['category_name' => '思春期、青年期のひきこもり（15歳～39歳）'],
            ['category_name' => '中高年のひきこもり（40歳～64歳）'],
            ['category_name' => '悩み事、不安なこと、困っていること'],
            ['category_name' => '自立に関すること'],
            ['category_name' => '家族に関すること'],
            ['category_name' => '他愛のない話題、ゆるい話'],
            ['category_name' => 'その他'],
        ]);
    }
}
