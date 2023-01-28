<?php

namespace App\Exports;

use App\Contract;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContractExports implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    protected $export_field = [
        'customer1_name', 
        'customer1_birthdate',
        'customer1_gender',
        'customer_phone_number',
        'customer1_id_number',
        'customer2_name',
        'customer2_birthdate',
        'customer2_gender',
        'customer2_id_number',
        'customer_phone_number2',
        'customer_address',
        'contract_id',
        'selling_price',
        'promotional_discount',
        'other_discount_allowed',
        'net_price',
        'down_payment_amount',
        'loan_amount',       
        'payment_term',
        'interest_rate',  
        'management_fee',
        'loan_schedule',
        'bank_information',
        'unit_type',
        'project',
        'company',
        'unit_number',
        'house_room_size',
        'land_size',
        'bedroom',
        'bathroom',
        'kitchen',
        'living_room',
        'deposit',
        'deadline_in_month',
        'extended_deadline_in_month',
        'deadline',
        'warrenty_year',
        'material_providing',
        'net_sqm_area',
        'punishment_rate_late_payment',
        'punishment_rate_late_construction',
        'approver_name',
        'admin_transfer_fee',
        'tax_transfer_fee',
        'status',
        'agency_name',
        'agency_sale_team_leader',
        'created_at',
        'last_updated_at',
    ];

    public function query()
    { 
        return Contract::query()->with([
            'saleRepresentative' => function ($query) { return $query->select(['id', 'name']); },
            'paymentOption',
            'unit' => function ($query) { return $query->without(['action','action.createdBy']); },
            'unit.unitType' => function ( $query ) { return $query->select(['id', 'name', 'project_id', 'short_code']); },
            'unit.unitType.project' => function ($query) { return $query->select(['id', 'name', 'name_en','company_id']); },
            'unit.unitType.project.bank' => function ($query) { return $query->select(['id', 'short_name', 'account_name', 'account_number']); },
            'unit.unitType.project.company' => function ($query) { return $query->select(['id', 'name_en']); },
            'agent' => function ($query) { return $query->select(['id', 'name', 'managed_by']); },
            'agent.manager' => function ($query) { return $query->select(['id', 'name', 'managed_by']); }
        ])->select([
            'id',
            'sale_representative_id',
            'customer1_name',
            'customer1_birthdate',
            'customer1_gender',
            'customer1_nid',
            'customer_phone_number',
            'customer2_name',
            'customer2_birthdate',
            'customer2_gender',
            'customer2_nid',
            'customer_phone_number2',
            'customer_address_line1', 
            'customer_address_line2',
            'agent_id',
            'unit_id',
            'status',
            'unit_sale_price',
            'discount_promotion',
            'other_discount_allowed',
            'deposited_amount',            
            'deposited_at',
            'payment_option_id',
            'loan_duration',
            'interest',
            'special_discount',
            'is_first_payment',
            'first_payment_duration',
            'first_payment_percentage',
            'first_payment_amount',
            'annual_management_fee',
            'contract_transfer_fee',
            'management_fee_per_square',
            'equipment_text',
            'signed_at',
            'deadline',
            'extended_deadline',
            'created_at',
            'updated_at'
        ]);
    }

    
    public function map($contract): array
    {        
        return [
            'customer1_name' => $contract->customer1_name,
            'customer1_birthdate' => $contract->customer1_birthdate,
            'customer1_gender' => $contract->customer1_gender == 1 ? 'Male' : 'Female',
            'customer_phone_number' => $contract->customer_phone_number, 
            'customer1_id_number' => $contract->customer1_nid ?? '',
            'customer2_name' => $contract->customer2_name ?? 'N/A',
            'customer2_birthdate' => $contract->customer2_birthdate ?? '',
            'customer2_gender' => $contract->customer2_gender == 1 ? 'Male' : 'Female',
            'customer2_id_number' => $contract->customer2_nid ?? '',
            'customer_phone_number2' => $contract->customer_phone_number2 ?? 'N/A',
            'customer_address' => $contract->customer_address_line1.' '.$contract->customer_address_line2,
            'contract_id' => $contract->unit->code.'/'.$contract->unit->unitType->short_code.'-'.$contract->formatted_id,
            'selling_price' => $contract->unit_sale_price,
            'promotional_discount' => $contract->discount_promotion,
            'other_discount_allowed' => $contract->other_discount_allowed,
            'net_price' => $contract->getUnitSoldPriceAfterAllDiscount(),
            'down_payment_amount' => $contract->getTotalFirstPaymentAmount(),
            'loan_amount' => $contract->getPrincipalAmount(),            
            'payment_term' => $contract->payment_option_id ? $contract->paymentOption->name : 'Other',
            'interest_rate' => $contract->interest,            
            'management_fee' => $contract->annual_management_fee,
            'loan_schedule' => $contract->loan_duration,
            'bank_information' => $contract->unit->unitType->project->bank ? 
            $contract->unit->unitType->project->bank->short_name.' | '.$contract->unit->unitType->project->bank->account_name.' | '.$contract->unit->unitType->project->bank->account_number : 'N/A',
            'unit_type' => $contract->unit->unitType->name,
            'project' => $contract->unit->unitType->project->name_en,
            'company' => $contract->unit->unitType->project->company->name_en,
            'unit_number' => $contract->unit->code,
            'house_room_size' => $contract->unit->building_size_width  && $contract->unit->building_size_length ? $contract->unit->building_size_width.' x '.$contract->unit->building_size_length : $contract->unit->building_area,
            'land_size' => $contract->unit->land_size_width  && $contract->unit->land_size_length ? $contract->unit->land_size_width.' x '.$contract->unit->land_size_length : $contract->unit->land_area,
            'bedroom' => $contract->unit->bedroom,
            'bathroom' => $contract->unit->bathroom,
            'kitchen' => $contract->kitchen,
            'living_room' => $contract->living_room,
            'deposit' => $contract->deposited_amount,
            'deadline_in_month' => $contract->deadline,
            'extended_deadline_in_month' => $contract->extended_deadline,
            'deadline' => $contract->deadline_at,
            'warrenty_yeat' => 'N/A',
            'material_providing' => $contract->equipment_text ? strip_tags($contract->equipment_text) : '',
            'net_sqm_area' => 'N/A',
            'punishment_rate_late_payment' => 'N/A',
            'punishment_rate_late_construction' => 'N/A',
            'approver_name' => $contract->saleRepresentative->name,
            'admin_transfer_fee' => $contract->contract_transfer_fee,
            'tax_transfer_fee' => 'N/A',
            'status' => $contract->status,
            'agency_name' => $contract->agent->name,
            'agency_sale_team_leader' => $contract->agent->manager->name ?? 'N/A',
            'created_at' => $contract->created_at,
            'last_updated_at' => $contract->updated_at,
        ];
    }

    public function headings(): array
    {
        return $this->export_field;
    }
}
