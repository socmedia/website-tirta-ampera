<?php

namespace Modules\Common\Transformers;

use Modules\Common\Transformers\TransformerResult;

class FaqTransformer
{
    /**
     * Transform a FAQ item into an array representation.
     *
     * @param mixed $item The FAQ item to transform.
     * @return TransformerResult The transformed FAQ data.
     */
    public static function transform($item): TransformerResult
    {
        // Append computed attributes (must be defined as accessors in the model)
        $item->append([
            'status_badge',
            'featured_badge',
            'answer_preview',
            'readable_created_at',
            'readable_updated_at',
        ]);

        // Now build transformed data from model (includes appended fields)
        $data = collect($item->toArray());

        return new TransformerResult($data->toArray(), $item);
    }
}
