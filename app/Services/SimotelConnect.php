<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SimotelConnect
{
    private $client ;

    public function __construct($client = null)
    {
        $this->client = $client ?? new Client();
    }

    public function sendData($suffix, $method, $data)
    {

        try {
            // $fileContent = File::get($data['file']->getRealPath()."/".$data['file']->getClientOriginalName());
            // $path = Storage::putFile( $data);
            
            // $g = storage_path($path);

             Storage::disk('public')->put("fileName.mp3", file_get_contents($data));
 
            $res = $this->client->request($method, env('SIMOTEL_ADDRESS') . "/" . $suffix, [
                'headers' => [
                                'X-APIKEY' => env('SIMOTEL_TOKEN'),
                            ],
                            'timeout'=>70,
                            
                            'multipart' => [
                                [
                                    'name' => 'file',
                                    
                                    'contents' => fopen(storage_path('app\public\fileName.mp3'),'r'),
                                    'filename' => 'Rec.mp3'
                                ]
                            ]
                           
            ]);

            return $res->getBody()->getContents();

        } catch(ClientException $ex) {

            $response = $ex->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();

            return (response()->json([
                "success" => false,
                "error_message" => $ex->getMessage(),
                "response_body" => $responseBodyAsString,
            ], $response->getStatusCode()));
        }
    }

    public function call (){
        $data = $this->client->post(env('SIMOTEL_ADDRESS').'/call/originate/act',[
                    'headers'=>[
                        'X-APIKEY' => env('SIMOTEL_TOKEN'),
                        'Content-Type'=>'application/json',
                    ],
                    'json'=>[
                        "caller"=>"09332999173",
                        "callee"=>"100",
                        "context"=>"from-pstn",
                        "caller_id"=>"100",
                        "trunk_name"=>"moshaver",
                        "timeout"=>"30"
                    ]
                    ]);
    }

}
