/* Janela de Cadastro */
document.getElementById('movb_categoria').addEventListener('change', function(){
    let extraDiv = document.getElementById('extra-div');
    if (this.value === "10") {
        extraDiv.classList.remove('hidden');
    } else {
        extraDiv.classList.add('hidden');
    }
});

document.getElementById('movb_forma').addEventListener('change', function(){
    let parcelas = document.getElementById('parcelasExtrato');
    if (this.value === "19") {
        parcelas.classList.remove('hidden');
    } else {
        parcelas.classList.add('hidden');
    }
})

document.getElementById('add-transacoes-btn').addEventListener('click', function() {
    document.getElementById('transacoes-modal').classList.remove('hidden');
});
document.getElementById('close-transacoes-modal').addEventListener('click', function() {
    document.getElementById('transacoes-modal').classList.add('hidden');
});
document.getElementById('cancel-transacoes').addEventListener('click', function() {
    document.getElementById('transacoes-modal').classList.add('hidden');
});

/* Janela de Editar */  
document.querySelectorAll('.edit-transacao-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        
        document.querySelector('#transacoes-edit input[name="movb_codigo"]').value = this.dataset.id;
        document.querySelector('#transacoes-edit input[name="movb_valortotal"]').value = this.dataset.valortotal;
        document.querySelector('#transacoes-edit input[name="movb_valorliquido"]').value = this.dataset.valorliquido;
        document.querySelector('#transacoes-edit input[name="movb_pessoa_atual"]').value = this.dataset.pessoa;
        document.querySelector('#transacoes-edit select[name="movb_situacao"]').value = this.dataset.situacao;
        document.querySelector('#transacoes-edit select[name="movb_categoria"]').value = this.dataset.categoria;
        document.querySelector('#transacoes-edit input[name="movb_datavenc"]').value = this.dataset.datavenc;
        document.querySelector('#transacoes-edit input[name="movb_databaixa"]').value = this.dataset.databaixa;
        document.querySelector('#transacoes-edit select[name="movb_forma"]').value = this.dataset.forma;
        document.querySelector('#transacoes-edit select[name="movb_natureza"]').value = this.dataset.natureza;
        document.querySelector('#transacoes-edit textarea[name="movb_observ"]').value = this.dataset.observ;
        document.querySelector('#transacoes-edit select[name="movb_parcelas"]').value = this.dataset.parcela;
        
        const dateBaixa = document.querySelector('#transacoes-edit input[name="movb_databaixa"]');
        if (this.dataset.parcela >= 2) {
            dateBaixa.readOnly = true;
            dateBaixa.classList.add("bg-gray-100", "cursor-not-allowed");
        }

        document.querySelector('#transacoes-edit form').action = `/extrato/${this.dataset.id}`;

        document.getElementById('transacoes-edit').classList.remove('hidden');
    });
});

document.getElementById('close-transacoes-edit').addEventListener('click', function() {
    document.getElementById('transacoes-edit').classList.add('hidden');
});
document.getElementById('cancel-transacoes-edit').addEventListener('click', function() {
    document.getElementById('transacoes-edit').classList.add('hidden');
});

/* Janela Exclui */
document.querySelectorAll('.add-transacoes-exclui').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;

        document.querySelector('#edit-codigo').value = id;
        
        document.querySelector('#confirm-exclui form').action = `/extrato/${id}`;

        document.getElementById('confirm-exclui').classList.remove('hidden');
    });
});
document.getElementById('close-transacoe-exclui').addEventListener('click', function() {
    document.getElementById('confirm-exclui').classList.add('hidden');
});
document.getElementById('cancel-transacoes-exclui').addEventListener('click', function() {
    document.getElementById('confirm-exclui').classList.add('hidden');
});

/* Janela Parcelamento*/
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.parcelamento').forEach(btn => {
        btn.addEventListener('click', function() {
            const movId = this.dataset.id; 
            const modal = document.getElementById('parcelamento-modal');
            const codigoSpan = modal.querySelector('#codigo-mov');
            const hiddenInput = modal.querySelector('input[name="movb_codigo"]');
            const parcelasLista = modal.querySelector('#parcelas-lista');

            hiddenInput.value = movId;
            codigoSpan.textContent = movId;

            parcelasLista.innerHTML = '';

            carregarParcelas(movId);

            modal.classList.remove('hidden');
        });
    });
    document.getElementById('close-parcelamento').addEventListener('click', () => {
        document.getElementById('parcelamento-modal').classList.add('hidden');
    });

    document.getElementById('cancel-parcelamento-btn').addEventListener('click', () => {
        document.getElementById('parcelamento-modal').classList.add('hidden');
    });
});    

function carregarParcelas(movb_codigo) {
    fetch(`/parcelamento/${movb_codigo}`)
        .then(res => res.json())
        .then(data => {
            const parcelasLista = document.querySelector('#parcelamento-modal #parcelas-lista');
            parcelasLista.innerHTML = '';

            if (data.parcelas && data.parcelas.length > 0) {
                data.parcelas.forEach(par => {
                    parcelasLista.innerHTML += `
                        <div class="flex justify-between p-2 border-b">
                            <span>Parcela: ${par.par_numero}/${par.par_qtnumero ?? ''}</span>
                            <span>R$ ${parseFloat(par.par_valor).toFixed(2).replace('.', ',')}</span>
                            <span>${new Date(par.par_datavenc).toLocaleDateString('pt-BR')}</span>
                            <span class="${par.par_situacao === 'Pendente' ? 'text-yellow-800' : 'text-green-800'}">
                                ${par.par_situacao ?? 'Pendente'}
                            </span>
                            <button type="button" 
                                class="edit-parcelamento-btn px-3 py-1 border rounded-lg bg-indigo-600 text-gray-100 hover:bg-indigo-700"
                                data-codigomov="${par.par_codigomov}"
                                data-codigo="${par.par_codigo}"
                                data-valor="${par.par_valor}"
                                data-numero="${par.par_numero}"
                                data-qtnumero="${par.par_qtnumero}"
                                data-datavenc="${par.par_datavenc}"
                                data-databaixa="${par.par_databaixa ?? ''}"
                                data-situacao="${par.par_situacao ?? ''}">
                                Editar
                            </button>
                        </div>`;
                });

                document.querySelectorAll('.edit-parcelamento-btn').forEach(btn => {
                    btn.addEventListener('click', function () {
                        const modalEdit = document.getElementById('edit-parcelamento-modal');

                        modalEdit.querySelector('#edit-par-codigomov').value = this.dataset.codigomov;
                        modalEdit.querySelector('#edit-par-codigo').textContent = this.dataset.codigo;
                        modalEdit.querySelector('#edit-par-valor').value = this.dataset.valor;
                        modalEdit.querySelector('#edit-par-numero').textContent = this.dataset.numero;
                        modalEdit.querySelector('#edit-par-qtnumero').textContent = this.dataset.qtnumero;
                        modalEdit.querySelector('#edit-par-situacao').value = this.dataset.situacao;
                        modalEdit.querySelector('#edit-par-vencimento').value = this.dataset.datavenc;
                        modalEdit.querySelector('#edit-par-baixa').value = this.dataset.databaixa;

                        modalEdit.querySelector('form').action = `/parcelamento/${this.dataset.codigo}/${this.dataset.codigomov}`;

                        modalEdit.classList.remove('hidden');
                    });
                });
            } else {
                parcelasLista.innerHTML = `<div class="text-center text-gray-500 p-4">Nenhuma parcela encontrada.</div>`;
            }
        })
        .catch(err => console.error("Erro ao carregar parcelas:", err));
}

document.getElementById('close-parcelamento-edit').addEventListener('click', () => {
    document.getElementById('edit-parcelamento-modal').classList.add('hidden');
});

document.getElementById('cancel-parcelamento-edit').addEventListener('click', () => {
    document.getElementById('edit-parcelamento-modal').classList.add('hidden');
});

/* Limpar Filtro */
document.getElementById('btn-limpar').addEventListener('click', function () {
    const form = document.getElementById('form-filtros');
    form.reset();

    window.location.href = limpaFiltroExtrato;
});
       