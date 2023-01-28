<?php

namespace App\Http\Controllers;

use App;
use PDF;
use App\Contract;
use App\UnitType;
use App\Project;
use App\Helpers\NumberFormat;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ContractTemplatePreviewController extends Controller
{
	const TEMPLATE_PATH = "admin.contract.template.";

	public function showTemplate(Request $request)
	{
        $unit_types = UnitType::query();
        $unit_types = $unit_types->with(['project']);
        $projects = Project::withTrashed()->get();

        if ( $request->query('status') ) {
            $unit_types = $unit_types->ofStatus($request->query('status'));
        } else {
            $unit_types = $unit_types->ofStatus();
        }

        if ( $request->query('project') ) {
            $unit_types = $unit_types->where('project_id', $request->query('project'));
        }

        if ( $request->query('term') ) {
            $term = $request->query('term');
            $unit_types = $unit_types->where('name' , 'LIKE', '%'.$term.'%');
        }

        $unit_types = $unit_types->paginate();

        return view('contract_template.index', compact('unit_types','projects'));
	}

	public function preview(Request $request, $template_path)
	{
		$contract = $this->getSampleContract($request->query("unit_type_id"));       
		$unit  = $contract->unit;
		$unit_type = $unit->unitType;
		$project = $unit_type->project;
		$company = $project->company;
		$sale_representative = $project->saleRepresentative;
		$bank = $project->bank;
		$customer1 = $this->getCustomer1Data($contract);
		$customer2 = $this->getCustomer2Data($contract);
		$template = $unit_type->contractTemplate;
		$pdf = App::make('snappy.pdf.wrapper');
		$language = $request->language ?? 'km';
		if ( $request->version ) {
			$pdf->setOption('margin-top', '2.7mm');
			$pdf->setOption('margin-bottom', '2.7mm');
			$pdf->setOption('margin-left', '7.8mm');
			$pdf->setOption('margin-right', '12.7mm');
			$template_path = self::TEMPLATE_PATH.$request->version.'.'.$language.'.'.$template_path;
		} else {
			$template_path = self::TEMPLATE_PATH.$template_path;
		}

		if ( View::exists($template_path) ) {
			$pdf = App::make('snappy.pdf.wrapper');            
			$payment_data = [
				'unit_sale_price' => $contract->unit_sale_price,
				'discount_promotion' => $contract->discount_promotion,
				'other_discount_allowed' => $contract->other_discount_allowed,
				'deposited_amount' => $contract->deposited_amount,
				'deposited_at' => $contract->deposited_at->toDateString(),
				'start_payment_date' => $contract->start_payment_date->toDateString(),
				'loan_duration' => $contract->loan_duration,
				'interest' => $contract->interest,
				'special_discount' => $contract->special_discount,
				'is_first_payment' => $contract->is_first_payment,
				'first_payment_duration' => $contract->first_payment_duration,
				'first_payment_percentage' => $contract->first_payment_percentage,                
				'first_payment_amount' => $contract->first_payment_amount, 
				'loan_result_rounding' => $contract->loan_result_rounding,
				'start_payment_number' => $contract->start_payment_number,
				'signed_at' => $contract->signed_at
			];
			$payment_schedule = LoanController::getAmortizationScheduleCollection($payment_data);
			$pmt =  LoanController::pmt($contract->interest, $contract->loan_duration, $contract->getTotalFirstPaymentAmount());
			$attachment_array = $contract->getAttachmentsArrayWithTypeKey();
			$is_template = true;
			$html = View::make($template_path, compact('contract', 'project', 'company', 'unit', 'unit_type','bank','sale_representative', 'customer1', 'customer2', 'payment_schedule', 'pmt', 'attachment_array', 'is_template'));
			if ( $request->version ) {
				$pdf->loadHTML($html)
					->setOption('margin-top', '12.7mm')
					->setOption('margin-bottom', '12.7mm')
					->setOption('margin-left', '12.7mm')
					->setOption('margin-right', '12.7mm');
			} else {
				$pdf->loadHTML($html);
			}
			return $pdf->inline("contract - ".$contract->customer1_name.'.pdf');
		} else {
			Log::warning("Contract PDF Template is not found. file : ".$template_path);
			return back()->withErrors(['pdf_fail' => "System detected that the PDF template file was not found or not in the correct format.\n Please contact your System Administrator"]);
		}
	}

	private function getSampleContract($unit_type_id = null)
	{
		$user = App\User::first();
		$contract = New App\Contract();
		$unit  = New App\Unit();

		if ( is_null($unit_type_id) ) {
			$unit = App\Unit::inRandomOrder()->first();
		} else {       
			$unit = App\Unit::where("unit_type_id",$unit_type_id)->first();
		}

		if (!$unit) {
			abort(404, "We could not find any unit which related with this Unit Type.");
		}

		$unit_type = $unit->unitType;

		$contract->customer1_name = "អតិថិជន តេស្ត";
		$contract->customer1_gender = 1;
		$contract->customer1_birthdate = Carbon::createFromDate(1990,1,1);
		$contract->customer1_nid = "999999999";
		$contract->customer1_nid_issued_date = Carbon::createFromDate(2018,1,1);
		$contract->customer2_name = "";
		$contract->customer2_gender = 1;
		$contract->customer2_birthdate = Carbon::createFromDate(1990,1,1);
		$contract->customer2_nid = "";
		$contract->customer2_nid_issued_date = Carbon::createFromDate(2018,1,1);
		$contract->customer_phone_number = "0123456789";
		$contract->customer_phone_number2 = "01234567890";
		$contract->customer_house_no = "១២៣អឺ០";
		$contract->customer_street = "១២៣អឺ០";
		$contract->customer_phum = "១២៣អឺ០";
		$contract->customer_commune = "៤";
		$contract->customer_district = "ដូនពេញ";
		$contract->customer_city = "ភ្នំពេញ";
		$contract->unit_id = $unit->id;

		$contract->unit_sold_at = Carbon::today();
		$contract->signed_at = Carbon::today()->addWeek();   	
		$contract->unit_remark = "តេស្តការកំណត់ចំនាំ";
		$contract->unit_sale_price = 100000;
		$contract->discount_promotion = 2000;
		$contract->other_discount_allowed = 2000;
		$contract->deposited_amount = 1000;
		$contract->deposited_at = Carbon::today()->subWeek();
		$contract->payment_option_id = null;
		$contract->loan_duration = 32;
		$contract->interest = 12;
		$contract->special_discount = 10;
		$contract->is_first_payment = true;
		$contract->first_payment_duration = 5;
		$contract->first_payment_percentage = 4;
		$contract->first_payment_amount = 0;
		$contract->loan_result_rounding = true;
		$contract->start_payment_number = 1;
		$contract->start_payment_date = Carbon::today()->addWeek();
		$contract->annual_management_fee = $unit_type->annual_management_fee;
		$contract->contract_transfer_fee = $unit_type->contract_transfer_fee;
		$contract->management_fee_per_square = $unit_type->management_fee_per_square;
		$contract->deadline = $unit_type->deadline;
		$contract->extended_deadline = $unit_type->extended_deadline;
		
		$contract->title_clause_zh = $unit_type->title_clause_zh;
		$contract->management_service_zh = $unit_type->management_service_zh;
		$contract->equipment_text_zh = $unit_type->equipment_text_zh;			
	
		$contract->title_clause_en = $unit_type->title_clause_en;
		$contract->management_service_en = $unit_type->management_service_en;
		$contract->equipment_text_en = $unit_type->equipment_text_en;			
	
		$contract->title_clause_kh = $unit_type->title_clause_kh;
		$contract->management_service_kh = $unit_type->management_service_kh;
		$contract->equipment_text = $unit_type->equipment_text;			
		
		return $contract;
	}
	
	/* return Array
	*/
	private function getCustomer1Data($contract)
	{
		$attachment_array = $contract->getAttachmentsArrayWithTypeKey();
		return [
			'name' => $contract->customer1_name,
			'gender' => $contract->customer1_gender,
			'birth_day' => $contract->customer1_birthdate->day,
			'birth_month' =>  $contract->customer1_birthdate->month,
			"birth_year" => $contract->customer1_birthdate->year,
			"nid_number" => $contract->customer1_nid,
			'nid_issued_day' => $contract->customer1_nid_issued_date->day,
			'nid_issued_month' => $contract->customer1_nid_issued_date->month,
			'nid_issued_year' => $contract->customer1_nid_issued_date->year,
			'nationality' => $contract->customer1_nationality ? $contract->customer1_nationality : "ខ្មែរ",
            'indentity_text' => array_key_exists('customer1_id_front',$attachment_array) ? "អត្តសញ្ញាណប័ណ្ណ" : "លិខិតឆ្លងដែន"
		];
	}

	/* return Array
	*/
	private function getCustomer2Data($contract)
	{
		$attachment_array = $contract->getAttachmentsArrayWithTypeKey();
		return [
			'name' => $contract->customer2_name,
			'gender' => $contract->customer2_gender,
			'birth_day' => $contract->customer2_birthdate->day,
			'birth_month' => $contract->customer2_birthdate->month,
			"birth_year" => $contract->customer2_birthdate->year,
			"nid_number" =>$contract->customer2_nid,
			'nid_issued_day' => $contract->customer2_nid_issued_date->day,
			'nid_issued_month' => $contract->customer2_nid_issued_date->month,
			'nid_issued_year' =>$contract->customer2_nid_issued_date->year,
			'nationality' => $contract->customer2_nationality ?  $contract->customer2_nationality : "ខ្មែរ",
            'indentity_text' => array_key_exists('customer2_id_front',$attachment_array) ? "អត្តសញ្ញាណប័ណ្ណ" : "លិខិតឆ្លងដែន"
		];
	}

}
