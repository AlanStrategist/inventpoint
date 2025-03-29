<?php 

//Set All Urls

$Urls = ["https://pydolarve.org/api/v1/dollar?page=enparalelovzla",
"https://pydolarve.org/api/v1/dollar?page=bcv",
"https://pydolarve.org/api/v1/dollar?page=italcambio"];

//Try Call api
$i=0;


function ShowDollar( int $i , Array $data): string {

    $result = "";
    $dol = 0;
    $img = "";
    $subtitle = "";
    $sim = "";

    switch($i){

        case 0: //Enparalelovzla
            
           $dol = $data["monitors"]["enparalelovzla"]["price"];
           $img = $data["monitors"]["enparalelovzla"]["image"];
           $sim = $data["monitors"]["enparalelovzla"]["symbol"];
           $subtitle ="EnParaleloVzla";
        
        break;

        case 1: //BCV  
            
            $dol = $data["monitors"]["usd"]["price"];
            $img = "https://w7.pngwing.com/pngs/534/624/png-transparent-central-bank-of-venezuela-venezuelan-bolivar-bank-emblem-label-logo-thumbnail.png";
            $sim = $data["monitors"]["usd"]["symbol"];
            $subtitle = "Banco Central";

        break;

        case 2:
            
            $dol = $data["monitors"]["usd"]["price"];
            $img = "https://media.licdn.com/dms/image/v2/C560BAQEl6jTOwPWkiQ/company-logo_200_200/company-logo_200_200/0/1631356186912?e=2147483647&v=beta&t=nlOWa4gdJVHBsZCcWIXCZHfauRWnpPgR5WFS1OAUqEE";
            $sim = $data["monitors"]["usd"]["symbol"];
            $subtitle = "Italcambio";
        
        break;

    }


    $result .="<div class='d-flex align-items-center mb-3'>
                  <div class='mr-3'
                    style='width: 50px; height: 50px; overflow: hidden; border-radius: 6px; background: #f8f9fa; display: flex; align-items: center; justify-content: center;'>
                    <img src='".$img."' alt='USD' class='img-fluid h-100'
                      style='object-fit: cover;'>
                  </div>
                  <div>
                    <h5 class='card-title mb-0'>".$subtitle." = ".$dol."</h5>
                    <small class='text-muted'>USD/BS ".$sim."</small>
                  </div>
                </div>
      ";
    
    return $result;

}

foreach ( $Urls as $en) {

    try {
        // Inicializar cURL
        $ch = curl_init($en);
        
        if ($ch === false) {
            throw new Exception('Error al inicializar cURL');
        }
        
        // Configurar opciones de cURL
        $options = [
            CURLOPT_RETURNTRANSFER => true,  // Devuelve el resultado como string
            CURLOPT_HEADER         => false, // No incluir cabeceras en la salida
            CURLOPT_FOLLOWLOCATION => true, // Seguir redirecciones
            CURLOPT_MAXREDIRS      => 10,   // Límite de redirecciones
            CURLOPT_TIMEOUT        => 30,   // Timeout en segundos
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "GET", // Método HTTP
        ];
        
        curl_setopt_array($ch, $options);
        
        // Ejecutar la petición
        $response = curl_exec($ch);
        
        // Verificar errores de cURL
        if (curl_errno($ch)) {
            throw new Exception('Error en cURL: ' . curl_error($ch));
        }
        
        // Obtener el código de estado HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        // Verificar código de respuesta HTTP
        if ($httpCode !== 200) {
            throw new Exception("La API devolvió el código HTTP: $httpCode");
        }
        
        // Decodificar la respuesta JSON
        $data = json_decode($response, true);
        
        // Verificar si el JSON es válido
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Error al decodificar JSON: ' . json_last_error_msg());
        }
        
        // Mostrar los resultados
        //echo "<h2>Respuesta de la API ".$i.":</h2>";
        
        echo ShowDollar($i, $data);
        
        //echo "<pre>";
        //print_r($data);
        //echo "</pre>";
        
        // Cerrar la conexión cURL
        curl_close($ch);
        
    } catch (Exception $e) {
        // Manejar cualquier excepción
        echo "<div style='color: red; padding: 10px; border: 1px solid red; margin: 10px;'>";
        echo "<strong>Error:</strong> " . $e->getMessage();
        echo "</div>";
        
        // Cerrar conexión cURL si está abierta
        if (isset($ch) && is_resource($ch)) {
            curl_close($ch);
        }
    }

    $i++;
}

?>