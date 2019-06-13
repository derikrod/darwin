$(function () {
	/*adicionar classes nas tabelas*/
			$("#user_hours_div>table>tbody>tr").each(function() {
				$(this).addClass('pdf_hours');
			});
			$("#admin_unsolvedcalls_div>table>tbody>tr").each(function() {
				$(this).addClass('unsolved_calls');
			});
			$("#admin_solvedcalls_div>table>tbody>tr").each(function() {
				$(this).addClass('solved_calls');
			});

	//login
	$('#login_form').on('submit', function(event) {
		event.preventDefault();
		/* Act on the event */
		$("#btn_users_form").html('<img src="'+$(this).data('path')+'/assets/images/loading.gif" alt="" style="width:50px;" />');
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
				$("#btn_users_form").html('<input type="submit" class="btn btn-success" value="Entrar">');
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
	//adicionar usuário
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
				$("#btn_users_form").html('<img src="'+$(this).data('path')+'/assets/images/loading.gif" alt="" style="width:50px;" />');
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
					}else{
						$(".modal-title").html("Adicionar Usuário");
						$(".modal-body").html('<p>Ocorreu um erro inesperado</p><button type="button" class="btn btn-success reload-btn">Recarregar Página</button>');
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
	//update
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
			$("#sel_users").css('pointer-events','none');
			$("#div_sel_bhstatus").html("");
			$("#btn_hours_form").append('&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="btn btn-primary aprove-btn"  value="APROVAR" data-path="'+$("#update_hours").data('path')+'"data-id="'+$("#update_hours").data('id')+'">');
			$("#btn_lates_form").append('&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="btn btn-primary pay-hours-btn"  value="USAR HORAS" data-toggle="tooltip" data-placement="bottom" title="Horas extas do colaborador: '+data.hours+' Horas" data-path="'+$("#update_lates").data('path')+'"data-id="'+$("#update_lates").data('id')+'">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="btn btn-warning pay-money-btn"  value="DESCONTAR" data-path="'+$("#update_lates").data('path')+'"data-id="'+$("#update_lates").data('id')+'">');
			$('[data-toggle="tooltip"]').tooltip()
			/*remover dados*/
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
								$(".modal-body").html('<p>Dados removidos com sucesso</p><div class="text-center"><button type="button" class="btn btn-success reload-btn">Recarregar Página</button></div>');
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

			});
			
			/*aprovar horas extras*/
			$('.aprove-btn').click(function function_name() {
				$(".modal-title").html("Aprovar Horas");
				$(".modal-body").html("<p>Esta alteração não poderá ser desfeita. Você tem certeza que quer continuar?</p><div class='text-center'><input type='button' class='btn btn-success' value='Alterar' id='confirm_approve' data-path='"+$(this).data('path')+"' data-id='"+$(this).data('id')+"'></div>");
				$("#mymodal").modal();
				$("#confirm_approve").click(function(event) {
					/* Act on the event */
					$.ajax({
						url: $(this).data('path')+'/hours/approve/'+$(this).data('id'),
						type: 'post',
						dataType: 'json',
					})
					.done(function(data) {
						if (data.success == 1) {
							$(".modal-title").html("Aprovar Horas");
							$(".modal-body").html("<p>Horas aprovadas com sucesso</p><div class='text-center'><input type='button' class='btn btn-success reload-btn' value='Recarregar' </div>");
							$("#mymodal").modal();
							$(".reload-btn").click(function(event) {
							window.location.reload();
							});
						}else{

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
			
			/*compensar atrasos com horas*/
			$('.pay-hours-btn').click(function function_name() {
				$(".modal-title").html("Compensar Atrasos");
				$(".modal-body").html("<p>Com essa opção você estará usando as horas extras do colaborador para compensar este atraso ou falta.<br>Esta alteração não poderá ser desfeita. Você tem certeza que quer continuar?</p><div class='text-center'><input type='button' class='btn btn-success' value='Alterar' id='confirm_use' data-path='"+$(this).data('path')+"' data-id='"+$(this).data('id')+"'></div>");
				$("#mymodal").modal();
				$("#confirm_use").click(function(event) {
					/* Act on the event */
					$.ajax({
						url: $(this).data('path')+'/lates/use_hours/'+$(this).data('id'),
						type: 'post',
						dataType: 'json',
					})
					.done(function(data) {
						if (data.success == 1) {
							$(".modal-title").html("Compensar Atrasos");
							$(".modal-body").html("<p>Horas compensadas com sucesso</p><div class='text-center'><input type='button' class='btn btn-success reload-btn' value='Recarregar'> </div>");
							$("#mymodal").modal();
							$(".reload-btn").click(function(event) {
							window.location.reload();
							});
						}else{
							$(".modal-title").html("Compensar Atrasos");
							$(".modal-body").html("<p>O Usuário não tem horas o bastante para compensar este atraso.</p><div class='text-center'><input type='button' class='btn btn-success reload-btn' value='Recarregar'> </div>");
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
			/*compensar atrasos com horas*/
			/*descontar do salário*/
			$('.pay-money-btn').click(function function_name() {
				$(".modal-title").html("Descontar horas");
				$(".modal-body").html("<p>Esta alteração atesta que os atrasos em questão serão descontados do salário do colaborador.<br> Esta alteração não poderá ser desfeita. Você tem certeza que quer continuar?</p><div class='text-center'><input type='button' class='btn btn-success' value='Alterar' id='confirm_approve' data-path='"+$(this).data('path')+"' data-id='"+$(this).data('id')+"'></div>");
				$("#mymodal").modal();
				$("#confirm_approve").click(function(event) {
					/* Act on the event */
					$.ajax({
						url: $(this).data('path')+'/lates/descount/'+$(this).data('id'),
						type: 'post',
						dataType: 'json',
					})
					.done(function(data) {
						if (data.success == 1) {
							$(".modal-title").html("Aprovar Horas");
							$(".modal-body").html("<p>Horas compensadas com sucesso</p><div class='text-center'><input type='button' class='btn btn-success reload-btn' value='Recarregar' </div>");
							$("#mymodal").modal();
							$(".reload-btn").click(function(event) {
							window.location.reload();
							});
						}else{

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
			/*descontar do salário*/

			/*atualizar dados*/
			$("#update_"+$('.inform-row').data('table')).submit(function(event) {
				$(this).hide();
				event.preventDefault();
				$.ajax({
					url: $(this).data('path')+'/'+$(this).data('table')+'/update/'+$(this).data('id'),
					type: 'post',
					dataType: 'json',
					data: $("#update_"+$('.inform-row').data('table')).serialize(),
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

	/*atualizar dados*/

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
			if ($("#add_bh_btn").data('lates') == 1) {
				$("#sel_bhtypes").val(2);
				$("#sel_bhtypes").css('pointer-events','none');
				$("#error_display").html('Você precisa compensar seus atrasos antes de fazer horas extras');
			}
			$("#bh_pdf_form").attr({
				action: $("#bh_pdf_form").data('path')+'/pdf',
				target: '_blank',
				method: 'post'
			});
			$("#bh_pdf_form").submit(function () {
				window.location.reload();
			})
			
	 	})
	 	.fail(function() {
	 		console.log("error");
	 	})
	 	.always(function() {
	 		console.log("complete");
	 	});
	 	
	 });


	 /*gerar pdf via id*/
	 $(".pdf_hours").click(function() {
	 	$(".modal-title").html("Gerar documento");
			$(".modal-body").html('<p>Por favor, verifique se as informações do documento estão corretas.</p><p>Este documento deve ser impresso e as assinaturas dos responsáveis devem ser colhidas.</p><form method="post" action="'+$(this).data('path')+'/pdf/load/'+$(this).data('id')+'" target="blank"><div class="text-center"><input type="submit" class="btn btn-success" value="Gerar PDF"></div></form>');
			$("#mymodal").modal();
	 });
	 
	 $("#add_late_btn").click(function(event) {
	 	/* Act on the event */

	 	$.ajax({
	 		url: $(this).data('path')+'/lates/addform',
	 		type: 'post',
	 		dataType: 'json'
	 	})
	 	.done(function(data) {
	 		$(".modal-title").html("Adicionar Atraso");
			$(".modal-body").html(data.form);
			$("#mymodal").modal();
			$(".hours").mask('00:00');
			$("#add_lates").submit(function(event) {
				$("#btn_lates_form").html('<img src="'+$(this).data('path')+'/assets/images/loading.gif" alt="" style="width:50px;" />');
				/* Act on the event */
				event.preventDefault();
				$.ajax({
					url: $(this).data('path')+'/lates/addlate',
					type: 'post',
					dataType: 'json',
					data: $("#add_lates").serialize(),
				})
				.done(function(data) {
					if (data.success == 1) {
						$(".modal-title").html("Adicionar Atraso");
						$(".modal-body").html('<p>Atraso cadastrado</p><input type="button" value="Recarregar página" class="btn btn-succes reload-btn">');
						$("#mymodal").modal();
						$(".reload-btn").click(function(event) {
							window.location.reload();
						});
					}else{
						$(".modal-title").html("Adicionar Atraso");
						$(".modal-body").html('<p>Ocorreu um erro ao cadastrar o Atraso</p><input type="button" value="Recarregar página" class="btn btn-succes reload-btn">');
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

	 $("#showcalc").click(function(event) {
	 	
	 	/* Act on the event */
	 	$.ajax({
	 		url: $(this).data('path')+'/calc/',
	 		type: 'post',
	 		dataType: 'json',
	 	})
	 	.done(function(data) {
	 		$(".modal-title").html("Calculadora de produtos");
			$(".modal-body").html(data.form);
			$("#mymodal").modal();
	 	})
	 	.fail(function() {
	 		console.log("error");
	 	})
	 	.always(function() {
	 		console.log("complete");
	 	});
	 	
	 });

	 /*contatos*/
	$("#contact_form").submit(function(event) {
		event.preventDefault();
		$.ajax({
			url: $(this).data('path')+"/contacts/get",
			type: 'post',
			dataType: 'json',
			data: $("#contact_form").serialize(),
		})
		.done(function(data) {
			$(".modal-title").html("Contatos");
			$(".modal-body").html(data.list);
			$("#mymodal").modal();
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	});
	/*contatos*/

	/*ti*/
	$("#newcall_btn").click(function(event) {
		$.ajax({
			url: $(this).data('path')+'/calls/getuserform/'+$(this).data('id'),
			type: 'post',
			dataType: 'json'
		})
		.done(function(data) {
			$(".modal-title").html("Novo Chamado");
			$(".modal-body").html(data.form);
			$("#mymodal").modal();
			$("#add_calls").submit(function(event) {
				event.preventDefault();
				$("#btn_calls_form").html('<img src="'+$(this).data('path')+'/assets/images/loading.gif" alt="" style="width:50px;" />');
				$.ajax({
					url: $(this).data('path')+"/calls/add",
					type: 'post',
					dataType: 'json',
					data: $("#add_calls").serialize(),
				})
				.done(function(data) {
					$(".modal-title").html("Novo Chamado");
						$(".modal-body").html('<p>Chamado cadastrado</p><input type="button" value="Recarregar página" class="btn btn-succes reload-btn">&nbsp;&nbsp;<a href="'+data.path+'/calls" class="btn btn-primary">LISTA DE CHAMADOS</a>');
						$("#mymodal").modal();
						$(".reload-btn").click(function(event) {
							window.location.reload();
						});
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
	/*ti*/

	$(".unsolved_calls").click(function () {
		$.ajax({
			url: $(this).data('path')+'/calls/getupdatestatus/'+$(this).data('id'),
			type: 'post',
			dataType: 'json',
		})
		.done(function(data) {
			$(".modal-title").html("Chamados");
			$(".modal-body").html(data.form);
			$("#mymodal").modal();
			$("#updatecallstatus_form").submit(function(event) {
				event.preventDefault();
				$.ajax({
					url: $(this).data('path')+"/calls/updatestatus",
					type: 'post',
					dataType: 'json',
					data: $('#updatecallstatus_form').serialize(),
				})
				.done(function(data) {
					
					if (data.success == 0) {
						$(".modal-title").html("Chamados");
						$(".modal-body").html('<p>Dados alterados</p><button type="button" class="btn btn-success reload-btn">Recarregar Página</button>');
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
		
	})

	$('.solved_calls').click(function () {
		$.ajax({
			url: $(this).data('path')+'/calls/getsolution/'+$(this).data('id'),
			type: 'post',
			dataType: 'json',
		})
		.done(function(data) {
			$(".modal-title").html("Chamados");
			$(".modal-body").html(data.solution);
			$("#mymodal").modal();
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	})
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