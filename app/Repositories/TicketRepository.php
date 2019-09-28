<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface TicketRepository.
 *
 * @package namespace App\Repositories;
 */
interface TicketRepository extends RepositoryInterface
{
    public function assignUser($ticket_id, $user_id);
}
