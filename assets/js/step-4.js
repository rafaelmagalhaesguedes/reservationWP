document.getElementById('finalizar_submit').addEventListener('click', function(event) {
    let nome = document.querySelector('input[name="cliente_nome"]').value;
    let sobrenome = document.querySelector('input[name="cliente_sobrenome"]').value;
    let email = document.querySelector('input[name="cliente_email"]').value;
    let cpf = document.querySelector('input[name="cliente_cpf"]').value;
    let telefone = document.querySelector('input[name="cliente_telefone"]').value;

    if (nome === '' || sobrenome === '' || email === '' || cpf === '' || telefone === '') {
        showDialog('Todos os campos são obrigatórios!');
        event.preventDefault();
    } else if (!validateEmail(email)) {
        showDialog('Email inválido! Digite um email válido.');
        event.preventDefault();
    } else if (!validaCPF(cpf)) {
        showDialog('CPF inválido! Digite um CPF válido.');
        event.preventDefault();
    }

    return true;
});

document.getElementById('dialog-close').addEventListener('click', function() {
    document.getElementById('dialog').style.display = 'none';
});

function showDialog(message) {
    document.getElementById('dialog-message').textContent = message;
    document.getElementById('dialog').style.display = 'block';
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function validaCPF(cpf) {
    cpf = cpf.replace(/\D/g, '');
    if (cpf.toString().length != 11 || /^(\d)\1{10}$/.test(cpf)) return false;
    var result = true;
    [9, 10].forEach(function(j) {
        var soma = 0, r;
        cpf.split(/(?=)/).splice(0,j).forEach(function(e, i) {
            soma += parseInt(e) * ((j+2)-(i+1));
        });
        r = soma % 11;
        r = (r <2)?0:11-r;
        if(r != cpf.substring(j, j+1)) result = false;
    });
    return result;
}