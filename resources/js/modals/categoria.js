document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('category-modal');
    const openBtn = document.getElementById('add-category-btn');
    const closeBtn = document.getElementById('close-category-modal');
    const cancelBtn = document.getElementById('cancel-category');
    const iconButtons = document.querySelectorAll('button[data-icone]');
    const iconInput = document.getElementById('cat_icone');

    /* Modal Cadastro */
    openBtn.addEventListener('click', () => modal.classList.remove('hidden'));
    closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
    cancelBtn.addEventListener('click', () => modal.classList.add('hidden'));

    iconButtons.forEach(button => {
        button.addEventListener('click', () => {
            if(button.closest('#categoria-edit-modal')) {
                document.querySelector('#categoria-edit-modal input[name="cat_icone"]').value = button.dataset.icone;
            } else {
                iconInput.value = button.dataset.icone;
            }
            iconButtons.forEach(btn => btn.classList.remove('bg-indigo-200'));
            button.classList.add('bg-indigo-200');
        });
    });

    /* Modal Editar */
    document.querySelectorAll('.categoria-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelector('#categoria-edit-modal input[name="cat_codigo"]').value = this.dataset.id;
            document.querySelector('#categoria-edit-modal input[name="cat_nome"]').value = this.dataset.nome;
            document.querySelector('#categoria-edit-modal input[name="cat_icone"]').value = this.dataset.icone;
            document.querySelector('#categoria-edit-modal form').action = `/categorias/${this.dataset.id}`;
            document.getElementById('categoria-edit-modal').classList.remove('hidden');
        });
    });
    document.getElementById('close-categoria-edit').addEventListener('click', () => {
        document.getElementById('categoria-edit-modal').classList.add('hidden');
    });
    document.getElementById('cancel-categoria-edit').addEventListener('click', () => {
        document.getElementById('categoria-edit-modal').classList.add('hidden');
    });

    /* Modal Excluir */
    document.querySelectorAll('.categoria-exclui').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelector('#confirm-exclui form').action = `/categorias/${this.dataset.id}`;
            document.getElementById('confirm-exclui').classList.remove('hidden');
        });
    });
    document.getElementById('close-categoria-exclui').addEventListener('click', () => {
        document.getElementById('confirm-exclui').classList.add('hidden');
    });
    document.getElementById('cancel-categoria-exclui').addEventListener('click', () => {
        document.getElementById('confirm-exclui').classList.add('hidden');
    });
});