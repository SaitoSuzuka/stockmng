@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center"> <!-- 個々の値で中央寄せしている。 -->
        <div class="col-md-8"><!-- 12分割中の8を利用している -->
            <div class="card">
                <div class="card-header">{{ __('メインメニュー') }}</div><!-- {}はphp側で用意した変数を利用するとき使用 -->

                <div class="card-body">

                {{ csrf_field() }}


                <div class="form-group row">
                <span class="col-md-3"></span>
                	<ul class="col-md-5">
                	<!-- $mに一行ずつ入れている -->
                		@foreach($menu as $m)
                			<li>
                			<!-- その中のuriをurlにしていして、メニューネームを表示している。 -->
                				<a href="/{{ $m->menu_uri }}">{{$m->MENU_NAME}}</a>
                			</li>
                		@endforeach
                	</ul>
            	</div>
            	</div>
			</div>
		</div>
	</div>
</div>


@endsection