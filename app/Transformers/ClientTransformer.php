<?php

namespace Delivery\Transformers;

use Delivery\Models\User;
use League\Fractal\TransformerAbstract;
use Delivery\Models\Client;

/**
 * Class ClientTransformer
 * @package namespace Delivery\Transformers;
 */
class ClientTransformer extends TransformerAbstract
{

    /**
     * Transform the \Client entity
     * @param \Client $model
     *
     * @return array
     */
    public function transform(Client $model)
    {
        return [
            'name'      => $model->user->name,
            'email'     => $model->user->email,
            'phone'     => $model->phone,
            'address'   => $model->address,
            'zipcode'   => $model->zipcode,
            'city'      => $model->city,
            'state'     => $model->state,
        ];
    }
}
