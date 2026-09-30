<?php
require_once __DIR__.'/funciones_mexotech.php';
// Conserva una respuesta clara para formularios o enlaces antiguos. No ejecuta compras.
encabezado('Pedidos no disponibles');
echo '<p>Esta versión de MEXOTECH permite revisar las páginas y probar el formulario de soporte. Los pedidos todavía no están habilitados y no se ha guardado ni cobrado ninguna compra.</p><a class="boton" href="catalogo_electronica.php">Volver al catálogo</a>';
pie();
