@if( $unit_type->contractTemplate )
<div class="dropdown show">
	<a class="btn btn-sm btn-secondary dropdown-toggle" href="#" role="button" id="contract-print-preview-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    	{{ __('Preview') }}
  	</a>
	<div class="dropdown-menu" aria-labelledby="contract-print-preview-dropdown">
		<a class="dropdown-item" href="{{ route('admin.contract_templates.preview',['template_path' => $unit_type->contractTemplate->template_path, 'unit_type_id' => $unit_type->id, 'version' => 'v2', 'language' => 'km' ]) }}" target="_blank">{{ __('Khmer Version') }}</a>
		<a class="dropdown-item" href="{{ route('admin.contract_templates.preview',['template_path' => $unit_type->contractTemplate->template_path, 'unit_type_id' => $unit_type->id, 'version' => 'v2', 'language' => 'zh' ]) }}" target="_blank">{{ __('Chinese Version') }}</a>
		<a class="dropdown-item" href="{{ route('admin.contract_templates.preview',['template_path' => $unit_type->contractTemplate->template_path, 'unit_type_id' => $unit_type->id, 'version' => 'v2', 'language' => 'en' ]) }}" target="_blank">{{ __('English Version') }}</a>
	</div>
</div>                          
@else
{{ __('N/A') }}
@endif

