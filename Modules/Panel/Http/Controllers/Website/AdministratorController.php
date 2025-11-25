<?php

namespace Modules\Panel\Http\Controllers\Website;

use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;

class AdministratorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('panel::pages.web.index');
    }
}
