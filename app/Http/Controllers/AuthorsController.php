<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use Auth;
use Validator;
use Session;
use Illuminate\Support\Facades\Input;
class AuthorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$perPage = 25;
        $authors = Author::latest()->paginate($perPage);
		return view('authors.index',compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('authors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$data  = $request->all();
        // validate
        $rules = [
            'name'  => 'required',
        ];
		$message = [
            'name.required' => 'The Author name must be added'
        ];
        $validator = Validator::make($data, $rules, $message);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator);
        } else {
            // store
            $author = new Author;
            $author->name = $request->name;
            $author->status = $request->status;
            $author->save();

            // redirect
            Session::flash('message', 'Successfully created author!');
			return redirect()->route("authors.index");
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $authors = Author::find($id);
		return view('authors.edit',compact('authors'));
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
        $data  = $request->all();
        // validate
        $rules = [
            'name'  => 'required',
        ];
		$message = [
            'name.required' => 'The Author name must be added'
        ];
        $validator = Validator::make($data, $rules, $message);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator);
        } else {
            // store
            $author = Author::find($id);
            $author->name = $request->name;
            $author->status = $request->status;
            $author->save();

            // redirect
            Session::flash('message', 'Successfully updated author!');
			return redirect()->route("authors.index");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $author = Author::find($id);
        $author->delete();
        // redirect
        Session::flash('message', 'Successfully deleted author!');
			return redirect()->route("authors.index");
    }
}
