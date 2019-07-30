@extends ('app')

@section('title', __('Groups'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1 class="mt-4">{{ __('Group list') }}:</h1>
                @include('errors')
                @foreach($types as $type)
                    <h3 style="margin-top: 30px">{{ $type->title }}:</h3>
                    {!! Form::open(['route' => 'groups.store']) !!}
                    <input type="hidden" name="type_id" value="{{ $type->id }}">
                    <input type="text" name="id_vk" class="form-control my-1" placeholder="{{ __('Insert link to group') }}">
                    <input type="submit" value="{{ __('Add') }}" class="btn btn-success my-1">
                    @if ($type->groups->isNotEmpty())
                        <button class="btn btn-link js-show-or-hide-groups-btn" data-type-id="{{ $type->id }}">{{ __('Show list') }}</button>
                    @endif
                    {!! Form::close() !!}
                    <ul class="d-none" id="ulGroups{{ $type->id }}">
                        @foreach($type->groups as $group)
                            <li class="my-2">
                                <a href="https://vk.com/club{{ $group->id_vk }}" target="_blank">
                                    {{ $group->name }}
                                </a>
                                <button class="btn btn-danger py-0" data-group-name="{{ $group->name }}" data-toggle="modal" data-target="#modalDeleteGroup" data-href="{{ route('groups.destroy', [$group->id]) }}">{{ __('Delete') }}</button>
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalDeleteGroup">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['method' => 'DELETE']) !!}
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Delete group') }}</h4>
                </div>
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to delete group') }} <span data-groupname></span>?</p>
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
        let remove_group_form = $("#modalDeleteGroup");
        remove_group_form.on('show.bs.modal', function (e) {
            let group_name = $(e.relatedTarget).data('groupName');
            remove_group_form.find('span[data-groupname]').text(group_name);
            remove_group_form.find('form').attr('action', $(e.relatedTarget).data('href'));
        });

        let buttons = $(".js-show-or-hide-groups-btn");
        buttons.css('text-decoration', 'none');
        buttons.click(function (e) {
            e.preventDefault();
            let list = $("#ulGroups" + this.dataset.typeId);
            list.toggleClass('d-none');
            $(this).html(list.hasClass('d-none') ? '{{ __('Show list') }}' : '{{ __('Hide list') }}');
        });
    </script>
@endsection
