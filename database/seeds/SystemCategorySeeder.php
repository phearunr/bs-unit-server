<?php

use Illuminate\Database\Seeder;
use App\Category;

class SystemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$category = New Category;
    	$category->name = 'Announcement';
    	$category->description = '[Default] This category is created by system. It is used for mobile to display any company\'s announcement';
    	$category->default = true;
    	$category->save();
    }
}
