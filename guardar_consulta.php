<?php
require_once __DIR__ . '/funciones_mexotech.php';
validar_post();
try {
    $nombre=campo('nombre',120);
    $correo=campo('correo',190);
    $modelo=campo('modelo',120,false);
    $mensaje=campo('mensaje',1500);
    $servicio=campo('servicio',30);
    if(!filter_var($correo,FILTER_VALIDATE_EMAIL)) throw new DomainException('Escribe un correo válido.');
    if(!in_array($servicio,['diagnostico','pantalla','bateria','accesorios'],true)) throw new DomainException('Selecciona un servicio válido.');
    $producto=filter_var($_POST['producto_id']??0,FILTER_VALIDATE_INT,['options'=>['min_range'=>1]]) ?: null;
    require __DIR__ . '/conexion_mexotech.php';
    if($producto!==null){$q=$pdo->prepare('SELECT id FROM productos WHERE id=? AND activo=1');$q->execute([$producto]);if(!$q->fetch())$producto=null;}
    $q=$pdo->prepare('INSERT INTO solicitudes_soporte (nombre,correo,servicio,modelo,mensaje,producto_id) VALUES (?,?,?,?,?,?)');
    $q->execute([$nombre,$correo,$servicio,$modelo?:null,$mensaje,$producto]);
    $_SESSION['mexotech_csrf']=bin2hex(random_bytes(32));
    volver('soporte_tecnico.php','Tu consulta quedó registrada correctamente.');
} catch(DomainException $e){volver('soporte_tecnico.php',$e->getMessage());}
catch(PDOException $e){error_log($e->getMessage());volver('soporte_tecnico.php','No se pudo guardar la consulta. Inténtalo más tarde.');}
