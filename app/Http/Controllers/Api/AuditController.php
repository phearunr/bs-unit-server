<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Audit as AuditResource;
use App\Http\Resources\AuditCollection;
use \OwenIt\Auditing\Models\Audit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuditController extends Controller
{
	protected $model_path_prefix = "App\\";

    public function index( Request $request ) {
    	$audits = Audit::query();

    	if ( $request->type AND $request->id ) {
    		$audits = $audits->where('auditable_type', $this->model_path_prefix.$request->type)
    						 ->where('auditable_id', $request->id);
    	}
    	return new AuditCollection($audits->with(['user'])
    				  ->latest()
    				  ->paginate( $request->per_page ?? (new Audit())->getPerpage() ));
    }
}
