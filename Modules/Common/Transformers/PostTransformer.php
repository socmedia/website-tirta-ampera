<?php

namespace Modules\Common\Transformers;

use Modules\Common\Transformers\TransformerResult;

class PostTransformer
{
    /**
     * Transform a Post item into an array representation, appending attributes not present in the model.
     *
     * @param mixed $item
     * @return TransformerResult
     */
    public static function transform($item)
    {
        // Append computed attributes (must be defined as accessors in the model)
        $item->append([
            'status_badge',
            'readable_created_at',
            'readable_updated_at',
            'thumbnail_url',
            'category_name',
            'author_name',
            'readable_published_at',
            'readable_archived_at',
            'type_badge',
            'tags_array',
            'is_published',
        ]);

        // Get all columns as array (no translations in posts table)
        $data = collect($item->toArray());

        return new TransformerResult($data->toArray(), $item);
    }
}
