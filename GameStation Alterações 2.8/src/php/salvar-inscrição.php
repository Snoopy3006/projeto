<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = strip_tags($_POST['nome']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

        if($email){
           
            $linha = "$nome,$email\n";
            file_put_contents("inscritos.csv", $linha, FILE_APPEND);
            echo "Inscrição realizada com sucesso!";

        }
        else{

            echo "Email Invalido!"

        }
}