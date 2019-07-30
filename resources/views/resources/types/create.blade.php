@extends('app')

@section('title', __('Add type'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <a href="{{ route('types.index') }}">{{ __('Go back') }}</a>
                <h1 class="mt-4">{{ __('Add new type') }}: </h1>
                {!! Form::open(['route' => 'types.store']) !!}
                <div class="form-group">
                    <label for="title">{{ __('Title') }}:</label>
                    <input type="text" class="form-control" placeholder="{{ __('Title') }}" name="title" value="{{ old('title') }}">
                </div>
                @include('errors')
                <input type="submit" value="{{ __('Add') }}" class="btn btn-success">
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
