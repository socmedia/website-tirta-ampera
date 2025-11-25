<?php

namespace Modules\Panel\Http\Controllers\Website;

use Modules\Common\Models\Faq;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Stichoza\GoogleTranslate\GoogleTranslate;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('panel::pages.web.faq.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('panel::pages.web.faq.create');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        return view('panel::pages.web.faq.edit', [
            'faq' => $faq,
        ]);
    }
}
