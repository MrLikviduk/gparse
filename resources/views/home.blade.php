@extends('app')

@section('title', __('Home'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="alert alert-primary">
                    {{ __('Hello, ') . Auth::user()->name . '! ' . __('Your role(s): ') }} <b>{{ __(Auth::user()->roles()->get()->implode('name', ', ')) }}</b>
                </div>
            </div>
        </div>
    </div>
@endsection
