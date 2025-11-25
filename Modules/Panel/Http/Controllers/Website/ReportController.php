<?php

namespace Modules\Panel\Http\Controllers\Website;

use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function transaction()
    {
        return view('panel::pages.web.report.transaction');
    }
}
