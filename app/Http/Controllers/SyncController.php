<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Engineer;
use Carbon\Carbon;

class SyncController extends Controller
{
    public function apiGetSyncEngineer()
    {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://s-tracking.byi-demo.site/installer-service/api/member/sync_engineer',
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
                    'Authorization: bearer 1TEIUFkBVCl2hFDTpnzPQDOa2FLwbS2MMcXd1GfsbhguEt3ybTzyrE5fizUpr7KSp-56WNBsnvMzBixCjWAt5Qk2Rb5-k4-J5Et_YT55Ofz821R3Gm41ddbF7y6HJ_KXcTY2B8iK5lcHnH_SwxWZpaaRdo0kHQ4rZv_ef3iFzZOHmvjY3KRSbzJVV3-yUIfI-AnVSDlauWElXSEr4hei40PXqPbR1xYCBGrVUaygiZhWGXSpZmMj4bVpGS8raCEOFxGxr87IbHMALvwx4atGhPZotkIpxzBaHEcSTq28B9yGjxAGx4PE3pC3D4Jmt3TF5rK8VSZlLe7IRb9PWJpqmNAB_LjYe4vd8C9as8BJa1TQe_B5TxGXlFKeKS9UGzuJzTZV4NHqgqvsXXWWck7VTOjkqtPAk7vjDlaxSZd5etp3DLkxpWB-8SpUyJTZodhx0zpNIoJ-13P0-P9Ce37_uLNcRkW1QtzfcYf4s2ZMHQSUQNUMfxnYB6281Ped2wCOBpLwM84u8Pt4mTfDWNOAYSD9-ta1l9Y_vg5mg4A5bmZ0bjOesW6IjvwyOfw-G7lUyQUntXK8r6ugiX2wjrx3gQ',
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return json_decode($response, true)['Result'];
        } catch (\Exception $e) {
            return [];
        }
    }
    public function syncEngineer()
    {
        $engineers = $this->apiGetSyncEngineer();

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
