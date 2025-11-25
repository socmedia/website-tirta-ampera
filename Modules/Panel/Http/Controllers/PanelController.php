<?php

namespace Modules\Panel\Http\Controllers;

use App\Http\Controllers\Controller;

class PanelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('panel::index');
    }
}
