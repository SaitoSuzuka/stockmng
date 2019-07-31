@extends('layouts.app')


@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<div class="card">
				<div class="card-header">{{ __('入荷データ一覧') }}</div>
				<div class="card-body">

					<form action="/nkensaku" method="post">
						@csrf
						<div class="form-group row">
							<!-- label for=""と select id=""が結びついている。ラベルを押すとカーソルが移動するなどする -->
							<label for="yakuhin_kbn" class="col-md-2 col-form-label text-md-right">{{ __('薬品区分') }}</label>
							<div class="col-md-5">
								<select id="yakuhin_kbn" name="yakuhin_kbn">
									<option value="">--</option>
									<!-- count -> .lengthと同じ　ちなみに値は３ -->
									@for($i = 0; $i < count($y_kbn_code); $i++)
										@if($yakuhin_kbn == $y_kbn_code[$i])
											<option value="{{ $y_kbn_code[$i] }}" selected>{{ $y_kbn_name[$i] }}</option>
										@else
											<option value="{{ $y_kbn_code[$i] }}">{{ $y_kbn_name[$i] }}</option>
										@endif
									@endfor
								</select>
							</div>
							<label for="tenpo_code" class="col-md-1 col-form-label text-md-right">{{ '店舗' }}</label>
							<div class="col-md-4">
								@if($kengen_code == "002")
    								<input type="hidden" name="tenpo_code" value="{{ $tenpo_code }}">
    								<select name="d_tenpo_code" disabled>
    							@else
    								<select id="tenpo_code" name="tenpo_code">
    							@endif
    								<option value="">--</option>
    								@foreach($tenpo_data as $tenpo)
    									@if($tenpo_code == $tenpo->torihikisaki_code)
    										<option value="{{$tenpo->torihikisaki_code }}" selected>{{ $tenpo->torihikisaki_name }}</option>
    									@else
    										<option value="{{$tenpo->torihikisaki_code }}">{{ $tenpo->torihikisaki_name }}</option>
    									@endif
    								@endforeach
    								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="date_from" class="col-md-2 col-form-label text-md-right">{{ '入荷数' }}</label>
							<div class="col-md-5">
								<input type="date" id="date_from" name="date_from" value="{{ $date_from }}">&nbsp;&nbsp;~&nbsp;&nbsp;
								<input type="date" id="date_to" name="date_to" value="{{ $date_to }}">
							</div>
							<label for="yakuhin" class="col-md-1 col-form-label text-md-right">{{ '薬品' }}</label>
							<div class="col-md-4">
								<input type="text" id="yakuhin" name="yakuhin" value="{{ $yakuhin}}">
							</div>
						</div>
						<div class="form-group row">
							<label for="torihikisaki" class="col-md-2 col-form-label text-md-right">{{ '取引先' }}</label>
							<div class="col-md-5">
								<input type="text" id="torihikisaki" name="torihikisaki" value="{{ $torihikisaki }}">
							</div>
							<div class="col-md-5 text-md-center">
								<button type="submit">検索</button>&nbsp;&nbsp;<!-- submitでformタグのaction先に飛ぶ -->
								<button formaction="/nshinki">新規作成</button><!-- formaction で飛び先を変更できる-->
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- 以下一覧表示 -->
		@if(count($nyuka_list) > 0)
			<div class="w-100">
				<div class="card">
    				<div class="card-body">
    					<div class="row">
    						<div class="col-md-4 col-md-offset-4">
    							{{ $nyuka_list->links() }}
    						</div>
    					</div>
    					<table class="table table-borderd table-striped">
    						<tr>
    							<th>店舗</th><th>取引先</th><th>薬品区分</th>
    							<th>JANコード</th><th>薬品名</th><th>入荷数</th>
    							<th>入荷数</th><th>編集</th><th>削除</th>
							</tr>
							@foreach($nyuka_list as $row)
							<tr>
								<td>{{ $row->tenpo_name }}</td>
								<td>{{ $row->torihikisaki_name }}</td>
								<td>
									@if($row->yakuhin_kbn == "1")
										薬品
									@elseif($row->yakuhin_kbn == "2")
										OTC
									@elseif($row->yakuhin_kbn == "4")
										特材
									@else
										不明
									@endif
								</td>
								<td>{{ $row->jan_code }}</td>
								<td>{{ $row->hanbai_name }}</td>
								<td>{{ $row->nyuka_su }}</td>
								<td>{{ $row->nyuka_date }}</td>
								<td>
									<form action="nhenshu" method="post">
										<input type="hidden" name="nyuka_seq" value="{{ $row->nyuka_seq }}">
										<button type="submit">編集</button>
									</form>
								</td>
								<td>
									<form action="ndelete" method="post">
										<input type="hidden" name="nyuka_seq" value="{{ $row->nyuka_seq }}">
										<button type="submit">削除</button>
									</form>
								</td>
							</tr>
							@endforeach
    					</table>
    				</div>
				</div>
			</div>
		@endif
	</div>
</div>


@endsection