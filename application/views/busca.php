<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="refresh" content="240">
    <title>Kanban GLPI</title>
    <link rel="stylesheet" href="/kanban/assets/dist/jkanban.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>
	<script src="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" crossorigin="anonymous"></script>
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
          
        </div>
      </li>
	  <li class="nav-item">
		 <a class="nav-link" href="#" id="navbarTotal" >
			<span class="badge badge-pill badge-warning"><?php echo (isset($qteChamados) ? $qteChamados: '0');?> </span>
		<a>
	  <li>
      
      
    </ul>
    <form action="/kanban/dashboard/search" method="POST" class="form my-2 my-lg-0 navbar-nav mr-left	">
      <div class="input-group">
		<input class="form-control" type="text" placeholder="" name="qry">
		<div id="dropDownFilter"  class="input-group-btn">
		<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		  Filtros
		</button>
		<div class="dropdown-menu dropdown-menu-right"> 
		 <div role="separator" class="dropdown-divider"></div>
		 <div class="form-check form-check dropdown-item">
		  <label class="form-check-label">
			<label class="custom-control custom-checkbox">
			  <input type="checkbox" class="custom-control-input" name="filter[]" value='title'>
			  <span class="custom-control-indicator"></span>
			  <span class="custom-control-description"> Título do Chamado</span>
			</label>
		  </label>
		</div>
		  <div role="separator" class="dropdown-divider"></div>
		  <div class="form-check form-check dropdown-item">
		  <label class="form-check-label">
			<label class="custom-control custom-checkbox">
			  <input type="checkbox" class="custom-control-input" name="filter[]" value='desc'>
			  <span class="custom-control-indicator"></span>
			  <span class="custom-control-description"> Descrição do Chamado
			</label>			  
		  </label>
		</div>
		<div role="separator" class="dropdown-divider"></div>
		 <div class="form-check form-check dropdown-item">
		  <label class="form-check-label">
			<label class="custom-control custom-checkbox">
			  <input type="checkbox" class="custom-control-input" name="filter[]" value='req'>
			  <span class="custom-control-indicator"></span>
			  <span class="custom-control-description"> Requerente do Chamado
			</label>			  
		  </label>
		</div>
		  <div role="separator" class="dropdown-divider"></div>
		  <div class="form-check form-check dropdown-item">
		  <label class="form-check-label">
			<label class="custom-control custom-checkbox">
			  <input type="checkbox" class="custom-control-input" name="filter[]" value='acom'>
			  <span class="custom-control-indicator"></span>
			  <span class="custom-control-description"> Acompanhamento do Chamado
			</label>			  
		  </label>
		</div>
		<div role="separator" class="dropdown-divider"></div>
		  <div class="form-check form-check dropdown-item">
		  <label class="form-check-label">
			<label class="custom-control custom-checkbox">
			  <input type="checkbox" class="custom-control-input" name="filter[]" value='id'>
			  <span class="custom-control-indicator"></span>
			  <span class="custom-control-description"> Id do Chamado
			</label>
		  </label>
		</div>
		<div role="separator" class="dropdown-divider"></div>
		</div>
      </div>
	  </div>
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
    </form>
  </div>
</nav>
<div id="myKanban">

</div>

<div id="descChamado" class="modal ">
	<div class="modal-dialog modal-lg " role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id='TITULOMODAL'></a></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			
			<div id="accordion" role="tablist" aria-multiselectable="true">
  <div class="card">
    <div class="card-header" role="tab" id="headingOne">
      <h5 class="mb-0">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
         Informações do chamado
        </a>
      </h5>
    </div>

    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
      <div class="card-block">
	  
	  
			<table class="table">
			  <tr>
				<th scope="row">Título</th>
				<td id="TITULO">'+data[0].title+'</td>
				<td></td>
				<th scope="row">Data</th>
				<td id="DATA">'+dataAtualFormatada(data[0].date)+'</td>
			  </tr>
			  <tr>
				<th scope="row">Requerente</th>
				<td id="REQ" colspan="4">'+data[0].requerente+'</td>
				<td></td>
			  </tr>
			  <tr>
				<th scope="row">Descrição</th>
				<td id="DESC" colspan="4">'+data[0].content+'</td>
			  </tr>
			</table>
</div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" role="tab" id="headingTwo">
      <h5 class="mb-0">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Acompanhamentos
        </a>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div id='acompanhamentos' class="card-block">
        NONE
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" role="tab" id="headingThree">
      <h5 class="mb-0">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Inserir Acompanhamento
        </a>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
      <div class="card-block">
        <div id="alertas"></div>		
		<form  method="POST" action="" >

			  <div class="form-group">
				<input type="text" class="form-control" hidden id="id_ac" name="id_ac" >
				<label for="message-text" class="col-form-label">Comentário:</label>
				<textarea name="comment_ac" class="form-control" id="message-text"></textarea>
			  </div>
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
			<button type="button" id="acompanhamento" class="btn btn-primary">Inserir</button>
			</form>
			
			
		  </div>
		</div>
	  </div>
	</div>			
				
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
		  </div>
		</div>
	</div>
</div>


<script src="/kanban/assets/dist/jkanban.min.js"></script>
<script>
    var KanbanTest = new jKanban({
        element: '#myKanban',
        gutter: '10px',
        widthBoard: '630px',
        dropEl : function (el, target, source, sibling) {
			var elem_working = KanbanTest.getBoardElements('_working');
			var i = 0;
			var itens = [];
			for(i = 0; i< elem_working.length; i++){
				
				itens[i] = elem_working[i].dataset.eid;
			}
			<?php echo $canUpdate;?> 
						
			var elem_working = KanbanTest.getBoardElements('_done');
			if(elem_working.length > 0){
				var i = 0;
				var itens = [];
				for(i = 0; i< elem_working.length; i++){
					
					$('#idChamado').val(elem_working[i].dataset.eid);
					$('#closeTicket').modal('show');
					itens[i] = elem_working[i].dataset.eid;
				}
			}
		}, 
		boards: [
            {
                "id": "_search",
                "title": "Resultado da busca",
                "class": "info,good",
                "dragTo": ['_working'],
                "item": <?php echo $initialItemsNew;?> 
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

$('#dropDownFilter .dropdown-menu').on({
	"click":function(e){
      e.stopPropagation();
    }
});

$("#acompanhamento").on("click", function(data){
	$('#alertas').html('<div class="loader"></div>'); 
	$("#acompanhamento").prop('disabled', true);
	$.ajax({
	  type: "POST",
	  url: "/kanban/dashboard/addComment/",
	  data: {id_ac :$( "input[name='id_ac']" ).val() ,	  
			comment_ac : $( "textarea[name='comment_ac']" ).val()},
	  success: function(msg){
				// location.reload();
				$('#alertas').html('<div id="alert_ok" class="alert alert-success" role="alert"><strong>Sucesso!</strong> Acompanhamento Inserido com sucesso :).</div>'); 				
			   },
	  error :  function(msg){
				 //location.reload();
				$('#alertas').html('<div id="alert_error" class="alert alert-danger" role="alert"><strong>Erro!</strong> Acompanhamento Inserido com erro, tente novamente :(.</div>');
			   },
	   beforeSend : function(){
		 //$('#acompanhamento').html('<div class="loader"></div>');  
	   }
			  
	});
});

$('#descChamado').on('hidden.bs.modal', function (e) {
	$('#alertas').html('');
	$("#acompanhamento").prop('disabled', false);
})

$(".kanban-item").dblclick( function(){
	$('#TITULOMODAL').html('Buscando Informações.... Aguarde!');
	$('#TITULO').html('');
	$('#DATA').html('');
	$('#REQ').html('');
	$('#DESC').html('<div class="loader"></div>');
	$.getJSON( "/kanban/dashboard/getTicketById/" + this.dataset.eid, function( data ) {
		//var dataSql = new Date();
		
		$('#TITULOMODAL').html('Chamado <a href="http://suporte.solidabrasil.com.br/chamados/front/ticket.form.php?id='+data[0].id+' " target="_blank">#'+ data[0].id+'</a>');
		$('#TITULO').html(data[0].title);
		$('#DATA').html(dataAtualFormatada(data[0].date));
		$('#REQ').html(data[0].requerente);
		$('#DESC').html(data[0].content);
		$( "input[name='id_ac']" ).val(data[0].id);
		$('#acompanhamentos').html(data['acomp']);
		
	});
	$('#descChamado').modal('show');
	
});
</script>
</html>