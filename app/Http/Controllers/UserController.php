<?php

namespace App\Http\Controllers;

use App\User;
use App\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\UserFormRequest;

class UserController extends Controller
{
    public function viewprofile()
    {
        $not=Note::where(['user_id'=>Auth::id(),'favourite'=>1])->orderBy('updated_at','desc')->take(3)->get();
        return view('users.profile',compact('not'));
    }
    public function updateprofile(Request $request)
    {
        $not=Note::where(['user_id'=>Auth::id(),'favourite'=>1])->orderBy('updated_at','desc')->take(3)->get();
        $imagename=$request->hiddenimage;
        $user_id = Auth::id();
        $image = $request->file('profile');
        if($image!='')
        {
            $this->validate($request,[
                'name' => 'min:2',
                'email' => 'unique:users,email,'.$user_id.'|email',
                'profile' => 'mimes:jpeg,jpg,png,gif|required|max:10000'
            ]);
            $image = $request->file('profile');
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/image/profile');
            $image->move($destinationPath, $imagename);
        }
        else
        {
            $this->validate($request,[
                'name' => 'min:2',
                'email' => 'unique:users,email,'.$user_id.'|email',
            ]);
        }
        $user = User::findOrFail(Auth::id());
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->profile_pictures=$imagename;
        $user->save();
        return redirect()->route('profile.show',compact('not'))->with('success', 'User has been updated!');

    }
    public function password()
    {
        $not=Note::where(['user_id'=>Auth::id(),'favourite'=>1])->orderBy('updated_at','desc')->take(3)->get();
        return view('users.password',compact('not'));
    }
    public function update(Request $request)
    {

        $this->validate(
            $request,[
            'Password' => ['required','string','same:Confirm-Password','min:8','max:20','regex:/[a-z]/',
            'regex:/[A-Z]/',
            'regex:/[a-z]/',
            'regex:/[0-9]/',
            'regex:/[@$!%*#?&]/'],
            'Confirm-Password'=>"required"
        ]);

		$done=User::find(auth()->user()->id)->update(['password'=> Hash::make($request->Password)]);
        if($done){
            return redirect()->route('home')->with('success','password Updated Successfully');
        }
        else
        {
            return redirect()->route('home')->with('danger','Try Again Latter');
        }
    }
}
