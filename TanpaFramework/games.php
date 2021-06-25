<?php

require_once('./vendor/autoload.php');

use Firebase\JWT\JWT;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

    header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        http_response_code(405);
        exit();
        }

            $headers = getallheaders();

                if (!isset($headers['Authorization'])) {
                http_response_code(401);
                exit();
                }

                list(, $token) = explode(' ', $headers['Authorization']); //mengambil token

                try {
                    JWT::decode($token, $_ENV['ACCESS_TOKEN_SECRET'], ['HS256']);
  
                    $games = [
                        [
                        'title' => 'Mortal Kombat',
                        'genre' => 'Fighting Game'
                        ],
                        [
                        'title' => 'Dead Effect',
                        'genre' => 'First Person Shooter (FPS)'
                        ],
                        [
                        'title' => 'Dead Space',
                        'genre' => 'Third Person Shooter (TPS)'
                        ]
                    ];

                echo json_encode($games);
                } catch (Exception $e) {

                //jalan jika terdapat error saat JWT diverifikasi atau di-decode
                http_response_code(401);
                exit();
                }