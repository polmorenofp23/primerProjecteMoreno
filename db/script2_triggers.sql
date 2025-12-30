-- =====================================================================
-- TRIGGERS PER CALCULAR PREUS DE PRODUCTE I INGREDIENT
-- =====================================================================

DELIMITER $$

-- -------------------------------------------------------------
-- BEFORE INSERT: calcula portion_price per a cada línia nova
-- -------------------------------------------------------------
CREATE TRIGGER bi_product_ingredient_price
BEFORE INSERT ON product_ingredient
FOR EACH ROW
BEGIN
  DECLARE v_price_per_100g DECIMAL(10,2);

  -- 1) Obtenim el preu/100g de l'ingredient associat
  SELECT price_per_100g
  INTO v_price_per_100g
  FROM ingredient
  WHERE id_ingredient = NEW.id_ingredient;

  IF v_price_per_100g IS NULL THEN
    SET v_price_per_100g = 0;
  END IF;

  -- 2) Calculem el preu de la ració:
  --    portion_price = (grams_per_portion / 100) * price_per_100g
  SET NEW.portion_price = (NEW.grams_per_portion / 100) * v_price_per_100g;
END$$


-- -------------------------------------------------------------
-- BEFORE UPDATE: recalcula portion_price si es modifica la línia
-- -------------------------------------------------------------
CREATE TRIGGER bu_product_ingredient_price
BEFORE UPDATE ON product_ingredient
FOR EACH ROW
BEGIN
  DECLARE v_price_per_100g DECIMAL(10,2);

  SELECT price_per_100g
  INTO v_price_per_100g
  FROM ingredient
  WHERE id_ingredient = NEW.id_ingredient;

  IF v_price_per_100g IS NULL THEN
    SET v_price_per_100g = 0;
  END IF;

  SET NEW.portion_price = (NEW.grams_per_portion / 100) * v_price_per_100g;
END$$


-- Funció auxiliar: recalcular el price d'un producte concret
-- La fem com a bloc reutilitzable dins dels triggers AFTER
-- (no es pot crear FUNCTION dins un trigger, així que repetirem el bloc)
-- -------------------------------------------------------------


-- -------------------------------------------------------------
-- AFTER INSERT: quan s'afegeix un ingredient a un producte,
--               recalcula el price del producte.
-- -------------------------------------------------------------
CREATE TRIGGER ai_product_ingredient_minprice
AFTER INSERT ON product_ingredient
FOR EACH ROW
BEGIN
  UPDATE product p
  SET p.price = (
    SELECT IFNULL(SUM(pi.portion_price), 0)
    FROM product_ingredient pi
    WHERE pi.id_product = NEW.id_product
  )
  WHERE p.id_product = NEW.id_product;
END$$


-- -------------------------------------------------------------
-- AFTER UPDATE: quan es modifica una línia (grams, ingredient...),
--               recalcula el price del producte.
-- -------------------------------------------------------------
CREATE TRIGGER au_product_ingredient_minprice
AFTER UPDATE ON product_ingredient
FOR EACH ROW
BEGIN
  UPDATE product p
  SET p.price = (
    SELECT IFNULL(SUM(pi.portion_price), 0)
    FROM product_ingredient pi
    WHERE pi.id_product = NEW.id_product
  )
  WHERE p.id_product = NEW.id_product;
END$$


-- -------------------------------------------------------------
-- AFTER DELETE: quan s'elimina una línia d'ingredient d'un producte,
--               recalcula el price del producte.
-- -------------------------------------------------------------
CREATE TRIGGER ad_product_ingredient_minprice
AFTER DELETE ON product_ingredient
FOR EACH ROW
BEGIN
  UPDATE product p
  SET p.price = (
    SELECT IFNULL(SUM(pi.portion_price), 0)
    FROM product_ingredient pi
    WHERE pi.id_product = OLD.id_product
  )
  WHERE p.id_product = OLD.id_product;
END$$

-- =====================================================================
-- Triggers: log CRUD operations into `bc_logs`
-- This section creates a small stored procedure and per-table AFTER triggers
-- that insert a JSON object with the primary key values into `row_ids`.
-- NOTE: Add more triggers for other tables as needed following the same pattern.
-- =====================================================================

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