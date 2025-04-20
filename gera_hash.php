<?php
// gera_hash.php - Gera um hash seguro para a senha
$senha = '1234';
echo password_hash($senha, PASSWORD_DEFAULT);
?>
