document.getElementById("cpf_pj").addEventListener("input", function(e) {
    let v = e.target.value.replace(/\D/g, "");
    if (v.length > 14) v = v.slice(0, 14);

    document.getElementById("cpfpjHidden").value = v;

    if (v.length > 11) {
        e.target.value = `${v.slice(0,2)}.${v.slice(2,5)}.${v.slice(5,8)}/${v.slice(8,12)}-${v.slice(12,14)}`;
    }
    else if (v.length > 9) {
        e.target.value = `${v.slice(0,3)}.${v.slice(3,6)}.${v.slice(6,9)}-${v.slice(9,11)}`;
    }
    else if (v.length > 6) {
        e.target.value = `${v.slice(0,3)}.${v.slice(3,6)}.${v.slice(6)}`;
    }
    else if (v.length > 3) {
        e.target.value = `${v.slice(0,3)}.${v.slice(3)}`;
    }
    else {
        e.target.value = v;
    }
});
document.getElementById("telefone").addEventListener("input", function(e) {
    let v = e.target.value.replace(/\D/g, "");
    if (v.length > 11) v = v.slice(0, 11);

    document.getElementById("telefoneHidden").value = v;

    if (v.length > 6) {
        e.target.value = `(${v.slice(0,2)}) ${v.slice(2,7)}-${v.slice(7)}`;
    } else if (v.length > 2) {
        e.target.value = `(${v.slice(0,2)}) ${v.slice(2)}`;
    } else {
        e.target.value = v;
    }
});