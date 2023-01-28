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
      <img src="{{ asset('img/logo/essc-logo.png') }}" width="150px">
      <p class="text-sm m-0 p-0" style="line-height: 12px">គំរោងលំនៅដ្ឋាន <span class="english-font text-bold text-sm" style="line-height: 12px">East Land & Home</span></p>
      <p class="text-sm m-0 p-0">ដីឡូតិ៍ប្រភេទ {{ $unit['type'] }}-{{ $unit['house_no'] }}</p>
    </div>
    <div class="col-auto">
      <h2 class="mb-3 main-title text-center">ព្រះរាជាណាចក្រកម្ពុជា</h2>
      <h2 class="main-title text-center">ជាតិ សាសនា ព្រះមហាក្សត្រ</h2>
    </div>
  </div>
  <h2 class="main-title text-center mb-4">កិច្ចសន្យាទិញ-លក់</h2>
  <h2 class="main-title text-center mb-4">ដីឡូតិ៍លំនៅដ្ឋាន <span class="english-font text-bold text-lg" style="font-size:22pt;">East Land & Home</span></h2>
  <h4 class="text-center">រវាង</h4>
  <p class="first-indent">គំរោង​ដី​ឡូតិ៍​លំនៅ​ដ្ឋាន <span class="english-font text-bold">East Land & Home</span> កា​រិ​យា​ល័យ​អគារ​ក្រុម​ហ៊ុន​អគារ​លេខ <span class="english-font text-bold">B2-109, B2-110</span> សង្កាត់​-​ទន្លេ​បាសាក់ ខណ្ឌ​-​ចំការមន រាជ​ធានី​-​ភ្នំពេញ នៃ​ក្រុម​ហ៊ុន​ <span class="english-font text-bold">BS Land & Home Co.,Ltd</span> តំណាង​ស្រប​ច្បាប់​ចុះ​កិច្ច​សន្យា​ទិញ​-​លក់​ដោយ​ឈ្មោះ <span class="moul-font">ប៉ែន  ស្រីរ័ត្ន</span> ភេទ​ស្រី កើត​នៅ​ថ្ងៃទី​២៨ ខែធ្នូ ឆ្នាំ១០៨៣ ជន​ជាតិ​ខ្មែរ​កាន់​អត្ត​សញ្ញាណ​ប័ណ្ណ​លេខ 010216130(01) ចុះ​ថ្ងៃ​ទី២០ ខែតុលា ឆ្នាំ២០១៧ អាស័យ​ដ្ឋាន​បច្ចុប្បន្ន​ផ្ទះ​លេខ-16 ផ្លូវ-K4B ភូមិ-ទឹកថ្លា សង្កាត់-ទឹកថ្លា ខណ្ឌ-សែនសុខ ខេត្ត-ក្រុង ភ្នំពេញ។ ចាប់​​ពី​ថ្ងៃ​ផ្តិត​មេ​ដៃ​ចុះ​កិច្ច​សន្យា​នេះ​ត​ទៅ​ហៅ​កាត់​ថា​ភាគី (ក) អ្នក​លក់។<br>
  លេខ​ទូរស័ព្ទ​ក្រុមហ៊ុន 012-855-821 / 015-855-821 / 078-224-124 / 097-209-647-8 / 088-5-855-821 / 087-855-821
  </p>

  <h4 class="text-center">និង</h4>

  <p class="first-indent mb-0">ឈ្មោះ <span class="text-bold">{{ $customer1['name'] }}</span> ភេទ <span class="text-bold">{{ $customer1['gender'] }}</span> កើតថ្ងៃទី <span class="text-bold">{{ $customer1['birth_day'] }}</span> ខែ <span class="text-bold">{{ $customer1['birth_month'] }}</span> ឆ្នាំ <span class="text-bold">{{ $customer1['birth_year'] }}</span> ជនជាតិខ្មែរ កាន់​អត្តសញ្ញាណប័ណ្ណលេខ <span class="text-bold">{{ $customer1['nid_number'] }}</span> ចុះថ្ងៃទី <span class="text-bold">{{ $customer1['nid_issued_day'] }}</span> ខែ <span class="text-bold">{{ $customer1['nid_issued_month'] }}</span> ឆ្នាំ <span class="text-bold">{{ $customer1['nid_issued_year'] }}</span> 
  @if(isset($customer2))
  និង ឈ្មោះ <span class="text-bold">{{ $customer2['name'] }}</span> ភេទ <span class="text-bold">{{ $customer2['gender'] }}</span> កើតថ្ងៃទី <span class="text-bold">{{ $customer2['birth_day'] }}</span> ខែ <span class="text-bold">{{ $customer2['birth_month'] }}</span> ឆ្នាំ <span class="text-bold">{{ $customer2['birth_year'] }}</span> ជនជាតិខ្មែរ កាន់​អត្តសញ្ញាណប័ណ្ណលេខ <span class="text-bold">{{ $customer2['nid_number'] }}</span> ចុះថ្ងៃទី <span class="text-bold">{{ $customer2['nid_issued_day'] }}</span> ខែ <span class="text-bold">{{ $customer2['nid_issued_month'] }}</span> ឆ្នាំ <span class="text-bold">{{ $customer2['nid_issued_year'] }}</span>
  @endif
  មាន​អស័យ​ដ្ឋាន​ផ្ទះ​លេខ <span class="text-bold">{{ $address['house_no'] }}</span> ផ្លូវលេខ <span class="text-bold">{{ $address['street'] }}</span> ភូមិ <span class="text-bold">{{ $address['phum'] }}</span> ឃុំ/សង្កាត់ <span class="text-bold">{{ $address['sangkat'] }}</span> ស្រុក/ខណ្ឌ <span class="text-bold">{{ $address['khan'] }}</span> រាជធានី/ខេត្ត <span class="text-bold">{{ $address['city'] }}</span> ជាអ្នកទិញ តទៅហៅថា <span class="text-bold">“ភាគី ខ”</span>។
  <br>
  ទូរសព្ទលេខទំនាក់ទំនង ៖ <span class="text-bold">{{ $phone_number }}</span>
  </p>
  @if(isset($customer2))
  <div style="page-break-after: always;"></div>
  @endif

  <p class="m-0 p-0 text-center"><span class="text-bold">យោង ៖</span></p>
  <ul class="ml-0 pl-0" style="{{ isset($customer2) ? '' : 'page-break-after: always;' }}">
    <li>ឧបសម្ព័ន្ធ១ : តារាងទូទាត់ប្រាក់។</li>
    <li>ឧបសម្ព័ន្ធ២ : ប្លង់ទីតាំងដីឡូតិ៍។</li>  
    <li>ឧបសម្ព័ន្ធ៣ : អត្តសញ្ញាណប័ណ្ណ អ្នកទិញ និង អ្នកលក់។</li>
    <li>ឧបសម្ព័ន្ធ៤ : លិខិតប្រគល់សិទ្ធឈរតំណាងក្រុមហ៊ុន។</li>
  </ul>

  <p class="text-bold text-center"​ style="text-align: center !important;">ដោយផ្អែកលើគោលការណ៍ស្ម័គ្រចិត្ត និងស្មើភាព ភាគី “ក” និង ភាគី “ខ” បានព្រមព្រៀងគ្នាដូចតទៅ ៖</p>

  <p class="mb-0 text-bold"><u>ប្រការ១: កម្មវត្ថុនៃការទិញ-លក់ និងតម្លៃ</u></p>
  <p>ភាគី (ខ) បាន​យល់​ព្រម​ទិញ​ដី​ឡូតិ៍​ប្រភេទ {{ $unit['type'] }} ឡូតិ៍លេខ {{ $unit['house_no'] }} ចំនួន01ឡូតិ៍</p>
  <ul>
    <li>ទំហំទទឹង <span class="text-bold">{{ $unit['land_width'] }}</span> ម៉ែត្រ។</li>
    <li>ទំហំបណ្ដោយ <span class="text-bold">{{ $unit['land_length'] }}</span> ម៉ែត្រ។</li>
  </ul> 
  <p>លក់​ក្នុង​តម្លៃ USD {{ $unit['price'] }} ({{ $unit['price_khmer_word'] }}) ក្នុង​មួយ​ឡូតិ៍។ ភាគី (ខ) យល់​ព្រម​ធ្វើ​ការ​ទូ​ទាត់​ប្រាក់​ជូន​ភាគី (ក) តាម​តារាង​ទូ​ទាត់​ប្រាក់​ដែល​ភាគី (ក) ភ្ជាប់​ជា​មួយ​កិច្ច​សន្យា​នៃ​ឧបសម្ព័ន្ធ១។</p>
  <p>រាល់ប្រាក់ដែលភាគី(ខ)បានបង់រួចគឺមិនអាចដកវិញបានឡើយ។</p>

  <p class="mb-0"><span class="text-bold"><u>ប្រការ២:</u></span></p>
  <p>ទី​តាំង​ដី​ឡូតិ៍​ដែល​ភាគី​ (ខ) ទិញ​ស្ថិត​នៅ ភូមិ-ដូនហែម  ឃុំ- ព្រែកអំពិល ស្រុក-ខ្សាច់កណ្តាល  ខេត្ត-កណ្តាល។</p>

  <p class="mb-0"><span class="text-bold"><u>ប្រការ៣:</u></span> ការផ្ទេរសិទ្ធិ និងការទទួលខុសត្រូវ ៖</p>
  <p>ពេលវេលាបង់ប្រាក់រៀងរាល់ថ្ងៃធ្វើការដូចខាងក្រោម:</p>
  <ul>
    <li>ពីថ្ងៃច័ន្ទ ដល់  ថ្ងៃអាទិត្យ</li>
    <li>ពេលព្រឹកម៉ោង 8.00 ព្រឹក ដល់ ម៉ោង 5.00 ល្ងាច</li>
    <li>ករណី​ពេល​វេលា​បង់​ប្រាក់​របស់​ភាគី (ខ) ចំ​ថ្ងៃ​បុណ្យ​ជាតិ​ធំៗ​ ភាគី (ក) នឹង​លើក​ថ្ងៃ​ត្រូវ​បង់​ប្រាក់​របស់​ភាគី (ខ) បន្ទាប់​នៅ​ថ្ងៃ​ចូល​ធ្វើ​ការ​វិញ។</li>
    <li>ទី​កន្លែង​បង់​ប្រាក់​ស្ថិត​នៅ​អគារ​លេខ B2-109, B2-110 សង្កាត់-ទន្លេបាសាក់ ខណ្ឌ-ចំការមន រាជធានី-ភ្នំពេញ។</li>
    <li>ទំនាក់ទំនងទូរស័ព្ទ 012-855-821 / 015-855-821 / 078-224-124  / 097-209-647-8  088-5-855-821 / 087-855-821</li>
  </ul>

  <p class="mb-0"><span class="text-bold"><u>ប្រការ៤:</u></span></p>
  <ul>
    <li>ភាគី (ខ) មាន​សិទ្ធិ​លក់​បន្ត​ទៅ​អោយ​ជន​ទី​៣​ដោយ​ត្រូវ​បង់​សេវា​រដ្ឋបាល 100$ ក្នុង​ការ​ផ្ទេរ​កិច្ច​សន្យា​បន្ត។</li>
    <li>ភាគី (ខ) មាន​សិទ្ធិ​ដាក់​បញ្ចាំ​ដី​ឡូត៌​បាន​គ្រប់​ពេល​វេលា​បន្ទាប់​ពី​ភាគី​ (ខ) បាន​បង់​ប្រាក់​គ្រប់​ចំនួន ១០០% (មួយ​រយ​ភាគ​រយ) ជូន​ដល់​ភាគី (ក)​ រួចរាល់។</li>
    <li>ភាគី (ក) សន្យា​នឹង​ធ្វើ​ការ​ផ្ទេរ​សិទ្ធិ​កាន់​កាប់​ជូន ភាគី (ខ) នៅ​ពេល​ណា​ដែល​ភាគី (ខ) បង់​ប្រាក់​គ្រប់​ចំនួន ១០០% (មួយ​រយ​ភាគ​រយ) នៃ​តម្លៃ​ដី​ហើយ​រាល់​ការ​ចំណាយ​ផ្ទេរ​កម្ម​សិទ្ធិ​កាន់​កាប់ (ប្លង់ទន់) ត្រឹម​ស្រុក​ជា​បន្ទុក​របស់​ភាគី (ក) ទាំង​ស្រុង។</li>
    <li>ដី​ឡូត៌​នេះ​ភាគី (ខ) អាច​ធ្វើ​ប័ណ្ណ​កម្ម​សិទ្ធិ (ប្លង់រឹងបាន100%) រាល់​ការ​ចំណាយ​សេវា​ជា​បន្ទុក​របស់​ភាគី (ខ) ទាំងស្រុង។</li>
    <li>ករណី​ថ្ងៃ​ក្រោយ​រដ្ឋ​តំរូវ​អោយ​បង់​ពន្ធ​រាល់​ការ​ចំណាយ​ជា​បន្ទុក​ភាគី (ខ) ទាំងស្រុង។</li>    
  </ul>

  <p class="mb-0"><span class="text-bold"><u>ប្រការ៥:</u></span> ភាគី (ក) សន្យាធ្វើការអភិវឌ្ឍន៍ដូចខាងក្រោម៖</p>
  <ul>
    <li>ផ្លូវបេតុងទំហំ ????? ម៉ែត្រក្នុងគំរោងដីឡូតិ៍ក្រុមហ៊ុន</li>
    <li>ប្រព័ន្ធលូក្នុងគំរោងដីឡូតិ៍ក្រុមហ៊ុន</li>
    <li>ប្រព័ន្ធទឹកស្អាតក្នុងគំរោងដីឡូតិ៍ក្រុមហ៊ុន</li>
    <li>បង្គោល​ភ្លើង​អគ្គិសនី និង​ចាក់​ដី​បំពេញ​មិន​អោយ​លិច​ទឹក (ក្នុង​គំរោង​ប្លង់​ក្រុមហ៊ុន​)</li>
  </ul>

  <p class="mb-0"><span class="text-bold"><u>ប្រការ៦:</u></span></p>
  <p>ភាគី (ខ) យល់​ព្រម​បង់​ថ្លៃ អនាម័យ សណ្ដាប់ធ្នាប់ សន្តិសុខ សោភ័ណ្ឌភាព ភ្លើង​បំភ្លឺ​សាធារណៈ​ និង​ការ​ខូច​ខាត​ជួស​ជុល​ផ្លូវ​មក​ក្រុមហ៊ុន <span class="english-font text-bold">East Land & Home</span> ជា​រៀង​រាល់​ខែ​នៅ​ពេល​ដែល​ភាគី (ខ) ចាប់​ផ្ដើម​សាង​សង់​សំណង់​រស់​នៅ​ឬ​ស្នាក់​អាស្រ័យ​ និង​ប្រកប​ជា​អា​ជី​វ​កម្ម​ផ្សេង​ៗ។ ក្នុង​ករណី​ត​ភ្ជាប់​ប្រព័ន្ធ​ទឹក​ និង​ភ្លើង​ចូល​ទៅ​ក្នុង​គេហ​ដ្ឋាន​របស់​ខ្លួន​សោ​ហ៊ុយ​ចំណាយ​ទាំង​ស្រុង​ជា​បន្ទុក​របស់​ភាគី(ខ)។</p>
    
  <p class="mb-0"><span class="text-bold"><u>ប្រការ៧:</u></span></p>
  <p>ភាគី (ក) សន្យា​ក្នុង​ករណី​បើ​ថ្ងៃ​ក្រោយ​មាន​ជន​ណា​ផ្សេង​មក​ទាម​ទារ ​ឬ​ តវ៉ា​ដី​ខាង​លើ​មិន​មែន​ជា​ដី​របស់​ក្រុមហ៊ុន​ រឺ​មិន​ស្រប​ច្បាប់​ភាគី (ក)​ សុខ​ចិត្ត​ទទួល​ខុស​ត្រូវ​ដោះ​ស្រាយ​ទាំង​ស្រុង​ចំពោះ​មុខ​ច្បាប់​ហើយ​រាល់​ការ​ចំណាយ​បញ្ហា​ជា​បន្ទុក​របស់​ភាគី (ក) ទាំង​ស្រុង។</p>

  <p class="mb-0"><span class="text-bold"><u>ប្រការ៨</u></span> ភាគី (ខ)យល់ព្រមឯកភាពតាមប្លង់នីមួយៗដែលមានដូចខាងក្រោម៖</p>
  <p>ភាគី (ក) សន្យា​ក្នុង​ករណី​បើ​ថ្ងៃ​ក្រោយ​មាន​ជន​ណា​ផ្សេង​មក​ទាម​ទារ ​ឬ​ តវ៉ា​ដី​ខាង​លើ​មិន​មែន​ជា​ដី​របស់​ក្រុមហ៊ុន​ រឺ​មិន​ស្រប​ច្បាប់​ភាគី (ក)​ សុខ​ចិត្ត​ទទួល​ខុស​ត្រូវ​ដោះ​ស្រាយ​ទាំង​ស្រុង​ចំពោះ​មុខ​ច្បាប់​ហើយ​រាល់​ការ​ចំណាយ​បញ្ហា​ជា​បន្ទុក​របស់​ភាគី (ក) ទាំង​ស្រុង។</p>

  <p class="mb-0"><span class="text-bold"><u>ប្រការ៩:</u></span> ភាគី (ខ)យល់ព្រមឯកភាពតាមប្លង់នីមួយៗដែលមានដូចខាងក្រោម៖</p>
  <p>ប្រភេទ​ដីឡូតិ៍​ប្លង់ {{ $unit['type'] }} ភាគី (ខ) យល់​ព្រម​ទុក​ដី​ខាង​មុខ​ផ្ទះ​ចំនួន​4​ម៉ែត្រ​ទើប​ភាគី (ខ) អាច​ធ្វើ​ការ​សាង​សង់​លំនៅ​ដ្ឋាន ឬ សង់​សំណង់​ផ្សេងៗ​បាន។</p>

  <p class="mb-0"><span class="text-bold"><u>ប្រការ១០:</u></span> ក្នុង​ករណី​ភាគី​(ខ)​បង់​ប្រាក់​យឺត​យ៉ាវ​មិន​ទៅ​តាម​តារាង​ទូ​ទាត់​ប្រាក់​ដែរ​ភ្ជាប់​ជា​មួយ​កិច្ច​សន្យា​។</p>
  <ul>
    <li>ចាប់​ពី​ក្នុង​ចន្លោះ​ពី​១​ថ្ងៃ​ដល់​៥​ថ្ងៃ​ភាគី​(ខ)​ត្រូវ​បង់​ប្រាក់​ពិន័យ​ចំនួន​២$​ក្នុង​មួយ​ថ្ងៃ​ជូន​ភាគី​(ក)</li>
    <li>ចាប់​ពី​ក្នុង​ចន្លោះ​ពី​៦​ថ្ងៃ​ដល់​១៥​ថ្ងៃ​ភាគី​(ខ)​ត្រូវ​បង់​ប្រាក់​ពិន័យ​ចំនួន​៥$​ក្នុង​មួយ​ថ្ងៃ​ជូន​ភាគី​(ក) </li>
    <li>ចាប់​ពី​​ក្នុង​​ចន្លោះ​ពី ៣០ថ្ងៃ​ឡើង​ទៅ​គឺ​មាន​ន័យ​ថា​ភាគី​(ខ)​យល់​ព្រម​បោះ​បង់​ចោល​កិច្ច​សន្យា​ទិញ​លក់​ជា​ឯក​តោ​ភាគី​ហើយ​ទឹក​ប្រាក់​ដែល​បាន​បង់​ជូន​ភាគី​(ក)​កន្លង​មក​ត្រូវ​បាន​ចាត់​ទុក​ជា​អាសារ​បង់​និង​មិន​អាច​រុះរើ​សំណង់​ដែល​សាង​សង់
លើ​ទី​តាំង​ដី​ឡូតិ៍​នេះ​បាន​ឡើយ​ ហើយ​ទី​តាំង​ដី​និង​សំណង់​នៅ​​តែ​ជា​កម្ម​សិទ្ធិ​ស្រប​ច្បាប់​របស់​ភាគី​(ក)​ដដែល​ហើយ​ភាគី​(ក)​ក៏​អាច​មាន​សិទ្ធិ​លក់​បន្ត​ទៅ​ភាគី​ផ្សេង​ទៀត​បាន​ដែរ។</li>
  </ul>

  <p class="mb-0"><span class="text-bold"><u>ប្រការ១១:</u></span></p>
  <p>ភាគី​ទាំង​ពីរ​សន្យាថា​នឹង​គោរព​តាម​កិច្ច​សន្យា​នេះ​ទាំង​ស្រុង​ហើយ​ក្នុង​ករណីដែល​មាន​វិវាទ​អ្វី​មួយ​កើត​ឡើង​ខុស​ពី​កិច្ច​សន្យា​នេះ​គឺ​ភាគី​ទាំង​ពីរ​ត្រូវ​ធ្វើ​ការ​ដោះ​ស្រាយ​ដំបូង​ដោយ​ពិភាក្សា​គ្នា​ឬ​ការ​ចរ​ចា​ដោយ​សន្តិ​វិធី​រវាង​គ្នា​ទៅ​វិញ​ទៅ​មក។ ក្នុង​ករណី​ដោះ​ស្រាយ​បែប​នេះ​បរា​ជ័យ​ភាគី​នីមួយៗ​អាច​បញ្ជូន​វិវាទ​នេះ​ទៅ​តុលា​ការ​មាន​សមត្ថ​កិច្ច​ នៃ​ប្រទេស​កម្ពុជា​ ដើម្បី​ដោះ​ស្រាយ​អោយ​ស្រប​ច្បាប់​នៃ​ព្រះ​រាជា​ណា​ចក្រ​កម្ពុជា។</p>
  <p>កិច្ច​សន្យា​នេះ ធ្វើ​ឡើង​ដោយ​ការ​ព្រម​ព្រៀង​គ្នា​រវាង​ភាគី​ (ក) និង​ភាគី​​ (ខ) ហើយ​គ្មាន​ការ​បង្ខិត​បង្ខំ ណា​មួយ​ឡើយ​កិច្ច​សន្យា​នេះ​មាន​ប្រសិទ្ធ​ភាព​ចាប់​ពី​កាល​បរិច្ឆេទ​ និង​ចុះ​ហត្ថ​លេខា​ ឬ​ផ្ដិត​មេ​ដៃ​ស្ដាំ​នេះ​តទៅ។ </p>

  <p style="text-align: right;margin-top:30px;">រាជធានីភ្នំពេញ ថ្ងៃទី........ ខែ........ ឆ្នាំ២០........</p>

  <table style="text-align: center; width: 100%;">
    <tr>
      <td><p class="text-center mb-0">ស្នាមមេដៃស្ដាំ ភាគី(ក)</p></td>
      <td colspan="2"><p class="text-center mb-0">ស្នាំមេដៃស្ដាំ សាក្សីដឹងឮ</p></td>
      <td><p class="text-center mb-0">ស្នាមមេដៃស្ដាំ ភាគី(ខ)</p></td>
    </tr>
    <tr>
      <td><p class="text-center">ភាគីអ្នកលក់</p></td>
      <td><p class="text-center">ភាគីអ្នកលក់</p></td>
      <td><p class="text-center">ភាគីអ្នកទិញ</p></td>
      <td><p class="text-center">ភាគីអ្នកទិញ</p></td>
    </tr>
    <tr style="vertical-align:bottom;">
      <td height="120px"><h4>ប៉ែន ស្រីរ័ត្ន</h4></td>
      <td>...........................</td>
      <td>...........................</td>
      <td>...........................</td>        
    </tr>
  </table>

  <p class="moul-font text-bold">ចម្លងជូនៈ</p>
  <p class="mb-0" style="text-align: left;">- <span class="moul-font">ភាគី(ក)</span> អ្នកលក់ រក្សាច្បាប់ដើមទុកចំនួន០១ច្បាប់</p>
  <p class="mb-0" style="text-align: left;">- <span class="moul-font">ភាគី(ខ)</span> អ្នកទិញ រក្សាច្បាប់ដើមទុកចំនួន០១ច្បាប់</p>
  <div style="page-break-after: always;"></div>
  
  @include('admin.contract.template.payment_template', ['contract' => $contract])

  <h4 class="main-title text-center mb-4">ឧបសម្ព័ន្ធ៣ : អត្តសញ្ញាណប័ណ្ណ អ្នកទិញ និង អ្នកលក់</h4>  
  
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