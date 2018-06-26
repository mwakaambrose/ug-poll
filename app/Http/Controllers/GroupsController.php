<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Group;
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
        $group = new Group($request->all());
        $group->user_id = Auth::user()->id;

        if (!$group->save()) {
            $status = "Failed to save group. Please check the error messages.";
        } else {
            $status = "Successfully created new survey group called $request->name.";
        }

        return redirect()->back()->with(['status' => $status]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Group::findOrFail($id)->load('respondents');
        if ($group) {
            return view('groups.show', compact('group'));
        }

        return redirect()->back()->with(['status' => "That survey group doesn't exist"]);
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
        Group::destroy($id);
        return redirect('/groups')->with(['status' => 'Group has been Successfully deleted.']);
    }
}
