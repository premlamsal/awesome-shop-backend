<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //id 1
        DB::table('categories')->insert([
            'name' => 'Mens',
            'link' => 'https://eshop.test/#/category/'.'mens',
            'slug' => 'mens',
        ]);
        //id 2
        DB::table('categories')->insert([
            'name' => 'Women',
            'link' => 'https://eshop.test/#/category/'.'women',
            'slug' => 'women',
        ]);
        //id 3
        DB::table('categories')->insert([
            'name' => 'T-Shirt',
            'link' => 'https://eshop.test/#/category/'.'tshirt',
            'slug' => 'tshirt',
            'parent_id'=>'1'
        ]);
        //id 4
        DB::table('categories')->insert([
            'name' => 'Pants',
            'link' => 'https://eshop.test/#/category/'.'pants',
            'slug' => 'pants',
            'parent_id'=>'1'
        ]);
        //id 5
        DB::table('categories')->insert([
            'name' => 'Plain',
            'link' => 'https://eshop.test/#/category/'.'Plain',
            'slug' => 'plain',
            'parent_id'=>'3'
        ]);
        //id 6
        DB::table('categories')->insert([
            'name' => 'Full',
            'link' => 'https://eshop.test/#/category/'.'full',
            'slug' => 'full',
            'parent_id'=>'3'
        ]);
        //id 7
        DB::table('categories')->insert([
            'name' => 'Jwellery',
            'link' => 'https://eshop.test/#/category/'.'jwellery',
            'slug' => 'jwellery',
            'parent_id'=>'2'
        ]);
        //id 8
        DB::table('categories')->insert([
            'name' => 'Creams',
            'link' => 'https://eshop.test/#/category/'.'creams',
            'slug' => 'creams',
            'parent_id'=>'2'
        ]);
        //id 9
        DB::table('categories')->insert([
            'name' => 'Face',
            'link' => 'https://eshop.test/#/category/'.'face',
            'slug' => 'face',
            'parent_id'=>'8'
        ]);
        //id 10
        DB::table('categories')->insert([
            'name' => 'body',
            'link' => 'https://eshop.test/#/category/'.'body',
            'slug' => 'body',
            'parent_id'=>'8'
        ]);


        
    }
}
