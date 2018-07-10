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

        .danger {
            background: #FF6347;
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
          <a class="dropdown-item" href="/kanban/dashboard/dash1/343">Vanuza</a>
         
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
  </div>
</nav>
<div id="myKanban">

</div>

<div class="container">
	<h1>Cadastro de usuário</h1>
	<form>
	  <ul class="nav nav-tabs" id="myTab" role="tablist">
	  <li class="nav-item">
	    <a class="nav-link active" id="geral-tab" data-toggle="tab" href="#geral" role="tab" aria-controls="geral" aria-selected="true">Geral</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" id="ad-tab" data-toggle="tab" href="#ad" role="tab" aria-controls="ad" aria-selected="false">Active Directory</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" id="protheus-tab" data-toggle="tab" href="#protheus" role="tab" aria-controls="protheus" aria-selected="false">Protheus</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" id="spm-tab" data-toggle="tab" href="#spm" role="tab" aria-controls="spm" aria-selected="false">SPM</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" id="engeman-tab" data-toggle="tab" href="#engeman" role="tab" aria-controls="engeman" aria-selected="false">Engeman</a>
	  </li>
	</ul>
	<div class="tab-content" id="myTabContent">
	  <div class="tab-pane fade show active" id="geral" role="tabpanel" aria-labelledby="geral-tab">
	  	 <div class="form-group row">
		    <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
		    <div class="col-sm-10">
		      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="email@example.com">
		    </div>
		  </div>
		  <div class="form-group row">
		    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
		    <div class="col-sm-10">
		      <input type="password" class="form-control" id="inputPassword" placeholder="Password">
		    </div>
		  </div>
	  </div>
	  <div class="tab-pane fade" id="ad" role="tabpanel" aria-labelledby="ad-tab">
	  	
	  </div>
	  <div class="tab-pane fade" id="protheus" role="tabpanel" aria-labelledby="protheus-tab">
	  	
	  </div>
	  <div class="tab-pane fade" id="spm" role="tabpanel" aria-labelledby="spm-tab">
	  	
	  </div>
	  <div class="tab-pane fade" id="engeman" role="tabpanel" aria-labelledby="engeman-tab">
	  	
	  </div>
	</div>
</form>
</div>

</html>