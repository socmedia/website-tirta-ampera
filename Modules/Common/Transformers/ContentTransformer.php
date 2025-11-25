<?php

namespace Modules\Common\Transformers;

use Modules\Common\Models\Content;
use Modules\Common\Transformers\TransformerResult;

class ContentTransformer
{
    /**
     * Transform a Content item into an array representation, appending attributes not present in the model.
     *
     * @param Content $item The Content item to transform.
     * @return TransformerResult The transformed Content data as an array.
     */
    public static function transform(Content $item): TransformerResult
    {
        // Append computed attributes (must be defined as accessors in the model)
        $item->append([
            'display_key',
            'formatted_meta',
            'readable_created_at',
            'readable_updated_at',
        ]);

        // Just use the model's data (translations no longer exist)
        $data = collect($item->toArray());

        return new TransformerResult($data->toArray(), $item);
    }
}
