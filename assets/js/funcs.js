$(function () {
	$('#login_form').on('submit', function(event) {
		event.preventDefault();
		/* Act on the event */
		$.ajax({
			url: $(this).data('path')+'/login/index/'+$("#txt_login").val()+'/'+$("#psw_pass").val(),
			type: 'post',
			dataType: 'json'
		})
		.done(function(data) {
			if (data.success == 1) {
				setCookie('intra_user',data.iduser,365);
				window.location.reload();			
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

	$("#add_user_btn").click(function() {
		$.ajax({
			url: $(this).data('path')+'/users/addform',
			type: 'post',
			dataType: 'json',
		})
		.done(function(data) {
			$(".modal-title").html("Adicionar Usuário");
			$(".modal-body").html(data.user_form);
			$("#mymodal").modal();
			$("#add_users").submit(function(event) {
				event.preventDefault();
				$.ajax({
					url: $(this).data('path')+'/users/adduser',
					type: 'post',
					dataType: 'json',
					data: $("#add_users").serialize(),
				})
				.done(function(data) {
					if (data.success == 1) {
						$(".modal-title").html("Adicionar Usuário");
						$(".modal-body").html('<p>Usuário Cadastrado com sucesso</p><button type="button" class="btn btn-success reload-btn">Recarregar Página</button>');
						$("#mymodal").modal();
						$(".reload-btn").click(function(event) {
							window.location.reload();
						});
					}	
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
				
			});


		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
		
	});
	
	$('.inform-row').click(function() {
		$.ajax({
			url: $(this).data('path')+'/'+$(this).data('table')+'/updateForm/'+$(this).data('id'),
			type: 'post',
			dataType: 'json',
		})
		.done(function(data) {
			$(".modal-title").html("Alterar dados");
			$(".modal-body").html(data.user_form);
			$("#mymodal").modal();
			$('#remove_btn').click(function () {
					$(".modal-title").html("Excluir dados");
					$(".modal-body").html('<p>Você deseja realmente excluir esses dados?</p><button type="button" id="confirm_delete"class="btn btn-danger" data-table="'+$(this).data('table')+'" data-path="'+$(this).data('path')+'" data-id="'+$(this).data('id')+'">Excluir</button>');
					$("#mymodal").modal();
					$("#confirm_delete").click(function(event) {
						$.ajax({
							url: $(this).data('path')+"/"+$(this).data('table')+"/delete/"+$(this).data('id'),
							type: 'post',
							dataType: 'json',
						})
						.done(function(data) {
							if (data.success == 1) {
								$(".modal-title").html("Remover dados");
								$(".modal-body").html('<p>Dados removidos com sucesso</p><button type="button" class="btn btn-success reload-btn">Recarregar Página</button>');
								$("#mymodal").modal();
								$(".reload-btn").click(function(event) {
									window.location.reload();
								});
							}
						})
						.fail(function() {
							console.log("error");
						})
						.always(function() {
							console.log("complete");
						});
						
					});

			})
			$("#update_users").submit(function(event) {
				event.preventDefault();
				$.ajax({
					url: $(this).data('path')+'/'+$(this).data('table')+'/update/'+$(this).data('id'),
					type: 'post',
					dataType: 'json',
					data: $("#update_users").serialize(),
				})
				.done(function(data) {
					if (data.success == 1) {
						$(".modal-title").html("Alterar dados");
						$(".modal-body").html('<p>Cadastro alterado com sucesso</p><button type="button" class="btn btn-success reload-btn">Recarregar Página</button>');
						$("#mymodal").modal();
						$(".reload-btn").click(function(event) {
							window.location.reload();
						});
					}
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
				
			});
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	});


});

//auxiliares
function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));
	var expires = "expires="+ d.toUTCString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

