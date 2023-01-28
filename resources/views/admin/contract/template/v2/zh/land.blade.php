@extends('admin.contract.template.v2.zh.template')

@section('page_title', "Contract $contract->customer1_name")

@section('contract_type')
<h3 class="khmer-title text-center mt-3 mb-3">កិច្ចសន្យាលក់ ទិញដីឡូតិ៍ ក្នុងគម្រោង {{ $project->name }}</h3>
<h3 class="text-center mt-3 mb-3">项目里的地块 {{ $project->name_zh }}</h3>
@endsection

@section('praka')
<p class="khmer-title pb-0 mb-0">ប្រការ១៖ អត្តសញ្ញាណនៃអចលនវត្ថុលក់ទិញ និងតម្លៃលក់ទិញ</p>
<p class="zh pb-0 mb-0 text-bold">第1条：购销不动产的身份及购销价</p>
<p class="khmer pb-0"><span class="khmer text-bold">១.១.</span> ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> គឺ​ជា​កម្មសិទ្ធិករ​ស្រប​ច្បាប់​លើ​អចលនវត្ថុ យល់​ព្រម​លក់ ហើយ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span>
យល់​ព្រម​ទិញ​នូវ​អចលនវត្ថុ​ដូច​មាន​ចែង​ក្នុង​តារាង​អត្តសញ្ញាណ​នៃ​អចលនវត្ថុ​លក់ទិញ និង​តម្លៃ​លក់​ទិញ​នេះ។</p>
<p class="zh"><span class="text-bold">1.1．“出售”</span>方为不动产的合法所有者并同意出售，且<span class="text-bold">“购买”</span>方同意购买在该购销不动产身份及购销价表里的不动产。</p>
<p class="khmer pb-0"><span class="khmer text-bold">១.២.</span> តារាងអត្តសញ្ញាណនៃអចលនវត្ថុលក់ទិញ និងតម្លៃលក់ទិញ (“អចលនវត្ថុ”)៖</p>
<p class="zh"><span class="text-bold">1.2. </span>购销不动产身份及购销价表<span class="text-bold">（“不动产”）</span>：</p>
<table class="table table-p-1 table-contract-bordered">
    <tr>
    	<td width="180px" class="text-bold">
            <p class="khmer pb-0">ប្រភេទ</p>   
            <p class="zh pb-0">种类</p>   
        </td>
    	<td width="30px" class="text-center">:</td>      
    	<td>
            <p class="khmer pb-0">{{ $unit_type->name }}</p>   
            <p class="zh pb-0">{{ $unit_type->name_zh }}</p>   
        </td>
    	<td width="100px" class="text-bold">
            <p class="khmer pb-0">លេខ</p>
            <p class="zh pb-0">号码</p>
        </td>
    	<td width="30px" class="text-center">:</td>
    	<td width="250px" class="english text-bold">
            <p class="khmer pb-0">{{ isset($is_template) ? '_______________' : $unit->code }}</p>   
            <p class="zh pb-0">{{ isset($is_template) ? '_______________' : $unit->code }}</p>   
        </td>
    </tr>
    <tr>
    	<td width="180px" class="text-bold">
            <p class="khmer pb-0">ទំហំដី</p>   
            <p class="zh pb-0">土地面积</p>   
        </td>
    	<td width="30px" class="text-center">:</td>      
    	<td>
            <p class="khmer mb-0 pb-0">
                @if( isset($is_template) )
                    _______________
                @else
                    ទទឹង {{ $unit->land_size_width_km }} ម៉្រែត និង បណ្តោយ {{ $unit->land_size_length_km }} ម៉្រែត
                @endif            
            </p>
    		<p class="zh mb-0 pb-0">
        		@if( isset($is_template) )
        			_______________
        		@else
        			宽度 {{ $unit->land_size_width }} 米 和 长度 {{ $unit->land_size_length }} 米
        		@endif            
    		</p>
            <small class="d-block"><i class="khmer">(ដែល​អាច​មាន​ការ​ប្រែប្រួល​បន្តិច​បន្ទួច​ជាលក្ខណៈ​បច្ចេកទេស អាស្រ័យ​លើ​ការ​កំណត់​ព្រុំ​របស់​មន្ត្រី​សុរិយោដី)</i></small>
            <small><i>(可能有一点点技术性的差异，其须依照地籍官员所规定的界线)</i></small>
    	</td>
    	<td width="120px" class="text-bold">
            <p class="khmer pb-0">សេវានិង​ថ្លៃ​គ្រប់គ្រង​ថែទាំ</p>   
            <p class="zh pb-0">服务及管理保养费</p>   
        </td>
    	<td width="30px" class="text-center">:</td>
    	<td width="250px"> 
            <p class="khmer pb-0">ដូច​ចែង​ក្នុង​<span class="khmer text-bold">ប្រការ៦</span> នៃ​កិច្ច​សន្យា​លក់​ទិញនេះ។</p>
            <p class="zh pb-0">根据本购销合同的第6条所载</p>
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
            <p class="khmer pb-0">ប្រភេទ​នៃ​ប័ណ្ណ​កម្មសិទ្ធិ​ដែល​ប្រគល់​ជូន​ភាគី“អ្នកទិញ”</p>
            <p class="zh pb-0">交纳给“购买”方的产权证的种类</p>
        </td>
    	<td width="30px" class="text-center">៖</td>      
    	<td colspan="4">
            <p class="khmer pb-0">ភាគី “អ្នកលក់” សន្យាថានឹងប្រគល់ប័ណ្ណបញ្ជាក់សិទ្ធិលើកម្មសិទ្ធិនៃអចលនវត្ថុនៃការលក់ទិញ (ប្លងទន់ត្រឹមសាលាស្រុក/ខណ្ឌ) ជូនភាគី “អ្នកទិញ” ដូចមានចែងលម្អិតក្នុងប្រការ ៧ នៃកិច្ចសន្យានេះ។ ប័ណ្ណបញ្ជាក់កម្មសិទ្ធិនេះ ភាគី “អ្នកលក់” ធានាថាអាចធ្វើប័ណ្ណកម្មសិទ្ធិ (ប្លង់រឹង) បានដែលរាល់ការចំណាយជាបន្ទុករបស់ភាគី “អ្នកទិញ” ទាំងស្រុង។</p>
    		<p class="zh pb-0"><span class="text-bold">“出售”</span>方将交纳产权证（还未转让权利）给<span class="text-bold">“购买”</span>方。 若<span class="text-bold">“购买”</span>方有意转让权利，则<span class="text-bold">“出售”</span>方有义务协助办理文件给<span class="text-bold">“购买”</span>方，但是所有办理文件上的公共服务费及4%（百分之四）的印花税由<span class="text-bold">“购买”</span>方承担。</p>
    	</td>
    </tr>   
    <tr>
    	<td width="180px" class="text-bold">
            <p class="khmer pb-0">តម្លៃលក់ទិញ</p>   
            <p class="zh pb-0">购销价</p>   
        </td>
    	<td width="30px" class="text-center">៖</td>
    	<td colspan="4">
            <p class="khmer pb-0">
                @if( isset($is_template) )
                    _______________ ( _______________ ) 美元
                @else
                {{ $contract->unit_sale_price_after_discount_km }} ({{ $contract->unit_sale_price_after_discount_in_word_km }}) 
                @endif
                ដុល្លារ​​​អាមេរិច
            </p>
            <p class="zh pb-0">
                @if( isset($is_template) )
                    _______________ ( _______________ ) 美元
                @else
                {{ $contract->unit_sale_price_after_discount_zh }} ({{ $contract->unit_sale_price_after_discount_in_word_zh }}) 美元
                @endif
            </p>
    	</td>
    </tr>
</table>

<p class="khmer-title pb-0 mb-0">ប្រការ២៖ ការទូទាត់ប្រាក់ថ្លៃលក់ទិញអចលនវត្ថុ</p>
<p class="zh pb-0 mb-0 text-bold">第2条：不动产购销价款的结算</p>
<p class="khmer pb-0"><span class="khmer text-bold">២.១.</span> ដោយ​មាន​ការ​ព្រមព្រៀង​គ្នា​ក្នុង​ការ​លក់​ទិញ នូវ​អចលនវត្ថុ​ដូច​បាន​ចែង​ក្នុង​ <span class="khmer text-bold">ប្រការ១ “អត្តសញ្ញាណ​នៃ​អចលនវត្ថុ​លក់​ទិញ និងតម្លៃ​លក់​ទិញ”</span> ខាងលើ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ត្រូវ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ខាង​លើ​ទៅ​តាម​ដំណាក់កាល​នៃ​ការ​ទូទាត់​ឲ្យ​បាន​ត្រឹមត្រូវ គ្រប់​ចំនួន​ និង​ទាន់​ពេល​វេលា​ជា​បន្ត​បន្ទាប់​ដូច​បាន​ចែង​ក្នុង​ឧបសម្ព័ន្ធទី១ <span class="khmer text-bold">“តារាងកាលវិភាគ​នៃ​ការ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ”</span>។ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> អាច​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ដោយ​ផ្ទាល់​នៅ​ការិយាល័យ​របស់​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ឬ​តាម​រយៈ​គណនី​ធនាគារ <span class="khmer text-bold">{{ $bank->short_name }}</span> ដូច​មាន​ព័ត៌មាន​លម្អិត​ខាង​ក្រោមនេះ៖</p>

<p class="zh"><span class="text-bold">2.1</span> 因有着上述第1条<span class="text-bold">“购销不动产的身份及购销价”</span>里所载的不动产的购销的协议一致，<span class="text-bold">“购买”</span>方须根据附件1<span class="text-bold">“不动产购销价款的结算时间表”</span>以正确、全额及准时按照结算阶段支付上述不动产购销价款。<span class="text-bold">“购买”</span>方可直接到<span class="text-bold">“出售”</span>方的办公室里结算不动产购销款项或通过以下信息的ABA银行的账户：</p>
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
				<td class="text-center text-bold">{{ $bank->account_name }}</td>
				<td class="text-center text-bold">{{ $bank->account_number }}</td>
			</tr>
		</table>
	</div>
</div>

<p class="khmer pb-0"><span class="khmer text-bold">២.២.</span> ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> អនុគ្រោះ​ជូនភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ក្នុង​ការ​យឺតយ៉ាវ ឬ​ខក​ខាន​ទូទាត់​ប្រាក់ថ្លៃ​លក់ទិញ​អចលនវត្ថុ​ត្រឹមរយៈពេល <span class="khmer text-bold">០៧ (ប្រាំពីរ) ថ្ងៃប្រតិទិន</span> ដោយ​មិន​បង់​ប្រាក់​ពិន័យ។ ផុត​ពី​រយៈ​ពេល​អនុគ្រោះ​នេះ ក្នុង​ករណី​ដែល​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> យឺតយ៉ាវ ឬ​ខកខាន​មិន​បាន​បំពេញ​កាតព្វកិច្ច​ទូទាត់​បង់ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ជូន​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ទៅ​តាម​ដំណាក់​កាល​នៃ​ការ​ទូទាត់​ឲ្យ​បាន​ត្រឹមត្រូវ គ្រប់ចំនួន និង​ទាន់​ពេល​វេលា​ទេ​នោះ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ត្រូវ​បង់​ប្រាក់​ពិន័យ​លើ​ការ​យឺតយ៉ាវ ឬ​ខក​ខាន​នោះ​ក្នុង​មួយថ្ងៃ <span class="khmer text-bold">០៥ (ប្រាំ) ដុល្លារ​អាមេរិក</span>។ ក្នុង​ករណី​ដែល​ការ​យឺតយ៉ាវ ឬ​ខក​ខាន​ក្នុង​ការ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​នោះ​នៅ​តែ​បន្ត​លើសពី រយៈពេល <span class="khmer text-bold">០២ (ពីរ) ខែ</span>​ជាប់ៗ​គ្នា ឬ​ក្នុង​ចន្លោះ​រយៈ​ពេល​ណា​មួយ​ដែល​ផល​បូក​នៃ​រយៈ​ពេល​ទាំង​នោះ​លើស​ពី <span class="khmer text-bold">០២ (ពីរ) ខែ</span> នោះ​ត្រូវ​បាន​សន្មត់ទុក​ជា​មុន និង​ចាត់​ទុក​ថា ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> រំលាយ​កិច្ចសន្យា​ដោយ​ឯកតោ​ភាគី ដោយ​បោះបង់​ចោល​នូវ​សិទ្ធិ​ទាំង​ឡាយ​ដែល​មាន​លើអចលនវត្ថុ ការ​លក់​ទិញ​អចលនវត្ថុ និង​ចំនួន​ទឹក​ប្រាក់​ដែល​ខ្លួន​បាន​ទូទាត់​មក​ឲ្យ​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span>។ ក្នុង​ករណី​នេះទឹក​ប្រាក់​ដែល​បាន​ទូទាត់​ហើយ​ទាំងអស់​ត្រូវ​ក្លាយ​ជា​ប្រយោជន៍​សម្រាប់​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ហើយ ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> មាន​សិទ្ធិ​ពេញ​លេញ​ដោយ​ស្រប​ច្បាប់​ក្នុង​ការ​លក់​អចលនវត្ថុ​ខាង​លើ​ឲ្យ​ទៅ​អតិថិជន ឬ​អ្នក​ទិញ​ផ្សេង​ទៀត​បាន ដោយ​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> សន្យា​ថា​នឹង​មិន​តវ៉ា ឬ​ជំទាស់​ឡើយ។ ក្នុង​ករណី​នេះ ប្រសិន​បើ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> បាន​ទទួល​យក​អចលនវត្ថុ​ពី ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ហើយនោះ ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ទុក​រយៈ​ពេល​ឲ្យ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ដែល​បោះបង់​សិទ្ធិ​លើ​ការ​លក់​ទិញ និង​អចលនវត្ថុ​នោះ <span class="khmer text-bold">០១ (មួយ) ខែ</span> សម្រាប់​រើចេញ​ពី​អចលនវត្ថុ។</p>

<p class="zh"><span class="text-bold">2.2</span> 若<span class="text-bold">“购买”</span>方延迟或耽误结算不动产购销价款 <span class="text-bold">“出售”</span>方将赦免07（七）天日历，其不必支付罚款。逾期该赦免，若<span class="text-bold">“购买”</span>方延迟或耽误没能执行义务以正确、全额及准时按照结算阶段结算不动产购销价款给<span class="text-bold">“出售”</span>方，则<span class="text-bold">“购买”</span>方须支付该延迟或耽误每天05（五）美元的罚款。若该不动产购销价款的支付仍然延迟或耽误连续超过02（二）个月或在任何期限内逾期相加超过02(二)个月，将被预估及视为<span class="text-bold">“购买”</span>方单方解除合同，其放弃不动产上的全权、不动产的购销及自己已支付给<span class="text-bold">“出售”</span>方的款项。此情况，已支付的全部款项将成为<span class="text-bold">“出售”</span>方的利益，<span class="text-bold">“出售”</span>方有合法全权出售上述不动产给第三者或其他购买者，<span class="text-bold">“购买”</span>方承诺不做出任何抗议或反抗。此情况，若<span class="text-bold">“购买”</span>者已从<span class="text-bold">“出售”</span>者接受不动产，则<span class="text-bold">“出售”</span>方将保留01（一）个月时间给放弃购销及不动产权利的<span class="text-bold">“购买”</span>方以便搬出不动产。</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៣៖ ការលក់ ឬផ្ទេរសិទ្ធិលើការលក់ទិញអចលនវត្ថុបន្តទៅតតិយជន និងឥណទានពីធនាគារ</p>
<p class="zh pb-0 mb-0 text-bold">第3条：出售或转让不动产购销权利给第三者或向银行贷款</p>
<p class="khmer pb-0"><span class="khmer text-bold">៣.១.</span> ក្នុង​កំឡុង​ពេល​នៃ​ការ​អនុវត្ត​កិច្ចសន្យា​លក់​ទិញ​នេះ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> អាច​លក់ ឬ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ​អចលនវត្ថុ​ទៅ​ តតិយជន​ណា​មួយ​បាន​ដោយ​ការ​ស្នើ​សុំ​ជា​លាយ​លក្ខណ៍​អក្សរ ហើយ​ទទួល​បាន​ការ​អនុញ្ញាត​យល់​ព្រម​ពី​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ដោយភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ត្រូវ​បង់​ថ្លៃ​សេវា​រដ្ឋបាល​លើ​ការ​លក់ ឬ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ អចលនវត្ថុ​នេះ​ស្មើ​នឹង <span class="khmer text-bold">{{ $contract->contract_transfer_fee_km }} ({{ $contract->contract_transfer_fee_in_word_km }}) ដុល្លារ​អាមេរិក</span> ជូន​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span>។ មុន​នឹង​អាច​លក់ ឬ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ​អចលនវត្ថុ​ទៅ​តតិយជន​ណា​មួយ​បាន ប្រសិន​បើ​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> យឺតយ៉ាវ ឬ​ខក​ខន​មិន​បាន​បំពេញ​កាតព្វកិច្ច​ទូទាត់​បង់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ជូន​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ទៅ​តាម​ដំណាក់​កាល​នៃ​ការ​ទូទាត់​ឲ្យ​បាន​ត្រឹមត្រូវ គ្រប់ចំនួន និងទាន់​ពេល​វេលា​ដូច​ចែង​ក្នុង​ <span class="khmer text-bold">ប្រការ២</span> នោះ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ត្រូវ​ទូទាត់​ប្រាក់​ដែល​នៅ​ជំពាក់ និង​ប្រាក់​ពិន័យ​លើ​ការ​យឺត​យ៉ាវ ឬ​ខក​ខាន​នោះ​ឲ្យ​រួច​រាល់​ជា​មុន​សិន។ តតិយជន​ដែល​ទទួល​ទិញ ឬ​ទទួល​ការ​ផ្ទេរ​សិទ្ធិ​លើ​ការ​លក់​ទិញ​អចលនវត្ថុ​នេះ ត្រូវ​គោរព​តាម​ទាំង​ស្រុង​នូវ​ខ្លឹម​សារ​នៃ​កិច្ចសន្យា​លក់​ទិញ​នេះ ហើយ​អនុវត្ត​តាម​បែប​បទ​រដ្ឋបាល​មួយ​ចំនួន​ដែល​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> តម្រូវ។</p>
<p class="zh"><span class="text-bold">3.1 </span>履行本购销合同期间，<span class="text-bold">“购买”</span>方可出售或转让不动产购销权利给任何第三者，但须以书面申请并获得<span class="text-bold">“出售”</span>方的同意批准，且在可以出售或转让不动产购销权利给任何第三者之前，<span class="text-bold">“购买”</span>方须支付出售或转让该不动产购销权利上的行政服务费相当于 {{ $contract->contract_transfer_fee }}（{{ numfmt_create('zh', \NumberFormatter::SPELLOUT)->format($contract->contract_transfer_fee) }}）美元给<span class="text-bold">“出售”</span>方。若 <span class="text-bold">“购买”</span>方延迟或耽误没能按照第2条所载执行义务以正确、全额及准时按照结算阶段结算不动产购销价款给<span class="text-bold">“出售”</span>方，则<span class="text-bold">“购买”</span>方须事先付清还欠的款项以及延迟或耽误的罚款。购买的第三者或该不动产购销的受权者须遵从本购销合同的全部内容并按照<span class="text-bold">“出售”</span>方的要求执行一些行政手续。</p>

<p class="khmer pb-0"><span class="khmer text-bold">៣.២.</span> ចំពោះ​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ដែល​ជ្រើស​រើស​ជម្រើស​បង់រម្លស់ <span class="english">(Loan)</span> ដែល​ភ្ជាប់​នឹង​អត្រា​ការ​ប្រាក់​ជាមួយ​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> នៅ​ពេល​ដែល​ដី​ត្រូវបានចាក់​បំពេញ​បាន​ចាប់ពី៧០% (ចិតសិបភាគរយ) ឡើង​ទៅ ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> សូម​រក្សា​សិទ្ធិ​ក្នុង​ការ​ចាត់​ចែង​បញ្ជូន​សិទ្ធិ​លើ​បំណុល​ដែល​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> មាន​ដោយ​ការ​បង់​រម្លស់​ជាមួយ ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ឲ្យ​ទៅ​ធនាគារ​ណា​មួយ​ដែល​សហការ​ជាមួយ​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ហើយ​សេវា​ក្នុង​ការ​សិក្សា​ជា​មួយ​ធនាគារ​ទាំងនោះ គឺ​ជា​បន្ទុក​របស់​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span>។</p>
<p class="zh"><span class="text-bold">3.2</span> 对于支付利息给<span class="text-bold">“出售”</span>方的选择分期付款(loan)的<span class="text-bold">“购买”</span>方，当不动产工程建设超过70%（百分之七十）以上，<span class="text-bold">“出售”</span>方保留权利安排发送<span class="text-bold">“购买”</span>方分期付款给<span class="text-bold">“出售”</span>方的债务权给任何与<span class="text-bold">“出售”</span>方合作的银行，与银行参考的服务费由<span class="text-bold">“购买”</span>方承担。</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៤៖ ការសន្យាប្រគល់អចលនវត្ថុ</p>
<p class="zh pb-0 mb-0 text-bold">第4条：不动产交纳承诺</p>
<p class="khmer pb-0">ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> សន្យា​នឹង​ប្រគល់​អចលនវត្ថុ​ជូន​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ក្នុង​រយៈ​ពេល <span class="khmer text-bold">{{ $contract->deadline_km }} ({{ $contract->deadline_in_word_km }}) ខែ​</span> ដោយ​រាប់​ចាប់​ពី​កាលបរិច្ឆេទ​ចុះ​កិច្ចសន្យា​លក់ទិញ​នេះ។ ក្នុង​ករណី​ដែល​មាន​ការ​យឺត​យ៉ាវ ឬ​ខកខាន​ក្នុង​​ការ​ប្រគល់​អចលនវត្ថុ​ជូន ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> សូម​រក្សា​សិទ្ធិ​ពន្យារ​ពេល​ថែម <span class="khmer text-bold">{{ $contract->extended_deadline_km }} ({{ $contract->extended_deadline_in_word_km }}) ខែ​</span> បន្ថែម​ទៀត ជា​រយៈ​ពេល​អនុគ្រោះ ក្នុង​ការ​សន្យា​ប្រគល់​អចលនវត្ថុ​ជូន ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span>។ បើ​ផុត​រយៈ​ពេល​អនុគ្រោះ​ខាង​លើ​ហើយ ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> នៅ​តែ​មិន​ទាន់​មាន​អចលនវត្ថុ ប្រគល់​ជូន​ភាគី “អ្នកទិញ” ទេ  ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> សូម​ទទួល​ខុស​ត្រូវ​ក្នុង​ការ​បង់​សំណង​ពិន័យ​ជូន ភាគី “អ្នកទិញ” ស្មើនឹងអត្រា ១% (មួយភាគរយ) ក្នុង​មួយ​ខែ នៃ​ប្រាក់​ដែល​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> បាន​ទូ​ទាត់​បង់​ជូន​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> រាប់​ចាប់​ពី​កាលបរិច្ឆេទ​ដែល​ផុត​កំណត់​ត្រូវ​ប្រគល់​អចលនវត្ថុ​ជូនភាគី <span class="khmer text-bold">“អ្នកទិញ”</span>។ ទាក់​ទង​នឹង​ការ​ប្រគល់​ទទួល​អចលនវត្ថុនេះ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> អាច​ទទួល​អចលនវត្ថុ​បាន​លុះ​ត្រាតែ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ត្រូវ​ទូទាត់​ប្រាក់​ដែល​នៅ​ជំពាក់ និង​ប្រាក់​ពិន័យ​លើ​ការ​យឺត​យ៉ាវ ឬ​ខក​ខាន​នោះ​ឲ្យ​រួច​រាល់​ជា​មុន​សិន។ ចំពោះ​អចលនវត្ថុ​ដែល​ជា​កម្មវត្ថុ​នៃ​ការ​លក់​ទិញ​ណា​មួយ ដែល​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> មិន​ទាន់​បាន​ទូទាត់​ថ្លៃលក់ទិញ​រួច​រាល់​ទាំង​ស្រុង​ជូន ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ទេ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> នោះ​មិន​ទាន់​ក្លាយ​ជា​ម្ចាស់​អចលនវត្ថុ​ពេញ​លេញ និង​ស្រប​ច្បាប់​ឡើយ ទោះ​បី​ជា​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> បាន​ប្រគល់​អចលនវត្ថុ​នោះជូន ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ក៏ដោយ។</p>
<p class="zh"><span class="text-bold">“出售”</span>方承诺自签订本购销合同的日期算起{{ $contract->deadline }}（{{ numfmt_create('zh', \NumberFormatter::SPELLOUT)->format($contract->deadline) }}）个月内交纳不动产给<span class="text-bold">“购买”</span>方。若延迟或耽误交纳不动产给<span class="text-bold">“购买”</span>方，<span class="text-bold">“出售”</span>方保留权利再延期{{ $contract->extended_deadline }}（{{ numfmt_create('zh', \NumberFormatter::SPELLOUT)->format($contract->extended_deadline) }}）个月，其为承诺交纳不动产给<span class="text-bold">“购买”</span>方的赦免期。若超过上述的赦免期，<span class="text-bold">“出售”</span>方仍然还未有不动产交纳给<span class="text-bold">“购买”</span>方，则自交纳不动产给<span class="text-bold">“购买”</span>方的期限期满之日算起，<span class="text-bold">“出售”</span>方将负责赔偿罚款给<span class="text-bold">“购买”</span>方相当于<span class="text-bold">“购买”</span>方已支付给<span class="text-bold">“出售”</span>方的款项的每月1%（百分之一）。关于该不动产的交接，<span class="text-bold">“购买”</span>方可接受不动产除非<span class="text-bold">“购买”</span>方须事先付清所欠的款项以及延迟或耽误上的罚款。对于<span class="text-bold">“购买”</span>方还未结算购销价款的任何购销标的的不动产给<span class="text-bold">“出售”</span>方的，<span class="text-bold">“购买”</span>方将还未成为完全及合法的不动产主人，即使<span class="text-bold">“出售”</span>方已交纳该不动产给<span class="text-bold">“购买”</span>方。</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៥៖ ការសន្យា និងការទទួលខុសត្រូវក្នុងការអភិវឌ្ឍន៍អចលនវត្ថុរវាងភាគី “អ្នកលក់” និងភាគី “អ្នកទិញ”</p>
<p class="zh pb-0 mb-0 text-bold">第５条：“出售”方与“购买”方之间对开发不动产的承诺及责任</p>
<p class="khmer pb-0 mb-0"><span class="khmer text-bold">៥.១.</span> ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> សន្យា​ធ្វើ​ការ​អភិវឌ្ឍន៍​អចលនវត្ថុ​ជូន​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ដូច​ខាង​ក្រោម​ទៅ​តាម​កាល​វិភាគ​ពេលវេលា និង​ដំណាក់​កាល​ការងារ​អភិវឌ្ឍន៍​របស់​គម្រោង​ខ្លួន៖</p>
<ul class="ml-4 mb-2">
    <li class="khmer">សាង​សង់​ផ្លូវ​បេតុង​ក្នុង​បរិវេណ​គម្រោង​ដែល​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> បាន​លក់​ជូន​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span>។</li>
    <li class="khmer">សាង​សង់​ប្រព័ន្ធ​លូ​ក្នុង​បរិវេណ​គម្រោង​ដែល​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> បាន​លក់​ជូន​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span>។</li>
    <li class="khmer">ត​ភ្ចាប់​ប្រព័ន្ធ​ទឹក​ស្អាត​ក្នុង​បរិវេណ​គម្រោង​ដែល​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> បាន​លក់​ជូន​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span>។</li>
    <li class="khmer">សាង​សង់ និង​ភ្ជាប់​បណ្តាញ​ប្រព័ន្ធ​អគ្គិសនី និង​ចាក់​ដី​បំពេញ​មិន​ឲ្យ​លិច​ទឹក​ក្នុង​បរិវេណ​គម្រោង​ដែល​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> បាន​លក់​ជូន​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span>។</li>
</ul>
<p class="zh pb-0 mb-0"><span class="text-bold">5.1 “出售”</span>方承诺将按照自己的开发工作阶段的计划及时间表进行开发不动产给<span class="text-bold">“购买”</span>方如下：</p>
<ul class="ml-4 mb-2">
    <li class="zh">在<span class="text-bold">“出售”</span>方出售给<span class="text-bold">“购买”</span>方的项目范围内进行建设混凝土路。</li>
    <li class="zh">在<span class="text-bold">“出售”</span>方出售给<span class="text-bold">“购买”</span>方的项目范围内进行建设下水道系统。</li>
    <li class="zh">在<span class="text-bold">“出售”</span>方出售给<span class="text-bold">“购买”</span>方的项目范围内连接净水系统。</li>
    <li class="zh">在<span class="text-bold">“出售”</span>方出售给<span class="text-bold">“购买”</span>方的项目范围内进行建设及连接电力系统以及填土不让其溺水。</li>
</ul>
<p class="khmer pb-0"><span class="khmer text-bold">៥.២.</span> ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> សន្យា​ថា​បើ​ថ្ងៃ​ក្រោយ​មាន​តតិយជន​ណា​មួយ​ចេញ​មក​តវ៉ា ឬ​ទាម​ទារ​សិទ្ធិ​លើ​អចលនវត្ថុ​ខាង​លើ ហើយ​អះអាង​ថា​អចលនវត្ថុ​នេះមិ​នមែន​ស្ថិត​ក្រោម​កម្មសិទ្ធិ​របស់ ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ឬ​ថា​ជា​អចលនវត្ថុ​មិន​ស្រប​ច្បាប់ ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> សុខ​ចិត្ត​ទទួល​ខុស​ត្រូវ​ដោះស្រាយទាំង​ស្រុង​ចំពោះ​មុខច្បាប់ ហើយ​ការ​ចំណាយ​នា​នា​ទាក់ទង​នឹង​បញ្ហា​ខាងលើ ជា​ការ​ទទួល​ខុសត្រូវ​ទាំង​ស្រុង​របស់​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span>។</p>

<p class="zh"><span class="text-bold">5.2 “出售”</span>方承诺日后若有任何第三者出面抗议或索求上述不动产权利，其声明不动产不是在<span class="text-bold">“出售”</span>方的权利下或不动产是违法的，<span class="text-bold">“出售”</span>方愿意在法律面前负全责解决，且与上述问题相关的费用由<span class="text-bold">“出售”</span>方负全责。</p>

<p class="khmer pb-0"><span class="khmer text-bold">៥.៣.</span> ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ក្រោយ​ពេល​ទទួល​បាន​អចលនវត្ថុ​ពី​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ហើយ​នៅ​ពេល​ណា​ដែល​ខ្លួន​មាន​ចេតនា​សាង​សង់​សំណង់​លំនៅឋាន ឬ​សំណង់​ផ្សេងៗ​នោះ ត្រូវ​បន្សល់​ទុក​ដី​ខាង​មុខ​សំណង់​របស់​ខ្លូន​ចំនួន <span class="khmer text-bold">០៤(បួន) ម៉ែត្រ</span> ដោយ​វាស់​ចេញ​ពី​ផ្នែក​មុខ​នៃ​សំណង់​របស់​ខ្លួន ហើយ​ទុក​ខាង​ក្រោយ​សល់ <span class="khmer text-bold">០១ (មួយ) ម៉ែត្រ</span> ដោយ​វាស់​ចេញ​ពី​ផ្នែក​ខាង​ក្រោយ​នៃ​សំណង់​របស់​ខ្លួន។</p>

<p class="zh"><span class="text-bold">5.3 </span>当<span class="text-bold">“购买”</span>方从<span class="text-bold">“出售”</span>方接受不动产之后，且自己有意建设住宅或其他建筑物，则须从自己的工程的前面部分测量保留自己工程前方的土地04（四）米，以及从自己的工程的后面部分测量保留后方01（一）米。</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៦៖ ថ្លៃសេវាថែទាំគ្រប់គ្រងក្នុងបរិវេណគម្រោងអភិវឌ្ឍន៍</p>
<p class="zh pb-0 mb-0 text-bold">第６条：开发项目范围内的管理保养服务费</p>
<p class="khmer pb-0">ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> យល់​ព្រម​បង់ថ្លៃ អនាម័យ សណ្ដាប់ធ្នាប់ សន្តិសុខ សោភ័ណ្ឌភាព ភ្លើងបំភ្លឺសាធារណៈ និង​ការ​ជួសជុល​ផ្លូវ​ខូចខាត​ជូន​មក ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> សម្រាប់​មួយ​ឆ្នាំ​ម្តង ទៅ​តាម​តម្លៃ​ទីផ្សារ​ជាក់​ស្តែង​ដែល ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> នឹង​កំណត់​នៅ​ពេល​អនាគត ហើយ​ត្រូវ​បង់​មួយ​ឆ្នាំ​ទុក​ជា​មុន នៅ​ពេល​ដែល​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ចាប់​ផ្ដើម​ធ្វើ​ការ​សាង​សង់​សំណង់​លំនៅឋាន ឬ​សំណង់​ផ្សេងៗ​លើ​អចលនវត្ថុ។ ក្នុង​ករណី​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> មាន​បំណង តភ្ជាប់​បណ្តាញ​ប្រព័ន្ធ​ទឹកស្អាត និង​ចរន្ត​អគ្គិសនី​ចូល​ទៅ​ក្នុង​លំនៅឋាន​របស់​ខ្លួន ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ត្រូវ​ទទួល​ខុស​ត្រូវ​ទៅ​លើ​ការ​ចំណាយ​ទាំងស្រុង។</p>
<p class="zh"><span class="text-bold">“购买”</span>方同意支付卫生费、秩序、保安、外观、公共路灯及维修损坏的道路给<span class="text-bold">“购买”</span>方一年一次按照<span class="text-bold">“出售”</span>方在未来所规定的实际市场价格，且在<span class="text-bold">“购买”</span>方开始在不动产上建设住宅或其他建筑物之际须预付一年时间。若<span class="text-bold">“购买”</span>方有意连接净水系统以及电系统到自己的住宅，<span class="text-bold">“购买”</span>方须对全部费用负责。</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៧៖ ប័ណ្ណបញ្ជាក់សិទ្ធិលើកម្មសិទ្ធិនៃអចលនវត្ថុនៃការលក់ទិញ</p>
<p class="zh pb-0 mb-0 text-bold">第7条：购销不动产权利上的产权证</p>
<p class="khmer pb-0">ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> សន្យា​ថា​នឹង​ប្រគល់​ប័ណ្ណ​បញ្ជាក់​សិទ្ធិ​លើ​កម្មសិទ្ធិ​នៃ​អចលនវត្ថុ​នៃ​ការ​លក់ទិញ ជា​ប្រភេទ​ដូច​ចែង​ក្នុង​ <span class="khmer text-bold">ប្រការ១៖ អត្តសញ្ញាណ​នៃ​អចលនវត្ថុ​លក់ទិញ និង​តម្លៃ​លក់​ទិញ</span> ជូនភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> បន្ទាប់​ពី​ភាគី <span class="khmer text-bold">“អ្នកទិញ”៖</span> <span class="khmer text-bold">(១).</span> បាន​ទទួល​យក​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ​ពី​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> រួច​រាល់​ហើយ <span class="khmer text-bold">(២).</span> បាន​ទូ​ទាត់​បង់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​រួច​រាល់​គ្រប់​ចំនួន​ជូនមក ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ដូច​បាន​ចែង​ក្នុង​ឧបសម្ព័ន្ធទី១ <span class="khmer text-bold">“តារាង​កាល​វិភាគ​នៃ​ការ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ” (៣).</span> មក​បំពេញ​បែប​បទ និង​ឯកសារ​គ្រប់គ្រាន់​ជូន​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ដើម្បី​រៀប​ចំ​ដាក់​ស្នើ ឬ​រៀប​ចំ​បែបបទ​រដ្ឋបាល​ជា​មួយ​មន្ត្រី​ជំនាញ​សុរិយោ​ដី​ដើម្បី​ស្នើ​ទៅ​តាម​នីតិ​វិធី​ច្បាប់ឲ្យ​បាន​ទាន់​ពេល​វេលា និង​រលូន​ជូន​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> (ប្រសិន​បើ​ត្រូវ​ការ)។ ទោះ​ជា​យ៉ាង​ណា​ក៏​ដោយ​ ប្រសិន​បើ​មាន​ការ​យឺត​យ៉ាវ​ក្នុង​ការ​សម្រេច និង​អនុញ្ញាត​ចេញ​ប័ណ្ណ​បញ្ជាក់​សិទ្ធិ​លើ​កម្មសិទ្ធិ​លើ​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ ដោយ​សារ​តែ​បញ្ហា​បច្ចេកទេស ឬ​រដ្ឋបាល​របស់​មន្ត្រី​សុរិយោដី ឬ​មន្ត្រី​មាន​សមត្ថកិច្ច​នោះ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> មិន​អាច​តវ៉ា ឬ​ទំលាក់​កំហុស​លើ​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ដែល​បាន​ប្រឹងប្រែង​អស់​ពី​សមត្ថភាព​ហើយ​នោះទេ។ ការ​ចំណាយ​លើ​ការ​រៀប​ចំ​ឯកសារ​ផ្ទេរ​សិទ្ធិ​លើ​កម្មសិទ្ធិ ដូច​ចែងក្នុង <span class="khmer text-bold">ប្រការ១</span> បូក​រួម​នឹង​ការ​បង់​ពន្ធ​ប្រថាប់​ត្រា <span class="khmer text-bold">៤% (បូនភាគរយ)</span> គឺ​ជាការ​ទទួល​ខុស​ត្រូវ​ដោយ​ផ្ទាល់​របស់ ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ដោយ​ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ជួយ​សម្រួល និង​រៀបចំ​ឯក​សារ​ពាក់​ព័ន្ធ​ជូន​ទៅ​តាម​ស្ថាន​ភាព​ជាក់ស្តែង។</p>
<p class="zh"><span class="text-bold">“出售”</span>方承诺将交纳如第１条：购销不动产的身份及购销价里所载的购销不动产权利上的产权证给<span class="text-bold">“购买”</span>方，当<span class="text-bold">“购买”</span>方：（１）已从<span class="text-bold">“出售”</span>方接受购销不动产完毕（２）已按照附件1<span class="text-bold">“不动产购销价款的结算时间表”</span>里所载支付全额的不动产购销价款给 <span class="text-bold">“出售”</span>方，（3）办理全部的手续及文件给 <span class="text-bold">“出售”</span>方以便让其与专业官员办理申请手续或办理行政手续以便按照法律程序及时及顺利申请给<span class="text-bold">“购买”</span>方（若有必要）。无论如何，若出具购销不动产权利上的产权证的决定及批准因地籍官员或职能官员的行政或技术有所延误，则<span class="text-bold">“购买”</span>方不可抗议或冤枉已尽力的<span class="text-bold">“出售”</span>方。第１条所载的权利上所办理的转让文件的费用包括4%（百分之四）的印花税由<span class="text-bold">“购买”</span>方自行负责，而<span class="text-bold">“出售”</span>方按照实际情况给予协助及办理相关文件。</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៨៖ ការទទួលខុសត្រូវបង់ពន្ធអចលនវត្ថុប្រចាំឆ្នាំរបស់គូភាគី</p>
<p class="zh pb-0 mb-0 text-bold">第8条：双方的年度不动产缴税责任</p>
<p class="khmer pb-0"><span class="khmer text-bold">៨.១</span> ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> ទទួល​ខុស​ត្រូវ​ទាំង​ស្រុង​ចំពោះ​ការ​បង់​ពន្ធ​អចលនវត្ថុ​ប្រចាំ​ឆ្នាំ ឬ​បង់​ពន្ធ​ដី​មិន​បាន​ប្រើ​ប្រាស់​ឬ​ពន្ធ​នានា​ពាក់​ព័ន្ធ​នឹង​អាជីវកម្ម​សាង​សង់​លំនៅឋាន​របស់​ខ្លួន​មុន​កាលបរិច្ឆេទ​នៃ​ការ​ប្រគល់​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ​ជូន​ទៅ​ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span>។</p>
<p class="zh"><span class="text-bold">8.1</span> 在交纳购销不动产给<span class="text-bold">“购买”</span>方之日前，<span class="text-bold">“出售”</span>方须负全责缴纳年度不动产税或缴纳没有使用的土地税或其他与自己建设住宅的业务有关的税务。</p>

<p class="khmer pb-0"><span class="khmer text-bold">៨.២</span> ភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> ត្រូវ​ទទួល​ខុស​ត្រូវ​លើ​ការ​បង់​ពន្ធ​អចលវត្ថុ​ប្រចាំ​ឆ្នាំ និង​ពន្ធ​ផ្សេង​ទៀត​ពាក់​ព័ន្ធ​នឹង​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ​ខាង​លើ​បន្ទាប់​ពី​កាល​បរិច្ឆេទ​ទទួល​យក​អចលនវត្ថុ​នៃ​ការ​លក់​ទិញ ពីភាគី <span class="khmer text-bold">“អ្នកលក់”</span>។</p> 
<p class="zh"><span class="text-bold">8.2</span> 当从<span class="text-bold">“出售”</span>方接受购销不动产之日之后，<span class="text-bold">“购买”</span>方须负责缴纳年度不动产税以及其他与上述购销不动产有关的税务。</p>

<p class="khmer-title pb-0 mb-0">ប្រការ៩៖ ទាយាទ អ្នកស្នងមរតក និងអ្នកទទួលសិទ្ធិស្របច្បាប់</p>
<p class="zh pb-0 mb-0 text-bold">第９条：后嗣、继承人及合法受权人</p>
<p class="khmer pb-0">ក្នុង​ករណី​ដែល​មាន​ភាគី​ណា​មួយ មិន​អាច​អនុវត្ត​សិទ្ធិ និង​កាតព្វកិច្ច​របស់​ខ្លួន​បាន​ដោយ​មូលហេតុ​ណា​មួយ​បណ្តាល​មក​ពី មរណភាព ពិការភាព ឬ​អវត្តមាន​ជា​បណ្តោះ​អាសន្ន ឬ​អចិន្ត្រៃយ៍​នៅ​ក្នុង​ប្រទេស​នោះ រាល់​សិទ្ធិ និង​កាតព្វកិច្ច​ទាំង​អស់​របស់​ភាគី​នោះ​ដែល​ស្ថិត​ក្រោម​ខ្លឹមសារ​នៃ​កិច្ចសន្យា​នេះ ត្រូវ​បន្ត​ទៅ​ទាយាទ និង/ឬ អ្នក​ស្នង​មរតក និង/ឬអ្នកតំណាង​ស្រប​ច្បាប់​ណា​មួយ​របស់​ខ្លួន​ដោយ​ស្វ័យប្រវត្តិ។</p>
<p class="zh">若任何一方因逝世、残废或在国内暂时或永久缺席的任何原因导致不能执行自己的权利和义务，该方在本合同内容下的所有权利和义务将自动转让给自己的任何后嗣及/或继承人及/或法定代表人。</p>

<p class="khmer-title pb-0 mb-0">ប្រការ១០៖ គោលការណ៍ស្ម័គ្រចិត្ត និងការព្រមព្រៀងនៃកិច្ចសន្យា</p>
<p class="zh pb-0 mb-0 text-bold">第10条：自愿原则及合同的协议</p>
<p class="khmer pb-0">កិច្ចសន្យា​លក់​ទិញ​អចលនវត្ថុ​នេះ ត្រូវ​ធ្វើ​ឡើង​ដោយ​គ្មាន​ការ​គំរាម​កំហែង បង្ខិតបង្ខំ ឬ​មាន​បញ្ហា​ខុស​ច្បាប់​ណា​មួយ​ឡើយ ហើយ <span class="khmer text-bold">គូភាគី</span> មាន​សមត្ថភាព​គ្រប់គ្រាន់​ក្នុង​ការ​ដឹង​លឺ ឬ​យល់​ដឹង បាន​អាន បានស្តាប់ និង​យល់​ព្រម​តាម​លក្ខខណ្ឌ​ទាំងឡាយ​នៃ​កិច្ចសន្យា​នេះ។ កិច្ចសន្យា​លក់​ទិញ​អចលនវត្ថុ​នេះ មាន​សុពលភាព​នា​កាលបរិច្ឆេទ​ដែល <span class="khmer text-bold">គូភាគី</span> បាន​ផ្តិត​ស្នាម​មេដៃ និង​ចុះ​ត្រា​ក្រុមហ៊ុន​ដូច​ខាង​ក្រោម។ កិច្ចសន្យា​លក់ទិញ​អចលនវត្ថុ​នេះ​ធ្វើ​ឡើង​ជាភាសាខ្មែរ​ចំនួន <span class="khmer text-bold">០២ (ពីរ)</span> ឯកសារ​ច្បាប់​ដើម ក្នុងនោះ ភាគី <span class="khmer text-bold">“អ្នកលក់”</span> រក្សាទុក <span class="khmer text-bold">០១ (មួយ)</span> ឯកសារ​ច្បាប់ដើម ហើយភាគី <span class="khmer text-bold">“អ្នកទិញ”</span> រក្សាទុក <span class="khmer text-bold">០១ (មួយ)</span> ឯកសារ​ច្បាប់​ដើម។ ឯកសារ​នីមួយៗ​មាន​សុពលភាព និង​អានុភាព​គតិយុត្តិ​ស្មើៗ និងដូចគ្នា។</p>
<p class="zh">本不动产购销合同在无任何威胁、逼迫或违法问题下订立，双方有足够能力知晓或了解并已阅读、聆听及了解本合同的全部条件。本不动产购销合同自双方在下面按拇指印及盖公司印章之日生效。本不动产购销合同以柬文书写一式02（二）份正本，其中“出售”方执01（一）份正本，“购买”方执01（一）份正本。每份具备同等法律效力。</p>
@endsection

@section('first')
<h4 class="khmer-title text-center">ឧបសម្ព័ន្ធទី៣៖</h4> 
<h4 class="zh text-bold text-center">附件3：</h4>  
<h4 class="khmer-title mb-4 text-center">“អត្តសញ្ញាណប័ណ្ណ ឬលិខិតឆ្លងដែនរបស់ភាគី អ្នកលក់ និងភាគី អ្នកទិញ”</h4>
<h4 class="zh text-bold mb-4 text-center">“出售方和购买方的身份证或护照”</h4>

@if(array_key_exists('customer1_id_front',$attachment_array) || array_key_exists('customer2_id_front',$attachment_array))  
<p class="khmer text-bold">- អត្តសញ្ញាណប័ណ្ណ អ្នកទិញ</p>
<p class="zh text-bold">- 买家身份证</p>
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

