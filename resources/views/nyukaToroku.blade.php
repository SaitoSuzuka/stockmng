@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<div class="card">
				<div class="card-header">{{ $title }}</div>
    			<div class="card-body">
    				<!-- ↓actionに何も指定していない -->
    				<form name="frm" action="" method="post">
    					<!-- ↓これはブレードのお決まり。これがないとエラー -->
    					{{ csrf_field() }}
    					<table class="table">
    						<tr>
    							<th>入荷連番</th><th>:</th>
    							<td>
    								<input type="text" value="{{ $nyuka_seq }}" disabled>
    								<input type="hidden" name="nyuka_seq" value="{{ $nyuka_seq }}">
    							</td>
    							<td></td>
    							<th>入荷数</th><th>:</th>
    							<td>
    								<input type="text" name="nyuka_su" value="{{ $nyuka_su }}" {{ $disabled }}>

    							</td>
    						</tr>
    						<tr>
    							<th>店舗</th><th>:</th>
    							<td>
    								@if($kengen_code == "002")
    									<input type="hidden" name="tenpo_code" value="{{ $tenpo_code }}">
    									<select disabled>
    								@else
    									<select name="tenpo_code">
    								@endif

    									<option value="">----</option>
    								@foreach($tenpo_data as $tenpo)
    									@if($tenpo_code == $tenpo->torihikisaki_code)
    										<option value="{{ $tenpo->torihikisaki_code }}" selected>{{ $tenpo->torihikisaki_name }}</option>
    									@else
    										<option value="{{ $tenpo->torihikisaki_code }}" >{{ $tenpo->torihikisaki_name }}</option>
    									@endif
    								@endforeach
    									</select>
    							</td>
    							<td></td>
    							<th>入荷日</th><th>:</th>
    							<td>
    								<input type="date" name="nyuka_date" value="{{ $nyuka_date }}" {{ $disabled }}>
    							</td>
    						</tr>
    						<tr>
    							<th>取引先</th><th>:</th>
    							<td>
    								<input type="text" value="{{ $torihikisaki_name }}" disabled>
    								<input type="hidden" name="torihikisaki_code" value="{{ $torihikisaki_code }}">
    								<input type="hidden" name="torihikisaki_name" value="{{ $torihikisaki_name }}">
    							</td>
    							<td>
    								<button formaction="torisansho" {{ $disabled }}>参照</button>
    							</td>
								<th rowspan="4">備考</th><th>:</th>
    							<td rowspan="4">
    								<textarea rows="4" cols="20" name="biko" {{ $disabled }}>{{ $biko }}</textarea>
    							</td>
    						</tr>
    						<tr>
    							<th>薬品名</th><th>:</th>
								<td>
									<input type="text" value="{{ $hanbai_name }}" disabled>
									<input type="hidden" name = "hanbai_name" value="{{ $hanbai_name }}">
								</td>
								<td>
									<button formaction="/yakusansho" {{ $disabled }}>参照</button>
								</td>
    						</tr>
    						<tr>
    							<th>薬品区分</th><th>:</th>
    							<td>
    								<input type="text" value="{{ $yakuhin_kbn_name }}" disabled>
    								<input type="hidden" name = "yakuhin_kbn_name" value="{{ $yakuhin_kbn_name }}">
    								<input type="hidden" name = "yakuhin_kbn" value="{{ $yakuhin_kbn }}">
    							</td>
    						</tr>
    						<tr>
    							<th>JANコード</th><th>:</th>
    							<td>
    								<input type="text" value="{{ $jan_code }}" disabled>
    								<input type="hidden" name="jan_code" value="{{ $jan_code }}">
    							</td>
    						</tr>
    						<tr>
    							<th>YJコード</th><th>:</th>
    							<td>
    								<input type="text" value="{{ $yj_code }}" disabled>
    								<input type="hidden" name="yj_code" value="{{ $yj_code }}">
    							</td>
    							<td></td>
    							<td colspan="3" style="text-align: center">
    								<button formaction="{{ $action }}">{{ $button }}</button>&nbsp;&nbsp;&nbsp;
    								<button type="button" onclick="cancel()">キャンセル</button>
    							</td>
    						</tr>
    					</table>
    				</form>
    				@include('common.errors')
    			</div>
			</div>
		</div>
	</div>
</div>

@endsection