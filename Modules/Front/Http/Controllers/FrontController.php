<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Common\Services\PostService;

class FrontController extends Controller
{
    /**
     * Show the homepage.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('front::pages.index');
    }

    /**
     * Show the about page.
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('front::pages.about');
    }

    /**
     * Show the main service page.
     *
     * @return \Illuminate\View\View
     */
    public function service()
    {
        return view('front::pages.service.index');
    }

    /**
     * Show the "Bayar Tagihan" service page.
     *
     * @return \Illuminate\View\View
     */
    public function servicePayBill()
    {
        return view('front::pages.service.pay-bill');
    }

    /**
     * Show the "Pindah Meter" service page.
     *
     * @return \Illuminate\View\View
     */
    public function serviceMoveMeter()
    {
        return view('front::pages.service.move-meter');
    }

    /**
     * Show the "Ganti Stop Kran" service page.
     *
     * @return \Illuminate\View\View
     */
    public function serviceReplaceStopValve()
    {
        return view('front::pages.service.replace-stop-valve');
    }

    /**
     * Show the "Balik Nama" service page.
     *
     * @return \Illuminate\View\View
     */
    public function serviceChangeName()
    {
        return view('front::pages.service.change-name');
    }

    /**
     * Show the "Buka Kembali" service page.
     *
     * @return \Illuminate\View\View
     */
    public function serviceReconnect()
    {
        return view('front::pages.service.reconnect');
    }

    /**
     * Show the "Tutup Sementara" service page.
     *
     * @return \Illuminate\View\View
     */
    public function serviceTemporaryDisconnect()
    {
        return view('front::pages.service.temporary-disconnect');
    }

    /**
     * Show the customer info "Hak dan Kewajiban" page.
     *
     * @return \Illuminate\View\View
     */
    public function customerInfoRightsObligations()
    {
        return view('front::pages.customer-info.rights-obligations');
    }

    /**
     * Show the customer info "Larangan" page.
     *
     * @return \Illuminate\View\View
     */
    public function customerInfoProhibitions()
    {
        return view('front::pages.customer-info.prohibitions');
    }

    /**
     * Show the customer info "Golongan" page.
     *
     * @return \Illuminate\View\View
     */
    public function customerInfoGroups()
    {
        return view('front::pages.customer-info.groups');
    }

    /**
     * Show the customer info "Tarif" page.
     *
     * @return \Illuminate\View\View
     */
    public function customerInfoTariff()
    {
        return view('front::pages.customer-info.tariff');
    }

    /**
     * Show the customer info "Info Gangguan" page.
     *
     * @return \Illuminate\View\View
     */
    public function customerInfoDisturbanceInfo()
    {
        return view('front::pages.customer-info.disturbance-info');
    }

    /**
     * Show the news listing page.
     *
     * @return \Illuminate\View\View
     */
    public function news()
    {
        return view('front::pages.news');
    }

    /**
     * Show the news detail page.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function newsDetail($slug)
    {
        $news = (new PostService)->findPublicBySlug($slug);

        return view('front::pages.show-news', [
            'news' => $news
        ]);
    }

    /**
     * Show the contact page.
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        return view('front::pages.contact');
    }

    /**
     * Show the terms and conditions page.
     *
     * @return \Illuminate\View\View
     */
    public function tnc()
    {
        return view('front::pages.tnc');
    }

    /**
     * Show the privacy policy page.
     *
     * @return \Illuminate\View\View
     */
    public function privacyPolicy()
    {
        return view('front::pages.privacy-policy');
    }
}
