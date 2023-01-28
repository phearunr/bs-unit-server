<?php

namespace App\Exports;

use App\Unit;
use App\Project;
use App\UnitType;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UnitsExport implements FromQuery, WithMapping, WithHeadings
{
	use Exportable;

    protected $export_field = [
        'id',
        'unit_type_id',
        'code',
        'unit_type',
        'project',
        'price',
        'status',
        'status_action',
        'remark',
        'saleable',
        'active',
        'street',
        'street_corner',
        'street_size',
        'floor',
        'land_size_width',
        'land_size_length',
        'land_area',
        'building_size_width',
        'building_size_length',
        'building_area',
        'gross_area',
        'living_room',
        'kitchen',
        'bedroom',
        'bathroom',
        'swimming_pool'
    ];

    // protected $unit_type_id;
    protected $type;
    protected $id;

    public function __construct($type = "unit_type", int $id = null)
    {
        // $this->unit_type_id = $unit_type_id;
        $this->type = $type;
        $this->id = $id;
    }

	public function query()
    { 
        if ( $this->type == 'unit_type' ) {
            return Unit::query()->withTrashed()->where("unit_type_id", $this->id);
        } elseif ( $this->type == 'project' ) {
            $unit_type_id_array = UnitType::where('project_id',$this->id)->pluck('id')->toArray();
            return Unit::query()->withTrashed()->whereIn('unit_type_id',$unit_type_id_array);
        } else {
            return Unit::query()->withTrashed();
        }
    }

    /**
    * @var Unit $unit
    */
    public function map($unit): array
    {   
        // return array_flatten($unit->only($this->export_field));
        return [
            'id' => $unit->id,
            'unit_type_id' => $unit->unit_type_id,
            'code' => $unit->code,
            'unit_type' => $unit->unitType->name,
            'project' => $unit->unitType->project->name_en,
            'price' => $unit->price,
            'status' => $unit->action->action,
            'status_action' => $unit->action->status_action,
            'remark' => $unit->action->description,
            'saleable' => $unit->saleable ? 'Yes' : 'No',
            'active' => $unit->trashed() ? 'No' : 'Yes',
            'street' => $unit->street,
            'street_corner' => $unit->street_corner,
            'street_size' => $unit->street_size,
            'floor' => $unit->floor,
            'land_size_width' => $unit->land_size_width, 
            'land_size_length' => $unit->land_size_length,
            'land_area' => $unit->getOriginal('land_area'),
            'building_size_width' => $unit->building_size_width,
            'building_size_length' => $unit->building_size_length,
            'building_area' => $unit->getOriginal('building_area'),
            'gross' => $unit->gross_area,
            'living_room' => $unit->living_room,
            'kitchen' => $unit->kitchen,
            'bedroom' => $unit->bedroom,
            'bathroom' => $unit->bathroom,
            'swimming_pool' => $unit->swimming_pool
        ];
    }

    public function headings(): array
    {
        return $this->export_field;
    }
}
