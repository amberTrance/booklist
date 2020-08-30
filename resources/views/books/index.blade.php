@extends('layouts/app')

@section('content')
    <!-- Books list -->
    <div style="margin:50px">
        <!-- Flash message -->
        @if ($flash = session('message'))
        <h4 class="alert alert-success role="alert">
            {{ $flash }}
        </h4>
        @endif
        <!-- Return message if no books have been found -->
        @if (count($books) == 0)
            <h4 class="alert alert-info" role="alert">No books have been found</h4>
        @endif

        <!-- Submit selected categories form -->
        <form action="/books" method="GET" style="display:inline-block">
            @csrf
            <div class="form-group">
                <h4>Select category:</h4>
                <!-- List book categories -->
                <div class="form-check" >
                    @foreach ($categories as $category)
                        @if (!empty($category_ids) && in_array($category->id, $category_ids))
                            <input class="form-check-input" type="checkbox" id="{{ $category->name }}" 
                            name="category_id[]" value="{{ $category->id }}" checked>
                        @else
                            <input class="form-check-input" type="checkbox" id="{{ $category->name }}" 
                            name="category_id[]" value="{{ $category->id }}">
                        @endif                  
                        <label class="form-check-label" for="{{ $category->name }}">
                            {{ $category->name }}
                        </label></br>
                    @endforeach
                </div>
            </div>    
            <!-- Submit categories button -->
            <button type="submit" class="btn btn-secondary" style="margin-bottom:20px">Submit categories</button>
        </form>

        <div style="display:inline-block; float:right; text-align:right">
            <h1>My Books</h1>
            <!-- Add new book button -->
            <div>
                <a href="books/create" class="btn btn-secondary">Add New Book</a>
            </div>
        </div>

        <!-- Book list -->
        <ul class="list-group list-group-flush">
            @foreach ($books as $book)
                <!-- Book title, author, genre, and created at -->
                @if ($book->is_read == 1)
                    <li class="list-group-item" style="padding: 20px; background-color:#9effbe">
                @else
                    <li class="list-group-item" style="padding: 20px; background-color:#f8fca7">
                @endif
                <!-- book image -->
                @if ($book->cover_image != 'noimage.png')
                    <img src="/storage/cover_images/{{ $book->cover_image }}" alt="an image" 
                    style="float:right; border:solid 10px white">
                @endif
                
                <h5 style="display:inline-block; padding:5px">
                    <a href="books/{{ $book->id }}" style="text-decoration:none">Title: {{ $book->title }}</a>
                </h5></br>
                <h6 style="display:inline-block; padding:5px">Author: {{ $book->author }}</h6></br>
                <h6 style="display:inline-block; padding:5px">Genre: {{ $book->category->name }} </h6></br>
                <h6 style="display:inline-block; padding:5px">Created at: {{ $book->created_at }}</h6></br>
                <!-- Edit book button -->
                <a href="books/{{ $book->id }}/edit" style="margin:5px" class="btn btn-outline-secondary">
                    Edit Book Details
                </a>
                <!-- Delete form -->
                <form action="/books/{{ $book->id }}" method="POST" style="display:inline-block">
                    @csrf
                    @method('DELETE')
                    <!-- Delete button -->
                    <button class="btn btn-dark" style="margin:5px">Delete</button>
                </form>
            @endforeach
        </ul>      
    </div>
@endsection