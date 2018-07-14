<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Group;
use App\Models\District;
use App\Models\Respondent;
use Illuminate\Http\Request;
use App\Http\Requests\RespondentStoreRequest;

class RespondentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $respondents = Respondent::with('groups')->get();
        $districts = District::all();
        $groups = Group::where('user_id', Auth::user()->id)->get();

        return view('respondents.index', compact('respondents','districts', 'groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $districts = District::all();
        $groups = Group::where('user_id', Auth::user()->id)->get();
        return view('respondents.create', compact('districts', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RespondentStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RespondentStoreRequest $request)
    {
        /* Original */
        $respondent = new Respondent($request->all());

        $phone = $request->phone_number;

        if ($phone[0] == "0") {
            $core_contact = ltrim($phone, "0");
            $phone_number = "+256".$core_contact;
        } else {
            $phone_number=$phone;
        }
        $respondent->phone_number=$phone_number;

        if (!$respondent->save()) {
            return back()->withErrors()->withInput();
        }

        //link the respondent with a group
        foreach ($request->group as $key => $group_id) {
            $respondent->groups()->attach($group_id);
        }
        return redirect()->back()->with(['status' => 'New Respondent successfully saved.']);
        /* End ORiginal */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $districts = District::all();
        $groups = Group::where('user_id', Auth::user()->id)->get();
        $respondents = Respondent::find($id);
        return view("respondents.edit")->with(compact('respondents','districts','groups'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {}

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RespondentStoreRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RespondentStoreRequest $request, $id)
    {
        $respondents = Respondent::find($id);
        if (!empty($request->district_id)) {
            $respondents->district_id = $request->district_id;
        }
        
        $respondents->name = $request->name;
        $respondents->phone_number = $request->phone_number;
        $respondents->address = $request->address;

        if (!empty($request->gender)) {
           $respondents->gender = $request->gender;
        }
        
        $respondents->email_address = $request->email_address;
        

        if (!empty($request->language)) {
            $respondents->language = $request->language;
        }

        if (!empty($request->level_of_education)) {
             $respondents->level_of_education = $request->level_of_education;
        }

       try {
            $respondents->save();
            echo "Updated";
       } catch (\Exception $e) {
           echo $e->getMessage();
       }

       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {}
}
