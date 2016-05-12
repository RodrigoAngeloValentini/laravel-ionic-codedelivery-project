<?php

namespace Delivery\Transformers;

use League\Fractal\TransformerAbstract;
use Delivery\Models\User;

/**
 * Class UserTransformer
 * @package namespace Delivery\Transformers;
 */
class UserTransformer extends TransformerAbstract
{

    /**
     * Transform the \User entity
     * @param \User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id'    =>  (int) $model->id,
            'nmae'  =>  $model->name,
            'email' =>  $model->email,
            'role'  =>  $model->role,
        ];
    }
}
