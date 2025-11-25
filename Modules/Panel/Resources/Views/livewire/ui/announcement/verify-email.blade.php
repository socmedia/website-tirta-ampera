<div>
    @if (!$user->hasVerifiedEmail())
        <div class="bg-yellow-300 p-2 text-center text-sm">
            <div class="flex flex-wrap items-center justify-center gap-2">
                <p class="inline-block text-black">
                    Please verify your email address to access all features.
                </p>
                <x-panel::ui.buttons.spinner class="btn-sm inline-flex" type="button" variant="soft-warning"
                                             wire:click="handleSendVerificationEmail"
                                             wire:target="handleSendVerificationEmail">
                    Send Email Verification
                </x-panel::ui.buttons.spinner>
            </div>
        </div>
    @endif
</div>
