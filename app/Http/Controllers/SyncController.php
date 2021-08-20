<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Engineer;
use Carbon\Carbon;

class SyncController extends Controller
{
    public function getToken()
    {
        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://www.ss-swatinhome.com/installer-service/token',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_POSTFIELDS => 'grant_type=password&line_id=eng_sync_not_remove',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return json_decode($response, true)['access_token'];
        } catch (\Exception $e) {
            return [];
        }
    }
    public function apiGetSyncEngineer()
    {
        try {
            $token =  $this->getToken();

            // https://www.ss-swatinhome.com/installer-service/
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://www.ss-swatinhome.com/installer-service/api/member/sync_engineer',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode([
                    "size" => 500,
                    "start_date" =>  Carbon::now()->subMinutes(600),
                    "end_date" => Carbon::now()
                ]),
                CURLOPT_HTTPHEADER => array(
                    "Authorization: bearer {$token}",
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return ["status" => 200, "data" => json_decode($response, true)['Result']];
        } catch (\Exception $e) {
            return ["status" => 400, "data" => []];
        }
    }
    public function syncEngineer()
    {


        $fetchEngineers = $this->apiGetSyncEngineer();
        if ($fetchEngineers['status'] == 200) {
            $engineers = $fetchEngineers['data'];
        } else {
            return ['message' => 'fetch engineer error'];
        }

        $creates = [];
        foreach ($engineers as $e) {
            if ($e['line_uid']) {
                $findEngineer = Engineer::select('id')->where('line_uid', $e['line_uid'])->first();
                if (!$findEngineer) {
                    $create = Engineer::create([
                        "first_name_th" => $e['name'],
                        "last_name_th" => $e['lastname'],
                        "installer_id" => $e['code_engineer'],
                        "line_uid" => $e['line_uid'],
                        "email" => $e['email'],
                        "tel" => $e['phone'],
                        "shop" => $e['shopname'],
                        "province_text" => $e['province']
                    ]);

                    array_push($creates, $create);
                }
            }
        }

        return ['message' => 'success', 'engineers' => $creates];
    }
}
