<div class="modal fade" id="nav_payment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">{{ __('Edit Receiving Amount') }}:</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>		
			<div class="modal-body">
				<h5 id="deposit-information">{{ __('Deposit Information') }}:</h5>
                <hr class="mt-0">
                <div class="row">
                    <div class="col-md form-group">                          
                        <label for="deposit_amount">{{ __('Deposited Amount') }}:</label>
                        <input type="hidden" name="id" readonly="readonly">
                        <input type="text" class="form-control" id="deposit_amount" readonly="readonly">
                    </div>
                    <div class="col-md form-group">                          
                        <label for="deposited_at">{{ __('Deposited At') }}:</label>
                        <input type="text" class="form-control" id="deposited_at"  readonly="readonly">
                    </div>  
                    <div class="col-md form-group">                          
                        <label for="receiving_amount">{{ __('Receiving Amount') }}:</label>                        
                        <input type="text" class="form-control" name="receiving_amount" id="receiving_amount" readonly="readonly">
                    </div>
                    <div class="col-md form-group">                          
                        <label for="document_no">{{ __('Document No') }}:</label>
                        <input type="hidden" name="entry_no" readonly="readonly">
                        <input type="text" class="form-control" name="document_no" id="document_no" readonly="readonly">
                    </div>
                </div>
                <h5 id="payment-information">{{ __('Payment Information') }} ({{ __('MS NAV System') }}):</h5>
                    <hr class="mt-0">
                    <div class="row">
                        <div class="col-lg">
                            <table class="table table-bordered" id="payment_table">
                                    <thead>
                                        <tr class="bg-grey">
                                            <th width="120px">{{ __('Posting Date') }}</th>                                       
                                            <th width="170px">{{ __('Type') }}</th>                           
                                            <th>{{ __('Information') }}</th>                                            
                                            <th>{{ __("Amount") }}</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>                                      
                                    </tbody>
                                </table>
                        </div>
                    </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
			</div>
		</div>
	</div>
</div>

@push('scripts')
<script type="text/javascript">
	function setDeposit() {
        deposit_obj = $(this).data('deposit');
       	id = $(this).data('id');
        $('input[name="receiving_amount"]').val(Math.abs(deposit_obj.Amount));
        $('input[name="document_no"]').val(deposit_obj.Document_No);
        $('input[name="entry_no"]').val(deposit_obj.Entry_No);       
        $('#unit_deposit_receiving_form').submit();
    }

    function buildDepositPaymentTable(payment_data, id) {
        var date_format = '{!! strtoupper(config("app.js_date_format")) !!}';
        $.each(payment_data, function (i, obj) {
            var action = $('<button type="button" class="btn btn-block btn-primary btn-sm set-deposit-button"></button')
                         .data('deposit', obj)
                         .data('id', id)
                         .html("Set");
        	// action.on("click", setDeposit);
            var tr = $("<tr></tr>");
            var doc_html = obj.Document_Type + " / " + obj.Payment_Type + `<br/><small>` + obj.Document_No + `</small>`;       
            var cust_html = `Customer: <b>` + obj.Customer_Name + `</b> | <b>` + obj.Customer_No + `</b><br/>
                            Unit: <b>` + obj.Item_No + `</b> | <b>` + obj.Variant_Code + `</b><br/>
                            Description: ` + obj.Description;
            var item_html = obj.Item_No + " / " + obj.Variant_Code;
            tr.append($("<td></td>").text( moment(obj.Posting_Date).format(date_format)));
            tr.append($("<td></td>").html(doc_html));
            tr.append($("<td></td>").html(cust_html));    
            tr.append($("<td width='130px'></td>").html( "<b>" + $.number((obj.Amount * -1),2) + "</b>").append(action));           
            $('#payment_table > tbody').append(tr);
        });
    }
    
    var deposit_data;

    $('#nav_payment_modal').on('show.bs.modal', function (e) {
        $('input[name="id"]').val(deposit_data.id);
        $('input[id="deposit_amount"]').val(deposit_data.amount);
        $('input[id="deposited_at"]').val(deposit_data.date);
        $('input[name="receiving_amount"]').val(deposit_data.receiving);
        $('input[name="document_no"]').val(deposit_data.document);
        $('#payment_table > tbody').empty();
    })

    $(document).on('click', '.set-deposit-button', function (e) {
    	var deposit_obj = $(e.target).data('deposit');
    	var id = $(e.target).data('id');
    	var url = '/admin/unit_deposit_requests/REQUEST_ID/updateReceivingAmount'.replace('REQUEST_ID', id);
    	axios.post(url, {
    		receiving_amount: Math.abs(deposit_obj.Amount),
    		document_no: deposit_obj.Document_No,
    		entry_no: deposit_obj.Entry_No.toString()
    	})
        .then(function (response) {   
            if ( response.data.status == 'success' ) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Deposit amount successfully set.'
                }).then((result) => {
                    if (result.value) {
                        window.location.reload();
                    }
                })
            }
        })
        .catch(function (error) { 
            console.log(error);
        });    	
    })

    $(document).on('click', '.unit-deposit-request-recieve-button', function (e) {
        e.preventDefault();
        if ( e.target.dataset.id != undefined ) {            
            var id = e.target.dataset.id;
            var url = e.target.href;
            deposit_data = e.target.dataset;
            $('#nav_payment_modal').modal('show');
            axios.get(url)
            .then(function (response) {   
                buildDepositPaymentTable(response.data.value, id);            
            })
            .catch(function (error) { 
                console.log(error);
            });
        }
    });
</script>
@endpush