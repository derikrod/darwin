<?php 

	/**
	 * 
	 */
	class calc extends model
	{
		//module
		public function loadCalcModule($idmodule,$iduser)
		{
			$calcmodule = "";
	
			if (!$this->check_modules($idmodule,$iduser)) {
				return $calcmodule;
			}else{
				$calcmodule = '
              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                  <div class="col-xs-12 mymodule">
                  <div class="row module-card" style="background-image:url(\''.BASE_URL.'/assets/images/calc.png\');background-position:bottom right;background-size:cover;">
                        
                  </div>
                  <div class="row">
                    
                    <div class="module-buttons">
                      <p><b>Calculadora de produtos</b></p>
                      <p>Calculadora de preço dos produto da equipe comercial.</p>
                      <p>&nbsp;</p>
                      <p class="text-right"><a href="#" id="showcalc" data-path="'.BASE_URL.'" class="btn btn-success">Calculadora</a>
                    </div>
                  </div>              
                  </div>
                </div>';

				return $calcmodule;
			}
		}

		public function getCalc()
		{
			$html ='<script type="text/javascript">


      function call_calc () {
         if ($.trim($("#price").val()) != "") {
             if ($.trim($("#factor").val()) != "") {
                 if ($.trim($("#charges").val()) != "") {
                     if ($.trim($("#currency").val()) != "") {
                      if ($("#iene_s").is(":checked") && $.trim($("#iene_currency").val()) == "") {
                        alert("Preencha corretamente o campo \"Valor do iene\" ");
                        $("#iene_currency").focus();
                      }else{
                      if ($("#ipi_s").is(":checked") && $.trim($("#ipi_value").val()) == "") {
                        alert("Preencha corretamente o campo \"Valor do IPI\" ");
                        $("#ipi_value").focus();
                        }else{
                          calc();
                        }
                      }
                     }else{
                        alert("Preencha corretamente o campo \"Valor da moeda corrente\" ");
                        $("#currency").focus();
                     }
                 }else{
                    alert("Preencha corretamente o campo \"Encargos Financeiros\"");
                    $("#charges").focus();
                 }
             }else{
                alert("Preencha corretamente o campo \"Fator\"");
                $("#factor").focus();
             }
         }else{
            alert("Preencha corretamente o campo \"Custo\"");
            $("#price").focus();
         }
      }
      function show_ipi(){
        if($("#ipi_s").is(":checked")){
          $("#ipi").fadeIn();
        }

        if($("#ipi_n").is(":checked")){
          $("#ipi").hide();
          $("#ipi_value").val("");
        }
      }

      function show_iene(){
        if($("#iene_s").is(":checked")){
          $("#iene_div").fadeIn();
        }

        if($("#iene_n").is(":checked")){
          $("#iene_div").hide();
          $("#iene_currency").val("");

        }
      }

      function calc () {
        
        var price = $("#price").val();
        var real_price = parseFloat(price.replace(",","."));
        var factor = $("#factor").val();
        var real_factor = parseFloat(factor.replace(",","."));
        var charges = $("#charges").val();
        var real_charges = parseFloat(charges.replace(",","."));
       
       if ($.trim($("#freight").val()) != "") {
          var freight = $("#freight").val();
          var real_freight = parseFloat(freight.replace(",","."));
        }else{
          var real_freight = 0;
        };

        
       
        var ipi = $("#ipi_value").val();
        var real_ipi = parseFloat(ipi.replace(",","."));
        var currency = $("#currency").val();
        var iene_currency = $("#iene_currency").val();
        var real_currency = parseFloat(currency.replace(",","."));
        


        if($("#ipi_n").is(":checked")){
          var ipi_percent = 1;
        }else{
          var ipi_percent = 1 + (real_ipi/100);  
        }
        
        var charges_percent = 1 + (real_charges/100);
        if ($("#iene_currency").val() == "") {
          var result = real_price * real_factor  * real_currency * charges_percent + real_freight ;
          var result = result*ipi_percent;
          var real_result = String(result.toFixed(2)).replace(".",",");
          $("#iene_result").html("");
        }else{
          var iene_currency = $("#iene_currency").val();
          iene_currency = parseFloat(iene_currency.replace(",","."));
          var result = real_price * real_factor  * iene_currency * charges_percent + real_freight ;
          var result = (result*ipi_percent).toFixed(2);
          var real_result = String(result).replace(".",",");
          var iene_freight = freight*iene_currency;
          var iene_result = real_price * real_factor * charges_percent + iene_freight;
          var iene_result = String(iene_result.toFixed(2)).replace(".",",");
          $("#iene_result").html("Valor em iene: ¥"+ iene_result);
        }
        
        //dolar
        var dolar_result = result/real_currency;
        var dolar_result = String(dolar_result.toFixed(2)).replace(".",",");
        $("#result").html("Valor em real: R$"+real_result);
        $("#dolar_result").html("Valor em dolar: US$"+dolar_result);
        


      }
    </script>
 
  	

  	<div class="row">
  		<div class="col-xs-12 col-sm-12  " style="padding-left:0;padding-right:0;">
  			<form>
  				 <div class="form-group">
    				<label for="price">Custo</label>
    				<input type="number" class="form-control" id="price"  placeholder="Custo do produto Ex: 1999,99">
  				</div>

  				 <div class="form-group">
    				<label for="factor">Fator</label>
    				<input type="number" class="form-control" id="factor"  placeholder="Fator do produto Ex: 9,9">
  				</div>
          <div class="form-group">
             <label>
              <input type="radio" name="ienevalue" id="iene_n" value="incluso" checked="checked" onclick="javascript:show_iene()">
              Valor em dólar
              </label>
              <label>
              <input type="radio" name="ienevalue" id="iene_s" value="n_incluso"  onclick="javascript:show_iene()">
              Valor em dólar e iene
              </label>
          </div>
          <div class="form-group">
              <label for="currency">Valor do dólar</label>
              <input type="number" class="form-control" id="currency"  placeholder="Valor da Moeda Ex: 1999,99">
          </div>
          <div class="form-group" id="iene_div" style="display:none;">
              <label for="iene_currency">Valor do iene</label>
              <input type="number" class="form-control" id="iene_currency"  placeholder="Valor da Moeda Ex: 1999,99">
          </div>
          <div class="form-group">
            <label for="charges">Encargos Financeiros(%)</label>
            <input type="number" class="form-control" id="charges"  placeholder="Encargos Financeiros Ex: 9,9">
          </div>
          <div class="form-group">
            <label for="freight">Frete (R$)</label>
            <input type="number" class="form-control" id="freight"  placeholder="Frete EX: 1999,99">
          </div>

  				 <div class="form-group">
    				 <label>
              <input type="radio" name="ipi" id="ipi_s" value="incluso" checked onclick="javascript:show_ipi()">
              IPI Incluso
              </label>
              <label>
              <input type="radio" name="ipi" id="ipi_n" value="n_incluso"  onclick="javascript:show_ipi()">
              IPI NÃO Incluso
              </label>
  				</div>
          <div id="ipi">
            <div class="form-group">
              <label for="charges">Valor do ipi(%)</label>
              <input type="number" class="form-control" id="ipi_value"  placeholder="Valor do ipi Ex: 10">
            </div>
          </div>
          

          <button type="button" class="btn btn-lg btn-success" onclick="javascript:call_calc();">CALCULAR</button>
          <br><br>
          <p><b>Resultado</b></p>
          <h2 id="result" style="color:green"></h2>
          <h2 id="dolar_result" style="color:red"></h2>
          <h2 id="iene_result" style="color:GoldenRod"></h2>
  			</form>	

        <br>
        
  	</div>
  	
   
   ';
			return $html;
		}
	}
 ?>