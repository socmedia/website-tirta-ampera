<?php

namespace Modules\Panel\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Panel\Enums\AccountEnum;
use Modules\Common\Models\AppSetting;

class MainController extends Controller
{
    /**
     * Display the main page of the panel.
     */
    public function index()
    {
        return view('panel::pages.index');
    }

    /**
     * Display the accounting page
     *
     * @return void
     */
    public function accounting()
    {
        return view('panel::pages.index');
    }

    /**
     * Display the human resource page
     *
     * @return void
     */
    public function humanResource()
    {
        return view('panel::pages.index');
    }

    /**
     * Display the access control page
     *
     * @return void
     */
    public function accessControl()
    {
        return view('panel::pages.acl.index');
    }

    /**
     * Display the inventory page
     *
     * @return void
     */
    public function inventory()
    {
        return view('panel::pages.index');
    }

    /**
     * Display the notification page
     *
     * @return void
     */
    public function notification()
    {
        return view('panel::pages.notification');
    }

    /**
     * Display the setting page
     *
     * @return void
     */
    public function setting()
    {
        return view('panel::pages.setting.index');
    }
    /**
     * Display the create setting page
     *
     * @return void
     */
    public function createSetting()
    {
        return view('panel::pages.setting.create');
    }

    /**
     * Display the edit setting page
     *
     * @return void
     */
    public function editSetting(AppSetting $appSetting)
    {
        return view('panel::pages.setting.edit', [
            'setting' => $appSetting
        ]);
    }

    /**
     * Display the account page
     *
     * @return void
     */
    public function account()
    {
        return view('panel::pages.account', [
            'user' => auth('web')->user(),
            'tabs' => AccountEnum::getTabs()
        ]);
    }
}
