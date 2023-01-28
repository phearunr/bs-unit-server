@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.banks.update', ['id' => $bank->id]) }}" novalidate="novalidate" autocomplete="false">
        @csrf   
        {{ method_field('PUT') }}       
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{__("Bank")}} : {{ __("Edit") }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif 

                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="name">{{ __('Bank Name') }}</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="ABA-BCC2" value="{{ old('name') ?? $bank->name }}">
                            </div> 
                            <div class="form-group col-md-4">
                                <label for="short_name">{{ __('Short Name') }}</label>
                                <input type="text" class="form-control" name="short_name" id="short_name" placeholder="ABA" value="{{ old('short_name') ?? $bank->short_name }}">
                            </div>
                        </div>
                         <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="account_name">{{ __('Account Name') }}</label>
                                <input type="text" class="form-control" name="account_name" id="account_name" placeholder="Borey Chaktomuk City 2" value="{{ old('account_name') ?? $bank->account_name }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="account_number">{{ __('Account Number') }}</label>
                                <input type="text" class="form-control" name="account_number" id="account_number" placeholder="0123456789" value="{{ old('account_number') ?? $bank->account_number }}">
                            </div>
                        </div>
                    </div>              
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">{{__("Update")}} {{ __("Bank") }}</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.banks.index') }}" class="btn btn-secondary float-right">{{ __("Back to") }} {{ __("Bank List") }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
