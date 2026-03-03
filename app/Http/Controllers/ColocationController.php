<?php

namespace App\Http\Controllers;

use App\Mail\InviteMail;
use App\Models\Colocation;
use App\Models\Invitation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ColocationController extends Controller
{
    public function create_colocation(Request $request)
    {
        $user = Auth()->user();
        if(!$user->colocation()->exists()){
             $incomingFields = $request->validate([
            'title' => 'required',
        ]);
        
        $coloc = Colocation::create($incomingFields);
        $user->colocation()->attach($coloc->id, ['role' => 'owner']);
        return redirect('/colocation/'.$coloc->id);
        } 
        return redirect()->back()->with('error', 'Colocation are exists');
    }
    public function colocation_page(Colocation $coloc){
        $users = $coloc->user;
        $expenses = $coloc->expenses;
        $payments = $coloc->payments;
        $categories = $coloc->Category;
        $total = $coloc->expenses->sum('amount');
        return view('Colocation',['users' => $users, 'coloc' => $coloc, 'expenses' => $expenses, 'payments' => $payments, 'categories' => $categories, 'total' => $total]);
    }

    public function invite_email(Request $request,Colocation $coloc){
        $var = Invitation::create([
              'colocation_id' => $coloc->id,
              'token' => Str::random(24)
        ]);
         Mail::to($request)->send(new InviteMail($var->token));
         return redirect()->back();
    }
    public function invitation_page($token){
            return view('invite_form',['token' => $token]);
    }
    public function accept_coloc($token){
        $invite = Invitation::where('token',$token)->first();
        auth()->user()->colocation()->attach($invite->colocation_id,['role'=>'member']);
        return redirect('/Dashboard');
    }
    public function cancel(Colocation $coloc){
        $coloc->state = 'canceled';
        $coloc->users()->detach();
        $coloc->save();
        return redirect('/dashboard');
    }
}

