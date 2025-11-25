<?php

namespace Modules\Common\Transformers;

use Modules\Common\Models\ContactMessage;
use Modules\Common\Transformers\TransformerResult;

class ContactMessageTransformer
{
    /**
     * Transform a ContactMessage item into an array representation, appending attributes not present in the model.
     *
     * @param ContactMessage $item The ContactMessage item to transform.
     * @return TransformerResult The transformed ContactMessage data as an array.
     */
    public static function transform(ContactMessage $item): TransformerResult
    {
        // Append computed attributes (must be defined as accessors in the model)
        $item->append([
            'whatsapp_formatted',
            'seen_badge',
            'readable_created_at',
            'readable_updated_at',
        ]);

        // Build transformed data from model (includes appended fields)
        $data = collect($item->toArray());

        return new TransformerResult($data->toArray(), $item);
    }
}
