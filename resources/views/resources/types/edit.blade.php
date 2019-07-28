@extends('app')

@section('title', __('Edit type'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <a href="{{ route('types.index') }}">{{ __('Go back') }}</a>
                <h1 class="mt-4">{{ __('Edit type') }}: </h1>
                {!! Form::open(['route' => ['types.update', $type->id], 'method' => 'PUT']) !!}
                <div class="form-group">
                    <label for="title">{{ __('Title') }}:</label>
                    <input type="text" class="form-control" placeholder="{{ __('Title') }}" name="title" value="{{ $type->title }}">
                </div>
                @include('errors')
                <input type="submit" value="{{ __('Edit') }}" class="btn btn-warning">
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
