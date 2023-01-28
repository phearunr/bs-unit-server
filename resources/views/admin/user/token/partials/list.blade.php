<tr>
	<td>{{ $token->metadata['device_info']['device_name'] ?? __('N/A') }}</td>
	<td>{{ $token->metadata['device_info']['platform'] ?? __('N/A') }}</td>
	<td>{{ $token->metadata['device_info']['os_version'] ?? __('N/A') }}</td>	
	<td>{{ $token->metadata['device_info']['app_version'] ?? __('N/A') }}</td>	
	<td>
		<div class="dropdown">
	        <a href="#" class="text-primary" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
	            <i class="fas fa-lg fa-ellipsis-v"></i>
	        </a>
	        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left" aria-labelledby="zdropdownMenuButton">	     
	            <a href="#" class="dropdown-item delete-token" data-id="{{ $token->id }}">
	                {{__("Delete")}}
	            </a>
	        </div>
	    </div>
	</td>
</tr>