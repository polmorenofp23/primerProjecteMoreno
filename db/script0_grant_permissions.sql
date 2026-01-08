-- =====================================================================
-- Script de permisos para el usuario polmq
-- Ejecutar ANTES de la creación de esquemas
-- =====================================================================

-- Otorgar todos los permisos sobre bees_cavern_db al usuario polmq
GRANT ALL PRIVILEGES ON bees_cavern_db.* TO 'polmq'@'%' IDENTIFIED BY 'Asdqwe!23';
GRANT ALL PRIVILEGES ON bees_cavern_db.* TO 'polmq'@'localhost' IDENTIFIED BY 'Asdqwe!23';

-- Aplicar cambios
FLUSH PRIVILEGES;
