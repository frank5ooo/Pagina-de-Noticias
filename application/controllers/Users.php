<?php
/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property Users_model $Users_model

 */

class Users extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Users_model');
		$this->load->helper(['url', 'form']);
		$this->load->library(['form_validation', 'session']);
	}

	public function index() {
		redirect('Users/login');
	}

	public function login()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Usuario', 'required');
		$this->form_validation->set_rules('password', 'Contraseña', 'required');

		if ($this->form_validation->run() === FALSE) 
		{
			$data['title'] = 'Iniciar Sesión';
			$this->load->view('login/index', $data);
		} 
		else {
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			$this->Users_model->setUsername($username);
			$this->Users_model->setPassword($password);

			$user = $this->Users_model->login();

			if ($user) {
				$this->session->set_userdata([
					'id' => $user->id,
					'fullname' => $user->fullname,
					'username' => $user->username,
				]);
				redirect('Users/me');
			} else {
				$data['title'] = 'Iniciar Sesión';
				$data['error'] = 'Usuario o contraseña inválidos';

				$this->load->view('login/index', $data);
			}
		}
	}

	public function register()
	{
		$data['title'] = 'Create a profile';
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('username','username','required');
		$this->form_validation->set_rules('fullname','fullname','required');
		// $this->form_validation->set_rules('password','password','required');
		// $this->form_validation->set_rules('RePassword','RePassword','required|min_length[6]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]',
                        array('required' => 'You must provide a %s.') );
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header', $data);
			$this->load->view('login/register');
			$this->load->view('templates/footer');
		} 
		else {
			$this->Users_model->register();
			redirect('Users/login');
		}
		
	}

	public function me()
	{
		if (!$this->session->userdata('username'))
		{
 			redirect('Users/register');
			return;  
		}
		$data['title'] = 'Panel de Usuario'; 

    	$data['username'] = $this->session->userdata('username');
    	$data['fullname'] = $this->session->userdata('fullname');

		$this->load->view('templates/header', $data);
		$this->load->view('login/me', $data);
		$this->load->view('templates/footer');


	}

	public function logout()
	{
    	$this->session->sess_destroy();
		redirect('Users/login');
	}
	
}
