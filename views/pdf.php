

 <style type="text/css">
			.row{
				margin-right: 0;
				margin-left: 0;
				margin-top: 10px;
				margin-bottom: 10px;
			}
			tr{
				text-align: center;
				padding-top: 10px;
				padding-bottom: 10px;
			}
	table,tr,td{
		border: 1px solid black;
	}
			td{
				padding-top: 10px;
				padding-bottom: 10px;

			}

			.presentation-row{
				background-color: <?php echo $color ?>
			}
			table{
				text-align: center;
			}
			b{font-weight: bold}
		</style>
	</head>
	<body>
		<h3 class="text-center" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; "><img src="<?php echo $logo ?>" style="height:50px;font-family: sans-serif ;" alt="">FORMULÁRIO DE HORAS</h3>
		<div class="row">
				<div class="col-xs-6">
					<p><b>Tipo do formulário: <?php echo utf8_encode($type); ?></b></p>
				</div>
				
		</div>
		<div class="row  presentation-row">
			
				<div class="col-xs-6">
					<p><b>Empresa:</b> <?php echo $company ?></p>
					<p><b>Funcionário:</b> <?php echo $user ?></p>
					<p><b>Departamento:</b> <?php echo $department ?></p>
				</div>
				<div class="col-xs-6">
					<p><b>CNPJ:</b> <?php echo $cnpj ?></p>
					<p><b>Cargo:</b> <?php echo $title ?></p>
					<p><b>Superior imediato:</b> <?php echo $boss ?></p>
				</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
				<p><b>Detalhamento do motivo: </b><?php echo $motivation ?></p>
				<p><b>Previsão da data de execução de atividade fora do expediente: </b><?php echo $hourdate ?></p>
				<p><b>Assinatura do responsável pela autorização:</b>___________________________</p>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="padding: 0;">
			<table aligin="center" class="table">
				<thead>
				<tr style="background-color: <?php echo $color; ?>">
					<td><b>Data e dia da Semana</b></td>
					<td><b>Local</b></td>
					<td><b>Horas Adicionais</b></td>
					<td><b>Horas Convertidas</b></td>
					<td><b>Atividades Realizadas</b></td>
				</tr>
				</thead>
				<tbody>	
					<tr>
						<td><?php echo $hourdate ?></td>
						<td><?php echo $locale ?></td>
						<td><?php echo $hours ?></td>
						<td><?php echo $calchours ?></td>
						<td><?php echo $description ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<p><b>TOTAL DE HORAS:</b> <?php echo $calchours ?></p> 
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<p>De acordo, conforme proposto. Após a prestação do serviço e o horário para registro.</p>
				<p class="text-right">Em ____ de __________ de __________</p>
				<br><p class="text-center">________________________________________________</p>
				<p class="text-center">Assinatura do funcionário</p>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<p>Atesto a efetivação do serviço, como proposto e autorizado.</p>
				<p class="text-right">Em ____ de __________ de __________</p>
				<br><p class="text-center">________________________________________________</p>
				<p class="text-center">Assinatura do superior imediato</p>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<p class="text-right">Em ____ de __________ de __________</p>
				<br><p class="text-center">________________________________________________</p>
				<p class="text-center">Assinatura do responsável pelo RH</p>
			</div>
		</div>
		