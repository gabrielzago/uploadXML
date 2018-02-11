<?php
include_once('conection.php');

function insereXml($nome, $senha, $display_nome, $email, $user, $celular, $profile, $max_connections, $start_data, $expire_data, $tipo){
    global $total;

    $sql = "INSERT INTO dados_import (name, password, display_name, email, caduser, celular, profiles, max_connections, start_date, expire_date, tipo) VALUES ('$nome', '$senha', '$display_nome', '$email', '$user', '$celular', '$profile', $max_connections, '$start_data', '$expire_data', $tipo)";
    $insert = comando($sql);

    if($insert){
      $total += 1;
    }
}

  if (isset($_FILES['enviar_xml'])) {
    if (is_uploaded_file($_FILES['enviar_xml']['tmp_name'])) {
      $xml = simplexml_load_file($_FILES['enviar_xml']['tmp_name']);

      foreach ($xml->user as $xml) {
        $nome =  $xml['name'];
        $senha = $xml['password'];
        $display_nome = $xml['display-name'];
        $email = $xml['email-address'];
        $user = $xml['caduser'];
        $profile = $xml['profiles'];
        $max_connections = $xml['max-connections'];
        $start_data = $xml['start-date'];
        $expire_data = $xml['expire-date'];
        $celular = $xml['celular'];

        if ($xml['tipo'] == null or $xml['tipo'] == '') {
          $tipo = 0;
        }else {
          $tipo = $xml['tipo'];
        }

        insereXml($nome, $senha, $display_nome, $email, $user, $celular, $profile, $max_connections, $start_data, $expire_data, $tipo);
      }
    }
}else {
  echo "sem arquivo";
}
echo "Linhas inseridas = ".$total;
