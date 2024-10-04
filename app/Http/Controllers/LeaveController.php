<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leaves;

class LeaveController extends Controller
{
    public function allLeaves()
    {
        $leaves = Leaves::where('final_status','pending')->latest()->get();
        return view('leaves.companyleaves',compact('leaves'));
    }
}
