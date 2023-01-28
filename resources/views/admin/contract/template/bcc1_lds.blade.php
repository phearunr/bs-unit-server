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
  <h2 class="main-title text-center">កិច្ចសន្យាទិញ-លក់បុរីចតុមុខស៊ីធី២</h2>

  <p class="text-center text-bold" style="margin-top:12pt;margin-bottom:12pt;">រវាង</p>

  <p class="first-indent"><span class="moul-font">បុរីចតុមុខស៊ីធី១</span> មានការិយាល័យកណ្តាលស្ថិតនៅអគារលេខ <span class="english-font text-bold">B2-109, B2-110</span> សង្កាត់-ទន្លេបាសាក់ ខណ្ឌ-ចំការមន រាជធានី-ភ្នំពេញ តំណាងដោយកញ្ញា <span class="text-bold">យីប ស៊ាងហុង</span> តំណាងផ្នែកលក់របស់ក្រុមហ៊ុន <span class="english-font text-bold">BS Land and Home Co., Ltd</span> កើត​ថ្ងៃទី១៤ ខែ០១ ឆ្នាំ១៩៩០ ជនជាតិខ្មែរ កាន់អត្តសញ្ញាណបណ្ណលេខ ០១០៦៤១៤៣៣ ចុះថ្ងៃទី ២៨ ខែ ១១ ឆ្នាំ ២០០៧ ជាអ្នកលក់តទៅ​ហៅ​ថា <span class="text-bold">“ភាគី ក”</span>។<br>
  លេខទូរសព្ទទំនាក់ទំនង ៖ <span class="english-font" >011 488 885 / 087 499 995</p>

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
    <li>ឧបសម្ព័ន្ធ៣ : សម្ភារៈដែលបំពាក់ក្នុងគេហដ្ឋាន</li>
    <li>ឧបសម្ព័ន្ធ៤ :  អត្តសញ្ញាណប័ណ្ណ អ្នកទិញ និង អ្នកលក់</li>
  </ul>

  <p class="text-bold text-center"​ style="text-align: center !important;">ដោយផ្អែកលើគោលការណ៍ស្ម័គ្រចិត្ត និងស្មើភាព ភាគី “ក” និង ភាគី “ខ” បានព្រមព្រៀងគ្នាដូចតទៅ ៖</p>

  <p class="mb-0 text-bold"><u>ប្រការ១:</u> កម្មវត្ថុនៃការទិញ-លក់ និងតម្លៃ</p>

  <p>ភាគី “ក” យល់​ព្រម​លក់ ហើយ​ភាគី “ខ” យល់​ព្រម​ទិញ​ផ្ទះ​ប្រភេទ LD មួយ​ខ្នង ដែល​​មាន​​អា​ស័យ​ដ្ឋាន​​ផ្ទះ​លេខ {{ $unit['house_no'] }} ផ្លូវ {{ $unit['street'] }} ក្នុងតម្លៃ <span class="english-font">USD </span> {{ $unit['price'] }} ({{$unit['price_khmer_word']}}) នៅ​ក្នុង​ បុរី​ចតុមុខ​ស៊ីធី​១  ដែល​មាន​ទី​តាំង​នៅ​ភូមិ​ស្វាយ​ជ្រុំ ឃុំ​ស្វាយ​ជ្រុំ ស្រុក​ខ្សាច់​កណ្តាល ខេត្ត​កណ្តាល។ តម្លៃ​នេះ​ជា​តម្លៃ​ដែល​មាន​បំពាក់​សម្ភារៈ​ប្រើ​ប្រាស់​ដូច​មាន​ក្នុង​ឧបសម្ព័ន្ធ៣។ ផ្ទះ​វីឡា​ប្រភេទ LD មាន​ទំហំ​ដី​ {{ $unit['land_width'] }} ម៉ែត្រ x {{ $unit['land_length'] }} ម៉ែត្រ ទំហំផ្ទះ {{ $unit['house_width'] }} ម៉ែត្រ x {{ $unit['house_length'] }} ម៉ែត្រ ដែល​មាន​បន្ទប់​ទទួល​ភ្ញៀវ១ ផ្ទះបាយ១ បន្ទប់គេង៣ និងបន្ទប់ទឹក៣ ។</p>

  <p class="mb-0 text-bold"><u>ប្រការ​២:</u> កាល​បរិច្ឆេទ​នៃ​ការ​ទូទាត់​ប្រាក់​</p>

  <p class="ml-5"><span class="text-bold">២.១</span>​ ភាគី​ “ខ”​ ត្រូវ​ទូទាត់​ប្រាក់​សរុប​​ថ្លៃទិញ​ផ្ទះ​តាម​ដំណាក់​កាល​ជា​បន្ត​បន្ទាប់​ដូច​មាន​ចែង​ក្នុង​តារាង​ទូទាត់​ប្រាក់​ក្នុង​ឧបសម្ព័ន្ធ១។​ ភាគី​ “ខ”​ អាច​មក​ទូទាត់​ប្រាក់​នៅក្រុមហ៊ុន​ផ្ទាល់​ ឬ​អាច​ទូទាត់​ប្រាក់​ចូល​ក្នុង​គណនី​របស់​ក្រុមហ៊ុន​ តាមរយៈ​ធនាគារ​ អ អេច ប៊ី ឥណ្ឌូឆៃណា  ដែល​មាន​គណនី​ឈ្មោះ ​<span class="english-font text-bold">BS LAND & HOME CO., LTD</span> &nbsp; លេខ​គណនី​ <span class="english-font text-bold"> 1-01-0004-00009925-0 </span>។</p>

  <p class="ml-5"><span class="text-bold">២.២</span>​ ក្នុង​ករណី​ដែល​ភាគី​ “ខ”​ យឺត​យ៉ាវ​ ឬ​ខកខាន​មិន​បាន​បង់​ប្រាក់​តាម​កាល​កំណត់​ ក្នុង​ឧបសម្ព័ន្ធ​១​នោះ​ទេ​ ភាគី ​“ខ”​ ត្រូវ​បង់​ប្រាក់​ពិន័យ​ក្នុង​អត្រា ​១.២%​ (មួយ​ក្បៀស​ពីរ​ភាគរយ​) ​នៃ​ទឹក​ប្រាក់​ត្រូវ​បង់​ក្នុង​មួយ​ខែ។​  ករណី​ការ​យឺត​យ៉ាវ​ និង​ខក​ខាន​លើស​ពី​ ៣ខែ​   ជាប់ៗ​គ្នា​ នោះ​ចាត់​ទុក​ថា​ភាគី​ “ខ”​ បាន​បោះបង់​ចោល​ការ​ទិញ​ផ្ទះ​នេះ​ជា​ឯកតោ​ភាគី។​ ក្នុង​ករណី​នេះ​ភាគី​“ក”​ មាន​សិទ្ធិ​លក់​ផ្ទះ​ឲ្យ​ទៅ​អ្នក​ផ្សេង​ទៀត​បាន​ ហើយ​ប្រាក់​ដែល​បាន​បង់​នៃ​ដំណាក់​កាល​នីមួយៗ​ចាត់​ទុក​ជា​អសារបង់​។</p>

  <p><span class="text-bold"><u>ប្រការ៣:</u></span> ភាគី “ក” សន្យា​ថា​នៅ​ក្នុង​អំឡុង​ពេល​ ២៤ (​ម្ភៃ​បួន​) ខែ​បន្ទាប់​ពី​ថ្ងៃ​ចុះ​កិច្ច​សន្យា​នឹង​ ប្រគល់​ផ្ទះ​លេខ​ {{ $unit['house_no'] }} ជូន​ទៅ​ភាគី​ “ខ”  ប៉ុន្តែ​ភាគី “ក” មាន​សិទ្ធិ​ពន្យា​ពេល​ ៦ (ប្រាំមួយ) ខែ យ៉ាង​យូរ លើស​ពី​នេះ​ប្រសិន​បើ​ភាគី “ក” យឺត​យ៉ាវ​ក្នុង​ការ​ប្រគល់​ផ្ទះ​ជូន​ ភាគី “ខ”  ភាគី “ក” ត្រូវ​បង់​សំណង​ជូន​ភាគី “ខ” ជា​ទឹក​ប្រាក់ ១% (​មួយ​ភាគ​រយ​) ក្នុង​មួយ​ខែ​នៃ​ទឹក​ប្រាក់​ដែល​បាន​បង់​រួច។</p>

  <p><span class="text-bold"><u>ប្រការ៤:</u></span> ភាគី “ក” មាន​កាតព្វកិច្ច​ក្នុង​ការ​ថែរក្សា​នូវ​សុវត្ថិភាព សន្តិសុខ សណ្តាប់ធ្នាប់ សោភ័ណ្ឌភាព ទ្រព្យ​សម្បត្តិ​សាធារណៈ​ផ្សេងៗ​ក្នុង​បុរី​ចតុមុខ​ស៊ីធី​២​ទាំងមូល។ បន្ទាប់​ពី ភាគី “ក” ប្រគល់​ផ្ទះ​ជូន​​ទៅ​ភាគី “ខ” រួច ភាគី “ខ” មាន​កាតព្វ​កិច្ច​បង់​ថ្លៃ​សេវា ចំនួន USD 240 (ពីរ​រយ​សែ​សិប​ដុល្លា​អាមេរិក) ក្នុង1ឆ្នាំ លើ​ផ្នែក​សេវា​ដែល មាន​ដូច​ជា អនាម័យ​សាធារណៈ  ភ្លើង​បំភ្លឺ​ផ្លូវ  ក្លឹប​ហាត់ប្រាណ (សមាជិក​ 2 នាក់)  និង​សន្តិសុខ 24ម៉ោង។ ភាគី “ក” មាន​សិទ្ធិ​ក្នុង​ការ​កែ​ប្រែ​តម្លៃ​ខាង​លើ ប្រសិន​បើ​មាន​ការ​កែ​ប្រែ ភាគី “ក” នឹង​ជូន​ដំណឹង​ជា​សាធារណៈ​រយៈ ពេល​មួយ​ខែ​ទុក​ជា​មុន​។</p>

  <p><span class="text-bold"><u>ប្រការ៥:</u></span>ភាគី “ក” ធានា​ចំពោះ​គុណភាព​សំណង់​ និង​ការ​បាក់​ស្រុត​រយៈពេល 03 (បី) ឆ្នាំ និងធានា​​ចំពោះ​ការ​ជួសជុល​ការ​ប្រះស្រាំ និង​លិច​ទឹក​ក្នុង​រយៈ​ពេល 01 (មួយ) ឆ្នាំ។</p>

  <p><span class="text-bold"><u>ប្រការ៦:</u></span> ភាគី “ខ” មិន​មាន​សិទ្ធិ​កែ​ប្រែ​សោភ័ណ្ឌភាព​សំណង់​បាន​ឡើយ លុះ​ត្រា​តែ​មាន​ការ អនុញ្ញាត​ពី​ភាគី “ក”។</p>

  <p><span class="text-bold"><u>ប្រការ៧:</u></span> ពេល​ដែល​ភាគី “ខ” បាន​ទូទាត់​ប្រាក់​ជូន​ភាគី “ក” គ្រប់​ចំនួន​ដូច​ចែង​ក្នុង​ឧបសម្ព័ន្ធ១ ភាគី “ក” <span class="text-bold">នឹង​ប្រគល់​ប្លង់​បំបែក​ក្បាល​ដី</span> (មិន​ទាន់​ផ្ទេរ​កម្មសិទ្ធិ) ជូនភាគី “ខ”។</p>

  <p><span class="text-bold"><u>ប្រការ៨:</u></span> ក្នុង​ករណី​ផ្ទេរ​វិញ្ញាបនបត្រ​សម្គាល់​ម្ចាស់​អចលនវត្ថុ (ប្លង់រឹង) ភាគី “ក” មាន​តួ​នាទី​ជួយ សម្រួល​រៀប​ចំ​រត់​ឯកសារ​ជូនភាគី “ខ” រាល់​ការ​ចំណាយ​លើ​សេវា​រត់​ឯកសារ និង​ពន្ធ​ប្រថាប់​ត្រា 4% ជា​បន្ទុក​របស់​ភាគី “ខ” ។</p>

  <p class="mb-0 text-bold"><u>ប្រការ​៩:</u> ភារៈកិច្ចទទួលខុសត្រូវមុន និងក្រោយទទួលផ្ទះ</p>

  <p class="ml-5"><span class="text-bold">៩.១</span>​ ភាគី “ក” ទទួល​ខុស​ត្រូវ​ទាំង​ស្រុង​លើ​ពន្ធ​អចលនទ្រព្យ ការ​បង់​ពន្ធ​ដី​មិន​ប្រើប្រាស់​និង​អាជីវកម្ម​សាង​សង់​ផ្ទះ​លក់​របស់​ក្រុមហ៊ុន <span class="text-bold">មុន​ពេល​ប្រគល់​ផ្ទះ</span>។</p>

  <p class="ml-5"><span class="text-bold">៩.២</span>​ បន្ទាប់​ពី​ភាគី “ខ” ទទួល​ផ្ទះ​ពី​ភាគី “ក” រួច ចំពោះ​ការ​បង់​ពន្ធ​លើអចលនទ្រព្យ និង​ពន្ធ​ផ្សេងៗ​ទៀត​ដែល​រដ្ឋ​តម្រូវ​ក្នុង​អំឡុង​ពេល​ភាគី “ខ” ទទួល​កាន់​កាប់ ជា​បន្ទុក​របស់ ភាគី“ខ”។</p>

  <p><span class="text-bold"><u>ប្រការ១០:</u></span> កិច្ច​ព្រមព្រៀង​នេះ​ត្រូវ​ធ្វើ​ឡើង​ដោយ​គ្មាន​ការ​គំរាម​កំហែង បង្ខិតបង្ខំ ឬ​មាន​បញ្ហា​ខុស​ច្បាប់​ណា​មួយ​ឡើយ​ ហើយ​ត្រូវ​ចូល​ជា​ធរ​មាន​បន្ទាប់​ពី​ភាគី “ក” និង ភាគី “ខ” បាន​ផ្តិត​ស្នាម​មេ​ដៃ​ ឬ​ប្រថាប់ត្រា។ កិច្ចព្រមព្រៀង​នេះ​ធ្វើ​ឡើង​ជា​ភាសា​ខ្មែរ​ចំនួន​ពីរ​ច្បាប់​ ក្នុង​នោះ​ភាគី​ “ក” រក្សា​ទុក​មួយ​ច្បាប់​ដើម​ ភាគី “ខ” រក្សា​ទុក​មួយ​ច្បាប់​ដើម។ ច្បាប់​នីមួយៗ​មាន​អានុភាព​គតិយុត្តិ​ស្មើ​គ្នា​។​</p>

  <p style="text-align: right;margin-top:30px;">រាជធានីភ្នំពេញ ថ្ងៃទី........ ខែ........ ឆ្នាំ២០........</p>

  <table style="text-align: center; width: 100%;page-break-after: always;">
    <tr>
      <td><p class="text-center">ភាគី “ក”</p></td>
      <td colspan="2"><p class="text-center">ភាគី “ខ”</p></td>     
    </tr>  
    <tr>
      <td height="200px"><h4>យីប ស៊ាងហុង</h4></td>    
      <td height="200px" style="text-align: right; padding-right: 50px;">..........................................</td>
      <td height="200px" style="text-align: left;">..........................................</td>        
    </tr>
  </table>

  @include('admin.contract.template.payment_template', ['contract' => $contract])
  
  <h4 class="main-title text-center">បុរីចតុមុខស៊ីធី១</h4>
  <h4 class="main-title text-center mb-4">ឧបសម្ព័ន្ធ៣ : សម្ភារៈដែលបូកបញ្ចូលផ្ទះប្រភេទ L1</h4>
  <p>១. សម្ភារៈ​ក្នុង​ផ្ទះ​បាយ​មាន ទូចង្ក្រាន១ឈុត ចង្ក្រាន១ ស៊ីងលាងចាន១ និង​ម៉ាស៊ីន​បឺត​ផ្សែង​១។</p>
  <p>២. សម្ភារៈក្នុងបន្ទប់ទទួលភ្ញៀវមាន ទូទូរទស្សន៍១។</p>  
  <p>៣. សម្ភារៈក្នុងបន្ទប់ទឹកមាន ម៉ាស៊ីនទឹកក្តៅទឹកត្រជាក់២ (ជាន់ទី១)។</p>
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