<?php

namespace App\Http\Controllers;

use App\Repositories\TicketMessageRepository;
use App\Traits\TraitBaseController;
use App\Validators\TicketValidator;
use Illuminate\Http\Request;

class TicketMessageController extends Controller
{
    use TraitBaseController;

    public function __construct (TicketMessageRepository $repo, TicketValidator $ticketValidator) {
        $this->repository = $repo;
        $this->validator = $ticketValidator;
    }
}
