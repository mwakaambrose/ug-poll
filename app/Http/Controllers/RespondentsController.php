<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Group;
use App\Models\District;
use App\Models\Respondent;
use Illuminate\Http\Request;
use App\Http\Requests\RespondentStoreRequest;
use App\Http\Requests\StoreRespondentsForm;

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

    public function fetchRespondents()
    {   
        $respondents = Respondent::with('groups')->orderBy('id','DESC')->get();
        $districts = District::all();
        $groups = Group::where('user_id', Auth::user()->id)->get();
        
        $data = [];
        foreach($respondents as $respondent){
            $result   = [];
            $result[] = $respondent->id;
            $result[] = $respondent->name;
            $result[] = $respondent->phone_number;
            $result[] = isset($respondent->language) ? $respondent->language : 'N/A';
            $result[] = isset($respondent->level_of_education) ? $respondent->level_of_education : 'N/A';
            // $result[] = isset($respondent->address) ? $respondent->address : 'N/A';
            $result[] = $respondent->gender;
            $result[] = isset($respondent->email_address) ? $respondent->email_address : 'N/A';
            $result[] = isset($respondent->district) ? $respondent->district->name : 'N/A';

            $fe = [];
            foreach ($respondent->groups as $group) {
                $fe[] = '<a href="'.url("/groups", $group->id).'">'.$group->name.'</a>';
            }
            $result[] = empty($fe) ? 'N/A' : $fe;
            
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
        $districts = District::all();
        $groups = Group::where('user_id', Auth::user()->id)->get();
        return view('respondents.create', compact('districts', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRespondentsForm $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRespondentsForm $form)
    {   
        return $form->persist();
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
