<?php
class User extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_user($email = FALSE)
    {
        if ($email === FALSE)
        {
                $query = $this->db->get("USER");
                return $query->result_array();
        }

        $query = $this->db->get_where('USER', array('email' => $email));
        return $query->row_array();
    }
}
