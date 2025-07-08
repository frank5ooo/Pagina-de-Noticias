<?php

/**
 * @property CI_DB_query_builder $db
 * @property News_model $News_model
 * @property CI_Pagination $pagination
 * @property CI_Form_validation $form_validation
 * @property CI_Session $session
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

		$this->by_slug();
	}

	public function by_slug()
	{
		$data['news'] = $this->News_model->get_slug_news();

	}

	public function page($page = 1)
	{
		// Obtener noticias
		$data['news'] = $this->News_model->get_all_news($page);

		$data['title'] = 'Noticias';

		// Pasar links de paginación
		$this->load->library('pagination');
		$data['pagination_links'] = $this->pagination->create_links();

		// Cargar vistas
		$this->load->view('templates/header', $data);
		$this->load->view('news/index', $data);
		$this->load->view('templates/footer');
	}

	public function view($slug)
	{
		// Obtener la noticia según el slug
		$news_item = $this->News_model->get_slug_news($slug);

		if (empty($news_item))
		{
			show_404();
		}

		// Cargar las vistas
		$this->load->view('templates/header', ['title' => $news_item['title']]);
		$this->load->view('news/view', ['news_item' => $news_item]);
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
}
