@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="/putLogin"><!-- action = "遷移先を指定" -->
                        @csrf

                        <div class="form-group row">
                            <label for="shain_code" class="col-md-4 col-form-label text-md-right">{{ __('社員コード') }}</label>
                            <div class="col-md-6">
                                <input id="shain_code" type="text" name="shain_code" value="{{ $shain_code }}" required autofocus>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('パスワード') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" name="password" value="{{ $password }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                        	<label for="tenpo_code" class="col-md-4 col-form-label text-md-right">{{ __('店舗') }}</label>
                            <div class="col-md-6">
                                <select id="tenpo_code" name="tenpo_code">
                                	<option value="">--店舗を選択--</option>
                                	@foreach($tenpo_data as $tenpo)
                                		@if($tenpo_code==$tenpo->torihikisaki_code)
                                			<option value="{{ $tenpo->torihikisaki_code }}" selected>{{ $tenpo->torihikisaki_name }}</option>
                                		@else
                                			<option value="{{ $tenpo->torihikisaki_code }}">{{ $tenpo->torihikisaki_name }}</option>
                                		@endif
                                	@endforeach

                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                        	<span>{{ $msg }}</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
