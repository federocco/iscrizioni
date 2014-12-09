/**
 * AJAX Setup
 */
$.ajaxSetup({
	type:'POST',
	url:'ajax/request.php',
	dataType:'json',
	error: function(xhr){console.log(xhr);}
//	complete: function(xhr){console.log(xhr);}
});

/**
 * Disposizione delle dialog
 */

function getBrowser()
{
    var N= navigator.appName, ua= navigator.userAgent, tem;
    var M= ua.match(/(opera|chrome|safari|firefox|msie)\/?\s*(\.?\d+(\.\d+)*)/i);
    if(M && (tem= ua.match(/version\/([\.\d]+)/i))!= null) M[2]= tem[1];
    M= M? [M[1], M[2]]: [N, navigator.appVersion,'-?'];
    return M;
}

var position  = "center";
var browserArray = getBrowser();
var tipo = browserArray[0];
var ver = browserArray[1];
if(tipo.toUpperCase()==="MSIE") {	
	if (ver == 9 ) {
	    position = {
	        my: "center",
	        at: "center",
	        of: $("body"),
	        within: $("body")
	    }
	}
}

$(document).ready(function(){
	//$("button").button();
	
	tableAnagrafica.loadData();	
	gestioneIscritto.initialize();
});