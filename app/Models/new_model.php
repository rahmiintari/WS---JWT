<?php
namespace App\Models;

use CodeIgniter\Model;

class new_model extends model{
    protected $table = "game";

    public function register($data) {
        $query = $this->db->table($this->table)->insert($data);
        return $query ? true : false;

    }

public function cek_login($email) {
    $query = $this->db->table($this->table)
                            ->where('email', $email)
                            ->countAll();

        if ($query > 0) {
            $hasil = $this->db->table($this->table)
                            ->where('email', $email)
                            ->limit(1)
                            ->get()
                            ->getRowArray();
        } else {
            $hasil = array();
        }
        return $hasil;
    }
}