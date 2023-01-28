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
    'type' => "ផ្ទះល្វែង",
    'land_width' => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->unit_land_width),
    'land_length' => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->unit_land_length),
    'house_width' => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->unit_house_width),
    'house_length' => \App\Helpers\NumberFormat::convertToKhmerNumber($contract->unit_house_length)
  ];
  
@endphp
<body>
  <h2 class="main-title text-center">ព្រះរាជាណាចក្រកម្ពុជា</h2>
  <h2 class="main-title text-center">ជាតិ សាសនា ព្រះមហាក្សត្រ</h2>
  <p class="text-center"><img src="{{ asset('img/kbach.png') }}"/></p>
  <h2 class="main-title text-center">កិច្ចសន្យាទិញ-លក់ផ្ទះបុរីអ៊ីសសីហនុស៊ីធី</h2>

  <p class="text-center text-bold" style="margin-top:12pt;margin-bottom:12pt;">រវាង</p>

  <p class="first-indent"><span class="moul-font">បុរីអ៊ីសសីហនុស៊ីធី</span> មានការិយាល័យកណ្តាលស្ថិតនៅអគារលេខ <span class="english-font text-bold">B2-109, B2-110</span> សង្កាត់-ទន្លេបាសាក់ ខណ្ឌ-ចំការមន រាជធានី-ភ្នំពេញ តំណាងដោយកញ្ញា <span class="text-bold">ប៉ែន ស្រីរ័ត្ន</span> តំណាងផ្នែកលក់របស់ក្រុមហ៊ុន <span class="english-font text-bold">BS Land and Home Co., Ltd</span> កើត​ថ្ងៃទី២៨ ខែ១២ ឆ្នាំ១៩៨៣ ជនជាតិខ្មែរ កាន់អត្តសញ្ញាណបណ្ណលេខ ០១០២១៦១៣០ (០១) ចុះថ្ងៃទី២០ ខែ១០ ឆ្នាំ២០០២ ជាអ្នកលក់តទៅ​ហៅ​ថា <span class="text-bold">“ភាគី ក”</span>។<br>
  លេខទូរសព្ទទំនាក់ទំនង ៖ <span class="english-font" >087 49 99 95/ 012-855-821/ 078-224-124/ 097-209-6478</p>

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
    <li>ឧបសម្ព័ន្ធ២ : ប្លង់ទីតាំងផ្ទះក្នុងបុរីចតុមុខស៊ីធី១</li>
    <li>ឧបសម្ព័ន្ធ៣ : អត្តសញ្ញាណប័ណ្ណ អ្នកទិញ និង អ្នកលក់</li>    
  </ul>

  <p class="text-bold text-center"​ style="text-align: center !important;">ដោយផ្អែកលើគោលការណ៍ស្ម័គ្រចិត្ត និងស្មើភាព ភាគី “ក” និង ភាគី “ខ” បានព្រមព្រៀងគ្នាដូចតទៅ ៖</p>

  <p class="mb-0 text-bold"><u>ប្រការ១:</u></p>
  <p>ភាគី (ក) យល់​ព្រម​លក់​ហើយ​ភាគី (ខ) បាន​យល់​ព្រម​ទិញ​ដី​មួយ​ឡូត៍​លេខ {{ $unit['house_no'] }} ដែល​មាន​ទំហំ​ដី​ទទឹង {{ $unit['land_width'] }} ម៉ែត្រ និង​បណ្ដោយ {{ $unit['land_length'] }} ម៉ែត្រ លក់​ក្នុង​តម្លៃ USD{{ $unit['price'] }} ({{ $unit['price_khmer_word'] }}) ក្នុង​មួយឡូត៍។ ភាគី​ (ខ) យល់​ព្រម​ធើ្វ​ការ​បង់​ប្រាក់​ជូន​ភាគី​ (ក) តាម​តារាង​បង់​ប្រាក់​ដែល​ភាគី (ក) ភ្ជាប់​ជាមួយ​កិច្ច​សន្យា​នេះ​ជា​ឧបសម្ព័ន្ធ១​។ រាល់​ប្រាក់​ដែល​ភាគី (ខ) បាន​បង់​រួច​គឺ​មិនអាច​ដក​វិញ​បាន​ឡើយ។</p>

  <p class="mb-0 text-bold"><u>ប្រការ​២:</u> ទីតាំងដីឡូត៍</p>
  <p>ទីតាំងដីឡូត៍ដែលភាគី (ខ) បាន​ទិញ​ស្ថិត​នៅ​ភូមិ​អូរ​តា​សេក ឃុំ​អូរ​ឧកញ៉ា​ហេង ស្រុក​ព្រៃ​នប់ ខេត្ត​ព្រះ​សី​ហ​នុ។</p>

  <p class="mb-0 text-bold"><u>ប្រការ​៣:</u> កាលបរិច្ឆេតបង់ប្រាក់</p>
  <p>ភាគី (ខ) ត្រូវ​បង់​ប្រាក់​សរុប​ថ្លៃ​ទិញ​ដី​ឡូត៍​តាម​ដំណាក់​កាល​ជា​បន្ត​បន្ទាប់​ដូច​មាន​ចែង​ក្នុង​តារាង​ទូទាត់​ប្រាក់​ក្នុង​ឧបសម្ព័ន្ធ១​។ ភាគី (ខ) អាច​មក​ទូ​ទាត់​ប្រាក់​នៅ​ក្រុមហ៊ុន​ផ្ទាល់ ឬ អាច​ទូ​ទាត់​ប្រាក់​ចូល​ក្នុង​គណនី​របស់​ក្រុមហ៊ុន​តាម​រយៈ​ធនាគារ​ភ្នំ​ពេញ​ពាណិជ្ជ​ដែល​មាន​គណនី​ឈ្មោះ CHAN DANY / LY JEA JEA ANGEL លេខ​គណនី 127-01-142790-8។ ក្នុង​ករណី​ភាគី​ (ខ) ដាក់​លុយ​ចូល​ក្នុង​គណនី​ខាង​លើ ភាគី(ខ) ត្រូវ​ផ្តល់​ពត៏មាន លេខ​ឡូតិ៍ និង​ឈ្មោះ មក​ខាង​ក្រុមហ៊ុន​ដើម្បី​ធ្វើ​ការ​ត្រួត​ពិនិត្យ។</p>

  <p class="mb-0 text-bold"><u>ប្រការ​៤:</u> ការផ្ទេរសិទ្ធិ និងការទទួលខុសត្រូវ</p>
  <p class="ml-5"><span class="text-bold">៤.១</span>​ ភាគី (ខ) មាន​សិទ្ធិ​លក់​បន្ត​ទៅ​អោយ​ជន​ទី៣​ដោយ​ត្រូវ​បង់​សេវា​រដ្ឋបាល​ចំនួន <strong>USD 100 (មួយ​រយ​ដុល្លារ​សហ​រដ្ឋ​អាមេរិក)</strong> ក្នុង​ការ​ផ្ទេរ​កិច្ច​សន្យា​បន្ត។</p>

  <p class="ml-5"><span class="text-bold">៤.២</span>​ ភាគី (ក) សន្យា​នឹង​ធ្វើ​ការ​ផ្ទេរ​សិទ្ធិ​កាន់​កាប់ (ប្លង់ទន់) ត្រឹម​ស្រុក​ជូន ភាគី (ខ) នៅ​ពេល​ណា​ដែល​ភាគី (ខ) បង់​ប្រាក់​គ្រប់​ចំនួន ១០០% (មួយ​រយ​ភាគ​រយ) នៃ​តម្លៃ​ដី ហើយ​រាល់​ការ​ចំណាយ​ផ្ទេរ​កម្ម​សិទ្ធិ​កាន់​កាប់​ (ប្លង់ទន់) ត្រឹម​ស្រុក ជា​បន្ទុក​របស់​ភាគី (ក) ទាំងស្រុង។</p>

  <p class="ml-5"><span class="text-bold">៤.៣</span>​ ក្នុង​ករណី​ផ្ទេរ​វិញ្ញា​បន​បត្រ​សម្គាល់​ម្ចាស់​អចលន​វត្ថុ (ប្លងរឹង) ភាគី (ក) មាន​តួនាទី​ជួយ​សម្រួល​រៀប​ចំ​ឯកសារ​ជូន​ភាគី (ខ) រាល់​ការ​ចំណាយ​លើ​សេវា​សាធារណៈ​ក្នុង​ការ​រៀប​ចំឯកសារ និង​ពន្ធ​ប្រថាប់​ត្រា ៤% <strong>ជា​បន្ទុក​របស់​ភាគី (ខ)</strong>។</p>

  <p class="mb-0 text-bold"><u>ប្រការ​៥:</u> ភារៈកិច្ចទទួលខុសត្រូវមុន និងក្រោយការទទួលដីឡូត៍</p>
  <p class="ml-5"><span class="text-bold">៥.១</span>​ ភាគី (ក) ទទួល​ខុស​ត្រូវ​ទាំង​ស្រុង​លើ​ពន្ធ​អចលន​ទ្រព្យ ការ​បង់​ពន្ធ​ដី​មិន​ប្រើប្រាស់​ និង​អាជីវកម្ម​ដី​ឡូត៍​លក់​របស់​ក្រុមហ៊ុន មុន​ពេល​ប្រគល់​ដីឡូត៍។</p>

  <p class="ml-5"><span class="text-bold">៥.២</span>​ ក្នុង​អំឡុង​ពេល​ភាគី (ខ) ទទួល​កាន់​កាប់​ដី​ឡូត៍​បន្ទាប់​ពី​បាន​ទទួល​ពី​ភាគី (ក) រួច​រាល់​នោះ​ភាគី​ (ខ) មាន​កាតព្វ​កិច្ច​ទទួល​បន្ទុក​ចំពោះ​ការ​បង់​ពន្ធ​លើ​អចលន​ទ្រព្យ និង​ពន្ធ​ផ្សេងៗ​ដែល​រដ្ឋា​ភិបាល​នៃ​ព្រះ​រា​ជា​ណា​ចក្រ​កម្ពុជា​បាន​កំណត់។</p>

  <p><span class="text-bold"><u>ប្រការ៦:</u></span> ភាគី (ក) សន្យាធ្វើការអភិវឌ្ឍន៍ដីឡូត៍ដូចខាងក្រោម៖</p>
  <ul>
    <li>ផ្លូវបេតុងក្នុងគម្រោងដីឡូត៍</li>
    <li>ប្រព័ន្ធលូក្នុងគម្រោងដីឡូត៍</li>
    <li>ប្រព័ន្ធទឹកស្អាតក្នុងគំរោងដីឡូត៍</li>
    <li>បោះបង្គោលភ្លើង និងចាក់ដីបំពេញមិនអោយលិចទឹក</li>    
  </ul>
  <p>ការអភិវឌ្ឍន៍ដីនេះនិងបញ្ចប់រួចរាល់ក្នុងរយះពេល 20 ខែ និងអនុគ្រោះ 6 ខែ គិតចាប់ពីថ្ងៃចុះ
  កិច្ចសន្យានេះតទៅ។
  </p>

  <p class="mb-0 text-bold"><u>ប្រការ៧:</u></p>
  <p>ភាគី (ខ) យល់​ព្រម​បង់ថ្លៃ អនាម័យ សណ្ដាប់ធ្នាប់ សន្តិសុខ សោភ័ណ្ឌភាព ភ្លើងបំភ្លឺសាធារណៈ និង​ការ​ជួស​ជុល​ផ្លូវ​ខូច​ខាត​ជូន​មក​បុរី​អ៊ីស​សីហនុ​ស៊ីធី​ ប្រចាំ​ឆ្នាំ​ចំនួន USD 180 (មួយ​រយ​ប៉ែត​សិប​ដុល្លារ​សហរដ្ឋ​អាមេរិក) នៅ​ពេល​ដែល​ភាគី (ខ) ចាប់​ផ្ដើម​ធ្វើ​ការ​សាង​សង់។ ក្នុង​ករណី​ភាគី​ (ខ) មាន​បំណង​ត​ភ្ជាប់​ប្រព័ន្ធ​ទឹក​និង​ភ្លើង​ចូល​ទៅ​ក្នុង​គេហដ្ឋាន​របស់​ខ្លួន​ការ​ចំណាយ​ទាំង​ស្រុង​ជា​បន្ទុក​របស់​ភាគី (ខ)។</p>

  <p class="mb-0 text-bold"><u>ប្រការ៨:</u></p>
  <p>ភាគី (ក) សន្យា​ក្នុង​ករណី​បើ​ថ្ងៃ​ក្រោយ​មាន​ជន​ណា​ផ្សេង​មក​ទាម​ទារ​ ឬ តវ៉ា ថា​ដី​ខាង​លើ​មិន​មែន​ជា​ដី​របស់​ក្រុមហ៊ុន​ ឬ​មិន​ស្រប​ច្បាប់​នោះ​ភាគី (ក) យល់​ព្រម​ទទួល​ខុស​ត្រូវ​ដោះ​ស្រាយ​បញ្ហា​ទាំង​ស្រុង​ចំពោះ​មុខ​ច្បាប់ ហើយ​រាល់​ការ​ចំណាយ​ដោះ​ស្រាយ​បញ្ហា​ជា​បន្ទុក​របស់​ភាគី (ក) ទាំង​ស្រុង។</p>

  <p class="mb-0 text-bold"><u>ប្រការ៩:</u></p>
  <p>ក្នុង​ករណី​​ភាគី​ (ខ) ល្មើស​លួច​ផ្ទេរ​សិទ្ធិ​ ឬ​ក៏​បញ្ចាំ​ដី​ខាង​លើ​ទៅ​ភាគី​ផ្សេងទៀត ដោយ​ពុំ​បាន​សុំ​សិទ្ធិ​ដោយ​ការ​ធ្វើ​លិខិត​ជា​លាយ​លក្ខ​អក្សរ​ជូន​ភាគី (ក) ដឹង​ឮនោះទេ ភាគី (ក) មាន​សិទ្ធិ​ទាំង​ស្រុង​ក្នុង​ការ​បញ្ចប់​កិច្ច​សន្យា​ទិញ-លក់​ដី​ឡូត៍​ជា​ឯក​តោ​ភាគី​ហើយ​ទឹក​ប្រាក់​ដែល​បាន​បង់​ជូន​ភាគី (ក) ត្រូវ​បាន​ចាត់​ទុក​ជា​អសារ​បង់​។ </p>

  <p class="mb-0 text-bold"><u>ប្រការ១០:</u></p>
  <p class="mb-0">ភាគី(ខ) ឯកភាពតាមប្លង់នីមួយៗដែលមានដូចខាងក្រោម៖</p>
  <p>ប្រភេទដីឡូត៍ប្លង់ {{ $unit['house_no'] }} ភាគី (ខ) យល់​ព្រម​ទុក​ដី​ខាង​មុខ​ផ្ទះ​ចំនួន ៤ ម៉ែត្រ ក្រោយ​ផ្ទះ​ចំនួន ១ ម៉ែត្រ ទើប​ភាគី (ខ) អាច​ធ្វើ​ការ​សាង​សង់​លំនៅ​ដ្ឋាន ឬ សំណង់​ផ្សេងៗ​បាន។</p>
  <div style="page-break-after: always;"></div>
  <p class="mb-0 text-bold"><u>ប្រការ១១:</u></p>
  <p class="">ក្នុងករណីភាគី (ខ) ធ្វើ​ការ​បង់​ប្រាក់​យឺត​យ៉ាវ មិន​ទៀង​ទាត់​តាម​តារាង​ទូ​ទាត់​ប្រាក់​ដែល​ភ្ជាប់​ជាមួយ​កិច្ច​សន្យា៖</p>
  <table class="v-align-top ml-3">
    <tr>
      <td width="20px">_ </td>
      <td><p>ចាប់​ពី​១​ថ្ងៃ ដល់ ៥ថ្ងៃ ភាគី(ខ) ត្រូវ​បង់​ប្រាក់​ពិន័យ​ចំនួន​ USD 2 ក្នុង​មួយ​ថ្ងៃ​ជូន​ភាគី (ក)</p></td>
    </tr>
    <tr>
      <td>_ </td>
      <td><p>ចាប់ពី ៦ថ្ងៃ ដល់ ១៥ថ្ងៃ ភាគី(ខ) ត្រូវ​បង់​ប្រាក់​ពិន័យ​ចំនួន USD 5 ក្នុង​មួយ​ថ្ងៃ​ជូន​ភាគី (ក)</p></td>
    </tr>
    <tr>
      <td>_ </td>
      <td><p>ចាប់​ពី​៣០​ថ្ងៃ​ឡើង​ទៅ​គឺ​មាន​ន័យ​ថា​ភាគី​(ខ)​យល់​ព្រម​បោះ​បង់​ចោល​កិច្ច​សន្យា​ទិញ-លក់​ជា​ឯក​តោ​ភាគី​ហើយ​ទឹក​ប្រាក់​ដែល​បាន​បង់​ជូន​ភាគី​(ក)​កន្លង​មក​ត្រូវ​បាន​ចាត់​ទុក​ជា​អា​សារ​បង់​ និង​មិន​អាច​រុះ​រើ​សំណង់​ដែល​សាង​សង់​លើ​ទីតាំង​ដីឡូត៍​នេះ​បាន​ឡើយ​ ហើយ​​ទី​តាំង​ដី​ និង​សំណង់​នៅ​តែ​ជា​កម្ម​សិទ្ធិ​ស្រប​ច្បាប់​របស់​ភាគី​(ក)​ដដែល ហើយ​ភាគី​(ក)​ក៏​អាច​មាន​សិទ្ធិ​លក់​បន្ត​ទៅ​ភាគី​ផ្សេង​ទៀត​បាន​ដែរ​។</p></td>
    </tr>
  </table>

  <p class="mb-0 text-bold"><u>ប្រការ១២:</u></p>
  <p>កិច្ច​ព្រមព្រៀង​នេះ​ត្រូវ​ធ្វើ​ឡើង​ដោយ​គ្មាន​ការ​គំរាម​កំហែង បង្ខិតបង្ខំ ឬ​មាន​បញ្ហា​ខុស​ច្បាប់​ណា​មួយ​ឡើយ​ ហើយ​ត្រូវ​ចូល​ជា​ធរ​មាន​បន្ទាប់​ពី​ភាគី “ក” និង ភាគី “ខ” បាន​ផ្តិត​ស្នាម​មេ​ដៃ​ ឬ​ប្រថាប់ត្រា។ កិច្ចព្រមព្រៀង​នេះ​ធ្វើ​ឡើង​ជា​ភាសា​ខ្មែរ​ចំនួន​ពីរ​ច្បាប់​ ក្នុង​នោះ​ភាគី​ “ក” រក្សា​ទុក​មួយ​ច្បាប់​ដើម​ ភាគី “ខ” រក្សា​ទុក​មួយ​ច្បាប់​ដើម។ ច្បាប់​នីមួយៗ​មាន​អានុភាព​គតិយុត្តិ​ស្មើ​គ្នា​។​</p>

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