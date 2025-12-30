-- =====================================================================
-- Bees Cavern DB — Script Creacio d’esquema (MySQL) v.3.0

-- @uthor: Pol Moreno Queraltó
-- =====================================================================

-- Esquema de la BD dedicat "bees_cavern_db"
CREATE DATABASE IF NOT EXISTS bees_cavern_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_0900_ai_ci;
USE bees_cavern_db;

-- Config per defecte
SET NAMES utf8mb4;
SET time_zone = 'Europe/Madrid'; -- Per les probes poso l'horari d'aqui (pero realment seria 'London' because we're Bees at Brentford)


-- USER TYPES ----
CREATE TABLE user_type (
  id_user_type    BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name            VARCHAR(80)  NOT NULL,
  description     VARCHAR(255) NULL
) ENGINE=InnoDB;

-- USERS ----
CREATE TABLE user (
  id_user         BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  id_user_type    BIGINT UNSIGNED NOT NULL,
  username        VARCHAR(60)   NOT NULL,
  role            ENUM('client','admin') NOT NULL DEFAULT 'client',
  email           VARCHAR(120)  NOT NULL,
  password_hash   VARCHAR(255)  NOT NULL,
  first_name      VARCHAR(80)   NOT NULL,
  last_name       VARCHAR(120)  NULL,
  phone           VARCHAR(30)   NULL,
  address         JSON          NULL,
  birth_date      DATE          NULL,
  registered_at   DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,

  CONSTRAINT fk_usr_usrtyp_idusrtyp FOREIGN KEY (id_user_type) REFERENCES user_type(id_user_type),
  CONSTRAINT uq_user_username UNIQUE (username),
  CONSTRAINT uq_user_email UNIQUE (email)
) ENGINE=InnoDB;

-- PRODUCT ----
CREATE TABLE product (
  id_product        BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name              VARCHAR(120) NOT NULL,
  description       TEXT NULL,
  dish_type         ENUM('appetiser','main','dessert','drink') NOT NULL, -- ("appetiser" -> entrante, "main" -> principal, "dessert" -> postre)
  price             DECIMAL(10,2) NOT NULL DEFAULT 0.00, -- preu minim del plat. mirar de fer el calcul del preu amb els ingredients que el composen desde un trigger
  img_dir           JSON NOT NULL,
  available         TINYINT(1) NOT NULL DEFAULT 1,
  created_at        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

) ENGINE=InnoDB;

-- INGREDIENT ----
CREATE TABLE ingredient (
  id_ingredient   BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name            VARCHAR(120) NOT NULL,
  category        ENUM('vegetable','fruit','meat','fish','seafood','animal_derivative','tree_nut','spice','sweetener','condiment','natural_fat','drink') NOT NULL,
  description     VARCHAR(255) NULL,
  price_per_100g  DECIMAL(10,2) NOT NULL,
  kcal_per_100g   DECIMAL(10,2) NOT NULL,
  -- img_dir         JSON NOT NULL,  
  has_doneness  TINYINT(1) NOT NULL DEFAULT 0,
  country         VARCHAR(120) NOT NULL,
  available       TINYINT(1) NOT NULL DEFAULT 1,
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ALLERGEN ---
CREATE TABLE allergen (
  id_allergen     BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name            VARCHAR(80) NOT NULL,
  description     VARCHAR(255) NULL,
  icon_dir        JSON NOT NULL
) ENGINE=InnoDB;

-- MACRONUTRIENT ---
CREATE TABLE macronutrient (
  id_macronutrient  BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name              VARCHAR(80) NOT NULL,
  description       VARCHAR(255) NULL,
  icon_dir          JSON NOT NULL
) ENGINE=InnoDB;

-- DESCOMPTE ----
CREATE TABLE discount (
  id_discount     BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name            VARCHAR(120) NOT NULL,
  description     TEXT NULL,
  percentage      TINYINT(3) UNSIGNED NOT NULL,              -- 0..100
  status          ENUM('active','inactive') NOT NULL DEFAULT 'active',
  type            ENUM('promocode', 'user_type') NOT NULL,
  -- Per promocode
  discount_code   VARCHAR(64) NULL,
  start_datetime  DATETIME NULL,
  end_datetime    DATETIME NULL,
  num_reuses      TINYINT(2) UNSIGNED NULL,                 -- NULL = il·limitat
  img_dir         JSON NULL,
  -- Per tipus d'usuari
  id_user_type    BIGINT UNSIGNED NULL,

  CONSTRAINT uq_discount_code UNIQUE (discount_code),
  CONSTRAINT fk_dis_usrtyp_idusrtyp FOREIGN KEY (id_user_type) REFERENCES user_type(id_user_type) ON DELETE SET NULL
) ENGINE=InnoDB;

-- COMANDA ---
CREATE TABLE orders (
  id_order          BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  id_user           BIGINT UNSIGNED NOT NULL,
  id_discount       BIGINT UNSIGNED NULL,
  total_amount      DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  discount_amount   DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  table_id          INT UNSIGNED NULL,
  order_status      ENUM('pending','cancelled','confirmed','in-preparation','served') NOT NULL DEFAULT 'pending',
  payment_status    ENUM('pending','rejected','cancelled','paid') NOT NULL DEFAULT 'pending',
  created_at        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  CONSTRAINT fk_ord_usr_idusr FOREIGN KEY (id_user) REFERENCES user(id_user),
  CONSTRAINT fk_ord_dis_iddis FOREIGN KEY (id_discount) REFERENCES discount(id_discount)
) ENGINE=InnoDB;

-- LÍNIA_COMANDA --- FALTARIA FEGIR AQUI EL CALCUL DE LES MACROS I KCAL PER AGILITZAR TOT?
CREATE TABLE order_line (
  id_line           BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  id_order          BIGINT UNSIGNED NOT NULL,
  id_product        BIGINT UNSIGNED NOT NULL,
  quantity          INT UNSIGNED NOT NULL,
  unit_price        DECIMAL(10,2) NOT NULL,

  CONSTRAINT fk_ordlin_ord_idord FOREIGN KEY (id_order) REFERENCES orders(id_order) ON DELETE CASCADE,
  CONSTRAINT fk_ordlin_prd_idprd FOREIGN KEY (id_product) REFERENCES product(id_product)
) ENGINE=InnoDB;



-- INGREDIENT ↔ AL·LÈRGEN (N:M) ----
CREATE TABLE ingredient_allergen (
  id_ingredient   BIGINT UNSIGNED NOT NULL,
  id_allergen     BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (id_ingredient, id_allergen),

  CONSTRAINT fk_ingall_ing_iding FOREIGN KEY (id_ingredient) REFERENCES ingredient(id_ingredient) ON DELETE CASCADE,
  CONSTRAINT fk_ingall_all_idall FOREIGN KEY (id_allergen) REFERENCES allergen(id_allergen) ON DELETE CASCADE
) ENGINE=InnoDB;

-- INGREDIENT ↔ MACRONUTRIENT (N:M) ----
CREATE TABLE ingredient_macronutrient (
  id_ingredient     BIGINT UNSIGNED NOT NULL,
  id_macronutrient  BIGINT UNSIGNED NOT NULL,
  grams_per_100g    DECIMAL(10,3)  NOT NULL, -- ex. 3.5g de fibra/100g
  PRIMARY KEY (id_ingredient, id_macronutrient),

  CONSTRAINT fk_ingmac_ing_iding FOREIGN KEY (id_ingredient) REFERENCES ingredient(id_ingredient) ON DELETE CASCADE,
  CONSTRAINT fk_ingmac_mac_idmac FOREIGN KEY (id_macronutrient) REFERENCES macronutrient(id_macronutrient) ON DELETE CASCADE
) ENGINE=InnoDB;

-- PRODUCTE ↔ INGREDIENT (N:M) ----
CREATE TABLE product_ingredient (
  id_product        BIGINT UNSIGNED NOT NULL,
  id_ingredient     BIGINT UNSIGNED NOT NULL,
  grams_per_portion DECIMAL(10,2) NOT NULL,
  portion_price     DECIMAL(10,2) NOT NULL,
  is_default        TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (id_product, id_ingredient),

  CONSTRAINT fk_prding_prd_idprd FOREIGN KEY (id_product) REFERENCES product(id_product) ON DELETE CASCADE,
  CONSTRAINT fk_prding_ing_iding FOREIGN KEY (id_ingredient) REFERENCES ingredient(id_ingredient) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- INGREDIENT ↔ LINEA_COMANDA (N:M) "complementa" ---
CREATE TABLE order_line_ingredient (
  id_line           BIGINT UNSIGNED NOT NULL,
  id_ingredient     BIGINT UNSIGNED NOT NULL,
  num_portions      TINYINT UNSIGNED NOT NULL,  
  ingredient_price  DECIMAL(12,4) NOT NULL,
  grams             DECIMAL(10,2) NOT NULL,   -- Grams calculats per trigger: racions × grams per ració
  kcal_component    DECIMAL(12,2) NOT NULL,
  protein_g         DECIMAL(12,2) NOT NULL,
  carbs_g           DECIMAL(12,2) NOT NULL,
  fat_g             DECIMAL(12,2) NOT NULL,
  origin            ENUM('default','extra') NOT NULL,
  doneness          ENUM('rare','medium-rare','medium-well','overcooked') NULL DEFAULT 'medium-rare', -- ("doneness" -> punt de coccio) + ("rare" -> sangrante/cruda/poco hecha| "medium-rare" -> al punto | "medium-well" -> bien hecha | "overcooked" -> muy hecha/quemada)
  PRIMARY KEY (id_line, id_ingredient),

  CONSTRAINT fk_ordlining_ordlin_idlin FOREIGN KEY (id_line) REFERENCES order_line(id_line) ON DELETE CASCADE,
  CONSTRAINT fk_ordlining_ing_iding FOREIGN KEY (id_ingredient) REFERENCES ingredient(id_ingredient) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- FAVORITS (guardaFavorito N:M) ---
CREATE TABLE product_favorite (
  id_user          BIGINT UNSIGNED NOT NULL,
  id_product       BIGINT UNSIGNED NOT NULL,
  created_at       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_user, id_product),

  CONSTRAINT fk_prdfav_usr_idusr FOREIGN KEY (id_user) REFERENCES user(id_user) ON DELETE CASCADE,
  CONSTRAINT fk_prdfav_prd_idprd FOREIGN KEY (id_product) REFERENCES product(id_product)
    ON DELETE CASCADE
) ENGINE=InnoDB;

-- VALORACIONS de productes (N:M) ---
CREATE TABLE product_rating (
  id_user         BIGINT UNSIGNED NOT NULL,
  id_product      BIGINT UNSIGNED NOT NULL,
  rating          TINYINT UNSIGNED NOT NULL CHECK (rating BETWEEN 1 AND 5),
  comment         TEXT NULL,
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_user, id_product),

  CONSTRAINT fk_prdrat_usr_idusr FOREIGN KEY (id_user) REFERENCES user(id_user) ON DELETE CASCADE,
  CONSTRAINT fk_prdrat_prd_idprd FOREIGN KEY (id_product) REFERENCES product(id_product) ON DELETE CASCADE
) ENGINE=InnoDB;


-- LOGS de les accions CRUD
CREATE TABLE bc_logs (
  id_log          BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  operation       ENUM('CREATE','READ','UPDATE','DELETE') NOT NULL,
  table_name      VARCHAR(80) NOT NULL,
  row_ids         JSON NOT NULL,
  performed_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  details         TEXT NULL
) ENGINE=InnoDB;

/* FALTARIEN TRIGGERS DE */
-- Logs d'operacions CRUD
--  

-- =====================================================================
-- Triggers: log CRUD operations into `bc_logs`
-- This section creates a small stored procedure and per-table AFTER triggers
-- that insert a JSON object with the primary key values into `row_ids`.
-- NOTE: Add more triggers for other tables as needed following the same pattern.
-- =====================================================================

DELIMITER $$

DROP PROCEDURE IF EXISTS bc_log_action$$
CREATE PROCEDURE bc_log_action(
  IN in_operation VARCHAR(10),
  IN in_table VARCHAR(80),
  IN in_row_ids JSON,
  IN in_details TEXT
)
BEGIN
  INSERT INTO bc_logs(`operation`, table_name, row_ids, details)
  VALUES (in_operation, in_table, in_row_ids, in_details);
END$$

-- PRODUCT
DROP TRIGGER IF EXISTS trg_product_after_insert$$
CREATE TRIGGER trg_product_after_insert
AFTER INSERT ON product
FOR EACH ROW
BEGIN
  CALL bc_log_action('CREATE', 'product', JSON_OBJECT('id_product', NEW.id_product), NULL);
END$$

DROP TRIGGER IF EXISTS trg_product_after_update$$
CREATE TRIGGER trg_product_after_update
AFTER UPDATE ON product
FOR EACH ROW
BEGIN
  CALL bc_log_action('UPDATE', 'product', JSON_OBJECT('id_product', NEW.id_product), NULL);
END$$

DROP TRIGGER IF EXISTS trg_product_after_delete$$
CREATE TRIGGER trg_product_after_delete
AFTER DELETE ON product
FOR EACH ROW
BEGIN
  CALL bc_log_action('DELETE', 'product', JSON_OBJECT('id_product', OLD.id_product), NULL);
END$$

-- INGREDIENT
DROP TRIGGER IF EXISTS trg_ingredient_after_insert$$
CREATE TRIGGER trg_ingredient_after_insert
AFTER INSERT ON ingredient
FOR EACH ROW
BEGIN
  CALL bc_log_action('CREATE', 'ingredient', JSON_OBJECT('id_ingredient', NEW.id_ingredient), NULL);
END$$

DROP TRIGGER IF EXISTS trg_ingredient_after_update$$
CREATE TRIGGER trg_ingredient_after_update
AFTER UPDATE ON ingredient
FOR EACH ROW
BEGIN
  CALL bc_log_action('UPDATE', 'ingredient', JSON_OBJECT('id_ingredient', NEW.id_ingredient), NULL);
END$$

DROP TRIGGER IF EXISTS trg_ingredient_after_delete$$
CREATE TRIGGER trg_ingredient_after_delete
AFTER DELETE ON ingredient
FOR EACH ROW
BEGIN
  CALL bc_log_action('DELETE', 'ingredient', JSON_OBJECT('id_ingredient', OLD.id_ingredient), NULL);
END$$

-- USER
DROP TRIGGER IF EXISTS trg_user_after_insert$$
CREATE TRIGGER trg_user_after_insert
AFTER INSERT ON `user`
FOR EACH ROW
BEGIN
  CALL bc_log_action('CREATE', 'user', JSON_OBJECT('id_user', NEW.id_user), NULL);
END$$

DROP TRIGGER IF EXISTS trg_user_after_update$$
CREATE TRIGGER trg_user_after_update
AFTER UPDATE ON `user`
FOR EACH ROW
BEGIN
  CALL bc_log_action('UPDATE', 'user', JSON_OBJECT('id_user', NEW.id_user), NULL);
END$$

DROP TRIGGER IF EXISTS trg_user_after_delete$$
CREATE TRIGGER trg_user_after_delete
AFTER DELETE ON `user`
FOR EACH ROW
BEGIN
  CALL bc_log_action('DELETE', 'user', JSON_OBJECT('id_user', OLD.id_user), NULL);
END$$

-- ORDERS
DROP TRIGGER IF EXISTS trg_orders_after_insert$$
CREATE TRIGGER trg_orders_after_insert
AFTER INSERT ON orders
FOR EACH ROW
BEGIN
  CALL bc_log_action('CREATE', 'orders', JSON_OBJECT('id_order', NEW.id_order), NULL);
END$$

DROP TRIGGER IF EXISTS trg_orders_after_update$$
CREATE TRIGGER trg_orders_after_update
AFTER UPDATE ON orders
FOR EACH ROW
BEGIN
  CALL bc_log_action('UPDATE', 'orders', JSON_OBJECT('id_order', NEW.id_order), NULL);
END$$

DROP TRIGGER IF EXISTS trg_orders_after_delete$$
CREATE TRIGGER trg_orders_after_delete
AFTER DELETE ON orders
FOR EACH ROW
BEGIN
  CALL bc_log_action('DELETE', 'orders', JSON_OBJECT('id_order', OLD.id_order), NULL);
END$$

-- ORDER_LINE
DROP TRIGGER IF EXISTS trg_order_line_after_insert$$
CREATE TRIGGER trg_order_line_after_insert
AFTER INSERT ON order_line
FOR EACH ROW
BEGIN
  CALL bc_log_action('CREATE', 'order_line', JSON_OBJECT('id_line', NEW.id_line), NULL);
END$$

DROP TRIGGER IF EXISTS trg_order_line_after_update$$
CREATE TRIGGER trg_order_line_after_update
AFTER UPDATE ON order_line
FOR EACH ROW
BEGIN
  CALL bc_log_action('UPDATE', 'order_line', JSON_OBJECT('id_line', NEW.id_line), NULL);
END$$

DROP TRIGGER IF EXISTS trg_order_line_after_delete$$
CREATE TRIGGER trg_order_line_after_delete
AFTER DELETE ON order_line
FOR EACH ROW
BEGIN
  CALL bc_log_action('DELETE', 'order_line', JSON_OBJECT('id_line', OLD.id_line), NULL);
END$$

-- PRODUCT_INGREDIENT (composite PK)
DROP TRIGGER IF EXISTS trg_product_ingredient_after_insert$$
CREATE TRIGGER trg_product_ingredient_after_insert
AFTER INSERT ON product_ingredient
FOR EACH ROW
BEGIN
  CALL bc_log_action('CREATE', 'product_ingredient', JSON_OBJECT('id_product', NEW.id_product, 'id_ingredient', NEW.id_ingredient), NULL);
END$$

DROP TRIGGER IF EXISTS trg_product_ingredient_after_update$$
CREATE TRIGGER trg_product_ingredient_after_update
AFTER UPDATE ON product_ingredient
FOR EACH ROW
BEGIN
  CALL bc_log_action('UPDATE', 'product_ingredient', JSON_OBJECT('id_product', NEW.id_product, 'id_ingredient', NEW.id_ingredient), NULL);
END$$

DROP TRIGGER IF EXISTS trg_product_ingredient_after_delete$$
CREATE TRIGGER trg_product_ingredient_after_delete
AFTER DELETE ON product_ingredient
FOR EACH ROW
BEGIN
  CALL bc_log_action('DELETE', 'product_ingredient', JSON_OBJECT('id_product', OLD.id_product, 'id_ingredient', OLD.id_ingredient), NULL);
END$$

-- PRODUCT_FAVORITE
DROP TRIGGER IF EXISTS trg_product_favorite_after_insert$$
CREATE TRIGGER trg_product_favorite_after_insert
AFTER INSERT ON product_favorite
FOR EACH ROW
BEGIN
  CALL bc_log_action('CREATE', 'product_favorite', JSON_OBJECT('id_user', NEW.id_user, 'id_product', NEW.id_product), NULL);
END$$

DROP TRIGGER IF EXISTS trg_product_favorite_after_delete$$
CREATE TRIGGER trg_product_favorite_after_delete
AFTER DELETE ON product_favorite
FOR EACH ROW
BEGIN
  CALL bc_log_action('DELETE', 'product_favorite', JSON_OBJECT('id_user', OLD.id_user, 'id_product', OLD.id_product), NULL);
END$$

-- PRODUCT_RATING
DROP TRIGGER IF EXISTS trg_product_rating_after_insert$$
CREATE TRIGGER trg_product_rating_after_insert
AFTER INSERT ON product_rating
FOR EACH ROW
BEGIN
  CALL bc_log_action('CREATE', 'product_rating', JSON_OBJECT('id_user', NEW.id_user, 'id_product', NEW.id_product), NULL);
END$$

DROP TRIGGER IF EXISTS trg_product_rating_after_delete$$
CREATE TRIGGER trg_product_rating_after_delete
AFTER DELETE ON product_rating
FOR EACH ROW
BEGIN
  CALL bc_log_action('DELETE', 'product_rating', JSON_OBJECT('id_user', OLD.id_user, 'id_product', OLD.id_product), NULL);
END$$

-- ALLERGEN
DROP TRIGGER IF EXISTS trg_allergen_after_insert$$
CREATE TRIGGER trg_allergen_after_insert
AFTER INSERT ON allergen
FOR EACH ROW
BEGIN
  CALL bc_log_action('CREATE', 'allergen', JSON_OBJECT('id_allergen', NEW.id_allergen), NULL);
END$$

DROP TRIGGER IF EXISTS trg_allergen_after_update$$
CREATE TRIGGER trg_allergen_after_update
AFTER UPDATE ON allergen
FOR EACH ROW
BEGIN
  CALL bc_log_action('UPDATE', 'allergen', JSON_OBJECT('id_allergen', NEW.id_allergen), NULL);
END$$

DROP TRIGGER IF EXISTS trg_allergen_after_delete$$
CREATE TRIGGER trg_allergen_after_delete
AFTER DELETE ON allergen
FOR EACH ROW
BEGIN
  CALL bc_log_action('DELETE', 'allergen', JSON_OBJECT('id_allergen', OLD.id_allergen), NULL);
END$$

-- MACRONUTRIENT
DROP TRIGGER IF EXISTS trg_macronutrient_after_insert$$
CREATE TRIGGER trg_macronutrient_after_insert
AFTER INSERT ON macronutrient
FOR EACH ROW
BEGIN
  CALL bc_log_action('CREATE', 'macronutrient', JSON_OBJECT('id_macronutrient', NEW.id_macronutrient), NULL);
END$$

DROP TRIGGER IF EXISTS trg_macronutrient_after_update$$
CREATE TRIGGER trg_macronutrient_after_update
AFTER UPDATE ON macronutrient
FOR EACH ROW
BEGIN
  CALL bc_log_action('UPDATE', 'macronutrient', JSON_OBJECT('id_macronutrient', NEW.id_macronutrient), NULL);
END$$

DROP TRIGGER IF EXISTS trg_macronutrient_after_delete$$
CREATE TRIGGER trg_macronutrient_after_delete
AFTER DELETE ON macronutrient
FOR EACH ROW
BEGIN
  CALL bc_log_action('DELETE', 'macronutrient', JSON_OBJECT('id_macronutrient', OLD.id_macronutrient), NULL);
END$$

-- DISCOUNT
DROP TRIGGER IF EXISTS trg_discount_after_insert$$
CREATE TRIGGER trg_discount_after_insert
AFTER INSERT ON discount
FOR EACH ROW
BEGIN
  CALL bc_log_action('CREATE', 'discount', JSON_OBJECT('id_discount', NEW.id_discount), NULL);
END$$

DROP TRIGGER IF EXISTS trg_discount_after_update$$
CREATE TRIGGER trg_discount_after_update
AFTER UPDATE ON discount
FOR EACH ROW
BEGIN
  CALL bc_log_action('UPDATE', 'discount', JSON_OBJECT('id_discount', NEW.id_discount), NULL);
END$$

DROP TRIGGER IF EXISTS trg_discount_after_delete$$
CREATE TRIGGER trg_discount_after_delete
AFTER DELETE ON discount
FOR EACH ROW
BEGIN
  CALL bc_log_action('DELETE', 'discount', JSON_OBJECT('id_discount', OLD.id_discount), NULL);
END$$

-- USER_TYPE
DROP TRIGGER IF EXISTS trg_user_type_after_insert$$
CREATE TRIGGER trg_user_type_after_insert
AFTER INSERT ON user_type
FOR EACH ROW
BEGIN
  CALL bc_log_action('CREATE', 'user_type', JSON_OBJECT('id_user_type', NEW.id_user_type), NULL);
END$$

DROP TRIGGER IF EXISTS trg_user_type_after_update$$
CREATE TRIGGER trg_user_type_after_update
AFTER UPDATE ON user_type
FOR EACH ROW
BEGIN
  CALL bc_log_action('UPDATE', 'user_type', JSON_OBJECT('id_user_type', NEW.id_user_type), NULL);
END$$

DROP TRIGGER IF EXISTS trg_user_type_after_delete$$
CREATE TRIGGER trg_user_type_after_delete
AFTER DELETE ON user_type
FOR EACH ROW
BEGIN
  CALL bc_log_action('DELETE', 'user_type', JSON_OBJECT('id_user_type', OLD.id_user_type), NULL);
END$$

-- ORDER_LINE_INGREDIENT (composite PK)
DROP TRIGGER IF EXISTS trg_order_line_ingredient_after_insert$$
CREATE TRIGGER trg_order_line_ingredient_after_insert
AFTER INSERT ON order_line_ingredient
FOR EACH ROW
BEGIN
  CALL bc_log_action('CREATE', 'order_line_ingredient', JSON_OBJECT('id_line', NEW.id_line, 'id_ingredient', NEW.id_ingredient), NULL);
END$$

DROP TRIGGER IF EXISTS trg_order_line_ingredient_after_delete$$
CREATE TRIGGER trg_order_line_ingredient_after_delete
AFTER DELETE ON order_line_ingredient
FOR EACH ROW
BEGIN
  CALL bc_log_action('DELETE', 'order_line_ingredient', JSON_OBJECT('id_line', OLD.id_line, 'id_ingredient', OLD.id_ingredient), NULL);
END$$

DELIMITER ;
