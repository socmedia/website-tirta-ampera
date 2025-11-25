@props(['destroyId' => ''])
<a href="javascript:void(0)" x-on:click="removeModal = true; $wire.set('destroyId', '{{ $destroyId }}')"
   {{ $attributes->merge(['class' => 'link-danger']) }}>
    Remove
</a>
