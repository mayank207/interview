<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use App\Note;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Http\Request;

class HrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $not=Note::where(['user_id'=>Auth::id(),'favourite'=>1])->orderBy('updated_at','desc')->take(3)->get();
        $hrs=User::where('role_id',2)->paginate(5);
        return view('hr.index',compact('hrs','not'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hr.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {

        $hr=new User();
        $hr->name=$request->hrname;
        $hr->email=$request->hremail;
        $hr->password=bcrypt($request->hrpassword);
        $hr->role_id=2;
        $hr->save();
        return response()->json(['success'=>'Hr added successfully']);

    }

    public function updatehr(UpdateUserRequest $request)
    {
        User::findOrFail($request->hrid)->update(['name'=>$request->hrname,'email'=>$request->hremail]);
        return response()->json(['success','Hr Updated Successfully']);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $hrs=User::findorfail($id);
            return response()->json(['success'=>$hrs]);
        } catch (Exception $ex) {
            return response()->json(['success'=>'Something Wrong']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            User::findorfail($id)->delete($id);
            return response()->json(['success'=>'Hr delted successfully']);
        }
        catch(Exception $ex){
            return response()->json(['success'=>'Something Wrong']);
        }
    }

    // Multiple Delete HR
    public function deleteMultipleHrs(Request $request)
    {
        $ids=$request->ids;
        User::whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>'HR deleted successfully']);
    }

    // Search HR
    public function fetch_hr(Request $request)
    {
        if($request->ajax())
        {
            $datas=User::where('role_id',2);
            if(isset($request->search))
            {
                $query = $request->search;
                $query = str_replace(" ", "%", $query);
                $datas->where('name', 'like', '%'.$query.'%')->orWhere('email', 'like', '%'.$query.'%');
            }
            $hrs=$datas->paginate(10);
            return view('hr.hrpagination', compact('hrs'))->render();
        }
    }
}
