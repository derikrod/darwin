<?php 
	$path = "segundou_connect/";
$diretorio = dir($path);
$gallery ="";
while($arquivo = $diretorio -> read()){
	if (substr($arquivo, -4) == '.jpg' || substr($arquivo, -4) == '.JPG' || substr($arquivo, -5) == '.JPEG') {
		$gallery.= '<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="padding:5px;">
						<div class="col-xs-12 modal-image" style="height:250px;padding:0; background-image:url(\''.$path.$arquivo.'\');background-size:cover;" data-type="image" data-image="'.$path.$arquivo.'" >
						<div class="image-caption"></div>
						</div>
					</div>';
	}elseif (substr($arquivo, -4) == '.mp4') {
		$gallery.='<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="padding:5px;">
						<div class="col-xs-12 modal-image" style="height:250px;padding:0; background-color:black;" data-type="video" data-image="'.$path.$arquivo.'" >
							<div class="image-caption text-center"><video style="width:100%;">
							  <source src="'.$path.$arquivo.'" type="video/mp4">
							Your browser does not support the video tag.
							</video><div style="width:100%;height:64px;background-color:black">
								<br><span class="glyphicon glyphicon-play" aria-hidden="true" style="fontsize:20px;color:white;"></span>					
							</div>
						</div>
					</div></div>';
	}
}
$diretorio -> close();

 ?><!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Album de fotos</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<style>
			.image-caption{
				position: relative;
				width: 100%;
				height: 100%;
				transition: all 0.2s;
				cursor:zoom-in;
			}
			.modal-image:hover .image-caption{
				background-color: rgba(0,0,0,0.5);
			}

			

			.row{
				margin-left: 0;
				margin-right: 0;
			}
			.loading{
				position: fixed;
				width: 100%;
				height: 100%;
				background-color: rgba(0,0,0,0.5);
				color:white;
			}
		</style>
	</head>
	<body>
		
		<div id="mymodal"class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-xl">
		    <div class="modal-content">
		      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        ...
      </div>
		    </div>
		  </div>
		</div>
		<h1 class="text-center">Galeria de fotos</h1>
	
			<p><a href="index.php"><img src="images/botao-voltar.png" alt="voltar" style="width: 100px;"></a></p>
		</div>
		<div class="row">
			<?php echo $gallery; ?>
		</div>
		<!-- jQuery -->
		<script src="https://code.jquery.com/jquery.js"></script>
		<script type="text/javascript">
			$(function() {
				// body...
				$(".modal-image").click(function() {
					if($(this).data('type')== 'image'){
						$(".modal-body").html("<a href='"+$(this).data('image')+"' download>Clique aqui para fazer download <span class='glyphicon glyphicon-download' aria-hidden='true'></span></a><img src='"+$(this).data('image')+"' style='width:100%;'>");
					}else{
						$(".modal-body").html("<a href='"+$(this).data('image')+"' download>Clique aqui para fazer download <span class='glyphicon glyphicon-download' aria-hidden='true'></span></a><br><video  controls  style=\"width:100%;\"><source src=\""+$(this).data('image')+"\" type=\"video/mp4\">Your browser does not support the video tag.</video>");
					}
					$('#mymodal').modal('show');
				});

				
			})
		</script>

		<!-- Bootstrap JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	</body>
</html>