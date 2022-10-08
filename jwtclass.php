<?php

class myJWT {
   private $senha = "SenhaSecreta";
   public function criaToken($conn, $payload, $idU){ // payload é um array
      $header = [
         'alg' => 'SHA256',
         'typ' => 'JWT'
      ];
      
      $header = json_encode($header); //Transformando o array para json
      $header = base64_encode($header); //Aplicando base 64, tirando caracteres especiais, padronizar, sem erro de compatibilidade
      
      $payload = json_encode($payload); //Payload precisa ser array, por causa da função json_encode
      $payload = base64_encode($payload);
      
      $signature = hash_hmac('sha256', "$header.$payload", $this->senha, true); //vai utilizar o algorítmo sha256 para criptografar o header e o payload, a chave de criptografia é $this->senha
      $signature = base64_encode($signature); //aplicando base 64, evita erro de compatibilidade 

      $token = "$header.$payload.$signature";

      $sql = "insert into token (hashToken, idUser) values ('". $token ."',". $idU .")"; 
      $resultadoQuery = mysqli_query($conn, $sql);
      
      return $token;
   }
    
   public function validaToken($conn, $tk, $idU){
      //segmentando o token e colocando suas partes partes em indices array
      $arrayPartesToken = explode(".",$tk);
      $vheader = $arrayPartesToken[0];
      $vpayload = $arrayPartesToken[1];
      $vsignature = $arrayPartesToken[2];
      
      $signatureCheck = hash_hmac('sha256', "$vheader.$vpayload", $this->senha, true);
    /* $signatureCheck = hash_hmac('sha256', "f", $this->senha, true); */ /*invalidação do token*/
      
      $signatureCheck = base64_encode($signatureCheck);
      
      if ($vsignature == $signatureCheck){
         $retorno = true;
      }else {
         $retorno = false;
         $sql = "delete from token where idUser = ". $idU; 
         $resultadoQuery = mysqli_query($conn, $sql);
         $this->criaToken($conn, $vpayload, $idU);
      }
      
      return $retorno;
   }


}
?>