<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Users\PermissionController;
use App\Http\Controllers\Dashboard\Users\RoleController;
use App\Http\Requests\Dashboard\UsersRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public static function getUsers($name = null, $id = null)
    {
        return User::when($name, fn ($q, $r) => $q->where('name', 'like', '%' . $r . '%'))
            ->when($id, fn ($q, $r) => $q->where('id', '=', $r))
            ->get()->map(function ($v) {
                $permissions = $v->roles()->get()->map(function ($v) {
                    return $v->permissions()->get()->map(fn ($v) => $v['name']);
                });
                $userRole =  $v->roles()->get()->map(fn ($r) => $r['name']);
                return [
                    'id' => $v['id'],
                    'name' => $v['name'],
                    'acadimyId' => $v['acadimyId'],
                    'permissions' => $permissions,
                    'email' => $v['email'],
                    'type' => $userRole,
                ];

                return $v;
            });
    }
    public function index()
    {
        return inertia('Dashboard/users', [
            'getData' => self::getUsers(null),
            'roles' => Role::all(),
        ]);
    }

    public function getRecourds(Request $request)
    {
        $title = $request->type;
        $name = $request->get('name') == '' ? null : $request->get('name');
        if ($title == 'users')
            return response()->json([
                'data' => self::getUsers($name),
                'roles' => RoleController::getRole(),
            ]);
        else if ($title == 'role')
            return response()->json([
                'data' => RoleController::getRole(name: $name),
                'roles' => PermissionController::getPermission(),
            ]);
        else
            return response()->json([
                'data' => PermissionController::getPermission($name),
                'roles' => RoleController::getRole(),
            ]);
    }

    public function store(UsersRequest $request)
    {
        $data = $request->safe()->except('roles');
        $user = User::query()->create($data);

        $roles = $request->get('roles');
        foreach ($roles as $k => $v)
            if ($v == true)
                $user->attachRole($k);

        return response()->json(self::getUsers(null, $user->id));
    }


    public function update(UsersRequest $request, User $id)
    {
        $data = $request->safe()->except(['roles', 'password']);
        $roles = $request->get('roles');
        $roles_id = array();
        foreach ($roles as $k => $v)
            if ($v == true) array_push($roles_id, $k);

        $id->update($data);
        $id->syncRoles($roles_id);
        return response()->json(self::getUsers(null, $id->id));
    }

    public function delete(User $id)
    {
        $id->delete();
        return response()->json('done');
    }
}
