<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
	
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('client');
		$this->load->helper('clientws');
		$this->session->set_userdata('isLogged', false);
	}
	public function index()
	{
		$this->load->view('login');
	}
	
	public function login(){
		$this->session->set_userdata('isLogged', false);
		
		
		$client = Client::getClient();
		
		//$client = Flight::get('client');
		try {
		   $client->initSessionByCredentials($this->input->post('name'),$this->input->post('pass')	);
		   $clientws = Clientws::getClient($this->input->post('name'), $this->input->post('pass'));
		} catch (Exception $e) {
		   echo $e->getMessage();
		   site_url('/');
		}
		$response = $client->request('GET', 'getFullSession');//$itemHandler->getMyProfiles();
		$user = json_decode($response->getBody()->getContents());
		//header('Content-Type: application/json');
		//echo json_encode($query->result() );
		//echo json_encode($user );
		//print('<pre>');print_r($user);print('</pre>');
		//$this->session->set_userdata('user', $user->session->);
		/*
			[session] =>
				[glpiID] => 7
				[glpiname] => aneidert
				[glpirealname] => Neidert
				[glpifirstname] => André
				[glpiactiveprofile] => 
					[id] => 4
				
		*/
		$this->session->set_userdata('glpiID', $user->session->glpiID);
		$this->session->set_userdata('user', $this->input->post('name'));
		$this->session->set_userdata('pass', $this->input->post('pass'));
		$this->session->set_userdata('glpiname', $user->session->glpiname);
		$this->session->set_userdata('glpirealname', $user->session->glpirealname);
		$this->session->set_userdata('glpifirstname', $user->session->glpifirstname);
		$this->session->set_userdata('glpiactiveprofile', $user->session->glpiactiveprofile);
		
		//$this->session->set_userdata('client', $client);
		$this->session->set_userdata('isLogged', true);
		redirect('/dashboard', 'refresh');
	}
}
