<?php

namespace App\Enums;

enum ErrorMessagesEnum: string
{
    case MethodNotAllowed = 'The method is not allowed';
    case UnexpectedError = 'Something went wrong on the server, please try again later';
}
