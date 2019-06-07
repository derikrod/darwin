
<body class="main-body">
<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="mymodal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="mymodallabel"></h3>
        
      </div>
      <div class="modal-body">
        ...
      </div>
    </div>
  </div>
</div>
	<nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo BASE_URL?>">Intranet</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
           
          </ul>
          <ul class="nav navbar-nav navbar-right">
          	 
             <p class="navbar-text"> <a href="<?php echo BASE_URL ?>" style="color:white;"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Página principal</a> | <span class="glyphicon glyphicon-user" aria-hidden="true"></span> <b><?php echo $name?> | <a href="#" id="logout_btn" data-path= "<?php echo BASE_URL?>"><span class="glyphicon glyphicon-off" aria-hidden="true" title="Sair"></span> Sair</a></b> </p> 
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="row">
    	<?php
    		 if (isset($trellomodule)) {
          echo($trellomodule);       
        }
        if (isset($usermodule)) {
    			echo($usermodule);    		
    		}
        if (isset($eventmodule)) {
          echo($eventmodule);       
        }
         if (isset($bhmodule)) {
          echo($bhmodule);       
        }
         if (isset($bhadmmodule)) {
          echo($bhadmmodule);       
        }
         if (isset($calcmodule)) {
          echo($calcmodule);       
        }

       

         if (isset($contactmodule)) {
          echo($contactmodule);       
        }

          if (isset($callsmodule)) {
          echo($callsmodule);       
        }
          if (isset($admincallsmodule)) {
          echo($admincallsmodule);       
        }
          if (isset($birthdaymodule)) {
          echo($birthdaymodule);       
        }
    	?>
    </div>
		
</body>