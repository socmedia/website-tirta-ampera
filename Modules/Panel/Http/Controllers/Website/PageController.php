<?php

namespace Modules\Panel\Http\Controllers\Website;

use Modules\Common\Models\Page;
use Modules\Common\Models\Content;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel::pages.web.page.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel::pages.web.page.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Content::findOrFail($id);
        return view('panel::pages.web.page.edit', [
            'page' => $page,
        ]);
    }
}
