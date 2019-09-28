<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TicketMessageRepository;
use App\Entities\TicketMessage;
use App\Validators\TicketMessageValidator;

/**
 * Class TicketMessageRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TicketMessageRepositoryEloquent extends BaseRepository implements TicketMessageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TicketMessage::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
