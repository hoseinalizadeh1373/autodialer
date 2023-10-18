<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SimotelConnect;

class AutoDialerController extends Controller
{
    public function announcementsUpload(Request $request)
    {
        $simotelConnect = new SimotelConnect();
        $suffix = "autodialer/announcements/upload";
        $method = "post";

        
        // $file = $request->file->storeAs('importFiles', $request->file->getClientOriginalName());
        $result = $simotelConnect->sendData($suffix, $method, $request->file('file'));
        return response()->json([

            'res' => $result,
        ]);

    }
}
