@extends('admin.contract.template.v2.en.template')
@section('page_title', "Contract $contract->customer1_name")

@section('contract_type')
<h3 class="khmer-title text-center mt-3 mb-3">កិច្ចសន្យាលក់ ទិញផ្ទះក្នុង {{ $project->name }}</h3>
<h3 class="english text-center mt-3 mb-3">CONTRACT ON HOUSE SALE-PURCHASE IN {{ strtoupper($project->name_en) }}</h3>
@endsection

@section('praka')
<p class="khmer-title pb-0 mb-0">ប្រការ១៖ អត្តសញ្ញាណនៃអចលនវត្ថុលក់ទិញ និងតម្លៃលក់ទិញ</p>
<p class="text-bold english">Article 1: Identity of Immoveable Property and Sale-Purchase Price</p>
<p class="khmer"><span class="text-bold">១.១.</span> ភាគី <span class="text-bold">“អ្នកលក់”</span> គឺ​ជា​កម្មសិទ្ធិករ​ស្រប​ច្បាប់​លើ​អចលនវត្ថុ យល់​ព្រម​លក់ ហើយ ភាគី <span class="text-bold">“អ្នកទិញ”</span> យល់​ព្រម​ទិញ​នូវ​អចលនវត្ថុ​ដូច​មាន​ចែង​ក្នុង​តារាង​អត្តសញ្ញាណ​នៃ​អចលនវត្ថុ​លក់ទិញ និង​តម្លៃ​លក់​ទិញ​នេះ។</p>
<p class="english text-justify">1.1. “The seller” is the legal owner of the immoveable property and agrees to sell, and “the purchaser” agrees to purchase the immoveable property as stated in the table of identity of immoveable property and of the sale-purchase price.</p>
<p class="khmer page-break-before"><span class="text-bold">១.២.</span> តារាងអត្តសញ្ញាណនៃអចលនវត្ថុលក់ទិញ និងតម្លៃលក់ទិញ (“អចលនវត្ថុ”)៖</p>
<p class="english text-justify">1.2. Table of Identity of Immoveable Property and Sale-Purchase Price (“Immoveable Property”)</p>
<table class="table table-p-1 table-contract-bordered">
    <tr>
    	<td width="180px" class="text-bold">
            <p class="khmer my-0 py-0">ប្រភេទ</p>
            <p class="english my-0 py-0">Type</p>
        </td>
    	<td width="30px" class="text-center">៖</td>      
    	<td><span class="text-`bold english">{{ $unit_type->name }}</span></td>
    	<td width="100px" class="text-bold">
            <p class="khmer my-0 py-0">លេខ</p>
            <p class="english my-0 py-0">No.</p>
        </td>
    	<td width="30px" class="text-center">៖</td>
    	<td width="250px" class="english text-bold">{{ isset($is_template) ? '_______________' : $unit->code }}</td>
    </tr>
    <tr>
    	<td width="180px" class="text-bold">
            <p class="khmer my-0 py-0">ទំហំសំណង់</p>
            <p class="english my-0 py-0">Size of the Construction</p>
        </td>
    	<td width="30px" class="text-center">៖</td>      
    	<td>
    		<p class="khmer">
    		@if( isset($is_template) )
    			_______________
    		@else
                @if($unit->building_size_width)
    			ទទឹង {{ $unit->building_size_width_km }} ម៉្រែត និង បណ្តោយ {{ $unit->building_size_length_km }} ម៉្រែត
                @else
                សុរប {{ $unit->building_area_km }} ម៉ែត្រការ៉េ
                @endif
    		@endif
    		</p>

            <p class="english">
            @if( isset($is_template) )
                _______________
            @else
                @if($unit->building_size_width)
                Width: {{ $unit->building_size_width }} meter, Length: {{ $unit->building_size_length }} meter
                @else
                Total Area: {{ $unit->building_area_km }} square meter
                @endif
            @endif
            </p>

    	</td>
    	<td width="100px" class="text-bold">
            <p class="khmer my-0 py-0">ទំហំដី</p>
            <p class="english my-0 py-0">Size of the land</p>
        </td>
    	<td width="30px" class="text-center">៖</td>
    	<td width="250px">
    		<p class="khmer pb-0">
    		@if( isset($is_template) )
    			_______________
    		@else
                @if( $unit->land_size_width AND $unit->land_size_length )
    			ទទឹង {{ $unit->land_size_width_km }} ម៉្រែត និង បណ្តោយ {{ $unit->land_size_length_km }} ម៉្រែត
                @else
                សុរប {{ $unit->land_area_km }} ម៉ែត្រការ៉េ
                @endif
    		@endif
    		</p>
            <span><small><i class="khmer">(ដែល​អាច​មាន​ការ​ប្រែប្រួល​បន្តិច​បន្ទួច ជា​លក្ខណៈ​បច្ចេកទេស អាស្រ័យ​លើ​ការ​កំណត់​ព្រុំ​របស់​មន្ត្រី​សុរិយោដី)</i></small></span>

            <p class="english">
            @if( isset($is_template) )
                _______________
            @else
                @if( $unit->land_size_width AND $unit->land_size_length )
                Width: {{ $unit->land_size_width }} meter, Lenght: {{ $unit->land_size_length }} meter
                @else
                Total Area: {{ $unit->land_area }} square meter
                @endif
            @endif
            </p>
            <p class="english">(Which can be slighly changed due to technical issue; according to border marking by the Cadaster Officer)</p>
    		
    	</td>
    </tr>
    <tr>
        <td width="180px" class="text-bold">
            <p class="khmer my-0 py-0">ទីតាំងគម្រោង</p>
            <p class="english my-0 py-0">Location of the Project</p>
        </td>
        <td width="30px" class="text-center">៖</td>      
        <td colspan="4">
            <p class="khmer my-0 py-0">{{ $project->address }}</p>
            <p class="english my-0 py-0">{{ $project->address_en }}</p>
        </td>
    </tr>
    <tr>
    	<td width="180px" class="text-bold">
            <p class="khmer my-0 py-0">សេវា និងថ្លៃគ្រប់គ្រងថែទាំ</p>
            <p class="english my-0 py-0">Management and Maintenance Service and Fees</p>
        </td>
    	<td width="30px" class="text-center">៖</td>      
    	<td colspan="4">
    		<p class="khmer pb-0">
    			{{
    			\App\Helpers\NumberFormat::convertToKhmerNumber(number_format($contract->annual_management_fee)) 
    			}} 
    			({{
    			\App\Helpers\NumberFormat::covertUsdToKhmerWord($contract->annual_management_fee, false) 
    			}}) ដុល្លារអាមេរិកក្នុងមួយឆ្នាំ
    		</p>
            <span><small><i class="khmer">ដោយត្រូវបង់សរុបមួយឆ្នាំម្តងៗ ដូចមានចែងលម្អិតក្នុងប្រការ ៦ នៃកិច្ចសន្យានេះ។ </i></small></span>
            <p class="english pb-0">
                {{ number_format($contract->annual_management_fee,0) }} ({{ numfmt_create('en', \NumberFormatter::SPELLOUT)->format($contract->annual_management_fee) }}) US dollars per year
             
            </p>
            <span><small><i class="english">by making a total payment once a year, as stated in detail in Article 6 of this contract.</i></small></span>
    		
    	</td>
    </tr>
    <tr>
    	<td width="180px" class="text-bold">
            <p class="khmer my-0 py-0">ការផ្តល់ជូនសេវាបន្ថែម</p>
            <p class="english my-0 py-0">Provision of Additional Service</p>
        </td>
    	<td width="30px" class="text-center">៖</td>      
    	<td colspan="4">
            <p class="khmer my-0 py-0">{{ $contract->management_service_kh }}</p>
            <p class="english my-0 py-0">{{ $contract->management_service_en}}</p>
    	</td>
    </tr>
    <tr>
    	<td width="180px" class="text-bold">
            <p class="khmer my-0 py-0">ប្រភេទ​នៃ​ប័ណ្ណ​កម្មសិទ្ធិ​ដែល​ប្រគល់​ជូន​ភាគី “អ្នកទិញ”</p>
            <p class="english my-0 py-0">Type of Title Deed Provided to “the Purchaser”</p>
        </td>
    	<td width="30px" class="text-center">៖</td>      
    	<td colspan="4">
            <p class="khmer my-0 py-0"> {{ $contract->title_clause_kh }}</p>
            <p class="english my-0 py-0">{{ $contract->title_clause_en }}</p>
    	</td>
    </tr>
    <tr>
    	<td width="180px" class="text-bold">
            <p class="khmer my-0 py-0">បន្ទប់គេង</p>
            <p class="english my-0 py-0">Room</p>
        </td>
    	<td width="30px" class="text-center">៖</td>      
    	<td>{{  isset($is_template) ? '_______' : $unit->bedroom ? $unit->bedroom : 'ពុំមាន' }}</td>
    	<td width="100px" class="text-bold">
            <p class="khmer my-0 py-0">ផ្ទះបាយ</p>
            <p class="english my-0 py-0">Kitchen</p>
        </td>
    	<td width="30px" class="text-center">៖</td>
    	<td width="250px">{{ isset($is_template) ? '_______' : $unit->kitchen ? $unit->kitchen : 'ពុំមាន' }}</td>
    </tr>
    <tr>
    	<td width="180px" class="text-bold">
            <p class="khmer my-0 py-0">បន្ទប់ទឹក</p>
            <p class="english my-0 py-0">Toilet</p>
        </td>
    	<td width="30px" class="text-center">៖</td>      
    	<td>{{  isset($is_template) ? '_______' : $unit->bathroom ? $unit->bathroom : 'ពុំមាន' }}</td>
    	<td width="100px" class="text-bold">
            <p class="khmer my-0 py-0">បន្ទប់ទទួលភ្ញៀវ</p>
            <p class="english my-0 py-0">Living room</p>
        </td>
    	<td width="30px" class="text-center">៖</td>
    	<td width="250px">{{  isset($is_template) ? '_______' : $unit->living_room ? $unit->living_room : 'ពុំមាន' }}</td>
    </tr>
	@if( $unit->swimming_pool )
	<tr>
		<td width="180px" class="text-bold">
            <p class="khmer my-0 py-0">អាងហែលទឹក</p>
            <p class="english my-0 py-0">Swimming pool</p>
        </td>
		<td width="30px" class="text-center">៖</td>
		<td colspan="4">{{ isset($is_template) ? '_______' : $unit->swimming_pool ? $unit->swimming_pool : 'ពុំមាន' }}</td>
	</tr>
	@endif
    <tr>
    	<td width="180px" class="text-bold">
            <p class="khmer my-0 py-0">តម្លៃលក់ទិញ</p>
            <p class="english my-0 py-0">Sale-Purchase Price</p>
        </td>
    	<td width="30px" class="text-center">៖</td>
    	<td class="text-bold" colspan="4">
    		@if( isset($is_template) )
    			_______________ ( _______________ ) 
    		@else
            <p class="khmer my-0 py-0">{{ $contract->unit_sale_price_after_discount_km }} ({{ $contract->unit_sale_price_after_discount_in_word_km }}) ដុល្លារ​​​អាមេរិច</p>
            <p class="english my-0 py-0">{{ number_format($contract->getUnitSoldPriceAfterDiscount(),0) }} ({{ numfmt_create('en', \NumberFormatter::SPELLOUT)->format($contract->getUnitSoldPriceAfterDiscount()) }}) US Dollars</p>
    		@endif
			
		</td>    
    </tr>
</table>

<p class="khmer-title pb-0 mb-0">ប្រការ២៖ ការទូទាត់ប្រាក់ថ្លៃលក់ទិញអចលនវត្ថុ</p>
<p class="text-bold english">Article 2: Payment of Immoveable Property Sale-Purchase Price</p>
<p class="khmer"><span class="text-bold">២.១.</span> ដោយ​មាន​ការ​ព្រមព្រៀង​គ្នា​ក្នុង​ការ​លក់​ទិញ នូវ​អចលនវត្ថុ​ដូច​បាន​ចែង​ក្នុង​ <span class="text-bold">ប្រការ១ “អត្តសញ្ញាណ​នៃ​អចលនវត្ថុ​លក់​ទិញ និងតម្លៃ​លក់​ទិញ”</span> ខាងលើ ភាគី <span clas="text-bold">“អ្នកទិញ”</span> ត្រូវ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ខាង​លើ​ទៅ​តាម​ដំណាក់កាល​នៃ​ការ​ទូទាត់​ឲ្យ​បាន​ត្រឹមត្រូវ គ្រប់​ចំនួន​ និង​ទាន់​ពេល​វេលា​ជា​បន្ត​បន្ទាប់​ដូច​បាន​ចែង​ក្នុង​ឧបសម្ព័ន្ធទី១ <span class="text-bold">“តារាងកាលវិភាគ​នៃ​ការ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ”</span>។ ភាគី <span class="text-bold">“អ្នកទិញ”</span> អាច​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ដោយ​ផ្ទាល់​នៅ​ការិយាល័យ​របស់​ភាគី <span class="text-bold">“អ្នកលក់”</span> ឬ​តាម​រយៈ​គណនី​ធនាគារ <span class="text-bold">{{ $bank->short_name }}</span> ដូច​មាន​ព័ត៌មាន​លម្អិត​ខាង​ក្រោមនេះ៖</p>
<p class="english text-justify">2.1. With mutual agreement to sale-purchase of the immoveable property as stated in Article 1 “Identity of the Immoveable Property and Sale-Purchase Price” above, “the purchaser” shall continuously make payment of the sale-purchase price of the said immoveable property in installments in proper manner, in full amount and in timely manner, as stated in Annex 1 “Schedule of Payment of Sale-Purchase Price of the Immoveable Property”. “The purchaser” shall be entitled to make payment of the sale-purchase price of the immoveable property at the office of “the seller” directly or via an account at ABA Bank with the following details:</p>
<div class="row">
	<div class="col-8 offset-2 mb-3">
		<table class="table table-p-1 table-bordered ">
			<tr>
				<th>
                    <p class="khmer text-center my-0 py-0">ឈ្មោះគណនីធនាគារ</p>
                    <p class="text-center english my-0 py-0">Bank Account Name</p>
                </th>
				<th class="text-center">
                    <p class="khmer text-center my-0 py-0">លេខគណនីធនាគារ</p>
                    <p class="text-center english my-0 py-0">Bank Account Number</p>
                </th>
			</tr>	
			<tr>
				<td class="text-center english">{{ $bank->account_name }}</td>
				<td class="text-center english">{{ $bank->account_number }}</td>
			</tr>
		</table>
	</div>
</div>

<p class="khmer"><span class="text-bold">២.២.</span> ភាគី <span class="text-bold">“អ្នកលក់”</span> អនុគ្រោះ​ជូនភាគី <span class="text-bold">“អ្នកទិញ”</span> ក្នុង​ការ​យឺតយ៉ាវ ឬ​ខក​ខាន​ទូទាត់​ប្រាក់ថ្លៃ​លក់ទិញ​អចលនវត្ថុ​ត្រឹមរយៈពេល <span class="text-bold">០៧ (ប្រាំពីរ) ថ្ងៃប្រតិទិន</span> ដោយ​មិន​បង់​ប្រាក់​ពិន័យ។ ផុត​ពី​រយៈ​ពេល​អនុគ្រោះ​នេះ ក្នុង​ករណី​ដែល​ភាគី <span class="text-bold">“អ្នកទិញ”</span> យឺតយ៉ាវ ឬ​ខកខាន​មិន​បាន​បំពេញ​កាតព្វកិច្ច​ទូទាត់​បង់ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ជូន​ភាគី <span class="text-bold">“អ្នកលក់”</span> ទៅ​តាម​ដំណាក់​កាល​នៃ​ការ​ទូទាត់​ឲ្យ​បាន​ត្រឹមត្រូវ គ្រប់ចំនួន និង​ទាន់​ពេល​វេលា​ទេ​នោះ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​បង់​ប្រាក់​ពិន័យ​លើ​ការ​យឺតយ៉ាវ ឬ​ខក​ខាន​នោះ​ក្នុង​មួយថ្ងៃ <span class="text-bold">០៥ (ប្រាំ) ដុល្លារ​អាមេរិក</span>។ ក្នុង​ករណី​ដែល​ការ​យឺតយ៉ាវ ឬ​ខក​ខាន​ក្នុង​ការ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​នោះ​នៅ​តែ​បន្ត​លើសពី រយៈពេល <span class="text-bold">០២ (ពីរ) ខែ</span>​ជាប់ៗ​គ្នា ឬ​ក្នុង​ចន្លោះ​រយៈ​ពេល​ណា​មួយ​ដែល​ផល​បូក​នៃ​រយៈ​ពេល​ទាំង​នោះ​លើស​ពី <span class="text-bold">០២ (ពីរ) ខែ</span> នោះ​ត្រូវ​បាន​សន្មត់ទុក​ជា​មុន និង​ចាត់​ទុក​ថា ភាគី <span class="text-bold">“អ្នកទិញ”</span> រំលាយ​កិច្ចសន្យា​ដោយ​ឯកតោ​ភាគី ដោយ​បោះបង់​ចោល​នូវ​សិទ្ធិ​ទាំង​ឡាយ​ដែល​មាន​លើអចលនវត្ថុ ការ​លក់​ទិញ​អចលនវត្ថុ និង​ចំនួន​ទឹក​ប្រាក់​ដែល​ខ្លួន​បាន​ទូទាត់​មក​ឲ្យ​ភាគី <span class="text-bold">“អ្នកលក់”</span>។ ក្នុង​ករណី​នេះ ទឹក​ប្រាក់​ដែល​បាន​ទូទាត់​ហើយ​ទាំងអស់​ត្រូវ​ក្លាយ​ជា​ប្រយោជន៍​សម្រាប់​ភាគី <span class="text-bold">“អ្នកលក់”</span> ហើយ ភាគី <span class="text-bold">“អ្នកលក់”</span> មាន​សិទ្ធិ​ពេញ​លេញ​ដោយ​ស្រប​ច្បាប់​ក្នុង​ការ​លក់​អចលនវត្ថុ​ខាង​លើ​ឲ្យ​ទៅ​អតិថិជន ឬ​អ្នក​ទិញ​ផ្សេង​ទៀត​បាន ដោយ​ភាគី <span class="text-bold">“អ្នកទិញ”</span> សន្យា​ថា​នឹង​មិន​តវ៉ា ឬ​ជំទាស់​ឡើយ។ ក្នុង​ករណី​នេះ ប្រសិន​បើ ភាគី <span class="text-bold">“អ្នកទិញ”</span> បាន​ទទួល​យក​អចលនវត្ថុ​ពី ភាគី <span class="text-bold">“អ្នកលក់”</span> ហើយនោះ ភាគី <span class="text-bold">“អ្នកលក់”</span> ទុក​រយៈ​ពេល​ឲ្យ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ដែល​បោះបង់​សិទ្ធិ​លើ​ការ​លក់​ទិញ និង​អចលនវត្ថុ​នោះ <span class="text-bold">០១ (មួយ) ខែ</span> សម្រាប់​រើចេញ​ពី​អចលនវត្ថុ។</p>
<p class="english text-justify">2.2. “The seller” gives “the purchaser” a grace period for delay or failure to make payment of the sale-purchase price of the immoveable property by 7 (seven) calendar days without paying a fine. After this grace period, should “the purchaser” delay or fail to fulfill the obligation of making payment of the sale-purchase price of the immoveable property to “the seller” as per the installment plan in proper manner, in full amount and in timely manner, “the purchaser” shall pay a fine for the said delay or failure at an amount of 5 (five) US dollars per day. In case the said delay or failure to make payment of the sale-purchase price of the immoveable property continues for more than 2 (two) consecutive months or at any periods, which the sum of those periods is more than 2 (two) months, it shall be assumed and deemed that “the purchaser” unilaterally dissolves the contract by waiving all existing rights over the immoveable property and the amount of money which he/she has made payment to “the seller”. In such case, all the amount of money which has already been paid shall become the benefit of “the seller”, and “the seller” shall have absolute and legal right to sell the said immoveable property to other customer or purchaser, which “the purchaser” pledges not to make a protest or an objection. In such case, should “the purchaser” have already accepted the immoveable property from “the seller”, “the seller” shall give “the purchaser” who abandons his/her right over the sale-purchase and the said immoveable property a 1 (one)-month period for moving out of the immoveable property.</p>
<p class="khmer-title pb-0 mb-0">ប្រការ៣៖ ការលក់ ឬផ្ទេរសិទ្ធិលើការលក់ទិញអចលនវត្ថុបន្តទៅតតិយជន និងឥណទានពីធនាគារ</p>
<p class="english">Article 3: Resale or Retransfer of Right over the Sale-Purchase of the Immoveable Property to Third Party and Credit from Bank</p>

<p class="khmer"><span class="text-bold">៣.១.</span> ក្នុង​កំឡុង​ពេល​នៃ​ការ​អនុវត្ត​កិច្ចសន្យា​លក់​ទិញ​នេះ ភាគី <span class="text-bold">“អ្នកទិញ”</span> អាច​លក់ ឬ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ​អចលនវត្ថុ​ទៅ​ តតិយជន​ណា​មួយ​បាន​ដោយ​ការ​ស្នើ​សុំ​ជា​លាយ​លក្ខណ៍​អក្សរ ហើយ​ទទួល​បាន​ការ​អនុញ្ញាត​យល់​ព្រម​ពី​ភាគី <span class="text-bold">“អ្នកលក់”</span> ដោយភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​បង់​ថ្លៃ​សេវា​រដ្ឋបាល​លើ​ការ​លក់ ឬ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ អចលនវត្ថុ​នេះ​ស្មើ​នឹង <span class="text-bold">{{ $contract->contract_transfer_fee_km }} ({{ $contract->contract_transfer_fee_in_word_km }}) ដុល្លារ​អាមេរិក</span> ជូន​ភាគី <span class="text-bold">“អ្នកលក់”</span>។ មុន​នឹង​អាច​លក់ ឬ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ​អចលនវត្ថុ​ទៅ​តតិយជន​ណា​មួយ​បាន ប្រសិន​បើ​ភាគី <span class="text-bold">“អ្នកទិញ”</span> យឺតយ៉ាវ ឬ​ខក​ខន​មិន​បាន​បំពេញ​កាតព្វកិច្ច​ទូទាត់​បង់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ជូន​ភាគី <span class="text-bold">“អ្នកលក់”</span> ទៅ​តាម​ដំណាក់​កាល​នៃ​ការ​ទូទាត់​ឲ្យ​បាន​ត្រឹមត្រូវ គ្រប់ចំនួន និងទាន់​ពេល​វេលា​ដូច​ចែង​ក្នុង​ <span class="text-bold">ប្រការ២</span> នោះ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​ទូទាត់​ប្រាក់​ដែល​នៅ​ជំពាក់ និង​ប្រាក់​ពិន័យ​លើ​ការ​យឺត​យ៉ាវ ឬ​ខក​ខាន​នោះ​ឲ្យ​រួច​រាល់​ជា​មុន​សិន។ តតិយជន​ដែល​ទទួល​ទិញ ឬ​ទទួល​ការ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ​អចលនវត្ថុ​នេះ ត្រូវ​គោរព​តាម​ទាំង​ស្រុង​នូវ​ខ្លឹម​សារ​នៃ​កិច្ចសន្យា​លក់​ទិញ​នេះ ហើយ​អនុវត្ត​តាម​បែប​បទ​រដ្ឋបាល​មួយ​ចំនួន​ដែល​ភាគី <span class="text-bold">“អ្នកលក់”</span> តម្រូវ។</p>

<p class="english text-justify">3.1. During the implementation of this Sale-Purchase Contract, “the purchaser” can resell or retransfer his/her right over the sale-purchase of the immoveable property to any third party by making a written request and obtaining authorization and agreement from “the seller”, and “the purchaser” shall make payment of administrative service fee for the sale or transfer of right over the said immoveable property, equivalent to an amount of {{ $contract->contract_transfer_fee }} ({{ numfmt_create('en', \NumberFormatter::SPELLOUT)->format($contract->contract_transfer_fee) }}) US dollars to “the seller”. To be able to sell or transfer right over the sale-purchase of the immoveable property to any third party, should “the purchaser” delay or fail to fulfill the obligation of making payment of the sale-purchase price of the immoveable property to “the seller” as per the installment plan in proper manner, in full amount and in timely manner as stated in Article 2, “the purchaser” shall completely make payment of the outstanding amount and fine for such delay or failure first. The third party who purchases or accepts the right over the sale-purchase of the said immoveable property shall completely abide by the content of this Contract on Sale-Purchase and comply with some administrative formalities required by “the seller”.</p>

<p class="khmer"><span class="text-bold">៣.២.</span> ចំពោះ​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ដែល​ជ្រើស​រើស​ជម្រើស​បង់រម្លស់ <span class="english">(Loan)</span> ដែល​ភ្ជាប់​នឹង​អត្រា​ការ​ប្រាក់​ជាមួយ​ភាគី <span class="text-bold">“អ្នកលក់”</span> នៅ​ពេល​ដែល​សំណង់​អចលនវត្ថុ​សាងសង់​បាន​ចាប់ពី៧០% (ចិតសិបភាគរយ) ឡើង​ទៅ ភាគី <span class="text-bold">“អ្នកលក់”</span> សូម​រក្សា​សិទ្ធិ​ក្នុង​ការ​ចាត់​ចែង​បញ្ជូន​សិទ្ធិ​លើ​បំណុល​ដែល​ភាគី <span class="text-bold">“អ្នកទិញ”</span> មាន​ដោយ​ការ​បង់​រម្លស់​ជាមួយ ភាគី <span class="text-bold">“អ្នកលក់”</span> ឲ្យ​ទៅ​ធនាគារ​ណា​មួយ​ដែល​សហការ​ជាមួយ​ភាគី <span class="text-bold">“អ្នកលក់”</span> ហើយ​សេវា​ក្នុង​ការ​សិក្សា​ជា​មួយ​ធនាគារ​ទាំងនោះ គឺ​ជា​បន្ទុក​របស់​ភាគី <span class="text-bold">“អ្នកទិញ”</span>។</p>

<p class="english text-justify">3.2. For “the purchaser” who chooses making payment by mortgage (loan) bearing interest rate with “the seller”, upon the construction of the immoveable property is completed by 70% (seventy percent) or more, “the seller” reserves the right to arrange and transfer the right over any debt of “the purchaser” arising out of the payment by mortgage with “the seller” to any bank which cooperates with “the seller”, and service fee for conducting study of the property taken by that bank shall be the burden of “the purchaser”.</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៤៖ ការសន្យាប្រគល់អចលនវត្ថុ</p>
<p class="text-bold english">Article 4: Pledge to Hand Over the Immoveable Property</p>
<p class="khmer">ភាគី <span class="text-bold">“អ្នកលក់”</span> សន្យា​នឹង​ប្រគល់​អចលនវត្ថុ​ជូន​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ក្នុង​រយៈ​ពេល <span class="text-bold">{{ $contract->deadline_km }} ({{ $contract->deadline_in_word_km }}) ខែ​</span> ដោយ​រាប់​ចាប់​ពី​កាលបរិច្ឆេទ​ចុះ​កិច្ចសន្យា​លក់ទិញ​នេះ។ ក្នុង​ករណី​ដែល​មាន​ការ​យឺត​យ៉ាវ ឬ​ខកខាន​ក្នុង​​ការ​ប្រគល់​អចលនវត្ថុ​ជូន ភាគី <span class="text-bold">“អ្នកទិញ”</span> ភាគី <span class="text-bold">“អ្នកលក់”</span> សូម​រក្សា​សិទ្ធិ​ពន្យារ​ពេល​ថែម <span class="text-bold">{{ $contract->extended_deadline_km }} ({{ $contract->extended_deadline_in_word_km }}) ខែ​</span> បន្ថែម​ទៀត ជា​រយៈ​ពេល​អនុគ្រោះ ក្នុង​ការ​សន្យា​ប្រគល់​អចលនវត្ថុ​ជូន ភាគី <span class="text-bold">“អ្នកទិញ”</span>។ បើ​ផុត​រយៈ​ពេល​អនុគ្រោះ​ខាង​លើ​ហើយ ភាគី <span class="text-bold">“អ្នកលក់”</span> នៅ​តែ​មិន​ទាន់​មាន​អចលនវត្ថុ​គ្រប់លក្ខណៈ​បច្ចេកទេស​សំណង់​ជា​អចលនវត្ថុ​រួចរាល់ ឬ​សម្រេច (មានទ្វារ បង្អួច កញ្ចក់ លាបថ្នាំពណ៌ និងគ្រឿង​បង្គុំ​ផ្សេងៗ​រួចរាល់) ប្រគល់​ជូន​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ទេ  ភាគី <span class="text-bold">“អ្នកលក់”</span> សូម​ទទួល​ខុស​ត្រូវ​ក្នុង​ការ​បង់​សំណង​ពិន័យ​ជូន ភាគី <span class="text-bold">“អ្នកទិញ”</span> ស្មើនឹងអត្រា ១% (មួយភាគរយ) ក្នុង​មួយ​ខែ នៃ​ប្រាក់​ដែល​ភាគី <span class="text-bold">“អ្នកទិញ”</span> បាន​ទូ​ទាត់​បង់​ជូន​ភាគី <span class="text-bold">“អ្នកលក់”</span> រាប់​ចាប់​ពី​កាលបរិច្ឆេទ​ដែល​ផុត​កំណត់​ត្រូវ​ប្រគល់​អចលនវត្ថុ​ជូនភាគី <span class="text-bold">“អ្នកទិញ”</span>។ គូ​ភាគី​បាន​សន្មត់ និង​ព្រម​ព្រៀង​គ្នា​ជា​មុន​ថា​នៅ​កាលបរិច្ឆេទ​ដែល​ភាគី <span class="text-bold">“អ្នកលក់”</span> បាន​ជូន​ដំណឹង​ស្តី​ពី​ការ​ត្រួត​ពិនិត្យ និងទទួល​អចលនវត្ថុ​ដែល​គ្រប់​លក្ខណៈបច្ចេកទេស​សំណង់​ជា​អចលនវត្ថុ​រួចរាល់ ឬសម្រេច ទោះ​បី​ជា​តាម​រយៈ​ទូរស័ព្ទ​ក្តី សារ​អេឡិចត្រូនិច​ក្តី លិខិត​ជូន​ផ្ទាល់​ដៃ​ក្តី ការ​ជូន​ដំណឹង​ទៅ​លំនៅឋានក្តី ឬលិខិត​ជូន​តាម​ប្រៃសណីយ៍ក្តី ពោល​គឺ​តាម​វិធីសាស្ត្រ​ណា​មួយ​ដែល​សមស្រប​ដែលភាគី <span class="text-bold">“អ្នកទិញ”</span> អាច​ជ្រាប​ជា​ដំណឹង​បាន គឺ​មាន​ន័យ​ថា ភាគី <span class="text-bold">“អ្នកលក់”</span> មាន​អចលនវត្ថុ​ប្រគល់​ជូន ភាគី <span class="text-bold">“អ្នកទិញ”</span> នៅ​កាលបរិច្ឆេទ​នោះ​តែម្តង (ក្នុង​ករណី​ដែល​មាន​ការ​ស្នើ​សុំ​កែ​លម្អ ឬ​ជួស​ជុល​ការងារ​បច្ចេកទេស​បន្តិច​បន្ទួច​ផ្នែក​ខាង​ក្នុង ឬ​ខាង​ក្រៅ​អចលនវត្ថុ ដូច​ជាកា​រ៉ូ ថ្នាំ​លាប ប្រឡាក់​កញ្ចក់ ប្រេះ​ស៊ីម៉ងត៍បៀក ។ល។ មិន​ត្រូវ​បាន​ចាត់​ទុក​ថា ភាគី <span class="text-bold">“អ្នកលក់”</span> មិន​ទាន់​មាន​អចលនវត្ថុ​សម្រាប់​ប្រគល់​ជូន ភាគី <span class="text-bold">“អ្នកទិញ”</span> ឡើយ)។ ដោយ​ឡែក ប្រសិន​បើ​ភាគី <span class="text-bold">“អ្នកលក់”</span> បាន​បញ្ចប់​ការ​សាង​សង់​អចលនវត្ថុ​មុន​កាល​កំណត់ ភាគី <span class="text-bold">“អ្នកលក់”</span> នឹង​ធ្វើ​ការ​ជូន​ដំណឹង​ទៅ​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ស្តី​ពី​ការ​ត្រួត​ពិនិត្យ និង​ទទួល​អចលនវត្ថុ​មុន​កាល​កំណត់ ហើយ​ភាគី <span class="text-bold">“អ្នកទិញ”</span> មិន​ត្រូវ​យឺត​យ៉ាវ​ក្នុង​ការ​មក​ពិនិត្យ និងទទួល​ឡើយ បើ​មិន​ដូច​នោះ​ទេ ភាគី <span class="text-bold">“អ្នកលក់”</span> នឹង​មិន​ទទួល​ខុសត្រូវ ចំពោះ​ការ​យឺត​យ៉ាវ ឬខក​ខាន​ណា​មួយ​ជាយថាហេតុ​នៅ​ពេល​បន្ទាប់​ពីនោះ​ឡើយ។ ទាក់​ទង​នឹង​ការ​ប្រគល់​ទទួល​អចលនវត្ថុនេះ ភាគី <span class="text-bold">“អ្នកទិញ”</span> អាច​ទទួល​អចលនវត្ថុ​បាន​លុះ​ត្រាតែ <span class="text-bold">(១).</span> ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​ទូទាត់​ប្រាក់​ដែល​នៅ​ជំពាក់ និង​ប្រាក់​ពិន័យ​លើ​ការ​យឺត​យ៉ាវ ឬ​ខក​ខាន​នោះ​ឲ្យ​រួច​រាល់​ជា​មុន​សិន និង <span class="text-bold">(២).</span> ត្រូវ​បង់​ប្រាក់​ថ្លៃ​សេវា​គ្រប់​គ្រង​ថែ​ទាំ​បុរី​ដូច​មាន​ចែង​ក្នុង​ <span class="text-bold">ប្រការ៦</span> ជូន​ភាគី <span class="text-bold">“អ្នកលក់”</span> សម្រាប់​រយៈ​ពេល​មួយ​ឆ្នាំ​ពេញ។ ចំពោះ​អចលនវត្ថុ​ដែល​ជា​កម្មវត្ថុ​នៃ​ការ​លក់​ទិញ​ណា​មួយ ដែល​ភាគី <span class="text-bold">“អ្នកទិញ”</span> មិន​ទាន់​បាន​ទូទាត់​ថ្លៃលក់ទិញ​រួច​រាល់​ទាំង​ស្រុង​ជូន ភាគី <span class="text-bold">“អ្នកលក់”</span> ទេ ភាគី <span class="text-bold">“អ្នកទិញ”</span> នោះ​មិន​ទាន់​ក្លាយ​ជា​ម្ចាស់​អចលនវត្ថុ​ពេញ​លេញ និង​ស្រប​ច្បាប់​ឡើយ ទោះ​បី​ជា​ភាគី <span class="text-bold">“អ្នកលក់”</span> បាន​ប្រគល់​អចលនវត្ថុ​នោះជូន ភាគី <span class="text-bold">“អ្នកទិញ”</span> ក៏ដោយ។</p>

<p class="english text-justify">“The seller” pledges to hand over the immoveable property to “the purchaser” within a period of {{ $contract->deadline }} ({{ numfmt_create('en', \NumberFormatter::SPELLOUT)->format($contract->deadline) }}) months, from the date this Contract on Sale-Purchase is entered into. In case of delay or failure to hand over the immoveable property to “the purchaser”, “the seller” reserves the right to delay the construction period for another {{ $contract->extended_deadline }} ({{ numfmt_create('en', \NumberFormatter::SPELLOUT)->format($contract->extended_deadline) }}) months as a grace period of the pledge to hand over the immoveable property to “the purchaser”. Should the said grace period be elapsed, and “the seller” is still yet to have an immoveable property with complete technical specifications of the construction as the finished or completed immoveable property (with door, window, mirror, painting and other structures be completed) to be handed over to “the purchaser”, “the seller” shall bear responsibility for paying compensation and fine to “the purchaser” at a monthly rate of 1% (one percent) over the amount of money which “the purchaser” has paid to “the seller” from the deadline of handing over the immoveable property to “the purchaser”. The two parties have determined and reached a mutual agreement in advance that when “the seller” gives a notice on inspection and receipt of the immoveable property with complete construction technical specifications as a finished or complete immoveable property, whether via phone call, electronic mail, or by handing a letter, giving notice to a residence or posted mail; to wit, through any appropriate way which “the purchaser” can be informed, it is implied that “the seller” has the immoveable property to be handed over to “the purchaser” on that day (in case of request for renovation or repair of minor technical work inside or outside the immoveable property, such as tile, paint, any spot on the mirror, crack of coated cement, etc., it shall not be considered that “the seller” does not have an immoveable property to be handed over to “the purchaser” yet). Should “the seller” finishes the construction of the immoveable property earlier, “the seller” will give a notice to “the purchaser” on early inspection and receipt of the immoveable property, and “the purchaser” shall not delay the inspection and receipt; otherwise, “the seller” will not bear responsibility for any eventual delay or failure later. In relation to the handover and receipt of the said immoveable property, “the purchaser” can receive the immoveable property only if “the purchaser” (1) has completely made payment of the outstanding amount and fine for such delay or failure in advance before he/she is entitled to receive the immoveable property from “the seller”, and (2) has made advance payment of Borey management and maintenance service fees as stated in Article 6 to “the seller” for one year. As for the immoveable property which “the purchaser” has yet to completely pay off the sale-purchase price to “the seller”, “the purchaser” has yet to completely and legally become the owner of that immoveable property though “the seller” has handed over the said immoveable property to “the purchaser”.</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៥៖ ការធានាគុណភាពសំណង់ ការកែប្រែសោភ័ណភាព និងប្លង់គោលលើអចលនវត្ថុនៃការលក់ទិញ</p>
<p class="text-bold english">Article 5: Guarantee for Construction Quality, Change of Aesthetics and Master Plan of the Immoveable Property</p>
<p class="khmer"><span class="text-bold">៥.១.</span> ដោយ​រាប់​ចាប់​ពី​កាលបរិច្ឆេទ​ដែល​ភាគី <span class="text-bold">“អ្នកលក់”</span> ប្រគល់​អចលនវត្ថុ​នៃ​ការ​លក់ទិញ​ជូន​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ភាគី <span class="text-bold">“អ្នកលក់”</span> សូម​ធានា​វិការៈ (លើ​គុណភាព​គ្រោង​សំណង់ និង​ការ​បាក់​ស្រុត​គ្រឹះ​សំណង់) សម្រាប់​រយៈពេល <span class="text-bold">០៣ (បី) ឆ្នាំ</span> និង​ធានា​វិការៈ​បច្ចេកទេស​សំណង់​ទូទៅ​ដូច​ជា​ការ​ប្រះ​ស្រាំ​ស៊ីម៉ងត៍បៀក ឬជញ្ជាំង ការជ្រាបទឹក សម្រាប់​រយៈពេល <span class="text-bold">០១ (មួយ) ឆ្នាំ</span> (លើក​លែង​តែ​គ្រឿង​បំពាក់​ឈើ បើ​សិន​ជា​មាន​ផ្តល់​ជូន គឺ​មិន​មាន​ការ​ធានា​ជួស​ជុល ឬ​ប្តូរ​ថ្មី​ជូន​ឡើយ​)។ បរិក្ខា​អគ្គិសនី​ដែល​បំពាក់​ក្នុង​អចលនវត្ថុ ត្រូវ​បាន​ធានា​ដោយ​យោង​ទៅ​តាម​លក្ខខណ្ឌ​ដែល​បាន​កំណត់ ដោយ​រោង​ចក្រ​ផលិត ឬ​អ្នក​លក់​បរិក្ខា​នោះ។ ផ្ទុយ​ទៅ​វិញ ប្រសិន​បើ​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ធ្លាប់​បាន​ធ្វើ​ការ​ជួសជុល ឬ​ផ្លាស់​ប្តូរ​ទ្រង់​ទ្រាយ​សំណង់​លើ​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ​ដោយ​ខ្លួនឯង ឬ​មិន​សម្អាត​លើ​វ៉េរ៉ងដា ឬ​ឥដ្ឋ​កន្សែង​ជាន់​ដំបូល ឬ​រុះ​រើ​ដំបូល​សំណង់ ដែល​បណ្តាល​ឲ្យ​មាន​ការ​ជ្រាប​ទឹកនោះ ភាគី <span class="text-bold">“អ្នកលក់”</span> មិន​ធានា​វិការៈជូនឡើយ។</p>

<p class="english text-justify">5.1. From the date “the seller” hands over the immoveable property to “the purchaser”, “the seller” shall give warranty for defect (of the quality of construction structure and subsidence of the construction) for 3 (three) years and give warranty for defect of general construction technique, such as crack of coated cement or wall, water leakage for 1 (one) year (with exception of wooden fitting, should it be provided, there is no warranty for repair or replacement). For electrical appliance equipped in the immoveable property, there is warranty according to the condition set out by the manufacturer or seller of that appliance. However, if “the purchaser” used to carry it out repair or change any feature of the construction on the immoveable property by him/herself, or did not clean veranda or tile on the rooftop or removed roof of the construction leading to water leakage, “the seller” shall not give warranty for defect.</p>

<p class="khmer"><span class="text-bold">៥.២.</span> ភាគី <span class="text-bold">“អ្នកទិញ”</span> មិន​មាន​សិទ្ធិ​កែ​ប្រែ​សោភ័ណភាព​សំណង់ និង/ឬប្លង់គោល​លើ​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញឡើយ លុះត្រា​តែ​មាន​ការ​អនុញ្ញាត​ពី ភាគី <span class="text-bold">“អ្នកលក់”</span>។ ការ​កែប្រែ​សោភ័ណភាព​សំណង់ និង/ឬប្លង់គោល​លើ​អចលនវត្ថុ​នៃ​ការ​លក់ទិញ​ដោយ​គ្មាន​ការ​អនុញ្ញាត​ពី​ភាគី <span class="text-bold">“អ្នកលក់”</span> ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​ទទួល​ខុស​ត្រូវ​ចំពោះ​មុខ​ច្បាប់​ជាធរមាន ហើយ​ការ​ធានា​លើវិការៈ​សំណង់​ដូច​មាន​ចែង​ក្នុង <span class="text-bold">​ប្រការ៥.១</span> ខាងលើ លែង​មាន​អនុភាព​សម្រាប់ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ទៀតដែរ។</p>

<p class="english text-justify">5.2. “The purchaser” shall not be entitled to make change to aesthetics of the construction and/or master plan of the immoveable property unless there is an authorization from “the seller”. Should any change to aesthetics of the construction and/or master plan of the immoveable property be carried out without an authorization from “the seller”, “the purchaser” shall bear responsibility before the law in force, and the warranty for defect of the construction as stated in Article 5.1 above shall no longer take any effect for “the purchaser”.</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៦៖ ការគ្រប់គ្រងថែទាំ និងថ្លៃសេវាថែទាំគ្រប់គ្រងបុរី</p>
<p class="text-bold english">Article 6: Management and Maintenance and Borey Management and Maintenance Fees</p>
<p class="khmer">បន្ទាប់​ពី​ប្រគល់​អចលនវត្ថុ​នៃ​ការ​លក់ទិញ​ជូន​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ភាគី <span class="text-bold">“អ្នកលក់”</span> មាន​កាតព្វកិច្ច​ក្នុង​ការ​ផ្តល់​ជូន​នូវ​សេវា​គ្រប់​គ្រង​ថែទាំ​បុរី ដែល​មាន​ដូច​ជា​សេវា​សន្តិសុខ​សណ្តាប់​ធ្នាប់ ២៤ម៉ោងលើ២៤ម៉ោង  អនាម័យសាធារណៈ ភ្លើងបំភ្លឺតាមដងផ្លូវ ការថែទាំសួនច្បារ និង​ទ្រព្យ​សម្បត្តិ​សាធារណៈទាំង​ឡាយ​នៅ​ក្នុង​បរិវេណ​បុរី​ទាំង​មូល។ ក្នុង​ករណីនេះ ភាគី <span class="text-bold">“អ្នកទិញ”</span> មាន​កាតព្វកិច្ច​ទូទាត់​បង់​ថ្លៃ​សេវា​គ្រប់គ្រង​ថែទាំ​បុរី​ដូច​ចែង​ក្នុង​ <span class="text-bold">​ប្រការ១៖ អត្តសញ្ញាណ​នៃ​អចលនវត្ថុ​លក់​ទិញ និង​តម្លៃ​លក់​ទិញ</span> សម្រាប់​រយៈ​ពេល​មួយ​ឆ្នាំ​ម្តង ហើយ​ត្រូវ​បង់​មួយ​ឆ្នាំ​ទុក​ជា​មុន​ជូនទៅ ភាគី <span class="text-bold">“អ្នកលក់”</span> មុន​ពេល​ទទួល​អចលនវត្ថុ​ពី ភាគី <span class="text-bold">“អ្នកលក់”</span> ហើយ​សេវា​នេះ​គិត​ចាប់​ពី​កាល​បរិច្ឆេទ​ដែល ភាគី <span class="text-bold">“អ្នកទិញ”</span> ទទួល​យក​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញពី ភាគី <span class="text-bold">“អ្នកលក់”</span>។ ថ្លៃ​សេវា​ថែទាំ​គ្រប់គ្រង់​បុរី​នេះ អាច​ត្រូវ​បាន​កែប្រែ​នា​ពេល​ណា​មួយ​ខាង​មុខ​ដោយ​ស្រប​ទៅ​តាម​តម្លៃ​ទីផ្សារ​ជាក់​ស្តែង ហើយភាគី <span class="text-bold">“អ្នកលក់”</span> នឹង​ជូន​ដំណឹង​ជាសាធារណៈ​ទៅភាគី <span class="text-bold">“អ្នកទិញ”</span> ទាំង​អស់​ក្នុង​រយៈពេល <span class="text-bold">០១ (មួយ) ខែ​</span>មុន​ការ​កែប្រែ​តម្លៃ​នេះ​ចូល​ជាធរមាន។</p>

<p class="english text-justify">After handing over the immoveable property to “the purchaser”, “the seller” shall be obliged to provide Borey management and maintenance services within the compound of the entire Borey, such as security and order services for 24 hours a day, sanitation, road lighting, gardening and other public properties care. In such case, “the purchaser” shall be obliged to make payment of Borey management and maintenance service fees, as stated in Article 1: Identity of Immoveable Property and Sale-Purchase Price, once a year, and shall make advance payment to “the seller” for one year before receiving the immoveable property from “the seller”, and the said service fee shall be charged from the date “the purchaser” receives the immoveable property from “the seller”. The said management and maintenance service fees might be changed at any time in the future, according to actual market price, and “the seller” will give a public notice to all “purchasers” within 1 (one) month before the change of the said fee takes effect.</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៧៖ ប័ណ្ណបញ្ជាក់សិទ្ធិលើកម្មសិទ្ធិនៃអចលនវត្ថុនៃការលក់ទិញ</p>
<p class="text-bold english">Article 7: Title Deed of Immoveable Property</p>
<p class="khmer">ភាគី <span class="text-bold">“អ្នកលក់”</span> សន្យា​ថា​នឹង​ប្រគល់​ប័ណ្ណ​បញ្ជាក់​សិទ្ធិ​លើ​កម្មសិទ្ធិ​នៃ​អចលនវត្ថុ​នៃ​ការ​លក់ទិញ ជា​ប្រភេទ​ដូច​ចែង​ក្នុង​ <span class="text-bold">ប្រការ១៖ អត្តសញ្ញាណ​នៃ​អចលនវត្ថុ​លក់ទិញ និង​តម្លៃ​លក់​ទិញ</span> ជូនភាគី <span class="text-bold">“អ្នកទិញ”</span> បន្ទាប់​ពី​ភាគី <span class="text-bold">“អ្នកទិញ”៖</span> <span class="text-bold">(១).</span> បាន​ទទួល​យក​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ​ពី​ភាគី <span class="text-bold">“អ្នកលក់”</span> រួច​រាល់​ហើយ <span class="text-bold">(២).</span> បាន​ទូ​ទាត់​បង់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​រួច​រាល់​គ្រប់​ចំនួន​ជូនមក ភាគី <span class="text-bold">“អ្នកលក់”</span> ដូច​បាន​ចែង​ក្នុង​ឧបសម្ព័ន្ធទី១ <span class="text-bold">“តារាង​កាល​វិភាគ​នៃ​ការ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ” (៣).</span> មក​បំពេញ​បែប​បទ និង​ឯកសារ​គ្រប់គ្រាន់​ជូន​ភាគី <span class="text-bold">“អ្នកលក់”</span> ដើម្បី​រៀប​ចំ​ដាក់​ស្នើ ឬ​រៀប​ចំ​បែបបទ​រដ្ឋបាល​ជា​មួយ​មន្ត្រី​ជំនាញ​សុរិយោ​ដី​ដើម្បី​ស្នើ​ទៅ​តាម​នីតិ​វិធី​ច្បាប់ឲ្យ​បាន​ទាន់​ពេល​វេលា និង​រលូន​ជូន​ភាគី <span class="text-bold">“អ្នកទិញ”</span> (ប្រសិន​បើ​ត្រូវ​ការ)។ ទោះ​ជា​យ៉ាង​ណា​ក៏​ដោយ​ ប្រសិន​បើ​មាន​ការ​យឺត​យ៉ាវ​ក្នុង​ការ​សម្រេច និង​អនុញ្ញាត​ចេញ​ប័ណ្ណ​បញ្ជាក់​សិទ្ធិ​លើ​កម្មសិទ្ធិ​លើ​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ ដោយ​សារ​តែ​បញ្ហា​បច្ចេកទេស ឬ​រដ្ឋបាល​របស់​មន្ត្រី​សុរិយោដី ឬ​មន្ត្រី​មាន​សមត្ថកិច្ច​នោះ ភាគី <span class="text-bold">“អ្នកទិញ”</span> មិន​អាច​តវ៉ា ឬ​ទំលាក់​កំហុស​លើ​ភាគី <span class="text-bold">“អ្នកលក់”</span> ដែល​បាន​ប្រឹងប្រែង​អស់​ពី​សមត្ថភាព​ហើយ​នោះទេ។ ការ​ចំណាយ​លើ​ការ​រៀប​ចំ​ឯកសារ​ផ្ទេរ​សិទ្ធិ​លើ​កម្មសិទ្ធិ ដូច​ចែងក្នុង <span class="text-bold">ប្រការ១</span> បូក​រួម​នឹង​ការ​បង់​ពន្ធ​ប្រថាប់​ត្រា <span class="text-bold">៤% (បូនភាគរយ)</span> គឺ​ជាការ​ទទួល​ខុស​ត្រូវ​ដោយ​ផ្ទាល់​របស់ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ដោយ​ភាគី <span class="text-bold">“អ្នកលក់”</span> ជួយ​សម្រួល និង​រៀបចំ​ឯក​សារ​ពាក់​ព័ន្ធ​ជូន​ទៅ​តាម​ស្ថាន​ភាព​ជាក់ស្តែង។</p>

<p class="english text-justify">“The seller” pledges to hand over the Title Deed of Immoveable Property with its type as stated in Article 1: Identity of Immoveable Property and Sale-Purchase Price to “the purchaser” after “the purchaser” (1) has already received the immoveable property from “the seller”, (2) has paid the sale-purchase price of the immoveable property to “the seller” in full amount, as stated in Annex 1 “Schedule of Payment of Sale-Purchase Price of the Immoveable Property”, (3) has came to fill out sufficient forms and documents in order for “the seller” to submit a request or to complete administrative formality with line cadaster officer in order to make a request in accordance with legal procedures for “the purchaser” in timely and smooth manners (if needed). However, should there be any delay in making decision and giving authorization for issue of the Title Deed of Immoveable Property due to technical problem or administration of the Cadaster Officer or any competent officer, “the purchaser” shall not be entitled to make a protest or slander “the seller” who has put all of his/her efforts. Expense incurred for preparation of document for ownership transfer, as stated in Article 1, including stamp tax of 4% (four percent) shall be borne by “the purchaser”, and “the seller” will help facilitate and prepare relevant documents according to actual situation.</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៨៖ ការទទួលខុសត្រូវបង់ពន្ធអចលនវត្ថុប្រចាំឆ្នាំរបស់គូភាគី</p>
<p class="text-bold english">Article 8: Responsibility for Payment of Annual Tax on Immoveable Property of the Two Parties</p>
<p class="khmer"><span class="text-bold">៨.១</span> ភាគី <span class="text-bold">“អ្នកលក់”</span> ទទួល​ខុស​ត្រូវ​ទាំង​ស្រុង​ចំពោះ​ការ​បង់​ពន្ធ​អចលនវត្ថុ​ប្រចាំ​ឆ្នាំ ឬ​បង់​ពន្ធ​ដី​មិន​បាន​បើ​ប្រាស់​ឬ​ពន្ធ​នានា​ពាក់​ព័ន្ធ​នឹង​អាជីវកម្ម​សាង​សង់​លំនៅឋាន​របស់​ខ្លួន​មុន​កាលបរិច្ឆេទ​នៃ​ការ​ប្រគល់​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ​ជូន​ទៅ​ភាគី <span class="text-bold">“អ្នកទិញ”</span>។</p>
<p class="english text-justify">8.1. “The seller” shall bear full responsibility for payment of annual tax on immoveable property or various taxes in relation to the business of constructing his/her housing building prior to the date of handing over the immoveable property to “the purchaser”.</p>

<p class="khmer"><span class="text-bold">៨.២</span> ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​ទទួល​ខុស​ត្រូវ​លើ​ការ​បង់​ពន្ធ​អចលវត្ថុ​ប្រចាំ​ឆ្នាំ និង​ពន្ធ​ផ្សេង​ទៀត​ពាក់​ព័ន្ធ​នឹង​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ​ខាង​លើ​បន្ទាប់​ពី​កាល​បរិច្ឆេទ​ទទួល​យក​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ ពីភាគី <span class="text-bold">“អ្នកលក់”</span>។</p>
<p class="english text-justify">8.2. “The purchaser” shall bear responsibility for annual tax on immoveable property and other taxes in relation to the immoveable property after the date of receiving the immoveable property from “the seller”.</p> 

<p class="khmer-title pb-0 mb-0">ប្រការ៩៖ ទាយាទ អ្នកស្នងមរតក និងអ្នកទទួលសិទ្ធិស្របច្បាប់</p>
<p class="text-bold english">Article 9: Heir, Successor and Legal Assignee</p>
<p class="khmer">ក្នុង​ករណី​ដែល​មាន​ភាគី​ណា​មួយ មិន​អាច​អនុវត្ត​សិទ្ធិ និង​កាតព្វកិច្ច​របស់​ខ្លួន​បាន​ដោយ​មូលហេតុ​ណា​មួយ​បណ្តាល​មក​ពី មរណភាព ពិការភាព ឬ​អវត្តមាន​ជា​បណ្តោះ​អាសន្ន ឬ​អចិន្ត្រៃយ៍​នៅ​ក្នុង​ប្រទេស​នោះ រាល់​សិទ្ធិ និង​កាតព្វកិច្ច​ទាំង​អស់​របស់​ភាគី​នោះ​ដែល​ស្ថិត​ក្រោម​ខ្លឹមសារ​នៃ​កិច្ចសន្យា​នេះ ត្រូវ​បន្ត​ទៅ​ទាយាទ និង/ឬ អ្នក​ស្នង​មរតក និង/ឬអ្នកតំណាង​ស្រប​ច្បាប់​ណា​មួយ​របស់​ខ្លួន​ដោយ​ស្វ័យប្រវត្តិ។</p>
<p class="english text-justify">In case either party is unable to implement their rights and obligations due to his/her death, disability or temporary or permanent absence in the country, all rights and obligations of that party under the content of this contract shall automatically transferred to one of his/her heir and/or successor and/or legal representative.</p>

<p class="khmer-title pb-0 mb-0">ប្រការ១០៖ គោលការណ៍ស្ម័គ្រចិត្ត និងការព្រមព្រៀងនៃកិច្ចសន្យា</p>
<p class="text-bold english">Article 10: Principle of Free Will and Agreement of the Contract</p>
<p class="khmer">កិច្ចសន្យា​លក់​ទិញ​អចលនវត្ថុ​នេះ ត្រូវ​ធ្វើ​ឡើង​ដោយ​គ្មាន​ការ​គំរាម​កំហែង បង្ខិតបង្ខំ ឬ​មាន​បញ្ហា​ខុស​ច្បាប់​ណា​មួយ​ឡើយ ហើយ <span class="text-bold">គូភាគី</span> មាន​សមត្ថភាព​គ្រប់គ្រាន់​ក្នុង​ការ​ដឹង​លឺ ឬ​យល់​ដឹង បាន​អាន បានស្តាប់ និង​យល់​ព្រម​តាម​លក្ខខណ្ឌ​ទាំងឡាយ​នៃ​កិច្ចសន្យា​នេះ។ កិច្ចសន្យា​លក់​ទិញ​អចលនវត្ថុ​នេះ មាន​សុពលភាព​នា​កាលបរិច្ឆេទ​ដែល <span class="text-bold">គូភាគី</span> បាន​ផ្តិត​ស្នាម​មេដៃ និង​ចុះ​ត្រា​ក្រុមហ៊ុន​ដូច​ខាង​ក្រោម។ កិច្ចសន្យា​លក់ទិញ​អចលនវត្ថុ​នេះ​ធ្វើ​ឡើង​ជាភាសាខ្មែរ​ចំនួន <span class="text-bold">០២ (ពីរ)</span> ឯកសារ​ច្បាប់​ដើម ក្នុងនោះ ភាគី <span class="text-bold">“អ្នកលក់”</span> រក្សាទុក <span class="text-bold">០១ (មួយ)</span> ឯកសារ​ច្បាប់ដើម ហើយភាគី <span class="text-bold">“អ្នកទិញ”</span> រក្សាទុក <span class="text-bold">០១ (មួយ)</span> ឯកសារ​ច្បាប់​ដើម។ ឯកសារ​នីមួយៗ​មាន​សុពលភាព និង​អានុភាព​គតិយុត្តិ​ស្មើៗ និងដូចគ្នា។</p>
<p class="english text-justify">This Contract on Sale-Purchase of Immoveable Property is made without threat, coercion, or any illegal issue, and the two parties have full capacity to acknowledge or recognize, have read and listened to, and have agreed to various conditions of this contract. This Contract on Sale-Purchase of Immoveable Property is valid from the date the two parties have affixed their thumbprints and company stamps hereunder. This Contract on Sale-Purchase of Immoveable Property is made in Khmer language, in 2 (two) original copies; of which, “the seller” retains 1 (one) original copy, and “the purchaser” retains 1 (one) original copy. Each document has equal and same validity and legal effect.</p>
@endsection

@section('third')
<h4 class="khmer-title text-center">ឧបសម្ព័ន្ធទី៣៖</h4>
<h4 class="khmer-title text-center">“សម្ភារៈដែលភ្ជាប់បញ្ជូលក្នុងអចលនវត្ថុ”</h4>
<h4 class="english text-center text-bold my-0 py-0">Annex 3:</h4>
<h4 class="english text-center text-bold my-0 py-0">Fixture to the Immoveable Property</h4>
{!! $contract->equipment_text !!}
<div style="page-break-after: always;"></div>
@endsection

@section('forth')
<h4 class="khmer-title text-center">ឧបសម្ព័ន្ធទី៤៖</h4>
<h4 class="khmer-title text-center">“អត្តសញ្ញាណប័ណ្ណ ឬលិខិតឆ្លងដែនរបស់ភាគី អ្នកលក់ និងភាគី អ្នកទិញ”</h4>
<h4 class="english text-center text-bold my-0 py-0">Annex 4:</h4>
<h4 class="english text-center text-bold my-0 py-0">Identification Card or Passport of the Seller and the Purchaser</h4>

@if(array_key_exists('customer1_id_front',$attachment_array) || array_key_exists('customer2_id_front',$attachment_array))  
<p class="khmer text-bold">- អត្តសញ្ញាណប័ណ្ណ អ្នកទិញ</p>
<p class="text-bold english">- Purchaser's Identification Card</p>
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
<p class="khmer text-bold">- លិខិតឆ្លងដែន អ្នកទិញ</p>
<p class="text-bold english">- Purchaser's Passport</p>
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
<p class="khmer text-bold">- អត្តសញ្ញាណប័ណ្ណ អ្នកលក់</p> 
<p class="text-bold english">- Seller's Identification Card</p> 
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