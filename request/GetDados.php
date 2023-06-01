<?php
    header('Content-Type: application/json; charset=utf-8');

    require_once '../app/Connection.php';
    
    // POST
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    $response = [
        'status' => false,
        'registros' => 0,
        'dados' => [],
        'message' => ''
    ];

    // Verifica E-mail
    if(empty($email)){
        $response['status'] = false;
        $response['message'] = 'E-mail não informado!';
    }else{
        // Faz a consulta no Banco de Dados
        try{
            $stmt = $connection->SQL('SELECT usuario.email as email, historico.data_consulta as data, historico.idade as idade, historico.peso as peso, historico.altura as altura, historico.sexo as sexo, historico.imc as imc, historico.tmb as tmb FROM historico LEFT JOIN usuario ON usuario.id = historico.usuario_id WHERE usuario.email = :0 ORDER BY data_consulta DESC');
            $connection->Bind($stmt, 0, $email);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                $response['status'] = true;
                $response['registros'] = $stmt->rowCount();
                $response['dados'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $response['message'] = 'OK!';
            }else{
                $response['status'] = true;
                $response['message'] = 'Nenhum registro encontrado!';
            }
        }catch(Exception  $e){
            $response['status'] = false;
            $response['message'] = 'Erro interno!';
        }
    }    

    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
?>