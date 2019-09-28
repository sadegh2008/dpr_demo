<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class UserValidator.
 *
 * @package namespace App\Validators;
 */
class UserValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name'     => 'required|string|min:3',
            'family'   => 'nullable|string',
            'password' => 'required|confirmed|min:6',
            'email'    => 'required_without:mobile|email',
            'mobile'   => 'required_without:email|digits:11',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name'     => 'required|string|min:3',
            'family'   => 'nullable|string',
            'password' => 'required|confirmed',
            'email'    => 'required_without:mobile|email',
            'mobile'   => 'required_without:email|digits:11',
        ],
    ];
}
