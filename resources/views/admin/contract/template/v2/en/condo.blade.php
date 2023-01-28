@extends('admin.contract.template.v2.en.template')
@section('page_title', "Contract $contract->customer1_name")
@section('contract_type')
<h3 class="khmer-title text-center mt-3 mb-3">កិច្ចសន្យាលក់ ទិញ ខុនដូ​ {{ $project->name }}</h3>
<h3 class="english text-center mt-3 mb-3 en">CONTRACT ON CONDOMINIUM SALE-PURCHASE {{ $project->name_en }}</h3>
@endsection

@section('project_suffix')
“អគារសហកម្មសិទ្ធិ”
@endsection
@section('project_suffix_en')
“Co-Ownership Building”
@endsection

@section('praka')
<p class="khmer-title py-0 my-0">ប្រការ១៖ អត្តសញ្ញាណនៃអចលនវត្ថុលក់ទិញ និងតម្លៃលក់ទិញ</p>
<p class="english text-bold">​Article 1: Identity of Immoveable Property and Sale-Purchase Price</p>
<p class="khmer"><span class="text-bold">១.១.</span> ភាគី <span class="text-bold">“អ្នកលក់”</span> គឺ​ជា​កម្មសិទ្ធិករ​ស្រប​ច្បាប់​លើ​អចលនវត្ថុ យល់​ព្រម​លក់ ហើយ ភាគី <span class="text-bold">“អ្នកទិញ”</span> 
យល់​ព្រម​ទិញ​នូវ​អចលនវត្ថុ​ដូច​មាន​ចែង​ក្នុង​តារាង​អត្តសញ្ញាណ​នៃ​អចលនវត្ថុ​លក់ទិញ និង​តម្លៃ​លក់​ទិញ​នេះ។</p>
<p class="english text-justify">1.1. "The seller" is the legal owner of the immoveable property and agrees to sell, and "the purchaser" agrees to purchase the immoveable property (private space of the co-ownership building) as stated in the table of identity of immoveable property and of the sale-purchase price.</p>

<p class="khmer py-0 my-0"><span class="text-bold">១.២.</span> តារាងអត្តសញ្ញាណនៃអចលនវត្ថុលក់ទិញ និងតម្លៃលក់ទិញ (“អចលនវត្ថុ”)៖</p>
<p class="english text-bold text-justify">1.2. Table of Identity of Immoveable Property (Private Space of the Co-Ownership Building) and Sale-Purchase Price ("Immoveable Property")</p>
<table class="table table-p-1 table-contract-bordered">
    <tr>
    	<td width="180px" class="text-bold">
            <p class="khmer my-0 py-0">ប្រភេទ</p>
            <p class="english my-0 py-0">Type</p>
        </td>
    	<td width="30px" class="text-center">៖</td>      
    	<td class="english text-bold">{{ $unit_type->name }}</td>
    	<td width="100px" class="text-bold">
            <p class="khmer my-0 py-0">ចំណែកឯកជនលេខ</p>
            <p class="english my-0 py-0">Private Space No.</p>
        </td>
    	<td width="30px" class="text-center">៖</td>
    	<td width="250px" class="english text-bold">{{ isset($is_template) ? '_______________' : $unit->code }}</td>
    </tr>
    <tr>
    	<td width="180px" class="text-bold">
            <p class="khmer my-0 py-0">ជាន់ទី</p>
            <p class="english my-0 py-0">Floor</p>
        </td>
    	<td width="30px" class="text-center">៖</td>      
    	<td class="english text-bold">    		
    		@if( isset($is_template) )
    			_______________
    		@else
    			{{ $unit->floor }} 
    		@endif
    	</td>
    	<td width="100px">
            <p class="khmer my-0 py-0 text-bold">ទំហំសំណង់</p>
            <p class="english my-0 py-0 text-bold">Size of the Construction</p>            
            <small class="khmer font-italic">(ជាទំហំក្រឡាផ្ទៃចំណែកឯកជន និង ទំហំក្រឡាផ្ទៃប្រើប្រាស់រួម)</small>
            <p class="english font-italic">(Size of the private space in square meter and size of the common space in square meter)</p>
        </td>
    	<td width="30px" class="text-center">៖</td>
    	<td width="250px">
    		<p class="english pb-0 text-bold">
    		@if( isset($is_template) )
    			_______________ 
    		@else
    			{{ $unit->building_area }} 
    		@endif
    		</p>
    		<small class="khmer font-italic">(ដែល​អាច​មាន​ការ​ប្រែប្រួល​ជា​លក្ខណៈ​បច្ចេកទេស​ត្រឹម ៣ម៉ែត្រក្រឡា លើស ឬ ខ្វះ អាស្រ័យ​លើ​ការ​កំណត់​ព្រុំ​របស់​មន្ត្រី​សុរិយោដី ហើយ​គូភាគី​នឹង​មិន​តវ៉ា​ទាមទារ​សំណង​ពីគ្នា​ឡើយ)។</small>
            <p class="english font-italic">(Which can be changed by 3 square meters due to technical issue; the size might be bigger or smaller according to border marking by the Cadaster Officer, and the two parties will not protest against it or claim any compensation from one another).</p>
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
            <p class="khmer my-0 py-0">សេវានិងថ្លៃគ្រប់គ្រងថែទាំ</p>
            <p class="english my-0 py-0">Management and Maintenance Service and Fees</p>
        </td>
    	<td width="30px" class="text-center">៖</td>      
    	<td colspan="4">
    		<p class="khmer pb-0">
                @if(isset($is_template))
                _______________ (______________________________)
                @else
                {{ $contract->total_managment_fee_km }} ({{$contract->total_management_fee_in_word_km}})
                @endif
                ដុល្លារអាមេរិកក្នុងមួយខែ 
    		</p>
    		<small class="khmer font-italic">ដោយត្រូវបង់សរុបមួយឆ្នាំម្តងៗ  ដោយគិតលើមូលដ្ឋាន ស្មើនឹងចំនួន {{ $contract->management_fee_per_square }} ({{ $contract->management_fee_per_square_in_word_km }}) ក្នុងមួយម៉ែត្រក្រឡាក្នុងមួយខែ នៃទំហំក្រឡាផ្ទៃចំណែកឯកជន និង ទំហំក្រឡាផ្ទៃប្រើប្រាស់រួមសរុប ដូចមានចែងលម្អិតក្នុងប្រការ ៦នៃកិច្ចសន្យានេះ ។</small>
            <p class="english pt-1 pb-0">
                @if(isset($is_template))
                ______________________ (____________________________) 
                @else
                {{ $contract->getTotalManagementFee() }} 
                ({{ numfmt_create('en', \NumberFormatter::SPELLOUT)->format($contract->getTotalManagementFee()) }})
                @endif
                US dollars per month 
            </p>
            <p class="english font-italic">by making a total payment once a year, at the rate of {{ $contract->management_fee_per_square }} ({{ numfmt_create('en', \NumberFormatter::SPELLOUT)->format($contract->management_fee_per_square) }}) US dollar only per square meter per month of the surface area of the private space and total surface area of the common space, as stated in detail in Article 6 of this contract.</p>
    	</td>
    </tr>
    <tr>
    	<td width="180px" class="text-bold">
            <p class="khmer my-0 py-0">ការផ្តល់ជូនសេវាបន្ថែម</p>
            <p class="english my-0 py-0">Provision of Additional Service</p>
        </td>
    	<td width="30px" class="text-center">៖</td>      
    	<td colspan="4">
            <p class="khmer my-0 py-0">{{ $contract->management_service_kh }}</p> <br>
    		<p class="english my-0 py-0">{{ $contract->management_service_en }}</p>
    	</td>
    </tr>
    <tr>
    	<td width="180px" class="text-bold">
            <p class="khmer my-0 py-0">ប្រភេទ​នៃ​ប័ណ្ណ​កម្មសិទ្ធិ​ដែល​ប្រគល់​ជូន​ភាគី “អ្នកទិញ” </p>
            <p class="english my-0 py-0">Type of Title Deed Provided to "the Purchaser"</p>
        </td>
    	<td width="30px" class="text-center">៖</td>      
    	<td colspan="4">
            <p class="khmer my-0 py-0">{{ $contract->title_clause_kh }}</p>
    		<p class="english my-0 py-0">{{ $contract->title_clause_en }}</p>
    	</td>
    </tr>  
    <tr>
    	<td width="180px" class="text-bold">
            <p class="khmer my-0 py-0">តម្លៃលក់ទិញ</p>
            <p class="english my-0 py-0">Sale-Purchase Price</p>
        </td>
    	<td width="30px" class="text-center">៖</td>
    	<td colspan="4">
            <p class="khmer mb-0 pb-0 text-bold">
                @if( isset($is_template) )
                    _______________ (______________________________)
                @else
                {{ $contract->unit_sale_price_after_discount_km }} ({{ $contract->unit_sale_price_after_discount_in_word_km }})
                @endif
                ដុល្លារអាមេរិក
            </p>
            <small class="khmer font-italic d-block mb-1">តម្លៃ​នេះ ជា​តម្លៃ​ដែល​មាន​ការ​តុប​តែង​រួម​បញ្ជូល​ទាំង​សម្ភារៈ​ប្រើប្រាស់​ដូច​មាន​ចែង​ក្នុង​ឧបសម្ព័ន្ធ៣។ ក្នុង​ករណី​ដែល រោង​ចក្រ​ដែល​អ្នក​ផ្គត់ផ្គង់​សម្ភារៈ​ឈប់​ផលិត​នូវ​ផលិតផលដែល ភាគី ”អ្នកលក់” បានជ្រើសរើស ភាគី អ្នកលក់” សូម​រក្សា​សិទ្ធិ​ក្នុង​ការ​ផ្លាស់ប្តូរ​បំពាក់​នូវ​សម្ភារៈ​ផ្សេង​ជំនួស​វិញ​ដោយ​រក្សា​នូវ​គុណភាព​ដដែល។</small>

            <p class="mb-0 pb-0 english text-bold">         
                @if( isset($is_template) )
                    _______________ (______________________________)
                @else
                {{ number_format($contract->getUnitSoldPriceAfterDiscount(),0) }} ({{ numfmt_create('en', \NumberFormatter::SPELLOUT) ->format($contract->getUnitSoldPriceAfterDiscount()) }})
                @endif
                US dollars
            </p>
            <p class="english font-italic">This price includes decoration and materials as stated in Annex 3. In case the factory supplying materials stops producing the products selected by “the seller”, “the seller” reserves the right to replace them with other materials with the same quality.</p>               
    	</td>    	
    </tr>
</table>

<p class="khmer"><span class="text-bold">១.៣.</span> ភាគី <span class="text-bold">“អ្នកទិញ”</span> យល់​ព្រម​ទទួល​យក​ទាំង​ស្រុង​នូវ​ប្លង់​រចនា​ម៉ូដ​សំណង់ ព្រម​ទាំង​សន្យា​ថា​មិន​កែប្រែ​រចនាបទ ឬទ្រង់ទ្រាយ ឬគ្រោង​សំណង់​ខាងក្នុង និង​ខាង​ក្រៅ​អចលនវត្ថុ​ដោយ​ខ្លួនឯង ឬ​តាម​រយៈ​ការ​ជួល​បុគ្គល​ដទៃ​មក​ធ្វើការ​កែប្រែ​រចនាបទ ឬទ្រង់ទ្រាយ ឬ​គ្រោង​សំណង់​នៃ​អចលនវត្ថុ​នោះ​ទេ។ ប្រសិន​បើ​មាន​ការ​ចាំបាច់ ភាគី <span class="text-bold">“អ្នកទិញ”</span> អាច​ដាក់​លិខិត​ស្នើ​សុំ​មក​ភាគី <span class="text-bold">“អ្នកលក់”</span> ដោយ​មាន​បញ្ជាក់​ពី​មូលហេតុ​អោយ​បាន​ត្រឹមត្រូវ ច្បាស់លាស់ និងសមរម្យ។ ក្នុង​ករណី​ដែល​ភាគី <span class="text-bold">“អ្នកលក់”</span> ពិចារណា​ហើយ​អនុញ្ញាត និង​យល់​ព្រម​តាម​ការ​ស្នើ​សុំ​នោះ ភាគី <span class="text-bold">“អ្នកលក់”</span> គឺ​ជា​អ្នក​កំណត់ និង​ជ្រើសរើស​បុគ្គល​ណាមួយ ដែល​ខ្លួន​គិត​ថា​មាន​លក្ខណៈ​សម្បត្តិ​គ្រប់គ្រាន់​ក្នុង​ការ​ទទួល​យក​ការងារ​នេះ ដោយ​ការ​ចំណាយ​ទាំងអស់​ជា​បន្ទុក​របស់​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ដែល​បាន​ស្នើសុំ។</p>

<p class="english text-justify">1.3. "The purchaser" agrees to completely accept the construction design as well as pledges not to modify its pattern or feature or construction structure both inside and outside the immoveable property by his/herself or by hiring someone else to do so. If necessary, "the purchaser" can file a Letter of Request for Modification with "the seller" by specifying a proper, clear and appropriate reason. In case "the seller" takes it into consideration then authorizes the modification and agrees as per the request, "the seller" shall be the one who determines and selects any individual, who is deemed qualified, to do such work, and all expenses incurred shall be the burden of "the purchaser" who makes the request.</p>

<p class="khmer-title pb-0 mb-0">ប្រការ២៖ ការទូទាត់ប្រាក់ថ្លៃលក់ទិញអចលនវត្ថុ</p>
<p class="english text-justify text-bold">Article 2: Payment of Immoveable Property Sale-Purchase Price</p>

<p class="khmer"><span class="text-bold">២.១.</span> ដោយ​មាន​ការ​ព្រមព្រៀង​គ្នា​ក្នុង​ការ​លក់​ទិញ នូវ​អចលនវត្ថុ​ដូច​បាន​ចែង​ក្នុង​ប្រការ១ <span class="text-bold">“អត្តសញ្ញាណ​នៃ​អចលនវត្ថុ​លក់​ទិញ និងតម្លៃ​លក់​ទិញ”</span> ខាងលើ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ខាង​លើ​ទៅ​តាម​ដំណាក់កាល​នៃ​ការ​ទូទាត់​ឲ្យ​បាន​ត្រឹមត្រូវ គ្រប់​ចំនួន​ និង​ទាន់​ពេល​វេលា​ជា​បន្ត​បន្ទាប់​ដូច​បាន​ចែង​ក្នុង​ឧបសម្ព័ន្ធទី១ <span class="text-bold">“តារាងកាលវិភាគ​នៃ​ការ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ”</span>។ ភាគី <span class="text-bold">“អ្នកទិញ”</span> អាច​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ដោយ​ផ្ទាល់​នៅ​ការិយាល័យ​របស់​ភាគី <span class="text-bold">“អ្នកលក់”</span> ឬ​តាម​រយៈ​គណនី​ធនាគារ <span class="text-bold">{{ $bank->short_name }}</span> ដូច​មាន​ព័ត៌មាន​លម្អិត​ខាង​ក្រោមនេះ៖</p>

<p class="english text-justify">2.1. With mutual agreement to sale-purchase of the immoveable property as stated in Article 1 “Identity of the Immoveable Property and Sale-Purchase Price” above, “the purchaser” shall continuously make payment of the sale-purchase price of the said immoveable property in installments in proper manner, in full amount and in timely manner, as stated in Annex 1 “Schedule of Payment of Sale-Purchase Price of the Immoveable Property”. “The purchaser” shall be entitled to make payment of the sale-purchase price of the immoveable property at the office of “the seller” directly or via an account at {{ $bank->short_name }} Bank with the following details:</p>

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
                <td class="text-center">{{ $bank->account_name }}</td>
                <td class="text-center">{{ $bank->account_number }}</td>
            </tr>
        </table>
    </div>
</div>

<p class="khmer"><span class="text-bold">២.២.</span> ភាគី <span class="text-bold">“អ្នកលក់”</span> អនុគ្រោះ​ជូនភាគី <span class="text-bold">“អ្នកទិញ”</span> ក្នុង​ការ​យឺតយ៉ាវ ឬ​ខក​ខាន​ទូទាត់​ប្រាក់ថ្លៃ​លក់ទិញ​អចលនវត្ថុ​ត្រឹមរយៈពេល <span class="text-bold">០៧ (ប្រាំពីរ) ថ្ងៃប្រតិទិន</span> ដោយ​មិន​បង់​ប្រាក់​ពិន័យ។ ផុត​ពី​រយៈ​ពេល​អនុគ្រោះ​នេះ ក្នុង​ករណី​ដែល​ភាគី <span class="text-bold">“អ្នកទិញ”</span> យឺតយ៉ាវ ឬ​ខកខាន​មិន​បាន​បំពេញ​កាតព្វកិច្ច​ទូទាត់​បង់ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ជូន​ភាគី <span class="text-bold">“អ្នកលក់”</span> ទៅ​តាម​ដំណាក់​កាល​នៃ​ការ​ទូទាត់​ឲ្យ​បាន​ត្រឹមត្រូវ គ្រប់ចំនួន និង​ទាន់​ពេល​វេលា​ទេ​នោះ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​បង់​ប្រាក់​ពិន័យ​លើ​ការ​យឺតយ៉ាវ ឬ​ខក​ខាន​នោះ​ក្នុង​មួយថ្ងៃ <span class="text-bold">០៥ (ប្រាំ) ដុល្លារ​អាមេរិក</span>។ ក្នុង​ករណី​ដែល​ការ​យឺតយ៉ាវ ឬ​ខក​ខាន​ក្នុង​ការ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​នោះ​នៅ​តែ​បន្ត​លើសពី រយៈពេល <span class="text-bold">០២ (ពីរ) ខែ</span>​ជាប់ៗ​គ្នា ឬ​ក្នុង​ចន្លោះ​រយៈ​ពេល​ណា​មួយ​ដែល​ផល​បូក​នៃ​រយៈ​ពេល​ទាំង​នោះ​លើស​ពី <span class="text-bold">០២ (ពីរ) ខែ</span> នោះ​ត្រូវ​បាន​សន្មត់ទុក​ជា​មុន និង​ចាត់​ទុក​ថា ភាគី <span class="text-bold">“អ្នកទិញ”</span> រំលាយ​កិច្ចសន្យា​ដោយ​ឯកតោ​ភាគី ដោយ​បោះបង់​ចោល​នូវ​សិទ្ធិ​ទាំង​ឡាយ​ដែល​មាន​លើអចលនវត្ថុ ការ​លក់​ទិញ​អចលនវត្ថុ និង​ចំនួន​ទឹក​ប្រាក់​ដែល​ខ្លួន​បាន​ទូទាត់​មក​ឲ្យ​ភាគី <span class="text-bold">“អ្នកលក់”</span>។ ក្នុង​ករណី​នេះទឹក​ប្រាក់​ដែល​បាន​ទូទាត់​ហើយ​ទាំងអស់​ត្រូវ​ក្លាយ​ជា​ប្រយោជន៍​សម្រាប់​ភាគី <span class="text-bold">“អ្នកលក់”</span> ហើយ ភាគី <span class="text-bold">“អ្នកលក់”</span> មាន​សិទ្ធិ​ពេញ​លេញ​ដោយ​ស្រប​ច្បាប់​ក្នុង​ការ​លក់​អចលនវត្ថុ​ខាង​លើ​ឲ្យ​ទៅ​អតិថិជន ឬ​អ្នក​ទិញ​ផ្សេង​ទៀត​បាន ដោយ​ភាគី <span class="text-bold">“អ្នកទិញ”</span> សន្យា​ថា​នឹង​មិន​តវ៉ា ឬ​ជំទាស់​ឡើយ។ ក្នុង​ករណី​នេះ ប្រសិន​បើ ភាគី <span class="text-bold">“អ្នកទិញ”</span> បាន​ទទួល​យក​អចលនវត្ថុ​ពី ភាគី <span class="text-bold">“អ្នកលក់”</span> ហើយនោះ ភាគី <span class="text-bold">“អ្នកលក់”</span> ទុក​រយៈ​ពេល​ឲ្យ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ដែល​បោះបង់​សិទ្ធិ​លើ​ការ​លក់​ទិញ និង​អចលនវត្ថុ​នោះ <span class="text-bold">០១ (មួយ) ខែ</span> សម្រាប់​រើចេញ​ពី​អចលនវត្ថុ។</p>

<p class="english text-justify">2.2. “The seller” gives “the purchaser” a grace period for delay or failure to make payment of the sale-purchase price of the immoveable property by 7 (seven) calendar days without paying a fine. After this grace period, should “the purchaser” delay or fail to fulfill the obligation of making payment of the sale-purchase price of the immoveable property to “the seller” as per the installment plan in proper manner, in full amount and in timely manner, “the purchaser” shall pay a fine for the said delay or failure at an amount of 5 (five) US dollars per day. In case the said delay or failure to make payment of the sale-purchase price of the immoveable property continues for more than 2 (two) consecutive months or at any periods, which the sum of those periods is more than 2 (two) months, it shall be assumed and deemed that “the purchaser” unilaterally dissolves the contract by waiving all existing rights over the immoveable property and the amount of money which he/she has made payment to “the seller”. In such case, all the amount of money which has already been paid shall become the benefit of “the seller”, and “the seller” shall have absolute and legal right to sell the said immoveable property to other customer or purchaser, which “the purchaser” pledges not to make a protest or an objection. In such case, should “the purchaser” have already accepted the immoveable property from “the seller”, “the seller” shall give “the purchaser” who abandons his/her right over the sale-purchase and the said immoveable property a 1 (one)-month period for moving out of the immoveable property. </p>

<p class="khmer-title pb-0 mb-0">ប្រការ៣៖ ការលក់ ឬផ្ទេរសិទ្ធិលើការលក់ទិញអចលនវត្ថុបន្តទៅតតិយជន និងឥណទានពីធនាគារ</p>
<p class="english text-bold">Article 3: Resale or Retransfer of Right over the Sale-Purchase of the Immoveable Property to Third Party and Credit from Bank</p>
<p class="khmer"><span class="text-bold">៣.១.</span> ក្នុង​កំឡុង​ពេល​នៃ​ការ​អនុវត្ត​កិច្ចសន្យា​លក់​ទិញ​នេះ ភាគី <span class="text-bold">“អ្នកទិញ”</span> អាច​លក់ ឬ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ​អចលនវត្ថុ​ទៅ​ តតិយជន​ណា​មួយ​បាន​ដោយ​ការ​ស្នើ​សុំ​ជា​លាយ​លក្ខណ៍​អក្សរ ហើយ​ទទួល​បាន​ការ​អនុញ្ញាត​យល់​ព្រម​ពី​ភាគី <span class="text-bold">“អ្នកលក់”</span> ដោយភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​បង់​ថ្លៃ​សេវា​រដ្ឋបាល​លើ​ការ​លក់ ឬ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ អចលនវត្ថុ​នេះ​ស្មើ​នឹង <span class="text-bold">{{ $contract->contract_transfer_fee_km }} ({{ $contract->contract_transfer_fee_in_word_km }}) ដុល្លារ​អាមេរិក</span> ជូន​ភាគី <span class="text-bold">“អ្នកលក់”</span>។ មុន​នឹង​អាច​លក់ ឬ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ​អចលនវត្ថុ​ទៅ​តតិយជន​ណា​មួយ​បាន ប្រសិន​បើ​ភាគី <span class="text-bold">“អ្នកទិញ”</span> យឺតយ៉ាវ ឬ​ខក​ខន​មិន​បាន​បំពេញ​កាតព្វកិច្ច​ទូទាត់​បង់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ជូន​ភាគី <span class="text-bold">“អ្នកលក់”</span> ទៅ​តាម​ដំណាក់​កាល​នៃ​ការ​ទូទាត់​ឲ្យ​បាន​ត្រឹមត្រូវ គ្រប់ចំនួន និងទាន់​ពេល​វេលា​ដូច​ចែង​ក្នុង​ <span class="text-bold">ប្រការ២</span> នោះ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​ទូទាត់​ប្រាក់​ដែល​នៅ​ជំពាក់ និង​ប្រាក់​ពិន័យ​លើ​ការ​យឺត​យ៉ាវ ឬ​ខក​ខាន​នោះ​ឲ្យ​រួច​រាល់​ជា​មុន​សិន។ តតិយជន​ដែល​ទទួល​ទិញ ឬ​ទទួល​ការ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ​អចលនវត្ថុ​នេះ ត្រូវ​គោរព​តាម​ទាំង​ស្រុង​នូវ​ខ្លឹម​សារ​នៃ​កិច្ចសន្យា​លក់​ទិញ​នេះ ហើយ​អនុវត្ត​តាម​បែប​បទ​រដ្ឋបាល​មួយ​ចំនួន​ដែល​ភាគី <span class="text-bold">“អ្នកលក់”</span> តម្រូវ។</p>

<p class="english text-justify">3.1. During the implementation of this Sale-Purchase Contract, “the purchaser” can resell or retransfer his/her right over the sale-purchase of the immoveable property to any third party by making a written request and obtaining authorization and agreement from “the seller”, and “the purchaser” shall make payment of administrative service fee for the sale or transfer of right over the said immoveable property, equivalent to an amount of {{ $contract->contract_transfer_fee }} ({{ numfmt_create('en', \NumberFormatter::SPELLOUT)->format($contract->contract_transfer_fee) }}) US Dollars to “the seller”. To be able to sell or transfer right over the sale-purchase of the immoveable property to any third party, should “the purchaser” delay or fail to fulfill the obligation of making payment of the sale-purchase price of the immoveable property to “the seller” as per the installment plan in proper manner, in full amount and in timely manner as stated in Article 2, “the purchaser” shall completely make payment of the outstanding amount and fine for such delay or failure first. The third party who purchases or accepts the right over the sale-purchase of the said immoveable property shall completely abide by the content of this Contract on Sale-Purchase and comply with some administrative formalities required by “the seller”.</p>
<p class="khmer"><span class="text-bold">៣.២.</span> ចំពោះ​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ដែល​ជ្រើស​រើស​ជម្រើស​បង់រម្លស់ <span class="english">(Loan)</span> ដែល​ភ្ជាប់​នឹង​អត្រា​ការ​ប្រាក់​ជាមួយ​ភាគី <span class="text-bold">“អ្នកលក់”</span> នៅ​ពេល​ដែល​សំណង់​អចលនវត្ថុ​សាងសង់​បាន​ចាប់ពី៧០% (ចិតសិបភាគរយ) ឡើង​ទៅ ភាគី <span class="text-bold">“អ្នកលក់”</span> សូម​រក្សា​សិទ្ធិ​ក្នុង​ការ​ចាត់​ចែង​បញ្ជូន​សិទ្ធិ​លើ​បំណុល​ដែល​ភាគី <span class="text-bold">“អ្នកទិញ”</span> មាន​ដោយ​ការ​បង់​រម្លស់​ជាមួយ ភាគី <span class="text-bold">“អ្នកលក់”</span> ឲ្យ​ទៅ​ធនាគារ​ណា​មួយ​ដែល​សហការ​ជាមួយ​ភាគី <span class="text-bold">“អ្នកលក់”</span> ហើយ​សេវា​ក្នុង​ការ​សិក្សា​ជា​មួយ​ធនាគារ​ទាំងនោះ គឺ​ជា​បន្ទុក​របស់​ភាគី <span class="text-bold">“អ្នកទិញ”</span>។</p>
<p class="english text-justify">3.2. For “the purchaser” who chooses making payment by mortgage (loan) bearing interest rate with “the seller”, upon the construction of the immoveable property is completed by 70% (seventy percent) or more, “the seller” reserves the right to arrange and transfer the right over any debt of “the purchaser” arising out of the payment by mortgage with “the seller” to any bank which cooperates with “the seller”, and service fee for conducting study of the property taken by that bank shall be the burden of “the purchaser”.</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៤៖ ការសន្យាប្រគល់អចលនវត្ថុ</p>
<p class="english text-bold">Article 4: Pledge to Hand Over the Immoveable Property</p>
<p class="khmer">ភាគី <span class="text-bold">“អ្នកលក់”</span> សន្យា​នឹង​ប្រគល់​អចលនវត្ថុ​ជូន​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ក្នុង​រយៈ​ពេល <span class="text-bold">{{ $contract->deadline_km }} ({{ $contract->deadline_in_word_km }}) ខែ​</span> ដោយ​រាប់​ចាប់​ពី​កាលបរិច្ឆេទ​ចុះ​កិច្ចសន្យា​លក់ទិញ​នេះ។ ក្នុង​ករណី​ដែល​មាន​ការ​យឺត​យ៉ាវ ឬ​ខកខាន​ក្នុង​​ការ​ប្រគល់​អចលនវត្ថុ​ជូន ភាគី <span class="text-bold">“អ្នកទិញ”</span> ភាគី <span class="text-bold">“អ្នកលក់”</span> សូម​រក្សា​សិទ្ធិ​ពន្យារ​ពេល​ថែម <span class="text-bold">{{ $contract->extended_deadline_km }} ({{ $contract->extended_deadline_in_word_km }}) ខែ​</span> បន្ថែម​ទៀត ជា​រយៈ​ពេល​អនុគ្រោះ ក្នុង​ការ​សន្យា​ប្រគល់​អចលនវត្ថុ​ជូន ភាគី <span class="text-bold">“អ្នកទិញ”</span>។ បើ​ផុត​រយៈ​ពេល​អនុគ្រោះ​ខាង​លើ​ហើយ ភាគី <span class="text-bold">“អ្នកលក់”</span> នៅ​តែ​មិន​ទាន់​មាន​អចលនវត្ថុ​គ្រប់លក្ខណៈ​បច្ចេកទេស​សំណង់​ជា​អចលនវត្ថុ​រួចរាល់ ឬ​សម្រេច (មានទ្វារ បង្អួច កញ្ចក់ លាបថ្នាំពណ៌ និងគ្រឿង​បង្គុំ​ផ្សេងៗ​រួចរាល់) ប្រគល់​ជូន​ភាគី “អ្នកទិញ” ទេ  ភាគី <span class="text-bold">“អ្នកលក់”</span> សូម​ទទួល​ខុស​ត្រូវ​ក្នុង​ការ​បង់​សំណង​ពិន័យ​ជូន ភាគី “អ្នកទិញ” ស្មើនឹងអត្រា ១% (មួយភាគរយ) ក្នុង​មួយ​ខែ នៃ​ប្រាក់​ដែល​ភាគី <span class="text-bold">“អ្នកទិញ”</span> បាន​ទូ​ទាត់​បង់​ជូន​ភាគី <span class="text-bold">“អ្នកលក់”</span> រាប់​ចាប់​ពី​កាលបរិច្ឆេទ​ដែល​ផុត​កំណត់​ត្រូវ​ប្រគល់​អចលនវត្ថុ​ជូនភាគី <span class="text-bold">“អ្នកទិញ”</span>។ គូ​ភាគី​បាន​សន្មត់ និង​ព្រម​ព្រៀង​គ្នា​ជា​មុន​ថា​នៅ​កាលបរិច្ឆេទ​ដែល​ភាគី <span class="text-bold">“អ្នកលក់”</span> បាន​ជូន​ដំណឹង​ស្តី​ពី​ការ​ត្រួត​ពិនិត្យ និងទទួល​អចលនវត្ថុ​ដែល​គ្រប់​លក្ខណៈបច្ចេកទេស​សំណង់​ជា​អចលនវត្ថុ​រួចរាល់ ឬសម្រេច ទោះ​បី​ជា​តាម​រយៈ​ទូរស័ព្ទ​ក្តី សារ​អេឡិចត្រូនិច​ក្តី លិខិត​ជូន​ផ្ទាល់​ដៃ​ក្តី ការ​ជូន​ដំណឹង​ទៅ​លំនៅឋានក្តី ឬលិខិត​ជូន​តាម​ប្រៃសណីយ៍ក្តី ពោល​គឺ​តាម​វិធីសាស្ត្រ​ណា​មួយ​ដែល​សមស្រប​ដែលភាគី <span class="text-bold">“អ្នកទិញ”</span> អាច​ជ្រាប​ជា​ដំណឹង​បាន គឺ​មាន​ន័យ​ថា ភាគី <span class="text-bold">“អ្នកលក់”</span> មាន​អចលនវត្ថុ​ប្រគល់​ជូន ភាគី <span class="text-bold">“អ្នកទិញ”</span> នៅ​កាលបរិច្ឆេទ​នោះ​តែម្តង (ក្នុង​ករណី​ដែល​មាន​ការ​ស្នើ​សុំ​កែ​លម្អ ឬ​ជួស​ជុល​ការងារ​បច្ចេកទេស​បន្តិច​បន្ទួច​ផ្នែក​ខាង​ក្នុង ឬ​ខាង​ក្រៅ​អចលនវត្ថុ ដូច​ជាកា​រ៉ូ ថ្នាំ​លាប ប្រឡាក់​កញ្ចក់ ប្រេះ​ស៊ីម៉ងត៍បៀក ។ល។ មិន​ត្រូវ​បាន​ចាត់​ទុក​ថា ភាគី <span class="text-bold">“អ្នកលក់”</span> មិន​ទាន់​មាន​អចលនវត្ថុ​សម្រាប់​ប្រគល់​ជូន ភាគី <span class="text-bold">“អ្នកទិញ”</span> ឡើយ)។ ដោយ​ឡែក ប្រសិន​បើ​ភាគី <span class="text-bold">“អ្នកលក់”</span> បាន​បញ្ចប់​ការ​សាង​សង់​អចលនវត្ថុ​មុន​កាល​កំណត់ ភាគី <span class="text-bold">“អ្នកលក់”</span> នឹង​ធ្វើ​ការ​ជូន​ដំណឹង​ទៅ​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ស្តី​ពី​ការ​ត្រួត​ពិនិត្យ និង​ទទួល​អចលនវត្ថុ​មុន​កាល​កំណត់ ហើយ​ភាគី <span class="text-bold">“អ្នកទិញ”</span> មិន​ត្រូវ​យឺត​យ៉ាវ​ក្នុង​ការ​មក​ពិនិត្យ និងទទួល​ឡើយ បើ​មិន​ដូច​នោះ​ទេ ភាគី <span class="text-bold">“អ្នកលក់”</span> នឹង​មិន​ទទួល​ខុសត្រូវ ចំពោះ​ការ​យឺត​យ៉ាវ ឬខក​ខាន​ណា​មួយ​ជាយថាហេតុ​នៅ​ពេល​បន្ទាប់​ពីនោះ​ឡើយ។ ទាក់​ទង​នឹង​ការ​ប្រគល់​ទទួល​អចលនវត្ថុនេះ ភាគី <span class="text-bold">“អ្នកទិញ”</span> អាច​ទទួល​អចលនវត្ថុ​បាន​លុះ​ត្រាតែ <span class="text-bold">(១).</span> ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​ទូទាត់​ប្រាក់​ដែល​នៅ​ជំពាក់ និង​ប្រាក់​ពិន័យ​លើ​ការ​យឺត​យ៉ាវ ឬ​ខក​ខាន​នោះ​ឲ្យ​រួច​រាល់​ជា​មុន​សិន និង <span class="text-bold">(២).</span> ត្រូវ​បង់​ប្រាក់​ថ្លៃ​សេវា​គ្រប់​គ្រង​ថែ​ទាំ​បុរី​ដូច​មាន​ចែង​ក្នុង​ <span class="text-bold">ប្រការ៦</span> ជូន​ភាគី <span class="text-bold">“អ្នកលក់”</span> សម្រាប់​រយៈ​ពេល​មួយ​ឆ្នាំ​ពេញ។ ចំពោះ​អចលនវត្ថុ​ដែល​ជា​កម្មវត្ថុ​នៃ​ការ​លក់​ទិញ​ណា​មួយ ដែល​ភាគី <span class="text-bold">“អ្នកទិញ”</span> មិន​ទាន់​បាន​ទូទាត់​ថ្លៃលក់ទិញ​រួច​រាល់​ទាំង​ស្រុង​ជូន ភាគី <span class="text-bold">“អ្នកលក់”</span> ទេ ភាគី <span class="text-bold">“អ្នកទិញ”</span> នោះ​មិន​ទាន់​ក្លាយ​ជា​ម្ចាស់​អចលនវត្ថុ​ពេញ​លេញ និង​ស្រប​ច្បាប់​ឡើយ ទោះ​បី​ជា​ភាគី <span class="text-bold">“អ្នកលក់”</span> បាន​ប្រគល់​អចលនវត្ថុ​នោះជូន ភាគី <span class="text-bold">“អ្នកទិញ”</span> ក៏ដោយ។</p>

<p class="english text-justify">“The seller” pledges to hand over the immoveable property to “the purchaser” within a period of {{ $contract->deadline }} ( {{ numfmt_create('en', \NumberFormatter::SPELLOUT)->format($contract->deadline) }}  ) months, from the date this Contract on Sale-Purchase is entered into. In case of delay or failure to hand over the immoveable property to “the purchaser”, “the seller” reserves the right to delay the construction period for another {{ $contract->extended_deadline }} ({{ numfmt_create('en', \NumberFormatter::SPELLOUT)->format($contract->extended_deadline) }}) months as a grace period of the pledge to hand over the immoveable property to “the purchaser”, so the total period shall be 36 (thirty-six) months. Should the said grace period be elapsed, and “the seller” is still yet to have an immoveable property with complete technical specifications of the construction as the finished or completed immoveable property (with door, window, mirror, painting and other structures be completed) to be handed over to “the purchaser”, “the seller” shall bear responsibility for paying compensation and fine to “the purchaser” at a monthly rate of 1% (one percent) over the amount of money which “the purchaser” has paid to “the seller” from the deadline of handing over the immoveable property to “the purchaser”. The two parties have determined and reached a mutual agreement in advance that when “the seller” gives a notice on inspection and receipt of the immoveable property with complete construction technical specifications as a finished or complete immoveable property, whether via phone call, electronic mail, or by handing a letter, giving notice to a residence or posted mail; to wit, through any appropriate way which “the purchaser” can be informed, it is implied that “the seller” has the immoveable property to be handed over to “the purchaser” on that day (in case of request for renovation or repair of minor technical work inside or outside the immoveable property, such as tile, paint, any spot on the mirror, crack of coated cement, etc., it shall not be considered that “the seller” does not have an immoveable property to be handed over to “the purchaser” yet). Should “the seller” finishes the construction of the immoveable property earlier, “the seller” will give a notice to “the purchaser” on early inspection and receipt of the immoveable property, and “the purchaser” shall not delay the inspection and receipt; otherwise, “the seller” will not bear responsibility for any eventual delay or failure later. In relation to the handover and receipt of the said immoveable property, “the purchaser” can receive the immoveable property only if “the purchaser” (1) has completely made payment of the outstanding amount and fine for such delay or failure in advance before he/she is entitled to receive the immoveable property from “the seller”, and (2) has made advance payment of Borey management and maintenance service fees as stated in Article 6 to “the seller” for one year. As for the immoveable property which “the purchaser” has yet to completely pay off the sale-purchase price to “the seller”, “the purchaser” has yet to completely and legally become the owner of that immoveable property though “the seller” has handed over the said immoveable property to “the purchaser”.</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៥៖ ការធានាគុណភាពសំណង់ ការកែប្រែសោភ័ណភាព និងប្លង់គោលលើអចលនវត្ថុនៃការលក់ទិញ</p>
<p class="english text-bold">Article 5: Guarantee for Construction Quality, Change of Aesthetics and Master Plan of the Immoveable Property</p>

<p class="khmer"><span class="text-bold">៥.១.</span> ដោយ​រាប់​ចាប់​ពី​កាលបរិច្ឆេទ​ដែល​ភាគី <span class="text-bold">“អ្នកលក់”</span> ប្រគល់​អចលនវត្ថុ​នៃ​ការ​លក់ទិញ​ជូន​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ភាគី <span class="text-bold">“អ្នកលក់”</span> សូម​ធានា​វិការៈ (លើ​គុណភាព​គ្រោង​សំណង់ និង​ការ​បាក់​ស្រុត​គ្រឹះ​សំណង់) សម្រាប់​រយៈពេល <span class="text-bold">០៣ (បី) ឆ្នាំ</span> និង​ធានា​វិការៈ​បច្ចេកទេស​សំណង់​ទូទៅ​ដូច​ជា​ការ​ប្រះ​ស្រាំ​ស៊ីម៉ងត៍បៀក ឬជញ្ជាំង ការជ្រាបទឹក សម្រាប់​រយៈពេល <span class="text-bold">០១ (មួយ) ឆ្នាំ</span> (លើក​លែង​តែ​គ្រឿង​បំពាក់​ឈើ បើ​សិន​ជា​មាន​ផ្តល់​ជូន គឺ​មិន​មាន​ការ​ធានា​ជួស​ជុល ឬ​ប្តូរ​ថ្មី​ជូន​ឡើយ​)។ បរិក្ខា​អគ្គិសនី​ដែល​បំពាក់​ក្នុង​អចលនវត្ថុ ត្រូវ​បាន​ធានា​ដោយ​យោង​ទៅ​តាម​លក្ខខណ្ឌ​ដែល​បាន​កំណត់ ដោយ​រោង​ចក្រ​ផលិត ឬ​អ្នក​លក់​បរិក្ខា​នោះ។ ផ្ទុយ​ទៅ​វិញ ប្រសិន​បើ​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ធ្លាប់​បាន​ធ្វើ​ការ​ជួសជុល ឬ​ផ្លាស់​ប្តូរ​ទ្រង់​ទ្រាយ​សំណង់​លើ​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ​ដោយ​ខ្លួនឯង ឬ​មិន​សម្អាត​លើ​វ៉េរ៉ងដា ឬ​ឥដ្ឋ​កន្សែង​ជាន់​ដំបូល ឬ​រុះ​រើ​ដំបូល​សំណង់ ដែល​បណ្តាល​ឲ្យ​មាន​ការ​ជ្រាប​ទឹកនោះ ភាគី <span class="text-bold">“អ្នកលក់”</span> មិន​ធានា​វិការៈជូនឡើយ។</p>

<p class="english text-justify">5.1. From the date “the seller” hands over the immoveable property to “the purchaser”, “the seller” shall give warranty for defect (of the quality of construction structure and subsidence of the construction) for 5 (five) years and give warranty for defect of general construction technique, such as crack of coated cement or wall, breakage of water system leads to water leakage, electricity system, sewage system for 1 (one) year (with exception of wooden fitting, should it be provided, there is no warranty for repair or replacement). For electrical appliance equipped in the immoveable property, there is warranty according to the condition set out by the manufacturer or seller of that appliance. However, if “the purchaser” used to carry it out repair or change any feature of the construction on the immoveable property by him/herself, or did not clean veranda or tile on the rooftop or removed roof of the construction leading to water leakage, “the seller” shall not give warranty for defect.</p>

<p class="khmer"><span class="text-bold">៥.២.</span> ភាគី <span class="text-bold">“អ្នកទិញ”</span> មិន​មាន​សិទ្ធិ​កែ​ប្រែ​សោភ័ណភាព​សំណង់ និង/ឬប្លង់គោល​លើ​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញឡើយ លុះត្រា​តែ​មាន​ការ​អនុញ្ញាត​ពី ភាគី <span class="text-bold">“អ្នកលក់”</span>។ ការ​កែប្រែ​សោភ័ណភាព​សំណង់ និង/ឬប្លង់គោល​លើ​អចលនវត្ថុ​នៃ​ការ​លក់ទិញ​ដោយ​គ្មាន​ការ​អនុញ្ញាត​ពី​ភាគី <span class="text-bold">“អ្នកលក់”</span> ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​ទទួល​ខុស​ត្រូវ​ចំពោះ​មុខ​ច្បាប់​ជាធរមាន ហើយ​ការ​ធានា​លើវិការៈ​សំណង់​ដូច​មាន​ចែង​ក្នុង​ប្រការ <span class="text-bold">៥.១</span> ខាងលើ លែង​មាន​អនុភាព​សម្រាប់ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ទៀតដែរ។</p>

<p class="english text-justify">5.2. “The purchaser” shall not be entitled to make change to aesthetics of the construction and/or master plan of the immoveable property unless there is an authorization from “the seller”. Should any change to aesthetics of the construction and/or master plan of the immoveable property be carried out without an authorization from “the seller”, “the purchaser” shall bear responsibility before the law in force, and the warranty for defect of the construction as stated in Article 5.1 above shall no longer take any effect for “the purchaser”.</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៦៖ ការគ្រប់គ្រងថែទាំ ថ្លៃសេវាថែទាំគ្រប់គ្រង បទបញ្ជាផ្ទៃ​ក្នុង​នៃ​អគារសហកម្មសិទ្ធិ និង​ការ​ជួល​អចលនវត្ថុ​ទៅ​ឲ្យ​តតិយជន</p>
<p class="english text-bold">Article 6: Management and Maintenance, Management and Maintenance Fees, Internal Regulations of Co-Ownership Building and Lease of Immoveable Property to a Third Party</p>

<p class="khmer"><span class="text-bold">៦.១.</span> បន្ទាប់​ពី​ប្រគល់​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ​ជូន​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ភាគី <span class="text-bold">“អ្នកលក់”</span> មាន​កាតព្វកិច្ច​ក្នុង​ការ​ផ្តល់​ជូន​នូវ​សេវា​គ្រប់គ្រង​ថែទាំ​ក្នុង​បរិវេណ​នៃ​អគារសហកម្មសិទ្ធិ​ទាំងមូល ដែល​មាន​ដូច​ជា​សេវា​សន្តិសុខ​សណ្តាប់ធ្នាប់ ២៤​ម៉ោងលើ​២៤ម៉ោង ជណ្តើរយន្ត  អនាម័យសាធារណៈ ភ្លើងបំភ្លឺផ្លូវ អាងហែលទឹក ការថែទាំសួនច្បារ និង​ទ្រព្យ​សម្បត្តិ​សាធារណៈ​ទាំង​ឡាយ​ផ្សេង​ទៀត។ ក្នុង​ករណី​នេះ ភាគី <span class="text-bold">“អ្នកទិញ”</span> មាន​កាតព្វកិច្ច​ទូទាត់​បង់​ថ្លៃ​សេវា​គ្រប់គ្រង​ថែទាំ​បុរី​ដូច​ចែង​ក្នុង​ <span class="text-bold">ប្រការ១​៖​ អត្តសញ្ញាណ​នៃ​អចលនវត្ថុ​លក់ទិញ និង​តម្លៃ​លក់ទិញ</span> សម្រាប់​រយៈ​ពេល​មួយ​ឆ្នាំ​ម្តង ហើយ​ត្រូវ​បង់​មួយ​ឆ្នាំ​ទុក​ជា​មុន​ជូន​ទៅ ភាគី <span class="text-bold">“អ្នកលក់”</span>  មុន​ពេល​ទទួល​អចលនវត្ថុ​ពី ភាគី <span class="text-bold">“អ្នកលក់”</span> ហើយ​សេវា​នេះ​គិត​ចាប់​ពី​កាលបរិច្ឆេទ​ដែល ភាគី <span class="text-bold">“អ្នកទិញ”</span> ទទួល​យក​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញពី ភាគី <span class="text-bold">“អ្នកលក់”</span>។ ថ្លៃ​សេវា​ថែទាំ​គ្រប់គ្រង់​នេះ អាច​ត្រូវ​បាន​កែប្រែ​នា​ពេល​ណា​មួយ​ខាង​មុខ​ដោយ​ស្រប​ទៅ​តាម​តម្លៃ​ទីផ្សារ​ជាក់ស្តែង ហើយ​ភាគី <span class="text-bold">“អ្នកលក់”</span> នឹង​ជូន​ដំណឹង​ជា​សាធារណៈ​ទៅ​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ទាំងអស់​ក្នុងរយៈពេល <span class="text-bold">១ (មួយ) ខែ​</span>មុន​ការ​កែប្រែ​តម្លៃ​នេះ​ចូល​ជាធរមាន។</p>

<p class="english text-justify">6.1. After handing over the immoveable property to “the purchaser”, “the seller” shall be obliged to provide management and maintenance services within the compound of the entire co-ownership building, such as security and order services for 24 hours a day, lift, sanitation, lighting, swimming pool, gardening and other public properties care. In such case, “the purchaser” shall be obliged to make payment of Borey management and maintenance service fees, as stated in Article 1: Identity of Immoveable Property and Sale-Purchase Price, once a year, and shall make advance payment to “the seller” for one year before receiving the immoveable property from “the seller”, and the said service fee shall be charged from the date “the purchaser” receives the immoveable property from “the seller”. The said management and maintenance service fees might be changed at any time in the future, according to actual market price, and “the seller” will give a public notice to all “purchasers” within 1 (one) month before the change of the said fee takes effect.</p>

<p class="khmer"><span class="text-bold">៦.២.</span> បន្ទាប់​ពី​ទទួល​អចលនវត្ថុ​ពីភាគី <span class="text-bold">“អ្នកលក់”</span> ហើយ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​គោរព​យ៉ាង​ម៉ឺងម៉ាត់​នូវ​ខ្លឹមសារ​ទាំងឡាយ​នៃ​បទបញ្ជាផ្ទៃក្នុង​នៃ​អគារសហកម្មសិទ្ធិ​ដែល​រៀបចំ​ឡើង​ដោយភាគី <span class="text-bold">“អ្នកលក់”</span> ដោយ​ស្រប​ទៅ​តាម​ច្បាប់  បទបញ្ញត្តិនានា និង​ផល​ប្រយោជន៍​រួម​នៃ​ម្ចាស់​ចំណែក​ឯកជន​គ្រប់​រូប​នៅ​ក្នុង​អគារ​សហកម្មសិទ្ធិ​ដូចជា គោលការណ៍ សណ្តាប់ធ្នាប់ (មិន​ត្រូវ​មាន​សំលេង​ឡូឡា​ដែល​នាំ​ឲ្យ​រំខាន​ដល់​អ្នក​ជិតខាង) សុវត្ថិភាព សុខភាពអនាម័យ (មិន​ត្រូវ​ចោល​សំរាម មិន​ត្រូវ​ចិញ្ចឹម​សត្វ រួម​ទាំង​ឆ្កែ​ឆ្មា បក្សី ឬសត្វ​ផ្សេងៗទៀត) មិន​ត្រូវ​បង្ក​សកម្មភាព​ទាំងឡាយ​ណា​ដែល​នាំ​ដល់​ការ​បំពុល​បរិស្ថាន មិន​ត្រូវ​នាំ​អាវុធ​ជាតិផ្ទុះ ឬសារធាតុ​រំសេវ ឬ​គ្រឿង​ញៀន​ចូល​ក្នុង​បរិវេណ​អគារ​សហកម្មសិទ្ធិ មិន​អនុញ្ញាត​ឲ្យ​បើក​ទីតាំង​ល្បែង​ស៊ីសង​ខុសច្បាប់ ឬហាង​ទំនិញ ឬក្រុមហ៊ុន។ ទីតាំង និង​បរិវេណ​នៃ​អចលនវត្ថុ និង​អគារ​សហកម្មសិទ្ធិ គឺ​ត្រូវ​បាន​ប្រើប្រាស់​សម្រាប់​តែ​កម្មវត្ថុ​នៃ​ការ​ស្នាក់​នៅប៉ុណ្ណោះ។</p>

<p class="english text-justify">6.2. After receiving the immoveable property from “the seller”, “the purchaser” shall strictly abide by the content of the internal regulations of the co-ownership building drawn up by “the seller” in accordance with the law, various regulations and common benefits of all owners of private spaces in the co-ownership building, such as principle, order (shall not make noise leading to disturb to their neighbors), safety, health and sanitation (shall not litter, shall not raise animals, including dog, cat, bird or other animals), shall not commit any act which pollutes the environment, shall not bring explosive weapon or gunpowder or addictive substances into the compound of the co-ownership building, and it is not authorized to operate a place for illegal gambling or shop or company. The premises and compound of the immoveable property and the co-ownership building shall be used for residential purpose only.</p>

<p class="khmer"><span class="text-bold">៦.៣.</span> បន្ទាប់​ពី​ទទួល​អចលនវត្ថុ​ពីភាគី <span class="text-bold">“អ្នកលក់”</span> ហើយ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​ទិញ​ធានា​រ៉ាប់រង​អគ្គីភ័យ​ដោយ​ខ្លួនឯង ហើយ​ថ្លៃ​ជួសជុល​ផ្សេងៗ​ត្រូវ​ស្ថិត​ក្រោម​ការ​ចំណាយ​ផ្ទាល់​របស់ ភាគី <span class="text-bold">“អ្នកទិញ”</span> បន្ទាប់​ពី​រយៈពេល​ធានា​លើ​វិការៈ​ក្នុង​ការ​ជួសជុល​របស់ ភាគី <span class="text-bold">“អ្នកលក់”</span> ដូច​ចែង​ក្នុង​ <span class="text-bold">ប្រការ៥.១</span> ត្រូវ​បាន​បញ្ចប់។</p>

<p class="english text-justify">6.3. After receiving the immoveable property from “the seller”, “the purchaser” shall purchase fire insurance by him/herself, and fees of various repairs shall be under the own expenses of “the purchaser” after the period of warranty on repair by “the seller” as stated in Article 5.1 is elapsed.</p>

<p class="khmer"><span class="text-bold">៦.៤.</span> បន្ទាប់​ពី​ទទួល​អចលនវត្ថុ​ពី​ភាគី <span class="text-bold">“អ្នកលក់”</span> ហើយ​ក្នុង​ករណី​ដែល​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ជួល​អចលនវត្ថុ​ឲ្យទៅ តតិយជន​ណា​ម្នាក់ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​ជូន​ដំណឹង​ជា​លាយ​លក្ខណ៍​អក្សរ​មកភាគី <span class="text-bold">“អ្នកលក់”</span> អំពី​ការ​ជួល​នោះ និង​អត្តសញ្ញាណ​នៃ​អ្នក​ជួល​អចលនវត្ថុ​ដើម្បី​ឲ្យ​ភាគី <span class="text-bold">“អ្នកលក់”</span> មាន​ភាព​ងាយ​ស្រួល​ក្នុង​ប្រតិបត្តិការថែទាំ និង​គ្រប់គ្រង​អគារ​សហកម្មសិទ្ធិ​នេះ​ឲ្យ​មាន​ប្រសិទ្ធិភាព​ខ្ពស់ ហើយ​ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​តែ​ធានា​ថា​ខ្លួន​បាន​ពន្យល់​តតិយជន​ដែល​ជួល​នោះ​អំពី​បទបញ្ជាផ្ទៃក្នុង​នៃ​អគារសហកម្មសិទ្ធិ ហើយ​តតិយជន​នោះ ត្រូវ​គោរព​ឲ្យ​បាន​ត្រឹមត្រូវ​នូវ​រាល់​ខ្លឹមសារ​ទាំង​ឡាយ​ក្នុង​បទបញ្ជាផ្ទៃក្នុង​នៃ​អគារសហមកម្មសិទ្ធិ​នេះ។</p>

<p class="english text-justify">6.4. After receiving the immoveable property from “the seller”, in case “the purchaser” offers a lease of the immoveable property to any third party, “the purchaser” shall give a written notice to “the seller” regarding the said lease and identity of lessee of the immoveable property, in order for “the seller” to be easy in operating the maintenance and management of the co-ownership building in highly effective manner, and “the purchaser” shall guarantee that he/she has explained the third party who accepts the lease about the internal regulations of the co-ownership building, and that third party shall properly abide by all the content of the internal regulations of this co-ownership building.</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៧៖ ប័ណ្ណបញ្ជាក់សិទ្ធិលើកម្មសិទ្ធិនៃអចលនវត្ថុនៃការលក់ទិញ</p>
<p class="english text-bold">Article 7: Title Deed of Immoveable Property</p>

<p class="khmer">ភាគី <span class="text-bold">“អ្នកលក់”</span> សន្យា​ថា​នឹង​ប្រគល់​ប័ណ្ណ​បញ្ជាក់​សិទ្ធិ​លើ​កម្មសិទ្ធិ​នៃ​អចលនវត្ថុ​នៃ​ការ​លក់ទិញ ជា​ប្រភេទ​ដូច​ចែង​ក្នុង​ប្រការ ១៖<span class="text-bold">អត្តសញ្ញាណ​នៃ​អចលនវត្ថុ​លក់ទិញ និង​តម្លៃ​លក់​ទិញ</span> ជូនភាគី <span class="text-bold">“អ្នកទិញ”</span> បន្ទាប់​ពី​ភាគី <span class="text-bold">“អ្នកទិញ”៖</span> <span class="text-bold">(១).</span> បាន​ទទួល​យក​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ​ពី​ភាគី <span class="text-bold">“អ្នកលក់”</span> រួច​រាល់​ហើយ <span class="text-bold">(២).</span> បាន​ទូ​ទាត់​បង់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​រួច​រាល់​គ្រប់​ចំនួន​ជូនមក ភាគី <span class="text-bold">“អ្នកលក់”</span> ដូច​បាន​ចែង​ក្នុង​ឧបសម្ព័ន្ធទី១ <span class="text-bold">“តារាង​កាល​វិភាគ​នៃ​ការ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ” (៣).</span> មក​បំពេញ​បែប​បទ និង​ឯកសារ​គ្រប់គ្រាន់​ជូន​ភាគី <span class="text-bold">“អ្នកលក់”</span> ដើម្បី​រៀប​ចំ​ដាក់​ស្នើ ឬ​រៀប​ចំ​បែបបទ​រដ្ឋបាល​ជា​មួយ​មន្ត្រី​ជំនាញ​សុរិយោ​ដី​ដើម្បី​ស្នើ​ទៅ​តាម​នីតិ​វិធី​ច្បាប់ឲ្យ​បាន​ទាន់​ពេល​វេលា និង​រលូន​ជូន​ភាគី <span class="text-bold">“អ្នកទិញ”</span> (ប្រសិន​បើ​ត្រូវ​ការ)។ ទោះ​ជា​យ៉ាង​ណា​ក៏​ដោយ​ ប្រសិន​បើ​មាន​ការ​យឺត​យ៉ាវ​ក្នុង​ការ​សម្រេច និង​អនុញ្ញាត​ចេញ​ប័ណ្ណ​បញ្ជាក់​សិទ្ធិ​លើ​កម្មសិទ្ធិ​លើ​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ ដោយ​សារ​តែ​បញ្ហា​បច្ចេកទេស ឬ​រដ្ឋបាល​របស់​មន្ត្រី​សុរិយោដី ឬ​មន្ត្រី​មាន​សមត្ថកិច្ច​នោះ ភាគី <span class="text-bold">“អ្នកទិញ”</span> មិន​អាច​តវ៉ា ឬ​ទំលាក់​កំហុស​លើ​ភាគី <span class="text-bold">“អ្នកលក់”</span> ដែល​បាន​ប្រឹងប្រែង​អស់​ពី​សមត្ថភាព​ហើយ​នោះទេ។ ការ​ចំណាយ​លើ​ការ​រៀប​ចំ​ឯកសារ​ផ្ទេរ​សិទ្ធិ​លើ​កម្មសិទ្ធិ ដូច​ចែងក្នុង <span class="text-bold">ប្រការ ១</span> បូក​រួម​នឹង​ការ​បង់​ពន្ធ​ប្រថាប់​ត្រា <span class="text-bold">៤% (បូនភាគរយ)</span> គឺ​ជាការ​ទទួល​ខុស​ត្រូវ​ដោយ​ផ្ទាល់​របស់ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ដោយ​ភាគី <span class="text-bold">“អ្នកលក់”</span> ជួយ​សម្រួល និង​រៀបចំ​ឯក​សារ​ពាក់​ព័ន្ធ​ជូន​ទៅ​តាម​ស្ថាន​ភាព​ជាក់ស្តែង។</p>

<p class="english text-justify">“The seller” pledges to hand over the Title Deed of Immoveable Property with its type as stated in Article 1: Identity of Immoveable Property and Sale-Purchase Price to “the purchaser” after “the purchaser” (1) has already received the immoveable property from “the seller”, (2) has paid the sale-purchase price of the immoveable property to “the seller” in full amount, as stated in Annex 1 “Schedule of Payment of Sale-Purchase Price of the Immoveable Property”, (3) has came to fill out sufficient forms and documents in order for “the seller” to submit a request or to complete administrative formality with line cadaster officer in order to make a request in accordance with legal procedures for “the purchaser” in timely and smooth manners (if needed). However, should there be any delay in making decision and giving authorization for issue of the Title Deed of Immoveable Property due to technical problem or administration of the Cadaster Officer or any competent officer, “the purchaser” shall not be entitled to make a protest or slander “the seller” who has put all of his/her efforts. Expense incurred for preparation of document for ownership transfer, as stated in Article 1, including stamp tax of 4% (four percent) shall be borne by “the purchaser”, and “the seller” will help facilitate and prepare relevant documents according to actual situation.</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៨៖ ការទទួលខុសត្រូវបង់ពន្ធអចលនវត្ថុប្រចាំឆ្នាំរបស់គូភាគី</p>
<p class="english text-bold">Article 8: Responsibility for Payment of Annual Tax on Immoveable Property of the Two Parties</p>

<p class="khmer"><span class="text-bold">៨.១</span> ភាគី <span class="text-bold">“អ្នកលក់”</span> ទទួល​ខុស​ត្រូវ​ទាំង​ស្រុង​ចំពោះ​ការ​បង់​ពន្ធ​អចលនវត្ថុ​ប្រចាំ​ឆ្នាំ ឬ​បង់​ពន្ធ​ដី​មិន​បាន​បើ​ប្រាស់​ឬ​ពន្ធ​នានា​ពាក់​ព័ន្ធ​នឹង​អាជីវកម្ម​សាង​សង់​លំនៅឋាន​របស់​ខ្លួន​មុន​កាលបរិច្ឆេទ​នៃ​ការ​ប្រគល់​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ​ជូន​ទៅ​ភាគី <span class="text-bold">“អ្នកទិញ”</span>។</p>

<p class="english text-justify">8.1. “The seller” shall bear full responsibility for payment of annual tax on immoveable property or various taxes in relation to the business of constructing his/her co-ownership building prior to the date of handing over the immoveable property to “the purchaser”.</p>

<p class="khmer"><span class="text-bold">៨.២</span> ភាគី <span class="text-bold">“អ្នកទិញ”</span> ត្រូវ​ទទួល​ខុស​ត្រូវ​លើ​ការ​បង់​ពន្ធ​អចលវត្ថុ​ប្រចាំ​ឆ្នាំ និង​ពន្ធ​ផ្សេង​ទៀត​ពាក់​ព័ន្ធ​នឹង​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ​ខាង​លើ​បន្ទាប់​ពី​កាល​បរិច្ឆេទ​ទទួល​យក​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ ពីភាគី <span class="text-bold">“អ្នកលក់”</span>។</p>

<p class="english text-justify">8.2. “The purchaser” shall bear responsibility for annual tax on immoveable property and other taxes in relation to the immoveable property after the date of receiving the immoveable property from “the seller”.</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៩៖ ទាយាទ អ្នកស្នងមរតក និងអ្នកទទួលសិទ្ធិស្របច្បាប់</p>
<p class="english text-justify">Article 9: Heir, Successor and Legal Assignee</p>

<p class="khmer">ក្នុង​ករណី​ដែល​មាន​ភាគី​ណា​មួយ មិន​អាច​អនុវត្ត​សិទ្ធិ និង​កាតព្វកិច្ច​របស់​ខ្លួន​បាន​ដោយ​មូលហេតុ​ណា​មួយ​បណ្តាល​មក​ពី មរណភាព ពិការភាព ឬ​អវត្តមាន​ជា​បណ្តោះ​អាសន្ន ឬ​អចិន្ត្រៃយ៍​នៅ​ក្នុង​ប្រទេស​នោះ រាល់​សិទ្ធិ និង​កាតព្វកិច្ច​ទាំង​អស់​របស់​ភាគី​នោះ​ដែល​ស្ថិត​ក្រោម​ខ្លឹមសារ​នៃ​កិច្ចសន្យា​នេះ ត្រូវ​បន្ត​ទៅ​ទាយាទ និង/ឬ អ្នក​ស្នង​មរតក និង/ឬអ្នកតំណាង​ស្រប​ច្បាប់​ណា​មួយ​របស់​ខ្លួន​ដោយ​ស្វ័យប្រវត្តិ។</p>

<p class="english text-justify">In case either party is unable to implement their rights and obligations due to his/her death, disability or temporary or permanent absence in the country, all rights and obligations of that party under the content of this contract shall automatically transferred to one of his/her heir and/or successor and/or legal representative.</p>

<p class="khmer-title pb-0 mb-0">ប្រការ១០៖ គោលការណ៍ស្ម័គ្រចិត្ត និងការព្រមព្រៀងនៃកិច្ចសន្យា</p>
<p class="english text-bold">Article 10: Principle of Free Will and Agreement of the Contract<</p>

<p class="khmer">កិច្ចសន្យា​លក់​ទិញ​អចលនវត្ថុ​នេះ ត្រូវ​ធ្វើ​ឡើង​ដោយ​គ្មាន​ការ​គំរាម​កំហែង បង្ខិតបង្ខំ ឬ​មាន​បញ្ហា​ខុស​ច្បាប់​ណា​មួយ​ឡើយ ហើយ <span class="text-bold">គូភាគី</span> មាន​សមត្ថភាព​គ្រប់គ្រាន់​ក្នុង​ការ​ដឹង​លឺ ឬ​យល់​ដឹង បាន​អាន បានស្តាប់ និង​យល់​ព្រម​តាម​លក្ខខណ្ឌ​ទាំងឡាយ​នៃ​កិច្ចសន្យា​នេះ។ កិច្ចសន្យា​លក់​ទិញ​អចលនវត្ថុ​នេះ មាន​សុពលភាព​នា​កាលបរិច្ឆេទ​ដែល <span class="text-bold">គូភាគី</span> បាន​ផ្តិត​ស្នាម​មេដៃ និង​ចុះ​ត្រា​ក្រុមហ៊ុន​ដូច​ខាង​ក្រោម។ កិច្ចសន្យា​លក់ទិញ​អចលនវត្ថុ​នេះ​ធ្វើ​ឡើង​ជាភាសាខ្មែរ​ចំនួន <span class="text-bold">០២ (ពីរ)</span> ឯកសារ​ច្បាប់​ដើម ក្នុងនោះ ភាគី <span class="text-bold">“អ្នកលក់”</span> រក្សាទុក <span class="text-bold">០១ (មួយ)</span> ឯកសារ​ច្បាប់ដើម ហើយភាគី <span class="text-bold">“អ្នកទិញ”</span> រក្សាទុក <span class="text-bold">០១ (មួយ)</span> ឯកសារ​ច្បាប់​ដើម។ ឯកសារ​នីមួយៗ​មាន​សុពលភាព និង​អានុភាព​គតិយុត្តិ​ស្មើៗ និងដូចគ្នា។</p>

<p class="english text-justify">This Contract on Sale-Purchase of Immoveable Property is made without threat, coercion, or any illegal issue, and the two parties have full capacity to acknowledge or recognize, have read and listened to, and have agreed to various conditions of this contract. This Contract on Sale-Purchase of Immoveable Property is valid from the date the two parties have affixed their thumbprints and company stamps hereunder. This Contract on Sale-Purchase of Immoveable Property is made in Khmer language, in 2 (two) original copies; of which, “the seller” retains 1 (one) original copy, and “the purchaser” retains 1 (one) original copy. Each document has equal and same validity and legal effect.</p>

@endsection

@section('third')
<h4 class="khmer-title text-center">ឧបសម្ព័ន្ធទី៣</h4>
<h4 class="khmer-title text-center">“សម្ភារៈដែលភ្ជាប់បញ្ជូលក្នុងអចលនវត្ថុ”</h4>
<h4 class="english text-center text-bold my-0 py-0">Annex 3</h4>
<h4 class="english text-center text-bold">Fixture to the Immoveable Property</h4>
<div class="khmer">
{!! $contract->equipment_text !!}
</div>
<div style="page-break-after: always;"></div>
@endsection

@section('forth')
<h4 class="khmer-title text-center">ឧបសម្ព័ន្ធទី៤</h4>
<h4 class="khmer-title text-center">“អត្តសញ្ញាណប័ណ្ណ ឬលិខិតឆ្លងដែនរបស់ភាគី អ្នកលក់ និងភាគី អ្នកទិញ”</h4>
<h4 class="english text-center text-bold my-0 py-0">Annex 4</h4>
<h4 class="english text-center text-bold">Identification Card or Passport of the Seller and the Purchaser</h4>

@if(array_key_exists('customer1_id_front',$attachment_array) || array_key_exists('customer2_id_front',$attachment_array))  
<p class="khmer text-bold">- អត្តសញ្ញាណប័ណ្ណ អ្នកទិញ</p>
<p class="text-bold english">- Purchaser's identification card </p>
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
<p class="text-bold english">- Purchaser's passport no.</p>
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
<p class="text-bold english">- Seller's identification card</p>
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