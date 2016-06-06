<?php
namespace CodeDelivery\Http\Controllers\Api\Client;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\ProductRepository;

class ClientProductController extends Controller
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function index()
    {
        $products = $this->productRepository->skipPresenter(false)->all();
        return $products;
    }
    public function show($id)
    {
        //['client','items.product','cupom','deliveryman']
        $idUser = Authorizer::getResourceOwnerId();
        return $this->orderRepository
            ->skipPresenter(false)
            ->with($this->whith)
            ->findWhere(['client_id'=>$idUser,'id'=>$id]);
    }
}