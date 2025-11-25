<?php

namespace Modules\Panel\Http\Controllers\Website;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

class AdministratorNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('panel::pages.web.administrator_notification.index');
    }
}
