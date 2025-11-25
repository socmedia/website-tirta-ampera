@props(['destroyId' => ''])
<a class="link-danger" href="javascript:void(0)"
   x-on:click="removeModal = true; $wire.set('destroyId', '{{ $destroyId }}')" {{ $attributes }}>
    Remove
</a>
