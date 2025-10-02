$(document).ready(function() { 
    $("#buscaPessoa").on("keyup", function(){
        let termo = $(this).val();

        if(termo.length > 2){
            $.ajax({
                url:"/pessoa/buscar",
                type:"GET",
                data: { q: termo },
                success: function(data){
                    let lista ="";
                    data.forEach(function(pessoa){
                        lista += "<li class='item-pessoa' data-id='"+pessoa.pes_codigo+"'>"+pessoa.pes_nome+" | "+pessoa.pes_cpfpj+" </li>";
                    });
                    $("#resultado").html(lista).show();
                }
            });
        }else{
            $("#resultado").hide();
        }
    });

    $(document).on("click", ".item-pessoa", function(){
        let nome = $(this).text();
        let id = $(this).data("id");

        $("#buscaPessoa").val(nome);
        $("#movb_pessoa").val(id);
        $("#resultado").hide();
    });
});
