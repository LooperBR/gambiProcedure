var email = '';

function validaEmail(email){
    let emailRegex = /\S+@\S+\.\S+/;
    
    if(emailRegex.test(email)){
        return true;
    }else{
        alert('E-mail inválido!');
        return false;
    }
}

function Acessar(){
    // Pega o E-mail
    email = prompt('Entre com seu E-mail:');
    let emailExists = false;

    if (!validaEmail(email)) return false;

    document.getElementById('btn-calculo-manual').disabled = true;
    document.getElementById('btn-calculo-procedure').disabled = true;

    // Verifica se o e-mail existe no banco
    $.ajax({
        url: 'request/VerificaEmail.php',
        type: 'POST',
        data: {
        email: email
        }
    }).done(function(result) {
        if (result.status) {
        emailExists = result.exists;
        if (emailExists) {
            document.getElementById('btn-calculo-manual').disabled = false;
            document.getElementById('btn-calculo-procedure').disabled = false;
            GetDados(email);
        }
        } else {
        alert(result.message);
        }
    }).fail(function() {
        alert('Erro na requisição AJAX!');
    });
}
  
function GetDados(email) {
    let dados = {};

    // Pega os dados no banco
    $.ajax({
        url: 'request/GetDados.php',
        type: 'POST',
        data: {
        email: email
        }
    }).done(function(result) {
        if (result.status) {
        dados = result.dados;
        let dadosContainer = document.getElementById('dados');

        // Limpa o conteúdo anterior
        dadosContainer.innerHTML = '';

        // Monta os Dados na Tela
        dados.forEach(function(item) {
            let row = document.createElement('tr');

            // E-mail
            let column = document.createElement('td');
            column.innerHTML = item.email;
            row.appendChild(column);

            // Data
            column = document.createElement('td');
            column.innerHTML = item.data;
            row.appendChild(column);

            // Idade
            column = document.createElement('td');
            column.innerHTML = item.idade;
            row.appendChild(column);

            // Peso
            column = document.createElement('td');
            column.innerHTML = item.peso;
            row.appendChild(column);

            // Altura
            column = document.createElement('td');
            column.innerHTML = item.altura;
            row.appendChild(column);

            // Sexo
            column = document.createElement('td');
            column.innerHTML = item.sexo;
            row.appendChild(column);

            // IMC
            column = document.createElement('td');
            column.innerHTML = item.imc;
            row.appendChild(column);

            // Taxa de Metabolismo Basal
            column = document.createElement('td');
            column.innerHTML = item.tmb;
            row.appendChild(column);

            dadosContainer.appendChild(row);
        });
        } else {
        alert(result.message);
        }
    }).fail(function() {
        alert('Erro na requisição AJAX!');
    });
}

function Calculo(modo){
    $.ajax({
        url: `request/Calculo${modo}.php`,
        type: 'POST',
        data: {
            email: email,
            idade: prompt('Qual sua idade?'),
            peso: prompt('Qual seu peso? (em kilos)'),
            altura: prompt('Qual sua altura? (em Metros, ex.: 1.74)'),
            sexo: prompt('Qual seu sexo? (F ou M)')
        }
    }).done(function(result) {
        if (result.status) {
            GetDados(email);
        } else {
        alert(result.message);
        }
    }).fail(function() {
        alert('Erro na requisição AJAX!');
    });
}

/* ********************************* */

document.getElementById('btn-acessar').addEventListener('click', () => {
    Acessar();
});

document.getElementById('btn-calculo-manual').addEventListener('click', () => {
    Calculo('Manual');
});

document.getElementById('btn-calculo-procedure').addEventListener('click', () => {
    Calculo('Procedure');
});