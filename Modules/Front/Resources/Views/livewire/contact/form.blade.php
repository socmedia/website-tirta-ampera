<form class="space-y-6" wire:submit.prevent="handleSubmit">
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <!-- Name -->
        <div>
            <x-front::ui.forms.input id="input-name" name="name" type="text" label="{{ __('front::form.name') }}"
                                     placeholder="{{ __('front::form.enter_full_name') }}" wire:model.defer="name"
                                     required />
        </div>

        <!-- Email -->
        <div>
            <x-front::ui.forms.input id="input-email" name="email" type="email" label="{{ __('front::form.email') }}"
                                     placeholder="{{ __('front::form.enter_email') }}" wire:model.defer="email"
                                     required />
        </div>
    </div>

    <!-- WhatsApp -->
    <div class="max-w-xs">
        <label class="form-label mb-2 block" for="whatsapp_number">{{ __('front::form.whatsapp_number') }}</label>
        <div class="flex flex-row gap-2 md:gap-4">
            <div class="flex-shrink-0" x-data x-init="$store.libphonenumber">
                <select class="form-select bg-sky-50 py-2.5 focus:border-sky-200 focus:bg-sky-100" id="country"
                        name="country" wire:model.lazy="whatsapp_code" required>
                    <template x-for="(country, idx) in $store.libphonenumber.countries"
                              :key="country.countryCode + '-' + idx">
                        <option :value="country.countryCode"
                                x-text="`(${country.countryCode.toUpperCase()}) +${country.phoneCode}`"
                                :selected="$wire.whatsapp_code === country.countryCode">
                        </option>
                    </template>
                </select>
            </div>
            <div class="flex-1">
                <input class="form-input w-full bg-sky-50 focus:border-sky-200 focus:bg-sky-100"
                       id="input-whatsapp-number" name="whatsapp_number" type="text" x-mask="999-9999-99999"
                       placeholder="{{ __('front::form.enter_whatsapp_number') }}"
                       x-on:change="$wire.set('whatsapp_number', `${$el.value.replace(/[-A-Za-z% ,.]/g, '')}`)"
                       wire:model.defer="whatsapp_number" required />
            </div>
        </div>
        @error('whatsapp_number')
            <small class="mt-2 block text-sm text-red-600">{{ $message }}</small>
        @enderror
    </div>

    <!-- Topic (optional) -->
    <div>
        <x-front::ui.forms.input id="input-topic" name="topic" type="text" :label="__('front::form.topic') . ' <small>' . __('front::form.optional') . '</small>'"
                                 placeholder="{{ __('front::form.enter_topic') }}" wire:model.defer="topic" />
    </div>

    <!-- Subject -->
    <div>
        <x-front::ui.forms.input id="input-subject" name="subject" type="text"
                                 label="{{ __('front::form.subject') }}"
                                 placeholder="{{ __('front::form.enter_subject') }}" wire:model.defer="subject"
                                 required />
    </div>

    <!-- Message -->
    <div>
        <x-front::ui.forms.textarea id="input-message" name="message" type="text"
                                    label="{{ __('front::form.message') }}" rows="4"
                                    placeholder="{{ __('front::form.enter_message') }}" wire:model.defer="message"
                                    required />

    </div>

    <p class="text-sm text-neutral-400">{{ __('front::form.all_fields_required_except_topic') }}</p>

    <!-- Submit -->
    <div>
        <x-front::ui.buttons.spinner class="outline-primary" wire:loading.attr="disabled" wire:target="handleSubmit">
            {{ __('front::form.submit') }}
            <i class='bx bx-arrow-right text-lg'></i>
        </x-front::ui.buttons.spinner>
    </div>
</form>
