<?php

namespace Delivery\Transformers;

use League\Fractal\TransformerAbstract;
use Delivery\Models\Product;

/**
 * Class ProductTransformer
 * @package namespace Delivery\Transformers;
 */
class ProductTransformer extends TransformerAbstract
{

    /**
     * Transform the \Product entity
     * @param \Product $model
     *
     * @return array
     */
    public function transform(Product $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'description' => $model->description,
            'price' => $model->price,
        ];
    }
}
