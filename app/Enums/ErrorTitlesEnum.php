<?php

namespace App\Enums;

enum ErrorTitlesEnum: string
{
    case ValidationErrorTitle = 'Validation failed';
    case NotFoundErrorTitle = 'Resource not found';
    case NotAllowedMethodErrorTitle = 'Method not allowed';
    case UnexpectedErrorTitle = 'Something went wrong on the server :(';
}
