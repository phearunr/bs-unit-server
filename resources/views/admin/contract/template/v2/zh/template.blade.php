<!DOCTYPE html>
<html lang="zh">
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
  <h1 class="zh text-center">柬埔寨王国</h1>
  <h2 class="khmer-title text-center">ជាតិ សាសនា ព្រះមហាក្សត្រ</h2>
  <h2 class="zh text-center ">民族 宗教 君主</h2>
  <p class="text-center"><img src="{{ asset('img/kbach.png') }}"/></p>
  @yield('contract_type')  
  <img src="{{ $project->logo_url }}" class="project-logo"/>
    
  <table class="table table-p-1 table-borderless">
    <tr>
      <td>
        <p class="khmer pb-0">លេខ: {{ $unit->code }}/{{ $unit_type->short_code }}-{{ $contract->formatted_id }}</p>
        <p class="zh pb-0 text-bold">字号: {{ $unit->code }}/{{ $unit_type->short_code }}-{{ $contract->formatted_id }}</p>
      </td>
      <td>
        <p class="khmer pb-0 text-right">ធ្វើនៅ ______________ ថ្ងៃទី ________________</p>
        <p class="zh pb-0 text-right text-bold">  __________ 年  __________ 月 __________ 日</p>
      </td>
    </tr>
  </table>

  <p class="khmer pb-0">ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ដែលមានអត្តសញ្ញាណដូចរៀបរាប់ក្នុងតារាងខាងក្រោម</p>
  <p class="text-bold">“出售” 方的身份如下述表格里</p>

  <table class="table table-p-1 table-contract-bordered">
    <tr>
      <td width="180px" class="text-bold">
        <p class="khmer pb-0">នាមករណ៍</p>
        <p class="zh pb-0">名称</p>
      </td>
      <td width="30px" class="text-center">:</td>
      <td>
        <p class="khmer pb-0">ក្រុមហ៊ុន <span class="khmer text-bold">{{ $project->company->name_km }}</span></p>
        <p class="zh pb-0">{{ $project->company->name_zh }} 公司</p>  
      </td>
    </tr>
    <tr>
      <td class="text-bold">
        <p class="khmer pb-0">លេខបញ្ជីពាណិជ្ជកម្ម</p>
        <p class="zh pb-0">商业注册号码</p>
      </td>
      <td class="text-center">:</td>
      <td>
        <p class="khmer pb-0">{{ $company->commercial_license_no }} ចុះថ្ងៃទី {{ $company->commercial_license_issued_day_km }} ខែ {{ $company->commercial_license_issued_month_km }} ឆ្នាំ {{ $company->commercial_license_issued_year_km }}</p>
        <p class="zh pb-0">{{ $company->commercial_license_no }} 于 {{ $company->commercial_license_issued_date->year }} 年 {{ $company->commercial_license_issued_date->month }} 月 {{ $company->commercial_license_issued_date->day }} 日签发</p>
      </td>
    </tr>
    <tr>
      <td class="text-bold">
        <p class="khmer pb-0">ទីស្នាក់ការចុះបញ្ជី</p>
        <p class="zh pb-0">注册总部</p>
      </td>
      <td class="text-center">:</td>
      <td>
        <p class="khmer pb-0">{{ $company->address_line1.' '.$company->address_line2 }}</p>
        <p class="zh pb-0">{{ $company->address_line1_zh.' '.$company->address_line2_zh }}</p>
      </td>
    </tr>
    <tr>
      <td class="text-bold">
        <p class="khmer pb-0">ឈ្មោះគម្រោង</p>
        <p class="zh pb-0">项目名称</p>
      </td>
      <td class="text-center">:</td>
      <td>
        <p class="khmer pb-0 text-bold">{{ $project->name }} @yield('project_suffix_kh')</p>
        <p class="zh pb-0">{{ $project->name_zh }} @yield('project_suffix_zh')</p>
      </td>
    </tr>
    <tr>
      <td class="text-bold">
        <p class="khmer pb-0">តំណាងស្របច្បាប់ដោយ</p>
        <p class="zh pb-0">法定代表</p>
      </td>
      <td class="text-center">:</td> 
      <td>
        <p class="khmer pb-0">ឈ្មោះ <span class="khmer text-bold">{{  $project->saleRepresentative->name }}</span> ភេទ <span class="khmer text-bold">{{ $sale_representative->gender_km }}</span> កើត​ថ្ងៃ​ទី {{ $sale_representative->birth_date_day_km }} ខែ {{ $sale_representative->birth_date_month_km }} ឆ្នាំ {{ $sale_representative->birth_date_year_km }} សញ្ជាតិខ្មែរ កាន់​អត្ត​សញ្ញាណ​ប័ណ្ណ​លេខ​ <span class="khmer text-bold">{{ $sale_representative->national_id_km }}</span> ចុះ​ថ្ងៃ​ទី {{ $sale_representative->national_id_issued_day_km }} ខែ {{ $sale_representative->national_id_issued_month_km }} ឆ្នាំ {{ $sale_representative->national_id_issued_year_km }}</p>
        <p class="zh pb-0">{{ $project->saleRepresentative->name_en }}, {{ $sale_representative->gender }}, 于 {{ $sale_representative->birth_date->year }} 年 {{ $sale_representative->birth_date->month }} 月 {{ $sale_representative->birth_date->day }} 日出生，高棉籍，持身份证号码：{{ $sale_representative->national_id }}，于 {{ $sale_representative->national_id_issued_date->year }} 年 {{ $sale_representative->national_id_issued_date->month }} 月 {{ $sale_representative->national_id_issued_date->day }} 日签发</p>
      </td>
    </tr>
    <tr>
      <td class="text-bold">
        <p class="khmer pb-0">លេខទូរស័ព្ទទំនាក់ទំនង</p>
        <p class="zh pb-0">联系电话号码</p>
      </td>
      <td class="text-center">:</td>
      <td>
        <p class="english pb-0">{{ $project->saleRepresentative->contact_number }}</p>
      </td>
    </tr>
  </table>
  <div style="page-break-after: always;"></div>
  <p class="khmer pb-0"><span class="khmer text-bold">ភាគី “អ្នកទិញ”</span> ដែលមានអត្តសញ្ញាណដូចរៀបរាប់ក្នុងតារាងខាងក្រោម</p>
  <p><span class="zh text-bold">“购买”</span> 方的身份如下述表格里</p>
  <table class="table table-p-1 table-contract-bordered">
    <tr>
      <td width="180px" class="text-bold">
        <p class="khmer pb-0">១. នាម ឬនាមករណ៍</p>
        <p class="zh pb-0">1．姓名</p>
      </td>
      <td width="30px" class="text-center">៖</td>
      <td colspan="3">
        <p class="english pb-0 text-bold">{{ isset($is_template) ? '_______________' : $customer1['name'] }}</p>
      </td>
    </tr>
    <tr>
      <td class="text-bold">
        <p class="khmer pb-0">ថ្ងៃខែឆ្នាំកំណើត</p>
        <p class="zh pb-0">出生日期</p>
      </td>
      <td class="text-center">៖</td>    
      <td>
        <p class="khmer pb-0">ថ្ងៃទី {{ isset($is_template) ? '_____' : $customer1['birth_day'] }} ខែ {{ isset($is_template) ? '_____' : $customer1['birth_month'] }} ឆ្នាំ {{ isset($is_template) ? '_____' : $customer1['birth_year'] }}</p>
        <p class="zh pb-0">日 {{ isset($is_template) ? '_____' : $customer1['birth_day'] }} 月 {{ isset($is_template) ? '_____' : $customer1['birth_month'] }} 年 {{ isset($is_template) ? '_____' : $customer1['birth_year'] }}</p>
      </td>
      <td width="100px">
        <p class="khmer pb-0">ភេទ៖ {{ isset($is_template) ? '_____' : ($customer1['gender'] == 1 ? 'ប្រុស'  : 'ស្រី') }}</p>
        <p class="zh pb-0">性别៖ {{ isset($is_template) ? '_____' : ($customer1['gender'] == 1 ? '男' : '女') }}</p>
      </td>
      <td width="200px">
        <p class="khmer pb-0">សញ្ជាតិ៖ {{ isset($is_template) ? '_____' : $customer1['nationality'] }}</p>
        <p class="zh pb-0">国籍៖ {{ isset($is_template) ? '_____' : $customer1['nationality'] }}</p>
      </td>
    </tr>
    <tr>
      <td class="text-bold">
        <p class="khmer pb-0">កាន់អត្តសញ្ញាណប័ណ្ណលេខ ឬលិខិតឆ្លងដែនលេខ</p>
        <p class="zh pb-0">持身份证号码或护照号码</p>
      </td>
      <td class="text-center">៖</td>
      <td>
        <p class="english pb-0">{{ isset($is_template) ? '_________' : $customer1['nid_number'] }}</p>
      </td>
      <td width="300px" colspan="2">
        <p class="khmer pb-0">ចុះថ្ងៃទី {{ isset($is_template) ? '_____' : $customer1['nid_issued_day'] }} ខែ {{ isset($is_template) ? '_____' : $customer1['nid_issued_month'] }} ឆ្នាំ {{ isset($is_template) ? '_____' : $customer1['nid_issued_year'] }}</p>
        <p class="pb-0">日 {{ isset($is_template) ? '_____' : $customer1['nid_issued_day'] }} 月 {{ isset($is_template) ? '_____' : $customer1['nid_issued_month'] }} 年 {{ isset($is_template) ? '_____' : $customer1['nid_issued_year'] }}</p>
      </td>
    </tr>
    @if( isset( $is_template ) ) 
    <tr>
      <td width="180px" class="text-bold">
        <p class="khmer pb-0">២. នាម ឬនាមករណ៍</p>
        <p class="zh pb-0">2．姓名</p>
      </td>
      <td width="30px" class="text-center">៖</td>
      <td colspan="3">
        <p class="english text-bold pb-0">_______________</p>
      </td>
    </tr>
    <tr>
      <td class="text-bold">
        <p class="khmer pb-0">ថ្ងៃខែឆ្នាំកំណើត</p>
        <p class="zh pb-0">出生日期</p>
      </td>
      <td class="text-center">៖</td>
      <td>
        <p class="khmer pb-0">ថ្ងៃទី _____ ខែ _____ ឆ្នាំ _____</p>
        <p class="zh pb-0">  _____ 年  _____ 月 _____ 日</p>
      </td>
      <td width="150px">
        <p class="khmer pb-0">ភេទ៖ _____</p>
        <p class="zh pb-0">性别៖ _____</p>
      </td>
      <td width="150px">
        <p class="khmer pb-0">សញ្ជាតិ៖ _____</p>
        <p class="zh pb-0">国籍៖ _____</p>
      </td>
    </tr>
    <tr>
      <td class="text-bold">
        <p class="khmer pb-0">កាន់អត្តសញ្ញាណប័ណ្ណលេខ ឬលិខិតឆ្លងដែនលេខ</p>
        <p class="zh pb-0">持身份证号码或护照号码</p>
      </td>
      <td class="text-center">៖</td>
      <td>
        <p class="pb-0">_________</p>
      </td>
      <td width="300px" colspan="2">
        <p class="khmer pb-0">ចុះថ្ងៃទី _____ ខែ _____ ឆ្នាំ _____</p>
        <p class="zh pb-0">  _____ 年  _____ 月 _____ 日</p>
      </td>
    </tr>
    @else
      @if( $customer2['name'] != '' )
      <tr>
        <td width="180px" class="text-bold">
          <p class="khmer pb-0">២. នាម ឬនាមករណ៍</p>
          <p class="zh pb-0">2．姓名</p>
        </td>
        <td width="30px" class="text-center">៖</td>
        <td colspan="3">
          <p class="english text-bold pb-0">{{ $customer2['name'] }}</p>
        </td>
      </tr>
      <tr>
        <td class="text-bold">
          <p class="khmer pb-0">ថ្ងៃខែឆ្នាំកំណើត</p>
          <p class="zh pb-0">出生日期</p>
        </td>
        <td class="text-center">៖</td>
        <td>
          <p class="khmer pb-0">ថ្ងៃទី {{ $customer2['birth_day'] }} ខែ {{ $customer2['birth_month'] }} ឆ្នាំ {{ $customer2['birth_year'] }}</p>
          <p class="zh pb-0">日 {{ $customer2['birth_day'] }} 月 {{ $customer2['birth_month'] }} 年 {{ $customer2['birth_year'] }}</p>
        </td>
        <td width="150px">
          <p class="khmer pb-0">ភេទ៖ {{ $customer2['gender'] == 1 ? 'ប្រុស' : 'ស្រី' }}</p>
          <p class="zh pb-0">性别៖ {{ $customer2['gender'] == 1 ? '雄性' : '女款' }}</p>
        </td>
        <td width="150px">
          <p class="khmer pb-0">សញ្ជាតិ៖ {{ $customer2['nationality'] }}</p>
          <p class="zh pb-0">国籍៖ {{ $customer2['nationality'] }}</p>
        </td>
      </tr>
      <tr>
        <td class="text-bold">
          <p class="khmer pb-0">កាន់អត្តសញ្ញាណប័ណ្ណលេខ ឬលិខិតឆ្លងដែនលេខ</p>
          <p class="zh pb-0">持身份证号码或护照号码</p>
        </td>
        <td class="text-center">៖</td>
        <td>
          <p class="english pb-0">{{ $customer2['nid_number'] }}</p>
        </td>
        <td width="300px" colspan="2">
          <p class="khmer pb-0">ចុះថ្ងៃទី {{ $customer2['nid_issued_day'] }} ខែ {{ $customer2['nid_issued_month'] }} ឆ្នាំ {{ $customer2['nid_issued_year'] }}</p>    
          <p class="zh pb-0">日 {{ $customer2['nid_issued_day'] }} 月 {{ $customer2['nid_issued_month'] }} 年 {{ $customer2['nid_issued_year'] }}</p>    
        </td>
      </tr>
      @else
      <tr>
        <td width="180px" class="text-bold">
          <p class="khmer pb-0">២. នាម ឬនាមករណ៍</p>
          <p class="zh pb-0">2．姓名</p>
        </td>
        <td width="30px" class="text-center">៖</td>
        <td colspan="3">          
        </td>
      </tr>
      <tr>
        <td class="text-bold">
          <p class="khmer pb-0">ថ្ងៃខែឆ្នាំកំណើត</p>
          <p class="zh pb-0">出生日期</p>
        </td>
        <td class="text-center">៖</td>
        <td></td>
        <td width="150px"></td>
        <td width="150px"></td>
      </tr>
      <tr>
        <td class="text-bold">
          <p class="khmer pb-0">កាន់អត្តសញ្ញាណប័ណ្ណលេខ ឬលិខិតឆ្លងដែនលេខ</p>
          <p class="zh pb-0">持身份证号码或护照号码</p>
        </td>
        <td class="text-center">៖</td>
        <td></td>
        <td width="300px" colspan="2">        
        </td>
      </tr>
      @endif
    @endif
    
    <tr>
      <td width="180px" class="text-bold">
        <p class="khmer pb-0">អាសយដ្ឋាន</p>
        <p class="zh pb-0">地址</p>
      </td>
      <td width="30px" class="text-center">៖</td>
      <td colspan="3">
        <p class="english pb-0">{{ isset($is_template) ? '______________________________' : $contract->customer_address_line1.' '.$contract->customer_address_line2 }}</p>
    
      </td>
    </tr>
    <tr>
      <td width="180px" class="text-bold">
        <p class="khmer pb-0">លេខទូរស័ព្ទទំនាក់ទំនង</p>
        <p class="zh pb-0">联系电话号码</p>
      </td>
      <td width="30px" class="text-center">៖</td>
      <td colspan="3">
        <p class="english pb-0">{{ isset($is_template) ? '______________________________' : $contract->customer_phone_number.($contract->customer_phone_number2 ? ' / '.$contract->customer_phone_number2 : '' ) }}</p>
     
      </td>
    </tr>
  </table>
  <p class="khmer">ភាគីទាំងពីរ ហៅដោយឡែកថា ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ឬ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ហើយហៅជារួមថា <span class="khmer text-bold">“គូភាគី”</span> ដោយផ្អែកលើគោលការស្ម័គ្រចិត្ត និងស្មើភាព ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> និង ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> បានព្រមព្រៀងគ្នាក្នុងការលក់ទិញនូវអចលនវត្ថុ ដែលមានអត្តសញ្ញាណ តម្លៃ និងខ្លឹមសារដូចខាងក្រោម៖</p>
  <p class="zh">双方各别称为<span class="text-bold">“出售”</span>方或<span class="text-bold">“购买”</span>方，统称为<span class="text-bold">“双方”</span>。遵循平等、自愿的原则，<span class="text-bold">“出售”</span>方和<span class="text-bold">“购买”</span>方已协议一致购销有如下身份、价格及内容的不动产：</p>

  @yield('praka')

  <table class="table table-p-1 table-contract-bordered">    
  
  @if( isset($customer2['name']) ) 
    <tr>
      <td>
        <p class="khmer-title pb-0 text-center">ភាគី “អ្នកលក់”</p>
        <p class="zh pb-0 text-center text-bold">“出售”方</p>
      </td>
      <td width="30px"></td>
      <td>
        <p class="khmer-title pb-0 text-center">សាក្សី</p>
        <p class="zh pb-0 text-center text-bold">证人</p>
      </td>
      <td width="30px"></td>
      <td colspan="3">
        <p class="khmer-title pb-0 text-center">ភាគី “អ្នកទិញ”</p>
        <p class="zh pb-0 text-center text-bold">“购买”方</p>
      </td>
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
      <td>
        <p class="khmer-title pb-0 text-center">ភាគី “អ្នកលក់”</p>
        <p class="zh pb-0 text-center text-bold">“出售”方</p>
      </td>
      <td width="30px"></td>
      <td>
        <p class="khmer-title pb-0 text-center">សាក្សី</p>
        <p class="zh pb-0 text-center text-bold">证人</p>
      </td>
      <td width="30px"></td>
      <td colspan="3">
        <p class="khmer-title pb-0 text-center">ភាគី “អ្នកទិញ”</p>
        <p class="zh pb-0 text-center text-bold">“购买”方</p>
      </td>
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
    

  @include('admin.contract.template.v2.zh.payment_schedule')
  
  @yield('first')
  @yield('second')
  @yield('third')
  @yield('forth')
</body>
</html>