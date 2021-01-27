<?php

namespace App\Http\Controllers;

use App\Note;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use Illuminate\Support\Facades\Validator;

class NotesController extends Controller
{
    private $favorite_limit=3;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $not=Note::where(['user_id'=>Auth::id(),'favourite'=>1])->orderBy('updated_at','desc')->take(3)->get();
        $notes=Note::where('user_id',Auth::id())->orderBy('updated_at','desc')->paginate(10);
        return view('notes.index',compact('notes','not'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNoteRequest $request)
    {
        $favourite=0;
        if(isset($request->favouritenote))
        {
            if($this->availableFavorite())
            {
                return response()->json(['danger'=>'Only 3 Notes is available in favourite']);
            }
            else
            {
                $favourite=1;
            }
        }
        else
        {
            $favourite=0;
        }
        $note=new Note();
        $note->title=$request->notetitle;
        $note->description=$request->description;
        $note->favourite=$favourite;
        $note->user_id=Auth::id();
        $note->save();
        return response()->json(['success'=>'Note successfully added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $notes=Note::where('user_id',Auth::id())->findorfail($id);
            return response()->json(['success'=>$notes]);
        } catch (Exception $ex) {
            return response()->json(['success'=>'Something Wrong']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */

    public function updatenote(UpdateNoteRequest $request)
    {
        $favourite=0;
        if(isset($request->favouritenote))
        {
            if($this->availableFavorite())
            {
                return response()->json(['danger'=>'Only 3 Notes is available in favourite']);
            }
            else
            {
                $favourite=1;
            }
        }
        else
        {
            $favourite=0;
        }
        $note=Note::find($request->noteid);
        $note->title=$request->notetitle;
        $note->description=$request->description;
        $note->favourite=$favourite;
        $note->save();
        return response()->json(['success'=>'Note update successfully']);
    }

    public function update(Request $request, $id)
    {
        // $this->validate($request,
        // [
        //     'title'=>"required|min:2|max:10",
        //     'description'=>"required|min:2|max:25",
        // ]);

        //     $note=Note::find($id);
        //     $note->title=$request->title;
        //     $note->description=$request->description;
        //     $note->save();
        //     return redirect()->route('notes.index')->with(['success'=>'note is successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try
        {
            Note::where(['id'=>$id,'user_id'=>Auth::id()])->delete($id);
            return response()->json(['success'=>'Note deleted successfully']);
        }
        catch(Exception $ex)
        {
            return response()->json(['success'=>'Something Wrong']);
        }
    }

    /**
     *
     * Multiple Delete Notes
     */
    public function deleteMultipleNotes(Request $request)
    {
        $ids=$request->ids;
        Note::whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>'Note deleted successfully']);
    }

    /**
     * Add or Remove favourite Note
     */
    public function notefavourite(Request $request)
    {
        $limit=3;
        try
        {
            if($request->current=="check"){
                $countFavourite=Note::where(['user_id'=>Auth::id(),'favourite'=>1])->count();
                if($countFavourite==$limit)
                {
                    return response()->json([
                        'danger' => 'Only 3 Notes is available in favourite'
                    ]);
                }
                else
                {
                    Note::find($request->noteid)->update(['favourite'=>1]);

                }
            }
            if($request->current=="uncheck"){
                Note::find($request->noteid)->update(['favourite'=>0]);
                return response()->json([
                    'success' => 'Notes removed successfully!'
                            ]);
            }
            else
            {
            return response()->json([
                'success' => 'Notes added favourite successfully!'
            ]);
            }

        }
        catch(Exception $ex)
        {
            return response()->json([
                'danger' => 'Something Wrong!'
            ]);
        }
    }


    // Check favourite is available
    public function availableFavorite()
    {
        $countFavourite=Note::where(['user_id'=>Auth::id(),'favourite'=>1])->count();
        return $countFavourite==$this->favorite_limit ? true : false;
    }

     /**
     * Search Note
     */
    public function fetch_note(Request $request)
    {
        if($request->ajax())
        {
        $datas=Note::where('user_id',Auth::id())->orderBy('updated_at','desc');
           if($request->search)
           {
               $query = $request->search;
               $query = str_replace(" ", "%", $query);
               $datas->where('title', 'like', '%'.$query.'%');
           }
           $notes=$datas->paginate(10);
         return view('notes.notepagination', compact('notes'))->render();
        }
    }
}