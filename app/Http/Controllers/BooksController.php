<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Tag;
use App\Models\Author;
use App\Models\Review;
use Auth;
use Validator;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$perPage = 25;
        $books = Book::latest()->paginate($perPage);
		return view('books.index',compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		
		$tags = Tag::pluck('name', 'id')->toArray();
		$authors = Author::pluck('name', 'id')->toArray();
		array_unshift($tags , '...Please select...');
		array_unshift($authors , '...Please select...');
        return view('books.create',compact(['tags','authors']));
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
            'author_id'  => 'required|not_in:0',
            "tag"    => "required|array|min:1",
			"tag.*"  => "required|min:1|not_in:0",
        ];
		$message = [
            'author_id.required' => 'Author must be added',
            'author_id.not_in' => 'Author must be added',
            'name.required' => 'The Book name must be added',
            'name.not_in' => 'The Book name must be added',
            'tag.*.required' => 'Tag must be selected'
        ];
        $validator = Validator::make($data, $rules, $message);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator);
        } else {
            $Book = new Book;
            $Book->name = $request->name;
            $Book->author_id = $request->author_id;
			$Book->save();
			$book_id = $Book->id;
			$tag_arr = $request->tag;
			foreach($tag_arr as $tag_val)
			{
				$tag_book_arr = array();
				$tag_book_arr['tag_id'] = $tag_val;
				$tag_book_arr['book_id'] = $book_id;
				DB::table('book_tag')->insert($tag_book_arr);
				
			}
            

            // redirect
            Session::flash('message', 'Successfully created Book!');
			return redirect()->route("books.index");
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
    public function review($id)
    {
        $books = Book::find($id);
		return view('books.review',compact(['books']));
    }
	 public function addreview(Request $request,$id)
    {
		$data  = $request->all();
        // validate
        $rules = [
            'rating'  => 'required|min:1|not_in:0',
            'comment'  => 'required',
        ];
		$message = [
            'rating.required' => 'Rating must be added',
            'comment.required' => 'Comment must be added',
        ];
        $validator = Validator::make($data, $rules, $message);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator);
        } else {
            $review = new Review;
            $review->rating = $request->rating;
            $review->comment = $request->comment;
            $review->book_id = $id;
            $review->user_id = Auth::user()->id;
			$review->save();
			
            Session::flash('message', 'Successfully added Book Review!');
			return redirect()->route("books.index");
        }
    }
	public function edit($id)
    {
        $books = Book::find($id);
		$tags = Tag::pluck('name', 'id')->toArray();
		$authors = Author::pluck('name', 'id')->toArray();
		array_unshift($tags , '...Please select...');
		array_unshift($authors , '...Please select...');
		return view('books.edit',compact(['tags','authors','books']));
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
            'author_id'  => 'required|not_in:0',
            "tag"    => "required|array|min:1",
			"tag.*"  => "required|min:1|not_in:0",
        ];
		$message = [
            'author_id.required' => 'Author must be added',
            'author_id.not_in' => 'Author must be added',
            'name.required' => 'The Book name must be added',
            'name.not_in' => 'The Book name must be added',
            'tag.*.required' => 'Tag must be selected'
        ];
        $validator = Validator::make($data, $rules, $message);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator);
        } else {
            $Book = Book::find($id);
            $Book->name = $request->name;
            $Book->author_id = $request->author_id;
			$Book->save();
			$book_id = $Book->id;
			$tag_arr = $request->tag;
			DB::table('book_tag')->where('book_id', $book_id)->delete();
			foreach($tag_arr as $tag_val)
			{
				$tag_book_arr = array();
				$tag_book_arr['tag_id'] = $tag_val;
				$tag_book_arr['book_id'] = $book_id;
				DB::table('book_tag')->insert($tag_book_arr);
				
			}
            // redirect
            Session::flash('message', 'Successfully created Book!');
			return redirect()->route("books.index");
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
        $Book = Book::find($id);
        $Book->delete();
        // redirect
        Session::flash('message', 'Successfully deleted Book!');
			return redirect()->route("books.index");
    }
}
