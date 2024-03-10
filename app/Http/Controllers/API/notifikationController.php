<?php

namespace App\Http\Controllers\API;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class notifikationController extends Controller
{
    public function index()
    {
        $notifikasi = Notifikasi::orderBy('id', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'notifikasi' => $notifikasi,
        ], 200);
    }
}
