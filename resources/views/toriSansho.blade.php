@extends('layouts.app')


@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<div class="card">
				<div class="card-header">取引先参照</div>
				<div class="card-body">
					<form action="/torikensaku" method="post">
						{{ csrf_field() }}
						<div class="form-group row">
							<label for="torihikisaki" class="col-md-1 col-form-label text-md-right">{{ __('取引先') }}</label>
							<div class="col-md-3">
								<input type="text" id="torihikisaki" name="torihikisaki">
							</div>
							<label for="torihikisaki_kbn" class="col-md-1 col-form-label text-md-right">{{ __('区分') }}</label>
							<div class="col-md-2">
								<select id="torihikisaki_kbn" name="torihikisaki_kbn">
									<option value="">--</option>
									<option value="1">問屋</option>
									<option value="2">他店舗</option>
									<option value="3">他薬局</option>
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
								<th>取引先コード</th><th>取引先区分</th>
							</tr>
							@foreach($sansho_list as $row)
								<tr>
									<td>
										<a href="#" onclick="toriSentaku('{{ $row->torihikisaki_code }}' , '{{ $row->torihikisaki_name }}')">{{ $row->torihikisaki_code }}</a>
									</td>
									<td>
										{{ $row->torihikisaki_name }}
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
<form name="frm" action="/torisentaku" method="post">
	{{ csrf_field() }}
	<input type="hidden" name="torihikisaki_code">
	<input type="hidden" name="torihikisaki_name">
</form>

@endsection