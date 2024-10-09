<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Job,JobApplication};
class HomeController extends Controller
{
    public function index()
    {
        $jobs = Job::all();
        return view('welcome',compact('jobs'));
    }

    public function jobDetail($id)
    {
        $jobs = Job::find($id);
        return view('job_detail',compact('jobs'));
    }

    public function applyJob($id)
    {
        $jobs = Job::find($id);
        return view('apply_job',compact('jobs'));
    }

    public function submitApplication(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'resume' => 'required'  
        ]);
        $request->request->remove('_token');
        $data = $request->input();
        if ($request->hasFile('profile')) {
            $fileName = time() . '.' . $request->profile->extension();
            $request->profile->move(public_path('uploads/profile'), $fileName);
            $data['profile'] = 'uploads/profile/' . $fileName;
        }

        if ($request->hasFile('resume')) {
            $fileName = time() . '.' . $request->resume->extension();
            $request->resume->move(public_path('uploads/resume'), $fileName);
            $data['resume'] = 'uploads/resume/' . $fileName;
        }
        JobApplication::create($data);
        return redirect()->route('welcome')->with('success','Application Submitted Successfully');
    }
}