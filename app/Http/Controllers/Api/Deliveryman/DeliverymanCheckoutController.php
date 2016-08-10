<?php
namespace CodeDelivery\Http\Controllers\Api\Deliveryman;

use CodeDelivery\Events\GetLocationDeliveryman;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Models\Geo;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class DeliverymanCheckoutController extends Controller
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var OrderService
     */
    private $orderService;
    private $whith = ['client','cupom','items'];
    /**
     * CheckoutController constructor.
     * @param OrderRepository $orderRepository
     * @param UserRepository $userRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(
        OrderRepository $orderRepository,
        UserRepository $userRepository,
        OrderService $orderService
    )
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->orderService = $orderService;
    }
    public function index()
    {
        $id = Authorizer::getResourceOwnerId();
        $orders = $this->orderRepository
            ->skipPresenter(false)
            ->with($this->whith)->scopeQuery(function($query) use ($id){
                return $query->where('user_deliveryman_id','=',$id);
            })->paginate(5);
        return $orders;
    }
    public function show($id)
    {
        $id_deliveryman = Authorizer::getResourceOwnerId();
        return $this->orderRepository
            ->skipPresenter(false)
            ->getByIdAndDeliveryman($id, $id_deliveryman);
    }
    public function updateStatus(Request $request, $id)
    {
        $id_deliveryman = Authorizer::getResourceOwnerId();
        return $this->orderService->updateStatus($id, $id_deliveryman, $request->get('status'));

    }

    public function geo(Request $request, Geo $geo, $id){
        $idDeliveryman = Authorizer::getResourceOwnerId();
        $order = $this->orderRepository->getByIdAndDeliveryman($id,$idDeliveryman);
        $geo->lat = $request->get('lat');
        $geo->long = $request->get('long');
        event(new GetLocationDeliveryman($geo,$order));
        return $geo;
    }
}