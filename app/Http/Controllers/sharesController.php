<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Expence;
use App\Models\User;
use Illuminate\Http\Request;

class sharesController extends Controller
{
    public function create_expense(Request $request, Colocation $coloc){
        $incomingFields = $request->validate([
            'title' => 'required',
            'amount' => 'required',
            'category_id' => 'required',
        ]);
        $incomingFields['paid_by'] = auth()->id();
        $incomingFields['colocation_id'] = $coloc->id;
        $expense = Expence::create($incomingFields);
        $users = $coloc->user;
        $shared = $expense->amount / count($users);
        foreach($users as $user){
            $balance = $user->balance;
            $balance = $balance - $shared;
            if($user->id !== auth()->id()){
                $expense->shares()->attach($user->id, ['amount' => $shared]);
                $user->balance = $balance;
                $user->save();
            }
        }
        return back();
    }
    public function pay($expence_id, $id){
        $user = User::findOrFail($id);
        $expense = Expence::findOrFail($expence_id);
        $pivotdata = $user->whoshares()->where('expence_id', $expense->id)->first();
        $amount = $pivotdata->pivot->amount;
        $user->whoshares()->detach($expense->id);
        $user->balance += $amount;
        $user->save();
        return back();
    }
    public function quit(Colocation $coloc, User $user)
    {
        if ($user->balance >= 0) {
            $user->reputation += 1;
        } else {
            $user->reputation -= 1;
            $total = $user->whoshares()->sum('shares.amount');
            $expense = Expence::create([
                'title' => $user->name . 'left over',
                'amount' => $total,
                'category_id' => 2,
                'paid_by' => auth()->id(),
                'colocation_id' => $coloc->id
            ]);
            $user->balance = 0;
            $members = $coloc->users->where('id', '!=', $user->id);
            $shared = $expense->amount / count($members);
            foreach ($members as $member) {
                $balance = $member->balance;
                $balance = $balance - $shared;

                $expense->shares()->attach($member->id, ['amount' => $shared]);
                $member->balance = $balance;
                $member->save();
            }
        }
        $user->whoshares()->detach();
        $user->colocation()->detach($coloc->id);
        $user->save();
        return redirect('/dashboard');
    }

    public function kick(User $user, Colocation $coloc)
    {
        if ($user->balance >= 0) {
            $user->reputation += 1;
        } else {
            auth()->user()->reputation -= 1;
            $total = $user->whoshares()->sum('shares.amount');
            $expense = Expence::create([
                'title' => $user->name . 'left over',
                'amount' => $total,
                'category_id' => 2,
                'paid_by' => $user->id,
                'colocation_id' => $coloc->id
            ]);
            $user->balance = 0;
            $expense->shares()->attach(auth()->id(), ['amount' => $total]);
            auth()->user()->balance -= $total;
            auth()->user()->save(); 
        }

        $user->whoshares()->detach();
        $user->colocation()->detach($coloc->id);
        $user->save();
        return back();
    }

}
