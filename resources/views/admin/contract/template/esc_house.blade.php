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
    <li>ឧបសម្ព័ន្ធ៣ : សម្ភារៈដែលបំពាក់ក្នុងគេហដ្ឋាន</li>
    <li>ឧបសម្ព័ន្ធ៤ :  អត្តសញ្ញាណប័ណ្ណ អ្នកទិញ និង អ្នកលក់</li>
  </ul>

  <p class="text-bold text-center"​ style="text-align: center !important;">ដោយផ្អែកលើគោលការណ៍ស្ម័គ្រចិត្ត និងស្មើភាព ភាគី “ក” និង ភាគី “ខ” បានព្រមព្រៀងគ្នាដូចតទៅ ៖</p>

  <p class="mb-0 text-bold"><u>ប្រការ១:</u> កម្មវត្ថុនៃការទិញ-លក់ និងតម្លៃ</p>

  <p>ភាគី “ក” យល់​ព្រម​លក់ ហើយ​ភាគី “ខ” យល់​ព្រម​ទិញ​ផ្ទះ​ដែល​មាន​អាស័យ​ដ្ឋាន​ផ្ទះ​លេខ {{ $unit['house_no'] }} ផ្លូវ {{ $unit['street'] }} ក្នុង​តម្លៃ USD {{ $unit['price'] }} ({{ $unit['price_khmer_word'] }}) នៅ​ក្នុង​បុរី​អ៊ីស​សីហនុ​ស៊ី​ធី ដែល​មាន​ទី​តាំង​នៅ​ភូមិ​អូ​តា​សេក ឃុំ​អូរ​ឧកញ៉ា​ហេង ស្រុក​ព្រៃ​នប់ ខេត្ត​ព្រះ​សី​ហ​នុ។ តម្លៃ​នេះ​ជា​តម្លៃ​ដែល​មាន​បំពាក់​សម្ភារៈ​ប្រើ​ប្រាស់​ដូច​មាន​ក្នុង​ឧបសម្ព័ន្ធ​៣។ ផ្ទះ​ល្វែង​ប្រភេទ {{ $contract->unitType->name }} (ជាន់​Eo) មាន​ទំហំ​ដី {{ $unit['land_width'] }} ម៉ែត្រ x {{ $unit['land_length'] }} ម៉ែត្រ ទំហំផ្ទះ {{ $unit['house_width'] }} ម៉ែត្រ x {{ $unit['house_length'] }} ម៉ែត្រ ដែល​មាន​បន្ទប់​ទទួល​ភ្ញៀវ១ ផ្ទះ​បាយ១ បន្ទប់​គេង​២ និងបន្ទប់​ទឹក​៣។</p>

  <p class="mb-0 text-bold"><u>ប្រការ​២:</u> កាល​បរិច្ឆេទ​នៃ​ការ​ទូទាត់​ប្រាក់​</p>

  <p class="ml-5"><span class="text-bold">២.១</span>​ ភាគី “ខ” ត្រូវ​ទូទាត់​ប្រាក់​សរុប​ថ្លៃ​ទិញ​ផ្ទះ​តាម​ដំណាក់​កាល​ជា​បន្ត​បន្ទាប់​ដូច​មាន​ចែង​ក្នុង​តារាង​បង់​ប្រាក់​ក្នុង​ឧបសម្ព័ន្ធ១។ ភាគី “ខ” អាច​មក​ទូទាត់​ប្រាក់​នៅ​ក្រុម​ហ៊ុន​ផ្ទាល់ ឬ​អាច​ទូទាត់​ប្រាក់​ចូល​ក្នុង​គណនី​របស់​ក្រុមហ៊ុន តាម​រយៈ​ធនាគារ​ភ្នំ​ពេញ​ពាណិជ្ជ​ ដែល​មាន​គណនី​ឈ្មោះ CHAN DANY /LY JEA JEA ANGEL លេខ​គណនី 127-01-142790-8។ ក្នុង​ករណី​ភាគី​(ខ)​បង់​ប្រាក់​តាម​រយៈ​គណនី​ខាង​លើ ភាគី(ខ) ត្រូវ​ផ្តល់​ពត៏​មាន​លេខ​ផ្ទះ​មក​ក្រុមហ៊ុន​ដើម្បី​ធ្វើ​ការ​ត្រួត​ពិនិត្យ</span>។</p>

  <p class="ml-5"><span class="text-bold">២.២</span>​ ក្នុង​ករណី​ដែល​ភាគី “ខ” យឺត​យ៉ាវ ឬ​ខក​ខាន​មិន​បាន​បង់​ប្រាក់​តាម​កាល​កំណត់ ក្នុង​ឧបសម្ព័ន្ធ​១​នោះ​ទេ ភាគី “ខ” ត្រូវ​បង់​ប្រាក់​ពិន័យ​ក្នុង​អត្រា ១.២% (មួយ​ក្បៀស​ពីរ​ភាគ​រយ) នៃ​ទឹក​ប្រាក់​ត្រូវ​បង់​ក្នុង​មួយ​ខែ។  ករណី​មាន​ការ​យឺត​យ៉ាវ និង​ខក​ខាន​លើស​ពី ៣​ខែ​ជាប់ៗ​គ្នា​ នោះ​ចាត់​ទុក​ថា​ភាគី “ខ” បាន​បោះ​បង់​ចោល​ការ​ទិញ​ផ្ទះ​នេះ​ជា​ឯក​តោ​ភាគី។ ក្នុង​ករណី​នេះ​ភាគី “ក” មាន​សិទ្ធិ​លក់​ផ្ទះ​ឲ្យ​ទៅ​អ្នក​ផ្សេង​ទៀត​បាន ហើយ​ប្រាក់​ដែល​បាន​បង់​គ្រប់​ដំណាក់​កាល​នីមួយៗ​ត្រូវ​ចាត់​ទុក​ជា​អ​សារ​បង់។</p>

  <p><span class="text-bold"><u>ប្រការ៣:</u></span> ភាគី “ក” សន្យា​ថា​នៅ​ក្នុង​អំឡុង​ពេល ២៤ (ម្ភៃ​បួន) ខែ និង​មាន​ការ​អនុ​គ្រោះ​ចំនួន​៦​ខែ​បន្ទាប់​ពី​ថ្ងៃ​ចុះ​កិច្ច​សន្យា​នឹង ប្រគល់​ផ្ទះ​លេខ {{ $unit['house_no'] }} ជូន​ទៅ​ភាគី “ខ” លើស​ពី​នេះ​ប្រសិន​បើ​ភាគី “ក” នៅ​តែ​មាន​ការ​យឺត​យ៉ាវ​ក្នុង​ការ​ប្រគល់​ផ្ទះ​ជូន ភាគី “ខ” នោះ​ភាគី “ក” ត្រូវ​បង់​សំណង​ជូន​ភាគី “ខ” ជា​ទឹក​ប្រាក់ ១% (មួយ​ភាគ​រយ) ក្នុង​មួយ​ខែ​នៃ​ទឹក​ប្រាក់​ដែល​ភាគី “ខ” បាន​បង់​រួច​។</p>

  <p><span class="text-bold"><u>ប្រការ៤:</u></span> ភាគី “ក” មាន​កាតព្វ​កិច្ច​ក្នុង​ការ​ថែរក្សា​នូវ​សុវត្ថិភាព សន្តិសុខ សណ្តាប់ធ្នាប់ និង សោភ័ណ្ឌភាព ក៏​ដូច​ជា​ទ្រព្យ​សម្បត្តិ​សាធារណៈ​ផ្សេងៗ​ក្នុង​ បុរី​អ៊ីស​សីហនុ​ស៊ីធី ទាំងមូល។ បន្ទាប់​ពី ភាគី “ក” ប្រគល់​ផ្ទះ​ជូន​ទៅ​ភាគី “ខ” រួច​រាល់ ភាគី “ខ” មាន​កាតព្វ​កិច្ច​បង់​ថ្លៃ​សេវា   ចំនួន USD 180 (មួយ​រយ​ប៉ែត​សិប​ដុល្លារ​សហរដ្ឋ​អាមេរិក) ក្នុង​មួយ​ឆ្នាំ​សម្រាប់​ថ្លៃ​សេវា​សាធារណៈ​ដែល​មាន​ដូច​ជា អនាម័យ​សាធារណៈ និង​សន្តិសុខ។ ភាគី “ក” មាន​សិទ្ធិ​ក្នុង​ការ​កែ​ប្រែ​តម្លៃ​ខាង​លើ​ទៅ​តាម​តម្លៃ​ទីផ្សារ ប្រសិន​បើ​មាន​ការ​កែប្រែ ភាគី “ក” នឹង​ជូន​ដំណឹង​ជា​សាធារណៈ​រយៈ​ពេល​មួយ​ខែ​ទុក​ជា​មុន។</p>

  <p><span class="text-bold"><u>ប្រការ៥:</u></span>អំឡុង​ពេល​សាង​សង់​ភាគី “ខ” អាច​លក់​ឬ​ផ្ទេរ​កិច្ច​សន្យា​បាន ដោយ​តម្រូវ​អោយ​ស្នើរ​សុំ​ជា​ទម្រង់​លិខិត​រដ្ឋបាល និង​ត្រូវ​បង់​ថ្លៃ​សេវា​រដ្ឋបាល​ក្រុម​ហ៊ុន​ចំនួន USD 150 (មួយ​រយ​ហា​សិប​ដុល្លារ​សហរដ្ឋ​អាមេរិក) ជូន​ភាគី “ក” ។ ភាគី​ទី​បី​ដែល​ទទួល​យក​ការ​ផ្ទេរ​កិច្ច​សន្យា​ពី​ភាគី “ខ” ត្រូវ​គោរព​តាម​ខ្លឹម​សារ​ទាំង​ស្រុង​នៃ​កិច្ច​សន្យា​នេះ។</p>

  <p><span class="text-bold"><u>ប្រការ៦:</u></span> ភាគី “ក” ធានា​ចំពោះ​គុណ​ភាព​សំណង់ និង​ការ​បាក់​ស្រុត​រយៈ​ពេល ៣ (បី) ឆ្នាំ និង ធានា​ចំពោះ​ការ​ជួស​ជុល​ការ​ប្រេះ​ស្រាំ និង​លិច​ទឹក​ក្នុង​រយៈ​ពេល​១ (មួយ) ឆ្នាំ។</p>

  <p><span class="text-bold"><u>ប្រការ៧:</u></span>ភាគី “ខ” មិន​មាន​សិទ្ធិ​កែ​ប្រែ​សោ​ភ័ណ្ឌ​ភាព​សំណង់​បាន​ឡើយ លុះ​ត្រា​តែ​មាន​ការ​អនុញ្ញាត​ពី​ភាគី “ក”។</p>

  <p><span class="text-bold"><u>ប្រការ៨:</u></span> នៅពេលដែលភាគី“ខ” បាន​ទូទាត់​ប្រាក់​ជូន​ភាគី “ក” គ្រប់​ចំនួន​ដូច​ចែង​ក្នុង​ឧបសម្ព័ន្ធ​១​រួច​រាល់ ភាគី “ក” <strong>នឹង​ប្រគល់​ប្លង់​បំបែក​ក្បាល​ដី</strong> ​(មិន​ទាន់​ផ្ទេរ​កម្ម​សិទ្ធិ) ជូន​ភាគី “ខ”។</p>

  <p><span class="text-bold"><u>ប្រការ៩:</u></span> ក្នុង​ករណី​ផ្ទេរ​វិញ្ញា​បន​បត្រ​សម្គាល់​ម្ចាស់​អចលន​វត្ថុ (ប្លង់រឹង) ភាគី “ក” មាន​តួ​នា​ទី​ជួយ​សម្រួល​រៀប​ចំ​ឯក​សារ​ជូន​ភាគី “ខ” ហើយ​រាល់​ការ​ចំណាយ​លើ​សេវា​សាធារណៈ​ក្នុង​ការ​រៀប​ចំ​ឯក​សារ និង​ពន្ធ​ប្រថាប់​ត្រា ៤% ជា​បន្ទុក​របស់​ភាគី “ខ”។</p>

  <p class="mb-0 text-bold"><u>ប្រការ​១០:</u> ភារៈកិច្ចទទួលខុសត្រូវមុន និងក្រោយការទទួលផ្ទះ</p>

  <p class="ml-5"><span class="text-bold">១០.១</span>​ ភាគី “ក” ទទួល​ខុស​ត្រូវ​ទាំង​ស្រុង​លើ​ពន្ធ​អចលនទ្រព្យ ការ​បង់​ពន្ធ​ដី​មិន​ប្រើ​ប្រាស់​និង​អាជីវកម្ម​សាង​សង់​ផ្ទះ​លក់​របស់​ក្រុមហ៊ុន មុន​ពេល​ប្រគល់​ផ្ទះ។ <span class="text-bold">មុន​ពេល​ប្រគល់​ផ្ទះ</span>។</p>

  <p class="ml-5"><span class="text-bold">១០.២</span>​ បន្ទាប់ពីភាគី “ខ” ទទួលផ្ទះពីភាគី “ក” រួចរាល់ការ​បង់​ពន្ធ​លើ​អចលន​ទ្រព្យ និង​ពន្ធ​ផ្សេងៗ​ទៀត​ដែល​កំណត់​ដោយ​រដ្ឋា​ភិ​បាល​នៃ​ព្រះ​រា​ជា​ណា​ចក្រ​កម្ពុជា​ក្នុង​អំឡុង​ពេល​ភាគី “ខ” <strong>ទទួល​កាន់​កាប់​ជា​បន្ទុក​របស់ ភាគី“ខ”។</strong></p>

  <div style="page-break-after: always;"></div>

  <p><span class="text-bold"><u>ប្រការ១១:</u></span> កិច្ច​ព្រមព្រៀង​នេះ​ត្រូវ​ធ្វើ​ឡើង​ដោយ​គ្មាន​ការ​គំរាម​កំហែង បង្ខិតបង្ខំ ឬ​មាន​បញ្ហា​ខុស​ច្បាប់​ណា​មួយ​ឡើយ​ ហើយ​ត្រូវ​ចូល​ជា​ធរ​មាន​បន្ទាប់​ពី​ភាគី “ក” និង ភាគី “ខ” បាន​ផ្តិត​ស្នាម​មេ​ដៃ​ ឬ​ប្រថាប់ត្រា។ កិច្ចព្រមព្រៀង​នេះ​ធ្វើ​ឡើង​ជា​ភាសា​ខ្មែរ​ចំនួន​ពីរ​ច្បាប់​ ក្នុង​នោះ​ភាគី​ “ក” រក្សា​ទុក​មួយ​ច្បាប់​ដើម​ ភាគី “ខ” រក្សា​ទុក​មួយ​ច្បាប់​ដើម។ ច្បាប់​នីមួយៗ​មាន​អានុភាព​គតិយុត្តិ​ស្មើ​គ្នា​។​</p>

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
  
  <h4 class="main-title text-center">បុរីអ៊ីសសីហនុស៊ីធី</h4>
  <h4 class="main-title text-center mb-4">ឧបសម្ព័ន្ធ៣ : សម្ភារៈដែលបំពាក់ជូនក្នុងផ្ទះមានដូចខាងក្រោម៖</h4>
  <p><strong>១. សម្ភារៈបំពាក់ជូនក្នុងផ្ទះបាយមានដូចជា</strong></p>
  <p class="first-indent">- ធ្នើចង្ក្រានរៀបការ៉ូ (ចំនួន១)</p>
  <p class="first-indent">- ស៊ីងលាងចាន (ចំនួន១)</p>
  <p><strong>២. សម្ភារៈក្នុងបន្ទប់ទឹកមានដូចជា</strong></p>
  <p class="first-indent">- បង្គន់</p>
  <p class="first-indent">- ឡាបូលាងដៃ</p>
  <p class="first-indent">- ផ្កាឈូកងូតទឹក</p> 
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