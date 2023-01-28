@extends('admin.contract.template.v2.en.template')

@section('page_title', "Contract $contract->customer1_name")

@section('contract_type')
<h3 class="khmer-title text-center mt-3 mb-3">កិច្ចសន្យាលក់ ទិញដីឡូតិ៍ ក្នុងគម្រោង {{ $project->name }}</h3>
<h3 class="english text-center mt-3 mb-3">CONTRACT ON LAND SALE-PURCHASE IN {{ strtoupper($project->name_en) }}</h3>
@endsection

@section('praka')
<p class="khmer-title pb-0 mb-0">ប្រការ១៖ អត្តសញ្ញាណនៃអចលនវត្ថុលក់ទិញ និងតម្លៃលក់ទិញ</p>
<p class="english ">Article 1: Identity of Immoveable Property and Sale-Purchase Price<</p>
<p class="khmer"><span class="text-bold">១.១.</span> ភាគី <span class="text-bold">“អ្នកលក់”</span> គឺ​ជា​កម្មសិទ្ធិករ​ស្រប​ច្បាប់​លើ​អចលនវត្ថុ យល់​ព្រម​លក់ ហើយ ភាគី <span class="text-bold">“អ្នកទិញ”</span>
យល់​ព្រម​ទិញ​នូវ​អចលនវត្ថុ​ដូច​មាន​ចែង​ក្នុង​តារាង​អត្តសញ្ញាណ​នៃ​អចលនវត្ថុ​លក់ទិញ និង​តម្លៃ​លក់​ទិញ​នេះ។</p>
<p class="english">1.1. “The seller” is the legal owner of the immoveable property and agrees to sell, and “the purchaser” agrees to purchase the immoveable property as stated in the table of identity of immoveable property and of the sale-purchase price.</p>
<p class="khmer"><span class="text-bold">១.២.</span> តារាងអត្តសញ្ញាណនៃអចលនវត្ថុលក់ទិញ និងតម្លៃលក់ទិញ (“អចលនវត្ថុ”)៖</p>
<p class="english">1.2. Table of Identity of Immoveable Property and Sale-Purchase Price (“Immoveable Property”)</p>
<table class="table table-p-1 table-contract-bordered">
    <tr>
    	<td width="180px" class="text-bold">
            <p class="khmer pb-0 mb-0">ប្រភេទ</p>
            <p class="english pb-0 mb-0">Type</p>
        </td>
    	<td width="30px" class="text-center">:</td>      
    	<td><span class="english">{{ $unit_type->name }}</span></td>
    	<td width="100px" class="text-bold">
            <p class="khmer pb-0 mb-0">លេខ</p>
            <p class="english pb-0 mb-0">No.</p>
        </td>
    	<td width="30px" class="text-center">:</td>
    	<td width="250px" class="english text-bold">{{ isset($is_template) ? '_______________' : $unit->code }}</td>
    </tr>
    <tr>
    	<td width="180px" class="text-bold">
            <p class="khmer pb-0 mb-0">ទំហំដី</p>
            <p class="english pb-0 mb-0">Size of the Land</p>
        </td>
    	<td width="30px" class="text-center">:</td>      
    	<td>
    		<p class="khmer mb-0 pb-0">
    		@if( isset($is_template) )
    			_______________
    		@else
    			ទទឺង {{ $unit->land_size_width }} ម៉្រែត និង បណ្តោយ {{ $unit->land_size_length }} ម៉្រែត 
    		@endif            
    		</p>
            <small class="khmer d-block">(ដែល​អាច​មាន​ការ​ប្រែប្រួល​បន្តិច​បន្ទួច​ជាលក្ខណៈ​បច្ចេកទេស អាស្រ័យ​លើ​ការ​កំណត់​ព្រុំ​របស់​មន្ត្រី​សុរិយោដី)</small>

            <p class="khmer mb-0 pb-0">
            @if( isset($is_template) )
                _______________
            @else
                Width: {{ $unit->land_size_width }} meter, Length {{ $unit->land_size_length }} meter 
            @endif            
            </p>
            <p class="english">(Which can be slighly changed due to technical issue; according to border marking by the Cadaster Officer)</p>
    	</td>
    	<td width="120px" class="text-bold">
            <p class="khmer pb-0 mb-0">សេវានិង​ថ្លៃ​គ្រប់គ្រង​ថែទាំ</p>
            <p class="english pb-0 mb-0">Management and Maintenance Service and Fees</p>
        </td>
    	<td width="30px" class="text-center">:</td>
    	<td width="250px"> 
            <p class="khmer">ដូច​ចែង​ក្នុង​<span class="text-bold">ប្រការ៦</span> នៃ​កិច្ច​សន្យា​លក់​ទិញនេះ។</p>
            <p class="english">As stated in Article 6 of this contract.</p>
    	</td>
    </tr>  
    <tr>
        <td width="180px" class="text-bold">
            <p class="khmer pb-0 mb-0">ទីតាំងគម្រោង</p>
            <p class="english pb-0 mb-0">Location of the Project</p>
        </td>
        <td width="30px" class="text-center">:</td>      
        <td colspan="4">
            <p class="khmer pb-0">{{ $project->address }}</p>
            <p class="english pb-0">{{ $project->address_en }}</p>
        </td>
    </tr>    
    <tr>
        <td width="180px" class="text-bold">
            <p class="khmer pb-0 mb-0">ប្រភេទ​នៃ​ប័ណ្ណ​កម្មសិទ្ធិ​ដែល​ប្រគល់​ជូន​ភាគី “អ្នកទិញ”</p>
            <p class="english pb-0 mb-0">Type of Title Deed Provided to “the purchaser”</p>
        </td>
    	<td width="30px" class="text-center">៖</td>      
    	<td colspan="4">
            <p class="khmer pb-0">{{ $contract->title_clause_kh }}</p>
            <p class="english pb-0">{{ $contract->title_clause_en }}</p>
    	</td>
    </tr>   
    <tr>
    	<td width="180px" class="text-bold">
            <p class="khmer pb-0 mb-0">តម្លៃលក់ទិញ</p>
            <p class="english pb-0 mb-0">Sale-Purchase Price</p>
        </td>
    	<td width="30px" class="text-center">៖</td>
    	<td colspan="4">            
            @if( isset($is_template) )
                _______________ (______________________________)
            @else
                <p class="khmer text-bold pb-0">{{ $contract->unit_sale_price_after_discount_km }} ({{ $contract->unit_sale_price_after_discount_in_word_km }}) ដុល្លារអាមេរិក</p>
                <p class="english text-bold">{{ number_format($contract->getUnitSoldPriceAfterDiscount(),0) }} ({{ numfmt_create('en', \NumberFormatter::SPELLOUT) ->format($contract->getUnitSoldPriceAfterDiscount()) }}) US dollars</p>           
            @endif
    	</td>    
    </tr>
</table>

<p class="khmer-title pb-0 mb-0">ប្រការ២៖ ការទូទាត់ប្រាក់ថ្លៃលក់ទិញអចលនវត្ថុ</p>
<p class="english text-bold">Article 2: Payment of Immoveable Property Sale-Purchase Price</p>

<p class="khmer"><span class="text-bold">២.១.</span> ដោយ​មាន​ការ​ព្រមព្រៀង​គ្នា​ក្នុង​ការ​លក់​ទិញ នូវ​អចលនវត្ថុ​ដូច​បាន​ចែង​ក្នុង​ <span class="text-bold">ប្រការ១ "អត្តសញ្ញាណ​នៃ​អចលនវត្ថុ​លក់​ទិញ និងតម្លៃ​លក់​ទិញ"</span> ខាងលើ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ខាង​លើ​ទៅ​តាម​ដំណាក់កាល​នៃ​ការ​ទូទាត់​ឲ្យ​បាន​ត្រឹមត្រូវ គ្រប់​ចំនួន​ និង​ទាន់​ពេល​វេលា​ជា​បន្ត​បន្ទាប់​ដូច​បាន​ចែង​ក្នុង​ឧបសម្ព័ន្ធទី១ <span class="text-bold">"តារាងកាលវិភាគ​នៃ​ការ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ"</span>។ ភាគី <span class="text-bold">“អ្នកទិញ”</span> អាច​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ដោយ​ផ្ទាល់​នៅ​ការិយាល័យ​របស់​ភាគី <span class="text-bold">“អ្នកលក់”</span> ឬ​តាម​រយៈ​គណនី​ធនាគារ <span class="text-bold">{{ $bank->short_name }}</span> ដូច​មាន​ព័ត៌មាន​លម្អិត​ខាង​ក្រោមនេះ៖</p>

<p class="english text-justify">2.1. With mutual agreement to sale-purchase of the immoveable property as stated in Article 1 "Identity of the Immoveable Property and Sale-Purchase Price" above, “the purchaser” shall continuously make payment of the sale-purchase price of the said immoveable property in installments in proper manner, in full amount and in timely manner, as stated in Annex 1 "Schedule of Payment of Sale-Purchase Price of the Immoveable Property". “the purchaser” shall be entitled to make payment of the sale-purchase price of the immoveable property at the office of ​“The seller” directly or via an account at ABA Bank with the following details:</p>

<div class="row">
	<div class="col-8 offset-2 mb-3">
		<table class="table table-p-1 table-bordered ">
			<tr>
				<th>
                    <p class="khmer py-0 my-0 text-center">ឈ្មោះគណនីធនាគារ</p>
                    <p class="english py-0 my-0 text-center">Bank Account Name</p>
                </th>
				<th >
                    <p class="khmer py-0 my-0 text-center">លេខគណនីធនាគារ</p>
                    <p class="english py-0 my-0 text-center">Bank Account Number</p>
                </th>
			</tr>	
			<tr>
				<td class="english text-center">{{ $bank->account_name }}</td>
				<td class="english text-center">{{ $bank->account_number }}</td>
			</tr>
		</table>
	</div>
</div>

<p class="khmer"><span class="text-bold">២.២.</span> ភាគី <span class="text-bold">“អ្នកលក់”</span> អនុគ្រោះ​ជូនភាគី <span class="text-bold">“អ្នកទិញ”</span> ក្នុង​ការ​យឺតយ៉ាវ ឬ​ខក​ខាន​ទូទាត់​ប្រាក់ថ្លៃ​លក់ទិញ​អចលនវត្ថុ​ត្រឹមរយៈពេល <span class="text-bold">០៧ (ប្រាំពីរ) ថ្ងៃប្រតិទិន</span> ដោយ​មិន​បង់​ប្រាក់​ពិន័យ។ ផុត​ពី​រយៈ​ពេល​អនុគ្រោះ​នេះ ក្នុង​ករណី​ដែល​ភាគី <span class="text-bold">“អ្នកទិញ”</span> យឺតយ៉ាវ ឬ​ខកខាន​មិន​បាន​បំពេញ​កាតព្វកិច្ច​ទូទាត់​បង់ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ជូន​ភាគី <span class="text-bold">“អ្នកលក់”</span> ទៅ​តាម​ដំណាក់​កាល​នៃ​ការ​ទូទាត់​ឲ្យ​បាន​ត្រឹមត្រូវ គ្រប់ចំនួន និង​ទាន់​ពេល​វេលា​ទេ​នោះ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​បង់​ប្រាក់​ពិន័យ​លើ​ការ​យឺតយ៉ាវ ឬ​ខក​ខាន​នោះ​ក្នុង​មួយថ្ងៃ <span class="text-bold">០៥ (ប្រាំ) ដុល្លារ​អាមេរិក</span>។ ក្នុង​ករណី​ដែល​ការ​យឺតយ៉ាវ ឬ​ខក​ខាន​ក្នុង​ការ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​នោះ​នៅ​តែ​បន្ត​លើសពី រយៈពេល <span class="text-bold">០២ (ពីរ) ខែ</span>​ជាប់ៗ​គ្នា ឬ​ក្នុង​ចន្លោះ​រយៈ​ពេល​ណា​មួយ​ដែល​ផល​បូក​នៃ​រយៈ​ពេល​ទាំង​នោះ​លើស​ពី <span class="text-bold">០២ (ពីរ) ខែ</span> នោះ​ត្រូវ​បាន​សន្មត់ទុក​ជា​មុន និង​ចាត់​ទុក​ថា ភាគី <span class="text-bold">“អ្នកទិញ”</span> រំលាយ​កិច្ចសន្យា​ដោយ​ឯកតោ​ភាគី ដោយ​បោះបង់​ចោល​នូវ​សិទ្ធិ​ទាំង​ឡាយ​ដែល​មាន​លើអចលនវត្ថុ ការ​លក់​ទិញ​អចលនវត្ថុ និង​ចំនួន​ទឹក​ប្រាក់​ដែល​ខ្លួន​បាន​ទូទាត់​មក​ឲ្យ​ភាគី <span class="text-bold">“អ្នកលក់”</span>។ ក្នុង​ករណី​នេះទឹក​ប្រាក់​ដែល​បាន​ទូទាត់​ហើយ​ទាំងអស់​ត្រូវ​ក្លាយ​ជា​ប្រយោជន៍​សម្រាប់​ភាគី <span class="text-bold">“អ្នកលក់”</span> ហើយ ភាគី <span class="text-bold">“អ្នកលក់”</span> មាន​សិទ្ធិ​ពេញ​លេញ​ដោយ​ស្រប​ច្បាប់​ក្នុង​ការ​លក់​អចលនវត្ថុ​ខាង​លើ​ឲ្យ​ទៅ​អតិថិជន ឬ​អ្នក​ទិញ​ផ្សេង​ទៀត​បាន ដោយ​ភាគី <span class="text-bold">“អ្នកទិញ”</span> សន្យា​ថា​នឹង​មិន​តវ៉ា ឬ​ជំទាស់​ឡើយ។ ក្នុង​ករណី​នេះ ប្រសិន​បើ ភាគី <span class="text-bold">“អ្នកទិញ”</span> បាន​ទទួល​យក​អចលនវត្ថុ​ពី ភាគី <span class="text-bold">“អ្នកលក់”</span> ហើយនោះ ភាគី <span class="text-bold">“អ្នកលក់”</span> ទុក​រយៈ​ពេល​ឲ្យ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ដែល​បោះបង់​សិទ្ធិ​លើ​ការ​លក់​ទិញ និង​អចលនវត្ថុ​នោះ <span class="text-bold">០១ (មួយ) ខែ</span> សម្រាប់​រើចេញ​ពី​អចលនវត្ថុ។</p>

<p class="english text-justify">2.2. “The seller” gives “the purchaser” a grace period for delay or failure to make payment of the sale-purchase price of the immoveable property by 7 (seven) calendar days without paying a fine. After this grace period, should “the purchaser” delay or fail to fulfill the obligation of making payment of the sale-purchase price of the immoveable property to “The seller” as per the installment plan in proper manner, in full amount and in timely manner, “the purchaser” shall pay a fine for the said delay or failure at an amount of 5 (five) US dollars per day. In case the said delay or failure to make payment of the sale-purchase price of the immoveable property continues for more than 2 (two) consecutive months or at any periods, which the sum of those periods is more than 2 (two) months, it shall be assumed and deemed that “the purchaser” unilaterally dissolves the contract by waiving all existing rights over the immoveable property and the amount of money which he/she has made payment to “The seller”. In such case, all the amount of money which has already been paid shall become the benefit of “The seller”, and “The seller” shall have absolute and legal right to sell the said immoveable property to other customer or purchaser, which “the purchaser” pledges not to make a protest or an objection. In such case, should “the purchaser” have already accepted the immoveable property from “The seller”, “The seller” shall give “the purchaser” who abandons his/her right over the sale-purchase and the said immoveable property a 1 (one)-month period for moving out of the immoveable property.</p>

<p class="khmer text-bold pb-0 mb-0">ប្រការ៣៖ ការលក់ ឬផ្ទេរសិទ្ធិលើការលក់ទិញអចលនវត្ថុបន្តទៅតតិយជន និងឥណទានពីធនាគារ</p>
<p class="english text-bold">Article 3: Resale or Retransfer of Right over the Sale-Purchase of the Immoveable Property to Third Party and Credit from Bank</p>

<p class="khmer"><span class="text-bold">៣.១.</span> ក្នុង​កំឡុង​ពេល​នៃ​ការ​អនុវត្ត​កិច្ចសន្យា​លក់​ទិញ​នេះ ភាគី <span class="text-bold">“អ្នកទិញ”</span> អាច​លក់ ឬ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ​អចលនវត្ថុ​ទៅ​ តតិយជន​ណា​មួយ​បាន​ដោយ​ការ​ស្នើ​សុំ​ជា​លាយ​លក្ខណ៍​អក្សរ ហើយ​ទទួល​បាន​ការ​អនុញ្ញាត​យល់​ព្រម​ពី​ភាគី <span class="text-bold">“អ្នកលក់”</span> ដោយភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​បង់​ថ្លៃ​សេវា​រដ្ឋបាល​លើ​ការ​លក់ ឬ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ អចលនវត្ថុ​នេះ​ស្មើ​នឹង <span class="text-bold">{{ $contract->contract_transfer_fee_km }} ({{ $contract->contract_transfer_fee_in_word_km }}) ដុល្លារ​អាមេរិក</span> ជូន​ភាគី <span class="text-bold">“អ្នកលក់”</span>។ មុន​នឹង​អាច​លក់ ឬ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ​អចលនវត្ថុ​ទៅ​តតិយជន​ណា​មួយ​បាន ប្រសិន​បើ​ភាគី <span class="text-bold">“អ្នកទិញ”</span> យឺតយ៉ាវ ឬ​ខក​ខន​មិន​បាន​បំពេញ​កាតព្វកិច្ច​ទូទាត់​បង់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ជូន​ភាគី <span class="text-bold">“អ្នកលក់”</span> ទៅ​តាម​ដំណាក់​កាល​នៃ​ការ​ទូទាត់​ឲ្យ​បាន​ត្រឹមត្រូវ គ្រប់ចំនួន និងទាន់​ពេល​វេលា​ដូច​ចែង​ក្នុង​ <span class="text-bold">ប្រការ២</span> នោះ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​ទូទាត់​ប្រាក់​ដែល​នៅ​ជំពាក់ និង​ប្រាក់​ពិន័យ​លើ​ការ​យឺត​យ៉ាវ ឬ​ខក​ខាន​នោះ​ឲ្យ​រួច​រាល់​ជា​មុន​សិន។ តតិយជន​ដែល​ទទួល​ទិញ ឬ​ទទួល​ការ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ​អចលនវត្ថុ​នេះ ត្រូវ​គោរព​តាម​ទាំង​ស្រុង​នូវ​ខ្លឹម​សារ​នៃ​កិច្ចសន្យា​លក់​ទិញ​នេះ ហើយ​អនុវត្ត​តាម​បែប​បទ​រដ្ឋបាល​មួយ​ចំនួន​ដែល​ភាគី <span class="text-bold">“អ្នកលក់”</span> តម្រូវ។</p>

<p class="english text-justify">3.1. During the implementation of this Sale-Purchase Contract, “the purchaser” can resell or retransfer his/her right over the sale-purchase of the immoveable property to any third party by making a written request and obtaining authorization and agreement from “The seller”, and “the purchaser” shall make payment of administrative service fee for the sale or transfer of right over the said immoveable property, equivalent to an amount of 150 (one hundred fifty) US dollars to “The seller”. To be able to sell or transfer right over the sale-purchase of the immoveable property to any third party, should “the purchaser” delay or fail to fulfill the obligation of making payment of the sale-purchase price of the immoveable property to “The seller” as per the installment plan in proper manner, in full amount and in timely manner as stated in Article 2, “the purchaser” shall completely make payment of the outstanding amount and fine for such delay or failure first. The third party who purchases or accepts the right over the sale-purchase of the said immoveable property shall completely abide by the content of this Contract on Sale-Purchase and comply with some administrative formalities required by “The seller”.</p>

<p class="khmer"><span class="text-bold">៣.២.</span> ចំពោះ​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ដែល​ជ្រើស​រើស​ជម្រើស​បង់រម្លស់ <span class="english">(Loan)</span> ដែល​ភ្ជាប់​នឹង​អត្រា​ការ​ប្រាក់​ជាមួយ​ភាគី <span class="text-bold">“អ្នកលក់”</span> នៅ​ពេល​ដែល​ដី​ត្រូវបានចាក់​បំពេញ​បាន​ចាប់ពី៧០% (ចិតសិបភាគរយ) ឡើង​ទៅ ភាគី <span class="text-bold">“អ្នកលក់”</span> សូម​រក្សា​សិទ្ធិ​ក្នុង​ការ​ចាត់​ចែង​បញ្ជូន​សិទ្ធិ​លើ​បំណុល​ដែល​ភាគី <span class="text-bold">“អ្នកទិញ”</span> មាន​ដោយ​ការ​បង់​រម្លស់​ជាមួយ ភាគី <span class="text-bold">“អ្នកលក់”</span> ឲ្យ​ទៅ​ធនាគារ​ណា​មួយ​ដែល​សហការ​ជាមួយ​ភាគី <span class="text-bold">“អ្នកលក់”</span> ហើយ​សេវា​ក្នុង​ការ​សិក្សា​ជា​មួយ​ធនាគារ​ទាំងនោះ គឺ​ជា​បន្ទុក​របស់​ភាគី <span class="text-bold">“អ្នកទិញ”</span>។</p>

<p class="english text-justify">3.2. For “the purchaser” who chooses making payment by mortgage (loan) bearing interest rate with “The seller”, upon the handover of the immovable property by “The seller”, “The seller” reserves the right to arrange and transfer the right over any debt of “the purchaser” arising out of the payment by mortgage with “The seller” to any bank which cooperates with “The seller”, and service fee for conducting study of the property taken by that bank shall be the burden of “the purchaser”.</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៤៖ ការសន្យាប្រគល់អចលនវត្ថុ</p>
<p class="english text-bold">Article 4: Pledge to Hand Over the Immoveable Property</p>
<p class="khmer">ភាគី <span class="text-bold">“អ្នកលក់”</span> សន្យា​នឹង​ប្រគល់​អចលនវត្ថុ​ជូន​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ក្នុង​រយៈ​ពេល <span class="text-bold">{{ $contract->deadline_km }} ({{ $contract->deadline_in_word_km }}) ខែ​</span> ដោយ​រាប់​ចាប់​ពី​កាលបរិច្ឆេទ​ចុះ​កិច្ចសន្យា​លក់ទិញ​នេះ។ ក្នុង​ករណី​ដែល​មាន​ការ​យឺត​យ៉ាវ ឬ​ខកខាន​ក្នុង​​ការ​ប្រគល់​អចលនវត្ថុ​ជូន ភាគី <span class="text-bold">“អ្នកទិញ”</span> ភាគី <span class="text-bold">“អ្នកលក់”</span> សូម​រក្សា​សិទ្ធិ​ពន្យារ​ពេល​ថែម <span class="text-bold">{{ $contract->extended_deadline_km }} ({{ $contract->extended_deadline_in_word_km }}) ខែ​</span> បន្ថែម​ទៀត ជា​រយៈ​ពេល​អនុគ្រោះ ក្នុង​ការ​សន្យា​ប្រគល់​អចលនវត្ថុ​ជូន ភាគី <span class="text-bold">“អ្នកទិញ”</span>។ បើ​ផុត​រយៈ​ពេល​អនុគ្រោះ​ខាង​លើ​ហើយ ភាគី <span class="text-bold">“អ្នកលក់”</span> នៅ​តែ​មិន​ទាន់​មាន​អចលនវត្ថុ ប្រគល់​ជូន​ភាគី “អ្នកទិញ” ទេ  ភាគី <span class="text-bold">“អ្នកលក់”</span> សូម​ទទួល​ខុស​ត្រូវ​ក្នុង​ការ​បង់​សំណង​ពិន័យ​ជូន ភាគី “អ្នកទិញ” ស្មើនឹងអត្រា ១% (មួយភាគរយ) ក្នុង​មួយ​ខែ នៃ​ប្រាក់​ដែល​ភាគី <span class="text-bold">“អ្នកទិញ”</span> បាន​ទូ​ទាត់​បង់​ជូន​ភាគី <span class="text-bold">“អ្នកលក់”</span> រាប់​ចាប់​ពី​កាលបរិច្ឆេទ​ដែល​ផុត​កំណត់​ត្រូវ​ប្រគល់​អចលនវត្ថុ​ជូនភាគី <span class="text-bold">“អ្នកទិញ”</span>។ ទាក់​ទង​នឹង​ការ​ប្រគល់​ទទួល​អចលនវត្ថុនេះ ភាគី <span class="text-bold">“អ្នកទិញ”</span> អាច​ទទួល​អចលនវត្ថុ​បាន​លុះ​ត្រាតែ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​ទូទាត់​ប្រាក់​ដែល​នៅ​ជំពាក់ និង​ប្រាក់​ពិន័យ​លើ​ការ​យឺត​យ៉ាវ ឬ​ខក​ខាន​នោះ​ឲ្យ​រួច​រាល់​ជា​មុន​សិន។ ចំពោះ​អចលនវត្ថុ​ដែល​ជា​កម្មវត្ថុ​នៃ​ការ​លក់​ទិញ​ណា​មួយ ដែល​ភាគី <span class="text-bold">“អ្នកទិញ”</span> មិន​ទាន់​បាន​ទូទាត់​ថ្លៃលក់ទិញ​រួច​រាល់​ទាំង​ស្រុង​ជូន ភាគី <span class="text-bold">“អ្នកលក់”</span> ទេ ភាគី <span class="text-bold">“អ្នកទិញ”</span> នោះ​មិន​ទាន់​ក្លាយ​ជា​ម្ចាស់​អចលនវត្ថុ​ពេញ​លេញ និង​ស្រប​ច្បាប់​ឡើយ ទោះ​បី​ជា​ភាគី <span class="text-bold">“អ្នកលក់”</span> បាន​ប្រគល់​អចលនវត្ថុ​នោះជូន ភាគី <span class="text-bold">“អ្នកទិញ”</span> ក៏ដោយ។</p>

<p class="english text-justify">“The seller” pledges to hand over the immoveable property to “the purchaser” within a period of 24 (twenty-four) months, from the date this Contract on Sale-Purchase is entered into. In case of delay or failure to hand over the immoveable property to “the purchaser”, “The seller” reserves the right to delay the construction period for another 6 (six) months as a grace period of the pledge to hand over the immoveable property to “the purchaser”. Should the said grace period be elapsed, and “The seller” is still yet to have an immoveable property to be handed over to “the purchaser”, “The seller” shall bear responsibility for paying compensation and fine to “the purchaser” at a monthly rate of 1% (one percent) over the amount of money which “the purchaser” has paid to “The seller” from the deadline of handing over the immoveable property to “the purchaser”. The two parties have determined and reached a mutual agreement in advance that when “The seller” gives a notice on inspection and receipt of the immoveable property, whether via phone call, electronic mail, or by handing a letter, giving notice to a residence or posted mail; to wit, through any appropriate way which “the purchaser” can be informed, it is implied that “The seller” has the immoveable property to be handed over to “the purchaser” on that day (in case of request for renovation or repair of minor technical work inside or outside the immoveable property, such as tile, paint, any spot on the mirror, crack of coated cement, etc., it shall not be considered that “The seller” does not have an immoveable property to be handed over to “the purchaser” yet). Should “The seller” can hand over the immoveable property earlier, “The seller” will give a notice to “the purchaser” on early inspection and receipt of the immoveable property, and “the purchaser” shall not delay the inspection and receipt; otherwise, “The seller” will not bear responsibility for any eventual delay or failure later. In relation to the handover and receipt of the said immoveable property, “the purchaser” can receive the immoveable property only if “the purchaser” (1) has completely made payment of the outstanding amount and fine for such delay or failure in advance, and (2) has made advance payment of Borey management and maintenance service fees as stated in Article 6 to “The seller” for one year. As for the immoveable property which “the purchaser” has yet to completely pay off the sale-purchase price to “The seller”, “the purchaser” has yet to completely and legally become the owner of that immoveable property though “The seller” has handed over the said immoveable property to “the purchaser”.</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៥៖ ការសន្យា និងការទទួលខុសត្រូវក្នុងការអភិវឌ្ឍន៍អចលនវត្ថុរវាងភាគី “អ្នកលក់” និងភាគី “អ្នកទិញ”</p>
<p class="english text-bold">Article 5: Pledge and Responsibility for Immovable Property Development between “The seller” and “the purchaser”</p>

<p class="khmer pb-0"><span class="text-bold">៥.១.</span> ភាគី <span class="text-bold">“អ្នកលក់”</span> សន្យា​ធ្វើ​ការ​អភិវឌ្ឍន៍​អចលនវត្ថុ​ជូន​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ដូច​ខាង​ក្រោម​ទៅ​តាម​កាល​វិភាគ​ពេលវេលា និង​ដំណាក់​កាល​ការងារ​អភិវឌ្ឍន៍​របស់​គម្រោង​ខ្លួន៖</p>
<ul class="ml-4 mb-3">
    <li class="khmer">សាង​សង់​ផ្លូវ​បេតុង​ក្នុង​បរិវេណ​គម្រោង​ដែល​ភាគី <span class="text-bold">“អ្នកលក់”</span> បាន​លក់​ជូន​ភាគី <span class="text-bold">“អ្នកទិញ”</span>។</li>
    <li class="khmer">សាង​សង់​ប្រព័ន្ធ​លូ​ក្នុង​បរិវេណ​គម្រោង​ដែល​ភាគី <span class="text-bold">“អ្នកលក់”</span> បាន​លក់​ជូន​ភាគី <span class="text-bold">“អ្នកទិញ”</span>។</li>
    <li class="khmer">ត​ភ្ចាប់​ប្រព័ន្ធ​ទឹក​ស្អាត​ក្នុង​បរិវេណ​គម្រោង​ដែល​ភាគី <span class="text-bold">“អ្នកលក់”</span> បាន​លក់​ជូន​ភាគី <span class="text-bold">“អ្នកទិញ”</span>។</li>
    <li class="khmer">សាង​សង់ និង​ភ្ជាប់​បណ្តាញ​ប្រព័ន្ធ​អគ្គិសនី និង​ចាក់​ដី​បំពេញ​មិន​ឲ្យ​លិច​ទឹក​ក្នុង​បរិវេណ​គម្រោង​ដែល​ភាគី <span class="text-bold">“អ្នកលក់”</span> បាន​លក់​ជូន​ភាគី <span class="text-bold">“អ្នកទិញ”</span>។</li>
</ul>
<p class="english">5.1. “The seller” pledges to develop the immovable property for “the purchaser” as per the timeframe and project development phase as follows:</p>
<ul class="ml-4 mb-3">
    <li class="english">To construct concreted roads in the project compound in which “The seller” has sold the immovable property to “the purchaser”</li>
    <li class="english">To construct sewage system in the project compound in which “The seller” has sold the immovable property to “the purchaser”</li>
    <li class="english">To connect clean water system to the project compound in which “The seller” has sold the immovable property to “the purchaser”</li>
    <li class="english">To construct and connect electricity network and fill in the area to prevent the project compound in which “The seller” has sold the immovable property to “the purchaser” from being flooded.</li>
</ul>

<p class="khmer"><span class="text-bold">៥.២.</span> ភាគី <span class="text-bold">“អ្នកលក់”</span> សន្យា​ថា​បើ​ថ្ងៃ​ក្រោយ​មាន​តតិយជន​ណា​មួយ​ចេញ​មក​តវ៉ា ឬ​ទាម​ទារ​សិទ្ធិ​លើ​អចលនវត្ថុ​ខាង​លើ ហើយ​អះអាង​ថា​អចលនវត្ថុ​នេះមិ​នមែន​ស្ថិត​ក្រោម​កម្មសិទ្ធិ​របស់ ភាគី <span class="text-bold">“អ្នកលក់”</span> ឬ​ថា​ជា​អចលនវត្ថុ​មិន​ស្រប​ច្បាប់ ភាគី <span class="text-bold">“អ្នកលក់”</span> សុខ​ចិត្ត​ទទួល​ខុស​ត្រូវ​ដោះស្រាយទាំង​ស្រុង​ចំពោះ​មុខច្បាប់ ហើយ​ការ​ចំណាយ​នា​នា​ទាក់ទង​នឹង​បញ្ហា​ខាងលើ ជា​ការ​ទទួល​ខុសត្រូវ​ទាំង​ស្រុង​របស់​ភាគី <span class="text-bold">“អ្នកលក់”</span>។</p>

<p class="english text-justify">5.2. “The seller” pledges that in the future should a third party appear to make a protest or claim on the said immovable property, and claim that the said immovable property is not under the ownership of “The seller” or is an lawful immovable property, “The seller” undertakes to bear responsibility in solving this problem under the law and all costs incurred for that problem shall be solely borne by “The seller”.</p>

<p class="khmer"><span class="text-bold">៥.៣.</span> ភាគី <span class="text-bold">“អ្នកទិញ”</span> ក្រោយ​ពេល​ទទួល​បាន​អចលនវត្ថុ​ពី​ភាគី <span class="text-bold">“អ្នកលក់”</span> ហើយ​នៅ​ពេល​ណា​ដែល​ខ្លួន​មាន​ចេតនា​សាង​សង់​សំណង់​លំនៅឋាន ឬ​សំណង់​ផ្សេងៗ​នោះ ត្រូវ​បន្សល់​ទុក​ដី​ខាង​មុខ​សំណង់​របស់​ខ្លូន​ចំនួន <span class="text-bold">០៤(បួន) ម៉ែត្រ</span> ដោយ​វាស់​ចេញ​ពី​ផ្នែក​មុខ​នៃ​សំណង់​របស់​ខ្លួន ហើយ​ទុក​ខាង​ក្រោយ​សល់ <span class="text-bold">០១ (មួយ) ម៉ែត្រ</span> ដោយ​វាស់​ចេញ​ពី​ផ្នែក​ខាង​ក្រោយ​នៃ​សំណង់​របស់​ខ្លួន។</p>

<p class="english text-justify">5.3. After receiving the immovable property from “The seller”, and when “the purchaser” wishes to construct a housing building or other buildings, “the purchaser” shall leave a space of 4 (four) meters from the front of the building and 1 (one) meter from the back of the building.</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៦៖ ថ្លៃសេវាថែទាំគ្រប់គ្រងក្នុងបរិវេណគម្រោងអភិវឌ្ឍន៍</p>
<p class="english text-justify">Article 6: Management and Maintenance Fees in the Development Project Compound</p>

<p class="khmer">ភាគី <span class="text-bold">“អ្នកទិញ”</span> យល់​ព្រម​បង់ថ្លៃ អនាម័យ សណ្ដាប់ធ្នាប់ សន្តិសុខ សោភ័ណ្ឌភាព ភ្លើងបំភ្លឺសាធារណៈ និង​ការ​ជួសជុល​ផ្លូវ​ខូចខាត​ជូន​មក ភាគី <span class="text-bold">“អ្នកទិញ”</span> សម្រាប់​មួយ​ឆ្នាំ​ម្តង ទៅ​តាម​តម្លៃ​ទីផ្សារ​ជាក់​ស្តែង​ដែល ភាគី <span class="text-bold">“អ្នកលក់”</span> នឹង​កំណត់​នៅ​ពេល​អនាគត ហើយ​ត្រូវ​បង់​មួយ​ឆ្នាំ​ទុក​ជា​មុន នៅ​ពេល​ដែល​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ចាប់​ផ្ដើម​ធ្វើ​ការ​សាង​សង់​សំណង់​លំនៅឋាន ឬ​សំណង់​ផ្សេងៗ​លើ​អចលនវត្ថុ។ ក្នុង​ករណី​ភាគី <span class="text-bold">“អ្នកទិញ”</span> មាន​បំណង តភ្ជាប់​បណ្តាញ​ប្រព័ន្ធ​ទឹកស្អាត និង​ចរន្ត​អគ្គិសនី​ចូល​ទៅ​ក្នុង​លំនៅឋាន​របស់​ខ្លួន ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​ទទួល​ខុស​ត្រូវ​ទៅ​លើ​ការ​ចំណាយ​ទាំងស្រុង។</p>

<p class="english text-justify">“the purchaser” agrees to make payment of sanitation, order, security, aesthetics, lighting and road repair fees to “The seller” once a year according to the actual market price which the “The seller” would determine in the future, and which are to be paid in advance for one year, when “the purchaser” starts to construct the housing building or other buildings on the immovable property. In the event that “the purchaser” wishes to connect his/her house to the clean water and electricity networks, “the purchaser” shall bear all the expenses.</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៧៖ ប័ណ្ណបញ្ជាក់សិទ្ធិលើកម្មសិទ្ធិនៃអចលនវត្ថុនៃការលក់ទិញ</p>
<p class="english text-bold">Article 7: Certificate of Ownership of Immoveable Property</p>

<p class="khmer">ភាគី <span class="text-bold">“អ្នកលក់”</span> សន្យា​ថា​នឹង​ប្រគល់​ប័ណ្ណ​បញ្ជាក់​សិទ្ធិ​លើ​កម្មសិទ្ធិ​នៃ​អចលនវត្ថុ​នៃ​ការ​លក់ទិញ ជា​ប្រភេទ​ដូច​ចែង​ក្នុង​ <span class="text-bold">ប្រការ១៖ អត្តសញ្ញាណ​នៃ​អចលនវត្ថុ​លក់ទិញ និង​តម្លៃ​លក់​ទិញ</span> ជូនភាគី <span class="text-bold">“អ្នកទិញ”</span> បន្ទាប់​ពី​ភាគី <span class="text-bold">“អ្នកទិញ”៖</span> <span class="text-bold">(១).</span> បាន​ទទួល​យក​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ​ពី​ភាគី <span class="text-bold">“អ្នកលក់”</span> រួច​រាល់​ហើយ <span class="text-bold">(២).</span> បាន​ទូ​ទាត់​បង់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​រួច​រាល់​គ្រប់​ចំនួន​ជូនមក ភាគី <span class="text-bold">“អ្នកលក់”</span> ដូច​បាន​ចែង​ក្នុង​ឧបសម្ព័ន្ធទី១ <span class="text-bold">"តារាង​កាល​វិភាគ​នៃ​ការ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ" (៣).</span> មក​បំពេញ​បែប​បទ និង​ឯកសារ​គ្រប់គ្រាន់​ជូន​ភាគី <span class="text-bold">“អ្នកលក់”</span> ដើម្បី​រៀប​ចំ​ដាក់​ស្នើ ឬ​រៀប​ចំ​បែបបទ​រដ្ឋបាល​ជា​មួយ​មន្ត្រី​ជំនាញ​សុរិយោ​ដី​ដើម្បី​ស្នើ​ទៅ​តាម​នីតិ​វិធី​ច្បាប់ឲ្យ​បាន​ទាន់​ពេល​វេលា និង​រលូន​ជូន​ភាគី <span class="text-bold">“អ្នកទិញ”</span> (ប្រសិន​បើ​ត្រូវ​ការ)។ ទោះ​ជា​យ៉ាង​ណា​ក៏​ដោយ​ ប្រសិន​បើ​មាន​ការ​យឺត​យ៉ាវ​ក្នុង​ការ​សម្រេច និង​អនុញ្ញាត​ចេញ​ប័ណ្ណ​បញ្ជាក់​សិទ្ធិ​លើ​កម្មសិទ្ធិ​លើ​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ ដោយ​សារ​តែ​បញ្ហា​បច្ចេកទេស ឬ​រដ្ឋបាល​របស់​មន្ត្រី​សុរិយោដី ឬ​មន្ត្រី​មាន​សមត្ថកិច្ច​នោះ ភាគី <span class="text-bold">“អ្នកទិញ”</span> មិន​អាច​តវ៉ា ឬ​ទំលាក់​កំហុស​លើ​ភាគី <span class="text-bold">“អ្នកលក់”</span> ដែល​បាន​ប្រឹងប្រែង​អស់​ពី​សមត្ថភាព​ហើយ​នោះទេ។ ការ​ចំណាយ​លើ​ការ​រៀប​ចំ​ឯកសារ​ផ្ទេរ​សិទ្ធិ​លើ​កម្មសិទ្ធិ ដូច​ចែងក្នុង <span class="text-bold">ប្រការ១</span> បូក​រួម​នឹង​ការ​បង់​ពន្ធ​ប្រថាប់​ត្រា <span class="text-bold">៤% (បូនភាគរយ)</span> គឺ​ជាការ​ទទួល​ខុស​ត្រូវ​ដោយ​ផ្ទាល់​របស់ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ដោយ​ភាគី <span class="text-bold">“អ្នកលក់”</span> ជួយ​សម្រួល និង​រៀបចំ​ឯក​សារ​ពាក់​ព័ន្ធ​ជូន​ទៅ​តាម​ស្ថាន​ភាព​ជាក់ស្តែង។</p>

<p class="english text-justify">“The seller” pledges to hand over the Certificate of Ownership of Immoveable Property with its type as stated in Article 1: Identity of Immoveable Property and Sale-Purchase Price to “the purchaser” after “the purchaser” (1) has already received the immoveable property from “The seller”, (2) has paid the sale-purchase price of the immoveable property to “The seller” in full amount, as stated in Annex 1 "Schedule of Payment of Sale-Purchase Price of the Immoveable Property", (3) has came to fill out sufficient forms and documents in order for “The seller” to submit a request or to complete administrative formality with line cadaster officer in order to make a request in accordance with legal procedures for “the purchaser” in timely and smooth manners (if needed). However, should there be any delay in making decision and giving authorization for issue of the Certificate of Ownership of Immoveable Property due to technical problem or administration of the Cadaster Officer or any competent officer, “the purchaser” shall not be entitled to make a protest or slander “The seller” who has put all of his/her efforts. Expense incurred for preparation of document for ownership transfer, as stated in Article 1, including stamp tax of 4% (four percent) shall be borne by “the purchaser”, and “The seller” will help facilitate and prepare relevant documents according to actual situation.</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៨៖ ការទទួលខុសត្រូវបង់ពន្ធអចលនវត្ថុប្រចាំឆ្នាំរបស់គូភាគី</p>
<p class="english text-justify">Article 8: Responsibility for Payment of Annual Tax on Immoveable Property of the Two Parties</p>

<p class="khmer"><span class="text-bold">៨.១</span> ភាគី <span class="text-bold">“អ្នកលក់”</span> ទទួល​ខុស​ត្រូវ​ទាំង​ស្រុង​ចំពោះ​ការ​បង់​ពន្ធ​អចលនវត្ថុ​ប្រចាំ​ឆ្នាំ ឬ​បង់​ពន្ធ​ដី​មិន​បាន​ប្រើ​ប្រាស់​ឬ​ពន្ធ​នានា​ពាក់​ព័ន្ធ​នឹង​អាជីវកម្ម​សាង​សង់​លំនៅឋាន​របស់​ខ្លួន​មុន​កាលបរិច្ឆេទ​នៃ​ការ​ប្រគល់​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ​ជូន​ទៅ​ភាគី <span class="text-bold">“អ្នកទិញ”</span>។</p>

<p class="english text-justify">8.1. “The seller” shall bear full responsibility for payment of annual tax on immoveable property or tax on unused land or various taxes in relation to his/her development business prior to the date of handing over the immoveable property to “the purchaser”.</p>

<p class="khmer"><span class="text-bold">៨.២</span> ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​ទទួល​ខុស​ត្រូវ​លើ​ការ​បង់​ពន្ធ​អចលវត្ថុ​ប្រចាំ​ឆ្នាំ និង​ពន្ធ​ផ្សេង​ទៀត​ពាក់​ព័ន្ធ​នឹង​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ​ខាង​លើ​បន្ទាប់​ពី​កាល​បរិច្ឆេទ​ទទួល​យក​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ ពីភាគី <span class="text-bold">“អ្នកលក់”</span>។</p> 

<p class="english text-justify">8.2. “the purchaser” shall bear responsibility for annual tax on immoveable property and other taxes in relation to the immoveable property after the date of receiving the immoveable property from “The seller”.</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៩៖ ទាយាទ អ្នកស្នងមរតក និងអ្នកទទួលសិទ្ធិស្របច្បាប់</p>
<p class="english text-bold">Article 9: Heir, Successor and Legal Assignee</p>

<p class="khmer">ក្នុង​ករណី​ដែល​មាន​ភាគី​ណា​មួយ មិន​អាច​អនុវត្ត​សិទ្ធិ និង​កាតព្វកិច្ច​របស់​ខ្លួន​បាន​ដោយ​មូលហេតុ​ណា​មួយ​បណ្តាល​មក​ពី មរណភាព ពិការភាព ឬ​អវត្តមាន​ជា​បណ្តោះ​អាសន្ន ឬ​អចិន្ត្រៃយ៍​នៅ​ក្នុង​ប្រទេស​នោះ រាល់​សិទ្ធិ និង​កាតព្វកិច្ច​ទាំង​អស់​របស់​ភាគី​នោះ​ដែល​ស្ថិត​ក្រោម​ខ្លឹមសារ​នៃ​កិច្ចសន្យា​នេះ ត្រូវ​បន្ត​ទៅ​ទាយាទ និង/ឬ អ្នក​ស្នង​មរតក និង/ឬអ្នកតំណាង​ស្រប​ច្បាប់​ណា​មួយ​របស់​ខ្លួន​ដោយ​ស្វ័យប្រវត្តិ។</p>

<p class="english text-justify">In case either party is unable to implement their rights and obligations due to his/her death, disability or temporary or permanent absence in the country, all rights and obligations of that party under the content of this contract shall automatically transferred to one of his/her heir and/or successor and/or legal representative.</p>

<p class="khmer-title pb-0 mb-0">ប្រការ១០៖ គោលការណ៍ស្ម័គ្រចិត្ត និងការព្រមព្រៀងនៃកិច្ចសន្យា</p>
<p class="english text-bold">Article 10: Principle of Free Will and Agreement of the Contract</p>

<p class="khmer">កិច្ចសន្យា​លក់​ទិញ​អចលនវត្ថុ​នេះ ត្រូវ​ធ្វើ​ឡើង​ដោយ​គ្មាន​ការ​គំរាម​កំហែង បង្ខិតបង្ខំ ឬ​មាន​បញ្ហា​ខុស​ច្បាប់​ណា​មួយ​ឡើយ ហើយ <span class="text-bold">គូភាគី</span> មាន​សមត្ថភាព​គ្រប់គ្រាន់​ក្នុង​ការ​ដឹង​លឺ ឬ​យល់​ដឹង បាន​អាន បានស្តាប់ និង​យល់​ព្រម​តាម​លក្ខខណ្ឌ​ទាំងឡាយ​នៃ​កិច្ចសន្យា​នេះ។ កិច្ចសន្យា​លក់​ទិញ​អចលនវត្ថុ​នេះ មាន​សុពលភាព​នា​កាលបរិច្ឆេទ​ដែល <span class="text-bold">គូភាគី</span> បាន​ផ្តិត​ស្នាម​មេដៃ និង​ចុះ​ត្រា​ក្រុមហ៊ុន​ដូច​ខាង​ក្រោម។ កិច្ចសន្យា​លក់ទិញ​អចលនវត្ថុ​នេះ​ធ្វើ​ឡើង​ជាភាសាខ្មែរ​ចំនួន <span class="text-bold">០២ (ពីរ)</span> ឯកសារ​ច្បាប់​ដើម ក្នុងនោះ ភាគី <span class="text-bold">“អ្នកលក់”</span> រក្សាទុក <span class="text-bold">០១ (មួយ)</span> ឯកសារ​ច្បាប់ដើម ហើយភាគី <span class="text-bold">“អ្នកទិញ”</span> រក្សាទុក <span class="text-bold">០១ (មួយ)</span> ឯកសារ​ច្បាប់​ដើម។ ឯកសារ​នីមួយៗ​មាន​សុពលភាព និង​អានុភាព​គតិយុត្តិ​ស្មើៗ និងដូចគ្នា។</p>

<p class="english text-justify">This Contract on Sale-Purchase of Immoveable Property is made without threat, coercion, or any illegal issue, and the two parties have full capacity to acknowledge or recognize, have read and listened to, and have agreed to various conditions of this contract. This Contract on Sale-Purchase of Immoveable Property is valid from the date the two parties have affixed their thumbprints and company stamps hereunder. This Contract on Sale-Purchase of Immoveable Property is made in Khmer language, in 2 (two) original copies; of which, “The seller” retains 1 (one) original copy, and “the purchaser” retains 1 (one) original copy. Each document has equal and same validity and legal effect.</p>
@endsection

@section('first')
<h4 class="khmer-title text-center">ឧបសម្ព័ន្ធទី៣</h4>
<h4 class="khmer-title text-center">អត្តសញ្ញាណប័ណ្ណ ឬលិខិតឆ្លងដែនរបស់ភាគី អ្នកលក់ និងភាគី អ្នកទិញ</h4>
<h4 class="english text-center text-bold my-0 py-0">Annex 3</h4>
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