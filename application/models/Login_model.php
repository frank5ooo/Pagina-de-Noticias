<?php
class Login_model extends CI_Model
{
    private $username;
    private $password;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

	public function login()
    {
		$query = $this->db->get_where('users', [
            'username' => $this->username,
            'password' => $this->password
        ]);

		if ($query->num_rows() === 1) {
            return $query->row(); 
        } else {
            return false;
        }
    }


	public function register()
    {
        $data = [
            'username' => $this->input->post('username'),
            'fullname' => $this->input->post('fullname'),
            'password' => $this->input->post('password')
        ];

        return $this->db->insert('users', $data);
    }
}
