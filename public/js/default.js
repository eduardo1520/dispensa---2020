function validaCampos(form,botao,components) {
    let cont = 0;
    if(components != null && components.length == 1) {
        $(`#${form}`).find(`${components[0]}[required]`).each((x,filhos) => {($(filhos).val() != "") ? cont++ : 0 });
        (cont == $(`#${form}`).find(`${components[0]}[required]`).length) ? $(`#${botao}`).removeAttr('disabled') : $(`#${botao}`).attr('disabled','disabled');
    } else if(components != null && components.length > 1) {
        let atributos = '';
        for(let c in components){
            atributos += `${components[c]}[required],`;
        }
        atributos = atributos.replace(/,\s*$/, "");
        $(`#${form}`).find(atributos).each((x,filhos) => {($(filhos).val() != "") ? cont++ : 0 });
        (cont == $(`#${form}`).find(atributos).length) ? $(`#${botao}`).removeAttr('disabled') : $(`#${botao}`).attr('disabled','disabled');
    }
}
