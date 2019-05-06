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
	$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
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
			$(".hours").mask('00:00');
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
			$(".modal-body").html(data.form);
			$("#mymodal").modal();
			$(".hours").mask('00:00');
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

	 $('.table').dataTable({
          "oLanguage": {
          "sEmptyTable":     "Nenhum registro encontrado na tabela",
          "sInfo": "Mostrar _START_ até _END_ de _TOTAL_ registros",
          "sInfoEmpty": "Mostrar 0 até 0 de 0 Registros",
          "sInfoFiltered": "(Filtrar de _MAX_ total registros)",
          "sInfoPostFix":    "",
          "sInfoThousands":  ".",
          "sLengthMenu": "Mostrar _MENU_ registros por pagina",
          "sLoadingRecords": "Carregando...",
          "sProcessing":     "Processando...",
          "sZeroRecords": "Nenhum registro encontrado",
          "sSearch": "Pesquisa Rápida",
          "oPaginate": {
             "sNext": "Próximo",
             "sPrevious": "Anterior",
             "sFirst": "Primeiro",
             "sLast":"Ultimo"
          },
        "oAria": {
            "sSortAscending":  ": Ordenar colunas de forma ascendente",
            "sSortDescending": ": Ordenar colunas de forma descendente"
            }
        },
        "iDisplayLength": 50
      });

	 $(".day-line").click(function(event) {
	    var	date = $(this).data('date');
	 	$.ajax({
	 		url: $(this).data('path')+"/events/getaddform/"+$(this).data('user')+"/"+date,
	 		type: 'post',
	 		dataType: 'json',
	 	})
	 	.done(function(data) {
	 		$(".modal-title").html("Adicionar Evento");
			$(".modal-body").html(data.form);
			$("#mymodal").modal();
			$("#dat_startdate").val(data.date);
			$(".hours").mask('00:00');
			
			 $("#add_events").submit(function(event) {
			 	event.preventDefault();
			 	if (comparedate($("#dat_startdate").val(),$("#hrs_starthour").val(),$("#dat_enddate").val(),$("#hrs_finalhour").val())) {
				 	$.ajax({
				 		url: $(this).data('path')+'/events/compareevent/'+$('#non_users').val()+'/'+$('#dat_startdate').val()+"/"+$("#dat_enddate").val(),
				 		type: 'post',
				 		dataType: 'json',
				 		data: $("#add_events").serialize(),
				 	})
				 	.done(function(data) {
				 		$(".modal-title").html("Adicionar Evento");
						$(".modal-body").html(data.form);
						$("#mymodal").modal();
						$(".reload-btn").click(function(event) {
							window.location.reload();
						});
						$('#hidden_add_event_form').submit(function(event) {
							$.ajax({
								url: $(this).data('path')+"/events/add",
								type: 'post',
								dataType: 'json',
								data: $('#hidden_add_event_form').serialize() ,
							})
							.done(function(data) {
								if (data.success == 1) {
									$(".modal-title").html("Adicionar Evento");
									$(".modal-body").html('<p>Evento cadastrado</p><input type="button" value="Recarregar página" class="btn btn-succes reload-btn">');
									$("#mymodal").modal();
									$(".reload-btn").click(function(event) {
										window.location.reload();
									});
								}else{
									$(".modal-title").html("Adicionar Evento");
									$(".modal-body").html('<p>Ocorreu um erro ao cadastrar o Evento</p><input type="button" value="Recarregar página" class="btn btn-succes reload-btn">');
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
				 }else{
				 	alert('A data e/ou horário de início devem ser maiores do que a data/horário de fim do evento');
				 }
			 	
			 });
	 	})
	 	.fail(function() {
	 		console.log("error");
	 	})
	 	.always(function() {
	 		console.log("complete");
	 	});
	 	
	 });


	 $("#sel_month").change(function(event) {
	 	window.location.assign($(this).data('path')+'/events/'+$('#sel_month').val()+'/'+$('#sel_year').val())
	 });
   
   	 $("#sel_year").change(function(event) {
	 	window.location.assign($(this).data('path')+'/events/'+$('#sel_month').val()+'/'+$('#sel_year').val())
	 });


	 $('.event-btn').click(function() {
	 	$.ajax({
	 		url: $(this).data('path')+'/events/openevent/'+$(this).data('edate'),
	 		type: 'post',
	 		dataType: 'json',
	 	})
	 	.done(function(data) {
	 		$(".modal-title").html("Lista de eventos");
			$(".modal-body").html(data.events);
			$("#mymodal").modal();

	 	})
	 	.fail(function() {
	 		console.log("error");
	 	})
	 	.always(function() {
	 		console.log("complete");
	 	});
	 	
	 });

	 $("#add_bh_btn").click(function(event) {
	 	/* Act on the event */
	 	$.ajax({
	 		url: $(this).data('path')+'/hours/getuseraddform/'+$(this).data('iduser'),
	 		type: 'post',
	 		dataType: 'json',
	 	})
	 	.done(function(data) {
	 		$(".modal-title").html("Novo registro de horas");
			$(".modal-body").html(data.form);
			$("#mymodal").modal();
			$(".hours").mask('00:00');
			$("#bh_pdf_form").attr({
				action: $("#bh_pdf_form").data('path')+'/pdf',
				target: '_blank',
				method: 'post'
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

function comparedate (startdate,starthour,finishdate,finishhour){
	
	if (Date.parse(startdate+' '+starthour) < Date.parse(finishdate+' '+finishhour) ) {
		return true;
	}else{
		return false;
	}
}