<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UsersRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class UsersController extends Controller
{

    /**
     * @param $name
     * @param $id
     * @return Collection|array|\Illuminate\Support\Collection
     */
    public static function getUsers($name = null, $id = null): Collection|array|\Illuminate\Support\Collection
    {
        return User::query()->when($name, fn ($q, $r) => $q->where('name', 'like', '%' . $r . '%'))
            ->when($id, fn ($q, $r) => $q->where('id', '=', $r))
            ->get()->map(function ($v) {
                $permissions = $v->roles()->get()->map(function ($v) {
                    return $v->permissions()->get()->map(fn ($v) => $v['name']);
                });
                $userRole =  $v->roles()->get()->map(fn ($r) => $r['name']);
                return [
                    'id' => $v['id'],
                    'name' => $v['name'],
                    'permissions' => $permissions,
                    'email' => $v['email'],
                    'type' => $userRole,
                ];
            });
    }

    public function store(UsersRequest $request): JsonResponse
    {
        $data = $request->safe()->except('roles');
        $user = User::query()->create($data);

        $roles = $request->get('roles');
        foreach ($roles as $k => $v)
            if ($v) $user->attachRole($k);

        return response()->json(self::getUsers(null, $user->id));
    }


    public function update(UsersRequest $request, User $id): JsonResponse
    {
        $data = $request->safe()->except(['roles', 'password']);
        $roles = $request->get('roles');
        $roles_id = array();
        foreach ($roles as $k => $v)
            if ($v) $roles_id[] = $k;

        $id->update($data);
        $id->syncRoles($roles_id);
        return response()->json(self::getUsers(null, $id->id));
    }

    public function delete(User $id): JsonResponse
    {
        $id->delete();
        return response()->json('done');
    }
}
