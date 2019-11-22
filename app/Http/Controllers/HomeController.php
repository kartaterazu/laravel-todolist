<?php

namespace App\Http\Controllers;

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Model\Todolist;

class HomeController extends Controller
{
    public function index()
    {

        return view('todolist');
    }

    public function list()
    {
        $todolist = Todolist::todolist();

        if($todolist) {
            $data = array(
                'error'         => 0,
                'message'       => 'Todolist get Successfully',
                'response_code' => 200,
                'data'          => $todolist
            );
        } else {
            $data = array(
                'error'         => 1,
                'message'       => 'Failed to get To do list',
                'response_code' => 200,
                'data'          => []
            );
        }

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'todolist' => 'required'
        ]);

        $saveTodo = Todolist::saveTodo($request);

        if($saveTodo) {
            $data = array(
                'error'         => 0,
                'message'       => 'Todolist saved Successfully',
                'response_code' => 200,
            );
        } else {
            $data = array(
                'error'         => 1,
                'message'       => 'Failed to save To do list',
                'response_code' => 200,
            );
        }

        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $deleteTodo = Todolist::deleteTodo($id);

        if($deleteTodo) {
            $data = array(
                'error'         => 0,
                'message'       => 'Todolist deleted Successfully',
                'response_code' => 200,
            );
        } else {
            $data = array(
                'error'         => 1,
                'message'       => 'Failed to delete To do list',
                'response_code' => 200,
            );
        }

        return response()->json($data, 200);
    }
}
