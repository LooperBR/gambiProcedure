<?php
    header('Content-Type: application/json; charset=utf-8');

    require_once '../app/Connection.php';
    
    // POST
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $idade = isset($_POST['idade']) ? intval($_POST['idade']) : null;
    $peso = isset($_POST['peso']) ? floatval($_POST['peso']) : null;
    $altura = isset($_POST['altura']) ? floatval($_POST['altura']) : null;
    $sexo = isset($_POST['sexo']) ? trim($_POST['sexo']) : null;

    $response = [
        'status' => false,
        'message' => ''
    ];

    // Verifica E-mail
    if(is_null($email) || is_null($idade) || is_null($peso) || is_null($altura) || is_null($sexo)){
        $response['status'] = false;
        $response['message'] = 'Erro: Dados faltando!';
    }else{
        // Faz a consulta no Banco de Dados
        try{
            $stmt = $connection->SQL('SELECT id FROM usuario WHERE email = :0 LIMIT 1');
            $connection->Bind($stmt, 0, $email);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                $idUsuario = intval($stmt->fetchAll(PDO::FETCH_ASSOC)[0]['id']);
                
                // Calcula o IMC
                $imc = floatval($peso / ($altura*$altura));
                
                // Calcula a Taxa de Metabolismo Basal
                $tmb = 0;

                if(strtoupper($sexo) == 'M'){
                    $tmb = floatval(66 + ((13.7 * $peso) + ( 5 * ($altura * 100)) - (6.8 * $idade)));
                }else if(strtoupper($sexo) == 'F'){
                    $tmb = floatval(655 + ((9.6 * $peso) + ( 1.8 * ($altura * 100)) - (4.7 * $idade)));
                }

                $stmt = $connection->SQL('INSERT INTO historico (data_consulta, idade, peso, altura, sexo, imc, tmb, usuario_id) VALUES (CURRENT_TIMESTAMP(), :0, :1, :2, :3, :4, :5, :6)');
                $connection->Bind($stmt, 0, $idade);
                $connection->Bind($stmt, 1, $peso);
                $connection->Bind($stmt, 2, $altura);
                $connection->Bind($stmt, 3, $sexo);
                $connection->Bind($stmt, 4, $imc);
                $connection->Bind($stmt, 5, $tmb);
                $connection->Bind($stmt, 6, $idUsuario);
                $stmt->execute();

                $response['status'] = true;
                $response['message'] = 'OK!';
            }else{
                $response['status'] = false;
                $response['message'] = 'Erro: Usuário não encontrado!';
            }
        }catch(Exception  $e){
            $response['status'] = false;
            $response['message'] = 'Erro interno!';
        }
    }    

    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
?>