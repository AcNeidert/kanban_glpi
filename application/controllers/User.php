	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
		
		
		if (!$this->session->userdata('isLogged'))
			redirect('/login', 'refresh');
	}
	public function index()
	{
		redirect('/user/add/', 'refresh');
										
	}
	public function add(){
		$this->load->view('user', array());
	}
	
	public function edit($user = null){
		
	}

	
	
}
