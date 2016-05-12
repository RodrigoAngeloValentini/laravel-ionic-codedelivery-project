<?php

namespace Delivery\Transformers;

use League\Fractal\TransformerAbstract;
use Delivery\Models\User as Deliveryman;

/**
 * Class DeliverymanTransformer
 * @package namespace Delivery\Transformers;
 */
class DeliverymanTransformer extends TransformerAbstract
{

    /**
     * Transform the \Deliveryman entity
     * @param \Deliveryman $model
     *
     * @return array
     */
    public function transform(Deliveryman $model)
    {
        return [
            'id'         => (int) $model->id,
            'name'=>$model->name,
            'email'=>$model->email,
        ];
    }
}
