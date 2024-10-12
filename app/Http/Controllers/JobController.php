<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Job,Department,Shift,JobApplication};
use Carbon\Carbon;
class JobController extends Controller
{
    public function __construct(string $title = null) {
        $this->title = 'Jobs';
        view()->share('title',$this->title);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('jobs.index');
    }
    public function getJobs(Request $request)
    {
        $query = Job::where(function($query) use ($request) {
            $query->orWhere('job_title', 'like', "%" . $request->search['value'] . "%");
        });
        
        $total = $query->count();
        $jobs = $query->skip($request->start)->take($request->length)->get(['id','job_title','start_date','end_date']);
        return response()->json([
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $jobs->map(function($job) {
                return [
                    'id' => $job->id,
                    'job_title' => $job->job_title,
                    'start_date' => Carbon::createFromTimestamp($job->start_date)->format('d-M-Y'),
                    'end_date' => Carbon::createFromTimestamp($job->end_date)->format('d-M-Y'),
                    'action' => '<a href="'.route('jobs.edit', $job->id).'" class="btn btn-sm btn-primary">Edit</a>
                    <a href="'.route('job.Applicant', $job->id).'" class="btn btn-sm btn-info">See Applicants</a>' 
                ];
            })
        ]);
    }


    public function jobApplicant($id)
    {
        $jobs = Job::find($id);
        return view('jobs.job_applicants',compact('jobs'));
    }

    public function applicantDetail($id)
    {
        $detail = JobApplication::find($id);
        return view('jobs.applicant_detail',compact('detail'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = null;
        $dept = Department::all();
        $shift = Shift::all();
        return view('jobs.create',compact('data','dept','shift'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'job_title' => 'required',
            'depart_id' => 'required',
            'shift_id' => 'required',
            'description' => 'required',
            'requirement' => 'required'
        ]);

        $job = new Job();
        $job->job_title = $request->input('job_title');
        $job->start_date = Carbon::parse($request->input('start_date'))->timestamp;
        $job->end_date = Carbon::parse($request->input('end_date'))->timestamp;
        $job->branch = $request->input('branch');
        $job->no_of_position = $request->input('no_of_position');
        $job->depart_id = $request->input('depart_id');
        $job->skills = $request->input('skills');
        $job->shift_id = $request->input('shift_id');
        $job->description = $request->input('description');
        $job->requirement = $request->input('requirement');
        $job->save();

        return redirect()->route('jobs.index')->with('success','Job Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Job::find($id);
        $dept = Department::all();
        $shift = Shift::all();
        return view('jobs.create',compact('data','dept','shift'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'job_title' => 'required',
            'depart_id' => 'required',
            'shift_id' => 'required',
            'description' => 'required',
            'requirement' => 'required'
        ]);

        $job = Job::find($id);
        $job->job_title = $request->input('job_title');
        $job->start_date = Carbon::parse($request->input('start_date'))->timestamp;
        $job->end_date = Carbon::parse($request->input('end_date'))->timestamp;
        $job->branch = $request->input('branch');
        $job->no_of_position = $request->input('no_of_position');
        $job->depart_id = $request->input('depart_id');
        $job->skills = $request->input('skills');
        $job->shift_id = $request->input('shift_id');
        $job->description = $request->input('description');
        $job->requirement = $request->input('requirement');
        $job->save();

        return redirect()->route('jobs.index')->with('success','Job Created Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $job = Job::findOrFail($request->id);
        $job->delete();
        return redirect()->route('jobs.index')->with('success','Job Deleted Successfully');
    }
}