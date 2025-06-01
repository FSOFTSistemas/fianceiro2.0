<div class="modal fade" id="exampleModal-{{ $conta->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('contasApagar.pagar', $conta->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-success">
                    <h5 class="modal-title fw-bold" id="pagarModalLabel">
                        💰 Informar Pagamento
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="data_pagamento" class="col-form-label">Data do Pagamento</label>
                        <input type="date" name="data_pagamento" id="data_pagamento" class="form-control"
                            value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="valor" class="col-form-label">Message:</label>
                        <input type="number" name="valor" id="valor" class="form-control" step="0.01"
                            value="{{ number_format($conta->valor, 2, '.', '') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">💾 Salvar Pagamento</button>
                </div>
            </form>
        </div>
    </div>
</div>
