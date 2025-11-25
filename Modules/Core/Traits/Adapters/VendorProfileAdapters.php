<?php

namespace Modules\Core\Traits\Adapters;

trait VendorProfileAdapters
{
    /**
     * Get the full address of the vendor.
     *
     * @param boolean $as_array Whether to return the address as an array.
     * @return string|array The full address as a string or an array if $as_array is true.
     */
    public function getFullAddress($as_array = false)
    {
        $address = [
            'address' => $this->address,
            'village' => $this->village ? 'Ds. ' . $this->village->name : null,
            'district' => $this->district ? 'Kec. ' . $this->district->name : null,
            'regency' => $this->regency ? $this->regency->name : null,
            'province' => $this->province ? $this->province->name : null,
        ];

        if ($as_array) {
            $address['postal_code'] = $this->postal_code;
            return $address;
        }

        return implode(', ', array_filter($address)) . ($this->postal_code ? ' ' . $this->postal_code : null) . '.';
    }

    /**
     * Get the vendor's phone number.
     *
     * @return string|null The formatted phone number or null if not available.
     */
    public function getPhone()
    {
        return $this->phone_number ? phone($this->phone_number, $this->phone_code) : null;
    }

    /**
     * Get the vendor's WhatsApp number.
     *
     * @return string|null The formatted WhatsApp number or null if not available.
     */
    public function getWhatsapp()
    {
        return $this->whatsapp_number ? phone($this->whatsapp_number, $this->whatsapp_code) : null;
    }
}
