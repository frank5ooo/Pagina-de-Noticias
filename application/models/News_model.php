<?php
/**
 * @property CI_DB_query_builder $db
 * @property CI_Session $session
 * @property CI_Pagination $pagination
 * @property CI_Loader $load
 * @property CI_Input $input
 */

class News_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->library(['form_validation', 'session']);
	}
	
	public function get_all_news($page)
	{
		$count = $this->db->count_all('news');

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

		$offset = $page * $paging_conf['per_page'] - $paging_conf['per_page'];

		$query = $this->db->get('news', $paging_conf['per_page'], $offset);

		return ($query->num_rows() > 0) ? $query->result() : [];
	}
	
	public function get_slug_news($slug = FALSE)
	{ 
		$this->db->select('n.*, u.fullname');
		$this->db->from('news n');
		$this->db->join('users u', 'u.id = n.id_author');
		$this->db->where('n.slug', $slug);
		$query = $this->db->get();

        return $query->row_array();
	}

	public function set_news()
	{
		$this->load->helper('url');

		$slug = url_title($this->input->post('title'), 'dash', TRUE);

		$data = array(
			'title' => $this->input->post('title'),
			'slug' => $slug,
			'text' => $this->input->post('text'),
			'id_author'=> $this->session->userdata('id')
		);

		return $this->db->insert('news', $data);
	}

	public function verifyVote($idUser, $idNoticia)
	{
		$this->db->select('v.*');
		$this->db->from('votes v');
		$this->db->where('id_user', $idUser);
		$this->db->where('id_news', $idNoticia);
		
		$query = $this->db->get();
		
		return $query->row_array();
	}

	public function updateVote($idUser, $idNoticia, $vote)
	{
		$this->db->select('v.*');
		$this->db->from('votes v');
		$this->db->where('id_user', $idUser);
		$this->db->where('id_news', $idNoticia);
		
		$query = $this->db->get();
		$votoExistente = $query->row_array();

		if(intval($votoExistente['value']) === intval($vote))
		{	
			$this->db->where('id_user', $idUser);
			$this->db->where('id_news', $idNoticia);
			
			$this->db->delete('votes');

			return 'Voto Eliminado'; 		
		}
		else{
            $this->db->where('id_user', $idUser);
            $this->db->where('id_news', $idNoticia);
			$this->db->update('votes', ['value' => $vote]);

			return 'Voto Actualizado'; 		
		}
	}
	public function Vote($idUser, $idNoticia, $vote)
	{
		$verify = $this-> verifyVote($idUser, $idNoticia);

		if(!$verify)
		{
			$insert = array(
				'id_user'=> $idUser,
				'id_news' => $idNoticia,
				'value' => $vote
			);
			$this->db->insert('votes', $insert);

			$mensaje ='Voto Nuevo';

			return $mensaje;

		} else {
			$mensaje =$this->updateVote($idUser, $idNoticia, $vote);
			
			return $mensaje;
		}
	}

	public function get_user_vote($userId, $newsId) 
	{
		$this->db->select('v.value');
		$this->db->from('votes v');
		$this->db->where('id_user', $userId);
		$this->db->where('id_news', $newsId);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0) 
		{
			$value =$query->row()->value;
			if ($value === 1) 
			{
				return 'up';
			}

			if ($value === -1)
			{
				return 'down';
			}
		}

		return null;
	}

}
