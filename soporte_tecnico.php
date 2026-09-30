<?php
require_once __DIR__.'/funciones_mexotech.php';
$items=require __DIR__.'/datos_productos.php';$seleccion=filter_input(INPUT_GET,'producto',FILTER_VALIDATE_INT)?:0;
$motivo='';$producto_id=0;foreach($items as $item)if((int)$item['id']===$seleccion){$motivo='Consulta sobre '.$item['nombre'];$producto_id=(int)$item['id'];break;}
ob_start();
encabezado('Soporte técnico MEXOTECH');
$cabecera=ob_get_clean();
$estilosContacto=<<<'CSS'
<style>
/* Estilos exclusivos del formulario de soporte de MEXOTECH. */
.mexotech-contacto{max-width:720px;margin:24px auto 0;text-align:left;font:16px/1.6 'Segoe UI',Arial,sans-serif;color:#334155}
.mexotech-contacto .introduccion{margin:0 0 18px}
.mexotech-contacto .nota-demo{font-size:14px;line-height:1.6;color:#475569;background:#edf3f7;border-left:3px solid #164a66;padding:14px 18px;margin:0 0 24px}
.mexotech-contacto .form-soporte{display:flex;flex-direction:column;gap:22px;box-sizing:border-box;width:100%;max-width:none;margin:0;padding:32px;background:#fff;border:1px solid #dce4ea;border-top:4px solid #164a66;border-radius:12px;box-shadow:0 10px 32px rgba(22,74,102,.06)}
.mexotech-contacto .campo-soporte{display:flex;flex-direction:column;gap:8px;width:100%;min-width:0}
.mexotech-contacto .campo-soporte label{display:block;margin:0;text-align:left;font-size:15px;font-weight:600;color:#164a66;letter-spacing:0}
.mexotech-contacto .campo-soporte input,.mexotech-contacto .campo-soporte select,.mexotech-contacto .campo-soporte textarea{display:block;box-sizing:border-box;width:100%;max-width:100%;min-width:0;min-height:48px;margin:0;padding:12px 14px;border:1px solid #b9c8d3;border-radius:6px;background:#fbfcfe;color:#1e293b;font:16px/1.5 'Segoe UI',Arial,sans-serif}
.mexotech-contacto .campo-soporte textarea{min-height:150px;resize:vertical}
.mexotech-contacto .campo-soporte input:focus,.mexotech-contacto .campo-soporte select:focus,.mexotech-contacto .campo-soporte textarea:focus{outline:3px solid #dcebf3;border-color:#164a66;outline-offset:1px;background:#fff}
.mexotech-contacto .form-soporte button{display:block;align-self:stretch;width:100%;min-height:50px;margin:2px 0 0;padding:13px 20px;background:#164a66;color:#fff;border:0;border-radius:6px;font:600 16px/1.5 'Segoe UI',Arial,sans-serif;cursor:pointer}
.mexotech-contacto .form-soporte button:hover{background:#0e3042}
.mexotech-contacto .form-soporte button:focus-visible{outline:3px solid #c96c34;outline-offset:3px}
@media(max-width:540px){.mexotech-contacto{margin-top:16px}.mexotech-contacto .form-soporte{padding:22px 18px;gap:20px}}
</style>
CSS;
echo str_replace('</head>', $estilosContacto.'</head>', $cabecera);
?>
<section class="mexotech-contacto" aria-label="Formulario de soporte técnico">
<p class="introduccion">Describe tu equipo y el servicio que necesitas. Puedes consultar por diagnóstico, pantalla, batería o accesorios.</p>
<p class="nota-demo">El formulario guarda tu consulta en la base de datos para su revisión. No compartas contraseñas ni datos bancarios.</p>
<form action="guardar_consulta.php" method="post" class="form-soporte">
<input type="hidden" name="producto_id" value="<?= $producto_id ?>">
<input type="hidden" name="csrf_token" value="<?= e($_SESSION['mexotech_csrf']) ?>">
<div class="campo-soporte">
<label for="nombre">Nombre</label>
<input id="nombre" name="nombre" maxlength="120" required autocomplete="name">
</div>
<div class="campo-soporte">
<label for="correo">Correo electrónico</label>
<input id="correo" type="email" name="correo" maxlength="190" required autocomplete="email">
</div>
<div class="campo-soporte">
<label for="servicio">Servicio</label>
<select id="servicio" name="servicio"><option value="diagnostico">Diagnóstico</option><option value="pantalla">Pantalla</option><option value="bateria">Batería</option><option value="accesorios" <?= $motivo!==''?'selected':'' ?>>Consulta de equipo o accesorio</option></select>
</div>
<div class="campo-soporte">
<label for="modelo">Marca y modelo (opcional)</label>
<input id="modelo" name="modelo" maxlength="120">
</div>
<div class="campo-soporte">
<label for="mensaje">Describe tu consulta</label>
<textarea id="mensaje" name="mensaje" rows="5" maxlength="1500" required><?= e($motivo) ?></textarea>
</div>
<button type="submit">Enviar consulta</button>
</form>
</section>
<?php pie(); ?>
