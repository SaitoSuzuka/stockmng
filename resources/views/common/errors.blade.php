@if(count($errors) > 0) <!-- もしエラーがあったら表示される。なかったら何も表示されない -->
	<div class="alert alert-danger">
		<ul>
			@foreach($errors->all() as $error) <!-- foreachを書き込んで保存すると必ず警告が入る -->
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif

<!-- book.blade.phpに差し込む -->