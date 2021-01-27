<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Job;
use App\Note;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $not=Note::where(['user_id'=>Auth::id(),'favourite'=>1])->orderBy('updated_at','desc')->take(3)->get();
        $jobs=Job::with('getTechnology')->orderBy('updated_at','desc')->paginate(10);
        $technology=Technology::all();
        return view('jobs.index',compact('jobs','technology','not'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $technology=Technology::all();
        return view('jobs.create',compact('technology'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJobRequest $request)
    {
        $job=new Job();
        $job->title=$request->title;
        $job->description=$request->jobdescription;
        $job->save();
        $job->getTechnology()->attach($request->technology);
        return response()->json(['success'=>'Job successfully added']);
    }

    public function updatejob(UpdateJobRequest $request)
    {
        $job=Job::updateOrCreate(['id'=>$request->jobid],
        [
            'title'=>$request->title,
            'description'=>$request->jobdescription
        ]);
        $job->getTechnology()->sync($request->technology);
        return response()->json(['success'=>$request->all()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $jobs=Job::with('getTechnology')->findorfail($id);
            $technology=Technology::select('id','tech')->get();
            return response()->json(['success'=>$jobs,'technology'=>$technology]);
        } catch (Exception $ex) {
            return response()->json(['success'=>'Something Wrong']);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        return response()->json(['success'=>'Job is successfully updated']);
        // $this->validate($request,[
        //     'jobtitle'=>"required|min:2|max:50",
        //     'jobdescription'=>"required|min:2|max:200"
        // ]);
        $job=Job::updateOrCreate(['id'=>$id],$request->all());
        $job->getTechnology()->sync($request->jobtechnology);
        return response()->json(['success'=>'Job is successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            Job::findOrFail($id)->delete();
           return response()->json(['success'=>'Job deleted successfully']);
        }
        catch(Exception $ex)
        {
            return response()->json(['success'=>'Something Wrong']);
        }
    }

    public function deleteMultipleJobs(Request $request)
    {
        $ids=$request->ids;
        Job::whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>'Job deleted successfully']);
    }

     /**
     * Search HR
     */


    public function fetch_job(Request $request)
    {
        if($request->ajax())
        {
        $datas=Job::with('getTechnology');
           if($request->search)
           {
               $query = $request->search;
               $query = str_replace(" ", "%", $query);
               $datas->where('title', 'like', '%'.$query.'%');
           }
           $jobs=$datas->paginate(5);
         return view('jobs.jobpagination', compact('jobs'))->render();
        }
    }


}
