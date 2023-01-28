<h4 class="khmer-title text-center">ឧបសម្ព័ន្ធ១</h4>
<h4 class="khmer-title text-center">“តារាងកាលវិភាគនៃការទូទាត់ប្រាក់ថ្លៃលក់ទិញអចលនវត្ថុ”</h4>
<h4 class="english text-center text-bold my-0 py-0">Annex 1</h4>
<h4 class="english text-center text-bold">Schedule of Payment of Sale-Purchase Price of the Immoveable Property</h4>
<p class="khmer text-center font-italic">(ដែល​អាច​កែប្រែ ផ្លាស់ប្តូរ​បាន​គ្រប់​ពេល​វេលា​អាស្រ័យ​លើ​ការ​ស្នើ​សុំ​របស់​ភាគី “អ្នកទិញ” ដោយ​មាន​ការ​យល់​ព្រម​ពីភាគី “អ្នកលក់” 
ដែល​តារាង​កាល​វិភាគ​នៃ​ការ​ទូទាត់​ប្រាក់​ថ្លៃ​​លក់​ទិញ​អចលនវត្ថុ​ថ្មី​នោះ និង​និរាករ​តារាង​កាលវិភាគ​នៃ​ការ​ទូទាត់​ប្រាក់​ថ្លៃ​លក់​ទិញ​អចលនវត្ថុ​ចាស់​ចោល ហើយ​មាន​សុពលភាព​បន្ត​ពី​តារាង​ចាស់​នោះ​ដោយ​ភ្ជាប់​ជាមួយ​កិច្ចសន្យា​លក់​ទិញ ក្នុងឧបសម្ព័ន្ធ​ទី១​នេះ)</p>
<p class="english text-center font-italic">(It is subject to change at any time according to a request made by “the purchaser” with agreement from “the seller”, by drawing up a new schedule of payment of sale-purchase price of the immoveable property and abrogating the former one superseded by the new one which are attached to this Contract on Sale-Purchase together as Annex 1)</p>
<div class="row my-2">
  <div class="col">
    <table class="table table-sm table-bordered">
      <tr>
        <td class="title bg-grey" width="180px">{{ __("Unit Code") }}:</td>    
        <td class="text-left">{{ $unit->code }}</td>
      </tr>
      <tr>
        <td class="title bg-grey" width="180px">{{ __("Unit Sale Price") }}:</td>    
        <td class="text-left">{{ number_format($contract->unit_sale_price,0)}}</td>
      </tr>
      @if($contract->discount_promotion != 0)
      <tr>
        <td class="title bg-grey">{{ __("Discount Promotion") }}:</td>    
        <td class="text-left">{{ number_format($contract->discount_promotion,0) }}</td>
      </tr>
      @endif
      @if($contract->other_discount_allowed != 0)
      <tr>
        <td class="title bg-grey">{{ __("Other Discount Allowed") }}:</td>    
        <td class="text-left">{{ number_format($contract->other_discount_allowed,0) }}</td>
      </tr>
      @endif
      @if($contract->getDiscountAmountByPaymentOption() != 0)
      <tr>
        <td class="title bg-grey">{{ __("Discount Payment Option $") }}:</td>    
        <td class="text-left">{{ number_format($contract->getDiscountAmountByPaymentOption(),0) }}</td>
      </tr>
      @endif
      <!-- 
      <tr>
        <td class="title bg-grey"">Price After discount:</td>    
        <td class="text-left text-bold">{{ number_format($contract->getUnitSoldPriceAfterDiscount(),0) }}</td>
      </tr>
       -->
      <tr>
        <td class="title bg-grey">{{ __("Property Final Price") }}:</td>    
        <td class="text-left text-bold">{{ number_format($contract->getUnitSoldPriceAfterAllDiscount(),0) }}</td>
      </tr>
      <tr>
        <td class="title bg-grey">{{ __("Deposited Amount") }}:</td>    
        <td class="text-left">{{ number_format($contract->deposited_amount,0) }}</td>
      </tr>
      <tr>
        <td class="title bg-grey">{{ __("Deposited At") }}:</td>    
        <td class="text-left">{{ $contract->deposited_at->toSystemDateString() }}</td>
      </tr>
      <tr>
        <td class="title bg-grey">{{ __("Start Payment Date") }}:</td>    
        <td class="text-left">{{ $contract->start_payment_date->day }}</td>
      </tr>
    </table>
  </div>
  <div class="col">
    @if($contract->is_first_payment)
    <table class="table table-sm table-bordered">
      <tr>
        <td class="title bg-grey" width="200px">{{ __("Has First Payment?") }}:</td>    
        <td class="text-left">Yes</td>
      </tr>
      <tr>
        <td class="title bg-grey">{{ __("First Payment Duration") }}:</td>    
        <td class="text-left">{{ $contract->first_payment_duration }}</td>
      </tr>
      <tr>
        @if( $contract->first_payment_percentage > 0 )
        <td class="title bg-grey">{{ __("First Payment Percentage") }}:</td>    
        <td class="text-left">{{ $contract->first_payment_percentage }}</td>
        @else
        <td class="title bg-grey">{{ __("First Payment Amount") }}:</td>
        <td class="text-left">{{ $contract->first_payment_amount }}</td>
        @endif
      </tr>
     
    </table>
    @endif
    <table class="table table-sm table-bordered">
      <tr>
        <td class="title bg-grey" width="200px">{{ __("Principal") }}:</td>    
        <td class="text-left">{{ number_format($contract->getPrincipalAmount(),2) }}</td>
      </tr>
      <tr>
        <td class="title bg-grey" width="200px">{{ __("Loan Duration") }}:</td>    
        <td class="text-left">{{ $contract->loan_duration }}</td>
      </tr>
      <tr>
        <td class="title bg-grey" width="200px">{{ __("Interest Rate") }}:</td>    
        <td class="text-left">{{ $contract->interest }}</td>
      </tr>     
      <tr>
        <td class="title bg-grey" width="200px">{{ __("Total Interest") }}:</td>    
        <td class="text-left">{{ number_format( ($pmt * $contract->loan_duration) - $contract->getPrincipalAmount(), 2) }}</td>
      </tr>             
    </table>    
  </div>    
</div>
@if( count($payment_schedule['first_payment']) > 0 )
  <table class="table table-sm table-bordered" id="first_payment_table">
    <thead>
      <tr class="bg-grey">
        <th colspan="6" class="text-center">{{ __("Down Payment Plan") }}</th>
      </tr>
      <tr class="bg-grey">
        <th>{{ __("No") }}</th>
        <th>{{ __("Payment Date") }}</th>
        <th>{{ __("Beginning Balance") }}</th>
        <th>{{ __("Payment Amount") }}</th>
        <th>{{ __("Ending Balance") }}</th>
        <th>{{ __("Note") }}</th>
      </tr>
    </thead>
    <tbody>
      @php
        $total_first_payment = 0 ;
      @endphp
      @foreach( $payment_schedule['first_payment'] as $item  )          
        <tr>
          <!-- <td>{{ $loop->index }}</td> -->
          <td>{{ $item['no'] }}</td>
          <td>{{ $item['payment_date'] }}</td>
          <td>{{ number_format($item['beginning_balance'],2) }}</td>
          <td>{{ number_format($item['amount_to_pay'],2) }}</td>
          <td>{{ number_format($item['ending_balance'],2) }}</td>
          <td>{!! $item['note'] !!}</td>
        </tr>
        @php
          $total_first_payment = $total_first_payment + $item['amount_to_pay'];
        @endphp
      @endforeach
      <tr class="table-secondary">
        <td></td>
        <td></td>
        <td></td>
        <td><strong>{{ number_format($total_first_payment,2) }}</strong></td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
  </table>
@endif

@php 
$first_payment_count = count($payment_schedule['first_payment']);
@endphp
@if( count($payment_schedule['loan_schedule_collection']) > 0 )
  <table class="table table-sm table-bordered" id="payment_schedule_table">
    <thead>
      <tr class="bg-grey">
        <th colspan="7" class="text-center">{{ __("Installment Plan") }}</th>
      </tr>
      <tr class="bg-grey">
        <th>{{ __("No") }}</th>
        <th>{{ __("Payment Date") }}</th>
        <th>{{ __("Beginning Balance") }}</th>
        <th>{{ __("Payment Amount") }}</th>
        <th>{{ __("Principal") }}</th>
        <th>{{ __("Interest") }}</th>
        <th>{{ __("Ending Balance") }}</th>
      </tr>
    </thead>
    <tbody>       
      @php
        $total_payment = 0;
        $total_principal = 0;
        $total_interest = 0;
      @endphp      
      @foreach( $payment_schedule['loan_schedule_collection'] as $item  ) 
        <tr>
          <!-- <td>{{ $first_payment_count + $loop->index }}</td> -->
          <td>{{ $item['no'] }}</td>
          <td>{{ $item['payment_date'] }}</td>
          <td>{{ number_format($item['beginning_balance'],2) }}</td>
          <td>{{ number_format($item['monthly_payment'],2) }}</td>        
          <td>{{ number_format($item['principle'],2) }}</td>
          <td>{{ number_format($item['interest'],2) }}</td>
          <td>{{ number_format($item['ending_balance'],2) }}</td>
        </tr>
        @php
          $total_payment = $total_payment + $item['monthly_payment'];
          $total_principal =  $total_principal + $item['principle'];
          $total_interest =  $total_interest + $item['interest'];
        @endphp
      @endforeach    

      <tr class="table-secondary">
        <td></td>
        <td></td>
        <td></td>
        <td><strong>{{ number_format($total_payment,2) }}</strong></td>
        <td><strong>{{ number_format($total_principal,2) }}</strong></td>
        <td><strong>{{ number_format($total_interest,2) }}</strong></td>
        <td></td>
      </tr> 
    </tbody>
  </table>
@endif
<div style="page-break-after: always;"></div>