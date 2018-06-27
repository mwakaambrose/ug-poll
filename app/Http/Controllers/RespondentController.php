<?php

namespace App\Http\Controllers;

use App\Models\Respondent;
use Illuminate\Http\Request;

class RespondentController extends Controller
{

    public function index()
    {
        return view('group.members_list')->with(['respondant' => Respondent::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('group.create_members');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $save_respondant = new Respondent();
        $save_respondant->name = $request->name;
        $phone = $request->phone_number;
        if ($phone[0] == "+") {
            $phone_number = $phone;
        } else if (($phone[0] == "0")) {
            $out = ltrim($phone, "0");
            $phone_number = "+256".$out;
        } else if($phone[0] == "256") {             
            $phone_number="+".$phone;
        }
        else{
           $phone_number=$phone; 
        }

        $save_respondant->phone_number = $phone_number;
        $save_respondant->address = $request->address;
        $save_respondant->gender = $request->gender;
        $save_respondant->email_adress = $request->email_adress;
        $save_respondant->district_id = $request->district_id;
        
        try {
            $save_respondant->save();
            foreach ($request->group as $group_id) {
                try {
                   \DB::table('group_respondent')->insert([['respondent_id' => $save_respondant->id, 'group_id' => $group_id],]);  
                } catch (\Exception $e) {}

            }
        } catch (\Exception $e) {}
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {}

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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {}
}
