<?php

namespace App\Http\Controllers\Admin;

use App;
use PDF;
use App\Helpers\NumberFormat;
use App\Contract;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Controller;

class ContractPdfController extends Controller
{

    const TEMPLATE_PATH = "admin.contract.template.";

    public $contract;

    public function __construct(Contract $contract) 
    {
        $this->contract = $contract;
    }

    public function getContractPdfFile(Request $request, $id) 
    {
        $contract = Contract::findOrFail($id);  
           
        try {
            $unit_contract_request = $contract->unitContractRequest;
            $unit  = $contract->unit;
            $unit_type = $unit->unitType;
            $project = $unit_type->project;
            $company = $project->company;
            $bank = $project->bank;
            $customer1 = $this->getCustomer1Data($contract);            
            $customer2 = $this->getCustomer2Data($contract);            
            $sale_representative = $contract->saleRepresentative;
            $template = $unit_type->contractTemplate;
            $language = $request->language ?? 'km';

            $template_path = self::TEMPLATE_PATH.$template->template_path;
            if ( $request->version ) {
                $template_path = self::TEMPLATE_PATH.$request->version.'.'.$language.'.'.$template->template_path;
            } else {
                $template_path = self::TEMPLATE_PATH.$template->template_path;
            }                  
          
            if ( View::exists($template_path) ) {                
                $pdf = App::make('snappy.pdf.wrapper');          
                // $pdf->setOption('enable-smart-shrinking', true);
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
                    'first_payment_amount' => is_null($contract->first_payment_amount) ? 0 : $contract->first_payment_amount,
                    'loan_result_rounding' => $contract->loan_result_rounding,
                    'start_payment_number' => $contract->start_payment_number,
                    'signed_at' => $contract->signed_at
                ];

                $payment_schedule = LoanController::getAmortizationScheduleCollection($payment_data);                   


                $pmt =  LoanController::pmt($contract->interest, $contract->loan_duration, $contract->getPrincipalAmount());
     
                $attachment_array = $contract->getAttachmentsArrayWithTypeKey();                
                $html = View::make($template_path, compact('contract', 'project', 'company', 'unit', 'unit_type','bank','sale_representative', 'customer1', 'customer2', 'payment_schedule', 'pmt', 'attachment_array'));
                if ( $request->version ) {
                    $pdf->loadHTML($html)
                        ->setOption('margin-top', '12.7mm')
                        ->setOption('margin-bottom', '12.7mm')
                        ->setOption('margin-left', '12.7mm')
                        ->setOption('margin-right', '12.7mm')
                        ->setOption('footer-font-name', 'Times New Roman')
                        ->setOption('footer-font-size', '6')
                        ->setOption('footer-right', 'Page: [page] of [topage]');
                } else {
                    $pdf->loadHTML($html);
                }      
                return $pdf->inline($contract->unit->code." - ".$contract->customer1_name.'.pdf');
            } else {
                Log::warning("Contract PDF Template is not found. file : ".$template_path);
                return back()->withErrors(['pdf_fail' => "System detected that the PDF template file was not found or not in the correct format.\n Please contact your System Administrator"]);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['pdf_fail' => "System encounter with some problem while trying to process your request. \n".$e->getMessage()]);
        }
    }

    public function getContractView(Request $request, $id) 
    {   
        $contract = Contract::findOrFail($id); 
        $this->contract = $contract;
        return $this->getContractHtml($request->language ?? 'km', $request->version ?? 'v2');
    }

    public function getContractPdf($locale = 'km', $version = 'v2') 
    {
        $pdf = App::make('snappy.pdf.wrapper'); 
        $pdf->loadHTML($this->getContractHtml($locale, $version))
            ->setOption('margin-top', '12.7mm')
            ->setOption('margin-bottom', '12.7mm')
            ->setOption('margin-left', '12.7mm')
            ->setOption('margin-right', '12.7mm'); 
        return $pdf->inline($this->contract->unit->code." - ".$this->contract->customer1_name.'.pdf');
    }

    private function getContractHtml($locale = 'km', $version = 'v2')
    {
        $contract = $this->contract;
        $payment_schedule = $this->getPaymentSchedule();
        $unit  = $contract->unit;
        $unit_type = $unit->unitType;
        $project = $unit_type->project;
        $company = $project->company;
        $bank = $project->bank;
        $customer1 = $this->getCustomer1Data($contract);            
        $customer2 = $this->getCustomer2Data($contract);       
        $sale_representative = $project->saleRepresentative;
        $template = $unit_type->contractTemplate;
        $template_path = self::TEMPLATE_PATH.$version.'.'.$locale.'.'.$template->template_path;

        if ( !View::exists($template_path) ) {  
            throw new \Exception("Template file is not found", 500);            
        }  
       
        $pmt =  LoanController::pmt(
            $contract->interest, 
            $contract->loan_duration, 
            $this->contract->getTotalFirstPaymentAmount()
        );

        $attachment_array = $contract->getAttachmentsArrayWithTypeKey();

        return View::make($template_path, compact(
            'contract', 
            'project', 
            'company', 
            'unit', 
            'unit_type', 
            'bank', 
            'sale_representative', 
            'customer1',
            'customer2',
            'payment_schedule',
            'pmt',
            'attachment_array'
        ));      
    }

    private function getPaymentSchedule()
    {
        $payment_schedule_request_data = $this->getPaymentScheduleRequestArray();
        return LoanController::getAmortizationScheduleCollection($payment_schedule_request_data);
    }

    private function getPaymentScheduleRequestArray()
    {
        return [
            'unit_sale_price' => $this->contract->unit_sale_price,
            'discount_promotion' => $this->contract->discount_promotion,
            'other_discount_allowed' => $this->contract->other_discount_allowed,
            'deposited_amount' => $this->contract->deposited_amount,
            'deposited_at' => $this->contract->deposited_at->toDateString(),
            'start_payment_date' => $this->contract->start_payment_date->toDateString(),                    
            'loan_duration' => $this->contract->loan_duration,
            'interest' => $this->contract->interest,
            'special_discount' => $this->contract->special_discount,
            'is_first_payment' => $this->contract->is_first_payment,
            'first_payment_duration' => $this->contract->first_payment_duration,
            'first_payment_percentage' => $this->contract->first_payment_percentage,
            'first_payment_amount' => is_null($this->contract->first_payment_amount) ? 0 : $this->contract->first_payment_amount,
            'loan_result_rounding' => $this->contract->loan_result_rounding,
            'start_payment_number' => $this->contract->start_payment_number,
            'signed_at' => $this->contract->signed_at
        ];
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
            'nationality' => $contract->customer1_nationality ?? "ខ្មែរ",
            'indentity_text' => array_key_exists('customer1_id_front',$attachment_array) ? "អត្តសញ្ញាណប័ណ្ណ" : "លិខិតឆ្លងដែន"
        ];
    }

    /* return Array
    */
    private function getCustomer2Data($contract)
    {
        $attachment_array = $contract->getAttachmentsArrayWithTypeKey();
        if ( $contract->customer2_name != '' ) {
            return [
                'name' => $contract->customer2_name,
                'gender' => $contract->customer2_gender,
                'birth_day' => $contract->customer2_birthdate->day,
                'birth_month' =>  $contract->customer2_birthdate->month,
                "birth_year" => $contract->customer2_birthdate->year,
                "nid_number" => $contract->customer2_nid,
                'nid_issued_day' => $contract->customer2_nid_issued_date->day,
                'nid_issued_month' => $contract->customer2_nid_issued_date->month,
                'nid_issued_year' => $contract->customer2_nid_issued_date->year,           
                'nationality' => $contract->customer2_nationality ? $contract->customer2_nationality : "ខ្មែរ",
                'indentity_text' => array_key_exists('customer2_id_front',$attachment_array) ? "អត្តសញ្ញាណប័ណ្ណ" : "លិខិតឆ្លងដែន"
            ];
        } else {
            return [
                'name' => '',
                'gender' => $contract->customer2_gender == 1 ? "ប្រុស" : "ស្រី",
                'birth_day' => $contract->customer2_birthdate->day,
                'birth_month' => $contract->customer2_birthdate->month,
                "birth_year" => $contract->customer2_birthdate->year,
                "nid_number" => $contract->customer2_nid,
                'nid_issued_day' => $contract->customer2_nid_issued_date->day,
                'nid_issued_month' => $contract->customer2_nid_issued_date->month,
                'nid_issued_year' => $contract->customer2_nid_issued_date->year,           
                'nationality' => $contract->customer2_nationality ? $contract->customer2_nationality : "ខ្មែរ",
                'indentity_text' => array_key_exists('customer2_id_front',$attachment_array) ? "អត្តសញ្ញាណប័ណ្ណ" : "លិខិតឆ្លងដែន"
            ];
        }        
    }
}
