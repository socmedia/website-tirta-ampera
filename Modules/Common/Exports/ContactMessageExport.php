<?php

namespace Modules\Common\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ContactMessageExport implements FromView
{
    protected $listing;

    /**
     * Constructor to initialize the listing.
     *
     * @param \Illuminate\Support\Collection $listing
     */
    public function __construct($listing)
    {
        $this->listing = $listing;
    }

    /**
     * Return a view for the export.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        return view('common::exports.contact-messages', [
            'data' => $this->listing,
        ]);
    }
}