@extends('layouts.app')

@section('content')
    <!-- Categories table -->
    <div class="categories">
        <div class="row">
            <div class="col-6">
                Category
            </div>
        </div>
        @foreach($categories as $category)
            <div class="row">
                <div class="col-6">
                    <a href="{{route('categories.show',$category)}}">{{$category->name}}</a>
                </div>
                <div class="col-6">
                    <form class="form-group" action="{{route('categories.destroy',$category)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="btn btn-danger" name="submit">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
        <div class="rom">
            <div class="col-12">
                <form class="input-group" action="{{route('categories.store')}}" method="post">
                    @csrf
                    <input type="text" name="name" placeholder="Category Name">
                    <button type="submit">Save Category</button>
                </form>
            </div>
        </div>
    </div>
@endsection
