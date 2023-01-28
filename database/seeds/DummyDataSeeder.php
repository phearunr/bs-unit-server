<?php

use Illuminate\Database\Seeder;
use App\Helpers\UserRole;
use Illuminate\Support\Facades\Log;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Warning this seeder should be called on the empty database only
        // Running this seeder on the live production environment could result in the database error

    	// User Identification Default Data
        if ( \App\UserIdentification::count() == 0 ) {
        	\App\UserIdentification::create([ "title" => "Identification Card" ]);
            \App\UserIdentification::create([ "title" => "Passport" ]);
            \App\UserIdentification::create([ "title" => "Student Card" ]);
        }
        $this->command->info('User Identification data has been created successfully.');

        $contract_types = [
            "land",
            "condo",
            "house",
            'shop',
            'condo-ecc'
        ];

        foreach( $contract_types as $contract_type) {
            if ( !\App\ContractTemplate::where('name', $contract_type)->first() ) {
                \App\ContractTemplate::create([
                    'name' => $contract_type,
                    'template_path' => str_replace("-","_",strtolower($contract_type))
                ]);
            }
        }

        $this->command->info('Default Contract Tempalte has been created successfully.');

        // Default Roles and Permissions
        $this->call(RoleAndPermissionTableSeeder::class);

        // Default Built-in Administrator User
        if ($this->command->confirm('Do you want to create built-in Administrator account?')) {
           $admin = \App\User::where('phone_number', '0123456789')->first();
            if ( !$admin ) {
                $admin = \App\User::create([         
                    "name"          => "SYSTEM",
                    "email"         => "",
                    "phone_number" => "0123456789",
                    "password"      => bcrypt("password")
                ]);
                $admin->assignRole(UserRole::ADMINISTRATOR);
            }
            $this->command->info("Administrator account has been created successfully. [loign: 0123456789, password: password]" );
        }

        // Create User for every available role in config/permission.php
        if ($this->command->confirm('Do you want to create dummy user account for every role in config/permission.php?')) {
            $roles = config('permission.available_roles' , null );
            if ( !is_null($roles) ) {
                foreach( array_keys($roles) as $role ) {              
                    $user = factory(App\User::class)->create();
                    $user->assignRole($role);
                }
            }
            $this->command->info('Dummy account for every role has been created successfully.' );

            // As Business requirement Agent need to be under Sale Team Lead
            // We will find one agent and one sale team leader account
            // then assign the agetn to sale team leader
            if ( $this->command->confirm('Do you want to assign agent to sale team leader?') ) {
                $sale_team_leader = App\User::role(UserRole::SALE_TEAM_LEADER)->first();
                $agent = App\User::role(UserRole::AGENT)->first();

                if ( $sale_team_leader AND $agent ) {
                    $agent->managed_by = $sale_team_leader->id;
                    $agent->save();
                    $this->command->info("$sale_team_leader->name has been assiged as Sale team leader of agent $agent->name." );
                } else {
                    $this->command->error('There are no either Sale Team Leader or Agent account.');
                }
            }
        }

        if ( $this->command->confirm('Do you want to create dummy unit?') ) {
            $company = App\Company::create([                
                'user_id' => config('app.default_system_user_id'),
                'name_km' => "ឈ្មោះក្រុមហ៊ុនជាភាសាខ្មែរ",
                'address_line1' => 'អគារលេខ ផ្ឡូវលេខ សង្កាត់',
                'address_line2' => 'ខណ្ឌ ក្រុង ប្រទេស',
                'name_en' => "Company's english name",
                'address_line1_en' => 'Building No Street No ',
                'address_line2_en' => "Khan City Country",
                'name_zh' => '公司英文名称',
                'address_line1_zh' => '地址第一行',
                'address_line2_zh' => '地址第二行',
                'contact_phone_number' => '(855) 12 234 567',
                'email_address' => 'myemail@company.com',
                'website' => 'www.mycompany.com',
                'tax_no' => 'K000-123456789',
                'tax_issued_date' => '2020-01-01',
                'commercial_license_no' => 'K000-123456789',
                'commercial_license_issued_date' => '2020-01-01',
                'nav_company_code' => 'BS' 
            ]);
            $this->command->info('Dummy Company has been created successfully.');

            $sale_representator = App\SaleRepresentative::create([
                'name' => 'តេស្តតំណាងលក់',
                'name_en' => 'Test Sale Representative',
                'gender' => 'Male',
                'birth_date' => '1990-01-01',
                'national_id' => 'N12345798',
                'national_id_issued_date' => '2010-01-01',        
                'contact_number' => '010 909 8081 / 012 202 303',
                'national_id_front_attachment_url' => 'img/customer-id-back-default.jpg',
                'national_id_back_attachment_url' => 'img/customer-id-back-default.jpg',
                'authorize_letter_url' => null
            ]);
            $this->command->info('Dummy Sale Representator has been created successfully.' );
            
            $bank = App\Bank::create([
                'name' => 'ឈ្មោះគម្រោង - Project Name', 
                'short_name' => 'ABA',
                'account_name' => 'Bank Account Name', 
                'account_number' => '00099999'
            ]);
            $this->command->info('Dummy Bank has been created successfully.' );

            $project = $company->projects()->create([
                'user_id' => config('app.default_system_user_id'),  
                'is_published' => true,
                'name' => 'គម្រោងសាកល្បង',
                'name_en' => 'Dummy Project',
                'name_zh' => '虚拟项目',
                'address' => 'អាសយដ្ឋាន',
                'address_en' => 'Project Address',
                'address_zh' => '地址',
                'short_code' => 'DEMO-PROJECT',
                'nav_company_code' => 'BS (NAV Company Name)',
                'sale_representative_id' => $sale_representator->id ,
                'bank_id' => $bank->id,
                'logo_url' => 'img/bs_units_512x512.png'                
            ]);
            $this->command->info('Dummy Project has been created successfully.');

            $unit_type = $project->unitTypes()->create([
                'user_id' => config('app.default_system_user_id'),
                'project_id' => $project->id, 
                'name' => 'Link house - LA',
                'short_code' => 'LA',
                'is_contractable' => TRUE,
                'annual_management_fee' => 180,
                'contract_transfer_fee' => 300,
                'management_fee_per_square' => 0,
                'deadline' => 24,
                'extended_deadline' => 6,
                'title_clause_kh' => 'មាត្រាក្នុងកិច្ចសន្យាដែលត្រូវចែងអំពីកម្មសិទ្ធិនៃប្រភេទទ្រព្យសម្បត្តិ។',
                'title_clause_en' => 'The article in the contract which should be stated about ownership of the property type.',
                'title_clause_zh' => '合同中有关财产类型所有权的条款。',
                'management_service_kh' => 'មាត្រានៅក្នុងកិច្ចសន្យាដែលគួរតែត្រូវបានចែងអំពីសេវាកម្មគ្រប់គ្រងដែលក្រុមហ៊ុនបានផ្តល់ឱ្យ។',
                'management_service_en' => 'The article in the contract which should be stated about the management services which company provided.',
                'management_service_zh' => '合同中的条款应说明公司提供的管理服务。',
                'contract_template_id' => App\ContractTemplate::where('name', 'house')->first()->id ?? 1, 
                'payment_option_image_url' => 'img/payment_option_sample.jpg',
                'equipment_text' => 'ផ្នែកនេះត្រូវបញ្ជាក់នូវរាល់ឧបករណ៍ដែលក្រុមហ៊ុនផ្តល់ជូនអតិថិជន។',
                'equipment_text_en' => 'This section shall be stated all equipments which company provide to customer',
                'equipment_text_zh' => '本节应说明公司向客户提供的所有设备。',
                'feature_image_url' => 'img/sample_unit_type_feature.jpeg'
            ]);
            $this->command->info('Dummy Unit Type has been created successfully.');

            $unit_type->paymentOptions()->create([
                'user_id' => config('app.default_system_user_id'),               
                'name' => '3 Years no interest',
                'deposit_amount' => 500,
                'loan_duration' => 0, 
                'interest' => 0, 
                'special_discount' => 0,
                'is_first_payment' => false,                
                'first_payment_duration' => 0,
                'first_payment_percentage' => 0
            ]);

            $unit_type->paymentOptions()->create([
                'user_id' => config('app.default_system_user_id'),
                'name' => '20% first, 10 years with 10% Interest',
                'deposit_amount' => 500,
                'loan_duration' => 120,
                'interest' => 10,
                'special_discount' => 0,
                'is_first_payment' => true,
                'first_payment_duration' => 1,            
                'first_payment_percentage' => 20
            ]);

            $unit_type->paymentOptions()->create([
                'user_id' => config('app.default_system_user_id'),
                'name' => '7%​ for full payment',
                'deposit_amount' => 500,
                'loan_duration' => 1,
                'interest' => 0,
                'special_discount' => 7,
                'is_first_payment' => false,
                'first_payment_duration' => 0,
                'first_payment_percentage' => 0
            ]);

            $this->command->info('Dummy Payment Options has been created successfully.');

            for( $i=1; $i <= 20; $i++ ) {
                App\Unit::create([
                    'user_id' => config('app.default_system_user_id'),
                    'unit_type_id' => $unit_type->id,
                    'code' => $unit_type->name.' - 0'.$i,
                    'price' => 10000,
                    'saleable' => true,
                    'street' => '123 (Main Road)',
                    'street_corner' => '',
                    'street_size' => 30,
                    'floor' => null,
                    'land_size_width' => 5,
                    'land_size_length' => 20,
                    'land_area' => null,
                    'building_size_width' => 5,
                    'building_size_length' => 12,
                    'building_area' => null,
                    'living_room' => 1,
                    'kitchen' => 1,
                    'bedroom' => 4,
                    'bathroom' => 4,
                    'swimming_pool' => 0
                ]);
            }
            $this->command->info('Dummy 20 Units has been created successfully.');

            $this->call(ConstructionProceduresSampleDataSeeder::class);
            $this->call(UnitConstructionProcedureSampleDataSeeder::class);
        }
    }
}