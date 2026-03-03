<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login_page(){
        return view('login');
    }
    public function Rigester_page(){
         return view('Rigester');
    }
    public function index(){
    $user = Auth()->user();
    if(auth()->check()){
        if($user->colocation()->exists()){
        $coloc = $user->colocation()->first();
        return redirect('/colocation/'. $coloc->id);
        }
        if(is_null($user->balance)){
            $user->balance = 0.00;
            $user->save();
        }
        return view('Dashboard');
    }else{
        return redirect('/');
    }
    }


    public function create_user(Request $request){
        $incomingFields = $request->validate([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required'
        ]);
        $user = User::create($incomingFields);
        $user->assignRole('member');
        return view('login');
    }
    public function login(Request $request){
        $incomingFields = $request->validate([
                'email' => 'required',
                'password' => 'required'
        ]);
        if(auth()->attempt(['email'=> $incomingFields['email'],'password'=> $incomingFields['password']])){
            $request->session()->regenerate();
            return redirect('/Dashboard');
        }else{
            return redirect('/login');
        }
    }
     public function logout(){
        auth()->logout();
        return redirect('/');
    }
}
