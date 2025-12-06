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
  min_price         DECIMAL(10,2) NOT NULL DEFAULT 0.00, -- preu minim del plat. mirar de fer el calcul del preu amb els ingredients que el composen desde un trigger
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

/* FALTARIEN TRIGGERS DE */
-- Logs d'operacions CRUD
--  