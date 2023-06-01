<?php
    header('Content-Type: application/json; charset=utf-8');

    require_once '../app/Connection.php';
    
    // POST
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    $response = [
        'status' => false,
        'exists' => false,
        'message' => ''
    ];

    // Verifica E-mail
    if(empty($email)){
        $response['status'] = false;
        $response['message'] = 'E-mail não informado!';
    }else{
        // Faz a consulta no Banco de Dados
        try{
            $stmt = $connection->SQL('SELECT id FROM usuario WHERE email = :0 LIMIT 1');
            $connection->Bind($stmt, 0, $email);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                $response['status'] = true;
                $response['exists'] = true;
                $response['message'] = 'E-mail existente!';
            }else{
                $response['status'] = true;
                $response['exists'] = false;
                $response['message'] = 'E-mail não existente!';
            }
        }catch(Exception  $e){
            $response['status'] = false;
            $response['message'] = 'Erro interno!';
        }
    }    

    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
?>