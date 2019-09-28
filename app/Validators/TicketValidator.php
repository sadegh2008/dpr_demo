<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class TicketValidator.
 *
 * @package namespace App\Validators;
 */
class TicketValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'title'   => 'required|string|min:3',
            'message' => 'required|string'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'title'   => 'required|string|min:3',
            'message' => 'required|string'
        ],
    ];
}
