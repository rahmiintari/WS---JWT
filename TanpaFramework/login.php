<?php

require_once('vendor/autoload.php');
require_once('./cors.php');

use Firebase\JWT\JWT;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


    header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit();
        }

        $json = file_get_contents('php://input');
        $input_user = json_decode($json);

            if (!isset($input_user->email) || !isset($input_user->password)) {
            http_response_code(400);
            exit();
            }

            $user = [
            'email' => 'intarirahmi07@gmail.com',
            'password' => 'rhmintari22baru'
            ];

                header('Content-Type: application/json');

                // Jika email atau password tidak sesuai
                if ($input_user->email !== $user['email'] || $input_user->password !== $user['password']) {
                echo json_encode([
                    'success' => false,
                    'data' => null,
                    'message' => 'Email atau password tidak sesuai'
                ]);
                exit();
                }

                    // Menghitung waktu kadaluarsa token dalam 15 menit
                    $waktu_kadaluarsa = time() + (15 * 60);

                    $payload = [
                    'email' => $input_user->email,
                    'exp' => $waktu_kadaluarsa
                    ];

                        // Men-generate access token
                        $access_token = JWT::encode($payload, $_ENV['ACCESS_TOKEN_SECRET']);

                            // Kirim kembali ke user
                            echo json_encode([
                            'success' => true,
                            'data' => [
                                'accessToken' => $access_token,
                                'expiry' => date(DATE_ISO8601, $waktu_kadaluarsa)
                            ],
                            'message' => 'Login berhasil!'
                            ]);

                            // Mengubah waktu expired
                            $payload['exp'] = time() + (60 * 60);
                            $refresh_token = JWT::encode($payload, $_ENV['REFRESH_TOKEN_SECRET']);

                            // Simpan refresh token
                            setcookie('refreshToken', $refresh_token, $payload['exp'], '', '', false, true);
