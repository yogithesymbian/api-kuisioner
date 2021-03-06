<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\UserScore;

class NilaiKuisController extends Controller
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


    public function showNilai(Request $request)
    {

        $id_users = $request->input('id_users');

        $userScore = DB::select(
            'SELECT
            *
            FROM
                show_score
            WHERE
                id_users =
                ' . $id_users . ' ORDER BY id DESC'
        );

        if (!$userScore) {
            return response()->json([
                'success' => false,
                'message' => 'kuis Not Found',
                'data' => null
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'kuis Found',
                'data' => [
                    'scores' => $userScore
                ]
            ], 201);
        }
    }

    public function insert(Request $request)
    {

        $id_users = $request->input('id_users');
        $id_soals = $request->input('id_soals');
        $score = $request->input('score');
        // elquent
        $insert = userScore::create([
            'id_users' => $id_users,
            'id_soals' => $id_soals,
            'score' => $score,
        ]);

        if($insert)
        {
            return response()->json([
                'success' => true,
                'message' => 'insert Success!',
                'data' => $insert
            ],201);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'insert Fail!',
                'data' => ''
            ],400);
        }
    }
}
