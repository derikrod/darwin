					
<?php 
class Calendar extends model
{
	private function ShowWeeks(){
		$semanas = "DSTQQSS";
	 	$diasDaSemana = "";
		for( $i = 0; $i < 7; $i++ ){
		 $diasDaSemana.= "<td width = '50' height = '50' align = \"center\" valign = \"center\" style=\"background-color:#16434B;color:white;border:1px solid #23282d;\">".$semanas{$i}."</td>";
		}

		return $diasDaSemana;
	 
	}
	 
	private function GetDayNumbers( $mes )
	{
		$numero_dias = array( 
				'01' => 31, '02' => 28, '03' => 31, '04' =>30, '05' => 31, '06' => 30,
				'07' => 31, '08' =>31, '09' => 30, '10' => 31, '11' => 30, '12' => 31
		);
	 
		if (((date('Y') % 4) == 0 and (date('Y') % 100)!=0) or (date('Y') % 400)==0)
		{
		    $numero_dias['02'] = 29;	// altera o numero de dias de fevereiro se o ano for bissexto
		}
	 
		return $numero_dias[$mes];
	}
	 
	private function getMounthName( $mes,$year )
	{
	     $meses = array( '01' => "Janeiro", '02' => "Fevereiro", '03' => "Março",
	                     '04' => "Abril",   '05' => "Maio",      '06' => "Junho",
	                     '07' => "Julho",   '08' => "Agosto",    '09' => "Setembro",
	                     '10' => "Outubro", '11' => "Novembro",  '12' => "Dezembro"
	                     );
	 
	      if( $mes >= 01 && $mes <= 12)
	        return $meses[$mes]." ".$year;
	 
	        return "Mês deconhecido";
	 
	}
	 private function getHolidays($ano){
      $dia = 86400;
      $datas = array();
      $datas['pascoa'] = easter_date($ano);
      $datas['sexta_santa'] = $datas['pascoa'] - (2 * $dia);
      $datas['carnaval'] = $datas['pascoa'] - (47 * $dia);
      $datas['corpus_cristi'] = $datas['pascoa'] + (60 * $dia);
      $feriados = array (
            'Ano novo' => $ano.'-01-01',
             'Anivesário de São Paulo' => $ano.'-01-25',//aniversário
              'Carnaval'=> $ano.'-'.date('m-d',$datas['carnaval']),
              'Sexta feira santa' =>   $ano.'-'.date('m-d',$datas['sexta_santa']),
                 'Páscoa' => $ano.'-'.date('m-d',$datas['pascoa']),
                  'Tiradentes' => $ano.'-04-21',
                  'Dia do trabalho' => $ano.'-05-01',
                  'Corpus Cristi' => $ano.'-'.date('m-d',$datas['corpus_cristi']),
                  'Revolução constitucionalista' => $ano.'-07-09',
                  'Independência do Brasil'=> $ano.'-09-07',
                  'Nossa senhora de aparecida' => $ano.'-10-12',
                  'Finados' => $ano.'-11-02',
                  'Proclamação da República' =>$ano.'-11-15',
                  'Dia da conciência negra' => $ano.'-11-20',
                  'Natal' =>$ano.'-12-25',
               );
      return $feriados;
   }

	 
   public function getMonths($month)
   {
   	$this -> query('SELECT * FROM months');
   	$select = '<select name="" id="sel_month" class="form-control" style="width:125px;" data-path="'.BASE_URL.'">';
   	foreach ($this-> result() as $key => $value) {
   		$selected = "";
   		if ($month == $value['id']) {
   			$selected = 'selected="selected"';
   		}
   		$select .= '<option value="'.str_pad($value['id'], 2,0,STR_PAD_LEFT).'" '.$selected.'>'.utf8_encode($value['txt_name']).'</option>';
   	}
   	$select .= '</select>';
   	return $select;
   }

   public function getYears($year)
   {
   	$this -> query('SELECT * FROM years');
   	$select = '<select name="" id="sel_year" class="form-control" style="width:125px;"  data-path="'.BASE_URL.'">';
   	foreach ($this-> result() as $key => $value) {
   		$selected = "";
   		if ($year == $value['txt_name']) {
   			$selected = 'selected="selected"';
   		}
   		$select .= '<option value="'.$value["txt_name"].'" '.$selected.'>'.utf8_encode($value['txt_name']).'</option>';

   	}
   	$select .= '</select>';
   	return $select;
   }
	public function ShowCalendars($mes,$year)
	{
	 
		$numero_dias = $this->GetDayNumbers( $mes );	// retorna o número de dias que tem o mês desejado
		$nome_mes = $this->getMounthName( $mes,$year );
		$diacorrente = 0;	
	 	$holyday = "";
	 	$holyday_name ="";
		$diasemana = jddayofweek( cal_to_jd(CAL_GREGORIAN, $mes,"01",$year) , 0 );	// função que descobre o dia da semana
	 
		$calendrio = "<style>
				.dia_comum{
					border:1px solid #23282d;
					padding:0;

				}

				.dia_comum:hover{
					background-color:#EEE;
					cur

				}
				.line{
					whidth:100%;
					padding-top:5px;
					padding-bottom:5px;
					padding-left:5px;
					padding-right:5px;
				}

				.day-line{
					background-color:#4388B0;
					color:white;
					border-bottom: 1px solid #23282d;
				}

				#dia_atual{
	
					border:1px solid #23282d;
					padding:0;
					background-color:#FFE;
				
				}
				#dia_atual:hover{
	
					border:1px solid #23282d;
					padding:0;
					background-color:#EEE;
				
				}



				#dia_atual>.day-line{
					background-color:#82BF6E;
				
				}

				.holyday{
					background-color: #F37C48;
				}
		</style>
				<div class=\"col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1\">
					<div class=\"module-div col-xs-12\">
						<h3 class=\"module-title text-center\">Agenda de Eventos</h3><br><table border = 0 cellspacing = '0' align = 'center'>";
		 $calendrio.= "<tr>";
	         $calendrio.= "<td colspan = 7><p><form class=\"form-inline\">".$this->getMonths($mes)." ".$this->getYears($year)."</form><p></td>";
		 $calendrio.= "</tr>";
		 $calendrio.= "<tr>";
		  $calendrio.= $this->ShowWeeks();	// função que mostra as semanas aqui
		 $calendrio.= "</tr>";
		for( $linha = 0; $linha < 6; $linha++ )
		{
	 
	 
		   $calendrio.= "<tr>";
	 
		   for( $coluna = 0; $coluna < 7; $coluna++ )
		   {
			$calendrio.= "<td width = '120' height = '120' ";
	 
			  if( ($diacorrente == ( date('d') - 1) && date('m') == $mes) )
			  {	
				   $calendrio.= " id = 'dia_atual' ";
			  }
			  else
			  {
				     if(($diacorrente + 1) <= $numero_dias )
				     {
				         if( $coluna < $diasemana && $linha == 0)
					 {
						$calendrio.= " class = 'dia_branco' ";
					 }
					 else
					 {
					  	$calendrio.= " class = 'dia_comum' ";
					 }
				     }
				     else
				     {
					$calendrio.= " ";
				     }
			  }
			$calendrio.= " align = \"left\" valign = \"top\" >";
	 
	 
			   /* TRECHO IMPORTANTE: A PARTIR DESTE TRECHO É MOSTRADO UM DIA DO CALENDÁRIO (MUITA ATENÇÃO NA HORA DA MANUTENÇÃO) */
	 
			      if( $diacorrente + 1 <= $numero_dias )
			      {
				 if( $coluna < $diasemana && $linha == 0)
				 {
				  	$calendrio.= " ";
				 }
				 else
				 {
				  	// echo "<input type = 'button' id = 'dia_comum' name = 'dia".($diacorrente+1)."'  value = '".++$diacorrente."' onclick = "acao(this.value)">";
					/*
						Pra cada dia checar
						Se existe 
					*/	$dia = ++$diacorrente;
						foreach ($this->getHolidays($year) as $key => $value) {
							
							if(strtotime($value) == strtotime($year."-".$mes."-".$dia)){
								$holyday ="holyday";
								$holyday_name = $key;
							} 
						}
					  $calendrio.= "<div class=\"line day-line ".$holyday."\" data-path=\"".BASE_URL."\" data-user=\"".$_COOKIE["intra_user"]."\" data-date=\"".$year."-".$mes."-".str_pad($dia, 2,0,STR_PAD_LEFT)."\">".$dia."</div>".$holyday_name;
					   $holyday = "";
					   $holyday_name = "";
				 }
			      }
			      else
			      {
				break;
			      }
	 
			   /* FIM DO TRECHO MUITO IMPORTANTE */
	 
	 
	 
			$calendrio.= "</td>";
		   }
		   $calendrio.= "</tr>";
		}
	 
		$calendrio.="</table>";

		return $calendrio;
	}
	 
	public function ShowCompleteCalendar()
	{
		    $calendrio.= "<table align = \"center\">";
		    $cont = 1;
		    for( $j = 0; $j < 4; $j++ )
		    {
			  $calendrio.= "<tr>";
			for( $i = 0; $i < 3; $i++ )
			{
			 
			  $calendrio.= "<td>";
			  $calendrio.=$this->ShowCalendars( ($cont < 10 ) ? "0".$cont : $cont );  
	 
        	  $cont++;
			  $calendrio.= "</td>";
	 
		 	}
			$calendrio.= "</tr>";
		   }
		   $calendrio.= "</table>";

		return $calendrio;
	}
	
}

?>