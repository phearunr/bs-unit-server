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
    </div>
    <div class="col-auto">
      <h2 class="mb-3 main-title text-center">ព្រះរាជាណាចក្រកម្ពុជា</h2>
      <h2 class="main-title text-center">ជាតិ សាសនា ព្រះមហាក្សត្រ</h2>
    </div>
  </div>
  <h2 class="main-title text-center mb-4">កិច្ចសន្យាទិញ-លក់ក្នុង</h2>
  <h2 class="text-center english-font mb-4"><span class="" style="font-size:22pt;">Borey East Land & Home</span></h2>
  <h4 class="text-center">រវាង</h4>
  <p class="first-indent">គំរោង​លំនៅ​ដ្ឋាន ​<span class="english-font text-bold">East Land & Home</span> ដែល​មាន​ការិយាល័យ​អគារ​ក្រុម​ហ៊ុន​អគារ​លេខ <span class="english-font text-bold">B2-109, B2-110</span> សង្កាត់-ទន្លេបាសាក់ ខណ្ឌ-ចំការមន រាជធានី-ភ្នំពេញ នៃ​ក្រុម​ហ៊ុន <span class="english-font text-bold">BS Land & Home Co.,Ltd</span> តំណាង​ស្រប​ច្បាប់​ចុះ​កិច្ច​សន្យា​ទិញ​-​លក់​ដោយ​ឈ្មោះ <span class="moul-font">ប៉ែន ស្រីរ័ត្ន</span> ភេទ​ស្រី កើត​នៅ​ថ្ងៃ​ទី ២៨ ខែ ធ្នូ ឆ្នាំ ១៩៨៣ ជន​ជាតិ​ខ្មែរ​កាន់​អត្ត​សញ្ញាណ​ប័ណ្ណលេខ 010216130 (01) ចុះ​ថ្ងៃ​ទី២០ ខែតុលា ឆ្នាំ២០១៧ អា​ស័យ​ដ្ឋាន​បច្ចុប្បន្ន​ផ្ទះ​លេខ-16 ផ្លូវ-K4B ភូមិ-ទឹកថ្លា ឃុំ-សង្កាត់-ទឹកថ្លា ខណ្ឌ-សែនសុខ ខេត្ត-ក្រុង ភ្នំពេញ ។ ចាប់​ពី​ថ្ងៃ​ផ្តិត​មេ​ដៃ​ចុះ​កិច្ច​សន្យា​នេះ​ត​ទៅ​ហៅ​កាត់​ថា​ភាគី​(ក)​អ្នក​លក់។ លេខ​ទូរស័ព្ទ​ក្រុម​ហ៊ុន 012-855-821 /015-855-821 /078-224-124/097-209-647-8/ 088-5-855-821087-855-821</p>

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
    <li>ឧបសម្ព័ន្ធ២ : ប្លង់ទីតាំងផ្ទះក្នុង <span class="english-font text-bold">Borey East Land & Home</span></li>
    <li>ឧបសម្ព័ន្ធ៣ : សម្ភារៈដែលបំពាក់ក្នុងគេហដ្ឋាន</li>
    <li>ឧបសម្ព័ន្ធ៤ : អត្តសញ្ញាណប័ណ្ណ អ្នកទិញ និង អ្នកលក់</li>
    <li>ឧបសម្ព័ន្ធ៥ : លិខិតប្រគល់សិទ្ធឈរតំណាងក្រុមហ៊ុន</li>
  </ul>

  <p class="text-bold text-center"​ style="text-align: center !important;">ដោយផ្អែកលើគោលការណ៍ស្ម័គ្រចិត្ត និងស្មើភាព ភាគី “ក” និង ភាគី “ខ” បានព្រមព្រៀងគ្នាដូចតទៅ ៖</p>

  <p class="mb-0 text-bold"><u>ប្រការ១: កម្មវត្ថុនៃការទិញ-លក់ និងតម្លៃ</u></p>
  <p>ភាគី “ក” យល់ព្រមលក់ហើយភាគី “ខ” យល់ព្រមទិញផ្ទះល្វែងមួយខ្នងដែលមាន អស័យ​ដ្ឋាន​ផ្ទះលេខ {{$unit['house_no']}} ផ្លូវបេតុងទំហំ ????? ក្នុងតម្លៃ USD {{$unit['price']}} ({{$unit['price_khmer_word']}}) នៅ​ក្នុង Borey East Land & Home ដែល​មានទី​តាំង​នៅ​ភូមិ​ដូន​ហែម ឃុំ​ព្រែក​អំពិល ស្រុក​ខ្សាច់កណ្តាល ខេត្ត​កណ្តាល។ តម្លៃ​នេះ​ជា​តម្លៃ​ដែល​មាន​បំពាក់​សម្ភារៈ​ប្រើ​ប្រាស់ដូច​មាន​ក្នុង​ឧបសម្ព័ន្ធ៣។</p>
  <p>ផ្ទះល្វែងប្រភេទ {{ $unit['type'] }} មានទំហំដូចខាងក្រោម៖</p>
  <table class="table table-borderless mb-0 pb-0" width="100%">
    <tr>
      <td width="50%">
        <p class="mb-0">1. ទំហំដី</p>
        <ul>
          <li>ទទឹង <span class="text-bold">{{ $unit['land_width'] }}</span> ម៉ែត្រ</li>
          <li>បណ្តោយ <span class="text-bold">{{ $unit['land_length'] }}</span> ម៉ែត្រ</li>
        </ul>
      </td>
      <td width="50%">
        <p class="mb-0">2. ទំហំផ្ទះ</p>
        <ul>
          <li>ទទឹង <span class="text-bold">{{ $unit['house_width'] }}</span> ម៉ែត្រ</li>
          <li>បណ្តោយ <span class="text-bold">{{ $unit['house_length'] }}</span> ម៉ែត្រ</li>
        </ul>
      </td>
    </tr>
  </table>
  <p>ដែល​មាន​បន្ទប់​ទទួល​ភ្ញៀវ​ចំនួន០១ ផ្ទះបាយ០១ បន្ទប់គេង០២ និងបន្ទប់ទឹក០២ (តាម​ប្លង់​បាត​ដែរ​ភ្ជាប់​ជូន)។</p>

  <p class="mb-0"><span class="text-bold"><u>ប្រការ២:</u></span> ភាគី “ខ” កាលបរិច្ឆេទនៃការទូទាត់ប្រាក់</p>
  <p>២.១ ភាគី “ខ” ត្រូវ​ទូ​ទាត់​ប្រាក់​សរុប​ថ្លៃ​ទិញ​ផ្ទះ​តាម​ដំណាក់​កាល​ជា​បន្ត​បន្ទាប់​ដូច​មាន 
  ចែង​ក្នុង​តារាង​ទូ​ទាត់​ប្រាក់​ក្នុង​ឧបសម្ព័ន្ធ១។</p>
  <p>២.២ ក្នុង​ករណី​ដែល​ភាគី “ខ” យឺត​យ៉ាវ ឬ​ខក​ខាន​មិន​បាន​បង់​ប្រាក់​តាម​កាល​កំណត់​ក្នុង ឧបសម្ព័ន្ធ១ នោះ​ទេ​ភាគី “ខ” ត្រូវ​បង់​ប្រាក់​ពិន័យ​ក្នុង​អត្រា 1.2% (មួយ​ក្បៀស​ពីរ​ភាគរយ) នៃ​ទឹក​ប្រាក់​ត្រូវ​បង់​ក្នុង១ខែ។ ករណី​ការ​យឺត​យ៉ាវ​ និង​ខក​ខាន​លើស​ពី៣ខែ​នោះ​ចាត់​ទុក​ថា​ភា​គី “ខ” បាន​បោះ​បង់​ចោល​ការ​ទិញ​ផ្ទះ​នេះ​ជា​ឯក​តោ​ភាគី។ ក្នុង​ករណី​នេះ​ភាគី “ក” មាន​សិទ្ធិ​លក់​ផ្ទះ​ឲ្យ​ទៅ​អ្នក​ផ្សេង​ទៀត​បាន​ហើយ​ប្រាក់​ដែលបាន​បង់​នៃ​ដំណាក់​កាល​នីមួយៗ​ចាត់​ទុក​ជា​អ​សារ​បង់។</p>
  
  <p><span class="text-bold"><u>ប្រការ៣:</u></span> ភាគី “ក” សន្យា​ប្រគល់​ផ្ទះ​នៅ​ក្នុង​អំឡុង​ពេល​២៤ខែ​ និង​អនុ​គ្រោះ​៦ខែ​បន្ដ​បន្ទាប់​ពី​ថ្ងៃចុះ​កិច្ច​សន្យា​នឹង​ប្រគល់​ផ្ទះលេខ {{ $unit['house_no'] }} ជូន​ទៅ​ភាគី “ខ”។ ករណី​ការ​សន្យា​មិន រួច​រាល់​តាម​ការ​កំណត់​ភាគី “ក” សន្យា​និង​សង​សំណង​ជូន​ភាគី “ខ”​ គុណ​នឹង​មួយ​ភាគរយ​នៃ​ទឹក​ប្រាក់​សរុប​ដែរ​ភាគី “ខ” បាន​បង់​ចូល​ក្រុមហ៊ុន​ជាក់​ស្ដែង។</p>

  <p><span class="text-bold"><u>ប្រការ៤:</u></span> អំឡុង​ពេល​សាងសង់​ភាគី “ខ” អាច​លក់​ ឬ ផ្ទេរ​កិច្ចសន្យា​បាន​បន្ទាប់​ពី​ស្នើ​សុំ​ហើយ ទទួល​បាន​ឯកភាព​ជា​លាយលក្ខណ៍​អក្សរ​ពីភាគី “ក” ដោយ​ភាគី “ខ” ត្រូវ​បង់​ថ្លៃ​សេវារ​រដ្ឋបាល​ក្រុមហ៊ុន​ចំនួន USD ១៥០ (មួយ​រយ​ហា​សិប​ដុល្លា​អាមេរិក) ជូនភាគី“ក”។  ភាគី​ទី​បី​ដែល​ទទួល​យក​ការ​ផ្ទេរ​កិច្ចសន្យា​ភាគី “ខ” ត្រូវ​គោរព​តាម​ខ្លឹមសារ​ទាំង​ស្រុង​នៃ​កិច្ច​ព្រម​ព្រៀង​នេះ។</p>

  <p><span class="text-bold"><u>ប្រការ៥:</u></span> ភាគី “ក” មាន​កាតព្វ​កិច្ច​ក្នុង​ការ​ថែ​រក្សា​នូវ​សុវត្ថិភាព សន្តិសុខ សណ្តាប់ធ្នាប់ សោភ័ណ្ឌ ភាព ទ្រព្យ​សម្បត្តិ​សាធារណៈ​ផ្សេងៗ​ក្នុង Borey East Land & Home ទាំង​មូល។ បន្ទាប់​ពី​ភាគី “ក” ប្រគល់​ផ្ទះ​ជូន​ទៅ​ភាគី “ខ” រួច​ភាគី “ខ” មាន​កាតព្វ​កិច្ច​បង់​ថ្លៃ សេវា​ចំនួន​ USD 240 (ពីរ​រយ​សែ​សិប​ដុល្លា​អាមេរិក) ក្នុង១ឆ្នាំ​លើ​ផ្នែក​សេវា​ដែល​មាន​ដូច​ជា​អនាម័យ​សាធារណៈ ភ្លើង​បំភ្លឺ​ផ្លូវ និង​សន្តិ​សុខ ២៤ ម៉ោង។ ភាគី “ក” មាន សិទ្ធិ​ក្នុងការ​កែ​ប្រែ​តម្លៃ​ខាង​លើទៅ​តាម​តម្លៃ​ទី​ផ្សារ​ប្រសិន​បើ​មាន​ការ​កែ​ប្រែ​ភា​គី “ក” នឹង​ជូន​ដំណឹងជា សា​ធារណៈ​រយៈ​ពេល​១ខែ​ទុក​ជា​មុន​។</p>

  <p><span class="text-bold"><u>ប្រការ៦:</u></span> ភាគី “ក” ធានា​ចំពោះ​គុណ​ភាព​សំណង់​និង​ការ​បាក់​ស្រុត​រយៈ​ពេល ៣ (បី) ឆ្នាំ និង ធានា​ចំពោះ​ការ​ជួស​ជុល​ការ​ប្រេះ​ស្រាំ និង​លិច​ទឹក​ក្នុង​រយៈ​ពេល ១ (មួយ) ឆ្នាំ។</p>
  
  <p><span class="text-bold"><u>ប្រការ៧:</u></span> ភាគី “ខ” មិន​មាន​សិទ្ធិ​កែ​ប្រែ​សោ​ភ័ណ្ឌភាព​សំណង់​បាន​ឡើយ​លុះ​ត្រា​តែ​មាន​ការអនុ​ញ្ញាត​ពី​ភា​គី “ក”។</p>

  <p><span class="text-bold"><u>ប្រការ៨:</u></span> ពេលដែលភាគី “ខ” បាន​ទូ​ទាត់​ប្រាក់​ជូន​ភាគី “ក” គ្រប់ចំនួន ១០០% ភាគី “ក” មាន​កាតព្វ​កិច្ច​រៀប​ចំឯក​សារ​ផ្ទេរ​វិញ្ញា​ប័ណ្ណ​ប័ត្រ​សម្គាល់​ម្ចាស់​អចលន​វត្ថុ​(ប្លង់​រឹង)​ជូន​ភាគី “ខ” សោ​ហ៊ុយ​រាល់​ការ​ចំណាយ​គឺ​ជា​បន្ទុក​របស់​ភាគី “ខ” ទាំង​ស្រុង​រួម​ទាំង​ពន្ធ​ផ្ទេរ​សិទ្ធិ​សេវា​កម្ម​រត់​ឯក​សា​ និង​ពន្ធ​ផ្សេងៗ​ដែលមាន។</p>

  <p><span class="text-bold"><u>ប្រការ៩:</u></span> កិច្ច​ព្រម​ព្រៀង​នេះ​ត្រូវ​ធ្វើ​ឡើង​ដោយ​គ្មាន​ការ​គំរាម​កំហែង បង្ខិត​បង្ខំ ឬ​មាន​បញ្ហា ខុស​ច្បាប់​ណា​មួយ​ឡើយ​ហើយ​ត្រូវ​ចូល​ជា​ធរមាន​បន្ទាប់​ពីភាគី “ក” និងភាគី “ខ” បាន​ផ្តិត​ស្នាម​មេ​ដៃ​ឬ​ប្រថាប់​ត្រា។ កិច្ច​ព្រម​ព្រៀង​នេះ​ធ្វើ​ឡើង​ជា​ភាសា​ខ្មែរ​ចំនួន ២ ច្បាប់​ក្នុង​នោះ​ភាគី “ក” រក្សា​ទុក១ច្បាប់​ដើម​ភាគី “ខ” រក្សា​ទុក១ច្បាប់​ដើម​ច្បាប់​នីមួយៗ មាន​អានុ​ភាព​គតិ​យុត្តិ​ស្មើ​គ្នា​។</p>

  @if(isset($customer2))
  <div style="page-break-after: always;"></div>
  @endif

  <p style="text-align: right;margin-top:30px;">រាជធានីភ្នំពេញ ថ្ងៃទី........ ខែ........ ឆ្នាំ២០........</p>

  <table class="mb-0" style="text-align: center; width: 100%;">
    <tr>
      <td><p class="text-center">ស្នាមមេដៃស្ដាំ ភាគី(ក)</p></td>
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

  <p class="moul-font text-bold mt-3">ចម្លងជូនៈ</p>
  <p class="mb-0" style="text-align: left;">- <span class="moul-font">ភាគី(ក)</span> អ្នកលក់ រក្សាច្បាប់ដើមទុកចំនួន០១ច្បាប់</p>
  <p class="mb-0" style="text-align: left;">- <span class="moul-font">ភាគី(ខ)</span> អ្នកទិញ រក្សាច្បាប់ដើមទុកចំនួន០១ច្បាប់</p>
  <div style="page-break-after: always;"></div>
  
  @include('admin.contract.template.payment_template', ['contract' => $contract])

  <h4 class="main-title text-center">បុរី East Land & Home</h4>
  <h4 class="main-title text-center">ឧបសម្ព័ន្ធ៣</h4>
  <p class="text-lg text-center">សម្ភារៈដែលបូកបញ្ចូលក្នុងផ្ទះមានដូចខាងក្រោម</p>
  <p class="text-lg text-center mb-4">ឧបសម្ព័ន្ធផ្ទះប្រភេទ {{ $unit['type'] }}</p>
  <p class="text-lg text-bold">១. សម្ភារៈក្នុងផ្ទះបាយមានដូចជា</p>
  <p class="second-indent text-left">- ធ្នើចង្រ្កានរៀបការ៉ូ ចំនួន ០១</p>
  <p class="second-indent text-left">- ស៊ីងលាងចាន ចំនួន ០១</p>
  <p class="text-lg text-bold">២. សម្ភារៈក្នុងបន្ទប់ទឹកមានដូចជា</p>  
  <p class="second-indent text-left">- បង្គន់</p>
  <p class="second-indent text-left">- ឡាបូលាងដៃ</p>
  <p class="second-indent text-left">- ទឹកផ្កាឈូក</p>
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