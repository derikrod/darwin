$(function () {
	$('#login_form').on('submit', function(event) {
		event.preventDefault();
		/* Act on the event */
		$.ajax({
			url: $(this).data('path')+'/login',
			type: 'post',
			dataType: 'json',
			data: $('#login_form').serialize(),
		})
		.done(function(data) {
			if (data.success == 1) {
				setCookie('intra_user',data.iduser,365);
				window.location.assign = '';			
			}else{
				$("#error_display").html('Usuário e/ou senha inválido(s)!');
			}
		})
		.fail(function() {
			console.log("error");
		})
	});

	$("#logout_btn").click(function() {
		document.cookie = "intra_user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
		window.location.assign($(this).data('path'));
	});
});


function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));
	var expires = "expires="+ d.toUTCString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

