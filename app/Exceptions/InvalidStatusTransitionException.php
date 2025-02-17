<?php

namespace App\Exceptions;

use Exception;

class InvalidStatusTransitionException extends BusinessLogicException
{
    public function __construct($message = "Invalid status transition", $code = 400)
    {
        parent::__construct($message, $code);
    }
}
