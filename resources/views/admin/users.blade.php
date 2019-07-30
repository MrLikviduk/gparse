@extends('app')

@section('title', __('Users panel'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1>{{ __('User list') }}: </h1>
                @foreach($roles as $role)
                    <h2 class="pt-md-2">{{ ucfirst(Str::plural($role->name)) }}: </h2>
                    <div class="md-form active-cyan-2 mb-3">
                        <input class="form-control" data-role-id="{{ $role->id }}" type="text" placeholder="Search (name or email)" aria-label="Search" onkeyup="tableSearch(this)">
                    </div>
                    <table class="table table-striped" id="tableRole{{ $role->id }}">
                        <thead>
                        <tr>
                            <th scope="col" class="w-25">#</th>
                            <th scope="col" class="w-25">{{ __('Name') }}</th>
                            <th scope="col" class="w-25">{{ __('Email') }}</th>
                            <th scope="col" class="w-25">{{ __('Actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($role->users as $user)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($role->name !== 'admin' && !($role->name === 'co-admin' && !Auth::user()->hasRole('admin')))
                                        @if ($role->name !== 'user')
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalRemoveRole" data-href="{{ route('admin.users.remove-role', [$user->id, $role->id]) }}" data-user-name="{{ $user->name }}" data-role-name="{{ $role->name }}">{{ __('Remove') }}</button>
                                        @endif
                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAddRole" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">{{ __('Add role') }}</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">{{ __('There are no users with this role...') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                @endforeach
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalAddRole">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['route' => 'admin.users.add-role', 'method' => 'PATCH']) !!}
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Add role') }}</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id">
                    <div class="form-group">
                        <label for="type_id">{{ __('Select role for ') }} <span data-username></span>: </label>
                        <select name="role_id" class="form-control">
                            @foreach ($roles as $role)
                                @continue(collect(['user', 'admin'])->contains($role->name) || $role->name === 'co-admin' && !Auth::user()->hasRole('admin'))
                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Add') }}</button>
                </div>
                {!! Form::close() !!}
            </div><!-- /.модальное окно-Содержание -->
        </div><!-- /.модальное окно-диалог -->
    </div><!-- /.модальное окно -->
    <div class="modal fade" id="modalRemoveRole">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['route' => ['admin.users.remove-role', 0, 0], 'method' => 'PATCH']) !!}
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Remove role') }}</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id">
                    <input type="hidden" name="role_id">
                    <p>{{ __('Are you sure you want to remove role ') }} <span data-rolename></span> {{ __(' from ') }} <span data-username></span>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('Remove') }}</button>
                </div>
                {!! Form::close() !!}
            </div><!-- /.модальное окно-Содержание -->
        </div><!-- /.модальное окно-диалог -->
    </div><!-- /.модальное окно -->
    <script>
        let add_role_form = $("#modalAddRole");
        add_role_form.on('show.bs.modal', function (e) {
            let user_id = $(e.relatedTarget).data('userId'), user_name = $(e.relatedTarget).data('userName');
            add_role_form.find('span[data-username]').text(user_name);
            add_role_form.find('input[name=user_id]').val(user_id);
        });

        let remove_role_form = $("#modalRemoveRole");
        remove_role_form.on('show.bs.modal', function (e) {
            let user_name = $(e.relatedTarget).data('userName');
            let role_name = $(e.relatedTarget).data('roleName');
            remove_role_form.find('span[data-username]').text(user_name);
            remove_role_form.find('span[data-rolename]').text(role_name);
            remove_role_form.find('form').attr('action', $(e.relatedTarget).data('href'));
            console.log(remove_role_form.find('form'));
        });

        function tableSearch(input) {
            let role_id = input.dataset.roleId;
            let table = document.getElementById("tableRole" + role_id);
            if (input.value !== '')
                table.classList.remove('table-striped');
            else
                table.classList.add('table-striped');
            let regPhrase = new RegExp(input.value, 'i');
            let flag = false;
            for (let i = 1; i < table.rows.length; i++) {
                flag = false;
                for (let j = table.rows[i].cells.length - 1; j >= 0; j--) {
                    flag = regPhrase.test(table.rows[i].cells[j].innerHTML);
                    if (flag) break;
                }
                if (flag) {
                    table.rows[i].style.display = "";
                } else {
                    table.rows[i].style.display = "none";
                }
            }
        }
    </script>

@endsection
