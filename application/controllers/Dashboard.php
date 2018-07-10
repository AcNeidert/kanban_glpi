	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	private $func;
	private $box;
	private $dragTo;
	
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('table');
		$this->load->helper('url');
		$this->load->database();
		$this->load->helper('client');
		$this->load->helper('clientws');
		$this->func = '';
		$this->box  = '';
		$this->dragTo = '';
		$this->users = $this->getUsers();
		
		if (!$this->session->userdata('isLogged'))
			redirect('/login', 'refresh');
	}
	public function index()
	{
		redirect('/dashboard/dash1/', 'refresh');
										
	}
	public function dash1($user = null){
		$this->load->view('dash', array('initialItemsNew' => $this->getTicketsNew(true, $user),
										'initialItemsWkg' => $this->getTicketWorking(true, $user),
										'initialItemsTodo' => $this->getTicketTodo(true, $user),
										'canUpdate'       => Array(($user == null ? '$.ajax({
																				   type: "POST",
																				   data: {
																				   		itens:itens,
																				   		elem_working:\'_working\'
																				   },
																				   url: "/kanban/dashboard/updateColumn/",
																				   success: function(msg){
																					
																				   }
																				});' : ''),
																	($user == null ? '$.ajax({
																				   type: "POST",
																				   data: {
																				   		itens:itens,
																				   		elem_working:\'_todo\'
																				   },
																				   url: "/kanban/dashboard/updateColumn/",
																				   success: function(msg){
																					
																				   }
																				});' : '')
									)));
	}
	
	public function dash2()
	{
		//$ret = $this->createBoxUser('123', 'Giovani', '_giovani');
		for($i = 0 ; $i < count($this->users); $i++){
			;
			$this->createBoxUser($this->users[$i]->id, $this->users[$i]->nome  , '_'.strtolower($this->users[$i]->nome));
		}
				
		$this->load->view('dash2', array('initialItemsNew' => $this->getTicketsNewOpen(true),
										 'function'        => $this->func,
										 'box'             => $this->box,
										 'dragTo'          => $this->dragTo));
	}

	public function dash3()
	{
		//$ret = $this->createBoxUser('123', 'Giovani', '_giovani');
		for($i = 0 ; $i < count($this->users); $i++){
			;
			$this->createBoxUser($this->users[$i]->id, $this->users[$i]->nome  , '_'.strtolower($this->users[$i]->nome));
		}
		
		$this->load->view('dash3', array('initialItemsNew' => $this->getTicketsNewOpen(true),
										 'function'        => $this->func,
										 'box'             => $this->box,
										 'dragTo'          => $this->dragTo));
	}
	
	public function search($query = null){
		$query = $this->input->post("qry");
		$filter = $this->input->post("filter");
		$this->load->view('busca', array('initialItemsNew' => $this->getTicketsQuery(true, $query, $filter),
										'canUpdate'       => ( '')));
	}
	
	public function getTicketsQuery($isForHtml = false, $qry, $filter = null){
		$isTitle = ( $filter == null ? true : in_array("title", $filter));
		$isDesc  = ( $filter == null ? true : in_array("desc" , $filter));
		$isReq   = ( $filter == null ? true : in_array("req", $filter));
		$isAcomp = ( $filter == null ? true : in_array("acom", $filter));
		$isId    = ( $filter == null ? true : in_array("id", $filter));
		
		$query = $this->db->query("SELECT 
									   glpi_tickets.id                  AS id, 
									   CONCAT( glpi_tickets.name, \"   \", \"<span class='badge badge-pill badge-primary'>\", 
												user_requerente.name, \"</span>\", \"<span class='badge badge-pill badge-danger'>\", 
												DATE_FORMAT(glpi_tickets.date,'%d/%m/%Y'), \"</span>\")                AS title
									  
									FROM   glpi_tickets 
									LEFT JOIN glpi_itilcategories ON ( 
										glpi_tickets.itilcategories_id = glpi_itilcategories.id 
									) LEFT JOIN glpi_tickets_users AS ticket_user_requerente ON ( 
										glpi_tickets.id = ticket_user_requerente.tickets_id AND 
										ticket_user_requerente.type = 1 
									) LEFT JOIN glpi_users AS user_requerente ON ( 
										ticket_user_requerente.users_id = user_requerente.id 
									) LEFT JOIN glpi_tickets_users AS ticket_user_tecnico ON ( 
										glpi_tickets.id = ticket_user_tecnico.tickets_id AND 
										ticket_user_tecnico.type = 2 
									) LEFT JOIN glpi_users AS user_tecnico ON ( 
										ticket_user_tecnico.users_id =user_tecnico.id 
									) left Join glpi_ticketfollowups fllwup on (
										fllwup.tickets_id = glpi_tickets.id
									)   
								
								WHERE  glpi_tickets.is_deleted = '0' 									 
											 AND glpi_tickets.status IN ( '1', '2', '3', '15', 
																			  '16', '17', '18', '19', 
																			  '13', '4', '14' ) 
											AND(
													".( $isTitle ? "glpi_tickets.name         like '%{$qry}%' ".(($isDesc OR $isReq OR $isAcomp OR $isId) ?  "OR " : "") : "") ."
													".( $isDesc  ? "glpi_tickets.content      like '%{$qry}%' ".((           $isReq OR $isAcomp OR $isId) ?  "OR " : "") : "") ."
													".( $isReq   ? "user_requerente.name      like '%{$qry}%' OR 
																	user_requerente.firstname like '%{$qry}%' OR 
																	user_requerente.realname  like '%{$qry}%' ".((                     $isAcomp OR $isId) ?  "OR " : "") : "") ."								 
													".( $isAcomp ? "fllwup.content            like '%{$qry}%' ".((                                 $isId) ?  "OR " : "") : "") ."
													".( $isId    ? "glpi_tickets.id               = '{$qry}' " : "") ."
											)
										
								GROUP  BY 
								 
									   glpi_tickets.id                
									   ,glpi_tickets.name  
									   ,user_requerente.name									   
									   ,glpi_tickets.content              
									   ,glpi_tickets.status               
									   ,glpi_itilcategories.completename  
									   ,glpi_tickets.status              
									   ,glpi_tickets.date_mod             
									   ,glpi_tickets.date            
									   ,glpi_tickets.priority");
		
		if(!$isForHtml){
			header('Content-Type: application/json');
			echo json_encode($query->result() );
		}
		return json_encode($query->result());
	}
	
	public function getTicketsNew($isForHtml = false, $user = null)
	{
		$userQuery = ($user == Null ? $this->session->userdata('glpiID') : $user);
		$query = $this->db->query("SELECT 
									   glpi_tickets.id                  AS id, 
									   CONCAT( glpi_tickets.name, \"   \", \"<span class='badge badge-pill badge-default'>\", 
												user_requerente.name, \"</span>\", \"<span class='badge badge-pill badge-danger'>\", 
												DATE_FORMAT(glpi_tickets.date,'%d/%m/%Y'), \"</span>\")                AS title
									  
									FROM   glpi_tickets 
									LEFT JOIN glpi_itilcategories ON ( 
										glpi_tickets.itilcategories_id = glpi_itilcategories.id 
									) LEFT JOIN glpi_tickets_users AS ticket_user_requerente ON ( 
										glpi_tickets.id = ticket_user_requerente.tickets_id AND 
										ticket_user_requerente.type = 1 
									) LEFT JOIN glpi_users AS user_requerente ON ( 
										ticket_user_requerente.users_id = user_requerente.id 
									) LEFT JOIN glpi_tickets_users AS ticket_user_tecnico ON ( 
										glpi_tickets.id = ticket_user_tecnico.tickets_id AND 
										ticket_user_tecnico.type = 2 
									) LEFT JOIN glpi_users AS user_tecnico ON ( 
										ticket_user_tecnico.users_id =user_tecnico.id 
									) 
								WHERE  glpi_tickets.is_deleted = '0' 
									   AND ( ( user_tecnico.id = '{$userQuery}' ) 
											 AND glpi_tickets.status IN ( '1', '2', '3', '15', 
																			  '16', '17', '18', '19', 
																			  '13', '4', '14' ) ) 
										AND glpi_tickets.id not in( Select idTicket from glpi_plugin_kanban where idUser = '{$userQuery}')
								GROUP  BY 
								 
									   glpi_tickets.id                
									   ,glpi_tickets.name 
										,user_requerente.name									   
									   ,glpi_tickets.content              
									   ,glpi_tickets.status               
									   ,glpi_itilcategories.completename  
									   ,glpi_tickets.status              
									   ,glpi_tickets.date_mod             
									   ,glpi_tickets.date            
									   ,glpi_tickets.priority");
		
		if(!$isForHtml){
			header('Content-Type: application/json');
			echo json_encode($query->result() );
		}
		return json_encode($query->result());
	}
	
	public function getTicketsNewOpen($isForHtml = false)
	{
		$query = $this->db->query("SELECT 
									   glpi_tickets.id                  AS id, 
									   CONCAT( glpi_tickets.name, \"   \", \"<span class='badge badge-pill badge-default'>\", 
												user_requerente.name, \"</span>\", \"<span class='badge badge-pill badge-danger'>\", 
												DATE_FORMAT(glpi_tickets.date,'%d/%m/%Y'), \"</span>\" )                AS title
									  
									FROM   glpi_tickets 
									LEFT JOIN glpi_itilcategories ON ( 
										glpi_tickets.itilcategories_id = glpi_itilcategories.id 
									) LEFT JOIN glpi_tickets_users AS ticket_user_requerente ON ( 
										glpi_tickets.id = ticket_user_requerente.tickets_id AND 
										ticket_user_requerente.type = 1 
									) LEFT JOIN glpi_users AS user_requerente ON ( 
										ticket_user_requerente.users_id = user_requerente.id 
									) 
								WHERE  glpi_tickets.is_deleted = '0' 
									   AND ( glpi_tickets.status IN ( '1' ) ) 
										AND glpi_tickets.id not in( Select idTicket from glpi_plugin_kanban where idUser = '{$this->session->userdata('glpiID')}')
								GROUP  BY 
								 
									   glpi_tickets.id                
									   ,glpi_tickets.name
										,user_requerente.name
									   ,glpi_tickets.content              
									   ,glpi_tickets.status               
									   ,glpi_itilcategories.completename  
									   ,glpi_tickets.status              
									   ,glpi_tickets.date_mod             
									   ,glpi_tickets.date            
									   ,glpi_tickets.priority");
		
		if(!$isForHtml){
			header('Content-Type: application/json');
			echo json_encode($query->result() );
		}
		return json_encode($query->result());
	}
	private function mostrarAcompanhamento($id){
		$query = $this->db->query("Select 
									DATE_FORMAT(glpi_ticketfollowups.date, '%d/%m/%Y') as Data, 
									concat(firstname , ' ', realname) as Nome,
								REPLACE(content, '\n', '<br>') as Acompanhamento
								from glpi_ticketfollowups 
								inner join glpi_users on (
										glpi_users.id = glpi_ticketfollowups.users_id
								)   
								where tickets_id= {$id}
								order by glpi_ticketfollowups.date desc");
		
		$template = array(
        'table_open'  => '<table class="table">'
		);
		$this->table->set_template($template);
		return $this->table->generate($query);	
	}
	
	public function getTicketWorking($isForHtml = false, $user = null)
	{
		$userQuery = ($user == Null ? $this->session->userdata('glpiID') : $user);
		$query = $this->db->query("SELECT 
									   glpi_tickets.id                  AS id, 
									   CONCAT( glpi_tickets.name, \"   \", \"<span class='badge badge-pill badge-default'>\", 
												user_requerente.name, \"</span>\", \"<span class='badge badge-pill badge-danger'>\", 
												DATE_FORMAT(glpi_tickets.date,'%d/%m/%Y'), \"</span>\")                AS title
									  
									FROM   glpi_tickets 
									LEFT JOIN glpi_itilcategories ON ( 
										glpi_tickets.itilcategories_id = glpi_itilcategories.id 
									) LEFT JOIN glpi_tickets_users AS ticket_user_requerente ON ( 
										glpi_tickets.id = ticket_user_requerente.tickets_id AND 
										ticket_user_requerente.type = 1 
									) LEFT JOIN glpi_users AS user_requerente ON ( 
										ticket_user_requerente.users_id = user_requerente.id 
									) LEFT JOIN glpi_tickets_users AS ticket_user_tecnico ON ( 
										glpi_tickets.id = ticket_user_tecnico.tickets_id AND 
										ticket_user_tecnico.type = 2 
									) LEFT JOIN glpi_users AS user_tecnico ON ( 
										ticket_user_tecnico.users_id =user_tecnico.id 
									) Right Join glpi_plugin_kanban ON(
										idUser = user_tecnico.id AND
										idTicket = glpi_tickets.id
									) 
								WHERE  glpi_tickets.is_deleted = '0' 
									   AND ( ( user_tecnico.id = '{$userQuery}' ) 
											 AND glpi_tickets.status IN ( '1', '2', '3', '15', 
																			  '16', '17', '18', '19', 
																			  '13', '4', '14' ) ) 
										AND glpi_plugin_kanban.coluna = '_working'
								GROUP  BY 
								 
									   glpi_tickets.id                
									   ,glpi_tickets.name 
										,user_requerente.name
									   ,glpi_tickets.content              
									   ,glpi_tickets.status               
									   ,glpi_itilcategories.completename  
									   ,glpi_tickets.status              
									   ,glpi_tickets.date_mod             
									   ,glpi_tickets.date            
									   ,glpi_tickets.priority
								Order by 
									glpi_plugin_kanban.priority");//TODO : ordenar por priority
		
		if(!$isForHtml){
			header('Content-Type: application/json');
			echo json_encode($query->result() );
		}
		return json_encode($query->result());
	}
	
	public function getTicketTodo($isForHtml = false, $user = null)
	{
		$userQuery = ($user == Null ? $this->session->userdata('glpiID') : $user);
		$query = $this->db->query("SELECT 
									   glpi_tickets.id                  AS id, 
									   CONCAT( glpi_tickets.name, \"   \", \"<span class='badge badge-pill badge-default'>\", 
												user_requerente.name, \"</span>\", \"<span class='badge badge-pill badge-danger'>\", 
												DATE_FORMAT(glpi_tickets.date,'%d/%m/%Y'), \"</span>\")                AS title
									  
									FROM   glpi_tickets 
									LEFT JOIN glpi_itilcategories ON ( 
										glpi_tickets.itilcategories_id = glpi_itilcategories.id 
									) LEFT JOIN glpi_tickets_users AS ticket_user_requerente ON ( 
										glpi_tickets.id = ticket_user_requerente.tickets_id AND 
										ticket_user_requerente.type = 1 
									) LEFT JOIN glpi_users AS user_requerente ON ( 
										ticket_user_requerente.users_id = user_requerente.id 
									) LEFT JOIN glpi_tickets_users AS ticket_user_tecnico ON ( 
										glpi_tickets.id = ticket_user_tecnico.tickets_id AND 
										ticket_user_tecnico.type = 2 
									) LEFT JOIN glpi_users AS user_tecnico ON ( 
										ticket_user_tecnico.users_id =user_tecnico.id 
									) Right Join glpi_plugin_kanban ON(
										idUser = user_tecnico.id AND
										idTicket = glpi_tickets.id
									) 
								WHERE  glpi_tickets.is_deleted = '0' 
									   AND ( ( user_tecnico.id = '{$userQuery}' ) 
											 AND glpi_tickets.status IN ( '1', '2', '3', '15', 
																			  '16', '17', '18', '19', 
																			  '13', '4', '14' ) ) 
									AND glpi_plugin_kanban.coluna = '_todo'	
								GROUP  BY 
								 
									   glpi_tickets.id                
									   ,glpi_tickets.name 
										,user_requerente.name
									   ,glpi_tickets.content              
									   ,glpi_tickets.status               
									   ,glpi_itilcategories.completename  
									   ,glpi_tickets.status              
									   ,glpi_tickets.date_mod             
									   ,glpi_tickets.date            
									   ,glpi_tickets.priority
								Order by 
									glpi_plugin_kanban.priority");//TODO : ordenar por priority
		
		if(!$isForHtml){
			header('Content-Type: application/json');
			echo json_encode($query->result() );
		}
		return json_encode($query->result());
	}

	public function getTicketById($id)
	{
		$query = $this->db->query("SELECT 
									   glpi_tickets.id                  AS id, 
									   glpi_tickets.name                AS title,
									   glpi_tickets.date_creation       AS date,
									   Concat(
											user_requerente.firstname, ' ',
											user_requerente.realname)   AS requerente,
									   REPLACE(glpi_tickets.content, '\n', '<br>')             AS content
									  
									FROM   glpi_tickets 
									LEFT JOIN glpi_itilcategories ON ( 
										glpi_tickets.itilcategories_id = glpi_itilcategories.id 
									) LEFT JOIN glpi_tickets_users AS ticket_user_requerente ON ( 
										glpi_tickets.id = ticket_user_requerente.tickets_id AND 
										ticket_user_requerente.type = 1 
									) LEFT JOIN glpi_users AS user_requerente ON ( 
										ticket_user_requerente.users_id = user_requerente.id 
									) LEFT JOIN glpi_tickets_users AS ticket_user_tecnico ON ( 
										glpi_tickets.id = ticket_user_tecnico.tickets_id AND 
										ticket_user_tecnico.type = 2 
									) LEFT JOIN glpi_users AS user_tecnico ON ( 
										ticket_user_tecnico.users_id =user_tecnico.id 
									) 
								WHERE  glpi_tickets.is_deleted = '0' 
										AND glpi_tickets.id in({$id})
								GROUP  BY 
								 
									   glpi_tickets.id                
									   ,glpi_tickets.name               
									   ,glpi_tickets.content              
									   ,glpi_tickets.status               
									   ,glpi_itilcategories.completename  
									   ,glpi_tickets.status              
									   ,glpi_tickets.date_mod             
									   ,glpi_tickets.date_creation 
									   ,user_requerente.firstname
									   ,user_requerente.realname									   
									   ,glpi_tickets.priority");
		
		$arr = $query->result();
		$arr['acomp'] = $this->mostrarAcompanhamento($id);
		header('Content-Type: application/html');
		echo json_encode($arr);
		//echo json_encode($this->session->userdata('user') );
	}
	

	public function updateColumn(){
		$itens = $this->input->post('itens');
		$elem_working = $this->input->post('elem_working');
		$elementos = '';
		$qryInsere = '';
		if($elem_working == '_working'){
			for($i = 0; $i < count($itens); $i++){
				$elementos .= ($i == 0 ? '': ', '). $this->db->escape($itens[$i]);
			}
			$qryFinaliza = 'Update glpi_plugin_kanban_tempo set dtFim = now() where';
			$qryFinaliza .= ($elementos == '' ? '' : 'idChamado not in ('.$elementos.') and') . ' dtFim is null';
			if(!$this->db->simple_query($qryFinaliza ))
			 	echo $this->db->error();
			for($i = 0; $i < count($itens); $i++){
				$qryInsere .= 'INSERT INTO glpi_plugin_kanban_tempo (idChamado, dtInicio) ';
				$qryInsere .= 'SELECT * FROM (SELECT '.$this->db->escape($itens[$i]).', now()) AS tmp
								WHERE NOT EXISTS (
								    SELECT 
								    	idChamado 
								    FROM glpi_plugin_kanban_tempo 
								    WHERE 
								    	idChamado = '.$this->db->escape($itens[$i]).' AND
								    	dtFim is NULL
								) LIMIT 1;';
				if(!$this->db->simple_query($qryInsere ))
			 		echo $this->db->error();
			 	$qryInsere = '';
			}
		}
		$qryDelete = "Delete from glpi_plugin_kanban	where idUser = '{$this->db->escape($this->session->userdata('glpiID'))}' and 			(coluna is NULL or coluna = '{$elem_working}')";
		//echo $qryDelete;
		//return;
		if(!$this->db->simple_query($qryDelete ))
			 echo $this->db->error(); 

		$qry = 'Insert into glpi_plugin_kanban (idTicket, idUser, priority, coluna) Values';
		
		for($i = 0; $i < count($itens); $i++){
			$qry .= ($i == 0 ? '': ','). " ({$this->db->escape($itens[$i])}, {$this->db->escape($this->session->userdata('glpiID'))}, {$this->db->escape($i)}, '{$elem_working}')";
		}
		//echo ($qry);
		header('Content-Type: application/html');
		if(!$this->db->simple_query($qry))
			echo json_encode(array('return' => 'error'));
		else
			echo json_encode(array('return' => 'success'));
		
	}
	
	public function closeTicket(){
		$id       = $this->input->post("id");
		$solution = $this->input->post("solution");
		//print_r($solution);
		$client = Clientws::getClient($this->session->userdata('user'), $this->session->userdata('pass'));
		//print_r( $client->listUserGroups());
		$response = $client->setTicketSolution($id, $solution);
		//print_r($response);
		
	}
	
	private function createBoxUser( $idUser, $userName, $boxId){
		
		$this->dragTo = $this->dragTo . ($this->dragTo == '' ? '': ',') . '\''. $boxId. '\'';
		
		$this->box = $this->box. ',{
                "id": "'.$boxId.'",
                "title": "'.$userName.'",
				"dragTo" : [\'_new\'],
                "class": "success",
                "item": []
            }
			';
		$this->func = $this->func . "var elem_working = KanbanTest.getBoardElements('{$boxId}');
			if(elem_working.length > 0){
				var i = 0;
				var itens = [];
				for(i = 0; i< elem_working.length; i++){
					//console.log(elem[i].dataset.eid);
					$('#idChamado').val(elem_working[i].dataset.eid);
					$('#idUser').val({$idUser});
					$('#closeTicket').modal('show');
					itens[i] = elem_working[i].dataset.eid;
				}
			}
			";
			
		//return array('func' => $function, 'box' => $box);
	}
	
	public function assingTicket(){
		$id      = $this->input->post("id");
		$idUser  = $this->input->post("idUser");
		$comment = $this->input->post("comment");
		$isPrivate =  $this->input->post("isPrivate");

		$client = Clientws::getClient($this->session->userdata('user'), $this->session->userdata('pass'));
		
		if ($comment != '')
			$response = $client->addTicketFollowup($id, $comment, $this->session->userdata('user'), 'Kanban', $isPrivate);
		
		$mail = '';
		foreach($this->users as $usr){
			if($usr->id == 7)
			$mail = $usr->email;
		}
		$response = $client->setTicketAssign($id, $idUser, Null, Null, $mail, TRUE);
					
		print_r($response);
		
	}
	
	public function addComment(){
		$id      = $this->input->post("id_ac");
		$comment = $this->input->post("comment_ac");
		$isPrivate =  $this->input->post("isPrivate");
		//echo $isPrivate;
		
		$client = Clientws::getClient($this->session->userdata('user'), $this->session->userdata('pass'));
		
		$response = 'error';
		
		if ($comment != '')
			$response = $client->addTicketFollowup($id, $comment, $this->session->userdata('user'), 'Kanban', $isPrivate );
		
		//print_r($response);
	}
	
	public function getUsers(){
		$qry = "Select 
					usr.id,
					usr.firstname as nome,
					usr.realname as sobrenome,
					concat(usr.firstname, ' ', usr.realname) AS nome_completo,
					mail.email as email
				from glpi_profiles_users as prf
				inner join glpi_users as usr on (
					usr.id = prf.users_id
				)Inner Join glpi_useremails as mail on (
					usr.id = mail.users_id
				)
				where prf.profiles_id = 6";
		$query = $this->db->query($qry);
		$arr = $query->result();

		return $arr;
	}
	
	
}
