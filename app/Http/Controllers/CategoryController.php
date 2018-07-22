<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view("category.list")->with(['categories'=>Category::all()]);
    }

    public function fetchCategories()
    {   
    
        $categories = Category::all();
        
        $data = [];
        foreach($categories as $category){
            $result   = [];
            $result[] = $category->name;
            $result[] = '<a class="btn btn-info" href="{{ route(\'category.edit\',$category->id) }}">Add Message</a>';
            $result[] = '<a class=" btn btn-info" href="{{ route(\'category.show\',$category->id) }}">View Message</a>';

            $result[] = '<button id="delete" href="'.$category->id.'">DELETE</button>';

            $data[]   = $result;
            $x =  response()->json($data);
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
        return view("category.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,["name"=>"required"]);
        $save_category = new Category();
        try {
            $save_category->name = $request->name;
            $save_category->save();
        } catch (\Exception $e) {}
        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('category.show_message')->with(['category'=>Category::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         return view('category.add_message')->with(['category'=>Category::find($id)]);
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
            Category::destroy($id);
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit();
        }
        return back();
    }
}
