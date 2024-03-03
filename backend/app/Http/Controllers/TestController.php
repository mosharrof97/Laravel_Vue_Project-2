<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;


class TestController extends Controller
{
    public function http()
    {
       
        $response = Http::get('http://103.16.73.190:6688/dcpl/dhakacariers/hr/empinfo/');
        
        if ($response->successful()) {
            $csvData = $response->body();
            
            $csvArray = str_getcsv($csvData, "\n");
            // dd($csvArray);
            $headers = str_getcsv(array_shift($csvArray));
            $parsedData = [];
    
            foreach ($csvArray as $row) {
                $rowData = str_getcsv($row);
                $parsedData[] = array_combine($headers, $rowData);
            }
    
            $jsonString = json_encode($parsedData);
            // dd($jsonString);
            return view('test', compact('jsonString'));
        } else {
            dd($response->status());
            // return $response->status();
        }
    }

    // public function httpData()
    // {
    //     $client = new Client();

    //     $response = $client->get('http://103.16.73.190:6688/dcpl/dhakacariers/hr/employees/');
    //     $data = $response->getBody()->getContents();
    //     $parsedData = [];
    //     foreach ($data as $kew => $row) {
    //         $parsedData[] = array_combine($headers, $row);
    //     }
    //     $datas = json_decode($data, true);
        
    //     return view('test', compact('datas'));


    // }


    public function httpData()
{
    // $client = new Client();

    // $response = $client->get('http://103.16.73.190:6688/dcpl/dhakacariers/hr/employees/');
    $response = Http::get('http://103.16.73.190:6688/dcpl/dhakacariers/hr/employees/');
    $result = json_decode($response->getBody()->getContents(), true);



    $datas = [];
    foreach ($result["items"] as  $row) {
        $datas[] = $row;
    }

    
// dd($datas);
// return $datas;
    return view('test',['datas'=>$datas,]);
}

   
}
// composer require guzzlehttp/guzzle
