/* Alterar Senha */
document.getElementById('alterar-senha').addEventListener('click', function() {
    document.getElementById('alterar-senha-modal').classList.remove('hidden');
});
document.getElementById('closed-alterar-senha-modal').addEventListener('click', function() {
    document.getElementById('alterar-senha-modal').classList.add('hidden');
});
document.getElementById('cancel-alterar-senha-modal').addEventListener('click', function() {
    document.getElementById('alterar-senha-modal').classList.add('hidden');
});

/* Editar Usuario */
document.getElementById('editarUser').addEventListener('click', function() {
    document.getElementById('usuario-modal').classList.remove('hidden');
});
document.getElementById('closed-usuario-modal').addEventListener('click', function() {
    document.getElementById('usuario-modal').classList.add('hidden');
});
document.getElementById('cancel-usuario-modal').addEventListener('click', function() {
    document.getElementById('usuario-modal').classList.add('hidden');
});