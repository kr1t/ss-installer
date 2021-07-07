<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Engineer;

class RichMenuController extends Controller
{
    public $memberRichMenuId = "richmenu-f8b0710013ea62988e8d72f87f8c7b2d";
    public function linkAll()
    {
        $curl = curl_init();
        $token = env('LINE_TOKEN', '');

        $engineers  = Engineer::get()->pluck('line_uid');
        $postBody = [
            "richMenuId" => $this->memberRichMenuId,
            "userIds" => $engineers
        ];


        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.line.me/v2/bot/richmenu/bulk/link',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postBody),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer {$token}",
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $engineers;
    }
}
