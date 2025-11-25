<?php

namespace Modules\Panel\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvestorFaqCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('panel::pages.web.investor.faq-category.index');
    }
}
