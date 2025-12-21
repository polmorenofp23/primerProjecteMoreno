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

DELIMITER ;
