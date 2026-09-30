<?php
require_once __DIR__ . '/conexion_mexotech.php';
return $pdo->query('SELECT p.id, c.clave AS categoria, p.nombre, p.descripcion, p.detalle, p.imagen, p.imagen_alternativa AS alternativa, p.precio, p.existencias FROM productos p JOIN categorias c ON c.id = p.categoria_id WHERE p.activo = 1 ORDER BY p.id')->fetchAll();
