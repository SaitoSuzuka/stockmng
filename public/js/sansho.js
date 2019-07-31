/**
 *
 */

function toriSentaku(code,name){
	var form = document.frm;
	form.torihikisaki_code.value = code;
	form.torihikisaki_name.value = name;
	form.submit();
}

function yakuSentaku(jan, kbn, yj, name){
	var form = document.frm;
	form.jan_code.value = jan;
	form.yakuhin_kbn.value= kbn;
	form.yj_code.value = yj;
	form.hanbai_name.value = name;

	if(kbn == "1"){
		form.yakuhin_kbn_name.value = "薬品";
	} else if(kbn == "2"){
		form.yakuhin_kbn_name.value = "OTC";
	} else if(kbn == "4"){
		form.yakuhin_kbn_name.value = "特材";
	} else {
		form.yakuhin_kbn_name.value = "不明";
	}

	form.submit();
}