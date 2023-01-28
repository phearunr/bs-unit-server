<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contract - {{ $contract->customer1_name }}</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/contract_print.css') }}">  
</head>
@php  
  $customer1 = [
    'name' => $contract->customer1_name,
    'gender' => $contract->customer1_gender == 1 ? "ប្រុស" : "ស្រី",
    'birth_day' => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->customer1_birthdate->day),
    'birth_month' =>  \App\Helpers\KhmerMonth::convertToKhmerMonth($contract->customer1_birthdate->month),
    "birth_year" => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->customer1_birthdate->year),
    "nid_number" => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->customer1_nid),
    'nid_issued_day' => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->customer1_nid_issued_date->day),
    'nid_issued_month' => \App\Helpers\KhmerMonth::convertToKhmerMonth($contract->customer1_nid_issued_date->month),
    'nid_issued_year' => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->customer1_nid_issued_date->year)
  ];

  if ( $contract->customer2_name != "" ) {
    $customer2 = [
      'name' => $contract->customer2_name,
      'gender' => $contract->customer2_gender == 1 ? "ប្រុស" : "ស្រី",
      'birth_day' => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->customer2_birthdate->day),
      'birth_month' =>  \App\Helpers\KhmerMonth::convertToKhmerMonth($contract->customer2_birthdate->month),
      "birth_year" => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->customer2_birthdate->year),
      "nid_number" => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->customer2_nid),
      'nid_issued_day' => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->customer2_nid_issued_date->day),
      'nid_issued_month' => \App\Helpers\KhmerMonth::convertToKhmerMonth($contract->customer2_nid_issued_date->month),
      'nid_issued_year' => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->customer2_nid_issued_date->year)
    ];
  }

  $address = [
    'house_no' => $contract->customer_house_no,
    'street' => $contract->customer_street,
    'phum' => $contract->customer_phum,
    'sangkat' => $contract->customer_commune,
    'khan' => $contract->customer_district,
    'city' =>$contract->customer_city
  ];

  if ( is_null($contract->customer_phone_number2) || $contract->customer_phone_number2 == "" ) {
    $phone_number = $contract->customer_phone_number;
  } else {
    $phone_number = $contract->customer_phone_number.' / '.$contract->customer_phone_number2;
  } 

  $unit = [
    'house_no' => $contract->unit_code,
    'street' => $contract->unit_street,
    'price' => \App\Helpers\NumberFormat::convertToKhmerNumber(number_format($contract->unit_sold_price)),
    'price_khmer_word' => App\Helpers\NumberFormat::covertUsdToKhmerWord($contract->unit_sold_price),
    'type' => $contract->unitType->name,
    'floor' => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->unit_floor),
    'land_width' => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->unit_land_width),    
    'land_length' => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->unit_land_length),
    'total_land_area' => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->unit_land_length * $contract->unit_land_width),
    'house_width' => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->unit_house_width),
    'house_length' => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->unit_house_length),
    'total_area' => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->unit_total_area),
    'service_fee' => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->service_fee)
  ];
  
@endphp
<body>
  <div class="row mb-5">
    <div class="col">
      <img src="{{ asset('img/logo/scc-logo.png') }}" width="150px">      
    </div>
    <div class="col-auto">
      <h2 class="mb-3 main-title text-center">ព្រះរាជាណាចក្រកម្ពុជា</h2>
      <h2 class="main-title text-center">ជាតិ សាសនា ព្រះមហាក្សត្រ</h2>
    </div>
  </div>
  <h2 class="main-title text-center mb-4">កិច្ចសន្យាទិញ-លក់ ខុនដូ</h2>
  <p class="text-lg text-center mb-4">គម្រោង <span class="english-font text-bold" style="font-size:18pt;">Sihanouk  Cityview</span></p>
  <p class="text-center text-bold">រវាង</p>
  <p class="first-indent">គំម្រោង <span class="english-font text-bold">Sihanouk Cityview</span> មាន​ការិយាល័យ​កណ្តាលស្ថិត​នៅ​អគារ​លេខ <span class="english-font text-bold">B2-109, B2-110</span> សង្កាត់-ទន្លេបាសាក់ ខណ្ឌ-ចំការមន រាជធានី-ភ្នំពេញ នៃក្រុមហ៊ុន <span class="english-font text-bold">BS Land & Home Co., Ltd</span> តំណាងស្របច្បាប់ចុះកិច្ចសន្យាទិញ-លក់ដោយឈ្មោះ <span class="text-bold">យីប ស៊ាងហុង</span> ភេទស្រី កើតនៅថ្ងៃទី១៤ ខែ០១ ឆ្នាំ១៩៩០ ជនជាតិ​ខ្មែរ​កាន់​អត្តសញ្ញាណ​ប័ណ្ណ​លេខ 010641433 ចុះថ្ងៃទី២៨ ខែ១១ ឆ្នាំ២០០៧ អាស័យដ្ឋានបច្ចុប្បន្នផ្ទះលេខ-16 ផ្លូវ-K4B ភូមិ-ទឹកថ្លា ឃុំ-សង្កាត់-ទឹកថ្លា ខណ្ឌ-សែនសុខ   ខេត្ត-ក្រុងភ្នំពេញ។ ចាប់​ពី​ថ្ងៃ​ផ្តិត​មេដៃ​ចុះ​កិច្ច​សន្យា​នេះ​ត​ទៅ​ហៅ​កាត់​ថា​ភាគី (ក) អ្នកលក់។<br>
  លេខទូរសព្ទទំនាក់ទំនង ៖ <span class="english-font" >087 499995/ 011 488885</p>

  <p class="text-center text-bold">និង</p>

  <p class="first-indent mb-0">ឈ្មោះ <span class="text-bold">{{ $customer1['name'] }}</span> ភេទ <span class="text-bold">{{ $customer1['gender'] }}</span> កើតថ្ងៃទី <span class="text-bold">{{ $customer1['birth_day'] }}</span> ខែ <span class="text-bold">{{ $customer1['birth_month'] }}</span> ឆ្នាំ <span class="text-bold">{{ $customer1['birth_year'] }}</span> ជនជាតិខ្មែរ កាន់​អត្តសញ្ញាណប័ណ្ណលេខ <span class="text-bold">{{ $customer1['nid_number'] }}</span> ចុះថ្ងៃទី <span class="text-bold">{{ $customer1['nid_issued_day'] }}</span> ខែ <span class="text-bold">{{ $customer1['nid_issued_month'] }}</span> ឆ្នាំ <span class="text-bold">{{ $customer1['nid_issued_year'] }}</span> 
  @if(isset($customer2))
  និង ឈ្មោះ <span class="text-bold">{{ $customer2['name'] }}</span> ភេទ <span class="text-bold">{{ $customer2['gender'] }}</span> កើតថ្ងៃទី <span class="text-bold">{{ $customer2['birth_day'] }}</span> ខែ <span class="text-bold">{{ $customer2['birth_month'] }}</span> ឆ្នាំ <span class="text-bold">{{ $customer2['birth_year'] }}</span> ជនជាតិខ្មែរ កាន់​អត្តសញ្ញាណប័ណ្ណលេខ <span class="text-bold">{{ $customer2['nid_number'] }}</span> ចុះថ្ងៃទី <span class="text-bold">{{ $customer2['nid_issued_day'] }}</span> ខែ <span class="text-bold">{{ $customer2['nid_issued_month'] }}</span> ឆ្នាំ <span class="text-bold">{{ $customer2['nid_issued_year'] }}</span>
  @endif
  មានអស័យដ្ឋានផ្ទះលេខ <span class="text-bold">{{ $address['house_no'] }}</span> ផ្លូវលេខ <span class="text-bold">{{ $address['street'] }}</span> ភូមិ <span class="text-bold">{{ $address['phum'] }}</span> ឃុំ/សង្កាត់ <span class="text-bold">{{ $address['sangkat'] }}</span> ស្រុក/ខណ្ឌ <span class="text-bold">{{ $address['khan'] }}</span> រាជធានី/ខេត្ត <span class="text-bold">{{ $address['city'] }}</span> ជាអ្នកទិញ តទៅហៅថា <span class="text-bold">“ភាគី ខ”</span>។
  <br>
  ទូរសព្ទលេខទំនាក់ទំនង ៖ <span class="text-bold">{{ $phone_number }}</span>
  </p>

  <p class="m-0 p-0"><span class="text-bold">យោង ៖</span></p>
  <ul style="{{ isset($customer2) ? '' : 'page-break-after: always;' }}">
    <li>ឧបសម្ព័ន្ធ១ : តារាងទូទាត់ប្រាក់</li>
    <li>ឧបសម្ព័ន្ធ២ : ប្លង់ទីតាំងក្នុង​អគារ​ខុនដូ</li>
    <li>ឧបសម្ព័ន្ធ៣ : សម្ភារៈ​ដែល​បូក​បញ្ចូល​ក្នុង​បន្ទប់​ខុនដូ​</li>
    <li>ឧបសម្ព័ន្ធ៤ :  អត្តសញ្ញាណប័ណ្ណ អ្នកទិញ និង អ្នកលក់</li>
  </ul>
  <div style="page-break-after: always;"></div>

  <p class="text-bold text-center"​ style="text-align: center !important;">ដោយផ្អែកលើគោលការណ៍ស្ម័គ្រចិត្ត និងស្មើភាព ភាគី “ក” និង ភាគី “ខ” បានព្រមព្រៀងគ្នាដូចតទៅ ៖</p>

  <p class="mb-0 text-bold"><u>ប្រការ១: កម្មវត្ថុនៃការទិញ-លក់ និងតម្លៃ</u></p>
  <p>ភាគី “ក” យល់​ព្រម​លក់​ហើយ​ភាគី​ “ខ” យល់​ព្រម​ទិញ​បន្ទប់​ខុន​ដូ​ប្រភេទ <span class="text-bold">{{ $unit['type'] }}</span> ទំហំសរុប <span class="text-bold">{{ $unit['total_area'] }}</span> ម៉ែត្រការ៉េ បន្ទប់លេខ <span class="text-bod">{{ $unit['house_no'] }} ជាន់ទី <strong>{{ $unit['floor'] }}</strong> ក្នុង​អគារ <span class="english-font text-bold">Sihanouk Cityview</span> ដែល​មាន​ទី​តាំង​ស្ថិត​នៅ​ភូមិ5 សង្កាត់4 ខណ្ឌមិត្តភាព ក្រុងព្រះសីហនុ​ ​ក្នុង​តម្លៃ <span class="english-font">USD </span> {{ $unit['price'] }} ({{$unit['price_khmer_word']}})។ ជា​តម្លៃ​ដែល​មាន​ការ​តុប​តែង​ដែល​មាន​បូក​បញ្ចូល​សម្ភារៈ​ប្រើ​ប្រាស់​ដូច​មាន​ក្នុង​ឧបសម្ព័ន្ធ៣។ ក្នុង​ករណី​រោងចក្រ​ឈប់​ផលិត​នូវ​ផលិត​ផល​​ដែល​ក្រុម​ហ៊ុន​បាន​ជ្រើសរើស ភាគី “ក” មាន​សិទ្ធិ​ក្នុង​ការ​ផ្លាស់ប្តូរ​ដោយ​រក្សា​នូវ​គុណភាព​ដដែល។</p>

  <p><span class="text-bold"><u>ប្រការ២:</u></span> ភាគី “ខ” យល់​ព្រម​ទទួល​យក​ទាំង​ស្រុង​នូវ​ប្លង់​រចនាម៉ូត​សំណង់​ព្រម​ទាំង​សន្យា​ថា​មិន​កែប្រែ​ទ្រង់ទ្រាយ​ក្នុង​ និង ក្រៅ​ បន្ទប់​ដោយ​ខ្លួន​ឯង​ ឬ​ ជួល​ក្រុមហ៊ុន​ដទៃ​ ឬ បុគ្គល​ណា​ម្នាក់​មក​ធ្វើ​ការ​កែប្រែ​បន្ទប់​នោះ​ទេ​។ ប្រសិន​បើ​មាន​ការ​ចាំ​បាច់​ភាគី “ខ” ត្រូវ​ធ្វើ​ការ​ស្នើ​សុំ ហើយ បន្ទាប់​ពី​ទទួល​បាន​ការ​ឯកភាព​ពី​ភាគី “ក” ក្រុមហ៊ុន​តំណាង​ចាត់​ចែង​ត្រូវ កំណត់ ដោយ​ភាគី “ក”។</p>

  <p class="text-bold"><u>ប្រការ៣: កាលបរិច្ឆេទនៃការទូទាត់ប្រាក់</u></p>
  <p class="pl-5">៣.១ ភាគី “ខ” ត្រូវ​ទូទាត់​ប្រាក់​សរុប​ថ្លៃ​ទិញ​បន្ទប់​តាម​ដំណាក់​កាល​ជា​បន្ត​បន្ទាប់​ដូច​មាន​ចែង​ក្នុង​តារាង​ទូទាត់​ប្រាក់​ក្នុង​ឧបសម្ព័ន្ធ១។</p>
  <p class="pl-5">៣.២ ភាគី “ក” អនុគ្រោះ​ជូន​ភាគី “ខ” ក្នុង​ការ​បង់​ប្រាក់​យឺត​យ៉ាវ​ត្រឹម​រយៈ​ពេល​មួយ​សប្ដាហ៍​ដោយ​មិន​ពិន័យ។ ករណី​ភាគី “ខ” នៅ​តែ​បន្ត​ការ​យឺត​យ៉ាវ​បង់​ប្រាក់​បន្ទាប់​ពី​ក្រុម​ហ៊ុន​បាន​អនុគ្រោះ​មួយ​សប្តាហ៍​រួច​មក​ហើយ​នោះ ភាគី “ខ” ត្រូវ​បង់​ប្រាក់​ពិន័យ​ការ​យឺត​យ៉ាវ​ក្នុង​មួយ​ថ្ងៃ 5 US$ ( ប្រាំ​ដុល្លារ​ក្នុង​មួយ​ថ្ងៃ ) ករណី​ការ​យឺត​យ៉ាវ និង ខក​ខាន​បង់​ប្រាក់​មិន​អោយ​លើស​ពី​២​ខែ​នោះ​ឡើយ​ ភាគី “ក” ចាត់​ទុក​ថា​ភាគី “ខ” បាន​បោះ​បង់​សិទ្ធិ​ជា​អ្នក​ទិញ​ក្នុង​ការ​បន្ត​កិច្ច​សន្យា​ទិញ-លក់​នេះ។</p>

  <p><span class="text-bold"><u>ប្រការ៤:</u></span> អំឡុង​ពេល​សាង​សង់​ភាគី “ខ” អាច​លក់ ឬ​ផ្ទេរ​កិច្ច​សន្យា​បាន​បន្ទាប់​ពី​ស្នើ​សុំ​ហើយ ទទួល​បាន​ឯកភាព​ជា​លាយ​លក្ខណ៍​អក្សរ​ពី​ភាគី “ក” ដោយ​ភាគី “ខ” ត្រូវ​បង់​ថ្លៃ​សេវា​រដ្ឋ​បាល​ក្រុម​ហ៊ុន​ចំនួន 300 US$ (បី​រយ​ដុល្លា​អា​មេ​រិក​) ជូន​ភាគី “ក” ។ ភាគី​ទី​បី​ដែល​ទទួល​យក​ការ​ផ្ទេរ​កិច្ច​សន្យា​ពី​ភាគី “ខ” ត្រូវ​គោរព​តាម​ខ្លឹម​សារ​ទាំង​ស្រុង​នៃ​កិច្ច​ព្រម​ព្រៀង​នេះ​។</p>

  <p><span class="text-bold"><u>ប្រការ៥:</u></span> ចំពោះអតិថិជន​ដែល​ជ្រើស​រើស​ជំ​រើស​បង់​រំលស់ (Loan) អត្រា​ការ​ប្រាក់​ជា​មួយ​ខាង ក្រុម​ហ៊ុន​ករណី​សំណង់​សាង​សង់​បាន 70% ក្រុម​ហ៊ុន​មាន​សិទ្ធិ​ពេញ​លេញ​ក្នុង​ការ​បញ្ជូន​ប្រតិបត្តិ​ការ​បង់​រំលស់ (Loan) របស់​អតិថិជន​ទៅ​បង់​រំលស់ជាមួយធនាគារណាមួយដែល   ក្រុម​ហ៊ុនសហការជាមួយហើយរាល់ការចំណាយលើសេវាធនាគារជាបន្ទុកខាងភាគី “ខ” ទាំងស្រុង។</p>

  <p><span class="text-bold"><u>ប្រការ៦:</u></span> ភាគី “ក” សន្យា​ថា​នៅ​ក្នុង​អំឡុងពេល <strong>៣០</strong>ខែ និងអនុគ្រោះ​បន្ថែម <strong>៦</strong>ខែ សរុប​រយៈ​ពេល​រួចរាល់ <strong>៣៦</strong>ខែ ដោយ​គិត​ចាប់​ពី​ថ្ងៃ​ចុះ​កិច្ច​សន្យា​ក្រុមហ៊ុន​នឹង​ប្រគល់​បន្ទប់​លេខ​ {{ $unit['house_no'] }} ជាន់ទី {{ $unit['floor'] }} ជូន​ទៅ​ភាគី “ខ”។ ប្រសិន​បើ​ការ​សាង​សង់​បន្ទប់​ហើយ​មុន​កាល​កំណត់​ក្នុង​កិច្ច​សន្យា ភាគី “ក” មាន​កាតព្វ​កិច្ច​ជូន​ដំណឹង​ទៅ​ភាគី “ខ” ដើម្បី​មក​បំពេញ​បែប​បទ​ទទួល​បន្ទប់ និង​ធ្វើ​លិខិត​ចូល​ស្នាក់​នៅ។ ប្រសិន​បើ​ភាគី “ក” យឺត​យ៉ាវ​ក្នុង​ការ​ប្រគល់​បន្ទប់​ជូន​ភាគី “ខ” ភាគី “ក” ត្រូវ​បង់​សំណង​ជូន​ភាគី “ខ” ជា​ទឹក​ប្រាក់ <strong>១%</strong> ក្នុង​មួយ​ខែ​នៃ​ទឹក​ប្រាក់​ដែល​បាន​បង់​រួច។</p>

  <p><span class="text-bold"><u>ប្រការ៧:</u></span> ភាគី “ក” មាន​កាតព្វកិច្ច​ក្នុង​ការ​ថែរក្សា​នូវ​សុវត្ថិភាព សន្តិសុខ សណ្តាប់ធ្នាប់  សោភ័ណ្ឌភាព ទ្រព្យ​សម្បត្តិ​សាធារណៈ​ផ្សេងៗ​ក្នុង​អគារ​ខុន​ដូ។</p>

  <p><span class="text-bold"><u>ប្រការ៨:</u></span> បន្ទាប់​ពី​ភាគី “ក” និង​ភាគី “ខ” បាន​ទូទាត់​ប្រាក់​ថ្លៃ​ទិញ​-​លក់​ និង​ធ្វើ​ការ​ផ្ទេរ​សិទ្ធិ​គ្រប់​គ្រង​បន្ទប់​ខុនដូ​រួច​រាល់ ភាគី “ខ” សន្យា​ថា​នឹង​គោរព​យ៉ាង​ម៉ឺង​ម៉ាត់​តាម​បទ​បញ្ជា​ផ្ទៃ​ក្នុង​ដែល​កំណត់​ដោយ​ភាគី “ក” មាន​ដូចជា សណ្តាប់ធ្នាប់ សុវត្ថិភាព សុខភាព អនាម័យ មិនចិញ្ចឹមសត្វ (សត្វឆ្មា សត្វឆ្កែ សត្វបក្សី និងសត្វផ្សេងៗទៀត) មិន​ស្រែក​ឡូឡា​ខ្លាំងៗ មិន​បំពុល​បរិស្ថាន មិន​អនុញ្ញាត​ឲ្យ​នាំ​អាវុធ និង​គ្រឿង​ញៀន​ចូល មិន​អនុញ្ញាត​ឲ្យ​បើក​បន​ល្បែង បើក​ហាង​លក់​ទំនិញ ឬក្រុមហ៊ុន គឺ​សម្រាប់​តែ​ស្នាក់​នៅ​ប៉ុណ្ណោះ។</p>  
  <p class="text-center text-bold">ភាគី “ខ” សន្យាយល់ព្រមគោរពតាមការកំណត់ជាសាធារណៈរបស់ផ្នែកគ្រប់គ្រងសេវាកម្ម</p>
  <ul>
    <li>ភាគី “ខ” ត្រូវទិញធានារ៉ាប់រងអគ្គីភ័យដោយខ្លួនឯង។</li>
    <li>ភាគី “ខ” មិនត្រូវ​កែ​ប្រែ​រចនា​សម្ព័ន្ធ​សំណង់ និង​សោភ័ណ្ឌភាព​នៃ​បន្ទប់​អគារ​ខាង​ក្រៅ។</li>
    <li>ភាគី “ខ” ត្រូវ​ទទួល​បន្ទុក​លើ​ថ្លៃ​ជួស​ជុល​ថែ​ទាំ ក្រោយ​រយៈ​ពេល​ធានា​ជួស​ជុល​ថែទាំ។</li>
  </ul>

  <p><span class="text-bold"><u>ប្រការ៩:</u></span> ភាគី “ក” មាន​កាតព្វ​កិច្ច​ទទួល​ខុស​ត្រូវ​សហការ​ជា​មួយ​ភាគី “ខ” ពេល​ភាគី “ខ” បង់​ប្រាក់​ផ្ដាច់​គ្រប់100% ក្រុម​ហ៊ុន​និង​ផ្ទេរ​ប្លង់​រឹង​សហកម្ម​សិទ្ធិ ជូន​ភាគី “ខ” រាល់​ការ​ចំណាយផ្សេងៗ​​បូក​រួម​ទាំង​ពន្ធ​ផ្សេងៗ​ជា​បន្ទុក​ភាគី “ខ” ទាំង​ស្រុង។</p>

  <p><span class="text-bold"><u>ប្រការ១០:</u></span> ប្រសិន​បើ​ភាគី “ខ” ជួល​បន្ទប់​នេះ ភាគី “ខ” មាន​កាតព្វកិច្ច​ជូន​ដំណឹង​ដល់​ភាគី “ក” ទុក​ជា​មុន ហើយ​ត្រូវ​ធានា​ថា​ភាគី​ទី​បី​គោរព​អនុវត្ត​តាម​ប្រការ៧ និងប្រការ៨ ខាងលើ។</p>

  <p><span class="text-bold"><u>ប្រការ១១:</u></span> ភាគី “ក” ធានា​ចំពោះ​គុណ​ភាព​សំណង់ និង​បរិក្ខា ជូន​ភាគី “ខ” គិត​ចាប់​ពី​ថ្ងៃ​ដែល ភាគី “ខ” ត្រូវ​ធ្វើ​លិខិត​ចូល​ស្នាក់​នៅ ដូច​ខាង​ក្រោម៖</p>
  <ul>
    <li>អគារ​បាក់​ស្រុត ភាគី “ក” ធានា​រយៈ​ពេល​ 5 ឆ្នាំ (ប្រាំឆ្នាំ) ប៉ុន្តែ​ការ​ធានា​នេះ​គឺ​ធានា​ត្រឹម​ការ​បាក់​ស្រុត​ដែល​បណ្តាល​មក​ពី​គុណភាព​សំណង់​តែ​ប៉ុណ្ណោះ។</li>
    <li>ជញ្ជាំង​ប្រេះ បែក ប្រព័ន្ធទឹក ប្រព័ន្ធអគ្គិសនី ប្រព័ន្ធលូ ភាគី “ក” ធានា​រយៈ​ពេល 1 ឆ្នាំ (មួយឆ្នាំ) ក្នុង​ការ​ជួសជុល។</li>
    <li>បរិក្ខា​អគ្គិសនី​ក្នុង​បន្ទប់ ត្រូវ​បាន​ធានា​ដោយ​យោង​ទៅ​តាម​លក្ខខណ្ឌ​ដែល​បាន​កំណត់ ដោយ​រោង​ចក្រ​ផលិត ឬ​អ្នក​លក់។</li>
    <li>ការ​ខូច​ខាត​ដែល​បង្ក​ឡើង​ដោយ​ករណី​ប្រធាន​ស័ក្តិ សង្គ្រាម និង​គ្រោះធម្មជាតិ​ផ្សេងៗ ព្រម​ទាំង​សកម្មភាព​បំពាន​ផ្សេងៗ មិន​រាប់​បញ្ចូល​ក្នុង​វិសាលភាព​នៃ​ការ​ធានា​ក្នុង​ប្រការ នេះឡើយ។</li>
  </ul>

  <p><span class="text-bold"><u>ប្រការ១២:</u></span> ភាគី “ខ” មាន​កាតព្វកិច្ច​បង់​ថ្លៃ​សេវា​សាធារណៈ​ចំនួន {{ $unit['service_fee'] }}US$ ({{ \App\Helpers\NumberFormat::covertUsdToKhmerWordFloat($contract->service_fee) }}) ក្នុង​មួយ​ខែ​ដោយ​កំណត់ 0.8 US$/m2 (សូន្យ​ក្បៀស​ប្រាំ​បី​ដុល្លា​អាមេរិក​ក្នុង​មួយ​ម៉ែត្រ​ការេ) ជា​បទ​ដ្ឋាន​គោល​នៃ​ការ​គណនា។ ផ្នែក​សេវាសាធារណៈ​មាន​ដូច​ជា​ជណ្តើរយន្ត អនាម័យ​ទី​កន្លែង​សាធារណៈ ភ្លើង​បំភ្លឺ​ផ្លូវ និង​សន្តិសុខ បូក​រួម​ក្លឹប​ហាត់​ប្រាណ (សមាជិក​2​នាក់) និង​អាង​ហែល​ទឹក រួម​ទាំង​ចំណត​ឡាន​ចត​ជា​សាធារណៈ ។ល។ ភាគី “ក” មាន​សិទ្ធិ​ក្នុង​ការ​កែ​ប្រែ​តម្លៃ​ខាង​លើ ទៅ​តាម​តម្លៃ​ទីផ្សារ ប្រសិន​បើ​មាន​ការ​កែ​ប្រែ​ភាគី “ក” នឹង​ជូន​ដំណឹង​ជា​សាធារណៈ​រយៈ​ពេល​មួយ​ខែ​ទុក​ជា​មុន។</p>

  <p><span class="text-bold"><u>ប្រការ១៣:</u></span> កិច្ច​ព្រម​ព្រៀង​នេះ​ត្រូវ​ធ្វើ​ឡើង​ដោយ​គ្មាន​ការ​គំរាម​កំហែង បង្ខិតបង្ខំ ឬ​មាន​បញ្ហា ខុសច្បាប់​ណា​មួយ​ឡើយ ហើយ​ត្រូវ​ចូល​ជា​ធរមាន​បន្ទាប់​ពី​ភាគី “ក” និង​ភាគី “ខ” បាន​ផ្តិត ស្នាម​មេ​ដៃ ឬ​ប្រថាប់​ត្រា។ កិច្ច​ព្រម​ព្រៀង​នេះ​ធ្វើ​ឡើង​ជា​ភាសា​ខ្មែរ ចំនួន​ពីរ​ច្បាប់ ក្នុង​នោះ​ភាគី “ក” រក្សា​ទុក​មួយ​ច្បាប់​ដើម ភាគី “ខ” រក្សា​ទុក​មួយ​ច្បាប់​ដើម។ ច្បាប់​នីមួយៗ​មាន​អានុភាព​គតិ​យុត្តិ​ស្មើ​គ្នា។</p>

  <p style="text-align: right;margin-top:30px;">រាជធានីភ្នំពេញ ថ្ងៃទី........ ខែ........ ឆ្នាំ២០........</p>

  <table style="text-align: center; width: 100%;page-break-after: always;">
    <tr>
      <td><p class="text-center">ភាគី “ក”</p></td>
      <td colspan="2"><p class="text-center">ភាគី “ខ”</p></td>     
    </tr>  
    <tr>
      <td height="250px"><h4>យីប ស៊ាងហុង</h4></td>    
      <td style="text-align: right; padding-right: 50px;">..........................................</td>
      <td style="text-align: left;">..........................................</td>        
    </tr>
  </table>

  @include('admin.contract.template.payment_template', ['contract' => $contract])
  
  <h4 class="main-title text-center">គម្រោង <span class="english-font text-bold">Sihanouk Cityview</span></h4>
  <h4 class="main-title text-center mb-4">ឧបសម្ព័ន្ធ៣ : សម្ភារៈដែលបំពាក់ក្នុងបន្ទប់ខុនដូ</h4> 
  <table class="v-align-top">
    <tr>
      <td><p>១. </p></td>
      <td><p>សម្ភារៈក្នុងផ្ទះបាយមាន ទូចង្ក្រាន១ឈុត ចង្ក្រាន១ ស៊ីងលាងចាន១ ម៉ាស៊ីនបឺតផ្សែង១</p></td>
    </tr>  
    <tr>
      <td><p>២. </p></td>
      <td><p>សម្ភារៈ​ក្នុង​បន្ទប់​គេង​មាន ទូ​សម្លៀក​បំពាក់១ ទូទូរទស្សន៍១ ម៉ាស៊ីនត្រជាក់១ (១.៥CC x ១គ្រឿង)។</p></td>
    </tr>
    <tr>
      <td><p>៣. </p></td>
      <td><p>សម្ភារៈក្នុងបន្ទប់ទឹកមាន បង្គន់១ ឡាបូ១ ផ្កាឈូកងូតទឹក១ ម៉ាស៊ីនទឹកក្តៅទឹកត្រជាក់១។</p></td>
    </tr>
  </table>
 
  <div style="page-break-after: always;"></div>
  <h4 class="main-title text-center mb-4">ឧបសម្ព័ន្ធ៤ : អត្តសញ្ញាណប័ណ្ណ អ្នកទិញ និង អ្នកលក់</h4>  
  
  <div class="container">
    <div class="row my-4">
      <div class="col">
        @if(array_key_exists('customer1_id_front',$attachment_array))  
        <img src="{{ $attachment_array['customer1_id_front']['path'] }}" class="img-fluid d-block">
        @endif
      </div>
      <div class="col">
        @if(array_key_exists('customer1_id_front',$attachment_array)) 
        <img src="{{ $attachment_array['customer1_id_back']['path'] }}" class="img-fluid d-block">
         @endif
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row my-4">
      <div class="col">
        @if(array_key_exists('customer2_id_front',$attachment_array)) 
        <img src="{{ $attachment_array['customer2_id_front']['path'] }}" class="img-fluid d-block">
        @endif
      </div>
      <div class="col">
        @if(array_key_exists('customer2_id_back',$attachment_array)) 
        <img src="{{ $attachment_array['customer2_id_back']['path'] }}" class="img-fluid d-block">
        @endif
      </div>
    </div>
  </div>
  @if(array_key_exists('customer1_passort',$attachment_array))
  <div class="container" style="page-break-after: always;">
    <div class="row my-4">
      <div class="col">
        <img src="{{ $attachment_array['customer1_passort']['path'] }}" class="img-fluid">
      </div>
    </div>
  </div>
  @endif
  @if(array_key_exists('customer2_passort',$attachment_array))
  <div class="container" style="page-break-after: always;>
    <div class="row my-4">
      <div class="col">
        <img src="{{ $attachment_array['customer2_passort']['path'] }}" class="img-fluid">
      </div>
    </div>
  </div>
  @endif
  
  
</html>