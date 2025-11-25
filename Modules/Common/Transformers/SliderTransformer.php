<?php

namespace Modules\Common\Transformers;

use Modules\Common\Transformers\TransformerResult;

class SliderTransformer
{
    /**
     * Transform a slider item into an array representation.
     *
     * @param mixed $item The slider item to transform.
     * @return TransformerResult The transformed slider data.
     */
    public static function transform($item)
    {
        // Append computed attributes (must be defined as accessors in the model)
        $item->append([
            'status_badge',
            'type_badge',
            'readable_created_at',
            'readable_updated_at',
            'thumbnail',
        ]);

        // Build transformed data from model (includes appended fields)
        $data = collect($item->toArray());

        return new TransformerResult($data->toArray(), $item);
    }
}
