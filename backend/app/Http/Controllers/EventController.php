<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
   public function list(){
        $data=Event::get();
        return response()->json([
            'status'=>true,
            'data'=>$data,
        ]);
   }

   public function view($id){
    $data=Event::where('id',$id)->first();
    return response()->json([
        'status'=>true,
        'data'=>$data,
    ],200);
   }

   public function create(Request $request){
    // $validation=$request->validate([
    //     'name' => ['required', 'string', 'max:255'],
    //     'start_date' => ['required'],
    //     'end_date' => ['required'],
    //     'start_time' => ['required'],
    //     'end_time' => ['required'],
    //     'location'=> ['required'],
    //     'image'=> ['required'],
    //     'description'=> ['required'],
    //  ]);

        if ($request->hasFile('image')) {
           $imageName = 'User_' . time() . '_' . mt_rand(100000, 20000000) . '.' . $request->file('image')->extension();
           $request->file('image')->move(public_path('upload/UserImage'), $imageName);
        }

        Event::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location'=> $request->location,
            'image'=> $imageName,
            'image'=> $request->image,
            'description'=> $request->description,
        ]);
        return response()->json([
            'status'=>true,
            'Massage'=>'Event Create Successfull',
        ],200);
   }

   public function update(Request $request, $id){
        // $validation=$request->validate([
        // 'name' => ['required', 'string', 'max:255'],
        // 'start_date' => ['required'],
        // 'end_date' => ['required'],
        // 'start_time' => ['required'],
        // 'end_time' => ['required'],
        // 'location'=> ['required'],
        // 'image'=> ['required'],
        // 'description'=> ['required'],
        // ]);

        if ($request->hasFile('image')) {
            $imageName = 'User_' . time() . '_' . mt_rand(100000, 20000000) . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('upload/UserImage'), $imageName);
        }

        $data= Event::find($id);
        $data->update([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location'=> $request->location,
            'image'=> $request->image,
            'description'=> $request->description,
        ]);
        return response()->json([
            'status'=>true,
            'Massage'=>'Event Update Successfull',
        ],200);
    }

    public function delete($id){
        $data=Event::find($id);
        $data->delete();
        return response()->json([
            'status'=>true,
            'Massage'=>'Event Delete Successfull',
        ],200);
    }
}
