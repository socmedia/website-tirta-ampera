<?php

namespace Modules\Core\Observers;

use Exception;
use App\Traits\FileService;

use Modules\Core\Models\Vendor;

class VendorObserver
{
    use FileService;

    /**
     * Handle the "created" event for the Vendor model.
     *
     * @param  Vendor  $vendor
     * @return void
     */
    public function created(Vendor $vendor)
    {
        $log = createLog('vendors');
        $log->info('Vendor created with email: ' . $vendor->email);

        if (!$vendor->email_verified_at) {
            try {
                $vendor->sendEmailVerificationNotification();
                $log->info('Email verification sent to: ' . $vendor->email);
            } catch (Exception $exception) {
                $errorMessage = 'Error sending email verification to: ' . $vendor->email . '. Error: ' . $exception->getMessage();
                $log->error($errorMessage);
                session()->flash('failed', $errorMessage);
            }
        }
    }

    /**
     * Handle the "updated" event for the Vendor model.
     *
     * @param  Vendor  $vendor
     * @return void
     */
    public function updated(Vendor $vendor)
    {
        $log = createLog('vendors');
        $log->info('Vendor updated with email: ' . $vendor->email);

        if ($vendor->getOriginal('avatar') !== $vendor->avatar) {
            $this->removeImage('images', $vendor->getOriginal('avatar'));
        }
    }

    /**
     * Handle the "deleted" event for the Vendor model.
     *
     * @param  Vendor  $vendor
     * @return void
     */
    public function deleted(Vendor $vendor)
    {
        $log = createLog('vendors');
        $log->info('Vendor deleted with email: ' . $vendor->email);
    }

    /**
     * Handle the "restored" event for the Vendor model.
     *
     * @param  Vendor  $vendor
     * @return void
     */
    public function restored(Vendor $vendor)
    {
        // Implement logic for restored event if needed
    }

    /**
     * Handle the "force deleted" event for the Vendor model.
     *
     * @param  Vendor  $vendor
     * @return void
     */
    public function forceDeleted(Vendor $vendor)
    {
        // Implement logic for force deleted event if needed
    }
}
