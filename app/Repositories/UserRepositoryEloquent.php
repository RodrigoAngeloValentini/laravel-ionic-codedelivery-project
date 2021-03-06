<?php

namespace CodeDelivery\Repositories;

use CodeDelivery\Presenters\UserPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeDelivery\Models\User;

/**
 * Class UserRepositoryEloquent
 * @package namespace CodeDelivery\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    protected $skipPresenter = true;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function lists()
    {
        return $this->model->lists('name','id');
    }

    public function notClients(ClientRepository $clientRepository){

        $clients = $clientRepository->lists();

        $users = $this->model->whereNotIn('id', $clients)->get(['id','name']);
        $lista = [];

        foreach ($users as $user){
            $lista[$user->id] = $user->name;
        }
        return $lista;

    }
    public function presenter()
    {
        return UserPresenter::class;
    }

    public function updateDeviceToken($id, $deviceToken)
    {
        $model = $this->model->find($id);
        $model->device_token = $deviceToken;
        $model->save();
        return $this->parserResult($model);
    }


}
