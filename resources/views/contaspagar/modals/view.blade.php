<div class="modal fade" id="modal-view-{{ $conta->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title">Detalhes do Membro</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="text-center mb-4">
                    <h3 class="text-primary">{{ $conta->fornecedor }}</h3>
                    <p>
                        @if ($conta->status == 'pago')
                            <span class="badge bg-success">Pago</span>
                        @else
                            <span class="badge bg-warning text-dark">Pendente</span>
                        @endif
                    </p>
                </div>

                <fieldset class="border rounded p-3 mb-3">
                    <legend class="w-auto px-2 text-muted">Informações da Conta</legend>
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Descrição:</dt>
                        <dd class="col-sm-8">{{ $conta->descricao ?? 'Não informado' }}</dd>

                        <dt class="col-sm-4">Valor:</dt>
                        <dd class="col-sm-8">R$ {{ number_format($conta->valor, 2, ',', '.') }}</dd>

                        <dt class="col-sm-4">Vencimento:</dt>
                        <dd class="col-sm-8">
                            {{ $conta->data_vencimento ? \Carbon\Carbon::parse($conta->data_vencimento)->format('d/m/Y') : 'Não informado' }}
                        </dd>

                        <dt class="col-sm-4">Pagamento:</dt>
                        <dd class="col-sm-8">
                            {{ $conta->data_pagamento ? \Carbon\Carbon::parse($conta->data_pagamento)->format('d/m/Y') : 'Não informado' }}
                        </dd>
                    </dl>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" data-bs-toggle="modal"
                    data-bs-target="#modal-edit-{{ $conta->id }}">Editar</button>
            </div>
        </div>
    </div>
</div>
