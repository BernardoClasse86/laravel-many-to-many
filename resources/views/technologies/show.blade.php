@extends('layouts.app')

@section('content')

    <div class="container">

        @if(request()->session()->exists('restore_message'))
        <div class="container pt-3">
            <div class="alert fixed alert-success" role="alert">
                {{request()->session()->pull('restore_message')}}
            </div>
        </div>
        @endif
    
        @if((request()->session()->exists('delete_message')))
        <div class="container pt-3">
            <div class="alert fixed alert-warning" role="alert">
                {{request()->session()->pull('delete_message')}}
            </div>
        </div>
        @endif
    
        @if((request()->session()->exists('full_delete_message')))
        <div class="container pt-3">
            <div class="alert fixed alert-danger" role="alert">
                {{request()->session()->pull('full_delete_message')}}
            </div>
        </div>
        @endif
        
    </div>

    <div class="my-container">

        <div class="my-card">

            <div class="my-type-body">

                <div>
                    Technology:
                </div>
    
                <h5 class="work-type py-4">{{$technology->name}}</h5>
    
                <div class="my-row edit">
    
                    <a href="{{route('technologies.edit', $technology)}}" class="btn btn-sm btn-warning">Edit Technology</a>
    
                    @if($technology->trashed())
                        <form action="{{ route('technologies.restore', $technology) }}" method="POST">
                        @csrf
                            <input class="btn btn-sm btn-success" type="submit" value="Ripristina">
                        </form>
                    @endif
    
                </div>
    
                <div class="my-row mt-3">
                    <form action="{{route('technologies.destroy', $technology)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input class="btn btn-sm btn-danger" type="submit" value='Delete'>
                    </form>
                </div>

            </div>

        </div>

    <div>

@endsection