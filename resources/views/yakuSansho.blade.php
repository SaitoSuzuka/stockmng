@extends('layouts.app')


@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<div class="card">
				<div class="card-header">薬品参照</div>
				<div class="card-body">
					<form action="/yakukensaku" method="post">
						{{ csrf_field() }}
						<div class="form-group row">
							<label for="torihikisaki" class="col-md-1 col-form-label text-md-right">{{ __('薬品名') }}</label>
							<div class="col-md-3">
								<input type="text" id="yakuhin" name="yakuhin">
							</div>
							<label for="yakuhin_kbn" class="col-md-1 col-form-label text-md-right">{{ __('区分') }}</label>
							<div class="col-md-2">
								<select id="yakuhin_kbn" name="yakuhin_kbn">
									<option value="">--</option>
									<option value="1">薬品</option>
									<option value="2">OTC</option>
									<option value="4">特材</option>
								</select>
							</div>
							<div class="col-md-5">
								<button type="submit">検索</button>
								<button formaction="/closesansho">キャンセル</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- 以下一覧表示 -->
		@if(count($sansho_list) > 0)
			<div class="w-100">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-4 col-md-offset-4">
								{{ $sansho_list->links() }}
							</div>
						</div>
						<table class="table table-borderd table-striped">
							<tr>
								<th>JANコード</th><th>薬品区分</th><th>YJコード</th><th>薬品名</th>
							</tr>
							@foreach($sansho_list as $row)
								<tr>
									<td>
										<a href="#" onclick="yakuSentaku
											('{{ $row->jan_code }}' , '{{ $row->yakuhin_kbn }}' , '{{ $row->yj_code }}' , '{{ $row->hanbai_name }}')">
											{{ $row->jan_code }}</a>
									</td>
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
									<td>

										{{ $row->yj_code }}
									</td>
									<td>
										{{ $row->hanbai_name }}
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
<form name="frm" action="/yakusentaku" method="post">
	{{ csrf_field() }}
	<input type="hidden" name="jan_code">
	<input type="hidden" name="yakuhin_kbn">
	<input type="hidden" name="yakuhin_kbn_name">
	<input type="hidden" name="yj_code">
	<input type="hidden" name="hanbai_name">
</form>

@endsection