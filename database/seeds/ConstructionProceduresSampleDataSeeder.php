<?php

use App\ConstructionProcedure;
use Illuminate\Database\Seeder;

class ConstructionProceduresSampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $system_user_id = config('app.default_system_user_id');
        ConstructionProcedure::insert([
            [
                'user_id' => $system_user_id,
                'name' => 'Land Filling',
                'name_km' => 'ការងារចាក់បំពេញដី',
            ],
            [
                'user_id' => $system_user_id,
                'name' => 'Foundation',
                'name_km' => 'ការងារគ្រិះ',
            ],
            [
                'user_id' => $system_user_id,
                'name' => 'Structure',
                'name_km' => 'ការងារគ្រឿងបង្គុំ',
            ],
            [
                'user_id' => $system_user_id,
                'name' => 'Plumbing and Electrical',
                'name_km' => 'ការងារទឹកភ្លើង',
            ],
            [
                'user_id' => $system_user_id,
                'name' => 'Wall',
                'name_km' => 'ការងារជញ្ជាំងឥដ្ឋ',
            ],
            [
                'user_id' => $system_user_id,
                'name' => 'Ceiling',
                'name_km' => 'ការងារពិដាន',
            ],
            [
                'user_id' => $system_user_id,
                'name' => 'Ceiling',
                'name_km' => 'ការងារពិដាន',
            ],
            [
                'user_id' => $system_user_id,
                'name' => 'Painting',
                'name_km' => 'ការងារថ្នាំ',
            ],
            [
                'user_id' => $system_user_id,
                'name' => 'Tile',
                'name_km' => 'ការងារការ៉ូ',
            ],
            [
                'user_id' => $system_user_id,
                'name' => 'Marble',
                'name_km' => 'ការងារម៉ាប',
            ],
            [
                'user_id' => $system_user_id,
                'name' => 'Steel',
                'name_km' => 'ការងារដែក',
            ],
            [
                'user_id' => $system_user_id,
                'name' => 'Glass',
                'name_km' => 'ការងារកញ្ចក់',
            ],
            [
                'user_id' => $system_user_id,
                'name' => 'Wood',
                'name_km' => 'ការងារឈើ',
            ],
            [
                'user_id' => $system_user_id,
                'name' => 'Furniture',
                'name_km' => 'ការងារគ្រឿងសង្ហារឹម',
            ],
            [
                'user_id' => $system_user_id,
                'name' => 'Draining',
                'name_km' => 'ការងារលូ',
            ],
            [
                'user_id' => $system_user_id,
                'name' => 'Road',
                'name_km' => 'ការងារចាក់បេតុងផ្លូវ',
            ],
            [
                'user_id' => $system_user_id,
                'name' => 'Fence',
                'name_km' => 'ការងាររបងផ្ទះ',
            ],
            [
                'user_id' => $system_user_id,
                'name' => 'Cleaning',
                'name_km' => 'ការងារសម្អាត',
            ],
        ]);
    }
}
