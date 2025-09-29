/* CADASTRO MODAL */
document.addEventListener('DOMContentLoaded', () => {
    const openBtn = document.getElementById('add-pessoa-btn');
    const closeBtn = document.getElementById('close-pessoa-modal');
    const cancelBtn = document.getElementById('cancel-pessoa');
    const modal = document.getElementById('pessoa-modal');

    openBtn.addEventListener('click', () => modal.classList.remove('hidden'));
    closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
    cancelBtn.addEventListener('click', () => modal.classList.add('hidden'));
});

/* EDITAR MODAL */
document.querySelectorAll('.pessoa-edit').forEach(btn => {
    btn.addEventListener('click', function(){

        const modal = document.getElementById('pessoa-edit-modal');

        modal.querySelector('#pessoa-edit-modal input[name="pes_codigo"]').value = this.dataset.id;
        modal.querySelector('#pessoa-edit-modal input[name="pes_nome"]').value = this.dataset.nome;
        modal.querySelector('#pessoa-edit-modal input[name="pes_cpfpj"]').value = this.dataset.cpfpj;
        modal.querySelector('#pessoa-edit-modal form').action = `/pessoa/${this.dataset.id}`;
        
        modal.classList.remove('hidden');
    });
    document.getElementById('close-pessoa-edit').addEventListener('click', () => {
        document.getElementById('pessoa-edit-modal').classList.add('hidden');
    });
    document.getElementById('cancel-pessoa-edit').addEventListener('click', () => {
        document.getElementById('pessoa-edit-modal').classList.add('hidden');
    });
});

/* DELETE MODAL */
document.querySelectorAll('.pessoa-exclui').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelector('#confirm-exclui form').action = `/pessoa/${this.dataset.id}`;
        document.getElementById('confirm-exclui').classList.remove('hidden');
    });
    document.getElementById('close-pessoa-exclui').addEventListener('click', () => {
        document.getElementById('confirm-exclui').classList.add('hidden');
    });
    document.getElementById('cancel-pessoa-exclui').addEventListener('click', () => {
        document.getElementById('confirm-exclui').classList.add('hidden');
    });
})