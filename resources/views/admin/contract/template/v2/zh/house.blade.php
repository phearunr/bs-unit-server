@extends('admin.contract.template.v2.zh.template')
@section('page_title', "Contract $contract->customer1_name")
@section('contract_type')
<h3 class="khmer-title text-center mt-3 mb-3">កិច្ចសន្យាលក់ ទិញផ្ទះក្នុងគម្រោង {{ $project->name }}</h3>
<h3 class="zh text-center mt-3 mb-3">里的房屋购销合同 {{ $project->name_zh }}</h3>
@endsection

@section('praka')
<p class="khmer-title pb-0 mb-0">ប្រការ១៖ អត្តសញ្ញាណនៃអចលនវត្ថុលក់ទិញ និងតម្លៃលក់ទិញ</p>
<p class="zh pb-0 mb-0 text-bold">第1条：购销不动产的身份及购销价</p>
<p class="khmer pb-0 mb-0"><span class="khmer text-bold">១.១.</span> ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> គឺ​ជា​កម្មសិទ្ធិករ​ស្រប​ច្បាប់​លើ​អចលនវត្ថុ យល់​ព្រម​លក់ ហើយ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> យល់​ព្រម​ទិញ​នូវ​អចលនវត្ថុ​ដូច​មាន​ចែង​ក្នុង​តារាង​អត្តសញ្ញាណ​នៃ​អចលនវត្ថុ​លក់ទិញ និង​តម្លៃ​លក់​ទិញ​នេះ។</p>

<p class="zh pb-0 mb-0"><span class="text-bold">1.1．“出售”</span>方为不动产的合法所有者并同意出售，且<span class="text-bold">“购买”</span>方同意购买在该购销不动产身份及购销价表里的不动产。</p>

<p class="khmer pb-0 mb-0"><span class="khmer text-bold">១.២.</span> តារាងអត្តសញ្ញាណនៃអចលនវត្ថុលក់ទិញ និងតម្លៃលក់ទិញ (“អចលនវត្ថុ”)៖</p>
<p class="zh"><span class="text-bold">1.2</span> 购销不动产身份及购销价表<span class="text-bold">（“不动产”）</span>：</p>
<table class="table table-p-1 table-contract-bordered">
    <tr>
        <td width="180px" class="text-bold">
            <p class="khmer pb-0">ប្រភេទ</p>
            <p class="zh pb-0">种类</p>
        </td>
        <td width="30px" class="text-center">:</td>      
        <td>
            <p class="english text-bold pb-0">{{ $unit_type->name }}</p>
        </td>
        <td width="100px" class="text-bold">
            <p class="khmer pb-0">លេខ</p>
            <p class="zh pb-0">号码</p>
        </td>
        <td width="30px" class="text-center">:</td>
        <td width="250px" class="english text-bold">
            <p class="english pb-0">{{ isset($is_template) ? '_______________' : $unit->code }}</p>
        </td>
    </tr>
    <tr>
        <td width="180px" class="text-bold">
            <p class="khmer pb-0">ទំហំសំណង់</p>
            <p class="zh pb-0">建筑面积</p>
        </td>
        <td width="30px" class="text-center">:</td>      
        <td>
            <p class="khmer pb-0">
            @if( isset($is_template) )
                _______________
            @else             
                    @if($unit->building_size_width)
                    ទទឹង {{ $unit->building_size_width_km }} ម៉្រែត និង បណ្តោយ {{ $unit->building_size_length_km }} ម៉្រែត
                    @else
                    សុរប {{ $unit->building_area_km }} ម៉ែត្រការ៉េ
                    @endif              
            @endif
            </p>
        </td>
        <td width="100px" class="text-bold">
            <p class="khmer pb-0">ទំហំដី</p>
            <p class="zh pb-0">土地面积</p>
        </td>
        <td width="30px" class="text-center">:</td>
        <td width="250px">
            <p class="pb-0">
            @if( isset($is_template) )
                <p class="khmer pb-0">_______________</p>              
            @else
                <p class="khmer pb-0">
                    @if( $unit->land_size_width AND $unit->land_size_length )
                    ទទឹង {{ $unit->land_size_width_km }} ម៉្រែត និង បណ្តោយ {{ $unit->land_size_length_km }} ម៉្រែត
                    @else
                    សុរប {{ $unit->land_area_km }} ម៉ែត្រការ៉េ
                    @endif
                </p>               
            @endif
            </p>
            <p class="pb-0"><small><i class="khmer">(ដែល​អាច​មាន​ការ​ប្រែប្រួល​បន្តិច​បន្ទួច ជា​លក្ខណៈ​បច្ចេកទេស អាស្រ័យ​លើ​ការ​កំណត់​ព្រុំ​របស់​មន្ត្រី​សុរិយោដី)</i></small></p>
            <p class="zh pb-0"><small><i>(技术性的差异在3平方米，超过或缺少须依照地籍官员所规定的界线，双方将不互相索求赔偿。)</i></small></p>
        </td>
    </tr>
    <tr>
        <td width="180px" class="text-bold">
            <p class="khmer pb-0">ទីតាំងគម្រោង</p>
            <p class="zh pb-0">项目地点</p>
        </td>
        <td width="30px" class="text-center">:</td>      
        <td colspan="4">
            <p class="khmer pb-0">{{ $project->address }}</p>
            <p class="zh pb-0">{{ $project->address_zh }}</p>
        </td>
    </tr>
    <tr>
        <td width="180px" class="text-bold">
            <p class="khmer pb-0">សេវា និងថ្លៃគ្រប់គ្រងថែទាំ</p>
            <p class="zh pb-0">服务及管理保养费</p>
        </td>
        <td width="30px" class="text-center">:</td>      
        <td colspan="4">
            <p class="khmer pb-0">
                {{
                \App\Helpers\NumberFormat::convertToKhmerNumber(number_format($contract->annual_management_fee)) 
                }} 
                ({{
                \App\Helpers\NumberFormat::covertUsdToKhmerWord($contract->annual_management_fee, false) 
                }}) ដុល្លារអាមេរិកក្នុងមួយឆ្នាំ
            </p>
            <p class="zh pb-0">
                一年 {{ number_format($contract->annual_management_fee,0) }}
                ({{ numfmt_create('zh', \NumberFormatter::SPELLOUT)->format($contract->annual_management_fee) }}) 美元
            </p>
            <p class="pb-0"><small><i class="khmer">ដោយត្រូវបង់សរុបមួយឆ្នាំម្តងៗ ដូចមានចែងលម្អិតក្នុងប្រការ ៦ នៃកិច្ចសន្យានេះ។</i></small></p>
            <p class="zh pb-0"><small><i>须按照本合同第6条所载一年一次性支付。</i></small></p>
        </td>
    </tr>
    <tr>
        <td width="180px" class="text-bold">
            <p class="khmer pb-0">ការផ្តល់ជូនសេវាបន្ថែម</p>
            <p class="zh pb-0">额外服务的提供</p>
        </td>
        <td width="30px" class="text-center">:</td>      
        <td colspan="4">
            <p class="khmer pb-0">{{ $contract->management_service_kh }}</p>
            <p class="zh pb-0">{{ $contract->management_service_zh }}</p>
        </td>
    </tr>
    <tr>
        <td width="180px" class="text-bold">
            <p class="khmer pb-0">ប្រភេទ​នៃ​ប័ណ្ណ​កម្មសិទ្ធិ​ដែល​ប្រគល់​ជូន​ភាគី “អ្នកទិញ”</p>
            <p class="zh pb-0">交纳给“购买”方的产权证的种类</p>
        </td>
        <td width="30px" class="text-center">:</td>      
        <td colspan="4">
            <p class="khmer pb-0">{{ $contract->title_clause_kh }}</p>
            <p class="zh pb-0">{{ $contract->title_clause_zh }}</p>
        </td>
    </tr>
    <tr>
        <td width="180px" class="text-bold">
            <p class="khmer pb-0">បន្ទប់គេង</p>
            <p class="zh pb-0">卧室</p>
        </td>
        <td width="30px" class="text-center">:</td>      
        <td>
            <p class="english pb-0">{{ $unit->bedroom ?? 'N/A' }}</p>
        </td>
        <td width="100px" class="text-bold">
            <p class="khmer pb-0">ផ្ទះបាយ</p>
            <p class="zh pb-0">厨房</p>
        </td>
        <td width="30px" class="text-center">:</td>
        <td width="250px">
            <p class="english pb-0">{{ $unit->kitchen ?? 'N/A' }}</p>
        </td>
    </tr>
    <tr>
        <td width="180px" class="text-bold">
            <p class="khmer pb-0">បន្ទប់ទឹក</p>
            <p class="zh pb-0">卫生间</p>
        </td>
        <td width="30px" class="text-center">:</td>      
        <td>
            <p class="english pb-0">{{ $unit->bathroom ?? 'N/A' }}</p>
        </td>
        <td width="100px" class="text-bold">
            <p class="khmer pb-0">បន្ទប់ទទួលភ្ញៀវ</p>
            <p class="zh pb-0">客厅</p>
        </td>
        <td width="30px" class="text-center">:</td>
        <td width="250px">
            <p class="english pb-0">{{ $unit->living_room ?? 'N/A' }}</p>
        </td>
    </tr>
    @if( $unit->swimming_pool )
    <tr>
        <td width="180px" class="text-bold">
            <p class="khmer pb-0">អាងហែលទឹក</p>
            <p class="zh pb-0">游泳馆</p>
        </td>
        <td width="30px" class="text-center">:</td>
        <td colspan="4">
            <p class="english pb-0">{{ $unit->swimming_pool ?? 'N/A' }}</p>
        </td>
    </tr>
    @endif
    <tr>
        <td width="180px" class="text-bold">
            <p class="khmer pb-0">តម្លៃលក់ទិញ</p>
            <p class="zh pb-0">购销价</p>
        </td>
        <td width="30px" class="text-center">:</td>
        <td class="text-bold" colspan="4">
            <p class="khmer pb-0">
                @if( isset($is_template) )
                    _______________ ( _______________ ) 
                @else
                {{ $contract->unit_sale_price_after_discount_km }} ({{ $contract->unit_sale_price_after_discount_in_word_km }}) ដុល្លារ​​​អាមេរិច
                @endif
            </p>
            <p class="zh pb-0">
                @if( isset($is_template) )
                    _______________ ( _______________ ) 
                @else
                {{ $contract->unit_sale_price_after_discount_zh }} ({{ $contract->unit_sale_price_after_discount_in_word_zh }}) 美元
                @endif
            </p>
        </td>    
    </tr>
</table>

<p class="khmer-title pb-0 mb-0">ប្រការ២៖ ការទូទាត់ប្រាក់ថ្លៃលក់ទិញអចលនវត្ថុ</p>
<p class="zh pb-0 mb-0 text-bold">第2条：不动产购销价款的结算</p>
<p class="khmer pb-0 mb-0"><span class="khmer text-bold">២.១.</span> ដោយ​មាន​ការ​ព្រមព្រៀង​គ្នា​ក្នុង​ការ​លក់​ទិញ នូវ​អចលនវត្ថុ​ដូច​បាន​ចែង​ក្នុង​ <span class="khmer text-bold">ប្រការ១ “អត្តសញ្ញាណ​នៃ​អចលនវត្ថុ​លក់​ទិញ និងតម្លៃ​លក់​ទិញ”</span> ខាងលើ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ត្រូវ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ខាង​លើ​ទៅ​តាម​ដំណាក់កាល​នៃ​ការ​ទូទាត់​ឲ្យ​បាន​ត្រឹមត្រូវ គ្រប់​ចំនួន​ និង​ទាន់​ពេល​វេលា​ជា​បន្ត​បន្ទាប់​ដូច​បាន​ចែង​ក្នុង​ឧបសម្ព័ន្ធទី១ <span class="khmer text-bold">“តារាងកាលវិភាគ​នៃ​ការ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ”</span>។ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> អាច​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ដោយ​ផ្ទាល់​នៅ​ការិយាល័យ​របស់​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ឬ​តាម​រយៈ​គណនី​ធនាគារ <span class="khmer text-bold">{{ $bank->short_name }}</span> ដូច​មាន​ព័ត៌មាន​លម្អិត​ខាង​ក្រោមនេះ៖</p>
<p><span class="text-bold">2.1</span> 因有着上述第1条<span class="text-bold">“购销不动产的身份及购销价”</span>里所载的不动产的购销的协议一致，<span class="text-bold">“购买”</span>方须根据附件1“不动产购销价款的结算时间表”以正确、全额及准时按照结算阶段支付上述不动产购销价款。<span class="text-bold">“购买”</span>方可直接到<span class="text-bold">“出售”</span>方的办公室里结算不动产购销款项或通过以下信息的ABA银行的账户：</p>

<div class="row">
    <div class="col-8 offset-2 mb-3">
        <table class="table table-p-1 table-bordered ">
            <tr>
                <th>
                    <p class="khmer pb-0 text-center">ឈ្មោះគណនីធនាគារ</p>
                    <p class="zh pb-0 text-center">银行账户名称</p>
                </th>
                <th>
                    <p class="khmer pb-0 text-center">លេខគណនីធនាគារ</p>
                    <p class="zh pb-0 text-center">银行账户号码</p>
                </th>
            </tr>   
            <tr>
                <td class="text-center">{{ $bank->account_name }}</td>
                <td class="text-center">{{ $bank->account_number }}</td>
            </tr>
        </table>
    </div>
</div>

<p class="khmer"><span class="khmer text-bold">២.២.</span> ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> អនុគ្រោះ​ជូនភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ក្នុង​ការ​យឺតយ៉ាវ ឬ​ខក​ខាន​ទូទាត់​ប្រាក់ថ្លៃ​លក់ទិញ​អចលនវត្ថុ​ត្រឹមរយៈពេល <span class="khmer text-bold">០៧ (ប្រាំពីរ) ថ្ងៃប្រតិទិន</span> ដោយ​មិន​បង់​ប្រាក់​ពិន័យ។ ផុត​ពី​រយៈ​ពេល​អនុគ្រោះ​នេះ ក្នុង​ករណី​ដែល​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> យឺតយ៉ាវ ឬ​ខកខាន​មិន​បាន​បំពេញ​កាតព្វកិច្ច​ទូទាត់​បង់ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ជូន​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ទៅ​តាម​ដំណាក់​កាល​នៃ​ការ​ទូទាត់​ឲ្យ​បាន​ត្រឹមត្រូវ គ្រប់ចំនួន និង​ទាន់​ពេល​វេលា​ទេ​នោះ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ត្រូវ​បង់​ប្រាក់​ពិន័យ​លើ​ការ​យឺតយ៉ាវ ឬ​ខក​ខាន​នោះ​ក្នុង​មួយថ្ងៃ <span class="khmer text-bold">០៥ (ប្រាំ) ដុល្លារ​អាមេរិក</span>។ ក្នុង​ករណី​ដែល​ការ​យឺតយ៉ាវ ឬ​ខក​ខាន​ក្នុង​ការ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​នោះ​នៅ​តែ​បន្ត​លើសពី រយៈពេល <span class="khmer text-bold">០២ (ពីរ) ខែ</span>​ជាប់ៗ​គ្នា ឬ​ក្នុង​ចន្លោះ​រយៈ​ពេល​ណា​មួយ​ដែល​ផល​បូក​នៃ​រយៈ​ពេល​ទាំង​នោះ​លើស​ពី <span class="khmer text-bold">០២ (ពីរ) ខែ</span> នោះ​ត្រូវ​បាន​សន្មត់ទុក​ជា​មុន និង​ចាត់​ទុក​ថា ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> រំលាយ​កិច្ចសន្យា​ដោយ​ឯកតោ​ភាគី ដោយ​បោះបង់​ចោល​នូវ​សិទ្ធិ​ទាំង​ឡាយ​ដែល​មាន​លើអចលនវត្ថុ ការ​លក់​ទិញ​អចលនវត្ថុ និង​ចំនួន​ទឹក​ប្រាក់​ដែល​ខ្លួន​បាន​ទូទាត់​មក​ឲ្យ​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span>។ ក្នុង​ករណី​នេះ ទឹក​ប្រាក់​ដែល​បាន​ទូទាត់​ហើយ​ទាំងអស់​ត្រូវ​ក្លាយ​ជា​ប្រយោជន៍​សម្រាប់​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ហើយ ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> មាន​សិទ្ធិ​ពេញ​លេញ​ដោយ​ស្រប​ច្បាប់​ក្នុង​ការ​លក់​អចលនវត្ថុ​ខាង​លើ​ឲ្យ​ទៅ​អតិថិជន ឬ​អ្នក​ទិញ​ផ្សេង​ទៀត​បាន ដោយ​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> សន្យា​ថា​នឹង​មិន​តវ៉ា ឬ​ជំទាស់​ឡើយ។ ក្នុង​ករណី​នេះ ប្រសិន​បើ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> បាន​ទទួល​យក​អចលនវត្ថុ​ពី ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ហើយនោះ ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ទុក​រយៈ​ពេល​ឲ្យ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ដែល​បោះបង់​សិទ្ធិ​លើ​ការ​លក់​ទិញ និង​អចលនវត្ថុ​នោះ <span class="khmer text-bold">០១ (មួយ) ខែ</span> សម្រាប់​រើចេញ​ពី​អចលនវត្ថុ។</p>
<p class="text-left"><span class="text-bold">2.2</span> 若<span class="text-bold">“购买”</span>方延迟或耽误结算不动产购销价款<span class="text-bold">“出售”</span>方将赦免07（七）天日历，其不必支付罚款。逾期该赦免，若<span class="text-bold">“购买”</span>方延迟或耽误没能执行义务以正确、全额及准时按照结算阶段结算不动产购销价款给<span class="text-bold">“出售”</span>方，则<span class="text-bold">“购买”</span>方须支付该延迟或耽误每天05（五）美元的罚款。若该不动产购销价款的支付仍然延迟或耽误连续超过02（二）个月或在任何期限内逾期相加超过02(二)个月，将被预估及视为<span class="text-bold">“购买”</span>方单方解除合同，其放弃不动产上的全权、不动产的购销及自己已支付给<span class="text-bold">“出售”</span>方的款项。此情况，已支付的全部款项将成为<span class="text-bold">“出售”</span>方的利益，<span class="text-bold">“出售”</span>方有合法全权出售上述不动产给第三者或其他购买者，<span class="text-bold">“购买”</span>方承诺不做出任何抗议或反抗。此情况，若<span class="text-bold">“购买”</span>者已从<span class="text-bold">“出售”</span>者接受不动产，则<span class="text-bold">“出售”</span>方将保留01（一）个月时间给放弃购销及不动产权利的<span class="text-bold">“购买”</span>方以便搬出不动产。</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៣៖ ការលក់ ឬផ្ទេរសិទ្ធិលើការលក់ទិញអចលនវត្ថុបន្តទៅតតិយជន និងឥណទានពីធនាគារ</p>
<p class="zh pb-0 mb-0 text-bold">第3条：出售或转让不动产购销权利给第三者或向银行贷款</p>
<p class="khmer"><span class="khmer text-bold">៣.១.</span> ក្នុង​កំឡុង​ពេល​នៃ​ការ​អនុវត្ត​កិច្ចសន្យា​លក់​ទិញ​នេះ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> អាច​លក់ ឬ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ​អចលនវត្ថុ​ទៅ​ តតិយជន​ណា​មួយ​បាន​ដោយ​ការ​ស្នើ​សុំ​ជា​លាយ​លក្ខណ៍​អក្សរ ហើយ​ទទួល​បាន​ការ​អនុញ្ញាត​យល់​ព្រម​ពី​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ដោយភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ត្រូវ​បង់​ថ្លៃ​សេវា​រដ្ឋបាល​លើ​ការ​លក់ ឬ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ អចលនវត្ថុ​នេះ​ស្មើ​នឹង <span class="khmer text-bold">{{ $contract->contract_transfer_fee_km }} ({{ $contract->contract_transfer_fee_in_word_km }}) ដុល្លារ​អាមេរិក</span> ជូន​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span>។ មុន​នឹង​អាច​លក់ ឬ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ​អចលនវត្ថុ​ទៅ​តតិយជន​ណា​មួយ​បាន ប្រសិន​បើ​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> យឺតយ៉ាវ ឬ​ខក​ខន​មិន​បាន​បំពេញ​កាតព្វកិច្ច​ទូទាត់​បង់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ជូន​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ទៅ​តាម​ដំណាក់​កាល​នៃ​ការ​ទូទាត់​ឲ្យ​បាន​ត្រឹមត្រូវ គ្រប់ចំនួន និងទាន់​ពេល​វេលា​ដូច​ចែង​ក្នុង​ <span class="khmer text-bold">ប្រការ២</span> នោះ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ត្រូវ​ទូទាត់​ប្រាក់​ដែល​នៅ​ជំពាក់ និង​ប្រាក់​ពិន័យ​លើ​ការ​យឺត​យ៉ាវ ឬ​ខក​ខាន​នោះ​ឲ្យ​រួច​រាល់​ជា​មុន​សិន។ តតិយជន​ដែល​ទទួល​ទិញ ឬ​ទទួល​ការ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ​អចលនវត្ថុ​នេះ ត្រូវ​គោរព​តាម​ទាំង​ស្រុង​នូវ​ខ្លឹម​សារ​នៃ​កិច្ចសន្យា​លក់​ទិញ​នេះ ហើយ​អនុវត្ត​តាម​បែប​បទ​រដ្ឋបាល​មួយ​ចំនួន​ដែល​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> តម្រូវ។</p>
<p class="text-left"><span class="text-bold">3.1</span> 履行本购销合同期间，<span class="text-bold">“购买”</span>方可出售或转让不动产购销权利给任何第三者，但须以书面申请并获得<span class="text-bold">“出售”</span>方的同意批准，且在可以出售或转让不动产购销权利给任何第三者之前，<span class="text-bold">“购买”</span>方须支付出售或转让该不动产购销权利上的行政服务费相当于300（叁佰）美元给<span class="text-bold">“出售”</span>方。若 <span class="text-bold">“购买”</span>方延迟或耽误没能按照第2条所载执行义务以正确、全额及准时按照结算阶段结算不动产购销价款给<span class="text-bold">“出售”</span>方，则<span class="text-bold">“购买”</span>方须事先付清还欠的款项以及延迟或耽误的罚款。购买的第三者或该不动产购销的受权者须遵从本购销合同的全部内容并按照<span class="text-bold">“出售”</span>方的要求执行一些行政手续。</p>

<p class="khmer"><span class="khmer text-bold">៣.២.</span> ចំពោះ​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ដែល​ជ្រើស​រើស​ជម្រើស​បង់រម្លស់ <span class="english">(Loan)</span> ដែល​ភ្ជាប់​នឹង​អត្រា​ការ​ប្រាក់​ជាមួយ​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> នៅ​ពេល​ដែល​សំណង់​អចលនវត្ថុ​សាងសង់​បាន​ចាប់ពី៧០% (ចិតសិបភាគរយ) ឡើង​ទៅ ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> សូម​រក្សា​សិទ្ធិ​ក្នុង​ការ​ចាត់​ចែង​បញ្ជូន​សិទ្ធិ​លើ​បំណុល​ដែល​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> មាន​ដោយ​ការ​បង់​រម្លស់​ជាមួយ ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ឲ្យ​ទៅ​ធនាគារ​ណា​មួយ​ដែល​សហការ​ជាមួយ​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ហើយ​សេវា​ក្នុង​ការ​សិក្សា​ជា​មួយ​ធនាគារ​ទាំងនោះ គឺ​ជា​បន្ទុក​របស់​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span>។</p>
<p class="text-left"><span class="text-bold">3.2</span> 对于支付利息给<span class="text-bold">“出售”</span>方的选择分期付款(loan)的<span class="text-bold">“购买”</span>方，当不动产工程建设超过70%（百分之七十）以上，<span class="text-bold">“出售”</span>方保留权利安排发送<span class="text-bold">“购买”</span>方分期付款给<span class="text-bold">“出售”</span>方的债务权给任何与<span class="text-bold">“出售”</span>方合作的银行，与银行参考的服务费由<span class="text-bold">“购买”</span>方承担。</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៤៖ ការសន្យាប្រគល់អចលនវត្ថុ</p>
<p class="zh pb-0 mb-0 text-bold">第4条：不动产交纳承诺</p>
<p class="khmer">ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> សន្យា​នឹង​ប្រគល់​អចលនវត្ថុ​ជូន​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ក្នុង​រយៈ​ពេល <span class="khmer text-bold">{{ $contract->deadline_km }} ({{ $contract->deadline_in_word_km }}) ខែ​</span> ដោយ​រាប់​ចាប់​ពី​កាលបរិច្ឆេទ​ចុះ​កិច្ចសន្យា​លក់ទិញ​នេះ។ ក្នុង​ករណី​ដែល​មាន​ការ​យឺត​យ៉ាវ ឬ​ខកខាន​ក្នុង​​ការ​ប្រគល់​អចលនវត្ថុ​ជូន ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> សូម​រក្សា​សិទ្ធិ​ពន្យារ​ពេល​ថែម <span class="khmer text-bold">{{ $contract->extended_deadline_km }} ({{ $contract->extended_deadline_in_word_km }}) ខែ​</span> បន្ថែម​ទៀត ជា​រយៈ​ពេល​អនុគ្រោះ ក្នុង​ការ​សន្យា​ប្រគល់​អចលនវត្ថុ​ជូន ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span>។ បើ​ផុត​រយៈ​ពេល​អនុគ្រោះ​ខាង​លើ​ហើយ ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> នៅ​តែ​មិន​ទាន់​មាន​អចលនវត្ថុ​គ្រប់លក្ខណៈ​បច្ចេកទេស​សំណង់​ជា​អចលនវត្ថុ​រួចរាល់ ឬ​សម្រេច (មានទ្វារ បង្អួច កញ្ចក់ លាបថ្នាំពណ៌ និងគ្រឿង​បង្គុំ​ផ្សេងៗ​រួចរាល់) ប្រគល់​ជូន​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ទេ  ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> សូម​ទទួល​ខុស​ត្រូវ​ក្នុង​ការ​បង់​សំណង​ពិន័យ​ជូន ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ស្មើនឹងអត្រា ១% (មួយភាគរយ) ក្នុង​មួយ​ខែ នៃ​ប្រាក់​ដែល​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> បាន​ទូ​ទាត់​បង់​ជូន​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> រាប់​ចាប់​ពី​កាលបរិច្ឆេទ​ដែល​ផុត​កំណត់​ត្រូវ​ប្រគល់​អចលនវត្ថុ​ជូនភាគី <span class="khmer text-bold">“អ្នកទិញ”</span>។ គូ​ភាគី​បាន​សន្មត់ និង​ព្រម​ព្រៀង​គ្នា​ជា​មុន​ថា​នៅ​កាលបរិច្ឆេទ​ដែល​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> បាន​ជូន​ដំណឹង​ស្តី​ពី​ការ​ត្រួត​ពិនិត្យ និងទទួល​អចលនវត្ថុ​ដែល​គ្រប់​លក្ខណៈបច្ចេកទេស​សំណង់​ជា​អចលនវត្ថុ​រួចរាល់ ឬសម្រេច ទោះ​បី​ជា​តាម​រយៈ​ទូរស័ព្ទ​ក្តី សារ​អេឡិចត្រូនិច​ក្តី លិខិត​ជូន​ផ្ទាល់​ដៃ​ក្តី ការ​ជូន​ដំណឹង​ទៅ​លំនៅឋានក្តី ឬលិខិត​ជូន​តាម​ប្រៃសណីយ៍ក្តី ពោល​គឺ​តាម​វិធីសាស្ត្រ​ណា​មួយ​ដែល​សមស្រប​ដែលភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> អាច​ជ្រាប​ជា​ដំណឹង​បាន គឺ​មាន​ន័យ​ថា ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> មាន​អចលនវត្ថុ​ប្រគល់​ជូន ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> នៅ​កាលបរិច្ឆេទ​នោះ​តែម្តង (ក្នុង​ករណី​ដែល​មាន​ការ​ស្នើ​សុំ​កែ​លម្អ ឬ​ជួស​ជុល​ការងារ​បច្ចេកទេស​បន្តិច​បន្ទួច​ផ្នែក​ខាង​ក្នុង ឬ​ខាង​ក្រៅ​អចលនវត្ថុ ដូច​ជាកា​រ៉ូ ថ្នាំ​លាប ប្រឡាក់​កញ្ចក់ ប្រេះ​ស៊ីម៉ងត៍បៀក ។ល។ មិន​ត្រូវ​បាន​ចាត់​ទុក​ថា ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> មិន​ទាន់​មាន​អចលនវត្ថុ​សម្រាប់​ប្រគល់​ជូន ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ឡើយ)។ ដោយ​ឡែក ប្រសិន​បើ​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> បាន​បញ្ចប់​ការ​សាង​សង់​អចលនវត្ថុ​មុន​កាល​កំណត់ ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> នឹង​ធ្វើ​ការ​ជូន​ដំណឹង​ទៅ​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ស្តី​ពី​ការ​ត្រួត​ពិនិត្យ និង​ទទួល​អចលនវត្ថុ​មុន​កាល​កំណត់ ហើយ​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> មិន​ត្រូវ​យឺត​យ៉ាវ​ក្នុង​ការ​មក​ពិនិត្យ និងទទួល​ឡើយ បើ​មិន​ដូច​នោះ​ទេ ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> នឹង​មិន​ទទួល​ខុសត្រូវ ចំពោះ​ការ​យឺត​យ៉ាវ ឬខក​ខាន​ណា​មួយ​ជាយថាហេតុ​នៅ​ពេល​បន្ទាប់​ពីនោះ​ឡើយ។ ទាក់​ទង​នឹង​ការ​ប្រគល់​ទទួល​អចលនវត្ថុនេះ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> អាច​ទទួល​អចលនវត្ថុ​បាន​លុះ​ត្រាតែ <span class="khmer text-bold">(១).</span> ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ត្រូវ​ទូទាត់​ប្រាក់​ដែល​នៅ​ជំពាក់ និង​ប្រាក់​ពិន័យ​លើ​ការ​យឺត​យ៉ាវ ឬ​ខក​ខាន​នោះ​ឲ្យ​រួច​រាល់​ជា​មុន​សិន និង <span class="khmer text-bold">(២).</span> ត្រូវ​បង់​ប្រាក់​ថ្លៃ​សេវា​គ្រប់​គ្រង​ថែ​ទាំ​បុរី​ដូច​មាន​ចែង​ក្នុង​ <span class="khmer text-bold">ប្រការ៦</span> ជូន​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> សម្រាប់​រយៈ​ពេល​មួយ​ឆ្នាំ​ពេញ។ ចំពោះ​អចលនវត្ថុ​ដែល​ជា​កម្មវត្ថុ​នៃ​ការ​លក់​ទិញ​ណា​មួយ ដែល​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> មិន​ទាន់​បាន​ទូទាត់​ថ្លៃលក់ទិញ​រួច​រាល់​ទាំង​ស្រុង​ជូន ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ទេ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> នោះ​មិន​ទាន់​ក្លាយ​ជា​ម្ចាស់​អចលនវត្ថុ​ពេញ​លេញ និង​ស្រប​ច្បាប់​ឡើយ ទោះ​បី​ជា​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> បាន​ប្រគល់​អចលនវត្ថុ​នោះជូន ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ក៏ដោយ។</p>
<p class="text-left"><span class="text-bold">“出售”</span>方承诺自签订本购销合同的日期算起24（二十四）个月内交纳不动产给<span class="text-bold">“购买”</span>方。若延迟或耽误交纳不动产给<span class="text-bold">“购买”</span>方，<span class="text-bold">“出售”</span>方保留权利再延期6（六）个月，其为承诺交纳不动产给<span class="text-bold">“购买”</span>方的赦免期。若超过上述的赦免期，<span class="text-bold">“出售”</span>方仍然还未有足够资格的建筑技术成为完整或完成的不动产（有门户、窗户、玻璃、油漆及其他配备）交给<span class="text-bold">“购买”</span>方的，则自交纳不动产给<span class="text-bold">“购买”</span>方的期限期满之日算起，<span class="text-bold">“出售”</span>方将负责赔偿罚款给<span class="text-bold">“购买”</span>方相当于<span class="text-bold">“购买”</span>方已支付给<span class="text-bold">“出售”</span>方的款项的每月1%（百分之一）。双方已确认及事先同意于<span class="text-bold">“出售”</span>方通知关于验收完整或完成的有足够资格的不动产之日，不论是通过电话、电子邮件、亲手交纳的信函、发送通知书到住所或通过邮寄的信函，总而言之是通过任何适当的方法能让<span class="text-bold">“购买”</span>方得知的，则意味着<span class="text-bold">“出售”</span>方在当日已交纳不动产给<span class="text-bold">“购买”</span>方（若申请装修或维修不动产内外部分的一点点技术工作如瓷砖、油漆、玻璃肮脏、水泥裂缝等将不被视为<span class="text-bold">“出售”</span>方还未有不动产交纳给<span class="text-bold">“购买”</span>方的）。另外，若<span class="text-bold">“出售”</span>方在期限之前完成不动产的建设，<span class="text-bold">“出售”</span>方将通知<span class="text-bold">“购买”</span>方在期限之前进行验收不动产，<span class="text-bold">“购买”</span>方不得因任何事故而延迟或耽误。关于该不动产的交接，<span class="text-bold">“购买”</span>方可接受不动产除非（１）<span class="text-bold">“购买”</span>方须事先付清所欠的款项以及延迟或耽误上的罚款，和（２）须支付第6条所载的整一年时间的Borey管理服务费给<span class="text-bold">“出售”</span>方。对于<span class="text-bold">“购买”</span>方还未结算购销价款的任何购销标的的不动产给<span class="text-bold">“出售”</span>方的，<span class="text-bold">“购买”</span>方将还未成为完全及合法的不动产主人，即使<span class="text-bold">“出售”</span>方已交纳该不动产给<span class="text-bold">“购买”</span>方。</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៥៖ ការធានាគុណភាពសំណង់ ការកែប្រែសោភ័ណភាព និងប្លង់គោលលើអចលនវត្ថុនៃការលក់ទិញ</p>
<p class="zh pb-0 mb-0 text-bold">第５条：购销不动产的建筑保质、更改外观及主项目图</p>
<p class="khmer"><span class="khmer text-bold">៥.១.</span> ដោយ​រាប់​ចាប់​ពី​កាលបរិច្ឆេទ​ដែល​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ប្រគល់​អចលនវត្ថុ​នៃ​ការ​លក់ទិញ​ជូន​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> សូម​ធានា​វិការៈ (លើ​គុណភាព​គ្រោង​សំណង់ និង​ការ​បាក់​ស្រុត​គ្រឹះ​សំណង់) សម្រាប់​រយៈពេល <span class="khmer text-bold">០៣ (បី) ឆ្នាំ</span> និង​ធានា​វិការៈ​បច្ចេកទេស​សំណង់​ទូទៅ​ដូច​ជា​ការ​ប្រះ​ស្រាំ​ស៊ីម៉ងត៍បៀក ឬជញ្ជាំង ការជ្រាបទឹក សម្រាប់​រយៈពេល <span class="khmer text-bold">០១ (មួយ) ឆ្នាំ</span> (លើក​លែង​តែ​គ្រឿង​បំពាក់​ឈើ បើ​សិន​ជា​មាន​ផ្តល់​ជូន គឺ​មិន​មាន​ការ​ធានា​ជួស​ជុល ឬ​ប្តូរ​ថ្មី​ជូន​ឡើយ​)។ បរិក្ខា​អគ្គិសនី​ដែល​បំពាក់​ក្នុង​អចលនវត្ថុ ត្រូវ​បាន​ធានា​ដោយ​យោង​ទៅ​តាម​លក្ខខណ្ឌ​ដែល​បាន​កំណត់ ដោយ​រោង​ចក្រ​ផលិត ឬ​អ្នក​លក់​បរិក្ខា​នោះ។ ផ្ទុយ​ទៅ​វិញ ប្រសិន​បើ​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ធ្លាប់​បាន​ធ្វើ​ការ​ជួសជុល ឬ​ផ្លាស់​ប្តូរ​ទ្រង់​ទ្រាយ​សំណង់​លើ​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ​ដោយ​ខ្លួនឯង ឬ​មិន​សម្អាត​លើ​វ៉េរ៉ងដា ឬ​ឥដ្ឋ​កន្សែង​ជាន់​ដំបូល ឬ​រុះ​រើ​ដំបូល​សំណង់ ដែល​បណ្តាល​ឲ្យ​មាន​ការ​ជ្រាប​ទឹកនោះ ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> មិន​ធានា​វិការៈជូនឡើយ។</p>
<p class="text-left"><span class="text-bold">5.1</span> 自<span class="text-bold">“出售”</span>方交纳购销的不动产给<span class="text-bold">“购买”</span>方之日起，<span class="text-bold">“出售”</span>方须保证（建筑结构的质量及建筑基础的倒塌）03（三）年时间以及保证建筑的一般技术如混凝土或墙面的裂缝、防水01（一）年时间（除了木材以外，若有供给的话，其没有保修期或更新）。在不动产里安装的电器须按照其生产商厂或出售者的条件进行保质。相反，若<span class="text-bold">“购买”</span>方自行维修或更改不动产的建筑原状或没有清洁阳台或屋顶的砖瓦或拆除建筑屋顶导致漏水的，<span class="text-bold">“出售”</span>方将不保证。</p>

<p class="khmer"><span class="khmer text-bold">៥.២.</span> ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> មិន​មាន​សិទ្ធិ​កែ​ប្រែ​សោភ័ណភាព​សំណង់ និង/ឬប្លង់គោល​លើ​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញឡើយ លុះត្រា​តែ​មាន​ការ​អនុញ្ញាត​ពី ភាគី <span class="khmer text-bold">“អ្នកលក់”</span>។ ការ​កែប្រែ​សោភ័ណភាព​សំណង់ និង/ឬប្លង់គោល​លើ​អចលនវត្ថុ​នៃ​ការ​លក់ទិញ​ដោយ​គ្មាន​ការ​អនុញ្ញាត​ពី​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ត្រូវ​ទទួល​ខុស​ត្រូវ​ចំពោះ​មុខ​ច្បាប់​ជាធរមាន ហើយ​ការ​ធានា​លើវិការៈ​សំណង់​ដូច​មាន​ចែង​ក្នុង <span class="khmer text-bold">​ប្រការ៥.១</span> ខាងលើ លែង​មាន​អនុភាព​សម្រាប់ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ទៀតដែរ។</p>
<p class="text-left"><span class="text-bold">5.2 “购买”</span>方无权更改建筑的外观及/或购销不动产的主项目图，除非获得<span class="text-bold">“出售”</span>方的批准。在没有获得<span class="text-bold">“出售”</span>方的批准下而进行更改建筑的外观及/或购销不动产的主项目图，则<span class="text-bold">“购买”</span>方须在现行法律面前负责，且上述5.1项所载的建筑保质将对<span class="text-bold">“购买”</span>方失效。</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៦៖ ការគ្រប់គ្រងថែទាំ និងថ្លៃសេវាថែទាំគ្រប់គ្រងបុរី</p>
<p class="zh pb-0 mb-0 text-bold">第６条：管理保养及Borey的管理服务费</p>
<p class="khmer">បន្ទាប់​ពី​ប្រគល់​អចលនវត្ថុ​នៃ​ការ​លក់ទិញ​ជូន​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> មាន​កាតព្វកិច្ច​ក្នុង​ការ​ផ្តល់​ជូន​នូវ​សេវា​គ្រប់​គ្រង​ថែទាំ​បុរី ដែល​មាន​ដូច​ជា​សេវា​សន្តិសុខ​សណ្តាប់​ធ្នាប់ ២៤ម៉ោងលើ២៤ម៉ោង  អនាម័យសាធារណៈ ភ្លើងបំភ្លឺតាមដងផ្លូវ ការថែទាំសួនច្បារ និង​ទ្រព្យ​សម្បត្តិ​សាធារណៈទាំង​ឡាយ​នៅ​ក្នុង​បរិវេណ​បុរី​ទាំង​មូល។ ក្នុង​ករណីនេះ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> មាន​កាតព្វកិច្ច​ទូទាត់​បង់​ថ្លៃ​សេវា​គ្រប់គ្រង​ថែទាំ​បុរី​ដូច​ចែង​ក្នុង​ <span class="khmer text-bold">​ប្រការ១៖ អត្តសញ្ញាណ​នៃ​អចលនវត្ថុ​លក់​ទិញ និង​តម្លៃ​លក់​ទិញ</span> សម្រាប់​រយៈ​ពេល​មួយ​ឆ្នាំ​ម្តង ហើយ​ត្រូវ​បង់​មួយ​ឆ្នាំ​ទុក​ជា​មុន​ជូនទៅ ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> មុន​ពេល​ទទួល​អចលនវត្ថុ​ពី ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ហើយ​សេវា​នេះ​គិត​ចាប់​ពី​កាល​បរិច្ឆេទ​ដែល ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ទទួល​យក​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញពី ភាគី <span class="khmer text-bold">“អ្នកលក់”</span>។ ថ្លៃ​សេវា​ថែទាំ​គ្រប់គ្រង់​បុរី​នេះ អាច​ត្រូវ​បាន​កែប្រែ​នា​ពេល​ណា​មួយ​ខាង​មុខ​ដោយ​ស្រប​ទៅ​តាម​តម្លៃ​ទីផ្សារ​ជាក់​ស្តែង ហើយភាគី <span class="khmer text-bold">“អ្នកលក់”</span> នឹង​ជូន​ដំណឹង​ជាសាធារណៈ​ទៅភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ទាំង​អស់​ក្នុង​រយៈពេល <span class="khmer text-bold">០១ (មួយ) ខែ​</span>មុន​ការ​កែប្រែ​តម្លៃ​នេះ​ចូល​ជាធរមាន។</p>
<p class="text-left">当交纳购销不动产给<span class="text-bold">“购买”</span>方之后，<span class="text-bold">“出售”</span>方有义务提供Borey的管理保养服务如：24小时的保安秩序、公共场所卫生、路灯、公园的保养以及所有在整个Borey范围内的公共财产。此情况，<span class="text-bold">“购买”</span>方有义务支付第1条：购销不动产的身份及购销价所载的Borey管理服务费一年一次，且必须在从<span class="text-bold">“出售”</span>方接受不动产之前预付一年给<span class="text-bold">“出售”</span>方，该服务将自<span class="text-bold">“购买”</span>方从<span class="text-bold">“出售”</span>方接受购销不动产之日算起。该Borey的管理服务费可按照实际的市场价格在将来的任何时间里更改，且<span class="text-bold">“出售”</span>方将在该价格的更改生效之前1（一）个月通知全部的<span class="text-bold">“购买”</span>方。</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៧៖ ប័ណ្ណបញ្ជាក់សិទ្ធិលើកម្មសិទ្ធិនៃអចលនវត្ថុនៃការលក់ទិញ</p>
<p class="zh pb-0 mb-0 text-bold">第7条：购销不动产权利上的产权证</p>
<p class="khmer">ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> សន្យា​ថា​នឹង​ប្រគល់​ប័ណ្ណ​បញ្ជាក់​សិទ្ធិ​លើ​កម្មសិទ្ធិ​នៃ​អចលនវត្ថុ​នៃ​ការ​លក់ទិញ ជា​ប្រភេទ​ដូច​ចែង​ក្នុង​ <span class="khmer text-bold">ប្រការ១៖ អត្តសញ្ញាណ​នៃ​អចលនវត្ថុ​លក់ទិញ និង​តម្លៃ​លក់​ទិញ</span> ជូនភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> បន្ទាប់​ពី​ភាគី <span class="khmer text-bold">“អ្នកទិញ”៖</span> <span class="khmer text-bold">(១).</span> បាន​ទទួល​យក​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ​ពី​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> រួច​រាល់​ហើយ <span class="khmer text-bold">(២).</span> បាន​ទូ​ទាត់​បង់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​រួច​រាល់​គ្រប់​ចំនួន​ជូនមក ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ដូច​បាន​ចែង​ក្នុង​ឧបសម្ព័ន្ធទី១ <span class="khmer text-bold">“តារាង​កាល​វិភាគ​នៃ​ការ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ” (៣).</span> មក​បំពេញ​បែប​បទ និង​ឯកសារ​គ្រប់គ្រាន់​ជូន​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ដើម្បី​រៀប​ចំ​ដាក់​ស្នើ ឬ​រៀប​ចំ​បែបបទ​រដ្ឋបាល​ជា​មួយ​មន្ត្រី​ជំនាញ​សុរិយោ​ដី​ដើម្បី​ស្នើ​ទៅ​តាម​នីតិ​វិធី​ច្បាប់ឲ្យ​បាន​ទាន់​ពេល​វេលា និង​រលូន​ជូន​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> (ប្រសិន​បើ​ត្រូវ​ការ)។ ទោះ​ជា​យ៉ាង​ណា​ក៏​ដោយ​ ប្រសិន​បើ​មាន​ការ​យឺត​យ៉ាវ​ក្នុង​ការ​សម្រេច និង​អនុញ្ញាត​ចេញ​ប័ណ្ណ​បញ្ជាក់​សិទ្ធិ​លើ​កម្មសិទ្ធិ​លើ​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ ដោយ​សារ​តែ​បញ្ហា​បច្ចេកទេស ឬ​រដ្ឋបាល​របស់​មន្ត្រី​សុរិយោដី ឬ​មន្ត្រី​មាន​សមត្ថកិច្ច​នោះ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> មិន​អាច​តវ៉ា ឬ​ទំលាក់​កំហុស​លើ​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ដែល​បាន​ប្រឹងប្រែង​អស់​ពី​សមត្ថភាព​ហើយ​នោះទេ។ ការ​ចំណាយ​លើ​ការ​រៀប​ចំ​ឯកសារ​ផ្ទេរ​សិទ្ធិ​លើ​កម្មសិទ្ធិ ដូច​ចែងក្នុង <span class="khmer text-bold">ប្រការ១</span> បូក​រួម​នឹង​ការ​បង់​ពន្ធ​ប្រថាប់​ត្រា <span class="khmer text-bold">៤% (បូនភាគរយ)</span> គឺ​ជាការ​ទទួល​ខុស​ត្រូវ​ដោយ​ផ្ទាល់​របស់ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ដោយ​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ជួយ​សម្រួល និង​រៀបចំ​ឯក​សារ​ពាក់​ព័ន្ធ​ជូន​ទៅ​តាម​ស្ថាន​ភាព​ជាក់ស្តែង។</p>
<p class="text-left"><span class="text-bold">“出售”</span>方承诺将交纳如第１条：购销不动产的身份及购销价里所载的购销不动产权利上的产权证给<span class="text-bold">“购买”</span>方，当<span class="text-bold">“购买”</span>方：（１）已从<span class="text-bold">“出售”</span>方接受购销不动产完毕（２）已按照附件1<span class="text-bold">“不动产购销价款的结算时间表”</span>里所载支付全额的不动产购销价款给<span class="text-bold">“出售”</span>方，（3）办理全部的手续及文件给<span class="text-bold">“出售”</span>方以便让其与专业官员办理申请手续或办理行政手续以便按照法律程序及时及顺利申请给<span class="text-bold">“购买”</span>方（若有必要）。无论如何，若出具购销不动产权利上的产权证的决定及批准因地籍官员或职能官员的行政或技术有所延误，则<span class="text-bold">“购买”</span>方不可抗议或冤枉已尽力的<span class="text-bold">“出售”</span>方。第１条所载的权利上所办理的转让文件的费用包括4%（百分之四）的印花税由<span class="text-bold">“购买”</span>方自行负责，而<span class="text-bold">“出售”</span>方按照实际情况给予协助及办理相关文件。</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៨៖ ការទទួលខុសត្រូវបង់ពន្ធអចលនវត្ថុប្រចាំឆ្នាំរបស់គូភាគី</p>
<p class="zh pb-0 mb-0 text-bold">第8条：双方的年度不动产缴税责任</p>
<p class="khmer"><span class="khmer text-bold">៨.១</span> ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ទទួល​ខុស​ត្រូវ​ទាំង​ស្រុង​ចំពោះ​ការ​បង់​ពន្ធ​អចលនវត្ថុ​ប្រចាំ​ឆ្នាំ ឬ​បង់​ពន្ធ​ដី​មិន​បាន​បើ​ប្រាស់​ឬ​ពន្ធ​នានា​ពាក់​ព័ន្ធ​នឹង​អាជីវកម្ម​សាង​សង់​លំនៅឋាន​របស់​ខ្លួន​មុន​កាលបរិច្ឆេទ​នៃ​ការ​ប្រគល់​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ​ជូន​ទៅ​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span>។</p>
<p class="text-left"><span class="text-bold">8.1</span> 在交纳购销不动产给<span class="text-bold">“购买”</span>方之日前，<span class="text-bold">“出售”</span>方须负全责缴纳年度不动产税或缴纳没有使用的土地税或其他与自己建设住宅的业务有关的税务。</p>

<p class="khmer"><span class="khmer text-bold">៨.២</span> ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ត្រូវ​ទទួល​ខុស​ត្រូវ​លើ​ការ​បង់​ពន្ធ​អចលវត្ថុ​ប្រចាំ​ឆ្នាំ និង​ពន្ធ​ផ្សេង​ទៀត​ពាក់​ព័ន្ធ​នឹង​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ​ខាង​លើ​បន្ទាប់​ពី​កាល​បរិច្ឆេទ​ទទួល​យក​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ ពីភាគី <span class="khmer text-bold">“អ្នកលក់”</span>។</p>
<p class="text-left"><span class="text-bold">8.2</span> 当从<span class="text-bold">“出售”</span>方接受购销不动产之日之后，<span class="text-bold">“购买”</span>方须负责缴纳年度不动产税以及其他与上述购销不动产有关的税务。</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៩៖ ទាយាទ អ្នកស្នងមរតក និងអ្នកទទួលសិទ្ធិស្របច្បាប់</p>
<p class="zh pb-0 mb-0 text-bold">第９条：后嗣、继承人及合法受权人</p>
<p class="khmer">ក្នុង​ករណី​ដែល​មាន​ភាគី​ណា​មួយ មិន​អាច​អនុវត្ត​សិទ្ធិ និង​កាតព្វកិច្ច​របស់​ខ្លួន​បាន​ដោយ​មូលហេតុ​ណា​មួយ​បណ្តាល​មក​ពី មរណភាព ពិការភាព ឬ​អវត្តមាន​ជា​បណ្តោះ​អាសន្ន ឬ​អចិន្ត្រៃយ៍​នៅ​ក្នុង​ប្រទេស​នោះ រាល់​សិទ្ធិ និង​កាតព្វកិច្ច​ទាំង​អស់​របស់​ភាគី​នោះ​ដែល​ស្ថិត​ក្រោម​ខ្លឹមសារ​នៃ​កិច្ចសន្យា​នេះ ត្រូវ​បន្ត​ទៅ​ទាយាទ និង/ឬ អ្នក​ស្នង​មរតក និង/ឬអ្នកតំណាង​ស្រប​ច្បាប់​ណា​មួយ​របស់​ខ្លួន​ដោយ​ស្វ័យប្រវត្តិ។</p>
<p>若任何一方因逝世、残废或在国内暂时或永久缺席的任何原因导致不能执行自己的权利和义务，该方在本合同内容下的所有权利和义务将自动转让给自己的任何后嗣及/或继承人及/或法定代表人。</p>

<p class="khmer-title pb-0 mb-0">ប្រការ១០៖ គោលការណ៍ស្ម័គ្រចិត្ត និងការព្រមព្រៀងនៃកិច្ចសន្យា</p>
<p class="zh pb-0 mb-0 text-bold">第10条：自愿原则及合同的协议</p>
<p class="khmer">កិច្ចសន្យា​លក់​ទិញ​អចលនវត្ថុ​នេះ ត្រូវ​ធ្វើ​ឡើង​ដោយ​គ្មាន​ការ​គំរាម​កំហែង បង្ខិតបង្ខំ ឬ​មាន​បញ្ហា​ខុស​ច្បាប់​ណា​មួយ​ឡើយ ហើយ <span class="khmer text-bold">គូភាគី</span> មាន​សមត្ថភាព​គ្រប់គ្រាន់​ក្នុង​ការ​ដឹង​លឺ ឬ​យល់​ដឹង បាន​អាន បានស្តាប់ និង​យល់​ព្រម​តាម​លក្ខខណ្ឌ​ទាំងឡាយ​នៃ​កិច្ចសន្យា​នេះ។ កិច្ចសន្យា​លក់​ទិញ​អចលនវត្ថុ​នេះ មាន​សុពលភាព​នា​កាលបរិច្ឆេទ​ដែល <span class="khmer text-bold">គូភាគី</span> បាន​ផ្តិត​ស្នាម​មេដៃ និង​ចុះ​ត្រា​ក្រុមហ៊ុន​ដូច​ខាង​ក្រោម។ កិច្ចសន្យា​លក់ទិញ​អចលនវត្ថុ​នេះ​ធ្វើ​ឡើង​ជាភាសាខ្មែរ​ចំនួន <span class="khmer text-bold">០២ (ពីរ)</span> ឯកសារ​ច្បាប់​ដើម ក្នុងនោះ ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> រក្សាទុក <span class="khmer text-bold">០១ (មួយ)</span> ឯកសារ​ច្បាប់ដើម ហើយភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> រក្សាទុក <span class="khmer text-bold">០១ (មួយ)</span> ឯកសារ​ច្បាប់​ដើម។ ឯកសារ​នីមួយៗ​មាន​សុពលភាព និង​អានុភាព​គតិយុត្តិ​ស្មើៗ និងដូចគ្នា។</p>
<p class="text-left">本不动产购销合同在无任何威胁、逼迫或违法问题下订立，双方有足够能力知晓或了解并已阅读、聆听及了解本合同的全部条件。本不动产购销合同自双方在下面按拇指印及盖公司印章之日生效。本不动产购销合同以柬文书写一式02（二）份正本，其中<span class="text-bold">“出售”</span>方执01（一）份正本，<span class="text-bold">“购买”</span>方执01（一）份正本。每份具备同等法律效力。</p>
@endsection

@section('third')
<h4 class="khmer-title text-center pb-0 mb-0">ឧបសម្ព័ន្ធទី៣៖</h4>
<h4 class="zh text-center">附件３៖</h4>
<h4 class="khmer-title text-center pb-0 mb-0">“សម្ភារៈដែលភ្ជាប់បញ្ជូលក្នុងអចលនវត្ថុ”</h4>
<h4 class="zh text-center mb-4">“加入不动产的设施设备”</h4>
<div class="khmer">
{!! $contract->equipment_text !!}
</div>
<div style="page-break-after: always;"></div>
@endsection

@section('forth')
<h4 class="khmer-title text-center pb-0 mb-0">ឧបសម្ព័ន្ធទី៤៖</h4>
<h4 class="zh text-center">附件4៖</h4>
<h4 class="khmer-title text-center pb-0 mb-0">“អត្តសញ្ញាណប័ណ្ណ​ឬលិខិតឆ្លងដែនរបស់ភាគី​អ្នកលក់​និងភាគី​អ្នកទិញ”</h4>  
<h4 class="zh text-center mb-4">“出售方和购买方的身份证或护照”</h4>  

@if(array_key_exists('customer1_id_front',$attachment_array) || array_key_exists('customer2_id_front',$attachment_array))  
<p class="khmer text-bold">- អត្តសញ្ញាណប័ណ្ណ អ្នកទិញ</p>
<p class="zh text-bold">- 出售者身份证</p>
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
<p class="khmer text-bold">- លិខិតឆ្លងដែន អ្នកទិញ</p>
<p class="zh text-bold">- 买家护照</p>
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
<p class="khmer text-bold">- អត្តសញ្ញាណប័ណ្ណ អ្នកលក់</p> 
<p class="zh text-bold">- 出售者身份证</p> 
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
@endsection