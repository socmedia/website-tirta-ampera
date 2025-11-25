<?php

namespace Modules\Core\Traits\Adapters;

use Jenssegers\Agent\Agent;
use Carbon\Carbon;

trait SessionAdapters
{
    /**
     * Generate badges indicating the session's operating system, device type, browser, and IP address.
     * Display the information as badges.
     *
     * @return string
     */
    public function sessionInfoBadges()
    {
        $agent = $this->getBrowserInfo();
        $isDesktop = $agent['isDesktop'] ? 'desktop' : 'mobile';

        $os_badge = '<span class="badge soft-primary">' . $agent['platform'] . '</span>';
        $device_type_badge = '<span class="badge soft-primary"><i class="bx bx-' . $isDesktop . '"></i>' . $agent['device'] . '</span>';
        $browser_badge = '<span class="badge soft-primary"><i class="bx bx-globe"></i>' . $agent['browser'] . ' (' . $agent['version'] . ')</span>';
        $ip_address_badge = '<span class="badge soft-primary"><i class="bx bx-globe"></i>' . $agent['ip_address'] . '</span>';

        return $os_badge . $device_type_badge . $browser_badge . $ip_address_badge;
    }

    /**
     * Get browser information
     *
     * @return array
     */
    public function getBrowserInfo()
    {
        $agent = new Agent();
        $agent->setUserAgent($this->user_agent);
        $browser = $agent->browser();

        return [
            'platform' => $agent->platform(),
            'device' => $agent->device(),
            'browser' => $browser,
            'version' => $agent->version($browser),
            'isDesktop' => $agent->isDesktop(),
            'ip_address' => $this->ip_address,
        ];
    }

    /**
     * Get formatted last activity
     *
     * @return string
     */
    public function getLastActivity()
    {
        return Carbon::parse($this->last_activity)->format('d M, Y. H:i');
    }

    /**
     * Get user name associated with the session
     *
     * @return string|null
     */
    public function getUserName()
    {
        return $this->user?->name;
    }

    /**
     * Get session payload
     *
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }
}