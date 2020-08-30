<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Book;
use App\User;
use App\Category;

class BooksController extends Controller
{   
    
    public $bookRequirements = [
        'title' => 'required',
        'author' => 'required',
        'description' => 'required',
        'cover_image' => 'image|nullable|max:1999',
        'category_id' => 'required'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get categories from user input
        $category_ids = $request->input('category_id');
        // Get categories
        $categories = Category::all();
         // Get user
        $user_id = auth()->user()->id;
        
        // Filters the books by user and category
        if (!empty($category_ids)) {
            $books = Book::where('user_id','=', $user_id)->whereIn('category_id', $category_ids)->get()->sortByDesc('updated_at');
        } else {
            $books = Book::where('user_id','=', $user_id)->get()->sortByDesc('updated_at');
        }

        // Return view; pass variables to the view
        return view('books/index')->with('books', $books)->with('categories', $categories)->with('category_ids', $category_ids);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $categories = Category::all();

        return view('books/create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $requestvag
     */
    public function store(Request $request)
    {
        // Validate and save logic from  form + redirect
        $this->validate($request, $this->bookRequirements);

        // Handle File Upload
        if ($request->hasFile('cover_image')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.png';
        }

        // Create Book
        $book = new Book();

        $book->title = $request->input('title');
        $book->author = $request->input('author');
        $book->description = $request->input('description');
        $book->is_read = $request->input('is_read');
        $book->user_id = auth()->user()->id;
        $book->category_id = $request->input('category_id');
        $book->cover_image = $fileNameToStore;

        $book->save();

        // Flash succes message
        session()->flash('message','Your book has been created');

        return redirect('books');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Retrieve record from database and pass it to the view
        $book = Book::findOrFail($id);

        return view('books/show', ['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // Retrieve record from database and pass it to the view
        $book = Book::findOrFail($id);
        $categories = Category::all();

        return view('books/edit')->with('book', $book)->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        // Validate and save logic from "Edit" form + redirect
        $this->validate($request, $this->bookRequirements);

        // Handle File Upload
        if ($request->hasFile('cover_image')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }

        $book = Book::findOrFail($id);
        // Update book
        $book->title = $request->input('title');
        $book->author = $request->input('author');
        $book->description = $request->input('description');
        $book->is_read = $request->input('is_read');
        $book->category_id = $request->input('category_id');

        if ($request->hasFile('cover_image')) {
            $book->cover_image = $fileNameToStore;
        }

        $book->save();

        // Flash succes message
        session()->flash('message','Your book details have been updated');
        return redirect('books');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete logic + redirect
        $book = Book::findOrFail($id);
        $book->delete();

        // Flash book deleted message
        session()->flash('message','Your book has been deleted');

        return redirect('books');
    }
}