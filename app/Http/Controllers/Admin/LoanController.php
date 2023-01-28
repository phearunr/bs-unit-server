<?php

namespace App\Http\Controllers\Admin;

use App\PaymentOption;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoanController extends Controller
{
  public function getAmortizationSchedule(Request $request)
  {

    $validatedData = $request->validate([
      'unit_sale_price' => 'required|numeric|min:0',
      'discount_promotion' => 'required|numeric|min:0',
      'other_discount_allowed' => 'required|numeric|min:0',
      'deposited_amount' => 'required|numeric|min:0',
      'deposited_at' => 'required|date',      
      'start_payment_date' => 'required|date|after_or_equal:deposited_at',
      'loan_duration' => 'required|integer|min:1',
      'interest' => 'required|numeric|min:0',
      'special_discount' => 'required|numeric|min:0|max:100',
      'is_first_payment' => 'required|boolean',
      'first_payment_duration' => 'required_if:is_first_payment,true|integer|min:0',
      'first_payment_percentage' => 'nullable|numeric|min:0',
      'first_payment_amount' => 'nullable|numeric|min:0',
      'loan_result_rounding' => "required|boolean",
      'start_payment_number' => "required|integer",
      'signed_at' => "required|date"        
    ]);
    
    $validatedData = $this->covertToStandardDateFormat(
      $validatedData, ['deposited_at','signed_at','start_payment_date']
    );
    return self::getAmortizationScheduleCollection($validatedData);
  }

  // public function paymentDate()
  // {
  //   return self::getPaymentDate(2018,12,10);
  // }

  public static function getAmortizationScheduleCollection( Array $data )
  {
    extract($data);
    $balance = $unit_sale_price - $discount_promotion - $other_discount_allowed;
    $balance = $balance - ( $balance * $special_discount / 100 );
    $deposited_at = Carbon::createFromFormat('Y-m-d', $deposited_at);
    $payment_date = Carbon::createFromFormat('Y-m-d', $start_payment_date);

    if ( !($signed_at instanceof \Carbon\Carbon) ) {
      $signed_at = Carbon::createFromFormat('Y-m-d', $signed_at);
    }    
    
    $first_payment_collection = [];
    if ( $is_first_payment ) {    
      $first_payment_collection = self::getFirstPayments($balance, $first_payment_duration, $first_payment_percentage, $first_payment_amount, $deposited_at, $deposited_amount, $signed_at, $payment_date, $payment_date->day, $start_payment_number, $loan_result_rounding);
    }

    if ( count($first_payment_collection) > 0 ) {
      $balance = $first_payment_collection[count($first_payment_collection)-1]['ending_balance'];
    }     

    $loan_schedule_collection = self::getLoanSchedules($balance, $loan_duration, $interest, $payment_date, $payment_date->day, $start_payment_number, $loan_result_rounding);

    $data['first_payment'] = $first_payment_collection;
    $data['loan_schedule_collection'] = $loan_schedule_collection;
    return $data;
  }

  public static function getPaymentDate($payment_year, $start_payment_month, $payment_day) 
  {   
    if ( $start_payment_month < Carbon::today()->month ) {
      return Carbon::createMidnightDate($payment_year + 1, $start_payment_month, $payment_day);  
    } else {
      return Carbon::createMidnightDate($payment_year, $start_payment_month, $payment_day);  
    }    
  }

  public static function getFirstPayments($balance, $first_payment_duration, $first_payment_percentage, $first_payment_amount, $deposited_at, $deposited_amount, $signed_at, &$payment_date, $payment_day, &$start_index = 0, $rounding_result = false)
  {
    $date_format = config('app.php_date_format');
    if ( $start_index==0 ){
      $start_index++;
    }
    $first_payment_collection = [];
    if ( $deposited_amount != 0 ) {
      $first_row = [
        'no' => 0,
        "payment_date" => $deposited_at->format(config('app.php_date_format')),
        "beginning_balance" => $balance,
        "amount_to_pay" => $deposited_amount,
        "ending_balance" => ($balance - $deposited_amount),
        "note" => "Deposit Amount"
      ];
      $first_payment_collection[0] = $first_row;   
    }
    // $monthly_payment_amount = $balance * $first_payment_percentage / 100;
    if ( is_null( $first_payment_amount ) OR $first_payment_amount == 0 ) {
      $monthly_payment_amount = $balance * $first_payment_percentage / 100;
    } else {
      $monthly_payment_amount = $first_payment_amount;
    }
    $cent = 0; 
    if ( $rounding_result  ){
      $cent = $monthly_payment_amount - round($monthly_payment_amount);
      $monthly_payment_amount = round($monthly_payment_amount);
    }    
    for ($i = 1 ; $i <= $first_payment_duration ; $i++) {
      if ($i==1) {
        $row = [
          "no" => $start_index++,
          "payment_date" => $signed_at->format($date_format),
          "beginning_balance" => $balance - $deposited_amount,
          "amount_to_pay" => $monthly_payment_amount - $deposited_amount,
          "ending_balance" => ($balance = $balance - $monthly_payment_amount),
          "note" => \App\Helpers\NumberFormat::str_ordinal($i,true)." Month Payment"
        ];       
      } else {
        if ( $i == $first_payment_duration ) {
          $row = [
            'no' =>  $start_index++,
            "payment_date" => $payment_date->format($date_format),
            "beginning_balance" => $balance,
            "amount_to_pay" => $monthly_payment_amount + ($cent * $first_payment_duration),
            "ending_balance" => ($balance = $balance - ($monthly_payment_amount + ($cent * $first_payment_duration))),
            "note" => \App\Helpers\NumberFormat::str_ordinal($i,true)." Month Payment"
          ];
        } else {
          $row = [
            "no" => $start_index++,
            "payment_date" => $payment_date->format($date_format),
            "beginning_balance" => $balance,
            "amount_to_pay" => $monthly_payment_amount,
            "ending_balance" => ($balance = $balance - $monthly_payment_amount),
            "note" => \App\Helpers\NumberFormat::str_ordinal($i,true)." Month Payment"
          ];
        }  
      }
      if ( $payment_day == 31) {
        $payment_date->modify("last day of next month");
      } else {
        if ( $payment_date->month == 1 AND $payment_day >=28) {
          $payment_date->modify('last day of next month');
        }else {
          $payment_date = \Carbon\Carbon::createMidnightDate($payment_date->year, $payment_date->month + 1, $payment_day);    
        }
      }
      array_push($first_payment_collection,  $row);      
    } 
    return $first_payment_collection;
  }

  public static function getLoanSchedules($balance, $loan_duration, $interest, &$payment_date, $payment_day, &$start_index = 0, $rounding_result = false) 
  {
    $date_format = config('app.php_date_format');
    if ( $start_index == 0  ) {
      $start_index++;
    }
    $montly_payment = 0;
    if ( $rounding_result ) {
      $montly_payment = round(self::pmt($interest, $loan_duration, $balance));
    }else{
      $montly_payment = self::pmt($interest, $loan_duration, $balance);
    }    
    $loan_schedule_collection = [];
    for ($i = 1 ; $i <= $loan_duration ; $i++) {
      //exit the loop if the $balance if equal or less than 0;
      if ( $balance <= 0 ) {
        break;
      } 
      // calculate interest;     
      $interest_amount = $balance * $interest / 100 / 12;
      // calculate principle;   
      $principle = $montly_payment  - $interest_amount;

      //fixing the monthly payment of the last record of the loop;
      if ( $i != $loan_duration ) {
        $row = [
          "no" => $start_index++,
          "payment_date" => $payment_date->format($date_format),
          "beginning_balance" => $balance,
          "monthly_payment" => $montly_payment,
          "principle" => $principle,
          "interest" => $interest_amount,
          "ending_balance" => ($balance = $balance - $principle)
        ];   
      } else {
        $principle = $balance;
        $row = [
          "no" => $start_index++,
          "payment_date" => $payment_date->format($date_format),
          "beginning_balance" => $balance,
          "monthly_payment" => $principle + $interest_amount,
          "principle" => $principle,
          "interest" => $interest_amount,
          "ending_balance" => ($balance = $balance - $principle)
        ];
      }
      // add row to the result array;
      array_push($loan_schedule_collection,  $row);
      // calculate the next payment date;
      if ( $payment_day == 31) {
        $payment_date->modify("last day of next month");
      } else {
        if ( $payment_date->month == 1 AND $payment_day >=28) {
          $payment_date->modify('last day of next month');
        } else {
          $payment_date = Carbon::createMidnightDate($payment_date->year, $payment_date->month + 1, $payment_day);    
        }
      }
    }
    return $loan_schedule_collection;
  }

  public static function pmt($interest, $months, $principal) 
  {
    if ($interest == 0) {
      return $principal / $months;
    }  
    $interest = $interest / 100 / 12;
    $amount = $interest * -$principal * pow((1 + $interest), $months) / (1 - pow((1 + $interest), $months));
    return $amount;
  }
}