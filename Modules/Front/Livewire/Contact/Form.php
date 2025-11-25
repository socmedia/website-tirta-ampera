<?php

namespace Modules\Front\Livewire\Contact;

use Exception;
use Livewire\Component;
use App\Traits\WithToast;
use Illuminate\Support\Facades\Cache;
use Modules\Common\Services\ContactMessageService;

class Form extends Component
{
    use WithToast;

    /**
     * The name of the user submitting the contact form.
     *
     * @var string|null
     */
    public $name;

    /**
     * The email address of the user submitting the contact form.
     *
     * @var string|null
     */
    public $email;

    /**
     * The WhatsApp country code of the user.
     *
     * @var string|null
     */
    public $whatsapp_code = 'id';

    /**
     * The WhatsApp number of the user.
     *
     * @var string|null
     */
    public $whatsapp_number;

    /**
     * The topic of the contact message (optional).
     *
     * @var string|null
     */
    public $topic;

    /**
     * The subject of the contact message.
     *
     * @var string|null
     */
    public $subject;

    /**
     * The message content from the user.
     *
     * @var string|null
     */
    public $message;

    /**
     * Get the validation rules for the contact form.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp_code' => [
                'required',
                'max:3', // e.g. 'ID', 'JPN"
            ],
            'whatsapp_number' => 'required|string|max:20',
            'topic' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ];
    }

    /**
     * Handle the submission of the contact form.
     *
     * @return void
     */
    public function handleSubmit()
    {
        $ip = request()->ip();
        $key = 'contact_form_submitted:' . $ip;
        $limitSeconds = 60; // 1 minute, adjust as needed

        // Check if user has already submitted recently
        if (cache()->has($key)) {
            return $this->notifyError(new Exception(__('front::form.submit_too_soon')));
        }

        $this->validate();

        $service = new ContactMessageService();

        try {
            $service->create([
                'name' => $this->name,
                'email' => $this->email,
                'whatsapp_code' => $this->whatsapp_code,
                'whatsapp_number' => $this->whatsapp_number,
                'topic' => $this->topic,
                'subject' => $this->subject,
                'message' => $this->message,
            ]);
            $this->reset(['name', 'email', 'whatsapp_code', 'whatsapp_number', 'topic', 'subject', 'message']);

            // Set rate limiter after successful submission
            cache()->put($key, now()->timestamp, $limitSeconds);

            $this->notifySuccess(__('front::form.submit_success'));
        } catch (\Throwable $e) {
            $this->notifyError($e);
        }
    }

    /**
     * Render the contact form view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('front::livewire.contact.form');
    }
}
