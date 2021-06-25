<?php

namespace App\Controllers;

use App\Models\new_model;
use CodeIgniter\RESTful\ResourceController;
use \Firebase\JWT\JWT;

class auth extends ResourceController
{
    public function __construct(){
        $this->auth = new new_model();
    }
	public function register() {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $judul = $this->request->getPost('judul');
        $genre = $this->request->getPost('genre');

        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $dataRegister = [
            'email' => $email,
            'password' => $password,
            'judul' => $judul,
            'genre' => $genre
        ];

        $register = $this->auth->register($dataRegister);

        if ($register == true) {
            $status = [
                'status' => 200,
                'message' => 'Registrasi Berhasil'

            ];
            return $this->respon($status, 200);
        } else {
            $status = [
                'status' => 401,
                'message' => 'Registrasi Gagal'

            ];
            return $this->respon($status, 401);
        }
    }	
}
