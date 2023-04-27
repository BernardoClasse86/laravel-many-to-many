@extends('layouts.app')

@section('content')
<div class="container pt-5">

    <div class="container">
        <h1>New Technology</h1>
    </div>

    <div class="container">

        <form action="{{route('technologies.store')}}" method="POST">

            @csrf

            <div class="mb-3">
                <label for="name" class="col-form-label">Technology Name</label>       
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name')}}">
                @error('name')
                    <div class="invalid-feedback mt-2">{{$message}}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Save new Technology</button>

        </form>

    </div>

</div>
@endsection