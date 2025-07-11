<?php
/**
 * @property CI_DB_query_builder $db
 * @property News_model $News_model
 * @property CI_Pagination $pagination
 * @property CI_Form_validation $form_validation
 * @property CI_Session $session
 * @property CI_Input $input
 * 
 */

class News extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('News_model');
		$this->load->helper('url_helper');
		$this->load->library(['form_validation', 'session']);
	}

	public function index()
	{
		$this->page();
	}
	public function page($page = 1)
	{
		$data['news'] = $this->News_model->get_all_news($page);

		$data['title'] = 'Noticias';

		$this->load->library('pagination');
		$data['pagination_links'] = $this->pagination->create_links();

		$this->load->view('templates/header', $data);
		$this->load->view('news/index', $data);
		$this->load->view('templates/footer');
	}

	public function view($slug)
	{
		$news_item = $this->News_model->get_slug_news($slug);
		$userId =$this->session->userdata('username');

		if (empty($news_item))
		{
			show_404();
		}
		
		$currentVote = $this->News_model->get_user_vote($userId, $news_item['id']);

		$this->load->view('templates/header', ['title' => $news_item['title']]);
		$this->load->view('news/view', [
			'news_item' => $news_item,
			'currentVote' => $currentVote,
		]);

		$this->load->view('templates/footer');
	}

	public function create()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		if (!$this->session->userdata('username'))
		{
 			redirect('Users/login');
			return;  
		}

		$data['title'] = 'Create a news item';
    	$data['username'] = $this->session->userdata('username');

		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('text', 'Text', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header', $data);
			$this->load->view('news/create');
			$this->load->view('templates/footer');
		}
		else
		{
			$this->News_model->set_news();
			redirect('news');
		}
	}

	public function vote($idNoticia)
	{
		header('Content-Type: application/json');

		if (!$this->session->userdata('username'))
		{
			http_response_code(401);
			echo json_encode([
				'error' => 'Debés iniciar sesión para votar.'
			]);
			return;
		}

		$json = file_get_contents('php://input');
		$data = json_decode($json, true);

		if($data['vote']==='up')
		{
			$vote = 1;
		} 
		else if ($data['vote']==='down')
		{
			$vote = -1;
		} else {
			$vote = 0;
		}

		$idUser= $this->session->userdata('id');

    	$ok = $this->News_model->vote($idUser, $idNoticia, $vote);

		echo json_encode([
			'mensaje' => $ok,
		]);
	}
}
