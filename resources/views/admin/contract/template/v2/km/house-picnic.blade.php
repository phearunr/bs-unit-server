@extends('admin.contract.template.v2.km.template')
@section('page_title', "Contract $contract->customer1_name")
@section('contract_type')
<h3 class="khmer-title text-center mt-3 mb-3">កិច្ចសន្យាលក់ ទិញផ្ទះក្នុង</h3>
@endsection

@section('praka')
<p class="khmer-title pb-0 mb-0">ប្រការ១៖ អត្តសញ្ញាណនៃអចលនវត្ថុលក់ទិញ និងតម្លៃលក់ទិញ</p>
<p><span class="text-bold">១.១.</span> ភាគី <span class="text-bold">“អ្នកលក់”</span> គឺ​ជា​កម្មសិទ្ធិករ​ស្រប​ច្បាប់​លើ​អចលនវត្ថុ យល់​ព្រម​លក់ ហើយ ភាគី <span class="text-bold">“អ្នកទិញ”</span> យល់​ព្រម​ទិញ​នូវ​អចលនវត្ថុ​ដូច​មាន​ចែង​ក្នុង​តារាង​អត្តសញ្ញាណ​នៃ​អចលនវត្ថុ​លក់ទិញ និង​តម្លៃ​លក់​ទិញ​នេះ។</p>
<p><span class="text-bold">១.២.</span> តារាងអត្តសញ្ញាណនៃអចលនវត្ថុលក់ទិញ និងតម្លៃលក់ទិញ (“អចលនវត្ថុ”)៖</p>
<table class="table table-p-1 table-contract-bordered">
    <tr>
        <td width="180px" class="text-bold">ប្រភេទ</td>
        <td width="30px" class="text-center">៖</td>      
        <td><span class="text-bold english">{{ $unit_type->name }}</span></td>
        <td width="100px" class="text-bold">លេខ</td>
        <td width="30px" class="text-center">៖</td>
        <td width="250px" class="english text-bold">{{ isset($is_template) ? '_______________' : $unit->code }}</td>
    </tr>
    <tr>
        <td width="180px" class="text-bold">ទំហំសំណង់</td>
        <td width="30px" class="text-center">៖</td>      
        <td>
            <p>
            @if( isset($is_template) )
                _______________
            @else
                @if($unit->building_size_width)
                ទទឹង {{ $unit->building_size_width_km }} ម៉ែត្រ និង បណ្តោយ {{ $unit->building_size_length_km }} ម៉ែត្រ
                @else
                សុរប {{ $unit->building_area_km }} ម៉ែត្រការ៉េ
                @endif
            @endif
            </p>
        </td>
        <td width="100px" class="text-bold">ទំហំដី</td>
        <td width="30px" class="text-center">៖</td>
        <td width="250px">
            <p class="pb-0">
            @if( isset($is_template) )
                _______________
            @else
                @if( $unit->land_size_width AND $unit->land_size_length )
                ទទឹង {{ $unit->land_size_width_km }} ម៉ែត្រ និង បណ្តោយ {{ $unit->land_size_length_km }} ម៉ែត្រ
                @else
                សុរប {{ $unit->land_area_km }} ម៉ែត្រការ៉េ
                @endif
            @endif
            </p>
            <span><small><i>(ដែល​អាច​មាន​ការ​ប្រែប្រួល​បន្តិច​បន្ទួច ជា​លក្ខណៈ​បច្ចេកទេស អាស្រ័យ​លើ​ការ​កំណត់​ព្រុំ​របស់​មន្ត្រី​សុរិយោដី)</i></small></span>
        </td>
    </tr>
    <tr>
        <td width="180px" class="text-bold">ទីតាំងគម្រោង</td>
        <td width="30px" class="text-center">៖</td>      
        <td colspan="4">
            {{ $project->address }}
        </td>
    </tr>
    <tr>
        <td width="180px" class="text-bold">សេវា និងថ្លៃគ្រប់គ្រងថែទាំ</td>
        <td width="30px" class="text-center">៖</td>      
        <td colspan="4">
            <p class="pb-0">
                {{
                \App\Helpers\NumberFormat::convertToKhmerNumber(number_format($contract->annual_management_fee)) 
                }} 
                ({{
                \App\Helpers\NumberFormat::covertUsdToKhmerWord($contract->annual_management_fee, false) 
                }}) ដុល្លារអាមេរិកក្នុងមួយឆ្នាំ
            </p>
            <span><small><i>ដោយត្រូវបង់សរុបមួយឆ្នាំម្តងៗ  ដូចមានចែងលម្អិតក្នុងប្រការ ៦ នៃកិច្ចសន្យានេះ។ </i></small></span>
        </td>
    </tr>
    <tr>
        <td width="180px" class="text-bold">ការផ្តល់ជូនសេវាបន្ថែម</td>
        <td width="30px" class="text-center">៖</td>      
        <td colspan="4">
            {{ $contract->management_service_kh }}
        </td>
    </tr>
    <tr>
        <td width="180px" class="text-bold">ប្រភេទ​នៃ​ប័ណ្ណ​កម្មសិទ្ធិ​ដែល​ប្រគល់​ជូន​ភាគី “អ្នកទិញ”</td>
        <td width="30px" class="text-center">៖</td>      
        <td colspan="4">
            {{ $contract->title_clause_kh }}
        </td>
    </tr>
    <tr>
        <td width="180px" class="text-bold">បន្ទប់គេង</td>
        <td width="30px" class="text-center">៖</td>      
        <td>{{  isset($is_template) ? '_______' : $unit->bedroom ? $unit->bedroom_km : 'ពុំមាន' }}</td>
        <td width="100px" class="text-bold">ផ្ទះបាយ</td>
        <td width="30px" class="text-center">៖</td>
        <td width="250px">{{ isset($is_template) ? '_______' : $unit->kitchen ? $unit->kitchen_km : 'ពុំមាន' }}</td>
    </tr>
    <tr>
        <td width="180px" class="text-bold">បន្ទប់ទឹក</td>
        <td width="30px" class="text-center">៖</td>      
        <td>{{  isset($is_template) ? '_______' : $unit->bathroom ? $unit->bathroom_km : 'ពុំមាន' }}</td>
        <td width="100px" class="text-bold">បន្ទប់ទទួលភ្ញៀវ</td>
        <td width="30px" class="text-center">៖</td>
        <td width="250px">{{  isset($is_template) ? '_______' : $unit->living_room ? $unit->living_room_km : 'ពុំមាន' }}</td>
    </tr>
    @if( $unit->swimming_pool )
    <tr>
        <td width="180px" class="text-bold">អាងហែលទឹក</td>
        <td width="30px" class="text-center">៖</td>
        <td colspan="4">{{ isset($is_template) ? '_______' : $unit->swimming_pool ? $unit->swimming_pool_km : 'ពុំមាន' }}</td>
    </tr>
    @endif
    <tr>
        <td width="180px" class="text-bold">តម្លៃលក់ទិញ</td>
        <td width="30px" class="text-center">៖</td>
        <td class="text-bold" colspan="4">
            @if( isset($is_template) )
                _______________ ( _______________ ) 
            @else
            {{ $contract->unit_sale_price_after_discount_km }} ({{ $contract->unit_sale_price_after_discount_in_word_km }}) 
            @endif
            ដុល្លារ​​​អាមេរិច
        </td>    
    </tr>
</table>

<p class="khmer-title pb-0 mb-0">ប្រការ២៖ ការទូទាត់ប្រាក់ថ្លៃលក់ទិញអចលនវត្ថុ</p>
<p><span class="text-bold">២.១.</span> ដោយ​មាន​ការ​ព្រមព្រៀង​គ្នា​ក្នុង​ការ​លក់​ទិញ នូវ​អចលនវត្ថុ​ដូច​បាន​ចែង​ក្នុង​ <span class="text-bold">ប្រការ១ “អត្តសញ្ញាណ​នៃ​អចលនវត្ថុ​លក់​ទិញ និងតម្លៃ​លក់​ទិញ”</span> ខាងលើ ភាគី <span clas="text-bold">“អ្នកទិញ”</span> ត្រូវ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ខាង​លើ​ទៅ​តាម​ដំណាក់កាល​នៃ​ការ​ទូទាត់​ឲ្យ​បាន​ត្រឹមត្រូវ គ្រប់​ចំនួន​ និង​ទាន់​ពេល​វេលា​ជា​បន្ត​បន្ទាប់​ដូច​បាន​ចែង​ក្នុង​ឧបសម្ព័ន្ធទី១ <span class="text-bold">“តារាងកាលវិភាគ​នៃ​ការ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ”</span>។ ភាគី <span class="text-bold">“អ្នកទិញ”</span> អាច​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ដោយ​ផ្ទាល់​នៅ​ការិយាល័យ​របស់​ភាគី <span class="text-bold">“អ្នកលក់”</span> ឬ​តាម​រយៈ​គណនី​ធនាគារ <span class="text-bold">{{ $bank->short_name }}</span> ដូច​មាន​ព័ត៌មាន​លម្អិត​ខាង​ក្រោមនេះ៖</p>

<table class="table table-p-1 table-bordered ">
    <tr>
        <th class="text-center">ឈ្មោះគណនីធនាគារ</th>
        <th class="text-center">លេខគណនីធនាគារ</th>
    </tr>   
    <tr>
        <td class="text-center">{{ $bank->account_name }}</td>
        <td class="text-center">{{ $bank->account_number }}</td>
    </tr>
</table>

<p><span class="text-bold">២.២.</span> ភាគី <span class="text-bold">“អ្នកលក់”</span> អនុគ្រោះ​ជូនភាគី <span class="text-bold">“អ្នកទិញ”</span> ក្នុង​ការ​យឺតយ៉ាវ ឬ​ខក​ខាន​ទូទាត់​ប្រាក់ថ្លៃ​លក់ទិញ​អចលនវត្ថុ​ត្រឹមរយៈពេល <span class="text-bold">០៧ (ប្រាំពីរ) ថ្ងៃប្រតិទិន</span> ដោយ​មិន​បង់​ប្រាក់​ពិន័យ។ ផុត​ពី​រយៈ​ពេល​អនុគ្រោះ​នេះ ក្នុង​ករណី​ដែល​ភាគី <span class="text-bold">“អ្នកទិញ”</span> យឺតយ៉ាវ ឬ​ខកខាន​មិន​បាន​បំពេញ​កាតព្វកិច្ច​ទូទាត់​បង់ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ជូន​ភាគី <span class="text-bold">“អ្នកលក់”</span> ទៅ​តាម​ដំណាក់​កាល​នៃ​ការ​ទូទាត់​ឲ្យ​បាន​ត្រឹមត្រូវ គ្រប់ចំនួន និង​ទាន់​ពេល​វេលា​ទេ​នោះ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​បង់​ប្រាក់​ពិន័យ​លើ​ការ​យឺតយ៉ាវ ឬ​ខក​ខាន​នោះ​ក្នុង​មួយថ្ងៃ <span class="text-bold">០៥ (ប្រាំ) ដុល្លារ​អាមេរិក</span>។ ក្នុង​ករណី​ដែល​ការ​យឺតយ៉ាវ ឬ​ខក​ខាន​ក្នុង​ការ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​នោះ​នៅ​តែ​បន្ត​លើសពី រយៈពេល <span class="text-bold">០២ (ពីរ) ខែ</span>​ជាប់ៗ​គ្នា ឬ​ក្នុង​ចន្លោះ​រយៈ​ពេល​ណា​មួយ​ដែល​ផល​បូក​នៃ​រយៈ​ពេល​ទាំង​នោះ​លើស​ពី <span class="text-bold">០២ (ពីរ) ខែ</span> នោះ​ត្រូវ​បាន​សន្មត់ទុក​ជា​មុន និង​ចាត់​ទុក​ថា ភាគី <span class="text-bold">“អ្នកទិញ”</span> រំលាយ​កិច្ចសន្យា​ដោយ​ឯកតោ​ភាគី ដោយ​បោះបង់​ចោល​នូវ​សិទ្ធិ​ទាំង​ឡាយ​ដែល​មាន​លើអចលនវត្ថុ ការ​លក់​ទិញ​អចលនវត្ថុ និង​ចំនួន​ទឹក​ប្រាក់​ដែល​ខ្លួន​បាន​ទូទាត់​មក​ឲ្យ​ភាគី <span class="text-bold">“អ្នកលក់”</span>។ ក្នុង​ករណី​នេះ ទឹក​ប្រាក់​ដែល​បាន​ទូទាត់​ហើយ​ទាំងអស់​ត្រូវ​ក្លាយ​ជា​ប្រយោជន៍​សម្រាប់​ភាគី <span class="text-bold">“អ្នកលក់”</span> ហើយ ភាគី <span class="text-bold">“អ្នកលក់”</span> មាន​សិទ្ធិ​ពេញ​លេញ​ដោយ​ស្រប​ច្បាប់​ក្នុង​ការ​លក់​អចលនវត្ថុ​ខាង​លើ​ឲ្យ​ទៅ​អតិថិជន ឬ​អ្នក​ទិញ​ផ្សេង​ទៀត​បាន ដោយ​ភាគី <span class="text-bold">“អ្នកទិញ”</span> សន្យា​ថា​នឹង​មិន​តវ៉ា ឬ​ជំទាស់​ឡើយ។ ក្នុង​ករណី​នេះ ប្រសិន​បើ ភាគី <span class="text-bold">“អ្នកទិញ”</span> បាន​ទទួល​យក​អចលនវត្ថុ​ពី ភាគី <span class="text-bold">“អ្នកលក់”</span> ហើយនោះ ភាគី <span class="text-bold">“អ្នកលក់”</span> ទុក​រយៈ​ពេល​ឲ្យ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ដែល​បោះបង់​សិទ្ធិ​លើ​ការ​លក់​ទិញ និង​អចលនវត្ថុ​នោះ <span class="text-bold">០១ (មួយ) ខែ</span> សម្រាប់​រើចេញ​ពី​អចលនវត្ថុ។</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៣៖ ការលក់ ឬផ្ទេរសិទ្ធិលើការលក់ទិញអចលនវត្ថុបន្តទៅតតិយជន និងឥណទានពីធនាគារ</p>
<p><span class="text-bold">៣.១.</span> ក្នុង​កំឡុង​ពេល​នៃ​ការ​អនុវត្ត​កិច្ចសន្យា​លក់​ទិញ​នេះ ភាគី <span class="text-bold">“អ្នកទិញ”</span> អាច​លក់ ឬ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ​អចលនវត្ថុ​ទៅ​ តតិយជន​ណា​មួយ​បាន​ដោយ​ការ​ស្នើ​សុំ​ជា​លាយ​លក្ខណ៍​អក្សរ ហើយ​ទទួល​បាន​ការ​អនុញ្ញាត​យល់​ព្រម​ពី​ភាគី <span class="text-bold">“អ្នកលក់”</span> ដោយភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​បង់​ថ្លៃ​សេវា​រដ្ឋបាល​លើ​ការ​លក់ ឬ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ អចលនវត្ថុ​នេះ​ស្មើ​នឹង <span class="text-bold">{{ $contract->contract_transfer_fee_km }} ({{ $contract->contract_transfer_fee_in_word_km }}) ដុល្លារ​អាមេរិក</span> ជូន​ភាគី <span class="text-bold">“អ្នកលក់”</span>។ មុន​នឹង​អាច​លក់ ឬ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ​អចលនវត្ថុ​ទៅ​តតិយជន​ណា​មួយ​បាន ប្រសិន​បើ​ភាគី <span class="text-bold">“អ្នកទិញ”</span> យឺតយ៉ាវ ឬ​ខក​ខន​មិន​បាន​បំពេញ​កាតព្វកិច្ច​ទូទាត់​បង់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ជូន​ភាគី <span class="text-bold">“អ្នកលក់”</span> ទៅ​តាម​ដំណាក់​កាល​នៃ​ការ​ទូទាត់​ឲ្យ​បាន​ត្រឹមត្រូវ គ្រប់ចំនួន និងទាន់​ពេល​វេលា​ដូច​ចែង​ក្នុង​ <span class="text-bold">ប្រការ២</span> នោះ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​ទូទាត់​ប្រាក់​ដែល​នៅ​ជំពាក់ និង​ប្រាក់​ពិន័យ​លើ​ការ​យឺត​យ៉ាវ ឬ​ខក​ខាន​នោះ​ឲ្យ​រួច​រាល់​ជា​មុន​សិន។ តតិយជន​ដែល​ទទួល​ទិញ ឬ​ទទួល​ការ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ​អចលនវត្ថុ​នេះ ត្រូវ​គោរព​តាម​ទាំង​ស្រុង​នូវ​ខ្លឹម​សារ​នៃ​កិច្ចសន្យា​លក់​ទិញ​នេះ ហើយ​អនុវត្ត​តាម​បែប​បទ​រដ្ឋបាល​មួយ​ចំនួន​ដែល​ភាគី <span class="text-bold">“អ្នកលក់”</span> តម្រូវ។</p>
<p><span class="text-bold">៣.២.</span> ចំពោះ​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ដែល​ជ្រើស​រើស​ជម្រើស​បង់រម្លស់ <span class="english">(Loan)</span> ដែល​ភ្ជាប់​នឹង​អត្រា​ការ​ប្រាក់​ជាមួយ​ភាគី <span class="text-bold">“អ្នកលក់”</span> នៅ​ពេល​ដែល​សំណង់​អចលនវត្ថុ​សាងសង់​បាន​ចាប់ពី៧០% (ចិតសិបភាគរយ) ឡើង​ទៅ ភាគី <span class="text-bold">“អ្នកលក់”</span> សូម​រក្សា​សិទ្ធិ​ក្នុង​ការ​ចាត់​ចែង​បញ្ជូន​សិទ្ធិ​លើ​បំណុល​ដែល​ភាគី <span class="text-bold">“អ្នកទិញ”</span> មាន​ដោយ​ការ​បង់​រម្លស់​ជាមួយ ភាគី <span class="text-bold">“អ្នកលក់”</span> ឲ្យ​ទៅ​ធនាគារ​ណា​មួយ​ដែល​សហការ​ជាមួយ​ភាគី <span class="text-bold">“អ្នកលក់”</span> ហើយ​សេវា​ក្នុង​ការ​សិក្សា​ជា​មួយ​ធនាគារ​ទាំងនោះ គឺ​ជា​បន្ទុក​របស់​ភាគី <span class="text-bold">“អ្នកទិញ”</span>។</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៤៖ ការសន្យាប្រគល់អចលនវត្ថុ</p>
<p>ភាគី <span class="text-bold">“អ្នកលក់”</span> សន្យា​នឹង​ប្រគល់​អចលនវត្ថុ​ជូន​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ក្នុង​រយៈ​ពេល <span class="text-bold">{{ $contract->deadline_km }} ({{ $contract->deadline_in_word_km }}) ខែ​</span> ដោយ​រាប់​ចាប់​ពី​កាលបរិច្ឆេទ​ចុះ​កិច្ចសន្យា​លក់ទិញ​នេះ។ ក្នុង​ករណី​ដែល​មាន​ការ​យឺត​យ៉ាវ ឬ​ខកខាន​ក្នុង​​ការ​ប្រគល់​អចលនវត្ថុ​ជូន ភាគី <span class="text-bold">“អ្នកទិញ”</span> ភាគី <span class="text-bold">“អ្នកលក់”</span> សូម​រក្សា​សិទ្ធិ​ពន្យារ​ពេល​ថែម <span class="text-bold">{{ $contract->extended_deadline_km }} ({{ $contract->extended_deadline_in_word_km }}) ខែ​</span> បន្ថែម​ទៀត ជា​រយៈ​ពេល​អនុគ្រោះ ក្នុង​ការ​សន្យា​ប្រគល់​អចលនវត្ថុ​ជូន ភាគី <span class="text-bold">“អ្នកទិញ”</span>។ បើ​ផុត​រយៈ​ពេល​អនុគ្រោះ​ខាង​លើ​ហើយ ភាគី <span class="text-bold">“អ្នកលក់”</span> នៅ​តែ​មិន​ទាន់​មាន​អចលនវត្ថុ​គ្រប់លក្ខណៈ​បច្ចេកទេស​សំណង់​ជា​អចលនវត្ថុ​រួចរាល់ ឬ​សម្រេច (មានទ្វារ បង្អួច កញ្ចក់ លាបថ្នាំពណ៌ និងគ្រឿង​បង្គុំ​ផ្សេងៗ​រួចរាល់) ប្រគល់​ជូន​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ទេ  
    ភាគី <span class="text-bold">“អ្នកលក់”</span> សូមទទួលខុសត្រូវក្នុងការបង់សំណងពិន័យជូន ភាគី <span class="text-bold">“អ្នកទិញ”</span> ស្នើនឹងអត្រា ១% (មួយភាគរយ) នៃទឹកប្រាក់ដែលភាគី <span class="text-bold">“អ្នកទិញ”</span> បានទូទាត់បង់ជូនភាគី <span class="text-bold">“អ្នកលក់”</span> ក្នុងមួយខែ និងមានសុពលភាព​រាប់ចាប់ពីកាលបរិច្ឆេទដែលផុតកំណត់ (ចាប់ពីខែទី​{{ \App\Helpers\NumberFormat::convertToKhmerNumber($contract->deadline + $contract->extended_deadline + 1) }}​នៃការបង់ប្រាក់ឡើងទៅ) នៃកាលបរិច្ឆេទ​ដែលត្រូវប្រគល់​អចលនវត្ថុ​ជូនភាគី “អ្នកទិញ”។
    <!-- ភាគី <span class="text-bold">“អ្នកលក់”</span> សូម​ទទួល​ខុស​ត្រូវ​ក្នុង​ការ​បង់​សំណង​ពិន័យ​ជូន ភាគី <span class="text-bold">“អ្នកទិញ”</span> ស្មើនឹងអត្រា ១% (មួយភាគរយ) ក្នុង​មួយ​ខែ នៃ​ប្រាក់​ដែល​ភាគី <span class="text-bold">“អ្នកទិញ”</span> បាន​ទូ​ទាត់​បង់​ជូន​ភាគី <span class="text-bold">“អ្នកលក់”</span> រាប់​ចាប់​ពី​កាលបរិច្ឆេទ​ដែល​ផុត​កំណត់​ត្រូវ​ប្រគល់​អចលនវត្ថុ​ជូនភាគី <span class="text-bold">“អ្នកទិញ”</span>។  -->

    គូ​ភាគី​បាន​សន្មត់ និង​ព្រម​ព្រៀង​គ្នា​ជា​មុន​ថា​នៅ​កាលបរិច្ឆេទ​ដែល​ភាគី <span class="text-bold">“អ្នកលក់”</span> បាន​ជូន​ដំណឹង​ស្តី​ពី​ការ​ត្រួត​ពិនិត្យ និងទទួល​អចលនវត្ថុ​ដែល​គ្រប់​លក្ខណៈបច្ចេកទេស​សំណង់​ជា​អចលនវត្ថុ​រួចរាល់ ឬសម្រេច ទោះ​បី​ជា​តាម​រយៈ​ទូរស័ព្ទ​ក្តី សារ​អេឡិចត្រូនិច​ក្តី លិខិត​ជូន​ផ្ទាល់​ដៃ​ក្តី ការ​ជូន​ដំណឹង​ទៅ​លំនៅឋានក្តី ឬលិខិត​ជូន​តាម​ប្រៃសណីយ៍ក្តី ពោល​គឺ​តាម​វិធីសាស្ត្រ​ណា​មួយ​ដែល​សមស្រប​ដែលភាគី <span class="text-bold">“អ្នកទិញ”</span> អាច​ជ្រាប​ជា​ដំណឹង​បាន គឺ​មាន​ន័យ​ថា ភាគី <span class="text-bold">“អ្នកលក់”</span> មាន​អចលនវត្ថុ​ប្រគល់​ជូន ភាគី <span class="text-bold">“អ្នកទិញ”</span> នៅ​កាលបរិច្ឆេទ​នោះ​តែម្តង (ក្នុង​ករណី​ដែល​មាន​ការ​ស្នើ​សុំ​កែ​លម្អ ឬ​ជួស​ជុល​ការងារ​បច្ចេកទេស​បន្តិច​បន្ទួច​ផ្នែក​ខាង​ក្នុង ឬ​ខាង​ក្រៅ​អចលនវត្ថុ ដូច​ជាកា​រ៉ូ ថ្នាំ​លាប ប្រឡាក់​កញ្ចក់ ប្រេះ​ស៊ីម៉ងត៍បៀក ។ល។ មិន​ត្រូវ​បាន​ចាត់​ទុក​ថា ភាគី <span class="text-bold">“អ្នកលក់”</span> មិន​ទាន់​មាន​អចលនវត្ថុ​សម្រាប់​ប្រគល់​ជូន ភាគី <span class="text-bold">“អ្នកទិញ”</span> ឡើយ)។ ដោយ​ឡែក ប្រសិន​បើ​ភាគី <span class="text-bold">“អ្នកលក់”</span> បាន​បញ្ចប់​ការ​សាង​សង់​អចលនវត្ថុ​មុន​កាល​កំណត់ ភាគី <span class="text-bold">“អ្នកលក់”</span> នឹង​ធ្វើ​ការ​ជូន​ដំណឹង​ទៅ​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ស្តី​ពី​ការ​ត្រួត​ពិនិត្យ និង​ទទួល​អចលនវត្ថុ​មុន​កាល​កំណត់ ហើយ​ភាគី <span class="text-bold">“អ្នកទិញ”</span> មិន​ត្រូវ​យឺត​យ៉ាវ​ក្នុង​ការ​មក​ពិនិត្យ និងទទួល​ឡើយ បើ​មិន​ដូច​នោះ​ទេ ភាគី <span class="text-bold">“អ្នកលក់”</span> នឹង​មិន​ទទួល​ខុសត្រូវ ចំពោះ​ការ​យឺត​យ៉ាវ ឬខក​ខាន​ណា​មួយ​ជាយថាហេតុ​នៅ​ពេល​បន្ទាប់​ពីនោះ​ឡើយ។ ទាក់​ទង​នឹង​ការ​ប្រគល់​ទទួល​អចលនវត្ថុនេះ ភាគី <span class="text-bold">“អ្នកទិញ”</span> អាច​ទទួល​អចលនវត្ថុ​បាន​លុះ​ត្រាតែ <span class="text-bold">(១).</span> ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​ទូទាត់​ប្រាក់​ដែល​នៅ​ជំពាក់ និង​ប្រាក់​ពិន័យ​លើ​ការ​យឺត​យ៉ាវ ឬ​ខក​ខាន​នោះ​ឲ្យ​រួច​រាល់​ជា​មុន​សិន និង <span class="text-bold">(២).</span> ត្រូវ​បង់​ប្រាក់​ថ្លៃ​សេវា​គ្រប់​គ្រង​ថែ​ទាំ​បុរី​ដូច​មាន​ចែង​ក្នុង​ <span class="text-bold">ប្រការ៦</span> ជូន​ភាគី <span class="text-bold">“អ្នកលក់”</span> សម្រាប់​រយៈ​ពេល​មួយ​ឆ្នាំ​ពេញ។ ចំពោះ​អចលនវត្ថុ​ដែល​ជា​កម្មវត្ថុ​នៃ​ការ​លក់​ទិញ​ណា​មួយ ដែល​ភាគី <span class="text-bold">“អ្នកទិញ”</span> មិន​ទាន់​បាន​ទូទាត់​ថ្លៃលក់ទិញ​រួច​រាល់​ទាំង​ស្រុង​ជូន ភាគី <span class="text-bold">“អ្នកលក់”</span> ទេ ភាគី <span class="text-bold">“អ្នកទិញ”</span> នោះ​មិន​ទាន់​ក្លាយ​ជា​ម្ចាស់​អចលនវត្ថុ​ពេញ​លេញ និង​ស្រប​ច្បាប់​ឡើយ ទោះ​បី​ជា​ភាគី <span class="text-bold">“អ្នកលក់”</span> បាន​ប្រគល់​អចលនវត្ថុ​នោះជូន ភាគី <span class="text-bold">“អ្នកទិញ”</span> ក៏ដោយ។</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៥៖ ការកែប្រែសោភ័ណភាព និងប្លង់គោលលើអចលនវត្ថុនៃការលក់ទិញ</p>
<p>
    ភាគី <span class="text-bold">“អ្នកទិញ”</span> មិនមានសិទ្ធិកែប្រែសោភ័ណភាពសំណង់ និង/ឬប្លង់គោលលើអចលនវត្ថុនៃការលក់ទិញឡើយ លុះត្រាតែមានការអនុញ្ញាតពី ភាគី <span class="text-bold">“អ្នកលក់”</span>។ ការកែប្រែសោភ័ណភាពសំណង់ និង/ឬ   ប្លង់គោលលើអចលនវត្ថុនៃការលក់ទិញដោយគ្មានការអនុញ្ញាតពីភាគី <span class="text-bold">“អ្នកលក់”</span> ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវទទួលខុសត្រូវចំពោះមុខច្បាប់ជាធរមាន និងធានាលើវិការៈសំណង់ផ្ទាល់ខ្លួន។
</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៦៖ ការគ្រប់គ្រងថែទាំ និងថ្លៃសេវាថែទាំគ្រប់គ្រងបុរី</p>
<p>បន្ទាប់​ពី​ប្រគល់​អចលនវត្ថុ​នៃ​ការ​លក់ទិញ​ជូន​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ភាគី <span class="text-bold">“អ្នកលក់”</span> មាន​កាតព្វកិច្ច​ក្នុង​ការ​ផ្តល់​ជូន​នូវ​សេវា​គ្រប់​គ្រង​ថែទាំ​បុរី ដែល​មាន​ដូច​ជា​សេវា​សន្តិសុខ​សណ្តាប់​ធ្នាប់ ២៤ម៉ោងលើ២៤ម៉ោង  អនាម័យសាធារណៈ ភ្លើងបំភ្លឺតាមដងផ្លូវ ការថែទាំសួនច្បារ និង​ទ្រព្យ​សម្បត្តិ​សាធារណៈទាំង​ឡាយ​នៅ​ក្នុង​បរិវេណ​បុរី​ទាំង​មូល។ ក្នុង​ករណីនេះ ភាគី <span class="text-bold">“អ្នកទិញ”</span> មាន​កាតព្វកិច្ច​ទូទាត់​បង់​ថ្លៃ​សេវា​គ្រប់គ្រង​ថែទាំ​បុរី​ដូច​ចែង​ក្នុង​ <span class="text-bold">​ប្រការ១៖ អត្តសញ្ញាណ​នៃ​អចលនវត្ថុ​លក់​ទិញ និង​តម្លៃ​លក់​ទិញ</span> សម្រាប់​រយៈ​ពេល​មួយ​ឆ្នាំ​ម្តង ហើយ​ត្រូវ​បង់​មួយ​ឆ្នាំ​ទុក​ជា​មុន​ជូនទៅ ភាគី <span class="text-bold">“អ្នកលក់”</span> មុន​ពេល​ទទួល​អចលនវត្ថុ​ពី ភាគី <span class="text-bold">“អ្នកលក់”</span> ហើយ​សេវា​នេះ​គិត​ចាប់​ពី​កាល​បរិច្ឆេទ​ដែល ភាគី <span class="text-bold">“អ្នកទិញ”</span> ទទួល​យក​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញពី ភាគី <span class="text-bold">“អ្នកលក់”</span>។ ថ្លៃ​សេវា​ថែទាំ​គ្រប់គ្រង់​បុរី​នេះ អាច​ត្រូវ​បាន​កែប្រែ​នា​ពេល​ណា​មួយ​ខាង​មុខ​ដោយ​ស្រប​ទៅ​តាម​តម្លៃ​ទីផ្សារ​ជាក់​ស្តែង ហើយភាគី <span class="text-bold">“អ្នកលក់”</span> នឹង​ជូន​ដំណឹង​ជាសាធារណៈ​ទៅភាគី <span class="text-bold">“អ្នកទិញ”</span> ទាំង​អស់​ក្នុង​រយៈពេល <span class="text-bold">០១ (មួយ) ខែ​</span>មុន​ការ​កែប្រែ​តម្លៃ​នេះ​ចូល​ជាធរមាន។</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៧៖ ប័ណ្ណបញ្ជាក់សិទ្ធិលើកម្មសិទ្ធិនៃអចលនវត្ថុនៃការលក់ទិញ</p>
<p>ភាគី <span class="text-bold">“អ្នកលក់”</span> សន្យា​ថា​នឹង​ប្រគល់​ប័ណ្ណ​បញ្ជាក់​សិទ្ធិ​លើ​កម្មសិទ្ធិ​នៃ​អចលនវត្ថុ​នៃ​ការ​លក់ទិញ ជា​ប្រភេទ​ដូច​ចែង​ក្នុង​ <span class="text-bold">ប្រការ១៖ អត្តសញ្ញាណ​នៃ​អចលនវត្ថុ​លក់ទិញ និង​តម្លៃ​លក់​ទិញ</span> ជូនភាគី <span class="text-bold">“អ្នកទិញ”</span> បន្ទាប់​ពី​ភាគី <span class="text-bold">“អ្នកទិញ”៖</span> <span class="text-bold">(១).</span> បាន​ទទួល​យក​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ​ពី​ភាគី <span class="text-bold">“អ្នកលក់”</span> រួច​រាល់​ហើយ <span class="text-bold">(២).</span> បាន​ទូ​ទាត់​បង់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​រួច​រាល់​គ្រប់​ចំនួន​ជូនមក ភាគី <span class="text-bold">“អ្នកលក់”</span> ដូច​បាន​ចែង​ក្នុង​ឧបសម្ព័ន្ធទី១ <span class="text-bold">“តារាង​កាល​វិភាគ​នៃ​ការ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ” (៣).</span> មក​បំពេញ​បែប​បទ និង​ឯកសារ​គ្រប់គ្រាន់​ជូន​ភាគី <span class="text-bold">“អ្នកលក់”</span> ដើម្បី​រៀប​ចំ​ដាក់​ស្នើ ឬ​រៀប​ចំ​បែបបទ​រដ្ឋបាល​ជា​មួយ​មន្ត្រី​ជំនាញ​សុរិយោ​ដី​ដើម្បី​ស្នើ​ទៅ​តាម​នីតិ​វិធី​ច្បាប់ឲ្យ​បាន​ទាន់​ពេល​វេលា និង​រលូន​ជូន​ភាគី <span class="text-bold">“អ្នកទិញ”</span> (ប្រសិន​បើ​ត្រូវ​ការ)។ ទោះ​ជា​យ៉ាង​ណា​ក៏​ដោយ​ ប្រសិន​បើ​មាន​ការ​យឺត​យ៉ាវ​ក្នុង​ការ​សម្រេច និង​អនុញ្ញាត​ចេញ​ប័ណ្ណ​បញ្ជាក់​សិទ្ធិ​លើ​កម្មសិទ្ធិ​លើ​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ ដោយ​សារ​តែ​បញ្ហា​បច្ចេកទេស ឬ​រដ្ឋបាល​របស់​មន្ត្រី​សុរិយោដី ឬ​មន្ត្រី​មាន​សមត្ថកិច្ច​នោះ ភាគី <span class="text-bold">“អ្នកទិញ”</span> មិន​អាច​តវ៉ា ឬ​ទំលាក់​កំហុស​លើ​ភាគី <span class="text-bold">“អ្នកលក់”</span> ដែល​បាន​ប្រឹងប្រែង​អស់​ពី​សមត្ថភាព​ហើយ​នោះទេ។ ការ​ចំណាយ​លើ​ការ​រៀប​ចំ​ឯកសារ​ផ្ទេរ​សិទ្ធិ​លើ​កម្មសិទ្ធិ ដូច​ចែងក្នុង <span class="text-bold">ប្រការ១</span> បូក​រួម​នឹង​ការ​បង់​ពន្ធ​ប្រថាប់​ត្រា <span class="text-bold">៤% (បូនភាគរយ)</span> គឺ​ជាការ​ទទួល​ខុស​ត្រូវ​ដោយ​ផ្ទាល់​របស់ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ដោយ​ភាគី <span class="text-bold">“អ្នកលក់”</span> ជួយ​សម្រួល និង​រៀបចំ​ឯក​សារ​ពាក់​ព័ន្ធ​ជូន​ទៅ​តាម​ស្ថាន​ភាព​ជាក់ស្តែង។</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៨៖ ការទទួលខុសត្រូវបង់ពន្ធអចលនវត្ថុប្រចាំឆ្នាំរបស់គូភាគី</p>
<p><span class="text-bold">៨.១</span> ភាគី <span class="text-bold">“អ្នកលក់”</span> ទទួល​ខុស​ត្រូវ​ទាំង​ស្រុង​ចំពោះ​ការ​បង់​ពន្ធ​អចលនវត្ថុ​ប្រចាំ​ឆ្នាំ ឬ​បង់​ពន្ធ​ដី​មិន​បាន​បើ​ប្រាស់​ឬ​ពន្ធ​នានា​ពាក់​ព័ន្ធ​នឹង​អាជីវកម្ម​សាង​សង់​លំនៅឋាន​របស់​ខ្លួន​មុន​កាលបរិច្ឆេទ​នៃ​ការ​ប្រគល់​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ​ជូន​ទៅ​ភាគី <span class="text-bold">“អ្នកទិញ”</span>។</p>

<p><span class="text-bold">៨.២</span> ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​ទទួល​ខុស​ត្រូវ​លើ​ការ​បង់​ពន្ធ​អចលវត្ថុ​ប្រចាំ​ឆ្នាំ និង​ពន្ធ​ផ្សេង​ទៀត​ពាក់​ព័ន្ធ​នឹង​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ​ខាង​លើ​បន្ទាប់​ពី​កាល​បរិច្ឆេទ​ទទួល​យក​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ ពីភាគី <span class="text-bold">“អ្នកលក់”</span>។</p> 

<p class="khmer-title pb-0 mb-0">ប្រការ៩៖ ទាយាទ អ្នកស្នងមរតក និងអ្នកទទួលសិទ្ធិស្របច្បាប់</p>
<p>ក្នុង​ករណី​ដែល​មាន​ភាគី​ណា​មួយ មិន​អាច​អនុវត្ត​សិទ្ធិ និង​កាតព្វកិច្ច​របស់​ខ្លួន​បាន​ដោយ​មូលហេតុ​ណា​មួយ​បណ្តាល​មក​ពី មរណភាព ពិការភាព ឬ​អវត្តមាន​ជា​បណ្តោះ​អាសន្ន ឬ​អចិន្ត្រៃយ៍​នៅ​ក្នុង​ប្រទេស​នោះ រាល់​សិទ្ធិ និង​កាតព្វកិច្ច​ទាំង​អស់​របស់​ភាគី​នោះ​ដែល​ស្ថិត​ក្រោម​ខ្លឹមសារ​នៃ​កិច្ចសន្យា​នេះ ត្រូវ​បន្ត​ទៅ​ទាយាទ និង/ឬ អ្នក​ស្នង​មរតក និង/ឬអ្នកតំណាង​ស្រប​ច្បាប់​ណា​មួយ​របស់​ខ្លួន​ដោយ​ស្វ័យប្រវត្តិ។</p>

<p class="khmer-title pb-0 mb-0">ប្រការ១០៖ គោលការណ៍ស្ម័គ្រចិត្ត និងការព្រមព្រៀងនៃកិច្ចសន្យា</p>
<p>កិច្ចសន្យា​លក់​ទិញ​អចលនវត្ថុ​នេះ ត្រូវ​ធ្វើ​ឡើង​ដោយ​គ្មាន​ការ​គំរាម​កំហែង បង្ខិតបង្ខំ ឬ​មាន​បញ្ហា​ខុស​ច្បាប់​ណា​មួយ​ឡើយ ហើយ <span class="text-bold">គូភាគី</span> មាន​សមត្ថភាព​គ្រប់គ្រាន់​ក្នុង​ការ​ដឹង​លឺ ឬ​យល់​ដឹង បាន​អាន បានស្តាប់ និង​យល់​ព្រម​តាម​លក្ខខណ្ឌ​ទាំងឡាយ​នៃ​កិច្ចសន្យា​នេះ។ កិច្ចសន្យា​លក់​ទិញ​អចលនវត្ថុ​នេះ មាន​សុពលភាព​នា​កាលបរិច្ឆេទ​ដែល <span class="text-bold">គូភាគី</span> បាន​ផ្តិត​ស្នាម​មេដៃ និង​ចុះ​ត្រា​ក្រុមហ៊ុន​ដូច​ខាង​ក្រោម។ កិច្ចសន្យា​លក់ទិញ​អចលនវត្ថុ​នេះ​ធ្វើ​ឡើង​ជាភាសាខ្មែរ​ចំនួន <span class="text-bold">០២ (ពីរ)</span> ឯកសារ​ច្បាប់​ដើម ក្នុងនោះ ភាគី <span class="text-bold">“អ្នកលក់”</span> រក្សាទុក <span class="text-bold">០១ (មួយ)</span> ឯកសារ​ច្បាប់ដើម ហើយភាគី <span class="text-bold">“អ្នកទិញ”</span> រក្សាទុក <span class="text-bold">០១ (មួយ)</span> ឯកសារ​ច្បាប់​ដើម។ ឯកសារ​នីមួយៗ​មាន​សុពលភាព និង​អានុភាព​គតិយុត្តិ​ស្មើៗ និងដូចគ្នា។</p>
@endsection

@section('third')
<h4 class="khmer-title text-center">ឧបសម្ព័ន្ធទី៣៖</h4>
<h4 class="khmer-title text-center mb-4">“សម្ភារៈដែលភ្ជាប់បញ្ជូលក្នុងអចលនវត្ថុ”</h4>
{!! $contract->equipment_text !!}
<div style="page-break-after: always;"></div>
@endsection

@section('forth')
<h4 class="khmer-title text-center">ឧបសម្ព័ន្ធទី៤៖</h4>  
<h4 class="khmer-title text-center mb-4">“អត្តសញ្ញាណប័ណ្ណ ឬលិខិតឆ្លងដែនរបស់ភាគី អ្នកលក់ និងភាគី អ្នកទិញ”</h4>  

@if(array_key_exists('customer1_id_front',$attachment_array) || array_key_exists('customer2_id_front',$attachment_array))  
<p class="text-bold">- អត្តសញ្ញាណប័ណ្ណ អ្នកទិញ</p>
@endif
<div class="container">
    <div class="row my-4">
        <div class="col">
        @if(array_key_exists('customer1_id_front',$attachment_array))  
            <img src="{{ $attachment_array['customer1_id_front']['path'] }}" width="100%" class="img-fluid d-block">
        @endif
        </div>
        <div class="col">
        @if(array_key_exists('customer1_id_front',$attachment_array)) 
            <img src="{{ $attachment_array['customer1_id_back']['path'] }}" width="100%" class="img-fluid d-block">     
        @endif
        </div>
    </div>
</div>
<div class="container">
    <div class="row my-4">
        <div class="col">
        @if(array_key_exists('customer2_id_front',$attachment_array)) 
            <img src="{{ $attachment_array['customer2_id_front']['path'] }}" width="100%" class="img-fluid d-block">
        @endif
        </div>
        <div class="col">
        @if(array_key_exists('customer2_id_back',$attachment_array)) 
            <img src="{{ $attachment_array['customer2_id_back']['path'] }}" width="100%" class="img-fluid d-block">
        @endif
        </div>
    </div>
</div>
@if(array_key_exists('customer1_passort',$attachment_array) || array_key_exists('customer2_passort',$attachment_array))
<p class="text-bold">- លិខិតឆ្លងដែន អ្នកទិញ</p>
@endif
<div class="container">
    <div class="row my-4">      
    @if(array_key_exists('customer1_passort',$attachment_array))
        <div class="col-6">       
            <img src="{{ $attachment_array['customer1_passort']['path'] }}" width="100%" class="img-fluid">        
        </div>   
    @endif     
    @if(array_key_exists('customer2_passort',$attachment_array))
        <div class="col-6">
            <img src="{{ $attachment_array['customer2_passort']['path'] }}" width="100%" class="img-fluid">        
        </div>
    @endif
    </div>
</div> 
<p class="text-bold">- អត្តសញ្ញាណប័ណ្ណ អ្នកលក់</p> 
@if($sale_representative)
<div class="container">
    <div class="row my-4">
        <div class="col">      
            <img src="{{ $sale_representative->national_id_front_attachment_url }}" width="100%" class="img-fluid d-block">       
        </div>
        <div class="col">        
            <img src="{{ $sale_representative->national_id_back_attachment_url }}" width="100%" class="img-fluid d-block">
        </div>
    </div>
</div>
@endif
@endsection