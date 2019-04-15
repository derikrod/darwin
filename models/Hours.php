<?php  
	Class Hours Extends Model{
		public function hoursTable()
		{
			return $this-> createForm('hours','Cadastrar');
		}

		public function getExtras($id)
		{
			$this -> query("SELECT * FROM users WHERE id =".$id);
			$extras = "";
			foreach ($this-> result() as $key => $value) {
				$extras = $value['hrs_hours'];
			}
		}

		public function listHours()
		{
			return $this-> createTable('hours',array('sel_users' => $_COOKIE['intra_user'])) ;
		}

		//auxiliares
		private function getCompany($id)
		{
			$this-> query('SELECT * FROM companies WHERE id ='.$id);
			return $this->result();
		}

		private function getDepartment($id)
		{
			$this-> query('SELECT * FROM departments WHERE id = '.$id);
			$department = "";
			foreach ($this-> result() as $key => $value) {
				$department = $value['txt_name'];
			}

			return $department;
		}

		private function getBoss($id)
		{
			$this-> query('SELECT * FROM users WHERE sel_departments = '.$id.' AND non_grant = 1');
			$boss = "";
			foreach ($this-> result() as $key => $value) {
				$boss = $value['txt_name'];
			}
			return $boss;
		}
		//auxiliares
		public function hourForm($id)
		{
			# code...
			$this-> query('SELECT * FROM users WHERE id ='.$id;)
			foreach ($this-> result() as $key => $value) {
				$form = '	
					<style type="text/css">
						.row{
							margin-right: 0;
							margin-left: 0;
							margin-top: 10px;
							margin-bottom: 10px;
						}
						th{
							text-align: center;
							background-color: rgb(225,180,180);
						}

						.presentation-row{
							background-color: rgb(225,180,180);
						}
					</style>
					<h3 class="text-center">TABELA DE HORAS</h3>
					<div class="row">
							<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xs-offset-1">
								<p><b>BANCO DE HORAS </b></p>
							</div>
							<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
								<p><b>COMPENSAÇÃO DE HORAS</b></p>
							</div>
					</div>
					<div class="row ">
						
							<div class="col-xs-5 col-xs-offset-1 presentation-row">
								<p>Empresa: {EMPRESA}</p>
								<p>Funcionário: '.$value['txt_name'].'</p>
								<p>Departamento: '.$this-> getDepartment($value['sel_departments'])'</p>
							</div>
							<div class="col-xs-5 presentation-row">
								<p>CNPJ: '.$this->getCompany($value['sel_companies'])['txt_name'].'</p>
								<p>Cargo: '.$value['txt_title'].'</p>
								<p>Superior imediato: '.$this-> getBoss($value['sel_departments']).'</p>
							</div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xs-offset-1">
							<p><b>Detalhamento do motivo:</b>{MOTIVO}</p>
							<p><b>Previsão da data de execução de atividade fora do expediente:</b>{DATA}</p>
							<p>Assinatura do responsável pela <b>autorização:</b>___________________________</p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xs-offset-1">
						<table class="table">
							<thead>
								<th>Data e dia da Semana</th>
								<th>Local</th>
								<th>Horas Adicionais</th>
								<th>Horas Convertidas</th>
								<th>Atividades Realizadas</th>
							</thead>
							<tbody>
								<tr>
									<td>{DATA E DIA}</td>
									<td>{LOCAL}</td>
									<td>{HORAS ADICIONAIS}</td>
									<td>{HORAS CONVERTIDAS}</td>
									<td>{ATIVIDADES REALIZADAS}</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="row">
						<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xs-offset-1">
							<p><b>TOTAL DE HORAS:</b> {TOTAL EM HORAS}</p> 
						</div>
						<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
							<p><b>TOTAL EM DIAS:</b> {TOTAL EM DIAS}</p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xs-offset-1">
							<p>De acordo, conforme proposto. Após a prestação do serviço e o horário para registro.</p>
							<p class="text-right">EM __ de ____ de __________</p>
							<p class="text-center">________________________________________________</p>
							<p class="text-center">Assinatura do funcionário</p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xs-offset-1">
							<p>Atesto a efetivação do serviço, como proposto e autorizado.</p>
							<p class="text-right">EM __ de ____ de __________</p>
							<p class="text-center">________________________________________________</p>
							<p class="text-center">Assinatura do funcionário</p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xs-offset-1">
							<p class="text-right">EM __ de ____ de __________</p>
							<p class="text-center">________________________________________________</p>
							<p class="text-center">Assinatura do funcionário</p>
						</div>
					</div>
					';


					return $form;
			}
		}

		public function loadUserHoursModule($iduser,$idmodule)
		{
			# code...
		}

		public function loadAdminHoursModule($iduser,$idmodule)
		{
			# code...
		}
	}

?>