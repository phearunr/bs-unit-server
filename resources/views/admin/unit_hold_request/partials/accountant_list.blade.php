<table class="table table-hover mb-0">
    <thead>
        <tr scope="row">
            <th scope="col" width="200px">{{ __("Unit Code") }}</th>
            <th scope="col" width="200px">{{ __("Customer Info.") }}</th>
            <th scope="col" width="150px">{{ __('Deposit Date') }}</th>
            <th scope="col">{{ __("Payment Info.") }}</th>
            <th scope="col" width="140px">{{ __('Payment Status') }}</th>
            <th scope="col" width="150px">{{ __("Salesperson") }}</th>
            <th scope="col" width="30px"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($unit_deposit_requests as $unit_deposit_request)
        <tr>
            <td scope="row" class="action-td">
                <a href="{{ route('admin.units.edit', ['id' => $unit_deposit_request->unit_id]) }}">
                    <strong>{{ $unit_deposit_request->unit->code }}</strong>
                </a>
                <span class="d-block text-muted">
                    {{ $unit_deposit_request->unit->unitType->name }}
                </span>
                <span class="d-block text-muted">
                    {{ $unit_deposit_request->unit->unitType->project->name }} 
                </span>
            </td>
            <td>
                <span class="d-block">{{ $unit_deposit_request->customer_name}}</span>
                @if( $unit_deposit_request->isContainCustomer2() )
                <span class="d-block">{{ $unit_deposit_request->customer2_name }}</span>
                @endif
                <span class="d-block text-muted">
                    {{ $unit_deposit_request->customer_phone_number }}
                    {{ $unit_deposit_request->isCustomerPhoneNumber2() ? " | ". $unit_deposit_request->customer_phone_number2 : '' }}
                </span>
            </td>
            <td>
                {{ $unit_deposit_request->deposited_at->toSystemDateString() }}
                <span class="text-muted font-italic d-block">{{ $unit_deposit_request->deposited_at->diffForHumans() }}</span>
            </td>
            <td>
                <ul class="mb-0">                    
                    <li>{{ __("Deposit Amount") }}: <b>{{ number_format($unit_deposit_request->deposit_amount, 2)}}</b></li>
                    <li>{{ __("Receiving Amount") }}: <b>{{ number_format($unit_deposit_request->receiving_amount, 2)}}</b></li>
                    <li>{{ __("Due Amount") }}: <b>{{ number_format($unit_deposit_request->getDueAmount(), 2) }}</b></li>
                </ul>
            </td>
            <td>{!! $unit_deposit_request->getPaymentStatusHtml() !!}</td>
            <td>
                <span class="d-block"><b>{{ $unit_deposit_request->createdBy->name }}</b></span>
                <span class="d-block"><b>{{ $unit_deposit_request->createdBy->phone_number }}</b></span>
                {!! $unit_deposit_request->getStatusHtml() !!}
            </td>
            <td>
                <div class="btn-group">
                    <a href="#" class="text-primary" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false"><i class="fas fa-lg fa-ellipsis-v"></i></a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                        <a href="{{ route('admin.unit_deposit_requests.show', ['id' => $unit_deposit_request->id]) }}" class="dropdown-item">{{ __("View") }}</a>
                        <a href="{{ route('admin.unit_deposit_requests.update.receving_amount', ['id' => $unit_deposit_request->id]) }}" class="dropdown-item">{{ __("Edit Receiving Amount") }}</a>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table> 