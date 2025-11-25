<?php

namespace Modules\Panel\Http\Controllers\Website;

use Illuminate\Routing\Controller;
use Modules\Common\Models\Content;
use Modules\Common\Models\Category;
use Illuminate\Contracts\Support\Renderable;

class CmsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('panel::pages.web.content.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('panel::pages.web.content.create');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $content = Content::findOrFail($id);
        return view('panel::pages.web.content.edit', [
            'content' => $content,
        ]);
    }
}
