<?php

use App\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DefaultCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      	$default_company = New Company();
      	$default_company->name_km = "ឈ្មោះក្រុមហ៊ុនជាភាសាខ្មែរ";
      	$default_company->name_en = "Company's english name";
      	$default_company->user_id =  config('app.default_system_user_id');
      	$default_company->save();

      	DB::table('projects')->update(['company_id' => $default_company->id]);
    }
}
