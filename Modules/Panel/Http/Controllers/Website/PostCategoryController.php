<?php

namespace Modules\Panel\Http\Controllers\Website;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

class PostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('panel::pages.web.post-category.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('panel::pages.web.post-category.create');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('panel::pages.web.post-category.edit');
    }
}
