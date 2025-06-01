

<div class="modal fade bd-delete-modal-lg" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir Conta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p class="text-danger text-center">Atenção: esta ação não pode ser desfeita!</p>
                <form action="{{ route('delete-contasPagar') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="idContaM" id="idContaM" value="{{ $conta->id }}">
                    <div class="text-center">
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>