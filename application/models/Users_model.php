<?php
class Users_model extends CI_Model
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
        $query = $this->db->get_where('users', ['username' => $this->username]);

        if ($query->num_rows() === 1) {
            $user = $query->row();

            if (password_verify($this->password, $user->password)) {
                return $user;
            }
        }

        return false;
    }

	public function register()
    {
        $password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);

        $data = [
            'username' => $this->input->post('username'),
            'fullname' => $this->input->post('fullname'),
            'password' => $password
        ];

        return $this->db->insert('users', $data);
    }
}
