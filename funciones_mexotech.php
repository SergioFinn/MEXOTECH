<?php
if(session_status()!==PHP_SESSION_ACTIVE)session_start(['cookie_httponly'=>true,'cookie_samesite'=>'Lax']);
if(empty($_SESSION['mexotech_csrf']))$_SESSION['mexotech_csrf']=bin2hex(random_bytes(32));
function e($x): string{return htmlspecialchars((string)$x,ENT_QUOTES,'UTF-8');}
function encabezado(string $titulo): void {
echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>'.e($titulo).' - MEXOTECH</title><link rel="stylesheet" href="estilos_mexotech.css"></head><body id="arriba"><nav aria-label="Navegación principal"><a href="inicio_mexotech.html">Inicio</a><a href="catalogo_electronica.php">Catálogo</a><a href="empresa_mexotech.html">Nuestra Empresa</a><a href="soporte_tecnico.php">Soporte Técnico</a><a href="seguridad_envios_mexotech.html">Seguridad y Envíos</a></nav><main class="seccion"><h1>'.e($titulo).'</h1>';
if(isset($_SESSION['mexotech_aviso'])){echo '<p class="aviso" role="status">'.e($_SESSION['mexotech_aviso']).'</p>';unset($_SESSION['mexotech_aviso']);}
}
function pie(): void{echo '</main><footer id="abajo"><p>MEXOTECH © 2026 · Proyecto académico · Demostración sin cobros</p><a href="#arriba">Volver arriba</a></footer></body></html>';}
function volver(string $pagina,string $mensaje): void{$_SESSION['mexotech_aviso']=$mensaje;header('Location: '.$pagina,true,303);exit;}
function validar_post(): void{
 if($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);header('Allow: POST');exit('Utiliza el formulario de MEXOTECH.');}
 $token=$_POST['csrf_token']??'';
 if(!is_string($token)||!hash_equals($_SESSION['mexotech_csrf'],$token)){http_response_code(403);exit('Formulario vencido o ya enviado. Regresa a la página y vuelve a abrirlo.');}
}
function campo(string $key,int $max,bool $required=true): string{
 $v=$_POST[$key]??'';if(!is_string($v))throw new DomainException('Datos inválidos.');$v=trim($v);
 if(($required&&$v==='')||mb_strlen($v)>$max)throw new DomainException('Revisa el campo '.$key.'.');return $v;
}
