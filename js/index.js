/**
 * AJAX Setup
 */
$.ajaxSetup({
	type:'POST',
	url:'config/session.php',
	dataType:'json',
	error: function(xhr){console.log(xhr);}
});

function checkLogin ()
{
	var username = $("#inputEmail").val();
	var password = $("#inputPassword").val();
	
	$.ajax({
		data:{ckLog:'',
			ckLogU:username,
			ckLogP: password
		},
		success: function(data) {checkLoginHandler(data);
		}
	});
}

function checkLoginHandler(json)
{
	if (json.result == "ok")
	{
		window.location.href = 'main.php';
	}
	else
	{
		$("#access_error").show();
	}
}

$(document).ready(function(){
	
	$(".form-control").on('click',function(){
		$("#access_error").hide();
	});
		
	$("#login").click(function() {
		checkLogin();
	});
});