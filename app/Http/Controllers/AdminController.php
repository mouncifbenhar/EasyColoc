<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin(){
        $users = User::all();
        $colocations = Colocation::all();
        return view('admin.dashboard', ['users' => $users, 'colocs' => $colocations]);
    }
    public function ban(User $user){
        $user->is_banned = true;
        $user->save();
        return back();
    }
    public function unban(User $user){
        $user->is_banned = false;
        $user->save();
        return back();
    }
}

