@extends('app')

@section('title', __('Types'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1 class="mt-4">{{ __('Type list') }}: </h1>
                <a href="{{ route('types.create') }}">
                    <button class="btn btn-success">{{ __('Add new type') }}</button>
                </a>
                <ul>
                    @foreach($types as $type)
                        <li class="my-3 h3">{{ $type->title }}
                            <a href="{{ route('types.edit', $type->id) }}">
                                <button class="btn btn-warning py-0">{{ __('Edit') }}</button>
                            </a>
                            {!! Form::open(['route' => ['types.destroy', $type->id], 'method' => 'DELETE', 'class' => 'd-inline']) !!}
                            <button class="btn btn-danger py-0" onclick="return confirm('{{ __('Are you sure you want to delete the type?') }}')">{{ __('Delete') }}</button>
                            {!! Form::close() !!}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
