function subcat_din(tipus) {
    var tip = parseInt(tipus);
    var select = document.getElementById("sel1");
    var num = select.options[select.selectedIndex].value;
    var url = "srv/subcat.php?term=" + num;
    if (tip == 1) {
	select = document.getElementById("sel2");
	num = select.options[select.selectedIndex].value;
	url = "srv/subcat.php?term=" + num;	
    }
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
	    var resposta = this.responseText;
	    canviarSubCat(resposta, tip);
	}
    };
    xhttp.open("GET", url, true);
    xhttp.send();
    
}

function canviarSubCat(text, tipus) {
    var vec = JSON.parse(text);
    var i;
    var sel_sub = document.getElementById("sel2");
    if (tipus == 1)
	sel_sub = document.getElementById("sel3");
    for(i = sel_sub.options.length - 1 ; i >= 0 ; i--) {
        sel_sub.remove(i);
    }
    for (i = 0; i < vec.length; i++) {
	var val = vec[i]["label"];
	var txt = vec[i]["value"]; 
	var option = document.createElement("option");
	option.text = txt;
	option.value = val;
	sel_sub.add(option, sel_sub[i]);
    }
}
