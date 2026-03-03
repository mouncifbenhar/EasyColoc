<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Colocation;
use Illuminate\Http\Request;

class ControllerCategories extends Controller
{
    public function create_Category(Request $request ,Colocation $coloc){
     

        $incomingFields = $request->validate([
            'title' => 'required',
        ]);

      Category::create([
             'colocation_id' => $coloc->id,
             'title' => $incomingFields['title']
       ]);
       return redirect()->back();
    }
}
