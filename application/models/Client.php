<?php
class Client extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_client($id = FALSE, $order_by='client_id', $order='DESC')
    {
        if ($id === FALSE)
        {
            $this->db->order_by($order_by, $order);
            $this->db->select("client_id, client_name");
            $query = $this->db->get("client");

            $data = [
                '-1' => '-- Select Client --',
            ];
            foreach ($query->result_array() as $row) {
                $data[$row['client_id']] = $row['client_name'];
            }

            return $data;
        }

        $query = $this->db->get_where('CLIENT', array('client_id' => $id));
        return $query->row_array();
    }

    public function get_client_for_table() {

        $this->db->order_by("client_name", "ASC");
        $query = $this->db->get("client");

        $data = [];
        foreach ($query->result_array() as $row) {
            $data[] = [
                '<a href="' . base_url('/') . 'index.php/client_form?client_id=' . $row['client_id'] . '">' . $row['client_name'] . '</a>',
                $row['client_cui'],
                $row['client_orc'],
                $row['client_phone'],
                $row['client_email'],
                $row['client_address'],
                $row['client_bank'],
                $row['client_account'],
                '<div style="width: 80px;"><a class="btn btn-sm btn-success" href="' . base_url('/') . 'index.php/client_form?client_id=' . $row['client_id'] . '"><span class="fas fa-edit"></span></a>' .
                '<a class="btn btn-sm btn-danger mx-2" onclick="return confirm(\'Are you sure you want to delete this record?\');" href="' . base_url('/') . 'index.php/form/delete_client?client_id=' . $row['client_id'] . '"><span class="fas fa-trash"></span></a></div>'
            ];
        }

        return $data;
    }

    public function save_client($data)
    {

        $client_id = $data['client_id'];
        unset($data['client_id']);
        unset($data['submit_form']);

        try {
            // client
            if ($client_id > 0) {
                // update
                $this->db->where('client_id', $client_id);
                $this->db->update('client', $data);
            } else {
                // insert
                $this->db->insert('client', $data);
                $client_id = $this->db->insert_id(); // get last insert id
            }

            $save = [
                'type' => 'alert-success',
                'message' => '<strong>Success:</strong> record successfully saved',
                'insert_id' => $client_id
            ];

        } catch(Exception $e) {
            $save = [
                'type' => 'alert-danger',
                'message' => '<strong>Error:</strong> ' . $e->getMessage(),
                'insert_id' => -1
            ];
        }

        return $save;
    }

    public function delete_client($client_id)
    {

        try {
            $this->db->delete('client', array('client_id' => $client_id));
            $success = [
                'type' => 'alert-success',
                'message' => '<strong>Success:</strong> record has been successfully deleted'
            ];
        } catch(Exception $e) {
            $success = [
                'type' => 'alert-danger',
                'message' => '<strong>Error:</strong> ' . $e->getMessage()
            ];
        }

        return $success;
    }
}
