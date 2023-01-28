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
      <p class="text-sm m-0 p-0" style="line-height: 12px">គម្រោង <span class="english-font text-bold text-sm" style="line-height: 12px">East Sen Sok Condominium</span></p>
      <p class="text-sm m-0 p-0">ខុនដូ  បន្ទប់លេខ : <span class="text-bold">{{ $contract->unit_code }}</span></p>
    </div>
    <div class="col-auto">
      <h2 class="mb-3 main-title text-center">ព្រះរាជាណាចក្រកម្ពុជា</h2>
      <h2 class="main-title text-center">ជាតិ សាសនា ព្រះមហាក្សត្រ</h2>
    </div>
  </div>
  <h2 class="main-title text-center mb-4">កិច្ចសន្យាទិញ-លក់</h2>
  <h2 class="main-title text-center mb-4">គម្រោង <span class="english-font text-bold" style="font-size:22pt;">East Sen Sok Condominium</span></h2>
  <h4 class="text-center">រវាង</h4>
  <p class="first-indent">គំម្រោង <span class="english-font text-bold">East Sen Sok Condominium &nbsp;</span> មាន​ការិយាល័យ​កណ្តាលស្ថិត​នៅ​អគារ​លេខ <span class="english-font text-bold">B2-109, B2-110</span> សង្កាត់-ទន្លេបាសាក់ ខណ្ឌ-ចំការមន រាជធានី-ភ្នំពេញ នៃក្រុមហ៊ុន <span class="english-font text-bold">BS Land & Home Co.,Ltd</span> តំណាងស្របច្បាប់ចុះកិច្ចសន្យាទិញ-លក់ដោយឈ្មោះ <span class="text-bold"> ប៉ែន  ស្រីរ័ត្ន </span> ភេទស្រី កើតនៅថ្ងៃទី២៨ ខែធ្នូ ឆ្នាំ១៩៨៣ ជន​ជាតិ​ខ្មែរ​កាន់​អត្ត​សញ្ញាណ​ប័ណ្ណ​លេខ ០១០២១៦១៣០ (០១) ចុះថ្ងៃទី២០ ខែតុលា ឆ្នាំ២០១៧ អាស័យ​ដ្ឋាន​បច្ចុប្បន្ន​ផ្ទះ​លេខ-16 ផ្លូវ-K4B ភូមិ-ទឹកថ្លា ឃុំ-សង្កាត់-ទឹកថ្លា ខណ្ឌ-សែនសុខ ខេត្ត-ក្រុងភ្នំពេញ។ ចាប់​ពី​ថ្ងៃ​ផ្តិត​មេដៃ​ចុះ​កិច្ច​សន្យា​នេះ​ត​ទៅ​ហៅ​កាត់​ថា​ភាគី (ក) អ្នកលក់។<br>
  លេខទូរសព្ទទំនាក់ទំនង ៖ <span class="english-font" >012-855-821/ 015-855-821/ 078-224-124/ 097-209-6478 / 088-5-855-821 / 087-855-821</p>

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
    <li>ឧបសម្ព័ន្ធ១ : តារាងទូទាត់ប្រាក់</li>
    <li>ឧបសម្ព័ន្ធ២ : ប្លង់ទីតាំងក្នុង​អគារ​ខុនដូ <span class="english-font text-bold">East Sen Sok Condominium</span></li>
    <li>ឧបសម្ព័ន្ធ៣ : សម្ភារៈ​ដែល​បូក​បញ្ចូល​ក្នុង​បន្ទប់​ខុនដូ​ <span class="english-font text-bold">East Sen Sok Condominium</span></li>
    <li>ឧបសម្ព័ន្ធ៤ :  អត្តសញ្ញាណប័ណ្ណ អ្នកទិញ និង អ្នកលក់</li>
  </ul>

  <p class="text-bold text-center"​ style="text-align: center !important;">ដោយផ្អែកលើគោលការណ៍ស្ម័គ្រចិត្ត និងស្មើភាព ភាគី “ក” និង ភាគី “ខ” បានព្រមព្រៀងគ្នាដូចតទៅ ៖</p>

  <p class="mb-0 text-bold"><u>ប្រការ១: កម្មវត្ថុនៃការទិញ-លក់ និងតម្លៃ</u></p>
  <p>ភាគី “ក” យល់​ព្រម​លក់​ហើយ​ភាគី​ “ខ” យល់​ព្រម​ទិញ​បន្ទប់​ខុន​ដូ​ប្រភេទ <span class="text-bold">{{ $unit['type'] }}</span> ទំហំសរុប <span class="text-bold">{{ $unit['total_area'] }}</span> ម៉ែត្រការ៉េ (ទទឹង <span class="text-bod">{{ $unit['house_width'] }}</span> ម៉ែត្រ និងបណ្ដោយ <span class="text-bod">{{ $unit['house_length'] }} ម៉ែត្រ) បន្ទប់លេខ <span class="text-bod">{{ $unit['house_no'] }} ជាន់ទី <strong>{{ $unit['floor'] }}</strong> ក្នុង​អគារ <span class="english-font text-bold">East Sen Sok Condominium</span> ដែល​មាន​ទី​តាំង​ស្ថិត​នៅ​ ​ភូមិ-ឧកញ៉ាវាំង សង្កាត់-ភ្នំពេញថ្មី  ខណ្ឌ-សែនសុខ រាជធានី-ភ្នំពេញ។ លក់​ក្នុង​តម្លៃ​ពេញ <span class="english-font">USD </span> {{ $unit['price'] }} ({{$unit['price_khmer_word']}})។ តម្លៃ​​នេះ​ជា​តម្លៃ​ដែល​មាន​ការ​តុប​តែង​ដែល​មាន​បូក​បញ្ចូល​សម្ភារៈ​ប្រាស់​ដូច​មាន​ក្នុង​ឧបសម្ព័ន្ធ៣។ ក្នុង​ករណី​រោងចក្រ​ឈប់​ផលិត​នូវ​ផលិត​ផល​​ដែល​ក្រុមហ៊ុន​បាន​ជ្រើសរើស ភាគី “ក” មាន​សិទ្ធិ​ក្នុង​ការ​ផ្លាស់ប្តូរ​ដោយ​រក្សា​នូវ​គុណភាព​ដដែល។</p>

  <p><span class="text-bold"><u>ប្រការ២:</u></span> ភាគី “ខ” យល់​ព្រម​ទទួល​យក​ទាំង​ស្រុង​នូវ​ប្លង់​រចនាម៉ូត​សំណង់​ព្រម​ទាំង​សន្យា​ថា​មិន​កែប្រែ​ទ្រង់ទ្រាយ​ក្នុង​ និង ក្រៅ​ បន្ទប់​ដោយ​ខ្លួន​ឯង​ ឬ​ ជួល​ក្រុមហ៊ុន​ដទៃ​ ឬ បុគ្គល​ណា​ម្នាក់​មក​ធ្វើ​ការ​កែប្រែ​បន្ទប់​នោះ​ទេ​។ ប្រសិន​បើ​មាន​ការ​ចាំ​បាច់​ភាគី “ខ” ត្រូវ​ធ្វើ​ការ​ស្នើ​សុំ ហើយ បន្ទាប់​ពី​ទទួល​បាន​ការ​ឯកភាព​ពី​ភាគី “ក” ក្រុមហ៊ុន​តំណាង​ចាត់​ចែង​ត្រូវ កំណត់ ដោយ​ភាគី “ក”។</p>

  <p class="text-bold"><u>ប្រការ៣: កាលបរិច្ឆេទនៃការទូទាត់ប្រាក់</u></p>
  <p class="pl-5">៣.១ ភាគី “ខ” ត្រូវ​ទូទាត់​ប្រាក់​សរុប​ថ្លៃ​ទិញ​បន្ទប់​តាម​ដំណាក់​កាល​ជា​បន្ត​បន្ទាប់​ដូច​មាន​ចែង​ក្នុង​តារាង​ទូទាត់​ប្រាក់​ក្នុង​ឧបសម្ព័ន្ធ១។</p>
  <p class="pl-5">៣.២ ក្នុង​ករណី​ដែល​ភាគី​ “ខ” យឺតយ៉ាវ ឬខកខាន​មិន​បាន​បង់ប្រាក់​តាម​កាល​កំណត់​ក្នុង​កថាខណ្ឌ ៣.១ នោះ​ទេ​ភាគី “ខ” ត្រូវ​បង់ប្រាក់​ពិន័យ​ក្នុង​អត្រា ១.២% (មួយ​ក្បៀស​ពីរ​ភាគ​រយ) ក្នុង១ខែ។ ករណី​ការ​យឺតយ៉ាវ​ និង​ខកខាន​លើស​ពី៣ខែ នោះ​ចាត់​ទុក​ថា​ភាគី “ខ” បាន​បោះបង់​សិទ្ធិ​ជា​អ្នក​ទិញ​ក្នុង​ការ​បន្ត​កិច្ចសន្យា​ទិញ-លក់នេះ។</p>

  <p><span class="text-bold"><u>ប្រការ៤:</u></span> អំឡុង​ពេល​សាងសង់​ភាគី “ខ” អាច​លក់​ ឬ ផ្ទេរ​កិច្ចសន្យា​បាន​បន្ទាប់​ពី​ស្នើ​សុំ​ហើយ ទទួល​បាន​ឯកភាព​ជា​លាយលក្ខណ៍​អក្សរ​ពីភាគី “ក” ដោយ​ភាគី “ខ” ត្រូវ​បង់​ថ្លៃ​សេវារ​រដ្ឋបាល​ក្រុមហ៊ុន​ចំនួន ១៥០ USD$ (មួយ​រយ​ហា​សិប​ដុល្លា​អាមេរិក) ជូនភាគី“ក”។  ភាគី​ទី​បី​ដែល​ទទួល​យក​ការ​ផ្ទេរ​កិច្ចសន្យា​ភាគី “ខ” ត្រូវ​គោរព​តាម​ខ្លឹមសារ​ទាំង​ស្រុង​នៃ​កិច្ច​ព្រម​ព្រៀង​នេះ។</p>

  <p><span class="text-bold"><u>ប្រការ៥:</u></span> ភាគី “ក” សន្យា​ថា​នៅ​ក្នុង​អំឡុង​ពេល ៣០ ខែ និង អនុគ្រោះ​ ៨ ខែ​បន្ថែម​បន្ទាប់​ពី​ថ្ងៃ​ចុះ​កិច្ចសន្យា នឹងប្រគល់​បន្ទប់​លេខ​ <strong>{{ $unit['house_no'] }}</strong> ជាន់ទី​ <strong>{{ $unit['floor'] }}</strong> ជូន​ទៅ​ភាគី “ខ”។ ប្រសិន​បើ​ការ​សាង​សង់​បន្ទប់​ហើយ​មុន​កាល​កំណត់​ក្នុង​កិច្ចសន្យា​ភាគី “ក” មាន​កាតព្វកិច្ច​ជូន​ដំណឹង​ទៅ​ភាគី “ខ” ដើម្បី​មក​បំពេញ​បែបប​ទទទួល​បន្ទប់ និង​ធ្វើ​លិខិត​ចូល​ស្នាក់នៅ។ ករណី​ការ​សន្យា​មិន​រួចរាល់​តាម​ការ​កំណត់​ភាគី “ក” សន្យា​និង​សង​សំណង​ជូន​ភាគី “ខ” គុណ នឹង (1%) ភាគរយក្នុង​មួយ​ខែៗ នៃ​ទឹក​ប្រាក់​សរុប​ដែរ ភាគី”ខ” បាន បង់រួច។</p>

  <p><span class="text-bold"><u>ប្រការ៦:</u></span> ភាគី “ក” មាន​កាតព្វកិច្ច​ក្នុង​ការ​ថែរក្សា​នូវ​សុវត្ថិភាព​សន្តិសុខ​សណ្តាប់​ធ្នាប់​សោភ័ណ្ឌ​ភាព​ទ្រព្យ​សម្បត្តិ​សាធារណៈ​ផ្សេងៗ​ក្នុង​អគារ​ខុនដូ <span class="english-font text-bold">East Sen Sok Condominium</span>។</p>

  <p><span class="text-bold"><u>ប្រការ៧:</u></span> បន្ទាប់​ពី​ភាគី “ក” និង​ភាគី “ខ” បាន​ទូទាត់​ប្រាក់​ថ្លៃ ទិញ-លក់ និង​ធ្វើ​ការ​ផ្ទេរ​ការ​គ្រប់គ្រង​បន្ទប់​ខុនដូ <span class="english-font text-bold">East Sen Sok Condominium</span> រួច​រាល់​ភាគី “ខ” សន្យា​ថា​នឹង​គោរព​យ៉ាង​ម៉ឺងម៉ាត់​តាម បទ​បញ្ជា​ផ្ទៃ​ក្នុង​ដែល​កំណត់​ដោយ​ភាគី “ក” មាន​ដូច​ជា សណ្តាប​ធ្នាប់ សុវត្ថិភាព សុខភាព អនាម័យ មិនចិញ្ចឹម (សត្វឆ្មា​-​សត្វឆ្កែ​-​សត្វបក្សី​-​និង​-​សត្វផ្សេងៗ​ទៀត​) មិន​ស្រែក​ឡូឡា​ខ្លាំងៗ​ មិន​បំពុល​បរិស្ថាន​ មិន​អនុញ្ញាត​ឲ្យ​នាំ​អាវុធ​ និង​គ្រឿង​ញៀន​ចូល​ មិន​អនុញ្ញាត​ឲ្យ​បើក​បន​ល្បែង​  បើក​ហាង​លក់​ទំនិញ​ ឬ​ក្រុមហ៊ុន​គឺ​សម្រាប់​តែ​ការ​ស្នាក់​នៅ​ប៉ុណ្ណោះ។ ភាគី “ខ” សន្យា​យល់​ព្រម​គោរព​តាម​ការ​កំណត់​ជា​សាធារណៈ​របស់​ផ្នែក​គ្រប់គ្រង​សេវាកម្ម។</p>
  <ul>
    <li>ភាគី “ខ” ត្រូវទិញធានារ៉ាប់រងអគ្គីភ័យដោយខ្លួនឯង។</li>
    <li>ភាគី “ខ” មិនត្រូវកែប្រែរចនាសម្ព័ន្ធសំណង់ និងសោភ័ណ្ឌភាពនៃបន្ទប់អគារខាងក្រៅ។</li>
    <li>ភាគី “ខ” ត្រូវទទួលបន្ទុកលើថ្លៃជួសជុលថែទាំ ក្រោយរយៈពេលធានាជួសជុលថែទាំ។</li>
  </ul>
  <p><span class="text-bold"><u>ប្រការ៨:</u></span> ពភាគី “ក” មាន​កាតព្វកិច្ច​ទទួល​ខុស​ត្រូវ​បំពេញ​បែបបទ​ផ្ទេរ​ឈ្មោះ​កាន់កាប់ (កម្មសិទ្ធិ) ជូនភាគី “ខ”។ វិសាលភាព​នៃ​ការ​បំពេញ​បែបបទ​នេះ​កំណត់​ត្រឹម​សង្កាត់ និងខណ្ឌ តែប៉ុណ្ណោះ។</p>

  <p><span class="text-bold"><u>ប្រការ៩:</u></span> ប្រសិនបើភាគី “ខ” ជួលបន្ទប់នេះ ភាគី “ខ” មាន​កាតព្វកិច្ច​ជូន​ដំណឹង​ដល់​ភាគី “ក” ទុកជាមុន ហើយ​ត្រូវ​ធានា​ថា​ភាគី​ទីបី​គោរព​អនុវត្ត​តាម ប្រការ៧ និង ៨ ខាងលើ។</p>

  <p><span class="text-bold"><u>ប្រការ១០:</u></span> គិត​ចាប់​ពី​ថ្ងៃ​ដែល​ភាគី “ខ” ត្រូវ​ធ្វើ​លិខិត​ចូល​ស្នាក់នៅ​ ភាគី “ក” ធ្វើ​ការ​ធានា​ចំពោះ​សំណង់ និង បរិក្ខាដូចខាងក្រោម</p>  
  <ul>
    <li>អគារ​បាក់​ស្រុត​: ភាគី “ក” ធានា​រយៈ​ពេល​ ៥(ប្រាំ) ឆ្នាំ ប៉ុន្តែ​ការ​ធានា​នេះ​គឺ​ធានា​ត្រឹម​ការ​បាក់​ស្រុត​ដែល​បណ្តាល​មក​ពី​គុណ​ភាព​សំណង់​តែ​ប៉ុណ្ណោះ​។</li>
    <li>ជញ្ជាំង​ប្រេះ  បែកប្រព័ន្ធទឹក   ប្រព័ន្ធអគ្គិសនី   ប្រព័ន្ធលូ ភាគី “ក” ធានារយៈពេល១ឆ្នាំ ក្នុងការជួសជុលជូន។</li>
    <li>បរិក្ខា​អគ្គិសនី​ក្នុង​បន្ទប់​ត្រូវ​បាន​ធានា​ដោយ​យោង​ទៅ​តាម​លក្ខខណ្ឌ​ដែល​បាន​កំណត់​ដោយ​រោង​ចក្រ​ផលិត ឬអ្នកលក់។</li>
    <li>ការ​ខូចខាត​ដែល​បង្ក​ឡើង​ដោយ​ករណី​ប្រធានស័ក្តិ សង្គ្រាម និងគ្រោះធម្មជាតិផ្សេងៗ ព្រមទាំង​សកម្មភាព​បំពានផ្សេងៗ មិន​រាប់​បញ្ចូល​ក្នុង​វិសាលភាព​នៃ​ការ​ធានា​ក្នុង​ប្រការ​នេះ​ឡើយ។</li>
  </ul>  

  <p><span class="text-bold"><u>ប្រការ១១:</u></span> ភាគី “ខ” មាន​កាតព្វកិច្ច​បង់​ថ្លៃសេវា​ចំនួន <strong>{{ $unit['service_fee'] }}US$</strong> ({{ \App\Helpers\NumberFormat::covertUsdToKhmerWordFloat($contract->service_fee) }}) ក្នុង​មួយ​ខែ​ដោយ​កំណត់ 0.8 US$/m2 (សូន្យ​ក្បៀស​ប្រាំបី​ដុល្លា​អាមេរិក​ក្នុង​មួយ​ម៉ែត្រ​ការ៉េ) ជា​បទដ្ឋាន​គោល​នៃ​ការ​គណនា។ ផ្នែក​សេវា​សាធារណៈ​មាន​ដូចជា (ជណ្តើរយន្តរួម - អនាម័យ​ទី​កន្លែង​សាធារណៈ - ភ្លើង​បំភ្លឺ​ផ្លូវរួម - និង​សន្តិសុខ - អាង​ហែល​ទឹករួម - និង​ក្លឹប​ហាត់​ប្រាណ​រួម -ល-។ ភាគី “ក” មាន​សិទ្ធិ​ក្នុង​ការ​កែ​ប្រែ​តម្លៃ​ខាង​លើ​ប្រសិន​បើ​មាន​ការ​កែ​ប្រែ​ភាគី “ក” នឹង​ជូន​ដំណឹង​ជា​សាធារណៈ​ រយៈពេល ១ ខែ​ទុក​ជា​មុន។</p>  

  <p><span class="text-bold"><u>ប្រការ១២:</u></span> កិច្ច​ព្រមព្រៀង​នេះ​ត្រូវ​ធ្វើ​ឡើង​ដោយ​គ្មាន​ការ​គំរាមកំហែង បង្ខិតបង្ខំ ឬ​មាន​បញ្ហា ខុស​ច្បាប់​ណា​មួយ​ឡើយ​ហើយ​ត្រូវ​ចូល​ជា​ធរ​មាន​បន្ទាប់​ពី​ភាគី “ក” និងភាគី “ខ” បាន ផ្តិត​ស្នាម​មេ​ដៃ​ ឬ​ប្រថាប់ត្រា។ កិច្ច​ព្រមព្រៀង​នេះ​ធ្វើ​ឡើង​ជា​ភាសា​ខ្មែរ​ចំនួន២ច្បាប់ ក្នុង​នោះ​ភាគី “ក” រក្សា​ទុក 1ច្បាប់ដើម ភាគី “ខ” រក្សាទុក 1ច្បាប់ដើម។ ច្បាប់​នីមួយៗ​មាន​អានុភាព​គតិយុត្ត​ស្មើគ្នា។</p>

  <p style="text-align: right;margin-top:30px;">រាជធានីភ្នំពេញ ថ្ងៃទី........ ខែ........ ឆ្នាំ២០........</p>

  <table style="text-align: center; width: 100%;page-break-after: always;">
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
    <tr>
      <td height="250px"><h4>ប៉ែន ស្រីរ័ត្ន</h4></td>
      <td>...........................</td>
      <td>...........................</td>
      <td>...........................</td>        
    </tr>
  </table>
  
  @include('admin.contract.template.payment_template', ['contract' => $contract])

  <h4 class="main-title text-center">គម្រោង East Sen Sok Condominium</h4>
  <h4 class="main-title text-center">ឧបសម្ព័ន្ធ៣ : (2 Bedrooms)</h4>
  <p class="text-lg text-center mb-4">សម្ភារៈដែលបូកបញ្ចូលក្នុងបន្ទប់ខុនដូប្រភេទ២បន្ទប់គេង</p>
  <p class="text-lg text-bold"><u>១. សម្ភារៈក្នុងផ្ទះបាយមាន</u></p>
  <p class="second-indent">- ទូចង្ក្រាន១ឈុត</p>
  <p class="second-indent">- ចង្ក្រាន០១។</p>
  <p class="second-indent">- ចង្ក្រាន០១។</p>
  <p class="second-indent">- ស៊ីងលាងចាន០១។</p>
  <p class="second-indent">- ម៉ាស៊ីនបឺតផ្សែង០១។</p>
  <p class="text-lg text-bold">២. សម្ភារៈក្នុងបន្ទប់គេងមាន</p>
  <p class="second-indent">- ទូរសម្លៀកបំពាក់០១។</p>
  <p class="second-indent">- ទូទូរទស្សន៍០១។</p>
  <p class="second-indent">- ម៉ាស៊ីនត្រជាក់០១។</p>
  <p class="text-lg text-bold">៣. សម្ភារៈក្នុងបន្ទប់ទឹកមាន</p>
  <p class="second-indent">- បង្គន់០១។</p>
  <p class="second-indent">- ឡាបូ០១។</p>
  <p class="second-indent">- ផ្កាឈូកងូតទឹក០១។</p>
  <p class="second-indent">- ម៉ាស៊ីនទឹកក្តៅទឹកត្រជាក់០៣។</p>
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