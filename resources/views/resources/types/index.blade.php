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
                            <button class="btn btn-danger py-0" data-type-title="{{ $type->title }}" data-toggle="modal" data-target="#modalDeleteType" data-href="{{ route('types.destroy', [$type->id]) }}">{{ __('Delete') }}</button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalDeleteType">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['method' => 'DELETE']) !!}
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Delete type') }}</h4>
                </div>
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to delete type') }} <span data-typetitle></span>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                </div>
                {!! Form::close() !!}
            </div><!-- /.модальное окно-Содержание -->
        </div><!-- /.модальное окно-диалог -->
    </div>
    <script>
        let remove_type_form = $("#modalDeleteType");
        remove_type_form.on('show.bs.modal', function (e) {
            let type_title = $(e.relatedTarget).data('typeTitle');
            remove_type_form.find('span[data-typetitle]').text(type_title);
            remove_type_form.find('form').attr('action', $(e.relatedTarget).data('href'));
        });
    </script>
@endsection
