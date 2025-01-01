<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Utils\FormatCpfCnpj;

class AccessControlController extends Controller
{

    public function getSignatureStatus($customer_cnpj_cpf)
    {
        $customer_cnpj_cpf = FormatCpfCnpj::format($customer_cnpj_cpf);
        $customer = Cliente::where('cpf_cnpj', $customer_cnpj_cpf)->first();
        if (isset($customer) && $customer->situacao == 'Ativa') {
            $installments = $customer->installments;
            $expiredInstallments = $installments->where('status', 'atrasado');
            if (count($expiredInstallments) > 0) {
                $due = [
                    'expires' => true,
                    'expired_on' => $expiredInstallments->first()->data_vencimento
                ];
                $value = $expiredInstallments->first()->valor;
            } else {
                $due = [
                    'expires' => false,
                    'expires_in' => $installments->where('status', 'pendente')->first()->data_vencimento
                ];
                $value = $installments->where('status', 'pendente')->first()->valor;
            }
            return response()->json(['customer' => $customer->nome_fantasia, 'due' => $due, 'value' => $value], 200);
        }
        return response()->json(['message' => 'Cliente não encontrado ou inativo para cobrança!'], 404);
    }

    public function getPaymentHistory($customer_cnpj_cpf)
    {
        $customer_cnpj_cpf = FormatCpfCnpj::format($customer_cnpj_cpf);
        $customer = Cliente::where('cpf_cnpj', $customer_cnpj_cpf)->first();
        if (isset($customer) && $customer->situacao == 'Ativa') {
            $installmentsPaid = $customer->installments->where('status', 'recebido');
            return response()->json(['payments' => $installmentsPaid], 200);
        }
        return response()->json(['message' => 'Cliente não encontrado ou inativo para cobrança!'], 404);
    }

}
