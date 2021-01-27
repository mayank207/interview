<?php

namespace App\Http\Controllers;

use App\Job;
use App\Note;
use App\State;
use Exception;
use App\Policy;
use App\Student;
use Carbon\Carbon;
use App\Technology;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use function PHPUnit\Framework\isEmpty;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_student=Student::count();
        $total_job=Job::count();
        $technology=Technology::get();
        $count=Policy::count();
        $states=State::get();
        $not=Note::where(['user_id'=>Auth::id(),'favourite'=>1])->orderBy('updated_at','desc')->take(3)->get();
        $students=Student::orderBy('updated_at','desc')->take(5)->paginate(5);
        $policy=policy::find(1);
        return view('home',compact('not','total_student','total_job','technology','states','students','count','policy'));
    }

    /**
     * Save Policy
     */
    public function updatepolicy(Request $request, $id)
    {
      try
      {
        $this->validate(
        $request,[
            'title'=>"required|string|max:20",
            'policy_description'=>"required|max:200",
        ]);
        if($request->document==null)
        {
          Policy::where('id',$id)->update([
            'title'=>$request->title,
            'description'=>$request->policy_description,
          ]);
        }
        else{

          $this->validate($request,['document'=>"required|mimes:pdf,xlx,csv,docs,doxs|max:2048"]);
          $fileName = time().'.'.$request->document->extension();
          $request->document->move(public_path('uploads'), $fileName);
           Policy::where('id',$id)->update([
              'title'=>$request->title,
              'description'=>$request->policy_description,
              'document'=>$fileName,
          ]);
        }
        return redirect('home')->with('success','Policy is successfully updated');
      }
      catch(Exception $ex)
      {
           return redirect()->back()->with('alert', 'Try Again');
      }
    }
    public function store(Request $request)
    {
          $this->validate(
              $request,[
              'title'=>"required|max:20",
              'policy_description'=>"required|max:200",
              'document'=>"required|mimes:pdf,xlx,csv,docs,doxs|max:2048"

          ]);

              $policy=new policy();
              $policy->title=$request->title;
              $policy->description=$request->policy_description;

              $fileName = time().'.'.$request->document->extension();
              $request->document->move(public_path('uploads'), $fileName);

              $policy->document=$fileName;

              if($policy->save())
              {
                  return redirect()->route('home')->with('success','Policy Add Successfully');
              }
      }


    // Search Student
    public function searchstudent(Request $request)
    {
      try
      {
        $searchMonth=0;
        $searchYear=0;
        $recent_students=Student::with('getTechnology');
        if(isset($request->technology)){
            $technology=$request->technology;
            $recent_students->whereHas('getTechnology',function($q) use($technology){
                $q->whereIn('id',$technology);
            });
        }
        if(isset($request->expereince)){
          if($request->expereince==0)
          {
              $recent_students->where('fresher',1);
          }
          else
          {
            if($request->expereince==1)
            {
              $recent_students->where(['expereince_year'=>0,'fresher'=>0])->whereBetween('expereince_month',[0,12]);
            }
            else
            {
              $recent_students->whereBetween('expereince_year',[$request->expereince-1,$request->expereince]);
            }
          }
        }

        if(isset($request->status))
        {
            $recent_students->where('state_id',$request->status);
        }
        if(isset($request->date))
        {
            if($request->date==0)
            {
              $recent_students->whereBetween('created_at',[$request->startdate.' 00:00:00',$request->enddate.' 23:59:59']);
            }
            else
            {
              $i=$request->date;
              $recent_students->whereDate('created_at', '>', Carbon::now()->subDays($i))->get();
            }
        }
        $total_student=Student::count();
        $total_job=Job::count();
        $count=Policy::count();
        $technology=Technology::get();
        $states=State::get();
        $policy=policy::find(1);
        $notes=Note::where(['user_id'=>Auth::id(),'favourite'=>1])->orderBy('updated_at','desc')->take(3)->get();
        $searchingVals = [
            'date' => $request['date'],
            'technology'=>$request['technology'],
            'status'=>$request['status'],
            ];
        $students=$recent_students->paginate(5);
        return view('home',compact('notes','total_student','total_job','technology','states','students','searchingVals','count','policy'));
      }
      catch(Exception $ex)
      {
        return redirect()->route('home')->with('danger','Not Found');
      }

    }

//  Policy
    public function fetch()
    {
      $data=Policy::get();
      return response()->json(['success'=>$data]);
    }
    public function update(Request $request)
    {
      if(isset($request->policyid))
      {
          $fileName='';
          if(isset($request->document))
          {
            $fileName = time().'.'.$request->document->extension();
            $request->document->move(public_path('document'), $fileName);
          }
          else
          {
              $fileName=$request->documentname;
          }
        $data=Policy::where('id',$request->policyid)->update([
            'title'=>$request->title,
            'description'=>$request->policy_description,
            'document'=>$fileName,
        ]);
        return Response()->json([
            "success" => 'Privacy policy update successfully'
        ]);
      }
      else
      {
        $policy=new policy();
        $policy->title=$request->title;
        $policy->description=$request->policy_description;

        $fileName = time().'.'.$request->document->extension();
        $request->document->move(public_path('document'), $fileName);

        $policy->document=$fileName;

        $policy->save();
        return Response()->json([
            "success" => "Privacy policy saved successfully"
            ]);
      }
    }




    // Fetch a Technology
    public function technology()
    {
        $technology=Technology::all();
        return response()->json(['technology'=>$technology]);
    }
    // Fetch a State
    public function state()
    {
        $state=State::all();
        return response()->json(['state'=>$state]);
    }
    // Fetch a Student
    public function student(Request $request)
    {
        if($request->ajax())
        {
            $datas=Student::with('getTechnology','getState');
            if(isset($request->technology)){
                $technology=$request->technology;
                $datas->whereHas('getTechnology',function($q) use($technology){
                    $q->whereIn('id',$technology);
                });
            }
           if(isset($request->expereince))
           {

               if($request->expereince==0)
               {
                   $datas->where('fresher',1);
               }
               else
               {
                   if($request->expereince==1)
                   {
                   $datas->where(['expereince_year'=>0,'fresher'=>0])->whereBetween('expereince_month',[0,12]);
                   }
                   else
                   {
                   $datas->whereBetween('expereince_year',[$request->expereince-1,$request->expereince]);
                   }
               }
           }
           if(isset($request->state))
           {
               $datas->where('state_id',$request->state);
           }
           if(isset($request->date))
           {
               if($request->date==0)
               {
                 $datas->whereBetween('created_at',[$request->startdate.' 00:00:00',$request->enddate.' 23:59:59']);
               }
               else
               {
                 $i=$request->date;
                 $datas->whereDate('created_at', '>', Carbon::now()->subDays($i))->get();
               }
           }
           $students=$datas->paginate(5);
         return view('layouts.studentpagination', compact('students'))->render();
        }
       }

       public function deleteMultipleStudents(Request $request)
       {
            $ids=$request->ids;
            Student::whereIn('id',explode(",",$ids))->delete();
            return response()->json(['success'=>'Student deleted successfully']);
       }

}
