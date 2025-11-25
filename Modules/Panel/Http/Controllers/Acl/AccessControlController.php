<?php

namespace Modules\Panel\Http\Controllers\Acl;

use App\Http\Controllers\Controller;

class AccessControlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel::pages.acl.session.index');
    }
}
