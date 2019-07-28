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
                                {!! Form::open(['route' => ['groups.destroy', $group->id], 'method' => 'DELETE', 'class' => 'd-inline']) !!}
                                <button class="btn btn-danger py-0" onclick="return confirm('{{ __('Are you sure you want to delete the group?') }}')">{{ __('Delete') }}</button>
                                {!! Form::close() !!}
                            </li>
                        @endforeach
                    </ul>
                @endforeach
                <script>
                    let buttons = $(".js-show-or-hide-groups-btn");
                    buttons.css('text-decoration', 'none');
                    buttons.click(function (e) {
                        e.preventDefault();
                        let list = $("#ulGroups" + this.dataset.typeId);
                        list.toggleClass('d-none');
                        $(this).html(list.hasClass('d-none') ? '{{ __('Show list') }}' : '{{ __('Hide list') }}');
                    });
                </script>
            </div>
        </div>
    </div>
@endsection
