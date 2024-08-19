<?php

namespace App\Enums;

enum PaymentMethodEnum : string {
    case PIX = "pix";
    case BOLETO = "boleto";
    case A_VISTA = "à vista";
    case CARTAO = "cartão";
}
