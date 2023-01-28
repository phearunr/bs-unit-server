<?php

namespace App\Imports;

use App\Unit;
use App\UnitAction;
use App\Helpers\UnitStatus;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class UnitsImport implements ToCollection, WithHeadingRow, WithBatchInserts
{
    public function collection(Collection $rows)
    {
        $auth_user_id = Auth::id();
        foreach ($rows as $row) 
        {   

            if ( $row['id'] == "" OR is_null($row['id'])) {
                $unit = Unit::create([
                    'user_id' => $auth_user_id,
                    'unit_type_id' => $row['unit_type_id'],
                    'code' => $row['code'],
                    'price' => $row['price'],                
                    'street' => $row['street'],
                    'street_corner' => $row['street_corner'],
                    'street_size' => $row['street_size'],
                    'floor' => $row['floor'],
                    'land_size_width' => $row['land_size_width'],
                    'land_size_length' => $row['land_size_length'],
                    'land_area' => $row['land_area'],
                    'building_size_width' => $row['building_size_width'],
                    'building_size_length' => $row['building_size_length'],
                    'building_area' => $row['building_area'],
                    'gross_area' => $row['gross_area'],
                    'living_room' => $row['living_room'],
                    'kitchen' => $row['kitchen'],
                    'bedroom' => $row['bedroom'],
                    'bathroom' => $row['bathroom'],
                    'swimming_pool' => $row['swimming_pool']
                ]);
                if ( isset($row['status']) AND strtoupper($row['status']) == UnitStatus::UNAVAILABLE ) { 
                    $unit = $unit->fresh();
                    $unit->action()->update(['action' => UnitStatus::UNAVAILABLE ]);
                }
            } else {
                try {
                    $data = [
                        'user_id' => Auth::id(),
                        'unit_type_id' => $row['unit_type_id'],
                        'code' => $row['code'],
                        'price' => $row['price'],                
                        'street' => $row['street'],
                        'street_corner' => $row['street_corner'],
                        'street_size' => $row['street_size'],
                        'floor' => $row['floor'],
                        'land_size_width' => $row['land_size_width'],
                        'land_size_length' => $row['land_size_length'],
                        'land_area' => $row['land_area'],
                        'building_size_width' => $row['building_size_width'],
                        'building_size_length' => $row['building_size_length'],
                        'building_area' => $row['building_area'],
                        'gross_area' => $row['gross_area'],
                        'living_room' => $row['living_room'],
                        'kitchen' => $row['kitchen'],
                        'bedroom' => $row['bedroom'],
                        'bathroom' => $row['bathroom'],
                        'swimming_pool' => $row['swimming_pool']
                    ];
                    $unit = Unit::find($row['id']);
                    if ( $unit ) {
                        $unit->fill($data);
                        $unit->save();
                        if( isset($row['status']) AND strtoupper($row['status']) == UnitStatus::UNAVAILABLE ) {
                            if ( $unit->action->action == UnitStatus::AVAILABLE ) {
                                UnitAction::create([
                                    'user_id' =>  $auth_user_id,
                                    'unit_id' => $unit->id,
                                    'action' => UnitStatus::UNAVAILABLE,
                                    'status_action' => "",
                                    'description' => "",
                                    'meta_data' => "",
                                    'actionable_type' => "",
                                    'actionable_id' => 0
                                ]);
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                }
            }
        }
    }

    public function batchSize(): int
    {
        return 20;
    }
}
