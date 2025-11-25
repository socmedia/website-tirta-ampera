<?php

namespace Modules\Panel\Http\Controllers\Website;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\Common\Models\AppSetting;
use Modules\Common\Models\Content;

class SeoController extends Controller
{
    /**
     * Display a listing of the SEO resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel::pages.web.seo.index');
    }

    /**
     * Show the form for creating a new SEO resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel::pages.web.seo.create');
    }

    /**
     * Show the form for editing the specified SEO resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $content = Content::findOrFail($id);
        return view('panel::pages.web.seo.edit', [
            'seo' => $content,
        ]);
    }
}
