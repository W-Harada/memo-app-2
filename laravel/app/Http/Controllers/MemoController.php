<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    public function store(Request $request){
        Memo::create([
            'text' => $request['text'],
        ]);
    }

    public function index(){
        $memos = Memo::all();
        return response()->json($memos);
    }
}
