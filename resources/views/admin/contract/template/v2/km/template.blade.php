<!DOCTYPE html>
<html lang="km">
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
  <h2 class="khmer-title text-center">ជាតិ សាសនា ព្រះមហាក្សត្រ</h2>
  <p class="text-center"><img src="{{ asset('img/kbach.png') }}"/></p>
  @yield('contract_type')
  <h3 class="khmer-title text-center">{{ $project->name }}</h3>
  <img src="{{ $project->logo_url }}" class="project-logo"/>
    
  <table class="table table-p-1 table-borderless">
    <tr>
      <td>លេខ៖ {{ $unit->code }}/{{ $unit_type->short_code }}-{{ $contract->formatted_id }}</td>
      <td class="text-right">ធ្វើនៅ ______________ ថ្ងៃទី _______________________</td>
    </tr>
  </table>

  <p><span class="khmer-title">ភាគី “អ្នកលក់”</span> ដែលមានអត្តសញ្ញាណដូចរៀបរាប់ក្នុងតារាងខាងក្រោម</p>

  <table class="table table-p-1 table-contract-bordered">
    <tr>
      <td width="180px" class="text-bold">នាមករណ៍</td>
      <td width="30px" class="text-center">៖</td>
      <td>ក្រុមហ៊ុន <span class="text-bold">{{ $project->company->name_km }}</span> <span class="english text-bold">({{ $project->company->name_en  }})</span></td>
    </tr>
    <tr>
      <td class="text-bold">លេខបញ្ជីពាណិជ្ជកម្ម</td>
      <td class="text-center">៖</td>
      <td>{{ $company->commercial_license_no_km }} ចុះថ្ងៃ​ទី {{ $company->commercial_license_issued_day_km }} ខែ {{ $company->commercial_license_issued_month_km }} ឆ្នាំ {{ $company->commercial_license_issued_year_km }}</td>
    </tr>
    <tr>
      <td class="text-bold">ទីស្នាក់ការចុះបញ្ជី</td>
      <td class="text-center">៖</td>
      <td>{{ $company->address_line1.' '.$company->address_line2 }}</td>
    </tr>
    <tr>
      <td class="text-bold">ឈ្មោះគម្រោង</td>
      <td class="text-center">៖</td>
      <td><span class="text-bold">{{ $project->name }}</span> <span class="english text-bold">({{ $project->name_en }})</span> @yield('project_suffix')</td>
    </tr>
    <tr>
      <td class="text-bold">តំណាងស្របច្បាប់ដោយ</td>
      <td class="text-center">៖</td>
      <td>ឈ្មោះ <span class="text-bold">{{  $sale_representative->name }}</span> ភេទ <span class="text-bold">{{ $sale_representative->gender_km }}</span> កើត​ថ្ងៃ​ទី {{ $sale_representative->birth_date_day_km }} ខែ {{ $sale_representative->birth_date_month_km }} ឆ្នាំ {{ $sale_representative->birth_date_year_km }} សញ្ជាតិខ្មែរ កាន់​អត្ត​សញ្ញាណ​ប័ណ្ណ​លេខ​ <span class="text-bold">{{ $sale_representative->national_id_km }}</span> ចុះ​ថ្ងៃ​ទី {{ $sale_representative->national_id_issued_day_km }} ខែ {{ $sale_representative->national_id_issued_month_km }} ឆ្នាំ {{ $sale_representative->national_id_issued_year_km }}</td>
    </tr>
    <tr>
      <td class="text-bold">លេខទូរស័ព្ទទំនាក់ទំនង</td>
      <td class="text-center">៖</td>
      <td>{{ $project->saleRepresentative->contact_number_km }}</td>
    </tr>
  </table>

  <p><span class="khmer-title">ភាគី “អ្នកទិញ”</span> ដែលមានអត្តសញ្ញាណដូចរៀបរាប់ក្នុងតារាងខាងក្រោម</p>
  <table class="table table-p-1 table-contract-bordered">
    <tr>
      <td width="180px" class="text-bold">១. នាម ឬនាមករណ៍</td>
      <td width="30px" class="text-center">៖</td>
      <td colspan="3"><span class="text-bold">{{ isset($is_template) ? '_______________' : $customer1['name'] }}</span></td>
    </tr>
    <tr>
      <td class="text-bold">ថ្ងៃខែឆ្នាំកំណើត</td>
      <td class="text-center">៖</td>    
      <td>ថ្ងៃទី {{ isset($is_template) ? '_____' : $customer1['birth_day'] }} ខែ {{ isset($is_template) ? '_____' : $customer1['birth_month'] }} ឆ្នាំ {{ isset($is_template) ? '_____' : $customer1['birth_year'] }}</td>
      <td width="100px">ភេទ៖ {{ (isset($is_template) )? '_____' : ($customer1['gender'] == 1 ? 'ប្រុស'  : 'ស្រី') }}</td>
      <td width="200px">សញ្ជាតិ៖ {{ (isset($is_template) ) ? '_____' : ($customer1['nationality']) }}</td>
    </tr>
    <tr>
      <td class="text-bold">កាន់អត្តសញ្ញាណប័ណ្ណលេខ ឬលិខិតឆ្លងដែនលេខ</td>
      <td class="text-center">៖</td>
      <td>{{ isset($is_template) ? '_________' : $customer1['nid_number'] }}</td>
      <td width="300px" colspan="2">ចុះថ្ងៃទី {{ isset($is_template) ? '_____' : $customer1['nid_issued_day'] }} ខែ {{ isset($is_template) ? '_____' : $customer1['nid_issued_month'] }} ឆ្នាំ {{ isset($is_template) ? '_____' : $customer1['nid_issued_year'] }}</td>
    </tr>
    @if( isset( $is_template ) ) 
    <tr>
      <td width="180px" class="text-bold">២. នាម ឬនាមករណ៍</td>
      <td width="30px" class="text-center">៖</td>
      <td colspan="3"><span class="text-bold">_______________</span></td>
    </tr>
    <tr>
      <td class="text-bold">ថ្ងៃខែឆ្នាំកំណើត</td>
      <td class="text-center">៖</td>
      <td>ថ្ងៃទី _____ ខែ _____ ឆ្នាំ _____</td>
      <td width="150px">ភេទ៖ _____</td>
      <td width="150px">សញ្ជាតិ៖ _____</td>
    </tr>
    <tr>
      <td class="text-bold">កាន់អត្តសញ្ញាណប័ណ្ណលេខ ឬលិខិតឆ្លងដែនលេខ</td>
      <td class="text-center">៖</td>
      <td>_________</td>
      <td width="300px" colspan="2">
      ចុះថ្ងៃទី _____ ខែ _____ ឆ្នាំ _____    
      </td>
    </tr>
    @else
      @if( $customer2['name'] != '' )
      <tr>
        <td width="180px" class="text-bold">២. នាម ឬនាមករណ៍</td>
        <td width="30px" class="text-center">៖</td>
        <td colspan="3"><span class="text-bold">{{ $customer2['name'] }}</span></td>
      </tr>
      <tr>
        <td class="text-bold">ថ្ងៃខែឆ្នាំកំណើត</td>
        <td class="text-center">៖</td>
        <td>ថ្ងៃទី {{ $customer2['birth_day'] }} ខែ {{ $customer2['birth_month'] }} ឆ្នាំ {{ $customer2['birth_year'] }}</td>
        <td width="150px">ភេទ៖ {{ $customer2['gender'] == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
        <td width="150px">សញ្ជាតិ៖ {{ $customer2['nationality'] }}</td>
      </tr>
      <tr>
        <td class="text-bold">កាន់អត្តសញ្ញាណប័ណ្ណលេខ ឬលិខិតឆ្លងដែនលេខ</td>
        <td class="text-center">៖</td>
        <td>{{ $customer2['nid_number'] }}</td>
        <td width="300px" colspan="2">
        ចុះថ្ងៃទី {{ $customer2['nid_issued_day'] }} ខែ {{ $customer2['nid_issued_month'] }} ឆ្នាំ {{ $customer2['nid_issued_year'] }}    
        </td>
      </tr>
      @else
      <tr>
        <td width="180px" class="text-bold">២. នាម ឬនាមករណ៍</td>
        <td width="30px" class="text-center">៖</td>
        <td colspan="3"><span class="text-bold"></span></td>
      </tr>
      <tr>
        <td class="text-bold">ថ្ងៃខែឆ្នាំកំណើត</td>
        <td class="text-center">៖</td>
        <td></td>
        <td width="150px"></td>
        <td width="150px"></td>
      </tr>
      <tr>
        <td class="text-bold">កាន់អត្តសញ្ញាណប័ណ្ណលេខ ឬលិខិតឆ្លងដែនលេខ</td>
        <td class="text-center">៖</td>
        <td></td>
        <td width="300px" colspan="2">        
        </td>
      </tr>
      @endif
    @endif
    
    <tr>
      <td width="180px" class="text-bold">អាសយដ្ឋាន</td>
      <td width="30px" class="text-center">៖</td>
      <td colspan="3">{{ isset($is_template) ? '______________________________' : $contract->customer_address_line1.' '.$contract->customer_address_line2 }}</td>
    </tr>
    <tr>
      <td width="180px" class="text-bold">លេខទូរស័ព្ទទំនាក់ទំនង</td>
      <td width="30px" class="text-center">៖</td>
      <td colspan="3"><span class="text-bold">{{ isset($is_template) ? '______________________________' : $contract->customer_phone_number_km.($contract->customer_phone_number2_km ? ' / '.$contract->customer_phone_number2_km : '' ) }}</span></td>
    </tr>
  </table>
  <p>ភាគីទាំងពីរ ហៅដោយឡែកថា ភាគី <span class="text-bold">“អ្នកលក់”</span> ឬ ភាគី <span class="text-bold">“អ្នកទិញ”</span> ហើយហៅជារួមថា <span class="text-bold">“គូភាគី”</span> ដោយផ្អែកលើគោលការស្ម័គ្រចិត្ត និងស្មើភាព ភាគី <span class="text-bold">“អ្នកលក់”</span> និង ភាគី <span class="text-bold">“អ្នកទិញ”</span> បានព្រមព្រៀងគ្នាក្នុងការលក់ទិញនូវអចលនវត្ថុ ដែលមានអត្តសញ្ញាណ តម្លៃ និងខ្លឹមសារដូចខាងក្រោម៖</p>
  <div style="page-break-after: always;"></div>

  @yield('praka')

  <table class="table table-p-1 table-contract-bordered">    
  
  @if( isset($customer2['name']) ) 
    <tr>
      <td class="text-center"><span class="khmer-title">ភាគី “អ្នកលក់”</span></td>
      <td width="30px"></td>
      <td class="text-center"><span class="khmer-title">សាក្សី</span></td>
      <td width="30px"></td>
      <td class="text-center" colspan="3"><span class="khmer-title">ភាគី “អ្នកទិញ”</span></td>
    </tr>
    <tr>
      <td class="text-center text-bold" height="120px" width="25%" style="vertical-align:bottom">{{ $sale_representative->name }}</td>
      <td width="30px"></td>
      <td class="text-center" width="25%"></td>
      <td width="30px"></td>
      <td width="25%" class="text-center text-bold"  style="vertical-align:bottom">{{ isset($is_template) ? '____________' : $customer1['name'] }}</td>
      <td width="30px"></td>
      <td width="25%" class="text-center text-bold" style="vertical-align:bottom">{{ isset($is_template) ? '____________' : $customer2['name'] }}</td>
    </tr>
  @else
    <tr>
      <td class="text-center"><span class="khmer-title">ភាគី “អ្នកលក់”</span></td>
      <td width="30px"></td>
      <td class="text-center"><span class="khmer-title">សាក្សី</span></td>
      <td width="30px"></td>
      <td class="text-center"><span class="khmer-title">ភាគី “អ្នកទិញ”</span></td>
    </tr>
    <tr>
      <td class="text-center text-bold" height="120px" width="33%" style="vertical-align:bottom">{{ $sale_representative->name }}</td>
      <td width="30px"></td>
      <td class="text-center" width="33%"></td>
      <td width="30px"></td>
      <td class="text-center text-bold" width="33%" style="vertical-align:bottom">{{ isset($is_template) ? '____________' : $customer1['name'] }}</td>
    </tr>
  @endif
  </table>
  <div style="page-break-after: always;"></div>
    

  @include('admin.contract.template.v2.km.payment_schedule')
  
  @yield('first')
  @yield('second')
  @yield('third')
  @yield('forth')
</body>
</html>