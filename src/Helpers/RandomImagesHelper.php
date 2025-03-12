<?php

namespace App\Helpers;

use App\Kernel;
use GuzzleHttp\Client;

class RandomImagesHelper
{
    private const API_URL = "https://api.together.xyz/v1/images/generations";
    private const API_KEY = "55a4a0b136caf76d884f86790b6f3ae224269449f663c0d496006bd4129de7fa";

    public static function getImageByPrompt(string $sPrompt)
    {
        $guzzle = new Client();
        try {
            $response = $guzzle->request(
                "POST",
                self::API_URL,
                [
                    'headers' => [
                        "Authorization" => "Bearer " . self::API_KEY,
                        "Content-Type" => " application/json"
                    ],
                    'json' => [
                        "model" => "black-forest-labs/FLUX.1-dev",
                        "prompt" => $sPrompt,
                        "height" => 260,
                        "width" => 250,
                        "guidance_scale" => 1,
                        "steps" => 10,
                        "n" => 1
                    ]
                ]
            );

            $data = json_decode($response->getBody(), true);

            $sPicURL = $data['data'][0]['url'];
            $kernel = new Kernel('dev', true);
            $rootPath = $kernel->getProjectDir().'/public';

            if(!file_exists($rootPath.'/upload/')) {
                mkdir($rootPath.'/upload/');
            }

            $sNewPicPath = '/upload/'.md5(time()).'.png';
            file_put_contents($rootPath . $sNewPicPath, file_get_contents($sPicURL));

            return 'http://localhost:8080'.$sNewPicPath;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}