/**
 *
 */

function nyukaShinki() {
	alert("call nyuka success");

}

function cancel() {
	if(window.confirm("画面を閉じて一覧に戻ります。よろしいでしょうか？")){
		var form = document.frm;
		form.action = "/redisplist";
		form.submit();
	}
}