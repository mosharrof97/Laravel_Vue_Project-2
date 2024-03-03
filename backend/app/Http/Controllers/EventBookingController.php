<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventBooking;

class EventBookingController extends Controller
{
   public function list(){
        $data=EventBooking::get();
        return response()->json([
            'status'=>true,
            'data'=>$data,
        ]);
   }

   public function view($id){
    $data=EventBooking::where('id',$id)->first();
    return response()->json([
        'status'=>true,
        'data'=>$data,
    ],200);
   }

   public function create(Request $request){
    // $validation=$request->validate([
    //     'name' => ['required', 'string', 'max:255'],
    //     'email'=> ['required'],
    //  ]);

        EventBooking::create([
            'name' => $request->name,
           'email'=> $request->email,
        ]);
        return response()->json([
            'status'=>true,
            'Massage'=>'Event Booking Successfull',
        ],200);
   }

   public function update(Request $request, $id){
        // $validation=$request->validate([
        // 'name' => ['required', 'string', 'max:255'],
        // 'email' => ['required'],
        // ]);


        $data= EventBooking::find($id);
        $data->update([
            'name' => $request->name,
            'email'=> $request->email,
        ]);
        return response()->json([
            'status'=>true,
            'Massage'=>'Event Booking Update Successfull',
        ],200);
    }

    public function delete($id){
        $data=EventBooking::find($id);
        $data->delete();
        return response()->json([
            'status'=>true,
            'Massage'=>'Event Delete Successfull',
        ],200);
    }
}
