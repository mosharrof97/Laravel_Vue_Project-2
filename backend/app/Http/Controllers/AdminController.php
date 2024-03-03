<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;


class AdminController extends Controller
{
    public function dashboard(){

        return view('AdminDashboard');
    }

    public function login(){
        return view('AdminLogin');
    }

    public function login_submit(Request $request){

    $request->validate([
    'email' => 'required|email',
    'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if(Auth::guard('admin')->attempt($credentials)){

    $user = Auth::guard('admin')->user(); // Retrieve the authenticated user
    $token = $user->createToken('authToken')->plainTextToken;

    return response()->json([
    'status' => true,
    'user' => $user,
    'token' => $token,
    'message' => 'Login Successful',
    ]);

    } else {

    return response()->json([
    'status' => false,
    'message' => 'Login unsuccessful',
    ], 401); // Unauthorized status code
    }
    }

    public function logout( Request $request){
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }
// public function logout(){

//     Auth::guard('admin')->logout();
//     // return redirect()->route('admin_login')->with('Success','Logout successfully');
//     return response()->json([
//         'status'=> true,
//         'massage' =>'Logout successfully',
//     ]);
// }

/////////---------Admin CRUD------------//////////

    public function adminList(){

        $data= Admin::get();
        return response()->json([
            'status'=>true,
            'data'=>$data,
        ]);
    }

    public function adminView($id){

        $data= Admin::where('id',$id)->first();
            return response()->json([
                'status'=>true,
                'data'=>$data,
            ]);
    }

    public function createAdmin(Request $request){
        return view('AdminRegister');
    }

    public function storeAdmin(Request $request){

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Admin::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $newuser = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($newuser));

        $user = Auth::guard('admin')->user();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'status'=> true,
            'massage' =>'Login successfully',
        ]);
    }

    public function Delete($id){

        $data= Admin::find($id);
        $data->delete();
        return response()->json([
            'status'=>true,
            'massage'=>'Data Delete Successfull',
        ]);
    }

}
