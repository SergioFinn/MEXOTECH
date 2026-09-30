<?php
require_once __DIR__.'/funciones_mexotech.php';
$items = require __DIR__ . '/datos_productos.php';
$categorias=['todos'=>'Todo el catálogo','equipos'=>'Smartphones','accesorios'=>'Accesorios','proteccion'=>'Protección'];
$filtro=$_GET['categoria']??'todos';
if(!is_string($filtro)||!isset($categorias[$filtro]))$filtro='todos';
ob_start();
encabezado('Catálogo de telefonía y accesorios');
$cabecera=ob_get_clean();
$estilos= <<<'CSS'
<style>
.mx-catalogo .aviso{text-align:center;color:#666;margin:20px auto 30px;max-width:780px}
.mx-catalogo .filtro{display:flex;flex-wrap:wrap;align-items:center;justify-content:center;gap:14px;margin:25px 0}
.mx-catalogo select,.mx-catalogo button{font:inherit;padding:10px 16px;border:1px solid #cdd8df;border-radius:6px;background:white;color:#164a66}
.mx-catalogo button{cursor:pointer}.mx-catalogo .filtro button{background:#164a66;color:white}
.mx-catalogo button:focus-visible,.mx-catalogo a:focus-visible{outline:3px solid #c96c34;outline-offset:3px}
.mx-catalogo .scroll{overflow-x:auto}.mx-catalogo .tabla-tech{min-width:760px;margin-top:20px}
.mx-catalogo caption{padding:15px;color:#666}.mx-catalogo .tabla-tech td{padding:24px 14px}
.mx-catalogo .foto-producto{display:block;width:180px;height:210px;object-fit:contain;background:#f3f4f4;border-radius:8px;margin:0 auto 14px}
.mx-catalogo .vista-alterna{display:block;margin:12px auto 0;font-size:13px}
.mx-catalogo .nombre-producto{display:block;max-width:210px;margin:auto;line-height:1.5}
.mx-catalogo .mapa-conectividad{margin:60px auto 0;text-align:center;max-width:900px}
.mx-catalogo .mapa-conectividad img{display:block;width:100%;height:auto;border-radius:12px;margin-top:24px}
.mx-catalogo figcaption{font-size:14px;color:#666;margin-top:16px}
@media(max-width:600px){.mx-catalogo .filtro{align-items:stretch;flex-direction:column}.mx-catalogo .foto-producto{width:150px;height:180px}}
</style>
CSS;
echo str_replace('</head>',$estilos.'</head>',$cabecera);
?>
<div class="mx-catalogo">
<p class="aviso">Catálogo de demostración con imágenes ilustrativas. Los artículos iniciales son ilustrativos. Precios y existencias por definir; no se realizan compras.</p>
<form method="get" class="filtro">
<label for="categoria">Categoría</label>
<select name="categoria" id="categoria"><?php foreach($categorias as $key=>$nombre): ?><option value="<?= e($key) ?>" <?= $key===$filtro?'selected':'' ?>><?= e($nombre) ?></option><?php endforeach ?></select>
<button type="submit">Filtrar</button>
</form>
<div class="scroll" role="region" aria-label="Catálogo de productos, desplazable horizontalmente" tabindex="0">
<table class="tabla-tech"><caption>Artículos de ejemplo de MEXOTECH</caption>
<thead><tr><th scope="col">Artículo</th><th scope="col">Descripción</th><th scope="col">Características</th><th scope="col">Precio</th><th scope="col">Información</th></tr></thead><tbody>
<?php foreach($items as $item): if($filtro!=='todos'&&$item['categoria']!==$filtro)continue; ?>
<tr><td>
<img class="foto-producto" id="foto-<?= (int)$item['id'] ?>" src="img/<?= e($item['imagen']) ?>" alt="<?= e($item['nombre']) ?>, vista principal" loading="lazy" width="180" height="210">
<strong class="nombre-producto"><?= e($item['nombre']) ?></strong>
<?php if(!empty($item['alternativa'])): ?>
<button type="button" class="vista-alterna" aria-controls="foto-<?= (int)$item['id'] ?>" aria-pressed="false" data-principal="img/<?= e($item['imagen']) ?>" data-alternativa="img/<?= e($item['alternativa']) ?>" data-nombre="<?= e($item['nombre']) ?>">Ver otra vista</button>
<?php endif ?>
</td><td><?= e($item['descripcion']) ?></td><td><?= e($item['detalle']) ?></td><td><?= $item['precio']===null ? 'Por definir' : '$'.number_format((float)$item['precio'],2) ?></td><td><a href="soporte_tecnico.php?producto=<?= (int)$item['id'] ?>">Consultar artículo</a></td></tr>
<?php endforeach ?></tbody></table></div>
<figure class="mapa-conectividad">
<h2>Un mundo conectado</h2>
<img src="img/mapa_cobertura.png" alt="Ilustración de conexiones tecnológicas entre distintas regiones del mundo" loading="lazy" width="1672" height="941">
<figcaption>Mapa ilustrativo de conectividad. No representa zonas de cobertura ni destinos de envío confirmados de MEXOTECH.</figcaption>
</figure>
</div>
<script>
document.querySelectorAll('.mx-catalogo .vista-alterna').forEach(function(boton){
 boton.addEventListener('click',function(){
  const foto=document.getElementById(boton.getAttribute('aria-controls'));
  const mostrarAlternativa=boton.getAttribute('aria-pressed')!=='true';
  foto.src=mostrarAlternativa?boton.dataset.alternativa:boton.dataset.principal;
  foto.alt=boton.dataset.nombre+(mostrarAlternativa?', vista alternativa':', vista principal');
  boton.setAttribute('aria-pressed',String(mostrarAlternativa));
  boton.textContent=mostrarAlternativa?'Ver vista principal':'Ver otra vista';
 });
});
</script>
<?php pie(); ?>
