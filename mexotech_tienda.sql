-- MEXOTECH: esquema de demostración para MySQL/MariaDB.
-- Importar en phpMyAdmin o con: mysql -u root -p < mexotech.sql
-- El sitio actual aún usa datos PHP y no escribe en estas tablas.
CREATE DATABASE IF NOT EXISTS mexotech CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mexotech;

CREATE TABLE IF NOT EXISTS categorias (
  id TINYINT UNSIGNED NOT NULL PRIMARY KEY,
  clave VARCHAR(30) NOT NULL UNIQUE,
  nombre VARCHAR(80) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS productos (
  id INT UNSIGNED NOT NULL PRIMARY KEY,
  categoria_id TINYINT UNSIGNED NOT NULL,
  nombre VARCHAR(120) NOT NULL,
  descripcion VARCHAR(500) NOT NULL,
  detalle VARCHAR(500) NOT NULL,
  imagen VARCHAR(190) NOT NULL,
  imagen_alternativa VARCHAR(190) DEFAULT NULL,
  precio DECIMAL(10,2) DEFAULT NULL,
  existencias INT UNSIGNED DEFAULT NULL,
  activo BOOLEAN NOT NULL DEFAULT TRUE,
  CONSTRAINT fk_producto_categoria FOREIGN KEY (categoria_id) REFERENCES categorias(id),
  CONSTRAINT chk_precio CHECK (precio IS NULL OR precio >= 0)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS solicitudes_soporte (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  correo VARCHAR(190) NOT NULL,
  servicio ENUM('diagnostico','pantalla','bateria','accesorios') NOT NULL,
  modelo VARCHAR(120) DEFAULT NULL,
  mensaje VARCHAR(1500) NOT NULL,
  producto_id INT UNSIGNED DEFAULT NULL,
  estado ENUM('nueva','en_revision','atendida') NOT NULL DEFAULT 'nueva',
  creada_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_soporte_fecha (creada_en),
  INDEX idx_soporte_correo (correo),
  CONSTRAINT fk_soporte_producto FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE SET NULL
) ENGINE=InnoDB;

INSERT INTO categorias (id, clave, nombre) VALUES
 (1,'equipos','Smartphones'),
 (2,'accesorios','Accesorios'),
 (3,'proteccion','Protección')
ON DUPLICATE KEY UPDATE clave=VALUES(clave), nombre=VALUES(nombre);

-- Productos ilustrativos: el sitio no confirma precios, existencias ni modelos.
INSERT INTO productos (id,categoria_id,nombre,descripcion,detalle,imagen,imagen_alternativa,precio,existencias) VALUES
 (1,1,'Smartphone para uso diario','Equipo de ejemplo para llamadas, mensajería y aplicaciones.','Modelo, capacidad y compatibilidad por definir.','prod_1.png','prod_1_alt.png',NULL,NULL),
 (2,2,'Cargador USB-C','Adaptador de pared con puerto USB-C.','Consultar potencia y compatibilidad con tu equipo.','prod_2.png',NULL,NULL,NULL),
 (3,3,'Funda protectora','Funda de diseño reforzado con soporte posterior.','Consultar el modelo y las dimensiones compatibles.','prod_3.png','prod_2_alt.png',NULL,NULL),
 (4,2,'Audífonos inalámbricos','Audífonos con estuche de carga.','Autonomía y compatibilidad por confirmar.','prod_4.png',NULL,NULL,NULL)
ON DUPLICATE KEY UPDATE categoria_id=VALUES(categoria_id),nombre=VALUES(nombre),descripcion=VALUES(descripcion),detalle=VALUES(detalle),imagen=VALUES(imagen),imagen_alternativa=VALUES(imagen_alternativa);
