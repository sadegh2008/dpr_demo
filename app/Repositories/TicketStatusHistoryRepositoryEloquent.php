<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TicketStatusHistoryRepository;
use App\Entities\TicketStatusHistory;
use App\Validators\TicketStatusHistoryValidator;

/**
 * Class TicketStatusHistoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TicketStatusHistoryRepositoryEloquent extends BaseRepository implements TicketStatusHistoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TicketStatusHistory::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
