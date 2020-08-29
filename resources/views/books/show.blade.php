@extends('layouts/app')

@section('content')
    <!-- Card book display -->
    <div class="card border-success mx-auto" style="max-width:50rem; margin:20px;">
        <!-- Author -->
        <h5 class="card-header text-white bg-success">
            <i>Author: {{ $book->author }}</i>
        </h5>
        <div class="card-body text-success">
            <!-- Book title -->
            <h5 class="card-title">{{ $book->title }}</h5>
            <!-- Book description -->
            <p class="card-text">{{ $book->description }}</p>
        </div>
        <!-- Is read book status -->
        <div class="card-footer bg-transparent border-success">
            @if ($book->is_read)
                <div> Read Status: Yes</div>
            @else
                <div> Read Status: No</div>
            @endif
        </div>
        <!-- Book category -->
        <div class="card-footer bg-transparent border-success">
            Category: {{ $book->category->name }}
        </div>
        <!-- Book image -->
        <img src="/storage/cover_images/{{ $book->cover_image }}" alt="an image" class="mx-auto">
        <!-- Buttons group -->
        <div class="btn-group mx-auto" style="padding:20px">
            <!-- Go back button -->
            <a href="/books" class="btn btn-success" role="button">Go back</a>
            <!-- Edit book button -->
            <a href="{{ $book->id }}/edit" class="btn btn-outline-secondary" role="button">
                Edit Book Details
            </a>
            <!-- Delete book form -->
            <form action="/books/{{ $book->id }}" method="POST">
                @csrf
                @method('DELETE')
                <!-- Delete button -->
                <button class="btn btn-secondary">Delete</button>
            </form>
        </div>
    </div>
@endsection