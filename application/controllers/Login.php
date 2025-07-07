<?php
/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property Login_model $Login_model

 */

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Login_model');
		$this->load->helper(['url', 'form']);
		$this->load->library(['form_validation', 'session']); // <-- IMPORTANTE
	}

	public function index() {
		redirect('login/login');
	}

	public function login()
	{
		$this->load->helper('form');
		$data['title'] = 'Iniciar Sesión';
		$this->load->view('login/index', $data);
	}

	public function register()
	{
		$data['title'] = 'Create a profile';
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username','username','required');
		$this->form_validation->set_rules('fullname','fullname','required');
		$this->form_validation->set_rules('password','password','required|min_length[6]');
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header', $data);
			$this->load->view('login/register');
			$this->load->view('templates/footer');
		} 
		else {
			$this->Login_model->register();

			redirect('login/login');
		}
	}

	public function me()
	{
		if (!$this->session->userdata('username'))
		{
 			redirect('login/register');
			return;  
		}
		$data['title'] = 'Panel de Usuario'; 

    	$data['username'] = $this->session->userdata('username');

		$this->load->view('templates/header', $data);
		$this->load->view('login/me', $data);
		$this->load->view('templates/footer');
	}
	public function doLogin()
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

			$this->Login_model->setUsername($username);
			$this->Login_model->setPassword($password);

			$user = $this->Login_model->login();

			if ($user) {
				$this->session->set_userdata([
					'id' => $user->id,
					'username' => $user->username,
					'password'=> $password
				]);
				redirect('login/me');
			} else {
				$data['title'] = 'Iniciar Sesión';
				$data['error'] = 'Usuario o contraseña inválidos';
				$this->load->view('login/index', $data);
			}
		}
	}

	public function logout()
	{
    	$this->session->sess_destroy();
		redirect('login/login');
	}
	
}
