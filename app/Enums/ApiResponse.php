<?php

namespace App\Enums;

enum ApiResponse: string
{
    case SUCCESS_STATUS = 'Success';
    case FAILED_STATUS = 'Failed';

    case SUCCESS_MESSAGE = 'Request succeeded';
    case FAILED_MESSAGE = 'Request failed';
}
