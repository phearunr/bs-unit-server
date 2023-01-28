<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('page_title')</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/contract_print_v2.css') }}">    
</head>
<body>
  <h1 class="khmer-title text-center">ព្រះរាជាណាចក្រកម្ពុជា</h1>
  <h1 class="english text-center">KINGDOM OF CAMBODIA</h1>
  <h2 class="khmer-title text-center">ជាតិ សាសនា ព្រះមហាក្សត្រ</h2>
  <h2 class="english text-center">NATION RELIGION KING</h2>
  <p class="text-center"><img src="{{ asset('img/kbach.png') }}"/></p>
  @yield('contract_type')

  <img src="{{ $project->logo_url }}" class="project-logo"/>
    
  <table class="table table-p-1 table-borderless">
    <tr>
      <td class="english">
        <p class="khmer my-0 py-0">លេខ : {{ $unit->code }}/{{ $unit_type->short_code }}-{{ $contract->formatted_id }}</p>
        <p class="english my-0 py-0">No. {{ $unit->code }}/{{ $unit_type->short_code }}-{{ $contract->formatted_id }}</p>      
      </td>
      <td>
        <p class="khmer my-0 py-0 text-right">ធ្វើនៅ ______________ ថ្ងៃទី _______________________</p>
        <p class="english my-0 py-0 text-right">Made in __________, on ____________________</p>
      </td>
    </tr>
  </table>
  <p class="khmer mb-0 pb-0"><span class="text-bold"> ភាគី “អ្នកលក់”</span> ដែលមានអត្តសញ្ញាណដូចរៀបរាប់ក្នុងតារាងខាងក្រោម</p>
  <p class="english">The <b class="english">"seller"</b> whose identity is described in the following table:</p>

  <table class="table table-p-1 table-contract-bordered">
    <tr>
      <td width="180px" class="text-bold">
        <p class="khmer my-0 py-0">នាមករណ៍</p>
        <p class="english my-0 py-0">Corporate Name</p>
      </td>
      <td width="30px" class="text-center">:</td>
      <td>
        <p class="khmer my-0 py-0 text-bold">ក្រុមហ៊ុន {{ $project->company->name_km }}</p>
        <p class="english my-0 py-0 text-bold">{{ $project->company->name_en }}</p>     
      </td>
    </tr>
    <tr>
      <td class="text-bold">
        <p class="khmer my-0 py-0">លេខបញ្ជីពាណិជ្ជកម្ម</p>
        <p class="english my-0 py-0">Commercial Registration No.</p>
      </td>
      <td class="text-center">:</td>
      <td>
        <p class="khmer my-0 py-0">{{ $company->commercial_license_no }} ចុះថ្ងៃទី {{ $company->commercial_license_issued_day_km }} ខែ {{ $company->commercial_license_issued_month_km }} ឆ្នាំ {{ $company->commercial_license_issued_year_km }}</p>
        <p class="english my-0 py-0">Issued Date: {{ $company->commercial_license_issued_date->format('F d, Y') }}</p>
      </td>
    </tr>
    <tr>
      <td class="text-bold">
        <p class="khmer my-0 py-0">ទីស្នាក់ការចុះបញ្ជី</p>
        <p class="english my-0 py-0">Registered Office</p>       
      </td>
      <td class="text-center">:</td>
      <td>        
        <p class="khmer my-0 py-0">{{ $company->address_line1.' '.$company->address_line1 }}</p>
        <p class="english my-0 py-0">{{ $company->address_line1_en.' '.$company->address_line2_en }}</p>
      </td>
    </tr>
    <tr>
      <td class="text-bold">
        <p class="khmer my-0 py-0">ឈ្មោះគម្រោង</p>
        <p class="english my-0 py-0">Project Name</p>
      </td>
      <td class="text-center">:</td>
      <td>
        <p class="khmer my-0 py-0 text-bold">{{ $project->name }} @yield('project_suffix')</p>
        <p class="english my-0 py-0 text-bold">{{ $project->name_en }} @yield('project_suffix_en')</p>
      </td>
    </tr>
    <tr>
      <td class="text-bold">
        <p class="khmer py-0">តំណាងស្របច្បាប់ដោយ</p>
        <p class="english my-0 py-0">Legally represented by</p>
      </td>
      <td class="text-center">:</td> 
      <td>
        <p class="khmer my-0 py-0">ឈ្មោះ <span class="text-bold">{{  $project->saleRepresentative->name }}</span> ភេទ <span class="text-bold">{{ $sale_representative->gender_km }}</span> កើត​ថ្ងៃ​ទី {{ $sale_representative->birth_date_day_km }} ខែ {{ $sale_representative->birth_date_month_km }} ឆ្នាំ {{ $sale_representative->birth_date_year_km }} សញ្ជាតិខ្មែរ កាន់​អត្ត​សញ្ញាណ​ប័ណ្ណ​លេខ​ <span class="text-bold">{{ $sale_representative->national_id_km }}</span> ចុះ​ថ្ងៃ​ទី {{ $sale_representative->national_id_issued_day_km }} ខែ {{ $sale_representative->national_id_issued_month_km }} ឆ្នាំ {{ $sale_representative->national_id_issued_year_km }}</p>

        <p class="english my-0 py-0">Name: {{ $project->saleRepresentative->name_en }}, {{ $sale_representative->gender }}, date of birth: {{ $sale_representative->birth_date->format('F d, Y') }} Khmer citizen, holder of identification card No.: {{ $sale_representative->national_id }}, dated {{ $sale_representative->national_id_issued_date->format('F d, Y') }}</p>
      </td>
    </tr>
    <tr>
      <td class="text-bold">
        <p class="khmer my-0 py-0">លេខទូរស័ព្ទទំនាក់ទំនង</p>
        <p class="english my-0 py-0">Contact Telephone No.</p>
      </td>
      <td class="text-center">:</td>
      <td class="english">
        {{ $project->saleRepresentative->contact_number }}​
      </td>
    </tr>
  </table>

  <p class="khmer mb-0 pb-0 page-break-before"><span class="text-bold">ភាគី “អ្នកទិញ”</span> ដែលមានអត្តសញ្ញាណដូចរៀបរាប់ក្នុងតារាងខាងក្រោម</p>
  <p class="english">The <span class="text-bold english">"purchaser"</span> whose identity is described in the following table:</p>
  <table class="table table-p-1 table-contract-bordered">
    <tr>
      <td width="180px" class="text-bold">
        <p class="khmer my-0 py-0">១. នាម ឬនាមករណ៍</p>
        <p class="english my-0 py-0">1. Name or Corporate Name</p>
      </td>
      <td width="30px" class="text-center">:</td>
      <td colspan="3" class="text-bold english">{{ isset($is_template) ? '_______________' : $customer1['name'] }}</td>
    </tr>
    <tr>
      <td class="text-bold">
        <p class="khmer my-0 py-0">ថ្ងៃខែឆ្នាំកំណើត</p>
        <p class="english my-0 py-0">Date of birth</p>
      </td>
      <td class="text-center">:</td>
      <td>
        <p class="khmer my-0 py-0">ថ្ងៃទី {{ isset($is_template) ? '_____' : $customer1['birth_day'] }} ខែ {{ isset($is_template) ? '_____' : $customer1['birth_month'] }} ឆ្នាំ {{ isset($is_template) ? '_____' : $customer1['birth_year'] }}</p>
        <p class="english my-0 py-0">{{ isset($is_template) ? '_________________' : Carbon\Carbon::createFromFormat('Y-m-d', $customer1['birth_year'].'-'.$customer1['birth_month'].'-'.$customer1['birth_day'])->format('F d, Y') }}</p>
      </td>
      <td width="100px" class="text-bold">
        <p class="khmer my-0 py-0">ភេទ៖​ {{ isset($is_template) ? '_____' : ($customer1['gender']  == 1 ? 'ប្រុស' : 'ស្រី') }} </p>
        <p class="english my-0 py-0">Sex: {{ isset($is_template) ? '_____' : ($customer1['gender']  == 1 ? 'Male' : 'Female') }}</p>
      </td>
      <td width="200px">
        <p class="khmer my-0 py-0">សញ្ជាតិ៖ {{ isset($is_template) ? '_____' : $customer1['nationality'] }}</p>
        <p class="english my-0 py-0">Nationality: {{ isset($is_template) ? '_____' : $customer1['nationality'] }}</p>        
      </td>
    </tr>
    <tr>
      <td class="text-bold">
        <p class="khmer my-0 py-0">កាន់អត្តសញ្ញាណប័ណ្ណលេខ ឬលិខិតឆ្លងដែនលេខ</p>
        <p class="english my-0 py-0">Holder of identification card or passport No.</p>        
      </td>
      <td class="text-center">:</td>
      <td class="english">
        {{ isset($is_template) ? '_________________' : $customer1['nid_number'] }}
      </td>
      <td width="300px" colspan="2">
        <p class="khmer my-0 py-0">ចុះថ្ងៃទី {{ isset($is_template) ? '_____' : $customer1['nid_issued_day'] }} ខែ {{ isset($is_template) ? '_____' : $customer1['nid_issued_month'] }} ឆ្នាំ {{ isset($is_template) ? '_____' : $customer1['nid_issued_year'] }}</p>
        <p class="english my-0 py-0">Issue Date: {{ isset($is_template) ? '_________________' : Carbon\Carbon::createFromFormat('Y-m-d',  $customer1['nid_issued_year'].'-'.$customer1['nid_issued_month'].'-'.$customer1['nid_issued_day'])->format('F d, Y') }}</p>
      </td>
    </tr>
    @if( isset( $is_template ) ) 
    <tr>
      <td width="180px" class="text-bold">
        <p class="khmer my-0 py-0">២. នាម ឬនាមករណ៍</p>
        <p class="english my-0 py-0">2. Name or Corporate Name</p>       
      </td>
      <td width="30px" class="text-center">:</td>
      <td colspan="3">_______________</td>
    </tr>
    <tr>
      <td class="text-bold">
        <p class="khmer my-0 py-0">ថ្ងៃខែឆ្នាំកំណើត</p>
        <p class="english my-0 py-0">Date of birth</p>
      </td>
      <td class="text-center">:</td>
      <td>
        <p class="khmer my-0 py-0">ថ្ងៃទី _____ ខែ _____ ឆ្នាំ _____</p>
        <p class="english my-0 py-0">_______________</p>      
      </td>
      <td width="150px">
        <p class="khmer my-0 py-0">ភេទ៖ _____</p>
        <p class="english my-0 py-0">Sex: _____</p>
      </td>
      <td width="150px">
        <p class="khmer my-0 py-0">សញ្ជាតិ៖ _____</p>
        <p class="english my-0 py-0">Nationality: _____</p>
      </td>
    </tr>
    <tr>
      <td class="text-bold">
        <p class="khmer my-0 py-0">កាន់អត្តសញ្ញាណប័ណ្ណលេខ ឬលិខិតឆ្លងដែនលេខ</p>
        <p class="english my-0 py-0">Holder of identification card or passport No.</p>        
      </td>
      <td class="text-center">:</td>
      <td>_________________</td>
      <td width="300px" colspan="2">
        <p class="khmer my-0 py-0">ចុះថ្ងៃទី {{ isset($is_template) ? '_____' : $customer1['nid_issued_day'] }} ខែ {{ isset($is_template) ? '_____' : $customer1['nid_issued_month'] }} ឆ្នាំ {{ isset($is_template) ? '_____' : $customer1['nid_issued_year'] }}</p> 
      <p class="english my-0 py-0">Issue Date: _________________</p>
      </td>
    </tr>
    @else
      @if( $customer2['name'] != '' )
      <tr>
        <td width="180px" class="text-bold">
          <p class="khmer my-0 py-0">២. នាម ឬនាមករណ៍</p>
          <p class="english my-0 py-0">2. Name or Corporate Name</p>
        </td>
        <td width="30px" class="text-center">:</td>
        <td colspan="3" class="text-bold english">{{ $customer2['name'] }}</td>
      </tr>
      <tr>
        <td class="text-bold">
          <p class="khmer my-0 py-0">ថ្ងៃខែឆ្នាំកំណើត</p>
          <p class="english my-0 py-0">Date of birth</p>
        </td>
        <td class="text-center">:</td>
        <td>
          <p class="khmer my-0 py-0">ថ្ងៃទី {{ $customer2['birth_day'] }} ខែ {{ $customer2['birth_month'] }} ឆ្នាំ {{ $customer2['birth_year'] }}</p>
          <p class="english my-0 py-0">{{ isset($is_template) ? '_________________' : Carbon\Carbon::createFromFormat('Y-m-d', $customer2['birth_year'].'-'.$customer2['birth_month'].'-'.$customer2['birth_day'])->format('F d, Y') }}</p>      
        </td>
        <td width="150px">
          <p class="khmer my-0 py-0">ភេទ៖ {{ $customer2['gender'] == 1 ? 'ប្រុស' : 'ស្រី' }}</p>
          <p class="english my-0 py-0">Sex: {{ $customer2['gender'] == 1 ? 'Male' : 'Female' }}</p>
        
        </td>
        <td width="150px">
          <p class="khmer my-0 py-0">សញ្ជាតិ៖ {{ $customer2['nationality'] }}</p>
          <p class="english my-0 py-0">Nationality: {{ $customer2['nationality'] }}</p>       
        </td>
      </tr>
      <tr>
        <td class="text-bold">
          <p class="khmer my-0 py-0">កាន់អត្តសញ្ញាណប័ណ្ណលេខ ឬលិខិតឆ្លងដែនលេខ</p>
          <p class="english my-0 py-0">Holder of identification card or passport No.</p>          
        </td>
        <td class="text-center">:</td>
        <td class="english">{{ $customer2['nid_number'] }}</td>
        <td width="300px" colspan="2">
          <p class="khmer my-0 py-0">ចុះថ្ងៃទី {{ $customer2['nid_issued_day'] }} ខែ {{ $customer2['nid_issued_month'] }} ឆ្នាំ {{ $customer2['nid_issued_year'] }}   </p>
          <p class="english my-0 py-0">Issued Date: {{ Carbon\Carbon::createFromFormat('Y-m-d', $customer2['nid_issued_year'].'-'.$customer2['nid_issued_month'].'-'.$customer2['nid_issued_day'])->format('F d, Y') }}</p>
        </td>
      </tr>
      @else
      <tr>
        <td width="180px" class="text-bold">
          <p class="khmer my-0 py-0">២. នាម ឬនាមករណ៍</p>
          <p class="english my-0 py-0">2. Name or Corporate Name</p>            
        </td>
        <td width="30px" class="text-center">:</td>
        <td colspan="3"></td>
      </tr>
      <tr>
        <td class="text-bold">
          <p class="khmer my-0 py-0">ថ្ងៃខែឆ្នាំកំណើត</p>
          <p class="english my-0 py-0">Date of birth</p>
        </td>
        <td class="text-center">:</td>
        <td></td>
        <td width="150px"></td>
        <td width="150px"></td>
      </tr>
      <tr>
        <td class="text-bold">
          <p class="khmer my-0 py-0">កាន់អត្តសញ្ញាណប័ណ្ណលេខ ឬលិខិតឆ្លងដែនលេខ</p>
          <p class="english my-0 py-0">Holder of identification card or passport No.</p>  
        </td>
        <td class="text-center">:</td>
        <td></td>
        <td width="300px" colspan="2">        
        </td>
      </tr>
      @endif
    @endif
    
    <tr>
      <td width="180px" class="text-bold">
        <p class="khmer my-0 py-0">អាសយដ្ឋាន</p>
        <p class="english my-0 py-0">Address</p>
      </td>
      <td width="30px" class="text-center">:</td>
      <td colspan="3"><p class="english">{{ isset($is_template) ? '______________________________' : $contract->customer_address_line1.' '.$contract->customer_address_line2 }}</p></td>
    </tr>
    <tr>
      <td width="180px" class="text-bold">
        <p class="khmer my-0 py-0">លេខទូរស័ព្ទទំនាក់ទំនង</p>
        <p class="english my-0 py-0">Contact Telephone No.</p>
      </td>
      <td width="30px" class="text-center">:</td>
      <td colspan="3"><p class="english">{{ isset($is_template) ? '______________________________' : $contract->customer_phone_number.($contract->customer_phone_number2 ? ' / '.$contract->customer_phone_number2 : '' ) }}</p></td>
    </tr>
  </table>

  <p class="khmer">ភាគីទាំងពីរ ហៅដោយឡែកថា ភាគី <span class="text-bold">“អ្នកលក់”</span> ឬ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ហើយហៅជារួមថា <span class="text-bold">“គូភាគី”</span> ដោយផ្អែកលើគោលការស្ម័គ្រចិត្ត និងស្មើភាព ភាគី <span class="text-bold">“អ្នកលក់”</span> និង ភាគី <span class="text-bold">“អ្នកទិញ”</span> បានព្រមព្រៀងគ្នាក្នុងការលក់ទិញនូវអចលនវត្ថុ ដែលមានអត្តសញ្ញាណ តម្លៃ និងខ្លឹមសារដូចខាងក្រោម៖</p>

  <p class="english text-justify ">The two parties are individually referred to as <span class="text-bold english">“the seller”</span> or <span class="text-bold english">“the purchaser”</span>, and collectively referred to as <span class="text-bold english">“the two parties”</span>. Based on the principles of free will and equality, <span class="text-bold english">“the seller”</span> and <span class="text-bold english">“the purchaser”</span> have mutually agreed to sell and purchase the immoveable property (private space of the co-ownership building) with identity, price and content as follows:</p>

  @yield('praka')

  <table class="table table-p-1 table-contract-bordered page-break-after">    
  
  @if( isset($customer2['name']) ) 
    <tr>
      <td>
        <p class="khmer-title text-center my-0 py-0">ភាគី “អ្នកលក់”</p>
        <p class="text-bold text-center english my-0 py-0">“the seller”</p>
      </td>
      <td width="30px"></td>
      <td class="text-center">
        <p class="khmer-title text-center my-0 py-0">សាក្សី</p>
        <p class="text-bold text-center english my-0 py-0">Witness</p>
      </td>
      <td width="30px"></td>
      <td class="text-center" colspan="3">
        <p class="khmer-title text-center my-0 py-0">ភាគី “អ្នកទិញ”</p>
        <p class="text-bold text-center english my-0 py-0">“Purchaser”</p>      
      </td>
    </tr>
    <tr>
      <td class="text-center text-bold" height="140px" width="25%" style="vertical-align:bottom">
        <p class="text-center my-0 py-0">{{ $sale_representative->name }}</p>
        <p class="text-bold text-center english my-0 py-0">{{ $sale_representative->name_en }}</p>
      </td>
      <td width="30px"></td>
      <td class="text-center" width="25%"></td>
      <td width="30px"></td>
      <td width="25%" class="text-center text-bold"  style="vertical-align:bottom">{{ isset($is_template) ? '____________' : $customer1['name'] }}</td>
      <td width="30px"></td>
      <td width="25%" class="text-center text-bold" style="vertical-align:bottom">{{ isset($is_template) ? '____________' : $customer2['name'] }}</td>
    </tr>
  @else
    <tr>
      <td class="text-center"><span class="text-bold">
        <p class="khmer-title text-center my-0 py-0">ភាគី “អ្នកលក់”</p>
        <p class="text-bold text-center english my-0 py-0">“the seller”</p>
      </td>
      <td width="30px"></td>
      <td class="text-center">
        <p class="khmer-title text-center my-0 py-0">សាក្សី</p>
        <p class="text-bold text-center english my-0 py-0">Witness</p>
      </td>
      <td width="30px"></td>
      <td class="text-center">
        <p class="khmer-title text-center my-0 py-0">ភាគី “អ្នកទិញ”</p>
        <p class="text-bold text-center english my-0 py-0">“Purchaser”</p> 
      </td>
    </tr>
    <tr>
      <td class="text-center text-bold" height="120px" width="33%" style="vertical-align:bottom">
        <p class="text-center my-0 py-0">{{ $sale_representative->name }}</p>
        <p class="text-bold text-center english my-0 py-0">{{ $sale_representative->name_en }}</p>
      </td>
      <td width="30px"></td>
      <td class="text-center" width="33%"></td>
      <td width="30px"></td>
      <td class="text-center text-bold" width="33%" style="vertical-align:bottom">{{ isset($is_template) ? '____________' : $customer1['name'] }}</td>
    </tr>
  @endif
  </table>

  @include('admin.contract.template.v2.en.payment_schedule')
  
  @yield('first')
  @yield('second')
  @yield('third')
  @yield('forth')
  @yield('fifth')
</body>
</html>