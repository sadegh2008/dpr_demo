<?php

namespace App\Repositories;

use App\Entities\User;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
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

    public function allWithRole ($role) {
        return $this->model->hydrate(\DB::select("SELECT U.* FROM users U 
                    INNER JOIN role_user RU ON RU.user_id =  U.id 
                    INNER JOIN roles RO ON RO.id =  RU.role_id 
                WHERE RO.name='$role'"));
    }

}
