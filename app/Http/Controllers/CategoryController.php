<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Categories;

class CategoryController extends Controller

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
     * Show the category tree view.
     *
     * @return \Illuminate\Http\Response
     */
    public function manageCategory()

    {
        return view('categoryTreeview',compact('categories','allCategories'));
    }


    /**
     * Adds category
     *
     * @param  \Illuminate\Http\Request  $request
     * @return view
     */
    public function addCategory(Request $request)

    {

        $this->validate($request, [
            'name_cat' => 'required',
        ]);

        $input = $request->all();
        $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];

        Categories::create($input);

        return back()->with('success', 'Категория создана успешно.');

    }

    public function destroyCategory($id)
    {
        //
    }


}