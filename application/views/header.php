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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis.min.js" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <link src="https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis.min.css" crossorigin="anonymous"></link>
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
              <a class="dropdown-item" href="/kanban/dashboard/dash1/343">Vanuza</a>
              
            </div>
          </li>
          <li class="nav-item" active>
            <a class="nav-link" target="_blank" rel="noopener noreferrer" href="http://suporte.solidabrasil.com.br/chamados/front/central.php">GLPI </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" id="navbarTotal" >
              <span class="badge badge-pill badge-warning"><?php echo (isset($qteChamados) ? $qteChamados: '0');?> </span>
              <a>
                <li>
                  
                </ul>
                <?php $this->load->view('busca_header', array());?>
              </div>
            </nav>
            <div id="visualization"></div>
            
          </div>