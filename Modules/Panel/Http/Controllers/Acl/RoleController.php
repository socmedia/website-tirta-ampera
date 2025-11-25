<?php

namespace Modules\Panel\Http\Controllers\Acl;

use Modules\Core\Models\Role;
use App\Http\Controllers\Controller;
use Modules\Core\Database\Seeders\RolePermissionSeeder;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel::pages.acl.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel::pages.acl.role.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('panel::pages.acl.role.edit', [
            'role' => $role,
        ]);
    }
}
