@extends('layouts.app')

@section('content')

    {{-- alert messages --}}

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

    {{-- page titles --}}

    @if(request('trashed'))

        <div class="container py-4 text-center">

            <h1 class="main-title">This is the Bin</h1>

        </div>

    @else 

        <div class="container py-4 text-center">

            <h1 class="main-title">Welcome {{Auth::user()->name}}! These are your Technologies</h1>

        </div>

    @endif

    {{-- page buttons --}}

    <div class="container-xxl pt-3 d-flex flex-row-reverse gap-2">

        @if(request('trashed'))

            <a class="btn btn-light" href="{{route('technologies.index')}}">All Technologies</a>

        @else

        <a class="btn btn-warning" href="{{route('technologies.index', ['trashed'=> true])}}">Bin ({{$trashed_num}})</a>

        @endif

        <a class="btn btn-primary" href="{{route('technologies.create')}}">Add a new Technology</a>

    </div>

    {{-- page-datas --}}

    <div class="container-xxl mt-5">

        <table class="table table-bordered fs-6">

            <thead class="text-center">

                <tr>

                    <th>id</th>
                    <th>name</th>
                    <th>technology link</th>
                    <th>technology edit</th>
                    <th>technology delete</th>
                    <th>technology restore</th>

                </tr>

            </thead>

            <tbody>

                @forelse ($technologies as $technology)

                <tr>

                    <td>{{$technology->id}}</td>
                    <td>{{$technology->name}}</td>
                    <td><a class="btn btn-sm btn-secondary" href="{{route('technologies.show', $technology)}}">Technology Link</a></td>
                    <td><a class="btn btn-sm btn-warning" href="{{route('technologies.edit', $technology)}}">Edit technology</a></td>
                    <td>
                        <form action="{{route('technologies.destroy', $technology)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input class="btn btn-sm btn-danger" type="submit" value='Delete'>
                        </form>
                    </td>
                    
                    <td>
                        @if ($technology->trashed())
                        <form action="{{route('technologies.restore', $technology)}}" method="POST">
                            @csrf
                            <input class="btn btn-sm btn-success" type="submit" value='Restore'>
                        </form>
                        @endif
                    </td>
                </tr>

                @empty

                    @if (count($technologies) == 0 && request('trashed'))

                        <div class="container text-center pb-4">
                            <h2 class="bin-title">The Bin is Empty</h2>
                        </div>

                    @else

                        <div class="container text-center pb-4">
                            <h2 class="new-project-title">There are no work Technologies here, please make a new one.</h2>
                        </div>

                        <div class="container text-center pb-4">
                            <a class="btn btn-success" href="{{route('technologies.create')}}">Add a new Technology</a>
                        </div>

                    @endif
                        
                @endforelse

            </tbody>

        </table>

    </div>

@endsection