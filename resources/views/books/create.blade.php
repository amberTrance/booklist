@extends('layouts/app')

@section('content')
    <!-- Create book form -->
    <form action="/books" method="POST" enctype="multipart/form-data" 
    style="max-width:800px; margin-top:50px" class="mx-auto">
        @csrf
        <!-- Author -->
        <div class="form-group ">
            <label for="author">Author</label>
            <input type="text" class="form-control" id="author" name="author" placeholder="author" required>
        </div>
        <!-- Title -->
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="title" required>
        </div>
        <!-- Description -->
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>
            </textarea>
        </div>
        <!-- Select field with book category -->
        <select class="browser-default custom-select" name="category_id" required>
            <option selected value="">Select a book category</option>
            <!-- Book categories -->
            @foreach ($categories as $category)
                <option name="category_id[]" value="{{ $category->id }}">
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <!-- Radio-buttons for read status -->
        <label for="is_read" style="margin-top:20px">Read</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="is_read" id="yes" value="1" checked>
            <label class="form-check-label" for="yes">Yes</label>
        </div>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="is_read" id="no" value="0">
            <label class="form-check-label" for="no">No</label>
        </div>
        <!-- Upload image input field -->
        <div style="margin-top:20px;">
            <label for="cover_image">Select an image for your book</label></br>
            <input type="file" id="cover_image" name="cover_image">
        </div>
        <!-- Submit book button -->
        <button type="submit" class="btn btn-dark" style="margin:20px 20px 20px 0px;">
            Submit Book
        </button>
        <!-- Go back button -->
        <a href="/books" class="btn btn-secondary">Go back</a>
    </form>
@endsection