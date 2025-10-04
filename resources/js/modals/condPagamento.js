/* Janela Cadastro */ 
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('condPagamento-modal');
    const openBtn = document.getElementById('add-condPagamento-btn');
    const closeBtn = document.getElementById('close-condPagamento-modal');
    const cancelBtn = document.getElementById('cancel-condPagamento');

    openBtn.addEventListener('click', () => modal.classList.remove('hidden'));
    closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
    cancelBtn.addEventListener('click', () => modal.classList.add('hidden'));
});

/* Janela de Editar */
document.querySelectorAll('.cond-pagamento-edit').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelector('#cond-pagamento-edit-modal input[name="copa_codigo"]').value = this.dataset.id;
        document.querySelector('#cond-pagamento-edit-modal input[name="copa_nome"]').value = this.dataset.nome;
        document.querySelector('#cond-pagamento-edit-modal textarea[name="copa_desc"]').value = this.dataset.desc;
                                   
            document.querySelector('#cond-pagamento-edit-modal form').action = `/condicoesPagamento/${this.dataset.id}`;

        document.getElementById('cond-pagamento-edit-modal').classList.remove('hidden');
    });
});
document.getElementById('close-cond-pagamento-edit').addEventListener('click', function() {
    document.getElementById('cond-pagamento-edit-modal').classList.add('hidden');
});
document.getElementById('cancel-cond-pagamento-edit').addEventListener('click', function() {
    document.getElementById('cond-pagamento-edit-modal').classList.add('hidden');
});

/* Janela Exclui */
document.querySelectorAll('.cond-pagamento-exclui').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;

        document.querySelector('#edit-codigo').value = id;
        
        document.querySelector('#confirm-exclui form').action = `/condicoesPagamento/${id}`;

        document.getElementById('confirm-exclui').classList.remove('hidden');
    });
});
document.getElementById('close-cond-pagamento-exclui').addEventListener('click', function() {
    document.getElementById('confirm-exclui').classList.add('hidden');
});
document.getElementById('cancel-cond-pagamento-edit').addEventListener('click', function() {
    document.getElementById('confirm-exclui').classList.add('hidden');
});