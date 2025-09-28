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
        return response()->json([]);
    }

    public function index(){
        $memos = Memo::all();
        return response()->json($memos);
    }

    public function destroy(Request $request){
        $memo = Memo::find($request['id']);
        $memo->delete();
        return response()->json($memo);
    }

    public function edit(Request $request){
        $memo = Memo::find($request['id']);
        return response()->json($memo);
    }
}
