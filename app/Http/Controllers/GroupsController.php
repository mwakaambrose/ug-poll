<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Group;
use App\Models\Survey;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::where('user_id', Auth::user()->id)->withCount('respondents')->get();
        return view('groups.index', compact('groups'));
    }

    public function fetchGroups()
    {
        $groups = Group::where('user_id', Auth::user()->id)->withCount('respondents')->get();
        $data = [];
        foreach($groups as $group){
            $result   = [];
            $result[] = '<a href="'.url("/groups", $group->id).'">'.$group->name.'</a>';
            $result[] = $group->respondents_count;
            $result[] = '<a href="'.url("/groups", [$group->id, "edit"]).'" class="text-info-mx-3">Edit Members</a><a href="'.url("/groups", $group->id).'" class="text-success-mx-3">View Details</a>';

            $data[]   = $result;
        }

        $x =  response()->json($data);

        return $x;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required'
        ], ['name.required' => 'The Group field is required.']);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        
        $group = new Group($request->all());
        $save = Auth::user()->groups()->save($group);

        if (!$save) {
            return response()->json(["errors"=>"$request->name creation failed!"]);
        }else {
            return response()->json(["success"=>"Successfully created new survey group called $request->name."]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Group::find($id);
        $group_surveys = Survey::all()->where('group_id',$id);
        $group_surveys_count = Survey::all()->where('group_id',$id)->count();
        if ($group_surveys) {
            return view('groups.show', compact('group_surveys','group','group_surveys_count'));
        }
        return redirect()->back()->with(['status' => "That survey group doesn't exist",'group_surveys_count'=>$group_surveys_count]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::findOrFail($id)->load('respondents');
        if ($group) {
            return view('groups.edit', compact('group'));
        }

        return redirect()->back()->with(['status' => "That survey group doesn't exist"]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Group::destroy($id);
            return redirect('/groups')->with(['status' => 'Group has been Successfully deleted.']); 
        } catch (\Exception $e) {
            return redirect('/groups')->with(['status' => 'This Group already has information about it, You can not delete it.']); 
        }
       
    }
}
