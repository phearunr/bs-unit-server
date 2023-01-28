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
    'house_width' => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->unit_house_width),
    'house_length' => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->unit_house_length),
    'total_area' => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->unit_total_area),
    'service_fee' => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->service_fee)
  ];
  
@endphp
<body>
  <h2 class="main-title text-center">ព្រះរាជាណាចក្រកម្ពុជា</h2>
  <h2 class="main-title text-center">ជាតិ សាសនា ព្រះមហាក្សត្រ</h2>
  <p class="text-center"><img src="{{ asset('img/kbach.png') }}"/></p>
  <h2 class="main-title text-center">កិច្ចសន្យាទិញ-លក់ <strong>Chaktomuk Cityview</strong></h2>

  <p class="text-center text-bold" style="margin-top:12pt;margin-bottom:12pt;">រវាង</p>

  <p class="first-indent"><span class="english-font text-bold">Chaktomuk Cityview</span> មានការិយាល័យកណ្តាលស្ថិតនៅអគារលេខ <span class="english-font text-bold">B2-109, B2-110</span> សង្កាត់ទន្លេបាសាក់ ខណ្ឌចំការមន រាជធានីភ្នំពេញ តំណាងដោយកញ្ញា <span class="text-bold">យីប ស៊ាងហុង</span> តំណាងផ្នែកលក់របស់ក្រុមហ៊ុន <span class="english-font text-bold">BS Land and Home Co., Ltd</span> កើត​ថ្ងៃទី១៤ ខែ០១ ឆ្នាំ១៩៩០ ជនជាតិខ្មែរ កាន់អត្តសញ្ញាណបណ្ណលេខ ០១០៦៤១៤៣៣ ចុះថ្ងៃទី ២៨ ខែ ១១ ឆ្នាំ ២០០៧ ជាអ្នកលក់តទៅ​ហៅ​ថា <span class="text-bold">“ភាគី ក”</span>។<br>
  លេខទូរសព្ទទំនាក់ទំនង ៖ <span class="english-font" >087 499995/ 011 488885</p>

  <p class="text-center text-bold">និង</p>

  <p class="first-indent mb-0">ឈ្មោះ <span class="text-bold">{{ $customer1['name'] }}</span> ភេទ <span class="text-bold">{{ $customer1['gender'] }}</span> កើតថ្ងៃទី <span class="text-bold">{{ $customer1['birth_day'] }}</span> ខែ <span class="text-bold">{{ $customer1['birth_month'] }}</span> ឆ្នាំ <span class="text-bold">{{ $customer1['birth_year'] }}</span> ជនជាតិខ្មែរ កាន់អត្តសញ្ញាណប័ណ្ណលេខ <span class="text-bold">{{ $customer1['nid_number'] }}</span> ចុះថ្ងៃទី <span class="text-bold">{{ $customer1['nid_issued_day'] }}</span> ខែ <span class="text-bold">{{ $customer1['nid_issued_month'] }}</span> ឆ្នាំ <span class="text-bold">{{ $customer1['nid_issued_year'] }}</span> 
  @if(isset($customer2))
  និង ឈ្មោះ <span class="text-bold">{{ $customer2['name'] }}</span> ភេទ <span class="text-bold">{{ $customer2['gender'] }}</span> កើតថ្ងៃទី <span class="text-bold">{{ $customer2['birth_day'] }}</span> ខែ <span class="text-bold">{{ $customer2['birth_month'] }}</span> ឆ្នាំ <span class="text-bold">{{ $customer2['birth_year'] }}</span> ជនជាតិខ្មែរ កាន់អត្តសញ្ញាណប័ណ្ណលេខ <span class="text-bold">{{ $customer2['nid_number'] }}</span> ចុះថ្ងៃទី <span class="text-bold">{{ $customer2['nid_issued_day'] }}</span> ខែ <span class="text-bold">{{ $customer2['nid_issued_month'] }}</span> ឆ្នាំ <span class="text-bold">{{ $customer2['nid_issued_year'] }}</span>
  @endif
  មានអស័យដ្ឋានផ្ទះលេខ <span class="text-bold">{{ $address['house_no'] }}</span> ផ្លូវលេខ <span class="text-bold">{{ $address['street'] }}</span> ភូមិ <span class="text-bold">{{ $address['phum'] }}</span> ឃុំ/សង្កាត់ <span class="text-bold">{{ $address['sangkat'] }}</span> ស្រុក/ខណ្ឌ <span class="text-bold">{{ $address['khan'] }}</span> រាជធានី/ខេត្ត <span class="text-bold">{{ $address['city'] }}</span> ជាអ្នកទិញ តទៅហៅថា <span class="text-bold">“ភាគី ខ”</span>។
  <br>
  ទូរសព្ទលេខទំនាក់ទំនង ៖ <span class="text-bold">{{ $phone_number }}</span>
  </p>

  <p><span class="text-bold">យោង ៖</span></p>

  <ul style="list-style: none; margin-bottom:0px;margin-top: 0px;page-break-after: always;">
    <li>ឧបសម្ព័ន្ធ១ : តារាងទូទាត់ប្រាក់</li>
    <li>ឧបសម្ព័ន្ធ២ : ប្លង់ទីតាំងក្នុងអគារខុនដូ</li>
    <li>ឧបសម្ព័ន្ធ៣ : សម្ភារៈដែលបូកបញ្ចូលក្នុងបន្ទប់ខុនដូ</li>
    <li>ឧបសម្ព័ន្ធ៤ :  អត្តសញ្ញាណប័ណ្ណ អ្នកទិញ និង អ្នកលក់</li>
  </ul>

  <p class="text-bold text-center"​ style="text-align: center !important;">ដោយផ្អែកលើគោលការណ៍ស្ម័គ្រចិត្ត និងស្មើភាព ភាគី “ក” និង ភាគី “ខ” បានព្រមព្រៀងគ្នាដូចតទៅ ៖</p>

  <p class="mb-0 text-bold"><u>ប្រការ១:</u> កម្មវត្ថុនៃការទិញ-លក់ និងតម្លៃ</p>

  <p>ភាគី “ក” យល់​ព្រម​លក់ ហើយ​ភាគី “ខ” យល់​ព្រម​ទិញ​បន្ទប់​ខុនដូ ប្រភេទ <strong>{{ $unit['type'] }}</strong> ទំហំសរុប <strong>{{$unit['total_area']}}</strong> ម៉ែត្រការ៉េ បន្ទប់​លេខ <strong>{{ $unit['house_no'] }}</strong> ជាន់ទី <strong>{{ $unit['floor'] }}</strong> ក្នុងអគារ <span class="english-font text-bold">Chaktomuk Cityview</span>  ដែល​មាន​ទី​តាំង​ស្ថិត​នៅ​ មហាវីថី 380 ខាង​ជើង​វត្ត​ស្វាយ​ជ្រុំ 1000ម៉ែត្រ ក្នុងតម្លៃ <span class="english-font">USD </span> {{ $unit['price'] }} ({{$unit['price_khmer_word']}})។ តម្លៃ​នេះ​ជា​តម្លៃ​ដែល​មាន​ការ​តុប​តែង​ដែល​មាន​បូក​បញ្ចូល​សម្ភារៈ​ប្រើ​ប្រាស់​ដូច​មាន​ក្នុង​ឧបសម្ព័ន្ធ៣។ ក្នុង​ករណី​រោង​ចក្រ​ឈប់​ផលិត​នូវ​ផលិត​ផល​ដែល​ក្រុមហ៊ុន​បាន​ជ្រើស​រើស​ ភាគី “ក” មាន​សិទ្ធិ​ក្នុង​ការ​ផ្លាស់​ប្តូរ​ដោយ​រក្សា​នូវ​គុណ​ភាព​ដដែល។</p>

  <p><span class="text-bold"><u>ប្រការ២:</u></span> ភាគី “ខ” យល់​ព្រម​ទទួល​យក​ទាំង​ស្រុង​នូវ​ប្លង់​រចនា​ម៉ូត​សំណង់ ព្រម​ទាំង​សន្យា​ថា មិន​កែ​ប្រែ​ទ្រង់​ទ្រាយ​ក្នុង និង​ក្រៅ​បន្ទប់​ដោយ​ខ្លួន​ឯង ឬ​ជួល​ក្រុមហ៊ុន​ដទៃ ឬ​បុគ្គល​ណា​ម្នាក់​មក​ធ្វើ​ការ​កែ​ប្រែ​បន្ទប់​នោះ​ទេ។ ប្រសិន​បើ​មាន​ការ​ចាំ​បាច់ ភាគី “ខ” ត្រូវ​ធ្វើ​ការ​ស្នើ​សុំ​ហើយ​បន្ទាប់​ពី​ទទួល​បាន​ការ​ឯក​ភាព​ពី​ភាគី “ក” ក្រុម​ហ៊ុន​តំណាង​ចាត់​ចែង​ត្រូវ​កំណត់​ដោយ​ភាគី​​ “ក”។</p>

  <p class="mb-0 text-bold"><u>ប្រការ​៣:</u> កាល​បរិច្ឆេទ​នៃ​ការ​ទូទាត់​ប្រាក់​</p>

  <p class="ml-5"><span class="text-bold">៣.១</span>​ ភាគី​ “ខ”​ ត្រូវ​ទូទាត់​ប្រាក់​សរុប​​ថ្លៃទិញ​ផ្ទះ​តាម​ដំណាក់​កាល​ជា​បន្ត​បន្ទាប់​ដូច​មាន​ចែង​ក្នុង​តារាង​ទូទាត់​ប្រាក់​ក្នុង​ កថាខណ្ឌ៣.1។​ ភាគី​ “ខ”​ អាច​មក​ទូទាត់​ប្រាក់​នៅក្រុមហ៊ុន​ផ្ទាល់​ ឬ​អាច​ទូទាត់​ប្រាក់​ចូល​ក្នុង​គណនី​របស់​ក្រុមហ៊ុន​ តាមរយៈ​ធនាគារភ្នំពេញពាណិជ្ជ  ដែល​មាន​គណនី​ឈ្មោះ ​<span class="english-font text-bold">Yip Seang Hong</span> លេខ​គណនី​ <span class="english-font text-bold">112010942732</span>។</p>

  <p class="ml-5"><span class="text-bold">៣.២</span>​ ក្នុង​ករណី​ដែល​ភាគី “ខ” យឺតយ៉ាវ ឬ​ខក​ខាន​មិន​បាន​បង់​ប្រាក់​តាម​កាល​កំណត់​ក្នុង កថាខណ្ឌ៣.១ នោះទេ ភាគី “ខ” ត្រូវ​បង់​ប្រាក់​ពិន័យ​ក្នុង​អត្រា 1.2% (មួយក្បៀសពីរភាគរយ) នៃ​ទឹក​ប្រាក់​ដែល​ត្រូវ​បង់​ក្នុង 1ខែ។ ករណី​ការ​យឺត​យ៉ាវ និង​ខក​ខាន​លើស​ពី 3 ខែនោះ ចាត់​ទុក ថា​ភាគី “ខ” បាន​បោះ​បង់​សិទ្ធិ​ជា​អ្នក​ទិញ​ក្នុង​ការ​បន្ត​កិច្ច​សន្យា​ទិញ-​​លក់​នេះ។</p>

  <p><span class="text-bold"><u>ប្រការ៤:</u></span> អំឡុង​ពេល​សាង​សង់​ភាគី “ខ” អាច​លក់ ឬ​ផ្ទេរ​កិច្ច​សន្យា​បាន​បន្ទាប់​ពី​ស្នើ​សុំ​ហើយ ទទួល​បាន​ឯកភាព​ជា​លាយ​លក្ខណ៍​អក្សរ​ពី​ភាគី “ក” ដោយ​ភាគី “ខ” ត្រូវ​បង់​ថ្លៃ​សេវា​រដ្ឋបាល ក្រុមហ៊ុន​ចំនួន USD 300 (បី​រយ​ដុល្លា​អាមេរិក) ជូនភាគី “ក” ។ ភាគី​ទី​បី​ដែល​ទទួល​យក​ការ​ផ្ទេរ កិច្ច​សន្យា​ភាគី “ខ” ត្រូវ​គោរព​តាម​ខ្លឹម​សារ​ទាំង​ស្រុង​នៃ​កិច្ច​ព្រម​ព្រៀង​នេះ។</p>

  <p><span class="text-bold"><u>ប្រការ៥:</u></span> ភាគី “ក” សន្យា​ថា​នៅ​ក្នុង​អំឡុង​ពេល 30 ខែ​បន្ទាប់​ពី​ថ្ងៃ​ចុះ​កិច្ច​សន្យា​នឹង​ប្រគល់​ បន្ទប់​លេខ {{ $unit['house_no'] }} ជាន់ទី {{ $unit['floor'] }} ជូន​ទៅ​ភាគី “ខ”។ ប្រសិន​បើ​ការ​សាង​សង់​បន្ទប់​ហើយ​មុន​កាល​កំណត់ ក្នុង​កិច្ចសន្យា ភាគី “ក” មាន​កាតព្វ​កិច្ច​ ជូន​ដំណឹង​ទៅ​ភាគី “ខ” ដើម្បី​មក​បំពេញ​បែប​បទ​ទទួល បន្ទប់ និង​ធ្វើ​លិខិត​ចូល​ស្នាក់​នៅ។ ប្រសិន​បើ​ភាគី “ក” យឺត​យ៉ាវ​ក្នុង​ការ​ប្រគល់​បន្ទប់​ជូន​ភាគី “ខ” ភាគី “ក” ត្រូវ​បង់​សំណង​ជូន​ភាគី “ខ” ជា​ទឹកប្រាក់ 1% ក្នុង​1​ខែ​នៃ​ទឹក​ប្រាក់​ដែល​បាន​បង់។</p>

  <p><span class="text-bold"><u>ប្រការ៦:</u></span> ភាគី “ក” មាន​កាតព្វកិច្ច​ក្នុង​ការ​ថែរ​ក្សា​នូវ​សុវត្ថិភាព សន្តិសុខ សណ្តាប់ធ្នាប់ សោភ័ណ្ឌភាព ទ្រព្យសម្បត្តិ​សាធារណៈ​ផ្សេងៗ​ក្នុង​អគារ​ខុនដូ។</p>

  <p><span class="text-bold"><u>ប្រការ៧:</u></span> បន្ទាប់​ពី​ភាគី “ក” និងភាគី “ខ” បាន​ទូទាត់​ប្រាក់​ថ្លៃ​ទិញ​-​លក់ និង​ធ្វើ​ការ​ផ្ទេរ​ការ​គ្រប់​​គ្រង​បន្ទប់​ខុន​ដូ​រួច​រាល់ ភាគី “ខ” សន្យា​ថា​នឹង​គោរព​យ៉ាង​ម៉ឺង​ម៉ាត់​តាម​បទ​បញ្ជា​ផ្ទៃ​ក្នុង​ដែល កំណត់​ដោយ​ភាគី “ក” មាន​ដូច​ជា សណ្តាប់ធ្នាប់ សុវត្ថិភាព សុខភាព អនាម័យ មិន​ចិញ្ចឹម​សត្វ (សត្វឆ្មា សត្វឆ្កែ សត្វបក្សី និងសត្វ​ផ្សេងៗ​ទៀត) មិន​ស្រែក​ឡូឡា​ខ្លាំងៗ មិន​បំពុល​បរិស្ថាន មិន​អនុញ្ញាត​ឲ្យ​នាំ​អាវុធ និង​គ្រឿង​ញៀន​ចូល មិន​អនុញ្ញាត​ឲ្យ​បើក​បន​ល្បែង​ បើក​ហាង​លក់ ទំនិញ ឬក្រុមហ៊ុន គឺសម្រាប់​តែ​ស្នាក់​នៅ​ប៉ុណ្ណោះ។</p>
  <p class="first-indent text-bold">ភាគី “ខ” សន្យា​យល់​ព្រម​គោរព​តាម​ការ​កំណត់​ជា​សាធារណៈ​របស់​ផ្នែក​គ្រប់​គ្រង​សេវាកម្ម</p>
  <ul>
    <li>ភាគី “ខ” ត្រូវទិញធានារ៉ាប់រងអគ្គីភ័យដោយខ្លួនឯង។</li>
    <li>ភាគី “ខ” មិន​ត្រូវ​កែ​ប្រែ​រចនា​សម្ព័ន្ធ​សំណង់ និង​សោភ័ណ្ឌភាព​នៃ​បន្ទប់​អគារ​ខាង​ក្រៅ។</li>
    <li>ភាគី “ខ” ត្រូវ​ទទួល​បន្ទុក​លើ​ថ្លៃ​ជួស​ជុល​ថែទាំ ក្រោយ​រយៈ​ពេល​ធា​នា​ជួស​ជុល​ថែទាំ។</li>
  </ul>

  <p><span class="text-bold"><u>ប្រការ៨:</u></span> ភាគី “ក” មាន​កាតព្វ​កិច្ច​ទទួល​ខុស​ត្រូវ​សហការ​ជា​មួយ​ភាគី “ខ” ពេល​ភាគី “ខ” បង់​ប្រាក់​ផ្ដាច់​គ្រប់ 100% ក្រុម​ហ៊ុន​និង​ផ្ទេរ​ប្លង់​រឹង​សហកម្មសិទ្ធិ ជូនភាគី “ខ” រាល់​ការ​ចំណាយ​ផ្សេងៗ​បូក​រួម​ទាំង​ពន្ធ​ផ្សេងៗ​ជា​បន្ទុក​ភាគី “ខ” ទាំងស្រុង។</p>

  <p><span class="text-bold"><u>ប្រការ៩:</u></span> ប្រសិន​បើ​ភាគី “ខ” ជួល​បន្ទប់​នេះ​ ភាគី “ខ” មាន​កាតព្វ​កិច្ច​ជូន​ដំណឹង​ដល់​ភាគី “ក” ទុក​ជា​មុន ហើយ​ត្រូវ​ធា​នា​ថា​ភាគី​ទីបី​គោរព​អនុវត្ត​តាម​ប្រការ ៧ និង ៨ ខាងលើ។</p>

  <p><span class="text-bold"><u>ប្រការ១០:</u></span> គិត​ចាប់​ពី​ថ្ងៃ​ដែល​ភាគី “ខ” ត្រូវ​ធ្វើ​លិខិត​ចូល​ស្នាក់​នៅ ភាគី “ក” ធ្វើ​ការ​ធា​នា​ចំពោះ សំណង់ និង​បរិក្ខា​ដូច​ខាង​ក្រោម៖</p>
  <ul>
    <li>អគារ​បាក់​ស្រុត: ភាគី “ក” ធា​នា​រយៈ​ពេល 15 (ដប់ប្រាំ) ឆ្នាំ ប៉ុន្តែ​ការ​ធានា​នេះ​គឺធានា ត្រឹម​ការ​បាក់​ស្រុត​ដែល​បណ្តាល​មក​ពី​គុណភាព​សំណង់​តែ​ប៉ុណ្ណោះ។</li>
    <li>ជញ្ជាំង​ប្រេះ បែក ប្រព័ន្ធ​ទឹក ប្រព័ន្ធ​អគ្គិសនី ប្រព័ន្ធ​លូ: ភាគី “ក” ធានា​រយៈ​ពេល​១​ឆ្នាំ ក្នុង​ការ​ជួស​ជុល។</li>
    <li>បរិក្ខា​អគ្គិសនី​ក្នុង​បន្ទប់ ត្រូវ​បាន​ធានា​ដោយ​យោង​ទៅ​តាម​លក្ខខណ្ឌ​ដែល​បាន​កំណត់ ដោយ​រោង​ចក្រ​ផលិត ឬ​អ្នកលក់។</li>
    <li>បរិក្ខា​អគ្គិសនី​ក្នុង​បន្ទប់ ត្រូវ​បាន​ធានា​ដោយ​យោង​ទៅ​តាម​លក្ខខណ្ឌ​ដែល​បាន​កំណត់ ដោយ​រោង​ចក្រ​ផលិត ឬ​អ្នកលក់។</li>
    <li>ការ​ខូច​ខាត​ដែល​បង្ក​ឡើង​ដោយ​ករណី​ប្រធាន​ស័ក្តិ សង្គ្រាម និង​គ្រោះ​ធម្មជាតិ​ផ្សេងៗ ព្រម​ទាំង​សកម្មភាព​បំពាន​ផ្សេងៗ មិន​រាប់​បញ្ចូល​ក្នុង​វិសាល​ភាព​នៃ​ការ​ធានា​ក្នុង​ប្រការ នេះឡើយ។</li>
  </ul>

  <p><span class="text-bold"><u>ប្រការ១១:</u></span> ភាគី “ខ” មាន​កាតព្វកិច្ច​បង់​ថ្លៃ​សេវាចំនួន USD {{ number_format($contract->service_fee,2) }} ({{ \App\Helpers\NumberFormat::covertUsdToKhmerWordFloat($contract->service_fee) }}) ក្នុង​មួយ​ខែ​ដោយ​កំណត់ 0.4US$/m2 (សូន្យ​ក្បៀស​បួន​ដុល្លា​អាមេរិក​ក្នុង​មួយ​ម៉ែត្រ​ការេ) ជា​បទ​ដ្ឋាន​គោល​នៃ​ការ​គណនា។ ផ្នែក​សេវា​មាន​ដូចជា ជណ្តើរយន្ត អនាម័យ​ទី​កន្លែង​សាធារណៈ ភ្លើងបំភ្លឺផ្លូវ និងសន្តិសុខ។ល។ ភាគី “ក” មាន​សិទ្ធិ​ក្នុង​ការ​កែប្រែ​តម្លៃ​ខាង​លើ​ទៅ​តាម​តម្លៃ​ទីផ្សារ ប្រសិន​បើ​មាន​ការ​កែ​ប្រែ​ភាគី “ក” នឹង​ជូន​ដំណឹង​ជា សាធារណៈរយៈ ពេល​១​ខែទុក​ជា​មុន។</p>

  <p><span class="text-bold"><u>ប្រការ១២:</u></span> កិច្ច​ព្រមព្រៀង​នេះ​ត្រូវ​ធ្វើ​ឡើង​ដោយ​គ្មាន​ការ​គំរាម​កំហែង បង្ខិតបង្ខំ ឬមាន​បញ្ហា​ខុស​​ច្បាប់​ណា​មួយ​ឡើយ ហើយ​ត្រូវ​ចូល​ជា​ធរមាន​បន្ទាប់​ពី​ភាគី “ក” និងភាគី “ខ” បានផ្តិត ស្នាមមេដៃ ឬប្រថាប់ត្រា។ កិច្ច​ព្រមព្រៀង​នេះ​ធ្វើ​ឡើង​ជា​ភាសាខ្មែរ ចំនួន2ច្បាប់ ក្នុងនោះភាគី “ក” រក្សាទុក 1ច្បាប់ដើម ភាគី “ខ” រក្សាទុក 1ច្បាប់ដើម។ ច្បាប់​នីមួយៗ មាន​អានុភាព​គតិយុត្តិ​ស្មើ​គ្នា។</p>

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
  
  <h4 class="main-title text-center mb-4">ឧបសម្ព័ន្ធ៣ : សម្ភារៈដែលបូកបញ្ចូលក្នុងបន្ទប់ខុនដូ</h4>
  <p>១. សម្ភារៈ​ក្នុង​ផ្ទះ​បាយ​មាន ទូ​ចង្ក្រាន​១ឈុត ចង្ក្រាន១ ស៊ីងលាងចាន១ ម៉ាស៊ីន​បឺត​ផ្សែង១ ម៉ាស៊ីន​ចម្រោះ​ទឹក​១ (ផលិត​ផល​របស់​អាមេរិក)​។</p>
  <p>២. សម្ភារៈក្នុងបន្ទប់គេងមាន ទូសម្លៀកបំពាក់១ ទូទូរទស្សន៍១ ម៉ាស៊ីនត្រជាក់១។</p>  
  <p>៣. សម្ភារៈក្នុងបន្ទប់ទឹកមាន បង្គន់១ ឡាបូ១ ផ្កាឈូកងូតទឹក១ ម៉ាស៊ីនទឹកក្តៅទឹកត្រជាក់១។</p>  
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