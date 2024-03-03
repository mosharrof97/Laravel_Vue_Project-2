<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
class StudentController extends Controller
{

    public function dashboard(){

        return view('StudentDashboard');
    }



    public function login(){
        return view('StudentLogin');
    }



    public function login_submit(Request $request){

        $request ->validate([
                'email' =>'required|email',
                'password'=>'required',

        ]);

        $credentials = $request ->only('email','password');

        if(Auth::guard('student')->attempt($credentials)){

            $user = Student::where('email',$request->input('email'))->first();
            $token = $user->createToken('authToken')->plainTextToken;
            // Auth::guard('admin')->login($user);
            return response()->json([
                'status'=> true,
                'user' => $user,
                'token' => $token,
                'massage' =>'Login Successful',
            ]);
        }else{
            return response()->json([
                'status'=> true,
                'massage' =>'Login Unsuccessfully',
            ]);
        }
    }

    public function logout( Request $request){
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    // public function logout1(){

    //     Auth::guard('student')->logout();
    //     return response()->json([
    //         'status'=> true,
    //         'massage' =>'Logout successfully',
    //     ]);
    // }




    /////////---------Admin CRUD------------//////////

    public function studentList(){

        $data= Student::get();
        return response()->json([
            'status'=>true,
            'data'=>$data,
        ]);
    }

    public function studentView($id){

        $data= Student::where('id',$id)->first();
        return response()->json([
            'status'=>true,
            'data'=>$data,
        ]);
    }

    public function createStudent(){
        return view('StudentRegister');
    }

    public function storeStudent(Request $request){

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Student::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $newuser = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($newuser));

        $user = Student::where('email',$request->input('email'))->first();
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'status'=> true,
            'massage' =>'Logout successfully',
        ]);
    }

    public function Delete($id){

        $data= Student::find($id);
        $data->delete();
        return response()->json([
            'status'=>true,
            'massage'=>'Data Delete Successfull',
        ]);
    }
}
