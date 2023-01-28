<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contract - {{ $contract->customer1_name }}</title>
  <link href="https://fonts.googleapis.com/css?family=Battambang:400,700" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/contract_print.css') }}">  
  <style type="text/css">
    p {
      line-height: 26pt;
    }    
    table.table-list {
      width: 100%;
      margin:0px 0px 0px 30px;
      padding:0;
    }
    table.table-list tr td:first {
      width: 30px;
    }
    table.table-list tr {
      margin: 0px !important;
      padding: 0px !important;
    }
    table.table-list td {
      padding: 0px;
      margin: 0px;
    }
    table.table-list td {
      vertical-align: top;
    }
  </style>
</head>
@php  
  $address = [
    'house_no' => $contract->customer_house_no,
    'street' => $contract->customer_street,
    'phum' => $contract->customer_phum,
    'sangkat' => $contract->customer_commune,
    'khan' => $contract->customer_district,
    'city' =>$contract->customer_city
  ];

  if ( is_null($contract->customer_phone_number2) || $contract->customer_phone_number2 == "" ) {
    $phone_number = \App\Helpers\NumberFormat::convertToKhmerNumber($contract->customer_phone_number);
  } else {
    $phone_number = \App\Helpers\NumberFormat::convertToKhmerNumber($contract->customer_phone_number).' / '.\App\Helpers\NumberFormat::convertToKhmerNumber($contract->customer_phone_number2);
  } 

  $customer1_indentity_text = "";
@endphp
<body>
  <h2 class="main-title text-center">ព្រះរាជាណាចក្រកម្ពុជា</h2>
  <h2 class="main-title text-center">ជាតិ សាសនា ព្រះមហាក្សត្រ</h2>
  <p class="text-center"><img src="{{ asset('img/kbach.png') }}"/></p>
  <h2 class="main-title text-center mb-3">កិច្ចសន្យាទិញ-លក់គម្រោង</h2>
  <h2 class="battambang-font text-center text-bold">{{ $project->name }}</h2>

  <p class="text-center text-bold" style="margin-top:12pt;margin-bottom:12pt;">រវាង</p>

  <p class="first-indent">គម្រោង <strong>{{ $project->name }}</strong> មានការិយាល័យកណ្តាលស្ថិតនៅ{{ $project->company->address_line1 }} {{ $project->company->address_line2 }} នៃក្រុមហ៊ុន <span class="text-bold">{{ $project->company->name_en }}</span> តំណាង​ស្រប​ច្បាប់​ចុះ​កិច្ច​សន្យា​ទិញ​លក់​ដោយ​ឈ្មោះ <span class="text-bold">{{ $project->saleRepresentative->name }}</span> ភេទ <span class="text-bold">{{ __($project->saleRepresentative->gender_km) }}</span> កើត​ថ្ងៃ​ទី{{\App\Helpers\NumberFormat::convertToKhmerNumber($project->saleRepresentative->birth_date->day)}} ខែ{{\App\Helpers\KhmerMonth::convertToKhmerMonth($project->saleRepresentative->birth_date->month)}} ឆ្នាំ{{\App\Helpers\NumberFormat::convertToKhmerNumber($project->saleRepresentative->birth_date->year)}} ជន​ជាតិ​ខ្មែរ​កាន់​អត្ត​សញ្ញាណ​ប័ណ្ណ​លេខ​ <span class="text-bold">{{\App\Helpers\NumberFormat::convertToKhmerNumber($project->saleRepresentative->national_id)}}</span> ចុះ​ថ្ងៃ​ទី{{\App\Helpers\NumberFormat::convertToKhmerNumber($project->saleRepresentative->national_id_issued_date->day)}}  ខែ{{\App\Helpers\KhmerMonth::convertToKhmerMonth($project->saleRepresentative->national_id_issued_date->month)}} ឆ្នាំ{{\App\Helpers\NumberFormat::convertToKhmerNumber($project->saleRepresentative->national_id_issued_date->year)}} ជា​អ្នក​លក់​ត​ទៅ​ហៅ​ថា​​ <span class="text-bold">“ភាគី ក”</span>។<br>
  លេខទូរស័ព្ទទំនាក់ទំនង៖ {{ \App\Helpers\NumberFormat::convertToKhmerNumber($project->company->contact_phone_number) }}</p>

  <p class="text-center text-bold">និង</p>

  <p class="first-indent mb-0">ឈ្មោះ <span class="text-bold">{{ isset($is_template) ? '..................' : $customer1['name'] }}</span> ភេទ <span class="text-bold">{{ isset($is_template) ? "........." : $customer1['gender'] }}</span> កើតថ្ងៃទី <span class="text-bold">{{ isset($is_template) ? "........." : $customer1['birth_day'] }}</span> ខែ <span class="text-bold">{{ isset($is_template) ? "........." : $customer1['birth_month'] }}</span> ឆ្នាំ <span class="text-bold">{{ isset($is_template) ? "........." : $customer1['birth_year'] }}</span> ជនជាតិ{{$customer1['nationality']}} កាន់{{$customer1['indentity_text']}}លេខ <span class="text-bold">{{ isset($is_template) ? "............................" : $customer1['nid_number'] }}</span> ចុះថ្ងៃទី <span class="text-bold">{{ isset($is_template) ? "........." : $customer1['nid_issued_day'] }}</span> ខែ <span class="text-bold">{{ isset($is_template) ? "........." : $customer1['nid_issued_month'] }}</span> ឆ្នាំ <span class="text-bold">{{ isset($is_template) ? "........." : $customer1['nid_issued_year'] }}</span> 
  @if( $customer2['name'] != '')
  និង ឈ្មោះ <span class="text-bold">{{ isset($is_template) ? '............................' : $customer2['name'] }}</span> ភេទ <span class="text-bold">{{ isset($is_template) ? "........." : $customer2['gender'] }}</span> កើតថ្ងៃទី <span class="text-bold">{{ isset($is_template) ? "........." : $customer2['birth_day'] }}</span> ខែ <span class="text-bold">{{ isset($is_template) ? "........." : $customer2['birth_month'] }}</span> ឆ្នាំ <span class="text-bold">{{ isset($is_template) ? "........." : $customer2['birth_year'] }}</span> ជនជាតិ{{$customer2['nationality']}} កាន់​{{$customer2['indentity_text']}}លេខ <span class="text-bold">{{ isset($is_template) ? "............................" : $customer2['nid_number'] }}</span> ចុះថ្ងៃទី <span class="text-bold">{{ isset($is_template) ? "........." : $customer2['nid_issued_day'] }}</span> ខែ <span class="text-bold">{{ isset($is_template) ? "........." : $customer2['nid_issued_month'] }}</span> ឆ្នាំ <span class="text-bold">{{ isset($is_template) ? "........." : $customer2['nid_issued_year'] }}</span>
  @endif
  មានអាសយដ្ឋាន{{ isset($is_template) ? ".................." : $contract->customer_address_line1 }} {{ isset($is_template) ? '..................' : $contract->customer_address_line2 }} ជាអ្នកទិញ តទៅហៅថា <span class="text-bold bold-letter-spacing">“ភាគី ខ”</span>។
  <br>
  លេខទូរស័ព្ទទំនាក់ទំនង ៖ <span class="text-bold">{{ isset($is_template) ? ".................." : $phone_number }}</span>
  </p>

  <p><span class="text-bold">ឯកសារយោង ៖</span></p>
  
  <ul style="list-style: none; margin-bottom:0px;margin-top: 0px;">
    <li>ឧបសម្ព័ន្ធ១: តារាងទូទាត់ប្រាក់</li>    
    <li>ឧបសម្ព័ន្ធ២: ប្លង់ទីតាំងផ្ទះក្នុងគម្រោង</li>
    <li>ឧបសម្ព័ន្ធ៣: សម្ភារៈដែលបូកបញ្ចូល</li>
    <li>ឧបសម្ព័ន្ធ៤: អត្តសញ្ញាណប័ណ្ណអ្នកលក់ និងអ្នកទិញ</li>
    <li>ឧបសម្ព័ន្ធ៥: លិខិតប្រគល់សិទ្ធតំណាងក្រុមហ៊ុន</li>
  </ul>

  <p class="text-bold text-center"​ style="text-align: center !important;page-break-before: always;">ដោយផ្អែកលើគោលការណ៍ស្ម័គ្រចិត្ត និងស្មើភាព ភាគី “ក” និង ភាគី “ខ” បានព្រមព្រៀងគ្នាដូចតទៅ ៖</p>

  <p class="mb-0 text-bold"><u>ប្រការ១:</u> កម្មវត្ថុនៃការទិញ-លក់ និងតម្លៃ</p>

  <p class="pl-5">ភាគី “ក” យល់​ព្រម​លក់ ហើយ​ភាគី “ខ” យល់​ព្រម​ទិញ​ផ្ទះប្រភេទ {{ isset($is_template) ? '................' : $unit_type->name }} មួយ​ខ្នង ដែល​មាន​អា​ស័យ​ដ្ឋាន​ផ្ទះ​លេខ {{ isset($is_template) ? '................' : $unit->code }} ផ្លូវ​លេខ​ {{ isset($is_template) ? '................' : $unit->street }} នៅ​ក្នុង​ {{ $project->name }} ដែល​មាន​ទី​តាំង​នៅ {{ $project->address }} ក្នុង​តម្លៃ​ <strong> USD {{ isset($is_template) ? '............................' : \App\Helpers\NumberFormat::convertToKhmerNumber(number_format($contract->getUnitSoldPriceAfterDiscount())) }}</strong> ({{ isset($is_template) ? '................................................................' : App\Helpers\NumberFormat::covertUsdToKhmerWord($contract->getUnitSoldPriceAfterDiscount())}})។ តម្លៃ​នេះ​ជា​តម្លៃ​ដែល​មាន​បំពាក់​សម្ភារៈ​ប្រើ​ប្រាស់​ដូច​មាន​ក្នុង​ឧបសម្ព័ន្ធ៣។ ផ្ទះ​នេះ​មាន​ទំ​ហំ​ដី​ {{ isset($is_template) ? '............' : App\Helpers\NumberFormat::convertToKhmerNumber($unit->land_size_width * $unit->land_size_length) }} ម៉ែត្រការ៉េ 
  @if($unit->building_size_width)
  ទំ​ហំ​ផ្ទះ​ទទឹង {{ isset($is_template) ? '............' : App\Helpers\NumberFormat::convertToKhmerNumber($unit->building_size_width) }} ម៉ែត្រ និងបណ្តោយ {{ isset($is_template) ? '............' : App\Helpers\NumberFormat::convertToKhmerNumber($unit->building_size_length) }}  ម៉ែត្រ
  @else
  ទំហំ​ផ្ទះ​សរុប {{ isset($is_template) ? '............' : App\Helpers\NumberFormat::convertToKhmerNumber($unit->total_area_size) }} ម៉ែត្រការ៉េ
  @endif
   ដែល​មាន​បន្ទប់​ទទួល​ភ្ញៀវ {{ isset($is_template) ? '........' : App\Helpers\NumberFormat::convertToKhmerNumber($unit->living_room) }} ផ្ទះ​បាយ {{ isset($is_template) ? '........' : App\Helpers\NumberFormat::convertToKhmerNumber($unit->kitchen) }} បន្ទប់​គេង {{ isset($is_template) ? '........' : App\Helpers\NumberFormat::convertToKhmerNumber($unit->bedroom) }} និង បន្ទប់​ទឹក {{ isset($is_template) ? '........' : App\Helpers\NumberFormat::convertToKhmerNumber($unit->bathroom) }}។</p>

  <p><strong><u>ប្រការ​២:</u></strong> ភាគី “ខ” មិន​មាន​សិទ្ធិ​កែ​ប្រែ​សោ​ភ័ណ​ភាព​សំណង់​បាន​ឡើយ លុះ​ត្រា​តែ​មាន​ការ អនុញ្ញាត​ពី​ភាគី “ក”។</p>

  <p class="mb-0 text-bold"><u>ប្រការ៣:</u> ការទូទាត់ប្រាក់</p>

  <p class="pl-5"><span class="text-bold">៣.១</span>​ ភាគី “ខ” ត្រូវ​ទូ​ទាត់​ប្រាក់​សរុប​ថ្លៃ​ទិញ​ផ្ទះ​តាម​ដំណាក់​កាល​ជា​បន្ត​បន្ទាប់​ដូច​មាន​ចែង​ក្នុង​តារាង​ទូ​ទាត់​ប្រាក់​ក្នុង​ឧបសម្ព័ន្ធ១។</p>

  <p class="pl-5"><span class="text-bold">៣.២</span>​ ភាគី “ក” អនុ​គ្រោះ​ជូន​ភាគី “ខ” ក្នុង​ការ​បង់​ប្រាក់​យឺត​យ៉ាវ​ត្រឹម​រយៈ​ពេល​មួយ​សប្ដាហ៍​ដោយ​មិន​ពិន័យ។ ករណី​ភាគី “ខ” នៅ​តែ​បន្ត​ការ​យឺត​យ៉ាវ​បង់​ប្រាក់​បន្ទាប់​ពី​ក្រុម​ហ៊ុន​បាន​អនុ​គ្រោះ​មួយ​សប្តាហ៍​រួច​មក​ហើយ​នោះ ភាគី “ខ” ត្រូវ​បង់​ប្រាក់​ពិន័យ​ការ​យឺត​យ៉ាវ​ក្នុង​មួយ​ថ្ងៃ​ USD ៥ (ប្រាំ​ដុល្លារ​សហរដ្ឋ​អាមេរិច)។ ក្នុង​ករណី​ការ​យឺត​យ៉ាវ និង ខក​ខាន​បង់​ប្រាក់​លើស​ពី​២ខែ នោះ​ភាគី “ក” ចាត់​ទុក​ថា​ភាគី “ខ” បាន​បោះ​បង់​សិទ្ធិ​ជា​អ្នក​ទិញ​ក្នុង​ការ​បន្ត​កិច្ច​សន្យា​ទិញ-លក់នេះ។ ក្នុង​ករណី​នេះ ភាគី “ក” មាន​សិទ្ធិ​លក់​ផ្ទះ​នេះ​ឲ្យ​ទៅ​អ្នក​ផ្សេង​ទៀត​បាន​ ហើយ​ប្រាក់​ដែល​បាន​បង់​ទាំង​អស់​ចាត់​ទុក​ជា​អសារ​បង់។</p>

  <p><span class="text-bold"><u>ប្រការ៤:</u></span> អំឡុង​ពេល​សាង​សង់​ភាគី “ខ” អាច​លក់ ឬ​ផ្ទេរ​កិច្ច​សន្យា​បាន​បន្ទាប់​ពី​ស្នើ​សុំ​ហើយ ទទួល​បាន​ឯក​ភាព​ជា​លាយ​លក្ខណ៍​អក្សរ​ពីភាគី “ក” ដោយ​ភាគី “ខ” ត្រូវ​បង់​ថ្លៃ​សេវា​រដ្ឋ​បាល​ក្រុមហ៊ុន ចំនួន USD {{  App\Helpers\NumberFormat::convertToKhmerNumber($contract->contract_transfer_fee) }} ({{  App\Helpers\NumberFormat::covertUsdToKhmerWord($contract->contract_transfer_fee) }}) ជូន​ភាគី “ក” ។ ភាគី​ទី​បី​ដែល​ទទួល​យក​ការ​ផ្ទេរ​កិច្ច​សន្យាពីភាគី “ខ” ត្រូវ​គោរព​តាម​ខ្លឹម​សារ​ទាំង​ស្រុង​នៃ​កិច្ច​ព្រម​ព្រៀង​នេះ​។</p>

  <p><span class="text-bold"><u>ប្រការ៥:</u></span> ចំពោះ​អតិ​ថិ​ជន​ដែល​ជ្រើស​រើស​ជម្រើស​បង់​រំលស់ (Loan) អត្រា​ការ​ប្រាក់​ជា​មួយ​ខាង​ក្រុមហ៊ុន ករណី​សំណង់​សាង​សង់​បាន ៧០% (ចិត​សិប​ភាគ​រយ) ក្រុម​ហ៊ុន​មាន​សិទ្ធិ​ពេញ​លេញ​ក្នុង​ការ​បញ្ជូន​ប្រតិបត្តិ​ការ​បង់​រំលស់ (Loan) របស់​អ​តិ​ថិ​ជន ទៅ​បង់​រំលស់​ជា​មួយ ធ​នា​គារ​ណា​មួយ ដែល​ក្រុម​ហ៊ុន​សហការ​ជា​មួយ។ រាល់​ការ​ចំណាយ​លើ​សេ​វា​ធ​នា​គារ​ជា​បន្ទុក​របស់​ភាគី “ខ” ទាំង​ស្រុង។</p>

  <p><span class="text-bold"><u>ប្រការ៦:</u></span> ភាគី “ក” សន្យា​ថា​នៅ​ក្នុង​អំឡុង​ពេល {{ App\Helpers\NumberFormat::convertToKhmerNumber($contract->deadline) }}ខែ និង​អនុ​គ្រោះ​បន្ថែម {{  App\Helpers\NumberFormat::convertToKhmerNumber($contract->extended_deadline) }}ខែ ដោយ​គិត​ចាប់​ពី​ថ្ងៃ​ចុះ​កិច្ច​សន្យា ភាគី “ក” នឹង​ប្រគល់​ផ្ទះ​លេខ {{ isset($is_template) ? '........' : $unit->code }} ជូន​ទៅ​ភាគី “ខ”។ ប្រសិន​បើ​ភាគី “ក” យឺត​យ៉ាវ​ក្នុង​ការ​ប្រគល់​ផ្ទះ​ជូន​ភាគី  “ខ” ភាគី “ក” ត្រូវ​បង់​សំណង​ជូន​ភាគី “ខ” ជា​ទឹក​ប្រាក់ ១% (មួយភាគរយ) ក្នុង​មួយ​ខែ​នៃ​ទឹក​ប្រាក់​ដែល​បាន​បង់​រួច។</p>

  <p class="page-break-before: always;"><span class="text-bold"><u>ប្រការ៧:</u></span> ភាគី “ក” មាន​កាតព្វ​កិច្ច​ក្នុង​ការ​ថែរក្សា​នូវ​សុវត្ថិភាព សន្តិសុខ សណ្តាប់​ធ្នាប់ សោភ័ណភាព ទ្រព្យ​សម្បត្តិ​សា​ធារ​ណៈ​ផ្សេងៗ​ក្នុង​បុរី​ទាំង​មូល។ បន្ទាប់​ពី​ភាគី​ “ក” ប្រគល់​ផ្ទះ​ជូន​ទៅ​ភាគី “ខ” រួច ភាគី “ខ” មាន​កាតព្វ​កិច្ច​បង់​ថ្លៃ​សេវា​ចំនួន USD {{ App\Helpers\NumberFormat::convertToKhmerNumber($contract->annual_management_fee) }} ({{ App\Helpers\NumberFormat::covertUsdToKhmerWord($contract->annual_management_fee) }}) ក្នុង​១​ឆ្នាំ {{ $contract->management_service_kh }}។ ភាគី “ក” មាន​សិទ្ធិ​ក្នុង​ការ​កែ​ប្រែ​តម្លៃ​ខាង​លើ​ទៅ​តាម​តម្លៃ​ទីផ្សារ។ ប្រសិន​បើ​មាន​ការ​កែ​ប្រែ ភាគី “ក” នឹង​ជូន​ដំណឹង​ជា​សា​ធារណៈ​រយៈ​ពេល​១ខែ​ទុក​ជា​មុន។</p>

  <p><span class="text-bold"><u>ប្រការ៨:</u></span> ភាគី “ក” ធានា​ចំពោះ​គុណ​ភាព​សំណង់​និង​ការ​បាក់​ស្រុត​រយៈ​ពេល៣ឆ្នាំ និងធានា ចំពោះ​ការ​ជួស​ជុល​ប្រេះស្រាំ និង​លិច​ទឹកក្នុង​រយៈ​ពេល១ឆ្នាំ ​ដោយ​យោង​តាមបច្ចេកទេស​សាងសង់ គិត​ចាប់​ពី​ថ្ងៃ​ដែល​ភាគី “ក” ប្រគល់​ផ្ទះ​ជូន​ភាគី “ខ”។</p>

  <p><span class="text-bold"><u>ប្រការ៩:</u></span> {{ $contract->title_clause_kh }}</p>

  <p class="mb-0 text-bold"><u>ប្រការ​១០:</u> ភារៈកិច្ចទទួលខុសត្រូវមុន និងក្រោយទទួលផ្ទះ</p>

  <p class="ml-5"><span class="text-bold">១០.១</span>​ ភាគី “ក” ទទួល​ខុស​ត្រូវ​ទាំង​ស្រុង​លើ​ពន្ធ​អចលន​ទ្រព្យ ការ​បង់​ពន្ធ​ដី​មិន​ប្រើ​ប្រាស់​និង​អា​ជីវកម្មសាង​សង់​ផ្ទះ​លក់​របស់​ក្រុម​ហ៊ុន <span class="text-bold">មុន​ពេល​ប្រគល់​ផ្ទះ។</span></p>

  <p class="ml-5"><span class="text-bold">១០.២</span>​ បន្ទាប់​ពី​ភាគី “ខ” ទទួល​ផ្ទះ​ពី​ភាគី “ក” រួច ចំពោះ​ការ​បង់​ពន្ធ​លើ​អចលន​ទ្រព្យ និង​ពន្ធ​ផ្សេងៗ​ទៀត​ដែល​រដ្ឋ​តម្រូវ​ក្នុង​អំឡុង​ពេល​ភាគី “ខ” <span class="text-bold">ទទួល​កាន់​កាប់​ជា​បន្ទុក​របស់​ភាគី “ខ” ។</span></p>

  <p style="margin-bottom:0px;"><span class="text-bold"><u>ប្រការ១១:</u></span> កិច្ច​ព្រមព្រៀង​នេះ​ត្រូវ​ធ្វើ​ឡើង​ដោយ​គ្មាន​ការ​គំរាម​កំហែង បង្ខិតបង្ខំ ឬ​មាន​បញ្ហា​ខុស​ច្បាប់​ណា​មួយ​ឡើយ​ ហើយ​ត្រូវ​ចូល​ជា​ធរ​មាន​បន្ទាប់​ពី​ភាគី “ក” និង ភាគី “ខ” បាន​ផ្តិត​ស្នាម​មេដៃ​ ឬ​ប្រថាប់ត្រា។ កិច្ចព្រមព្រៀង​នេះ​ធ្វើ​ឡើង​ជា​ភាសា​ខ្មែរ​ចំនួន​ពីរ​ច្បាប់​ ក្នុង​នោះ​ភាគី​ “ក” រក្សា​ទុក​មួយ​ច្បាប់​ដើម​ ភាគី “ខ” រក្សា​ទុក​មួយ​ច្បាប់​ដើម។ ច្បាប់​នីមួយៗ​មាន​អានុភាព​គតិយុត្តិ​ស្មើគ្នា។​</p>

  <table style="text-align: center; width: 100%;page-break-after: always; page-break-inside: avoid;">
    <tr>
      <td colspan="4"><p style="text-align: right;margin-top:0px;">រាជធានីភ្នំពេញ ថ្ងៃទី........ ខែ........ ឆ្នាំ២០........</p></td>
    </tr>
    <tr>
      <td><p class="text-center mb-0">ស្នាមមេដៃស្ដាំភាគី “ក”</p></td>
      <!-- 
      <td><p class="text-center mb-0">សាក្សីភាគី “ក”</p></td>
      <td><p class="text-center mb-0">សាក្សីភាគី “ខ”</p></td> 
      -->
      <td><p class="text-center mb-0">ស្នាមមេដៃស្ដាំភាគី “ខ”</p></td>
    </tr>
    <tr>
      <td><p class="text-center">ភាគីអ្នកលក់</p></td>
      <!-- 
      <td><p class="text-center">ភាគីអ្នកលក់</p></td>
      <td><p class="text-center">ភាគីអ្នកទិញ</p></td>
       -->
      <td><p class="text-center">ភាគីអ្នកទិញ</p></td>
    </tr>
    <tr>
      <td height="200px"><h4 class="Battambang-font text-bold">{{ $project->saleRepresentative->name }}</h4></td>
      <!--  
      <td>...........................</td>
      <td>...........................</td>
      -->
      @if(isset($is_template))
      <td><h4 class="Battambang-font text-bold">.................... / ....................</h4></td>          
      @else
      <td><h4 class="Battambang-font text-bold">{{ $customer1['name'] }}{{ $customer2['name'] != '' ? " / ".$customer2['name'] : "" }}</h4></td>    
      @endif      
    </tr>
  </table>

  @include('admin.contract.template.payment_template', ['contract' => $contract])
  
  <h4 class="battambang-font text-center">{{ $project->name }}</h4>
  <h4 class="main-title text-center mb-4">ឧបសម្ព័ន្ធ៣ : សម្ភារៈដែលបូកបញ្ចូលផ្ទះប្រភេទ {{ $unit_type->name }}</h4>
  {!! $contract->equipment_text !!}   

  <div style="page-break-after: always;"></div>
  <h4 class="main-title text-center mb-4">ឧបសម្ព័ន្ធ៤ : អត្តសញ្ញាណប័ណ្ណ អ្នកទិញ និង អ្នកលក់</h4>  
  
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
</body>
</html>