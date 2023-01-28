function buildFirstPaymentTable(data) {
    var table = $('#first_payment_table tbody');       
    table.empty();
    for(var i = 0; i < data.length; i++) {
        var obj = data[i];
        var tr = `<tr>
                    <td>`+ obj.no +`</td>
                    <td>`+ obj.payment_date +`</td>
                    <td>`+ $.number(obj.beginning_balance,2) + `</td>
                    <td>`+ $.number(obj.amount_to_pay,2) +`</td>
                    <td>`+ $.number(obj.ending_balance,2) +`</td>
                    <th>`+ obj.note +`</th>
                </tr>`;
        table.append(tr);
    }
}

function buildPaymentScheduleTable(data) {
    var table = $('#payment_schedule_table tbody');       
    table.empty();
    var cent = data[0].monthly_payment - Math.floor(data[0].monthly_payment);
    for(var i = 0; i < data.length; i++) {
        var obj = data[i];
        var tr = `<tr>
                        <td>`+ obj.no +`</td>
                        <td>`+ obj.payment_date +`</td>
                        <td>`+ $.number(obj.beginning_balance,2) + `</td>            
                        <td>`+ $.number(obj.monthly_payment,2) +`</td>
                        <td>`+ $.number(obj.principle,2) +`</td>
                        <td>`+ $.number(obj.interest,2) +`</td>
                        <td>`+ $.number(obj.ending_balance,2) +`</td>                       
                    </tr>`;        
        table.append(tr);
    }
}

function setPaymentFields(loan_duration, interest, special_discount, is_first_payment, first_payment_duration, first_payment_percentage) {
    $('input[name="loan_duration"]').val(loan_duration);
    $('input[name="interest"]').val(interest);
    $('input[name="special_discount"]').val(special_discount);  
    $('select[name="is_first_payment"]').val(is_first_payment);
    $('input[name="first_payment_duration"]').val(first_payment_duration);
    if ( first_payment_percentage > 0  ) {
        $('#first_payment_option').val(1).trigger("change");   
        $('input[name="first_payment_percentage"]').val(first_payment_percentage);
    }
    $('select[name="is_first_payment"]').trigger("change"); 
    $('input[name="special_discount"]').trigger("change");
}

function setPaymentFieldsReadOnly(status) {
    $('input[name="loan_duration"]').prop('readonly', status);
    $('input[name="interest"]').prop('readonly', status);
    $('input[name="special_discount"]').prop('readonly', status);  
    $('select[name="is_first_payment"]').prop('disabled', status);
    $('#first_payment_option').prop('disabled', status);
    $('input[name="first_payment_duration"]').prop('readonly', status);
    $('input[name="first_payment_percentage"]').prop('readonly', status);
    $('input[name="first_payment_amount"]').prop('readonly', status);
}

function loadPaymentOption(unit_type_id) {
    var url = "/admin/unit_types/"+ unit_type_id +"/payment_option";
    return axios.get(url)
    .then(function (response) { 
        $('#payment_option').empty();              
        if ( response.status == 200 ) {
            var payment_option_id = $('input[name="payment_option_id"]').val();
            $.each(response.data, function(index, obj){
                console.log();
                var is_selected = payment_option_id == obj.id;
                var newOption = new Option(obj.name, obj.id, is_selected, is_selected);
                $('#payment_option').append(newOption);
            });            
            if ( payment_option_id == "" || payment_option_id == undefined ) {
                var newOption = new Option("Other", "", true, true);
            } else {
                var newOption = new Option("Other", "", false, false);
            }
            
            $('#payment_option').append(newOption);
        }
    })
    .catch(function (error) {
        console.log(error);
    });
}

function loadUnitTypeData(unit_type_id) {
    var url = "/admin/unit_types/"+ unit_type_id;
    axios.get(url)
    .then(function (response) {
        if ( response.status == 200 ) {
            var unit_type = response.data;
            $('input[name="unit_type_name"]').val(unit_type.name);
            $('input[name="annual_management_fee"]').val(unit_type.annual_management_fee);
            $('input[name="contract_transfer_fee"]').val(unit_type.contract_transfer_fee);
            $('input[name="management_fee_per_square"]').val(unit_type.management_fee_per_square);
            $('input[name="deadline"]').val(unit_type.deadline);
            $('input[name="extended_deadline"]').val(unit_type.extended_deadline);
            $('textarea[name="title_clause_kh"]').val(unit_type.title_clause_kh);
            $('textarea[name="management_service_kh"]').val(unit_type.management_service_kh);            
            $('#equipment_text').summernote('code', unit_type.equipment_text);
        }
    })
    .catch(function (error) {
        console.log(error);
    });
}

function setUserField( user ) {    
    if ( user.id != "") {            
        $('input[name="agent_id"]').val(user.id);
        $("#agent_name").val(user.name);
        $("#agent_gender").val(user.gender);
        $("#agent_phone_number").val(user.phone_number);
        $("#sale_team_leader").val((user.manager == null) ? 'N/A' : user.manager.name);
        return true;
    }
    return false;
}

function setUnitField(unit) {
    if ( unit.unit_type_id != undefined ) {
        $('input[name="unit_id"]').val(unit.id);
        // $('input[name="unit_sale_price"]').val(unit.price);
        $("#unit_code").val(unit.code);
        $("#street").val(unit.street);
        $("#street_corner").val(unit.street_corner);  
        $("#street_size").val(unit.street_size);  
        $("#floor").val(unit.floor);
        $("#land_size_width").val(unit.land_size_width);
        $("#land_size_length").val(unit.land_size_length);
        $("#land_area").val(unit.land_area);
        $("#building_size_width").val(unit.building_size_width);
        $("#building_size_length").val(unit.building_size_length);
        $("#building_area").val(unit.building_area);
        $("#gross_area").val(unit.gross_area);
        $("#living_room").val(unit.living_room);
        $("#kitchen").val(unit.kitchen);
        $("#bedroom").val(unit.bedroom);
        $("#bathroom").val(unit.bathroom);
        $('#unit_price').val(unit.price);
        return true;
    }
    return false;
}

function setSaleRepresentativeField(sale_representative) {
    if ( sale_representative.id != '') {
        console.log(sale_representative);
        $('input[name="sale_representative_id"]').val(sale_representative.id);
        $('#sale_representative_name').val(sale_representative.name);
        $('#sale_representative_name_en').val(sale_representative.name_en);
        $('#sale_representative_national_id').val(sale_representative.national_id);
        return true;
    }    
    return false;
}

function formatUnit(unit) {
    if (unit.loading) {
        return unit.text;
    } 
    return '<span class="font-weight-bold">' + unit.code + " | $" + $.number(unit.price,2) + '</span> '+ unit.action.status_html + '<br/>' +
           '<span>' + unit.unit_type.name + " - " + unit.unit_type.project.name_en + '</span>';
}
   
function formatUnitSelection (unit) {
    if ( unit.unit_type_id != undefined ) {
        setUnitField(unit);
        loadUnitTypeData(unit.unit_type_id);
        loadPaymentOption(unit.unit_type_id);        
    }    
    return "";
}

function formatUser(user) {
    if (user.loading) {
        return user.text;
    } 
    return user.name;
}

function formatUserSelection(user) {
    setUserField(user);  
    return "";
}

function formatSaleRepresentative(sale_representative) {
    if (sale_representative.loading) {
        return sale_representative.text;
    }
    return sale_representative.name + ' | ' + sale_representative.name_en + ' | ' + sale_representative.national_id;
}

function formatSaleRepresentativeSelection(sale_representative) {    
    setSaleRepresentativeField(sale_representative);  
    return "";
}

function getValidationErrorsHtml(validation_error_response) {
    for ( var property in validation_error_response ) {      
        $('input[name="' + property + '"').addClass("is-invalid");
    }   
}

$(document).ready(function () {
	const first_payment_field = $('.first_payment_field').collapse({toggle: false});
    const customer2_toggle  = $('#second_customer_container').collapse({toggle: false});
    var payment_option_id = $('input[name="payment_option_id"]').val();

    $('#equipment_text').summernote({
        height: 200,
    });

    $("#second_customer").change(function (e){
        if ( e.target.checked )  {
            customer2_toggle.collapse('show'); 
        } else {
            customer2_toggle.collapse('hide'); 
        }
    });

    $("#second_customer").trigger("change");

    $("#unit_search_control").select2({
        theme: "bootstrap4",
        ajax: {
            delay: 1000,
            url: "/admin/units",
            dataType: 'json',
            data: function (params) {
                return {
                    term: $.trim(params.term),
                    page: params.page || 1
                };
            },
            processResults: function (data, params) {                 
                params.page = params.page || 1;
                return {
                    results: data.data,                      
                    pagination: {
                        more: (data.next_page_url != null),
                    }
                };
            },
            cache: true
        },            
        placeholder: 'Search for a unit',
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        minimumInputLength: 3,
        templateResult: formatUnit,
        templateSelection: formatUnitSelection
    });

    $("#agent_search_control").select2({
        theme: "bootstrap4",
        ajax: {
            delay: 1000,                         
            url: "/admin/users/get_agents",
            dataType: 'json', 
            data: function (params) {
                return {
                    term : $.trim(params.term)
                };
            },
            processResults: function (data, params) {                  
                params.page = params.page || 1;
                return {
                    results: data.data,                      
                };
            },
        },
        placeholder: "Search for an agent by agent's name",
        minimumInputLength: 3,
        templateResult: formatUser,
        templateSelection: formatUserSelection
    });

    $("#sale_representative_search_control").select2({
        theme: "bootstrap4",
        ajax: {
            delay: 1000,                         
            url: "/api/sale_representatives",
            dataType: 'json', 
            data: function (params) {
                return {
                    term : $.trim(params.term)
                };
            },
            processResults: function (data, params) {                  
                params.page = params.page || 1;
                return {
                    results: data.data,                      
                };
            },
        },
        placeholder: "Search for an sale representative by name",     
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        minimumInputLength: 1,   
        templateResult: formatSaleRepresentative,
        templateSelection: formatSaleRepresentativeSelection
    });

    if ( $('input[name="unit_id"]').val() > 0 ) {
        var url = "/admin/units/"+ $('input[name="unit_id"]').val();
        axios.get(url)
        .then(function (response) {                 
            if ( response.status == 200 ) {
                setUnitField(response.data);
                loadPaymentOption(response.data.unit_type_id).then(function (){
                    $("#payment_option").trigger("change");
                });
            }          
        })
        .catch(function (error) {
            console.log(error);
        });
    }

    if ( $('input[name="sale_representative_id"]').val() > 0 ) {
        var id = $('input[name="sale_representative_id"]').val();      
        var url = `/api/sale_representatives/${id}`;
        axios.get(url)
        .then(function (response) {                 
            if ( response.status == 200 ) {
                setSaleRepresentativeField(response.data.data);
            }          
        })
        .catch(function (error) {
            console.log(error);
        });
    }
    
    $("#agent_id").on("select2:select", function (e) {
        var id = e.params.data.id;
        var url = "/admin/users/"+ id;
        axios.get(url)
        .then(function (response) {                  
            if ( response.status == 200 ) {
                var user = response.data;
                $('#agent_gender').val(user.gender);
                $('#agent_phone_number').val(user.phone_number);

            }
        })
        .catch(function (error) {
            console.log(error);
        });
    });

	$('#is_first_payment').change(function (){
        if ( $(this).val() == 1 ) {
            first_payment_field.collapse('show');
            $('#first_payment_table').show();
        } else {
            first_payment_field.collapse('hide');
            $('#first_payment_table').hide();
        }
    });

	$('input.changable-price').change(function(){
        var price_after_discount_ele = $('#price_after_discount');
        var discount_payment_option_ele = $('#discount_payment_option');
        var final_price_ele = $('#final_price');

        var unit_sold_price = $('input[name="unit_sale_price"]').val();
        var special_discount = $('input[name="special_discount"]').val();      
        var discount_promotion = $('input[name="discount_promotion"]').val();
        var other_discount_allowed = $('input[name="other_discount_allowed"]').val();

        var pad = unit_sold_price - discount_promotion - other_discount_allowed;
        var fp = pad - (pad * ( special_discount / 100 ));

        price_after_discount_ele.text($.number( pad ,0));
        discount_payment_option_ele.text($.number(pad * ( special_discount / 100 ),0));
        final_price_ele.text($.number(fp,0));
    });

	$("#btn-show-loan").click(function (){
        var data = {
            unit_sale_price : $('input[name="unit_sale_price"]').removeClass('is-invalid').val(),
            discount_promotion : $('input[name="discount_promotion"]').removeClass('is-invalid').val(),
            other_discount_allowed : $('input[name="other_discount_allowed"]').removeClass('is-invalid').val(),
            deposited_amount : $('input[name="deposited_amount"]').removeClass('is-invalid').val(),
            deposited_at : $('input[name="deposited_at"]').removeClass('is-invalid').val(),
            start_payment_date : $('input[name="start_payment_date"]').removeClass('is-invalid').val(),           
            loan_duration : $('input[name="loan_duration"]').removeClass('is-invalid').val(),
            interest : $('input[name="interest"]').removeClass('is-invalid').val(),
            special_discount : $('input[name="special_discount"]').removeClass('is-invalid').val(),
            is_first_payment : $('select[name="is_first_payment"]').removeClass('is-invalid').val(),
            first_payment_duration : $('input[name="first_payment_duration"]').removeClass('is-invalid').val(),
            first_payment_percentage : $('input[name="first_payment_percentage"]').val(),
            first_payment_amount : $('input[name="first_payment_amount"]').removeClass('is-invalid').val(),
            loan_result_rounding : $('select[name="loan_result_rounding"]').removeClass('is-invalid').val(),
            start_payment_number : $('input[name="start_payment_number"]').removeClass('is-invalid').val(),
            signed_at : $('input[name="signed_at"]').removeClass('is-invalid').val()
        };

        axios.post("/admin/loan/amortization-schedule", data)
        .then(function (response) {
            if ( response.status == 200 ) {  
                if ( response.data.first_payment.length > 0 ) {
                    buildFirstPaymentTable(response.data.first_payment);
                }
                if (response.data.loan_schedule_collection.length > 0) {
                    buildPaymentScheduleTable(response.data.loan_schedule_collection);
                }
            }           
        })
        .catch(function (error) {
            if ( error.response.status == 422 ) {
                const html_error_text = getValidationErrorsHtml(error.response.data.errors);
                Swal.fire({
                    icon: 'error',
                    title: 'Something went wrong!',
                    text: error.response.data.message
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: "Internal Server Error!",
                    text: error.message           
                });
            }
        });
    });

    $('#payment_option').on("change", function (e) {       
        if ($(this).val() == "" || $(this).val() == undefined ) {            
            setPaymentFieldsReadOnly(false);
            $('input[name="payment_option_id"]').val("");
            return;
        }
        var url = "/admin/payment_options/"+ $(this).val();
        axios.get(url)
        .then(function (response) { 
            if ( response.status == 200 ) {
                var is_first_payment = 0
                if ( response.data.is_first_payment ) {
                    is_first_payment = 1
                }
                var data = response.data;                
                setPaymentFields(
                    data.loan_duration,
                    data.interest,
                    data.special_discount,
                    is_first_payment,
                    data.first_payment_duration,
                    data.first_payment_percentage
                );    
                $('input[name="payment_option_id"]').val(data.id);
                setPaymentFieldsReadOnly(true);               
            }
        })
        .catch(function (error) {
            console.log(error);
        });
    });

    $("#first_payment_option").on("change", function (e) {
        var selected_first_payment_option = $(this).val();
        if ( selected_first_payment_option == 1 ) {            
            $('#first_payment_percentage').removeClass("d-none");
            $('#first_payment_amount').addClass('d-none');
            $('#first_payment_amount').val(0);
        } else {        
            $('#first_payment_percentage').val(0);    
            $('#first_payment_percentage').addClass("d-none");            
            $('#first_payment_amount').removeClass('d-none');
        }
    });

    $('#first_payment_option').trigger("change");

    // $('#payment_option').trigger('change');
    jQuery(function ($) {
        $('form').bind('submit', function () {
            $(this).find(':input').prop('disabled', false);
        });
    });
});