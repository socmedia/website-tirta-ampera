<?php

namespace Modules\Front\Livewire\Service;

use App\Traits\WithToast;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Exception;

class PayBill extends Component
{
    use WithToast;

    /**
     * Customer's connection number for billing search.
     *
     * @var string|null
     */
    public $no_sambungan;

    /**
     * Bill data retrieved from the portal API search.
     *
     * @var array|null
     */
    public $billData = null;

    /**
     * Retrieves authentication token from portal API and caches it securely.
     *
     * @return string
     * @throws \Exception
     */
    protected function portalApiToken()
    {
        try {
            $cacheKey = 'portal_api_token';
            $token = Cache::get($cacheKey);

            if (!$token) {
                // Username & password: use from .env or config
                $username = config('services.portal.username', env('PORTAL_API_USERNAME'));
                $password = config('services.portal.password', env('PORTAL_API_PASSWORD'));

                $authUrl = config('app.portal_api_url') . 'customer/login';

                $response = Http::asJson()->post($authUrl, [
                    'identifier' => $username,
                    'password' => $password,
                ]);

                if ($response->successful() && !empty($response['data']['token'])) {
                    $token = $response['data']['token'];
                    // Store token in cache for 1 week (or match token expiry)
                    Cache::put($cacheKey, $token, now()->addWeek());
                } else {
                    throw new Exception('Failed to authenticate portal: ' . $response->json('message'));
                }
            }

            return $token;
        } catch (Exception $e) {
            $this->notifyError($e);
        }
    }

    /**
     * Fetches billing data from the /tagihan/ endpoint on the portal API.
     *
     * @param string $no_sambungan
     * @return array|null
     */
    public function getTagihan($no_sambungan)
    {
        try {
            $token = $this->portalApiToken();
            $url = config('app.portal_api_url') . 'customer/tagihan';

            $response = Http::withToken($token)
                ->acceptJson()
                ->post($url, [
                    'no_sambungan' => $no_sambungan,
                ]);

            if ($response->successful()) {
                return $response->json();
            } else {
                throw new Exception('Failed to fetch billing: ' . $response->json('message'));
            }
        } catch (Exception $e) {
            $this->notifyError($e);
        }
    }

    /**
     * Processes user action for bill checking.
     * Calls getTagihan based on no_sambungan property
     * and fills billData on success.
     *
     * @return void
     */
    public function checkBill()
    {
        try {
            $this->reset('billData');
            if (!$this->no_sambungan) {
                throw new Exception("Connection number is required.");
            }
            $result = $this->getTagihan($this->no_sambungan);
            if ($result) {
                $this->billData = $result;
            }
        } catch (Exception $e) {
            $this->notifyError($e);
        }
    }

    public function render()
    {
        return view('front::livewire.service.pay-bill');
    }
}
