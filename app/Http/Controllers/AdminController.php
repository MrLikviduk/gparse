<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function usersPanelIndex()
    {
        return view('admin.users', [
            'roles' => Role::with('users')->get()
        ]);
    }

    public function usersPanelAddRole(Request $request)
    {
        $role = Role::findById($request->get('role_id'));
        $user = User::find($request->get('user_id'));
        if ($role->name === 'co-admin' && !Auth::user()->hasRole('admin') || $role->name === 'admin')
            return redirect()->route('admin.users.index');
        $user->assignRole($role);
        return redirect()->route('admin.users.index');
    }

    public function usersPanelRemoveRole(User $user, Role $role)
    {
        if ($role->name === 'admin' || $role->name === 'co-admin' && !Auth::user()->hasRole('admin'))
            return redirect()->route('admin.users.index');
        $user->removeRole($role);
        return redirect()->route('admin.users.index');
    }
}
