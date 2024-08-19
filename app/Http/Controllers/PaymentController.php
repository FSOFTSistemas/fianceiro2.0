<?php

namespace App\Http\Controllers;

use App\Enums\PaymentMethodEnum;
use App\Models\ContasAReceber;
use App\Models\FluxoDeCaixa;
use App\Models\PlanoDeContas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contasAReceber = ContasAReceber::whereMonth('data_vencimento', '<=', Carbon::now()->month)
        ->whereYear('data_vencimento', '<=', Carbon::now()->year)
        ->where('status', 'pendente')
        ->orWhere('status', 'atrasado')
        ->get();
        $paymentMethods = PaymentMethodEnum::cases();
        $accountPlans = PlanoDeContas::all();
        return view('payment.index', ['contasAReceber' => $contasAReceber, 'paymentMethods' => $paymentMethods, 'accountPlans' => $accountPlans]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'payment_id' => ['required', 'numeric'],
            'account_plan_id' => ['required', 'numeric'],
            'payment_method' => ['required', Rule::enum(PaymentMethodEnum::class)]
        ]);
        DB::transaction(function () use ($data) {
            $payment = ContasAReceber::findOrFail($data['payment_id']);
            $payment->update([
                'data_recebimento' => date('Y-m-d'),
                'status' => 'recebido',
            ]);
            FluxoDeCaixa::create([
                'descricao' => $payment->descricao,
                'valor' => $payment->valor,
                'data_transacao' => $payment->data_recebimento,
                'tipo' => 'entrada',
                'plano_contas_id' => $data['account_plan_id']
            ]);
        });
        return Redirect::route('pagamentos.index')->with('success', 'Pagamento efetuado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
