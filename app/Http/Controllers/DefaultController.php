<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;

class DefaultController extends Controller
{
    public function index(){
        return view('teacher.index');
    }

    public function allData(){
       $allData = Teacher::all();

       return response()->json($allData);
    }

    public function dataStore(Request $request){
        $request->validate([
            'name'=>'required',
            'qualification'=>'required'
        ]);

      $data = Teacher::insert([
          'name'=>$request->name,
          'qualification'=>$request->qualification,
      ]);

        return response()->json($data);
    }

    public function editData($id){
        $editData = Teacher::find($id);

        return response()->json($editData);
    }
    public function dataUpdate(Request $request,$id){

        $request->validate([
            'name'=>'required',
            'qualification'=>'required'
        ]);
        $data = Teacher::findOrFail($id)->update([
            'name'=>$request->name,
            'qualification'=>$request->qualification,
        ]);
        return response()->json($data);
    }

    public function delete($id){
       $data= Teacher::find($id);
       $data->delete();
       return response()->json($data);
    }
   
}

