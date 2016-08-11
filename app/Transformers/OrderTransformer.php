<?php

namespace CodeDelivery\Transformers;
use Illuminate\Database\Eloquent\Collection;
use League\Fractal\TransformerAbstract;
use CodeDelivery\Models\Order;

/**
 * Class OrderTransformer
 * @package namespace CodeDelivery\Transformers;
 */
class OrderTransformer extends TransformerAbstract
{
    protected $availableIncludes= ['items','cupom','client','deliveryman'];
    /**
     * Transform the \Order entity
     * @param \Order $model
     *
     * @return array
     */
    public function transform(Order $model)
    {
        return [
            'id'        =>(int)$model->id,
            'total'      => (float) $model->total,
            'status'     => $model->status,
            'hash' => $model->hash,
            'product_names' => $this->getArrayProductNames($model->items),
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    protected function getArrayProductNames(Collection $items){
        $names = [];
        foreach($items as $item){
            $names[] = $item->product->name;
        }
        return $names;
    }

    public function includeClient(Order $model)
    {
        return $this->item($model->client, new ClientTransformer());
    }
    public function includeCupom(Order $model)
    {
        if(!$model->cupom){
            return null;
        }
        return $this->item($model->cupom, new CupomTransformer());
    }
    public function includeItems(Order $model)
    {
        return $this->collection($model->items, new OrderItemTransformer());
    }
    public function includeDeliveryman(Order $model)
    {
        if(!$model->deliveryman) {
            return null;
        }
        return $this->item($model->deliveryman, new DeliverymanTransformer());
    }
}
