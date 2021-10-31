<?php

   session_start();

   include_once("connection.php");
   include_once("url.php");

   $data = $_POST;

   //Modificacoes no banco
   if(!empty($data)){

      //Criar contato
      if($data["type"] === "create"){
         $name = $data["name"];
         $phone = $data["phone"];
         $observations = $data["observations"];

         $query = "INSERT INTO agenda.contacts (name, phone, observations) VALUES (:name, :phone, :observations)";

         $stmt = $conn->prepare($query);

         $stmt->bindParam(":name", $name);
         $stmt->bindParam(":phone", $phone);
         $stmt->bindParam(":observations", $observations);

         try {
            $stmt->execute();
            $_SESSION["msg"] = "Contato criado com sucesso!";
         } catch(PDOException $e) {
            // Obtem o erro
            $error = $e->getMessage();
    
            echo "Erro: $error";
         }
      } else if($data["type"] === "edit") {
         $name = $data["name"];
         $phone = $data["phone"];
         $observations = $data["observations"];
         $id = $data["id"];

         $query = "UPDATE agenda.contacts
                   SET name = :name, phone = :phone, observations = :observations
                   WHERE id = :id";
         
         $stmt = $conn->prepare($query);

         $stmt->bindParam(":name", $name);
         $stmt->bindParam(":phone", $phone);
         $stmt->bindParam(":observations", $observations);
         $stmt->bindParam(":id", $id);

         try {
            $stmt->execute();
            $_SESSION["msg"] = "Contato atualizado com sucesso!";
         } catch(PDOException $e) {
            // Obtem o erro
            $error = $e->getMessage();
    
            echo "Erro: $error";
         }
      } else if ($data["type"] === "delete") {
         $id = $data["id"];

         $query = "DELETE FROM agenda.contacts WHERE id = :id";

         $stmt = $conn->prepare($query);

         $stmt->bindParam(":id", $id);

         try {
            $stmt->execute();
            $_SESSION["msg"] = "Contato removido com sucesso!";
         } catch(PDOException $e) {
            // Obtem o erro
            $error = $e->getMessage();
    
            echo "Erro: $error";
         }

      }

      // Redirect HOME
      header("Location:" . $BASE_URL . "../index.php");

   // Selecao de dados
   } else {
       // Query que retorna os dados de um contato
      $id;

      if(!empty($_GET)){
         $id = $_GET["id"];
      }

      if(!empty($id)){
         $query = "SELECT * FROM agenda.contacts WHERE id = :id";

         $stmt = $conn->prepare($query);

         $stmt->bindParam(":id", $id);

         $stmt->execute();

         $contact = $stmt->fetch();
      } else {
         // Query que retorna todos os contatos
         $query = "SELECT * FROM agenda.contacts";

         $stmt = $conn->prepare($query);

         $stmt->execute();

         $contacts = $stmt->fetchAll();
      }
   }
   
   // Fechar conexao
   $conn = null;
  

   

