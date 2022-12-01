<?php

namespace App\Libs;

use Illuminate\Support\Facades\DB;

use App\Models\User;

class AccessControl extends AbstractAccessControl
{
    private $permissions = [];

    public function __construct(User $model)
    {
        parent::__construct($model);

        $this->permissions = $this->getPermissions();
    }

    public function getPermissionGroups()
    {
        $permissions = User::select('permissions.name')
            ->join('categories as permission_groups', 'permission_groups.id', '=', 'users.permission_group_id')
            ->join('permission_group_permissions', 'permission_group_permissions.permission_group_id', '=', 'permission_groups.id')
            ->join('categories as permissions', 'permissions.id', '=', 'permission_group_permissions.permission_id')
            ->where('users.id', $this->model->id)
            ->get();

        return $permissions;
    }

    public function getPermissions()
    {
        // $permissions = DB::table('metas as permission_groups')
        //                     ->join('metas as permissions', 'permission_groups.value', '=', 'permissions.fk_id')
        //                     ->join('categories', 'categories.id', '=', 'permissions.value')

        //                     ->where('permission_groups.table_name', 'users')
        //                     ->where('permission_groups.fk_id', $this->model->id)
        //                     ->where('permission_groups.key', 'permission_group_id')

        //                     ->where('permissions.table_name', 'categories')
        //                     ->where('permissions.key', 'permission_id')

        //                     ->orderBy('categories.name', 'asc')
        //                     ->select('categories.name')
        //                     ->distinct()
        //                     ->get();

        // return $permissions->sortBy('name');
        $permissions = DB::table('categories as permission_groups')
                            ->join('permission_group_permissions', 'permission_group_permissions.permission_group_id', '=', 'permission_groups.id')
                            ->join('categories as permissions', 'permissions.id', '=', 'permission_group_permissions.permission_id')

                            ->where('permission_groups.id', $this->model->permission_group_id)

                            ->orderBy('permissions.name', 'asc')
                            ->select('permissions.name')
                            ->distinct()
                            ->get();

        return $permissions->sortBy('name');
    }

    public function hasAccess($name) : bool
    {
        return !empty($this->permissions->where('name', $name)->first());
    }

    public function hasAccesses($listName) : bool
    {
        $isHasAccess = $this->permissions;

        foreach($listName as $x)
            $isHasAccess->where('name', $x);

        return !empty($isHasAccess);
    }

    public function getUser()
    {
        return $this->getModel();
    }

    public function hasPerson()
    {
        $user = $this->getUser();

        if (empty($user->person_id)) {
            $messages = 'Anda tidak terasosiasi dengan data civitas.';
            self::throwUnauthorizedException($messages);
        }
    }
}
