<?php
    $host = "localhost";
    $dbname = "agenda";
    $user = "root";
    $pass = "";

    try {
        $conn = new PDO("mysql:host=$host; dbname = $dbname", $user, $pass);
    
        // Ativer o modo de erros
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    } catch(PDOException $e) {
        // Obtem o erro
        $error = $e->getMessage();

        echo "Erro: $error";
    }