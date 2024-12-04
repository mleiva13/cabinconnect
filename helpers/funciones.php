<?php

// Esta función se encargará de limpiar espacios y caracteres especiales para prevenir la inyección SQL.

//La inyección SQL es un método de infiltración de código intruso que se vale de una vulnerabilidad informática 
//presente en una aplicación en el nivel de validación de las entradas para realizar operaciones sobre una base de datos.

function strClean($cadena){
    $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $cadena);
    $string = trim($string);
    $string = stripslashes($string);
    $string = str_ireplace('<script>', '', $string);
    $string = str_ireplace('</script>', '', $string);
    $string = str_ireplace('<script type=>', '', $string);
    $string = str_ireplace('<script src>', '', $string);
    $string = str_ireplace('SELECT * FROM', '', $string);
    $string = str_ireplace('DELETE FROM', '', $string);
    $string = str_ireplace('INSERT INTO', '', $string);
    $string = str_ireplace('SELECT COUNT(*) FROM', '', $string);
    $string = str_ireplace('DROP TABLE', '', $string);
    $string = str_ireplace("OR '1'='1", '', $string);
    $string = str_ireplace('OR ´1´=´1', '', $string);
    $string = str_ireplace('IS NULL', '', $string);
    $string = str_ireplace('LIKE "', '', $string);
    $string = str_ireplace("LIKE '", '', $string);
    $string = str_ireplace('LIKE ´', '', $string);
    $string = str_ireplace('OR "a"="a', '', $string);
    $string = str_ireplace("OR 'a'='a", '', $string);
    $string = str_ireplace('OR ´a´=´a', '', $string);
    $string = str_ireplace('--', '', $string);
    $string = str_ireplace('^', '', $string);
    $string = str_ireplace('[', '', $string);
    $string = str_ireplace(']', '', $string);
    $string = str_ireplace('==', '', $string);
    return $string;
}

//SLUG
//Es una pequeña parte de un enlace que permite identificar un contenido específico en una web.

function slugify($text, string $divider = '-'){
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

//LIMITAR CADENA
//Como su nombre lo indica vamos limitar cuantos caracteres necesitamos mostrar.
function limitar_cadena($cadena, $limite, $sufijo){
    // Si la longitud es mayor que el límite...
    if (strlen($cadena) > $limite) {
        // Entonces corta la cadena y ponle el sufijo
        return substr($cadena, 0, $limite) . $sufijo;
    }

    // Si no, entonces devuelve la cadena normal
    return $cadena;
}


//Personalizar Fecha
function fechaPerzo($fecha){
    $datos = explode('-', $fecha);
    $anio = $datos[0];
    $me = ltrim($datos[1], "0");
    $dia = $datos[2];
    $mes = array(
            "",
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        );
    return $dia . " de " . $mes[$me] . " de " . $anio;
}


//Validar Campos
//Nos va servir para verificar los campos requeridos
function validarCampos($campos){
    foreach ($campos as $campo) {
        if (empty($_POST[$campo])) {
            return false;
        }
    }
    return true;
}

//CREAR SESIONES 
function crearSession($datos) {
    $_SESSION['id_usuario'] = $datos['id_usuario'];
    $_SESSION['usuario'] = $datos['usuario'];
    $_SESSION['correo_usuario'] = $datos['correo'];
    $_SESSION['nombre_usuario'] = $datos['nombre'];
    $_SESSION['rol'] = $datos['rol'];
}
//REDIRECT
function redirect($ruta){
    header('Location:' . $ruta);
}
//Agregar productos al carrito
//Nos servirá para crear un array de sesiones, para el módulo de ventas
function addToCart($carrito, $id, $nombre, $precio, $token, $cant = 1){
    if (!isset($_SESSION[$carrito])) {
        $_SESSION[$carrito] = [];
    }

    $cart = $_SESSION[$carrito];

    $product = [
        'id' => $id,
        'name' => $nombre,
        'price' => $precio,
        'token' => $token,
        'quantity' => $cant
    ];

    // Verificar si el producto ya está en el carrito y actualizar la cantidad si es necesario
    $found = false;
    foreach ($cart as &$item) {
        if ($item['id'] === $id && $item['token'] === $token) {
            $item['quantity']++;
            $found = true;
            break;
        }
    }

    // Si no se encontró el producto en el carrito, agrégalo
    if (!$found) {
        $cart[] = $product;
    }

    $_SESSION[$carrito] = $cart;

    // Preparar una respuesta JSON
    $response = [
        'status' => 'success',
        'message' => 'Producto agregado.'
    ];

    return $response;
}

//Eliminar producto del carrito
function removeFromCart($carrito, $id, $token){
    if (!isset($_SESSION[$carrito])) {
        $_SESSION[$carrito] = [];
    }

    $cart = $_SESSION[$carrito];

    // Buscar el índice del producto en el carrito
    $productIndex = null;
    foreach ($cart as $index => $product) {
        if ($product['id'] === $id && $product['token'] === $token) {
            $productIndex = $index;
            break;
        }
    }

    if ($productIndex !== null) {
        // Eliminar el producto del carrito
        unset($cart[$productIndex]);
        $_SESSION[$carrito] = array_values($cart); // Reindexar el array
    }

    // Preparar una respuesta JSON
    $response = [
        'status' => 'success',
        'message' => 'Producto eliminado.'
    ];

    return $response;
}

//Vaciar productos del carrito
function clearCart($carrito){
    unset($_SESSION[$carrito]); // Eliminar el carrito de la sesión

    // Preparar una respuesta JSON
    $response = [
        'status' => 'success',
        'message' => 'Carrito limpiado'
    ];

    return $response;
}

//Mostrar el total general
//Esta función calculara el total (precio * cantidad)
function getTotalPrice($carrito){
    if (!isset($_SESSION[$carrito])) {
        return 0; // Devolver 0 si el carrito no existe en la sesión
    }

    $cart = $_SESSION[$carrito];
    $totalPrice = 0;

    if (!empty($cart)) {
        foreach ($cart as $product) {
            $totalPrice += $product['price'] * $product['quantity'];
        }
    }

    return $totalPrice;
}

//Cantidad editable en el carrito
function updateCantidad($carrito, $id, $cantidad, $token){
    if (!isset($_SESSION[$carrito])) {
        // Manejar el caso en que el carrito no exista
        $response = [
            'status' => 'error',
            'message' => 'El carrito no existe.'
        ];
        return $response;
    }

    $cart = $_SESSION[$carrito];

    foreach ($cart as &$product) {
        if ($product['id'] === $id && $product['token'] === $token) {
            $product['quantity'] = $cantidad;
            break;
        }
    }

    $_SESSION[$carrito] = $cart;

    $response = [
        'status' => 'success',
        'message' => 'Cantidad actualizada.'
    ];

    return $response;
}

//Precio editable en el carrito
function updatePrice($carrito, $id, $new_price, $token){
    if (!isset($_SESSION[$carrito])) {
        // Manejar el caso en que el carrito no exista
        $response = [
            'status' => 'error',
            'message' => 'El carrito no existe.'
        ];
        return $response;
    }

    $cart = $_SESSION[$carrito];

    foreach ($cart as &$product) {
        if ($product['id'] === $id && $product['token'] === $token) {
            $product['price'] = $new_price;
            break;
        }
    }

    $_SESSION[$carrito] = $cart;

    $response = [
        'status' => 'success',
        'message' => 'Precio actualizado.'
    ];

    return $response;
}

//Generar Serie
function generate_numbers($start, $count, $digits){
    $result = array();
    for ($n = $start;
        $n < $start + $count;
        $n++
    ) {
        $result[] = str_pad($n, $digits, "0", STR_PAD_LEFT);
    }
    return $result;
}

//Capturar el nombre de día
function get_nombre_dia($fecha){
    $fechats = strtotime($fecha); //pasamos a timestamp

    //lo devuelve en numero 0 domingo, 1 lunes,....
    switch (date('w', $fechats)) {
        case 0:
            return "Domingo";
            break;
        case 1:
            return "Lunes";
            break;
        case 2:
            return "Martes";
            break;
        case 3:
            return "Miercoles";
            break;
        case 4:
            return "Jueves";
            break;
        case 5:
            return "Viernes";
            break;
        case 6:
            return "Sabado";
            break;
    }
}


//Buscar valor en un array
//Para verificar si tienes permisos
function verificar($valor, $datos = []){
    $existe = array_search($valor, $datos, true);
    return is_numeric($existe);
}

function validarPassword($password) {
    // Mínimo 8 caracteres, al menos una letra mayúscula, una minúscula y un número
    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/";
    return preg_match($pattern, $password);
}

?>