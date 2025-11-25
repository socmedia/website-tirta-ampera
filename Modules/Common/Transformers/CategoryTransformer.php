<?php

namespace Modules\Common\Transformers;

use Illuminate\Support\Collection;
use Modules\Common\Models\Category;
use Modules\Common\Transformers\TransformerResult;

class CategoryTransformer
{
    /**
     * Transform a Category item into a collection representation, appending attributes not present in the model.
     *
     * @param Category $item The Category item to transform.
     * @return TransformerResult The transformed Category data as a collection.
     */
    public static function transform(Category $item): TransformerResult
    {
        // Append computed attributes (must be defined as accessors in the model)
        $item->append([
            'status_badge',
            'featured_badge',
            'group_badge',
            'readable_created_at',
            'readable_updated_at',
            'image_url',
        ]);

        // Columns now follow the structure in the migrations: no translations
        $data = collect($item->toArray());

        return new TransformerResult($data->toArray(), $item);
    }
}
