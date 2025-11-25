<?php

namespace Modules\Panel\Http\Controllers\Website;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\Common\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('panel::pages.web.post.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('panel::pages.web.post.create');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('panel::pages.web.post.edit', [
            'post' => $post,
        ]);
    }
}
