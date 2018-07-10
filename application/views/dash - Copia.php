<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="refresh" content="60">
    <title>Kanban GLPI</title>
    <link rel="stylesheet" href="/kanban/assets/dist/jkanban.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

    <style>
        body {
            font-family: "Lato";
            margin: 0;
            padding: 0;
        }

        #myKanban {
            overflow-x: auto;
            padding: 20px 0;
        }

        .success {
            background: #00B961;
        }

        .info {
            background: #2A92BF;
        }

        .warning {
            background: #F4CE46;
        }

        .error {
            background: #FB7D44;
        }
		.loader {
			border: 16px solid #f3f3f3; /* Light grey */
			border-top: 16px solid #3498db; /* Blue */
			border-radius: 50%;
			width: 120px;
			height: 120px;
			animation: spin 2s linear infinite;
			margin:auto;
			top:50%;
		}

		@keyframes spin {
			0% { transform: rotate(0deg); }
			100% { transform: rotate(360deg); }
		}
    </style>
</head>
<body>
<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#">Kanban GLPI</a>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
     <ul class="navbar-nav mr-auto">
      <li class="nav-item ">
        <a class="nav-link" href="/kanban/dashboard/dash1">Dash </a>
      </li>
      
	  <li class="nav-item" active>
        <a class="nav-link" href="/kanban/dashboard/dash2">Atribuir </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Outros
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/kanban/dashboard/dash1/7">André</a>
          <a class="dropdown-item" href="/kanban/dashboard/dash1/140">Fabio</a>
          <a class="dropdown-item" href="/kanban/dashboard/dash1/123">Giovani</a>
        </div>
      </li>
      
      
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
    </form>
  </div>
</nav>
<div id="myKanban"></div>

<div id="descChamado" class="modal "></div>

<div class="modal fade" id="closeTicket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Solucionar Ticket</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  method="POST" action="" >
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Id:</label>
            <input type="text" class="form-control" disabled id="idChamado" name="id" >
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Solução:</label>
            <textarea name="solution" class="form-control" id="message-text"></textarea>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="solve" class="btn btn-primary">Solucionar</button>
		</form>
      </div>
    </div>
  </div>
</div>

<script src="/kanban/assets/dist/jkanban.min.js"></script>
<script>
    var KanbanTest = new jKanban({
        element: '#myKanban',
        gutter: '10px',
        widthBoard: '450px',
        dropEl : function (el, target, source, sibling) {
			var elem_working = KanbanTest.getBoardElements('_working');
			var i = 0;
			var itens = [];
			for(i = 0; i< elem_working.length; i++){
				//console.log(elem[i].dataset.eid);
				itens[i] = elem_working[i].dataset.eid;
			}
			<?php echo $canUpdate;?> 
			/*$.ajax({
			   type: "POST",
			   data: {itens:itens},
			   url: "/kanban/dashboard/updateColumn/",
			   success: function(msg){
				
			   }
			});*/
			
			var elem_working = KanbanTest.getBoardElements('_done');
			if(elem_working.length > 0){
				var i = 0;
				var itens = [];
				for(i = 0; i< elem_working.length; i++){
					//console.log(elem[i].dataset.eid);
					$('#idChamado').val(elem_working[i].dataset.eid);
					$('#closeTicket').modal('show');
					itens[i] = elem_working[i].dataset.eid;
				}
			}
		}, 
		boards: [
            {
                "id": "_todo",
                "title": "To Do (Chamados ou tarefas novos)",
                "class": "info,good",
                "dragTo": ['_working'],
                "item": <?php echo $initialItemsNew;?> 
            },
            {
                "id": "_working",
                "title": "Trabalhando",
                "class": "warning",
                "item": <?php echo $initialItemsWkg;?> 
            },
            {
                "id": "_done",
                "title": "Feito",
                "class": "success",
                "dragTo": ['_working'],
                "item": []
            }
        ]
    });
</script>

</body>
<script>
function dataAtualFormatada(dd){
    var data = new Date(dd);
    var dia = data.getDate();
    if (dia.toString().length == 1)
      dia = "0"+dia;
    var mes = data.getMonth()+1;
    if (mes.toString().length == 1)
      mes = "0"+mes;
    var ano = data.getFullYear();  
    return dia+"/"+mes+"/"+ano;
}

$("#solve").on("click", function(data){
	$.ajax({
	  type: "POST",
	  url: "/kanban/dashboard/closeTicket/",
	  data: {id :$( "input[name='id']" ).val() , 
			solution : $( "textarea[name='solution']" ).val()},
	  success: function(msg){
				 location.reload();
			   },
	   beforeSend : function(){
		 $('#closeTicket').html('<div class="loader"></div>');  
	   }
	});
});

$(".kanban-item").dblclick( function(){
	$('#descChamado').html('<div class="loader"></div>');
	$.getJSON( "/kanban/dashboard/getTicketById/" + this.dataset.eid, function( data ) {
		//var dataSql = new Date();
		var html = '<div class="modal-dialog modal-lg" role="document">'+
					'<div class="modal-content">'+
					  '<div class="modal-header">'+
						'<h5 class="modal-title">Chamado <a href="http://suporte.solidabrasil.com.br/chamados/front/ticket.form.php?id='+data[0].id+' " target="_blank">#'+ data[0].id+'</a></h5>'+
						'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
						  '<span aria-hidden="true">&times;</span>'+
						'</button>'+
					  '</div>'+
					  '<div class="modal-body">'+
						'<table class="table">'+
						 ' <tr>'+
							'<th scope="row">Título</th>'+
							'<td id="TITULO">'+data[0].title+'</td>'+
							'<td></td>'+
							'<th scope="row">Data</th>'+
							'<td id="DATA">'+dataAtualFormatada(data[0].date)+'</td>'+
						  '</tr>'+
					'	  <tr>'+
					'		<th scope="row">Requerente</th>'+
					'		<td id="REQ" colspan="4">'+data[0].requerente+'</td>'+
					'		<td></td>'+
					'	  </tr>'+
					'	  <tr>'+
					'		<th scope="row">Descrição</th>'+
					'		<td id="DESC" colspan="4">'+data[0].content+'</td>'+
					'	'+
					'	  </tr>'+
					'	</table>'+
					'  </div>'+
					'  <div class="modal-footer">'+
					'	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
					'  </div>'+
					'</div>'+
				'</div>';
	  $('#descChamado').html(html);
	});
	$('#descChamado').modal('show');
});
</script>
</html>