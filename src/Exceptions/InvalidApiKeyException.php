<?php

namespace RiotApiConnector\Exceptions;

use Exception;

class InvalidApiKeyException extends Exception
{
    public function __construct()
    {
        parent::__construct('Your API Key is invalid. Please check if it has expired.', 403);
    }
}
