<?php

namespace App\Enums;

enum RoleCode: string
{
    case ADMIN = 'admin';
    case CUSTOMER = 'customer';
    case OPERATION = 'operation';
}
