<?php

namespace App\Enums;

enum PaymentType: string
{
    case CREDIT_CARD = 'CREDIT_CARD';
    case CASH_ON_DELIVERY = 'CASH_ON_DELIVERY';
    case BANK_TRANSFER = 'BANK_TRANSFER';
}