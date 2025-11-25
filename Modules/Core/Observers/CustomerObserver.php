<?php

namespace Modules\Core\Observers;

use Exception;
use App\Traits\FileService;

use Modules\Core\Models\Customer;

class CustomerObserver
{
    use FileService;

    /**
     * Handle the "created" event for the Customer model.
     *
     * @param  Customer  $customer
     * @return void
     */
    public function created(Customer $customer)
    {
        $log = createLog('customers');
        $log->info('Customer created with email: ' . $customer->email);

        if (!$customer->email_verified_at) {
            try {
                $customer->sendEmailVerificationNotification();
                $log->info('Email verification sent to: ' . $customer->email);
            } catch (Exception $exception) {
                $errorMessage = 'Error sending email verification to: ' . $customer->email . '. Error: ' . $exception->getMessage();
                $log->error($errorMessage);
                session()->flash('failed', $errorMessage);
            }
        }
    }

    /**
     * Handle the "updated" event for the Customer model.
     *
     * @param  Customer  $customer
     * @return void
     */
    public function updated(Customer $customer)
    {
        $log = createLog('customers');
        $log->info('Customer updated with email: ' . $customer->email);

        if ($customer->getOriginal('avatar') !== $customer->avatar) {
            $this->removeImage('images', $customer->getOriginal('avatar'));
        }
    }

    /**
     * Handle the "deleted" event for the Customer model.
     *
     * @param  Customer  $customer
     * @return void
     */
    public function deleted(Customer $customer)
    {
        $log = createLog('customers');
        $log->info('Customer deleted with email: ' . $customer->email);
    }

    /**
     * Handle the "restored" event for the Customer model.
     *
     * @param  Customer  $customer
     * @return void
     */
    public function restored(Customer $customer)
    {
        // Implement logic for restored event if needed
    }

    /**
     * Handle the "force deleted" event for the Customer model.
     *
     * @param  Customer  $customer
     * @return void
     */
    public function forceDeleted(Customer $customer)
    {
        // Implement logic for force deleted event if needed
    }
}
