<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script src="https://api.trello.com/1/client.js?key=9867ade09cb0213da53c972990e65f07"></script>
<script type="text/javascript">
	var authenticationSuccess = function() {
  console.log('Successful authentication');
  function mostrarProps(obj, nomeDoObj) {
	  var resultado = "";
	  for (var i in obj) {
	    if (obj.hasOwnProperty(i)) {
	        resultado += nomeDoObj + "." + i + " = " + obj[i] + "\n";
	    }
	  }
	  return resultado;
}
window.Trello.rest('GET', 	'/members/me/boards', function (data) {
	// body...
	for(var i in data){
		if (data[i].closed === false) {
			$('#trello_contents').append('<blockquote class="trello-board-compact col-xs-6"><a href="'+data[i].url+'">Trello Board</a></blockquote>&nbsp;&nbsp;');
			$('#trello_contents').append('<script src="https://p.trellocdn.com/embed.min.js">');
		}
			
	}
	

}, function () {
	// body...
	console.log('error');
});

};

var authenticationFailure = function() {
  console.log('Failed authentication');
};
$(function () {
	$("#authorize").click(function() {
		$("#authorize").hide('fast');
		/* Act on the event */
		Trello.authorize({
		  type: 'popup',
		  name: 'Intranet',
		  scope: {
		    read: 'true',
		    write: 'true' },
		  expiration: 'never',
		  success: authenticationSuccess,
		  error: authenticationFailure
		});
	}); 
})



</script>

<div id="trello_contents"><button id="authorize" class="btn btn-success" data-have="false">CARREGAR QUADROS DE ATIVIDADE</button></div>