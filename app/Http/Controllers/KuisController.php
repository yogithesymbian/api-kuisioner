<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class KuisController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
    {
        $this->middleware('auth');
    }
    public function home()
    {
        return response()->json([
            'success' => false,
            'title' => 'Welcome'
            'message' => 'hello world',
        ], 201);
    }

    public function showKuisDetail(Request $request)
    {

        $id_soals = $request->input('id_soals');

        $kuis = DB::select(
            'SELECT
                *
            FROM
                isi_kuis
            WHERE
                id_soals =
                ' . $id_soals
        );

        if (!$kuis) {
            return response()->json([
                'success' => false,
                'message' => 'kuis Not Found',
                'data' => null
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'kuis detail Found',
                'data' => [
                    'soal' => $kuis,
                ]
            ], 201);
        }
    }

    public function showKuis()
    {
        $kuis = DB::select(
            'SELECT
                *
            FROM
                soals
                '
        );

        if (!$kuis) {
            return response()->json([
                'success' => false,
                'message' => 'kuis Not Found',
                'data' => null
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'list soal kuis Found',
                'data' => [
                    'soal' => $kuis,
                ]
            ], 201);
        }
    }
}
