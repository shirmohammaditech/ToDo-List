<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index()
    {
        $toDos = auth()->user()->todos();
        return view('dashboard', compact('toDos'));
    }
    public function create()
    {
    	return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
    	$toDo = new Todo();
        $toDo->name = $request->name;
    	$toDo->description = $request->description;
    	$toDo->user_id = auth()->user()->id;
    	$toDo->save();
    	return redirect('/dashboard'); 
    }

    public function edit(Todo $todo)
    {

    	if (auth()->user()->id == $todo->user_id)
        {            
                return view('edit', compact('todo'));
        }           
        else {
             return redirect('/dashboard');
         }            	
    }

    public function update(Request $request, Todo $todo)
    {
    	if(isset($_POST['delete'])) {
    		$todo->delete();
    		return redirect('/dashboard');
    	} else {
            $request->validate([
                'name' => 'required',
                'description' => 'required'
            ]);
            $todo->name = $request->name;
    		$todo->description = $request->description;
	    	$todo->save();
	    	return redirect('/dashboard'); 
    	}    	
    }

    public function updateStatus(Request $request, Todo $todo)
    {
        $request->validate([
            'status' => 'required'
        ]);
        $todo->status = $request->status;
	    $todo->save();
        return response()->json([
            'code' => 1,
            'success'=>'Todo status Updated Successfully!'
        ]);    }    
}