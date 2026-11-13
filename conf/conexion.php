<?php

// Datos de la base de datos 
$servername = "localhost";      
$dbusername = "root";      
$dbpassword = "";      
$dbname     = "gaming_center";      

// 2. Intento conectar
try {
    $conn = new PDO(
        "mysql:host=$servername;dbname=$dbname;charset=utf8mb4",
        $dbusername,    
        $dbpassword   
    );

    // 3. PDO avisa con una excepción si una consulta falla
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // 4. Si algo falla, se muestra algun memsaje y la conexion paara
    die("Error en la conexión: " . $e->getMessage());
}