<?php

/**
 * @property CI_DB_query_builder $db
 */

class News_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_all_news($page)
	{
		$count = $this->db->count_all('news');
		$cant = 2;

		$this->load->library('pagination');
		$this->load->helper('url');

		$paging_conf = [
			'uri_segment'      		=> 3,
			'base_url'        		=> site_url("news/page"),
			'per_page'         		=> 2,
			'total_rows'       		=> $count,
			'first_url'        		=> site_url("news"),
			'use_page_numbers' 		=> TRUE,
		];

		$this->pagination->initialize($paging_conf);


		// Calcular offset
		$offset = $page * $paging_conf['per_page'] - $paging_conf['per_page'];

		// Obtener datos de la base
		$query = $this->db->get('news', $paging_conf['per_page'], $offset);

		// Devolver resultados o arreglo vacío
		return ($query->num_rows() > 0) ? $query->result() : [];

	}
	
	public function get_slug_news($slug = FALSE)
	{ 
		$query = $this->db->get_where('news', array('slug' => $slug));
        return $query->row_array();
	 
	}

	public function set_news()
	{
		$this->load->helper('url');

		$slug = url_title($this->input->post('title'), 'dash', TRUE);

		$data = array(
			'title' => $this->input->post('title'),
			'slug' => $slug,
			'text' => $this->input->post('text')
		);

		return $this->db->insert('news', $data);
	}
}
