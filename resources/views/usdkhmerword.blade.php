@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Test Convert USD to Khmer Word</div>

                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="usd_money">USD Money</label>
                            <input type="text" class="form-control form-control-lg" id="usd_money" placeholder="Enter Numeric">
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" id="convert_button">Convert</button>
                        </div>
                        <div class="form-group">
                            <label for="khmer_word">Khmer Word</label>
                            <input type="text" class="form-control form-control-lg" id="khmer_word" readonly="readonly">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $('#convert_button').click(function (){
        axios.post('/admin/misc/usd_to_khmer_word',{ number : $('#usd_money').val() })
        .then(function (response) {
            $("#khmer_word").val(response.data);
            console.log(response);
        })
        .catch(function (error) {
            console.log(error);
        });
    });
</script>
@endpush
