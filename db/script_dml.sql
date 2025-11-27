-- SCRIPT DML ---------------------

-- macronutrient (id_macronutrient, name, description, icon_dir)
-- INSERTS
INSERT INTO macronutrient (name, description, icon_dir) VALUES
('Protein', 'Macronutrient responsible for muscle repair and growth.', JSON_OBJECT()),
('Fat', 'Essential fats used for energy storage and metabolic functions.', JSON_OBJECT()),
('Carbohydrate', 'Primary source of energy for the human body.', JSON_OBJECT()),
('Water', 'Hydration component essential for all metabolic processes.', JSON_OBJECT());

-- allergen (id_allergen, name, description, icon_dir)
-- INSERTS
INSERT INTO allergen (name, description, icon_dir) VALUES
('Gluten', 'Protein found in wheat and related grains.', JSON_OBJECT()),
('Soy', 'Allergen present in soybeans and soy-based products.', JSON_OBJECT()),
('Fish', 'Allergen present in all types of fish.', JSON_OBJECT()),
('Crustaceans', 'Allergen found in crustacean shellfish such as prawns and crabs.', JSON_OBJECT()),
('Molluscs', 'Allergen found in mollusk shellfish such as clams and squid.', JSON_OBJECT()),
('Egg', 'Allergen derived from bird eggs.', JSON_OBJECT()),
('Lactose', 'Milk sugar present in dairy products.', JSON_OBJECT()),
('Mustard', 'Plant-based allergen used commonly in sauces and condiments.', JSON_OBJECT()),
('Tree Nuts', 'Allergen present in nuts such as walnuts, almonds, and hazelnuts.', JSON_OBJECT());

-- EXAMPLE OF UPDATES AND DELETES
UPDATE allergen
SET description = 'Allergen commonly found in wheat, barley and rye.'
WHERE name = 'Gluten';

UPDATE macronutrient
SET icon_dir = JSON_OBJECT('path', '/icons/macros/protein.svg')
WHERE name = 'Protein';


DELETE FROM macronutrient
WHERE name = 'Water';

-- VEGETABLES (name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
INSERT INTO ingredient 
(name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
('Spinach', 'Vegetable', 'Fresh green spinach leaves.', 2.50, 23, 0, 'England', 1),
('Broccoli', 'Vegetable', 'Fresh broccoli florets.', 2.50, 34, 0, 'Italy', 1),
('Cabbage', 'Vegetable', 'Green cabbage head.', 2.00, 25, 0, 'England', 1),
('Cauliflower', 'Vegetable', 'White cauliflower head.', 2.20, 30, 0, 'Spain', 1),
('Zucchini', 'Vegetable', 'Fresh zucchini.', 2.00, 21, 0, 'Italy', 1),
('Artichoke', 'Vegetable', 'Fresh artichoke.', 3.50, 47, 0, 'Spain', 1),
('Asparagus', 'Vegetable', 'Fresh green asparagus stalks.', 4.50, 25, 0, 'Peru', 1),
('Potato', 'Vegetable', 'Fresh potato suitable for multiple preparations.', 2.00, 77, 0, 'England', 1),
('Lettuce', 'Vegetable', 'Fresh lettuce leaves.', 1.50, 15, 0, 'England', 1),
('Arugula', 'Vegetable', 'Fresh arugula leaves.', 2.80, 30, 0, 'Italy', 1),
('Red Bell Pepper', 'Vegetable', 'Sweet red bell pepper.', 2.80, 31, 0, 'Spain', 1),
('Green Bell Pepper', 'Vegetable', 'Fresh green bell pepper.', 2.40, 24, 0, 'Mexico', 1),
('Eggplant', 'Vegetable', 'Fresh eggplant.', 2.20, 30, 0, 'Italy', 1),
('Carrot', 'Vegetable', 'Fresh orange carrots.', 2.00, 41, 0, 'France', 1),
('Cucumber', 'Vegetable', 'Fresh cucumber.', 1.80, 16, 0, 'England', 1),
('Celery', 'Vegetable', 'Fresh celery stalks.', 2.20, 16, 0, 'Netherlands', 1),
('Tomato', 'Vegetable', 'Fresh tomatoes.', 2.50, 18, 0, 'Spain', 1),
('Mushrooms', 'Vegetable', 'Fresh mushrooms.', 4.00, 28, 0, 'Poland', 1),
('Onion', 'Vegetable', 'Fresh onions.', 2.00, 40, 0, 'England', 1),
('Garlic', 'Vegetable', 'Fresh garlic bulbs.', 3.00, 149, 0, 'China', 1);

-- VEGETABLES MACRONUTRIENT (id_ingredient, id_macronutrient, grams_per_100g)
INSERT INTO ingredient_macronutrient (id_ingredient, id_macronutrient, grams_per_100g) VALUES
-- Spinach (ID 1)
(1, 1, 2.9), (1, 2, 0.4), (1, 3, 3.6), (1, 4, 91),
-- Broccoli (ID 2)
(2, 1, 2.8), (2, 2, 0.4), (2, 3, 7), (2, 4, 89),
-- Cabbage (ID 3)
(3, 1, 1.3), (3, 2, 0.1), (3, 3, 6), (3, 4, 92),
-- Cauliflower (ID 4)
(4, 1, 1.9), (4, 2, 0.3), (4, 3, 5), (4, 4, 92),
-- Zucchini (ID 5)
(5, 1, 1.2), (5, 2, 0.3), (5, 3, 3), (5, 4, 94),
-- Artichoke (ID 6)
(6, 1, 3.3), (6, 2, 0.2), (6, 3, 11), (6, 4, 84),
-- Asparagus (ID 7)
(7, 1, 2.2), (7, 2, 0.1), (7, 3, 4), (7, 4, 92),
-- Potato (ID 8)
(8, 1, 2), (8, 2, 0.1), (8, 3, 17), (8, 4, 79),
-- Lettuce (ID 9)
(9, 1, 1.2), (9, 2, 0.2), (9, 3, 2), (9, 4, 95),
-- Arugula (ID 10)
(10, 1, 2.6), (10, 2, 0.7), (10, 3, 3.7), (10, 4, 91),
-- Red Bell Pepper (ID 11)
(11, 1, 1), (11, 2, 0.3), (11, 3, 6), (11, 4, 93),
-- Green Bell Pepper (ID 12)
(12, 1, 1), (12, 2, 0.2), (12, 3, 4.6), (12, 4, 94),
-- Eggplant (ID 13)
(13, 1, 1), (13, 2, 0.2), (13, 3, 6), (13, 4, 92),
-- Carrot (ID 14)
(14, 1, 0.9), (14, 2, 0.2), (14, 3, 10), (14, 4, 88),
-- Cucumber (ID 15)
(15, 1, 0.7), (15, 2, 0.1), (15, 3, 3), (15, 4, 96),
-- Celery (ID 16)
(16, 1, 0.7), (16, 2, 0.2), (16, 3, 3), (16, 4, 95),
-- Tomato (ID 17)
(17, 1, 0.9), (17, 2, 0.2), (17, 3, 3.9), (17, 4, 94),
-- Mushrooms (ID 18)
(18, 1, 3.1), (18, 2, 0.3), (18, 3, 3.3), (18, 4, 89),
-- Onion (ID 19)
(19, 1, 1.1), (19, 2, 0.1), (19, 3, 9.3), (19, 4, 89),
-- Garlic (ID 20)
(20, 1, 6), (20, 2, 0.5), (20, 3, 33), (20, 4, 58);

-- VEGETABLES ALLERGENS No allergens for vegetable ingredients (no rows added)


-- FRUIT (name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
INSERT INTO ingredient 
(name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
('Avocado', 'Fruit', 'Fresh ripe avocado.', 4.00, 160, 0, 'Mexico', 1),
('Lemon', 'Fruit', 'Fresh yellow lemons.', 2.00, 29, 0, 'Spain', 1),
('Orange', 'Fruit', 'Fresh sweet oranges.', 2.50, 47, 0, 'England', 1),
('Mandarin', 'Fruit', 'Fresh mandarin oranges.', 2.80, 53, 0, 'Spain', 1),
('Strawberry', 'Fruit', 'Fresh strawberries.', 3.80, 32, 0, 'England', 1),
('Raspberry', 'Fruit', 'Fresh raspberries.', 4.20, 52, 0, 'Serbia', 1),
('Blueberry', 'Fruit', 'Fresh blueberries.', 4.50, 57, 0, 'Poland', 1),
('Watermelon', 'Fruit', 'Sweet red watermelon.', 2.20, 30, 0, 'Spain', 1),
('Melon', 'Fruit', 'Fresh sweet melon.', 2.40, 34, 0, 'Spain', 1),
('Mango', 'Fruit', 'Fresh ripe mango.', 3.50, 60, 0, 'Peru', 1),
('Grape', 'Fruit', 'Fresh table grapes.', 2.80, 69, 0, 'Italy', 1),
('Apple', 'Fruit', 'Fresh crunchy apples.', 2.00, 52, 0, 'England', 1),
('Pear', 'Fruit', 'Fresh sweet pears.', 2.00, 57, 0, 'Belgium', 1),
('Fig', 'Fruit', 'Fresh ripe figs.', 4.00, 74, 0, 'Turkey', 1);

-- FRUIT MACRONUTRIENT (id_ingredient, id_macronutrient, grams_per_100g)
INSERT INTO ingredient_macronutrient (id_ingredient, id_macronutrient, grams_per_100g) VALUES
-- Avocado (ID 21)
(21,1,2), (21,2,15), (21,3,9), (21,4,73),
-- Lemon (ID 22)
(22,1,1.1), (22,2,0.3), (22,3,9.3), (22,4,89),
-- Orange (ID 23)
(23,1,0.9), (23,2,0.1), (23,3,12), (23,4,86),
-- Mandarin (ID 24)
(24,1,0.8), (24,2,0.2), (24,3,13), (24,4,85),
-- Strawberry (ID 25)
(25,1,0.8), (25,2,0.3), (25,3,7.7), (25,4,91),
-- Raspberry (ID 26)
(26,1,1.5), (26,2,0.6), (26,3,12), (26,4,86),
-- Blueberry (ID 27)
(27,1,0.7), (27,2,0.3), (27,3,14), (27,4,84),
-- Watermelon (ID 28)
(28,1,0.6), (28,2,0.2), (28,3,8), (28,4,91),
-- Melon (ID 29)
(29,1,0.8), (29,2,0.2), (29,3,8), (29,4,90),
-- Mango (ID 30)
(30,1,0.8), (30,2,0.4), (30,3,15), (30,4,83),
-- Grape (ID 31)
(31,1,0.6), (31,2,0.2), (31,3,17), (31,4,81),
-- Apple (ID 32)
(32,1,0.3), (32,2,0.2), (32,3,14), (32,4,85),
-- Pear (ID 33)
(33,1,0.4), (33,2,0.1), (33,3,15), (33,4,84),
-- Fig (ID 34)
(34,1,0.8), (34,2,0.3), (34,3,19), (34,4,79);

-- FRUIT ALLERGENS No allergens for fruit ingredients (no rows added)


-- MEAT (name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
INSERT INTO ingredient
(name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
('Beef', 'Meat (unprocessed)', 'Fresh beef meat.', 7.50, 250, 1, 'England', 1),
('Chicken', 'Meat (unprocessed)', 'Fresh chicken meat.', 4.50, 140, 1, 'Spain', 1),
('Turkey', 'Meat (unprocessed)', 'Fresh turkey meat.', 5.00, 135, 1, 'England', 1),
('Iberian Pork', 'Meat (unprocessed)', 'Fresh Iberian pork meat.', 8.50, 270, 1, 'Spain', 1),
('Rabbit', 'Meat (unprocessed)', 'Fresh rabbit meat.', 6.00, 145, 1, 'France', 1),
('Lamb', 'Meat (unprocessed)', 'Fresh lamb meat.', 8.00, 290, 1, 'England', 1),
('Duck', 'Meat (unprocessed)', 'Fresh duck meat.', 9.00, 285, 1, 'France', 1),
('Venison', 'Meat (unprocessed)', 'Fresh venison meat.', 9.50, 160, 1, 'New Zealand', 1),
('Wild Boar', 'Meat (unprocessed)', 'Fresh wild boar meat.', 8.50, 180, 1, 'Italy', 1),
('Horse Meat', 'Meat (unprocessed)', 'Fresh horse meat.', 7.00, 175, 1, 'England', 1);

-- MEAT MACRONUTRIENT (id_ingredient, id_macronutrient, grams_per_100g)
INSERT INTO ingredient_macronutrient (id_ingredient, id_macronutrient, grams_per_100g) VALUES
-- Beef (ID 35)
(35,1,26), (35,2,15), (35,3,0), (35,4,59),
-- Chicken (ID 36)
(36,1,27), (36,2,3), (36,3,0), (36,4,69),
-- Turkey (ID 37)
(37,1,29), (37,2,2), (37,3,0), (37,4,70),
-- Iberian Pork (ID 38)
(38,1,24), (38,2,20), (38,3,0), (38,4,55),
-- Rabbit (ID 39)
(39,1,21), (39,2,4), (39,3,0), (39,4,73),
-- Lamb (ID 40)
(40,1,25), (40,2,20), (40,3,0), (40,4,55),
-- Duck (ID 41)
(41,1,23), (41,2,19), (41,3,0), (41,4,56),
-- Venison (ID 42)
(42,1,30), (42,2,3), (42,3,0), (42,4,67),
-- Wild Boar (ID 43)
(43,1,26), (43,2,6), (43,3,0), (43,4,65),
-- Horse Meat (ID 44)
(44,1,27), (44,2,6), (44,3,0), (44,4,66);

-- MEAT ALLERGENS No allergens for meat ingredients (no rows added)



-- FISH (name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
INSERT INTO ingredient
(name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
('Hake', 'Fish', 'Fresh hake fillet.', 6.00, 90, 1, 'Spain', 1),
('Salmon', 'Fish', 'Fresh salmon fillet.', 8.50, 208, 1, 'Norway', 1),
('Tuna', 'Fish', 'Fresh tuna loin.', 9.00, 145, 1, 'England', 1),
('Cod', 'Fish', 'Fresh cod fillet.', 6.50, 82, 1, 'Iceland', 1),
('Sea Bass', 'Fish', 'Fresh sea bass fillet.', 8.00, 96, 1, 'England', 1),
('Sea Bream', 'Fish', 'Fresh sea bream fillet.', 8.00, 118, 1, 'Greece', 1),
('Trout', 'Fish', 'Fresh trout fillet.', 6.50, 110, 1, 'England', 1),
('Monkfish', 'Fish', 'Fresh monkfish tail.', 7.50, 82, 1, 'Portugal', 1),
('Sardine', 'Fish', 'Fresh sardines.', 6.00, 208, 1, 'Morocco', 1),
('Anchovy', 'Fish', 'Fresh anchovy fillets.', 5.50, 150, 1, 'England', 1);

-- FISH MACRONUTRIENT (id_ingredient, id_macronutrient, grams_per_100g)
INSERT INTO ingredient_macronutrient (id_ingredient, id_macronutrient, grams_per_100g) VALUES
-- Hake (ID 45)
(45,1,19), (45,2,1), (45,3,0), (45,4,79),
-- Salmon (ID 46)
(46,1,20), (46,2,13), (46,3,0), (46,4,67),
-- Tuna (ID 47)
(47,1,24), (47,2,5), (47,3,0), (47,4,68),
-- Cod (ID 48)
(48,1,18), (48,2,0.7), (48,3,0), (48,4,80),
-- Sea Bass (ID 49)
(49,1,20), (49,2,2), (49,3,0), (49,4,75),
-- Sea Bream (ID 50)
(50,1,21), (50,2,4), (50,3,0), (50,4,74),
-- Trout (ID 51)
(51,1,19), (51,2,3), (51,3,0), (51,4,76),
-- Monkfish (ID 52)
(52,1,18), (52,2,0.5), (52,3,0), (52,4,81),
-- Sardine (ID 53)
(53,1,25), (53,2,10), (53,3,0), (53,4,64),
-- Anchovy (ID 54)
(54,1,29), (54,2,4), (54,3,0), (54,4,69);

-- FISH ALLERGENS
INSERT INTO ingredient_allergen (id_ingredient, id_allergen) VALUES
(45, 3),
(46, 3),
(47, 3),
(48, 3),
(49, 3),
(50, 3),
(51, 3),
(52, 3),
(53, 3),
(54, 3);


-- SEAFOOD (name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
INSERT INTO ingredient
(name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
('Shrimp', 'Seafood', 'Fresh shrimp.', 10.00, 100, 1, 'England', 1),
('Lobster', 'Seafood', 'Fresh lobster meat.', 14.00, 90, 1, 'Canada', 1),
('Cuttlefish', 'Seafood', 'Fresh cuttlefish.', 8.00, 85, 1, 'Spain', 1),
('Octopus', 'Seafood', 'Fresh octopus.', 9.00, 82, 1, 'Portugal', 1),
('Mussel', 'Seafood', 'Fresh mussels.', 6.00, 130, 1, 'England', 1);

-- SEAFOOD MACRONUTRIENT (id_ingredient, id_macronutrient, grams_per_100g)
INSERT INTO ingredient_macronutrient (id_ingredient, id_macronutrient, grams_per_100g) VALUES
-- Shrimp (ID 55)
(55,1,24), (55,2,0.3), (55,3,0), (55,4,75),
-- Lobster (ID 56)
(56,1,19), (56,2,1), (56,3,0), (56,4,78),
-- Cuttlefish (ID 57)
(57,1,16), (57,2,1), (57,3,1), (57,4,80),
-- Octopus (ID 58)
(58,1,15), (58,2,1), (58,3,2), (58,4,80),
-- Mussel (ID 59)
(59,1,24), (59,2,3), (59,3,3), (59,4,72);

-- SEAFOOD ALLERGENS
INSERT INTO ingredient_allergen (id_ingredient, id_allergen) VALUES
-- Shrimp → Crustaceans
(55, 4),
-- Lobster → Crustaceans
(56, 4),
-- Cuttlefish → Molluscs
(57, 5),
-- Octopus → Molluscs
(58, 5),
-- Mussel → Molluscs
(59, 5);



-- ANIMAL DERIVATIVES (name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
INSERT INTO ingredient
(name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
('Chicken Egg', 'Animal derivative', 'Fresh chicken eggs.', 2.00, 155, 1, 'England', 1),
('Quail Egg', 'Animal derivative', 'Fresh quail eggs.', 3.00, 155, 1, 'France', 1),
('Aged Sheep Cheese', 'Animal derivative', 'Aged sheep cheese (lactose removed).', 7.00, 420, 1, 'Spain', 1),
('Aged Cow Cheese', 'Animal derivative', 'Aged cow cheese (lactose removed).', 6.50, 400, 1, 'Netherlands', 1),
('Aged Goat Cheese', 'Animal derivative', 'Aged goat cheese (lactose removed).', 6.50, 390, 1, 'England', 1),
('Aged Mixed Cheese', 'Animal derivative', 'Aged cheese mix of sheep, cow and goat.', 6.50, 410, 1, 'Italy', 1);

-- ANIMAL DERIVATIVES MACRONUTRIENT (id_ingredient, id_macronutrient, grams_per_100g)
INSERT INTO ingredient_macronutrient (id_ingredient, id_macronutrient, grams_per_100g) VALUES
-- Chicken Egg (ID 60)
(60,1,13), (60,2,11), (60,3,1), (60,4,74),
-- Quail Egg (ID 61)
(61,1,13), (61,2,11), (61,3,1), (61,4,74),
-- Aged Sheep Cheese (ID 62)
(62,1,25), (62,2,33), (62,3,0), (62,4,38),
-- Aged Cow Cheese (ID 63)
(63,1,26), (63,2,30), (63,3,1), (63,4,40),
-- Aged Goat Cheese (ID 64)
(64,1,22), (64,2,30), (64,3,0), (64,4,42),
-- Aged Mixed Cheese (ID 65)
(65,1,24), (65,2,32), (65,3,0), (65,4,39);

-- ANIMAL DERIVATIVES ALLERGENS 
INSERT INTO ingredient_allergen (id_ingredient, id_allergen) VALUES
-- Eggs
(60, 6),
(61, 6),
-- Cheeses (milk/lactose)
(62, 7),
(63, 7),
(64, 7),
(65, 7);



-- NUTS (name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
INSERT INTO ingredient
(name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
('Almond', 'Nut', 'Raw natural almonds.', 5.00, 575, 0, 'USA', 1),
('Walnut', 'Nut', 'Raw walnut kernels.', 5.50, 654, 0, 'England', 1),
('Hazelnut', 'Nut', 'Raw hazelnuts.', 5.00, 628, 0, 'Turkey', 1),
('Cashew', 'Nut', 'Raw cashew nuts.', 5.50, 553, 0, 'Vietnam', 1),
('Pistachio', 'Nut', 'Raw pistachio nuts.', 6.00, 560, 0, 'Iran', 1),
('Macadamia', 'Nut', 'Raw macadamia nuts.', 6.50, 718, 0, 'Australia', 1),
('Pine Nut', 'Nut', 'Raw pine nuts.', 7.00, 673, 0, 'England', 1);

-- NUTS MACRONUTRIENT (id_ingredient, id_macronutrient, grams_per_100g)
INSERT INTO ingredient_macronutrient (id_ingredient, id_macronutrient, grams_per_100g) VALUES
-- Almond (ID 66)
(66,1,21), (66,2,50), (66,3,20), (66,4,4),
-- Walnut (ID 67)
(67,1,15), (67,2,65), (67,3,14), (67,4,4),
-- Hazelnut (ID 68)
(68,1,14), (68,2,61), (68,3,17), (68,4,5),
-- Cashew (ID 69)
(69,1,18), (69,2,44), (69,3,30), (69,4,5),
-- Pistachio (ID 70)
(70,1,20), (70,2,45), (70,3,28), (70,4,4),
-- Macadamia (ID 71)
(71,1,8), (71,2,76), (71,3,14), (71,4,2),
-- Pine Nut (ID 72)
(72,1,13), (72,2,68), (72,3,13), (72,4,3);

-- NUTS ALLERGENS 
INSERT INTO ingredient_allergen (id_ingredient, id_allergen) VALUES
(66, 9),
(67, 9),
(68, 9),
(69, 9),
(70, 9),
(71, 9),
(72, 9);



-- SPICES (name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
INSERT INTO ingredient
(name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
('Sea Salt', 'Spice', 'Natural sea salt.', 0.80, 0, 0, 'England', 1),
('Black Pepper', 'Spice', 'Ground black pepper.', 3.00, 255, 0, 'India', 1),
('Paprika', 'Spice', 'Sweet red paprika powder.', 3.00, 289, 0, 'Spain', 1),
('Natural Curry', 'Spice', 'Natural curry blend.', 3.50, 325, 0, 'India', 1),
('Turmeric', 'Spice', 'Ground turmeric root.', 3.00, 312, 0, 'India', 1),
('Parsley', 'Spice', 'Fresh or dried parsley.', 2.50, 36, 0, 'England', 1),
('Cumin', 'Spice', 'Ground cumin seeds.', 2.50, 375, 0, 'Turkey', 1),
('Cinnamon', 'Spice', 'Ground cinnamon.', 2.50, 247, 0, 'Madagascar', 1),
('Ginger', 'Spice', 'Ground ginger root.', 3.00, 80, 0, 'China', 1),
('Garlic Powder', 'Spice', 'Dehydrated garlic powder.', 2.50, 330, 0, 'England', 1),
('Chives', 'Spice', 'Fresh or dried chives.', 2.00, 30, 0, 'England', 1),
('Basil', 'Spice', 'Fresh or dried basil leaves.', 2.00, 23, 0, 'Italy', 1),
('Thyme', 'Spice', 'Fresh or dried thyme.', 2.50, 100, 0, 'England', 1),
('Rosemary', 'Spice', 'Fresh or dried rosemary.', 2.50, 131, 0, 'Spain', 1),
('Oregano', 'Spice', 'Fresh or dried oregano.', 2.50, 265, 0, 'Greece', 1),
('Bay Leaf', 'Spice', 'Dried bay leaves.', 2.00, 313, 0, 'Turkey', 1);

-- SPICES MACRONUTRIENT (id_ingredient, id_macronutrient, grams_per_100g)
INSERT INTO ingredient_macronutrient (id_ingredient, id_macronutrient, grams_per_100g) VALUES
-- Sea Salt (ID 73)
(73,1,0), (73,2,0), (73,3,0), (73,4,0),
-- Black Pepper (ID 74)
(74,1,10), (74,2,3), (74,3,64), (74,4,12),
-- Paprika (ID 75)
(75,1,14), (75,2,13), (75,3,54), (75,4,9),
-- Natural Curry (ID 76)
(76,1,12), (76,2,14), (76,3,58), (76,4,8),
-- Turmeric (ID 77)
(77,1,9), (77,2,3), (77,3,65), (77,4,13),
-- Parsley (ID 78)
(78,1,3), (78,2,0.8), (78,3,6), (78,4,87),
-- Cumin (ID 79)
(79,1,18), (79,2,22), (79,3,44), (79,4,8),
-- Cinnamon (ID 80)
(80,1,4), (80,2,1), (80,3,81), (80,4,11),
-- Ginger (ID 81)
(81,1,1.8), (81,2,0.8), (81,3,18), (81,4,79),
-- Garlic Powder (ID 82)
(82,1,17), (82,2,0.7), (82,3,72), (82,4,6),
-- Chives (ID 83)
(83,1,3), (83,2,0.7), (83,3,4), (83,4,91),
-- Basil (ID 84)
(84,1,3), (84,2,0.6), (84,3,2), (84,4,93),
-- Thyme (ID 85)
(85,1,5.6), (85,2,1.7), (85,3,24), (85,4,65),
-- Rosemary (ID 86)
(86,1,3.3), (86,2,5), (86,3,21), (86,4,67),
-- Oregano (ID 87)
(87,1,9), (87,2,4), (87,3,69), (87,4,10),
-- Bay Leaf (ID 88)
(88,1,8), (88,2,8), (88,3,74), (88,4,5);

-- SPICES ALLERGENS 
INSERT INTO ingredient_allergen (id_ingredient, id_allergen) VALUES
(76, 8);



-- SWEETENERS (name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
INSERT INTO ingredient
(name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
('Raw Honey', 'Sweetener', 'Unprocessed natural raw honey.', 3.50, 304, 0, 'England', 1),
('Maple Syrup', 'Sweetener', 'Pure natural maple syrup.', 3.80, 260, 0, 'Canada', 1),
('Coconut Sugar', 'Sweetener', 'Organic coconut sugar.', 3.00, 375, 0, 'Philippines', 1);

-- SWEETENERS MACRONUTRIENT (id_ingredient, id_macronutrient, grams_per_100g)
INSERT INTO ingredient_macronutrient (id_ingredient, id_macronutrient, grams_per_100g) VALUES
-- Raw Honey (ID 89)
(89,1,0.3), (89,2,0), (89,3,82), (89,4,17),
-- Maple Syrup (ID 90)
(90,1,0), (90,2,0), (90,3,67), (90,4,32),
-- Coconut Sugar (ID 91)
(91,1,0), (91,2,0), (91,3,94), (91,4,1);

-- SWEETENERS ALLERGENS No allergens for sweetener ingredients (no rows added)



-- CONDIMENTS (name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
INSERT INTO ingredient
(name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
('Homemade Tomato Sauce', 'Condiment', 'Natural homemade tomato sauce without sugar.', 2.50, 30, 0, 'Italy', 1),
('Natural Mustard', 'Condiment', 'Pure natural mustard without sugar.', 3.00, 90, 0, 'France', 1),
('Apple Vinegar', 'Condiment', 'Pure apple cider vinegar.', 1.50, 21, 0, 'England', 1),
('Avocado Sauce', 'Condiment', 'Creamy natural avocado sauce.', 4.00, 160, 0, 'Mexico', 1),
('Mushroom Sauce', 'Condiment', 'Creamy natural mushroom sauce.', 3.50, 55, 0, 'Poland', 1),
('Herb Bouquet', 'Condiment', 'Mixed natural fresh herbs.', 2.50, 45, 0, 'England', 1),
('Blueberry Sauce', 'Condiment', 'Natural blueberry sweet sauce.', 4.00, 110, 0, 'England', 1),
('Natural Orange Sauce', 'Condiment', 'Fresh orange reduction sauce.', 3.00, 55, 0, 'Spain', 1);

-- CONDIMENTS MACRONUTRIENT (id_ingredient, id_macronutrient, grams_per_100g)
INSERT INTO ingredient_macronutrient (id_ingredient, id_macronutrient, grams_per_100g) VALUES
-- Homemade Tomato Sauce (ID 92)
(92,1,1), (92,2,0.2), (92,3,5), (92,4,91),
-- Natural Mustard (ID 93)
(93,1,6), (93,2,6), (93,3,7), (93,4,70),
-- Apple Vinegar (ID 94)
(94,1,0), (94,2,0), (94,3,0.9), (94,4,95),
-- Avocado Sauce / Guacamole (ID 95)
(95,1,2), (95,2,15), (95,3,9), (95,4,73),
-- Mushroom Sauce (ID 96)
(96,1,2), (96,2,3), (96,3,4), (96,4,85),
-- Herb Bouquet (ID 97)
(97,1,4), (97,2,1), (97,3,4), (97,4,90),
-- Blueberry Sauce (ID 98)
(98,1,0.4), (98,2,0.1), (98,3,25), (98,4,70),
-- Natural Orange Sauce (ID 99)
(99,1,0.8), (99,2,0.2), (99,3,12), (99,4,85);

-- CONDIMENTS ALLERGENS
INSERT INTO ingredient_allergen (id_ingredient, id_allergen) VALUES
(93, 8);



-- NATURAL FATS (name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
INSERT INTO ingredient
(name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
('Extra Virgin Olive Oil', 'Natural fat (oil)', 'Premium extra virgin olive oil.', 2.50, 900, 0, 'Spain', 1),
('Coconut Oil', 'Natural fat (oil)', 'Unrefined natural coconut oil.', 2.50, 890, 0, 'Philippines', 1),
('Avocado Oil', 'Natural fat (oil)', 'Cold-pressed avocado oil.', 3.00, 884, 0, 'Mexico', 1),
('Natural Pork Fat', 'Natural fat (oil)', 'Rendered natural pork fat.', 2.00, 897, 0, 'England', 1),
('Natural Beef Fat', 'Natural fat (oil)', 'Rendered natural beef fat.', 2.00, 900, 0, 'Argentina', 1);

-- NATURAL FATS MACRONUTRIENT (id_ingredient, id_macronutrient, grams_per_100g)
INSERT INTO ingredient_macronutrient (id_ingredient, id_macronutrient, grams_per_100g) VALUES
-- Extra Virgin Olive Oil (ID 100)
(100,1,0), (100,2,100), (100,3,0), (100,4,0),
-- Coconut Oil (ID 101)
(101,1,0), (101,2,100), (101,3,0), (101,4,0),
-- Avocado Oil (ID 102)
(102,1,0), (102,2,100), (102,3,0), (102,4,0),
-- Natural Pork Fat (ID 103)
(103,1,0), (103,2,100), (103,3,0), (103,4,0),
-- Natural Beef Fat (ID 104)
(104,1,0), (104,2,100), (104,3,0), (104,4,0);

-- NATURAL FATS ALLERGENS No allergens for natural fats ingredients (no rows added)


-- DRINKS (name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
INSERT INTO ingredient
(name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
('Mineral Water', 'Drink', 'Natural still mineral water.', 0.60, 0, 0, 'England', 1),
('Sparkling Water', 'Drink', 'Natural sparkling water.', 0.65, 0, 0, 'Italy', 1),
('Herbal Infusion', 'Drink', 'Infused herbal drink.', 1.50, 2, 0, 'Morocco', 1),
('Green Tea', 'Drink', 'Fresh brewed green tea.', 1.80, 1, 0, 'China', 1),
('Black Coffee', 'Drink', 'Fresh brewed black coffee.', 1.20, 1, 0, 'Colombia', 1),
('Dry Wine', 'Drink', 'Natural dry wine.', 2.50, 70, 0, 'Spain', 1);

-- DRINKS MACRONUTRIENT (id_ingredient, id_macronutrient, grams_per_100g)
INSERT INTO ingredient_macronutrient (id_ingredient, id_macronutrient, grams_per_100g) VALUES
-- Mineral Water (ID 105)
(105,1,0), (105,2,0), (105,3,0), (105,4,100),
-- Sparkling Water (ID 106)
(106,1,0), (106,2,0), (106,3,0), (106,4,100),
-- Herbal Infusion (ID 107)
(107,1,0), (107,2,0), (107,3,0), (107,4,99),
-- Green Tea (ID 108)
(108,1,0), (108,2,0), (108,3,0), (108,4,99),
-- Black Coffee (ID 109)
(109,1,0.1), (109,2,0), (109,3,0), (109,4,99),
-- Dry Wine (ID 110)
(110,1,0.1), (110,2,0), (110,3,0.3), (110,4,86);

-- DRINKS ALLERGENS No allergens for drink ingredients (no rows added)



-- PLATES
-- PLATES

-- PRODUCTS
INSERT INTO product (id_product, name, description, dish_type, min_price, img_dir, available)
VALUES
  (1, 'Zucchini and Avocado Carpaccio (nuts)', 'Thinly sliced zucchini and avocado carpaccio with toasted almonds, lemon and thyme.', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (2, 'Grilled Asparagus with Natural Mustard', 'Grilled asparagus with natural mustard sauce, rosemary and olive oil.', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (3, 'Sea Bass Ceviche with Mango', 'Fresh sea bass ceviche with mango, onion, parsley, lemon and olive oil.', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (4, 'Salmon Tartare with Avocado and Pistachio', 'Fresh salmon tartare with avocado, crushed pistachios, black pepper and olive oil.', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (5, 'Quail Eggs with Grilled Mushrooms', 'Grilled mushrooms with quail eggs, chives, garlic powder and olive oil.', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (6, 'Tomato and Orange Salad with Anchovy', 'Tomato and orange salad with anchovy, arugula, oregano and olive oil.', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (7, 'Chicken Skewers with Avocado', 'Grilled chicken skewers with avocado, avocado sauce, cumin, black pepper and olive oil.', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (8, 'Beef Carpaccio with Aged Cheese and Pine Nuts', 'Thin sliced beef carpaccio with arugula, pine nuts, aged cheese, lemon and olive oil.', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (9, 'Avocado and Broccoli Dip', 'Creamy avocado and broccoli dip with carrot sticks, celery, parsley and olive oil.', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (10, 'Steamed Mussels with Lemon and Parsley', 'Steamed mussels with lemon, parsley and extra virgin olive oil.', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (11, 'Sautéed Shrimp with Green Salad', 'Sautéed shrimp with garlic, bay leaf, green salad and olive oil.', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (12, 'Baked Cauliflower Chips with Curry', 'Oven-baked cauliflower chips with natural curry, homemade tomato sauce and olive oil.', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (13, 'Scrambled Eggs with Spinach and Onion', 'Scrambled chicken eggs with spinach, onion and olive oil.', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (14, 'Roasted Eggplant with Almond and Honey', 'Roasted eggplant slices with toasted almonds, raw honey, black pepper and olive oil.', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (15, 'Marinated Sardines with Lemon and Thyme', 'Fresh sardines marinated in lemon, thyme and extra virgin olive oil.', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (16, 'Watermelon and Cucumber Salad with Pistachio', 'Fresh watermelon and cucumber salad with pistachios, lemon, basil and olive oil.', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (17, 'Grilled Mushrooms and Onion with Maple', 'Grilled mushrooms and onion glazed with maple syrup, black pepper and olive oil.', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (18, 'Cured Cheese Board with Figs', 'Selection of aged sheep, cow, goat and mixed cheeses served with fresh figs.', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (19, 'Avocado and Strawberry Salad with Macadamia', 'Fresh avocado and strawberry salad with macadamia nuts, lemon and olive oil.', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (20, 'Cabbage and Shredded Cod Broth', 'Warm broth of cabbage with shredded cod, chives and olive oil.', 'appetiser', 0.00, JSON_OBJECT(), 1),

  (21, 'Beef Entrecôte with Asparagus and Mushroom Sauce', 'Grilled beef entrecôte with asparagus, mushroom sauce and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (22, 'Lemon Roasted Chicken with Vegetables', 'Roast chicken with carrot, zucchini, lemon, thyme and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (23, 'Grilled Octopus with Vegetables', 'Grilled octopus with carrot, garlic, paprika, black pepper and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (24, 'Iberian Pork Ribs with Honey Salad', 'Iberian pork ribs with green salad, raw honey, rosemary and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (25, 'Rabbit with Garlic and Parsley', 'Rabbit stew with mushrooms, onion, parsley and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (26, 'Grilled Lamb Chops with Artichoke', 'Grilled lamb chops with sautéed artichoke, rosemary and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (27, 'Duck Breast with Orange and Asparagus', 'Roasted duck breast with orange, asparagus and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (28, 'Venison Stew with Mushrooms and Carrot', 'Slow-cooked venison with mushrooms, carrot, thyme and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (29, 'Wild Boar with Homemade Tomato Sauce', 'Wild boar with tomato sauce, cabbage, black pepper and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (30, 'Seared Tuna with Avocado and Almonds', 'Seared tuna with avocado, cucumber, almonds and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (31, 'Grilled Hake with Tomato and Arugula', 'Grilled hake fillet with tomato, arugula, lemon and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (32, 'Cod Confit with Roasted Pepper and Eggplant', 'Slow-cooked cod confit with roasted red bell pepper, eggplant, onion and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (33, 'Baked Sea Bream with Herbs', 'Oven-baked sea bream with lemon, thyme, oregano, olive oil and green salad.', 'main', 0.00, JSON_OBJECT(), 1),
  (34, 'Sea Bass with Avocado Sauce and Spinach', 'Grilled sea bass with avocado sauce and sautéed spinach.', 'main', 0.00, JSON_OBJECT(), 1),
  (35, 'Trout with Cabbage and Parsley', 'Grilled trout with cabbage, parsley and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (36, 'Monkfish with Tomato Stew', 'Monkfish in a tomato, garlic and parsley stew with olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (37, 'Egg and Vegetable Omelette with Aged Sheep Cheese', 'Omelette of chicken eggs, carrot, onion and aged sheep cheese.', 'main', 0.00, JSON_OBJECT(), 1),
  (38, 'Grilled Cuttlefish with Garlic and Salad', 'Grilled cuttlefish with garlic, parsley, lettuce and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (39, 'Octopus with Cauliflower Cream', 'Grilled octopus served on creamy cauliflower with black pepper and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (40, 'Lobster with Lemon and Fresh Herbs', 'Lobster with tomato, herb bouquet, lemon and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (41, 'Roast Chicken with Baked Vegetables', 'Roast chicken with baked carrot, herb bouquet, lemon juice and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (42, 'Beef and Vegetable Skewers', 'Grilled beef skewers with red bell pepper, zucchini, onion, cumin, black pepper and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (43, 'Horse Tenderloin with Mustard and Aged Cheese', 'Grilled horse meat with spinach, natural mustard, aged cheese and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (44, 'Iberian Pork with Sautéed Cabbage', 'Iberian pork with sautéed cabbage, apple vinegar, thyme and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (45, 'Natural Curry Chicken with Zucchini', 'Chicken stew with onion, zucchini, natural curry and coconut oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (46, 'Vegetable Frittata with Eggs', 'Egg frittata with mushrooms, spinach, onion and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (47, 'Paleo Shakshuka with Peppers and Eggplant', 'Baked eggs in tomato sauce with eggplant, red and green bell pepper and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (48, 'Warm Tuna Salad with Avocado, Berries and Almonds', 'Seared tuna with avocado, arugula, blueberries, almonds and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (49, 'Grilled Duck with Blueberries and Asparagus', 'Grilled duck with blueberries, raw honey, asparagus and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),
  (50, 'Beef Stew with Vegetables and Herb Bouquet', 'Slow-cooked beef stew with carrot, cabbage, herb bouquet and olive oil.', 'main', 0.00, JSON_OBJECT(), 1),

  (51, 'Red Berry Sorbet', 'Natural sorbet of strawberry, raspberry and blueberry sweetened with raw honey.', 'dessert', 0.00, JSON_OBJECT(), 1),
  (52, 'Lemon Sorbet', 'Natural lemon sorbet sweetened with raw honey.', 'dessert', 0.00, JSON_OBJECT(), 1),
  (53, 'Mandarin Sorbet', 'Natural mandarin sorbet sweetened with raw honey.', 'dessert', 0.00, JSON_OBJECT(), 1),
  (54, 'Melon Sorbet', 'Natural melon sorbet sweetened with raw honey.', 'dessert', 0.00, JSON_OBJECT(), 1),
  (55, 'Orange Sorbet', 'Natural orange sorbet sweetened with raw honey.', 'dessert', 0.00, JSON_OBJECT(), 1),
  (56, 'Baked Apple with Walnuts', 'Baked apple with raw honey, cinnamon and chopped walnuts.', 'dessert', 0.00, JSON_OBJECT(), 1),
  (57, 'Avocado Mousse with Pistachio', 'Creamy avocado mousse with raw honey, lemon and crushed pistachios.', 'dessert', 0.00, JSON_OBJECT(), 1),
  (58, 'Watermelon and Melon Skewers', 'Fresh fruit skewers with watermelon, melon, lemon juice and basil.', 'dessert', 0.00, JSON_OBJECT(), 1),
  (59, 'Spiced Orange with Honey and Cinnamon', 'Orange segments with raw honey and ground cinnamon.', 'dessert', 0.00, JSON_OBJECT(), 1),
  (60, 'Grapes with Toasted Sheep Cheese', 'Fresh grapes with toasted aged sheep cheese.', 'dessert', 0.00, JSON_OBJECT(), 1),
  (61, 'Figs with Mixed Nuts', 'Fresh figs with walnuts, almonds and hazelnuts.', 'dessert', 0.00, JSON_OBJECT(), 1),

  -- Drinks: dish_type set to 'appetiser' to respect current ENUM
  (62, 'Still Mineral Water - Small Bottle 330ml', 'Small bottle or glass of still mineral water (330 ml).', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (63, 'Still Mineral Water - Large Bottle 1000ml', 'Large bottle of still mineral water (1000 ml).', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (64, 'Sparkling Water - Small Bottle 330ml', 'Small bottle or glass of natural sparkling water (330 ml).', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (65, 'Sparkling Water - Large Bottle 1000ml', 'Large bottle of natural sparkling water (1000 ml).', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (66, 'Herbal Infusion - Cup 250ml', 'Individual cup of herbal infusion (250 ml).', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (67, 'Herbal Infusion - Teapot 600ml', 'Large teapot of herbal infusion for 2-3 people (600 ml).', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (68, 'Green Tea - Cup 250ml', 'Individual cup of green tea (250 ml).', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (69, 'Green Tea - Teapot 600ml', 'Large teapot of green tea for 2-3 people (600 ml).', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (70, 'Herbal Tea Blend - Cup 250ml', 'Individual cup of herbal tea blend (250 ml).', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (71, 'Herbal Tea Blend - Teapot 600ml', 'Large teapot of herbal tea blend (600 ml).', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (72, 'Black Coffee - Espresso 60ml', 'Single espresso of black coffee (60 ml).', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (73, 'Black Coffee - Americano 120ml', 'Double or long black coffee (americano) (120 ml).', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (74, 'Dry Red Wine - Glass 150ml', 'Individual glass of dry red wine (150 ml).', 'appetiser', 0.00, JSON_OBJECT(), 1),
  (75, 'Dry Red Wine - Bottle 750ml', 'Full bottle of dry red wine (750 ml).', 'appetiser', 0.00, JSON_OBJECT(), 1);


-- PRODUCT INGREDIENTS
INSERT INTO product_ingredient (id_product, id_ingredient, grams_per_portion, portion_price, is_default)
VALUES
  -- Appetisers
  -- Appetiser 1: Zucchini and Avocado Carpaccio (nuts)
  (1, 5, 110.00, 0.00, 1),  -- Zucchini
  (1, 20, 80.00, 0.00, 1),  -- Avocado
  (1, 31, 20.00, 0.00, 1),  -- Almond
  (1, 21, 20.00, 0.00, 1),  -- Lemon
  (1, 80, 5.00, 0.00, 1),   -- Thyme
  (1, 91, 15.00, 0.00, 1),  -- Extra Virgin Olive Oil

  -- Appetiser 2: Grilled Asparagus with Natural Mustard
  (2, 7, 190.00, 0.00, 1),  -- Asparagus
  (2, 88, 25.00, 0.00, 1),  -- Natural Mustard
  (2, 82, 5.00, 0.00, 1),   -- Rosemary
  (2, 91, 30.00, 0.00, 1),  -- Extra Virgin Olive Oil

  -- Appetiser 3: Sea Bass Ceviche with Mango
  (3, 34, 120.00, 0.00, 1), -- Sea Bass
  (3, 29, 60.00, 0.00, 1),  -- Mango
  (3, 18, 25.00, 0.00, 1),  -- Onion
  (3, 78, 10.00, 0.00, 1),  -- Parsley
  (3, 21, 20.00, 0.00, 1),  -- Lemon
  (3, 91, 15.00, 0.00, 1),  -- Extra Virgin Olive Oil

  -- Appetiser 4: Salmon Tartare with Avocado and Pistachio
  (4, 32, 130.00, 0.00, 1), -- Salmon
  (4, 20, 70.00, 0.00, 1),  -- Avocado
  (4, 36, 20.00, 0.00, 1),  -- Pistachio
  (4, 73, 5.00, 0.00, 1),   -- Black Pepper
  (4, 91, 25.00, 0.00, 1),  -- Extra Virgin Olive Oil

  -- Appetiser 5: Quail Eggs with Grilled Mushrooms
  (5, 52, 120.00, 0.00, 1), -- Quail Egg
  (5, 17, 100.00, 0.00, 1), -- Mushrooms
  (5, 84, 5.00, 0.00, 1),   -- Chives
  (5, 83, 3.00, 0.00, 1),   -- Garlic Powder
  (5, 91, 22.00, 0.00, 1),  -- Extra Virgin Olive Oil

  -- Appetiser 6: Tomato and Orange Salad with Anchovy
  (6, 16, 100.00, 0.00, 1), -- Tomato
  (6, 22, 70.00, 0.00, 1),  -- Orange
  (6, 40, 30.00, 0.00, 1),  -- Anchovy
  (6, 9, 30.00, 0.00, 1),   -- Arugula
  (6, 91, 15.00, 0.00, 1),  -- Extra Virgin Olive Oil
  (6, 86, 5.00, 0.00, 1),   -- Oregano

  -- Appetiser 7: Chicken Skewers with Avocado
  (7, 33, 150.00, 0.00, 1), -- Chicken
  (7, 20, 60.00, 0.00, 1),  -- Avocado
  (7, 95, 20.00, 0.00, 1),  -- Avocado Sauce / Guacamole
  (7, 79, 5.00, 0.00, 1),   -- Cumin
  (7, 73, 5.00, 0.00, 1),   -- Black Pepper
  (7, 91, 15.00, 0.00, 1),  -- Extra Virgin Olive Oil

  -- Appetiser 8: Beef Carpaccio with Aged Cheese and Pine Nuts
  (8, 31, 150.00, 0.00, 1), -- Beef
  (8, 9, 40.00, 0.00, 1),   -- Arugula
  (8, 39, 15.00, 0.00, 1),  -- Pine Nut
  (8, 47, 25.00, 0.00, 1),  -- Aged Mixed Cheese
  (8, 21, 10.00, 0.00, 1),  -- Lemon
  (8, 91, 10.00, 0.00, 1),  -- Extra Virgin Olive Oil

  -- Appetiser 9: Avocado and Broccoli Dip
  (9, 20, 100.00, 0.00, 1), -- Avocado
  (9, 2, 80.00, 0.00, 1),   -- Broccoli
  (9, 13, 40.00, 0.00, 1),  -- Carrot
  (9, 15, 15.00, 0.00, 1),  -- Celery
  (9, 78, 5.00, 0.00, 1),   -- Parsley
  (9, 91, 10.00, 0.00, 1),  -- Extra Virgin Olive Oil

  -- Appetiser 10: Steamed Mussels with Lemon and Parsley
  (10, 57, 180.00, 0.00, 1),-- Mussel
  (10, 21, 30.00, 0.00, 1), -- Lemon
  (10, 78, 10.00, 0.00, 1), -- Parsley
  (10, 91, 30.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Appetiser 11: Sautéed Shrimp with Green Salad
  (11, 55, 150.00, 0.00, 1),-- Shrimp
  (11, 19, 10.00, 0.00, 1), -- Garlic
  (11, 89, 5.00, 0.00, 1),  -- Bay Leaf
  (11, 8, 65.00, 0.00, 1),  -- Lettuce
  (11, 91, 20.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Appetiser 12: Baked Cauliflower Chips with Curry
  (12, 4, 180.00, 0.00, 1), -- Cauliflower
  (12, 87, 5.00, 0.00, 1),  -- Natural Curry
  (12, 90, 35.00, 0.00, 1), -- Homemade Tomato Sauce
  (12, 91, 30.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Appetiser 13: Scrambled Eggs with Spinach and Onion
  (13, 51, 120.00, 0.00, 1),-- Chicken Egg
  (13, 1, 100.00, 0.00, 1), -- Spinach
  (13, 18, 20.00, 0.00, 1), -- Onion
  (13, 91, 10.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Appetiser 14: Roasted Eggplant with Almond and Honey
  (14, 12, 160.00, 0.00, 1),-- Eggplant
  (14, 31, 30.00, 0.00, 1), -- Almond
  (14, 92, 10.00, 0.00, 1), -- Raw Honey
  (14, 73, 5.00, 0.00, 1),  -- Black Pepper
  (14, 91, 20.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Appetiser 15: Marinated Sardines with Lemon and Thyme
  (15, 38, 150.00, 0.00, 1),-- Sardine
  (15, 21, 40.00, 0.00, 1), -- Lemon
  (15, 80, 10.00, 0.00, 1), -- Thyme
  (15, 91, 50.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Appetiser 16: Watermelon and Cucumber Salad with Pistachio
  (16, 27, 120.00, 0.00, 1),-- Watermelon
  (16, 14, 80.00, 0.00, 1), -- Cucumber
  (16, 36, 15.00, 0.00, 1), -- Pistachio
  (16, 21, 20.00, 0.00, 1), -- Lemon
  (16, 81, 5.00, 0.00, 1),  -- Basil
  (16, 91, 10.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Appetiser 17: Grilled Mushrooms and Onion with Maple
  (17, 17, 160.00, 0.00, 1),-- Mushrooms
  (17, 18, 60.00, 0.00, 1), -- Onion
  (17, 93, 10.00, 0.00, 1), -- Maple Syrup
  (17, 73, 5.00, 0.00, 1),  -- Black Pepper
  (17, 91, 15.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Appetiser 18: Cured Cheese Board with Figs
  (18, 44, 60.00, 0.00, 1), -- Aged Sheep Cheese
  (18, 45, 60.00, 0.00, 1), -- Aged Cow Cheese
  (18, 46, 60.00, 0.00, 1), -- Aged Goat Cheese
  (18, 47, 40.00, 0.00, 1), -- Aged Mixed Cheese
  (18, 29, 30.00, 0.00, 1), -- Fig

  -- Appetiser 19: Avocado and Strawberry Salad with Macadamia
  (19, 20, 100.00, 0.00, 1),-- Avocado
  (19, 24, 80.00, 0.00, 1), -- Strawberry
  (19, 37, 20.00, 0.00, 1), -- Macadamia
  (19, 21, 30.00, 0.00, 1), -- Lemon
  (19, 91, 20.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Appetiser 20: Cabbage and Shredded Cod Broth
  (20, 41, 100.00, 0.00, 1),-- Cod
  (20, 3, 120.00, 0.00, 1), -- Cabbage
  (20, 84, 10.00, 0.00, 1), -- Chives
  (20, 91, 20.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Mains
  -- Main 21: Beef Entrecôte with Asparagus and Mushroom Sauce
  (21, 31, 350.00, 0.00, 1),-- Beef
  (21, 7, 120.00, 0.00, 1), -- Asparagus
  (21, 94, 20.00, 0.00, 1), -- Mushroom Sauce
  (21, 91, 10.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 22: Lemon Roasted Chicken with Vegetables
  (22, 33, 300.00, 0.00, 1),-- Chicken
  (22, 13, 100.00, 0.00, 1),-- Carrot
  (22, 5, 80.00, 0.00, 1),  -- Zucchini
  (22, 21, 10.00, 0.00, 1), -- Lemon
  (22, 80, 5.00, 0.00, 1),  -- Thyme
  (22, 91, 5.00, 0.00, 1),  -- Extra Virgin Olive Oil

  -- Main 23: Grilled Octopus with Vegetables
  (23, 59, 300.00, 0.00, 1),-- Octopus
  (23, 13, 100.00, 0.00, 1),-- Carrot (placeholder for potato)
  (23, 19, 10.00, 0.00, 1), -- Garlic
  (23, 74, 5.00, 0.00, 1),  -- Paprika
  (23, 73, 5.00, 0.00, 1),  -- Black Pepper
  (23, 91, 80.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 24: Iberian Pork Ribs with Honey Salad
  (24, 34, 320.00, 0.00, 1),-- Iberian Pork
  (24, 8, 130.00, 0.00, 1), -- Lettuce
  (24, 92, 10.00, 0.00, 1), -- Raw Honey
  (24, 82, 5.00, 0.00, 1),  -- Rosemary
  (24, 91, 35.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 25: Rabbit with Garlic and Parsley
  (25, 35, 300.00, 0.00, 1),-- Rabbit
  (25, 17, 100.00, 0.00, 1),-- Mushrooms
  (25, 18, 60.00, 0.00, 1), -- Onion
  (25, 78, 10.00, 0.00, 1), -- Parsley
  (25, 91, 30.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 26: Grilled Lamb Chops with Artichoke
  (26, 36, 330.00, 0.00, 1),-- Lamb
  (26, 6, 120.00, 0.00, 1), -- Artichoke
  (26, 82, 10.00, 0.00, 1), -- Rosemary
  (26, 91, 40.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 27: Duck Breast with Orange and Asparagus
  (27, 37, 300.00, 0.00, 1),-- Duck
  (27, 22, 100.00, 0.00, 1),-- Orange
  (27, 7, 80.00, 0.00, 1),  -- Asparagus
  (27, 91, 20.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 28: Venison Stew with Mushrooms and Carrot
  (28, 38, 320.00, 0.00, 1),-- Venison
  (28, 17, 100.00, 0.00, 1),-- Mushrooms
  (28, 13, 60.00, 0.00, 1), -- Carrot
  (28, 80, 10.00, 0.00, 1), -- Thyme
  (28, 91, 10.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 29: Wild Boar with Homemade Tomato Sauce
  (29, 39, 320.00, 0.00, 1),-- Wild Boar
  (29, 16, 100.00, 0.00, 1),-- Tomato
  (29, 3, 60.00, 0.00, 1),  -- Cabbage
  (29, 73, 10.00, 0.00, 1), -- Black Pepper
  (29, 91, 10.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 30: Seared Tuna with Avocado and Almonds
  (30, 42, 300.00, 0.00, 1),-- Tuna
  (30, 20, 80.00, 0.00, 1), -- Avocado
  (30, 14, 60.00, 0.00, 1), -- Cucumber
  (30, 31, 40.00, 0.00, 1), -- Almond
  (30, 91, 20.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 31: Grilled Hake with Tomato and Arugula
  (31, 43, 320.00, 0.00, 1),-- Hake
  (31, 16, 80.00, 0.00, 1), -- Tomato
  (31, 9, 80.00, 0.00, 1),  -- Arugula
  (31, 21, 10.00, 0.00, 1), -- Lemon
  (31, 91, 10.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 32: Cod Confit with Roasted Pepper and Eggplant
  (32, 41, 280.00, 0.00, 1),-- Cod
  (32, 10, 80.00, 0.00, 1), -- Red Bell Pepper
  (32, 12, 80.00, 0.00, 1), -- Eggplant
  (32, 18, 40.00, 0.00, 1), -- Onion
  (32, 91, 20.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 33: Baked Sea Bream with Herbs
  (33, 44, 320.00, 0.00, 1),-- Sea Bream
  (33, 21, 30.00, 0.00, 1), -- Lemon
  (33, 80, 10.00, 0.00, 1), -- Thyme
  (33, 86, 10.00, 0.00, 1), -- Oregano
  (33, 91, 30.00, 0.00, 1), -- Extra Virgin Olive Oil
  (33, 8, 100.00, 0.00, 1), -- Lettuce

  -- Main 34: Sea Bass with Avocado Sauce and Spinach
  (34, 34, 300.00, 0.00, 1),-- Sea Bass
  (34, 20, 100.00, 0.00, 1),-- Avocado
  (34, 1, 80.00, 0.00, 1),  -- Spinach
  (34, 91, 20.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 35: Trout with Cabbage and Parsley
  (35, 45, 320.00, 0.00, 1),-- Trout
  (35, 3, 120.00, 0.00, 1), -- Cabbage
  (35, 78, 10.00, 0.00, 1), -- Parsley
  (35, 91, 50.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 36: Monkfish with Tomato Stew
  (36, 46, 300.00, 0.00, 1),-- Monkfish
  (36, 16, 120.00, 0.00, 1),-- Tomato
  (36, 19, 10.00, 0.00, 1), -- Garlic
  (36, 78, 10.00, 0.00, 1), -- Parsley
  (36, 91, 60.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 37: Egg and Vegetable Omelette with Aged Sheep Cheese
  (37, 51, 180.00, 0.00, 1),-- Chicken Egg
  (37, 13, 200.00, 0.00, 1),-- Carrot (placeholder for potato)
  (37, 18, 80.00, 0.00, 1), -- Onion
  (37, 44, 40.00, 0.00, 1), -- Aged Sheep Cheese

  -- Main 38: Grilled Cuttlefish with Garlic and Salad
  (38, 58, 320.00, 0.00, 1),-- Cuttlefish
  (38, 19, 10.00, 0.00, 1), -- Garlic
  (38, 78, 10.00, 0.00, 1), -- Parsley
  (38, 8, 120.00, 0.00, 1), -- Lettuce
  (38, 91, 40.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 39: Octopus with Cauliflower Cream
  (39, 59, 280.00, 0.00, 1),-- Octopus
  (39, 4, 180.00, 0.00, 1), -- Cauliflower
  (39, 73, 10.00, 0.00, 1), -- Black Pepper
  (39, 91, 30.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 40: Lobster with Lemon and Fresh Herbs
  (40, 60, 300.00, 0.00, 1),-- Lobster
  (40, 16, 100.00, 0.00, 1),-- Tomato
  (40, 99, 20.00, 0.00, 1), -- Herb Bouquet
  (40, 21, 30.00, 0.00, 1), -- Lemon
  (40, 91, 50.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 41: Roast Chicken with Baked Vegetables
  (41, 33, 300.00, 0.00, 1),-- Chicken
  (41, 13, 150.00, 0.00, 1),-- Carrot (placeholder for baked potatoes)
  (41, 99, 20.00, 0.00, 1), -- Herb Bouquet
  (41, 21, 10.00, 0.00, 1), -- Lemon
  (41, 91, 20.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 42: Beef and Vegetable Skewers
  (42, 31, 250.00, 0.00, 1),-- Beef
  (42, 10, 80.00, 0.00, 1), -- Red Bell Pepper
  (42, 5, 80.00, 0.00, 1),  -- Zucchini
  (42, 18, 60.00, 0.00, 1), -- Onion
  (42, 79, 10.00, 0.00, 1), -- Cumin
  (42, 73, 10.00, 0.00, 1), -- Black Pepper
  (42, 91, 20.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 43: Horse Tenderloin with Mustard and Aged Cheese
  (43, 61, 300.00, 0.00, 1),-- Horse Meat
  (43, 1, 120.00, 0.00, 1), -- Spinach
  (43, 88, 30.00, 0.00, 1), -- Natural Mustard
  (43, 47, 30.00, 0.00, 1), -- Aged Mixed Cheese
  (43, 91, 20.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 44: Iberian Pork with Sautéed Cabbage
  (44, 34, 320.00, 0.00, 1),-- Iberian Pork
  (44, 3, 100.00, 0.00, 1), -- Cabbage
  (44, 89, 10.00, 0.00, 1), -- Apple Vinegar
  (44, 80, 10.00, 0.00, 1), -- Thyme
  (44, 91, 60.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 45: Natural Curry Chicken with Zucchini
  (45, 33, 300.00, 0.00, 1),-- Chicken
  (45, 18, 100.00, 0.00, 1),-- Onion
  (45, 5, 80.00, 0.00, 1),  -- Zucchini
  (45, 87, 10.00, 0.00, 1), -- Natural Curry
  (45, 96, 10.00, 0.00, 1), -- Coconut Oil

  -- Main 46: Vegetable Frittata with Eggs
  (46, 51, 180.00, 0.00, 1),-- Chicken Egg
  (46, 17, 150.00, 0.00, 1),-- Mushrooms
  (46, 1, 120.00, 0.00, 1), -- Spinach
  (46, 18, 30.00, 0.00, 1), -- Onion
  (46, 91, 20.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 47: Paleo Shakshuka with Peppers and Eggplant
  (47, 51, 120.00, 0.00, 1),-- Chicken Egg
  (47, 16, 200.00, 0.00, 1),-- Tomato
  (47, 12, 80.00, 0.00, 1), -- Eggplant
  (47, 10, 50.00, 0.00, 1), -- Red Bell Pepper
  (47, 11, 30.00, 0.00, 1), -- Green Bell Pepper
  (47, 91, 20.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 48: Warm Tuna Salad with Avocado, Berries and Almonds
  (48, 42, 200.00, 0.00, 1),-- Tuna
  (48, 20, 100.00, 0.00, 1),-- Avocado
  (48, 9, 80.00, 0.00, 1),  -- Arugula
  (48, 26, 60.00, 0.00, 1), -- Blueberry
  (48, 31, 30.00, 0.00, 1), -- Almond
  (48, 91, 30.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 49: Grilled Duck with Blueberries and Asparagus
  (49, 37, 300.00, 0.00, 1),-- Duck
  (49, 26, 60.00, 0.00, 1), -- Blueberry
  (49, 92, 20.00, 0.00, 1), -- Raw Honey
  (49, 7, 100.00, 0.00, 1), -- Asparagus
  (49, 91, 20.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Main 50: Beef Stew with Vegetables and Herb Bouquet
  (50, 31, 320.00, 0.00, 1),-- Beef
  (50, 13, 80.00, 0.00, 1), -- Carrot
  (50, 3, 80.00, 0.00, 1),  -- Cabbage
  (50, 99, 10.00, 0.00, 1), -- Herb Bouquet
  (50, 91, 10.00, 0.00, 1), -- Extra Virgin Olive Oil

  -- Desserts
  -- Dessert 51: Red Berry Sorbet
  (51, 24, 70.00, 0.00, 1), -- Strawberry
  (51, 25, 50.00, 0.00, 1), -- Raspberry
  (51, 26, 40.00, 0.00, 1), -- Blueberry
  (51, 92, 20.00, 0.00, 1), -- Raw Honey

  -- Dessert 52: Lemon Sorbet
  (52, 21, 150.00, 0.00, 1),-- Lemon
  (52, 92, 30.00, 0.00, 1), -- Raw Honey

  -- Dessert 53: Mandarin Sorbet
  (53, 23, 150.00, 0.00, 1),-- Mandarin
  (53, 92, 30.00, 0.00, 1), -- Raw Honey

  -- Dessert 54: Melon Sorbet
  (54, 28, 150.00, 0.00, 1),-- Melon
  (54, 92, 30.00, 0.00, 1), -- Raw Honey

  -- Dessert 55: Orange Sorbet
  (55, 22, 150.00, 0.00, 1),-- Orange
  (55, 92, 30.00, 0.00, 1), -- Raw Honey

  -- Dessert 56: Baked Apple with Walnuts
  (56, 30, 120.00, 0.00, 1),-- Apple
  (56, 92, 30.00, 0.00, 1), -- Raw Honey
  (56, 75, 5.00, 0.00, 1),  -- Cinnamon
  (56, 32, 25.00, 0.00, 1), -- Walnut

  -- Dessert 57: Avocado Mousse with Pistachio
  (57, 20, 100.00, 0.00, 1),-- Avocado
  (57, 92, 40.00, 0.00, 1), -- Raw Honey
  (57, 21, 20.00, 0.00, 1), -- Lemon
  (57, 36, 20.00, 0.00, 1), -- Pistachio

  -- Dessert 58: Watermelon and Melon Skewers
  (58, 27, 90.00, 0.00, 1), -- Watermelon
  (58, 28, 70.00, 0.00, 1), -- Melon
  (58, 21, 10.00, 0.00, 1), -- Lemon
  (58, 81, 10.00, 0.00, 1), -- Basil

  -- Dessert 59: Spiced Orange with Honey and Cinnamon
  (59, 22, 150.00, 0.00, 1),-- Orange
  (59, 92, 20.00, 0.00, 1), -- Raw Honey
  (59, 75, 10.00, 0.00, 1), -- Cinnamon

  -- Dessert 60: Grapes with Toasted Sheep Cheese
  (60, 30, 120.00, 0.00, 1),-- Grape
  (60, 44, 60.00, 0.00, 1), -- Aged Sheep Cheese

  -- Dessert 61: Figs with Mixed Nuts
  (61, 29, 100.00, 0.00, 1),-- Fig
  (61, 32, 30.00, 0.00, 1), -- Walnut
  (61, 31, 30.00, 0.00, 1), -- Almond
  (61, 33, 20.00, 0.00, 1), -- Hazelnut

  -- Drinks (dish_type = 'appetiser' in product)
  -- Drink 62: Still Mineral Water - Small Bottle 330ml
  (62, 105, 330.00, 0.00, 1),-- Mineral Water
  -- Drink 63: Still Mineral Water - Large Bottle 1000ml
  (63, 105, 1000.00, 0.00, 1),-- Mineral Water
  -- Drink 64: Sparkling Water - Small Bottle 330ml
  (64, 106, 330.00, 0.00, 1),-- Sparkling Water
  -- Drink 65: Sparkling Water - Large Bottle 1000ml
  (65, 106, 1000.00, 0.00, 1),-- Sparkling Water

  -- Drink 66: Herbal Infusion - Cup 250ml
  (66, 107, 250.00, 0.00, 1),-- Herbal Infusion
  -- Drink 67: Herbal Infusion - Teapot 600ml
  (67, 107, 600.00, 0.00, 1),-- Herbal Infusion

  -- Drink 68: Green Tea - Cup 250ml
  (68, 108, 250.00, 0.00, 1),-- Green Tea
  -- Drink 69: Green Tea - Teapot 600ml
  (69, 108, 600.00, 0.00, 1),-- Green Tea

  -- Drink 70: Herbal Tea Blend - Cup 250ml
  (70, 107, 250.00, 0.00, 1),-- Herbal Infusion (Herbal Tea Blend)
  -- Drink 71: Herbal Tea Blend - Teapot 600ml
  (71, 107, 600.00, 0.00, 1),-- Herbal Infusion (Herbal Tea Blend)

  -- Drink 72: Black Coffee - Espresso 60ml
  (72, 109, 60.00, 0.00, 1), -- Black Coffee
  -- Drink 73: Black Coffee - Americano 120ml
  (73, 109, 120.00, 0.00, 1),-- Black Coffee

  -- Drink 74: Dry Red Wine - Glass 150ml
  (74, 110, 150.00, 0.00, 1),-- Dry Wine
  -- Drink 75: Dry Red Wine - Bottle 750ml
  (75, 110, 750.00, 0.00, 1);-- Dry Wine


-- ============================
-- EXTRA INGREDIENTS (is_default = 0)
-- ============================
-- Each product gets ~5 optional extra ingredients that complement the dish
-- Format: (id_product, id_ingredient, grams_per_portion, portion_price, is_default=0)

INSERT INTO product_ingredient (id_product, id_ingredient, grams_per_portion, portion_price, is_default)
VALUES
-- Appetiser 1: Zucchini and Avocado Carpaccio (nuts) - Add more nuts/cheese
(1, 67, 15.00, 1.50, 0), -- Walnut
(1, 70, 15.00, 1.50, 0), -- Pistachio
(1, 62, 40.00, 2.00, 0), -- Aged Sheep Cheese
(1, 16, 50.00, 1.00, 0), -- Tomato
(1, 9, 30.00, 0.80, 0),  -- Arugula

-- Appetiser 2: Grilled Asparagus with Natural Mustard - Add proteins/nuts
(2, 61, 80.00, 1.80, 0), -- Chicken Egg
(2, 66, 20.00, 1.50, 0), -- Almond
(2, 63, 30.00, 2.00, 0), -- Aged Cow Cheese
(2, 17, 40.00, 1.00, 0), -- Mushrooms
(2, 16, 50.00, 1.00, 0), -- Tomato

-- Appetiser 3: Sea Bass Ceviche with Mango - Add fruits/vegetables
(3, 21, 30.00, 0.80, 0), -- Avocado
(3, 14, 40.00, 0.80, 0), -- Cucumber
(3, 11, 30.00, 0.80, 0), -- Red Bell Pepper
(3, 66, 15.00, 1.50, 0), -- Almond
(3, 24, 40.00, 1.00, 0), -- Strawberry

-- Appetiser 4: Salmon Tartare with Avocado and Pistachio - Add more nuts
(4, 66, 20.00, 1.50, 0), -- Almond
(4, 67, 20.00, 1.50, 0), -- Walnut
(4, 14, 50.00, 0.80, 0), -- Cucumber
(4, 9, 30.00, 0.80, 0),  -- Arugula
(4, 22, 20.00, 0.80, 0), -- Orange

-- Appetiser 5: Quail Eggs with Grilled Mushrooms - Add cheeses/vegetables
(5, 62, 40.00, 2.00, 0), -- Aged Sheep Cheese
(5, 1, 50.00, 0.80, 0),  -- Spinach
(5, 16, 50.00, 1.00, 0), -- Tomato
(5, 18, 30.00, 0.80, 0), -- Onion
(5, 78, 5.00, 0.50, 0),  -- Parsley

-- Appetiser 6: Tomato and Orange Salad with Anchovy - Add nuts/cheese
(6, 66, 20.00, 1.50, 0), -- Almond
(6, 70, 15.00, 1.50, 0), -- Pistachio
(6, 62, 30.00, 2.00, 0), -- Aged Sheep Cheese
(6, 14, 50.00, 0.80, 0), -- Cucumber
(6, 8, 40.00, 0.80, 0),  -- Lettuce

-- Appetiser 7: Chicken Skewers with Avocado - Add vegetables
(7, 11, 50.00, 0.80, 0), -- Red Bell Pepper
(7, 18, 40.00, 0.80, 0), -- Onion
(7, 16, 50.00, 1.00, 0), -- Tomato
(7, 8, 40.00, 0.80, 0),  -- Lettuce
(7, 66, 15.00, 1.50, 0), -- Almond

-- Appetiser 8: Beef Carpaccio with Aged Cheese and Pine Nuts - Add more nuts/cheese
(8, 66, 20.00, 1.50, 0), -- Almond
(8, 67, 20.00, 1.50, 0), -- Walnut
(8, 62, 30.00, 2.00, 0), -- Aged Sheep Cheese
(8, 16, 50.00, 1.00, 0), -- Tomato
(8, 70, 15.00, 1.50, 0), -- Pistachio

-- Appetiser 9: Avocado and Broccoli Dip - Add vegetables/nuts
(9, 16, 60.00, 1.00, 0), -- Tomato
(9, 11, 40.00, 0.80, 0), -- Red Bell Pepper
(9, 66, 20.00, 1.50, 0), -- Almond
(9, 8, 40.00, 0.80, 0),  -- Lettuce
(9, 18, 30.00, 0.80, 0), -- Onion

-- Appetiser 10: Steamed Mussels with Lemon and Parsley - Add vegetables
(10, 16, 80.00, 1.00, 0), -- Tomato
(10, 18, 40.00, 0.80, 0), -- Onion
(10, 19, 10.00, 0.50, 0), -- Garlic
(10, 11, 50.00, 0.80, 0), -- Red Bell Pepper
(10, 8, 50.00, 0.80, 0),  -- Lettuce

-- Appetiser 11: Sautéed Shrimp with Green Salad - Add vegetables
(11, 16, 60.00, 1.00, 0), -- Tomato
(11, 14, 50.00, 0.80, 0), -- Cucumber
(11, 9, 40.00, 0.80, 0),  -- Arugula
(11, 21, 50.00, 0.80, 0), -- Avocado
(11, 11, 40.00, 0.80, 0), -- Red Bell Pepper

-- Appetiser 12: Baked Cauliflower Chips with Curry - Add cheese/nuts
(12, 62, 40.00, 2.00, 0), -- Aged Sheep Cheese
(12, 66, 20.00, 1.50, 0), -- Almond
(12, 78, 10.00, 0.50, 0), -- Parsley
(12, 18, 40.00, 0.80, 0), -- Onion
(12, 19, 10.00, 0.50, 0), -- Garlic

-- Appetiser 13: Scrambled Eggs with Spinach and Onion - Add cheese/meat
(13, 62, 40.00, 2.00, 0), -- Aged Sheep Cheese
(13, 17, 60.00, 1.00, 0), -- Mushrooms
(13, 16, 50.00, 1.00, 0), -- Tomato
(13, 33, 50.00, 3.00, 0), -- Chicken
(13, 78, 10.00, 0.50, 0), -- Parsley

-- Appetiser 14: Roasted Eggplant with Almond and Honey - Add nuts/cheese
(14, 67, 25.00, 1.50, 0), -- Walnut
(14, 70, 20.00, 1.50, 0), -- Pistachio
(14, 62, 40.00, 2.00, 0), -- Aged Sheep Cheese
(14, 9, 30.00, 0.80, 0),  -- Arugula
(14, 16, 50.00, 1.00, 0), -- Tomato

-- Appetiser 15: Marinated Sardines with Lemon and Thyme - Add vegetables
(15, 16, 80.00, 1.00, 0), -- Tomato
(15, 18, 40.00, 0.80, 0), -- Onion
(15, 11, 50.00, 0.80, 0), -- Red Bell Pepper
(15, 8, 50.00, 0.80, 0),  -- Lettuce
(15, 9, 40.00, 0.80, 0),  -- Arugula

-- Appetiser 16: Watermelon and Cucumber Salad with Pistachio - Add nuts/cheese
(16, 66, 20.00, 1.50, 0), -- Almond
(16, 67, 20.00, 1.50, 0), -- Walnut
(16, 62, 30.00, 2.00, 0), -- Aged Sheep Cheese
(16, 25, 40.00, 1.20, 0), -- Raspberry
(16, 9, 30.00, 0.80, 0),  -- Arugula

-- Appetiser 17: Grilled Mushrooms and Onion with Maple - Add cheese/nuts
(17, 62, 40.00, 2.00, 0), -- Aged Sheep Cheese
(17, 66, 20.00, 1.50, 0), -- Almond
(17, 78, 10.00, 0.50, 0), -- Parsley
(17, 19, 10.00, 0.50, 0), -- Garlic
(17, 82, 5.00, 0.50, 0),  -- Rosemary

-- Appetiser 18: Cured Cheese Board with Figs - Add nuts/fruits
(18, 66, 30.00, 1.50, 0), -- Almond
(18, 67, 30.00, 1.50, 0), -- Walnut
(18, 68, 25.00, 1.50, 0), -- Hazelnut
(18, 30, 60.00, 1.00, 0), -- Grape
(18, 89, 20.00, 1.00, 0), -- Raw Honey

-- Appetiser 19: Avocado and Strawberry Salad with Macadamia - Add nuts/fruits
(19, 66, 20.00, 1.50, 0), -- Almond
(19, 70, 20.00, 1.50, 0), -- Pistachio
(19, 26, 40.00, 1.20, 0), -- Blueberry
(19, 25, 40.00, 1.20, 0), -- Raspberry
(19, 8, 50.00, 0.80, 0),  -- Lettuce

-- Appetiser 20: Cabbage and Shredded Cod Broth - Add vegetables
(20, 13, 80.00, 0.80, 0), -- Carrot
(20, 8, 60.00, 0.80, 0),  -- Potato (placeholder)
(20, 18, 40.00, 0.80, 0), -- Onion
(20, 78, 10.00, 0.50, 0), -- Parsley
(20, 19, 10.00, 0.50, 0), -- Garlic

-- Main 21: Beef Entrecôte with Asparagus and Mushroom Sauce - Add vegetables/cheese
(21, 1, 100.00, 1.00, 0), -- Spinach
(21, 11, 80.00, 1.00, 0), -- Red Bell Pepper
(21, 62, 50.00, 2.50, 0), -- Aged Sheep Cheese
(21, 18, 60.00, 1.00, 0), -- Onion
(21, 82, 10.00, 0.80, 0), -- Rosemary

-- Main 22: Lemon Roasted Chicken with Vegetables - Add more vegetables
(22, 2, 100.00, 1.00, 0), -- Broccoli
(22, 4, 100.00, 1.00, 0), -- Cauliflower
(22, 11, 80.00, 1.00, 0), -- Red Bell Pepper
(22, 18, 60.00, 1.00, 0), -- Onion
(22, 19, 15.00, 0.80, 0), -- Garlic

-- Main 23: Grilled Octopus with Vegetables - Add more vegetables
(23, 16, 100.00, 1.20, 0), -- Tomato
(23, 11, 80.00, 1.00, 0),  -- Red Bell Pepper
(23, 18, 60.00, 1.00, 0),  -- Onion
(23, 8, 80.00, 1.00, 0),   -- Potato (placeholder)
(23, 78, 15.00, 0.80, 0),  -- Parsley

-- Main 24: Iberian Pork Ribs with Honey Salad - Add vegetables/cheese
(24, 16, 100.00, 1.20, 0), -- Tomato
(24, 14, 80.00, 1.00, 0),  -- Cucumber
(24, 9, 60.00, 1.00, 0),   -- Arugula
(24, 62, 50.00, 2.50, 0),  -- Aged Sheep Cheese
(24, 21, 50.00, 1.00, 0),  -- Avocado

-- Main 25: Rabbit with Garlic and Parsley - Add vegetables
(25, 13, 100.00, 1.00, 0), -- Carrot
(25, 11, 80.00, 1.00, 0),  -- Red Bell Pepper
(25, 16, 80.00, 1.20, 0),  -- Tomato
(25, 4, 100.00, 1.00, 0),  -- Cauliflower
(25, 82, 10.00, 0.80, 0),  -- Rosemary

-- Main 26: Grilled Lamb Chops with Artichoke - Add vegetables
(26, 1, 100.00, 1.00, 0),  -- Spinach
(26, 13, 100.00, 1.00, 0), -- Carrot
(26, 11, 80.00, 1.00, 0),  -- Red Bell Pepper
(26, 18, 60.00, 1.00, 0),  -- Onion
(26, 19, 15.00, 0.80, 0),  -- Garlic

-- Main 27: Duck Breast with Orange and Asparagus - Add fruits/vegetables
(27, 23, 80.00, 1.00, 0),  -- Mandarin
(27, 1, 100.00, 1.00, 0),  -- Spinach
(27, 11, 80.00, 1.00, 0),  -- Red Bell Pepper
(27, 26, 50.00, 1.50, 0),  -- Blueberry
(27, 89, 20.00, 1.20, 0),  -- Raw Honey

-- Main 28: Venison Stew with Mushrooms and Carrot - Add vegetables
(28, 8, 120.00, 1.00, 0),  -- Potato (placeholder)
(28, 18, 80.00, 1.00, 0),  -- Onion
(28, 3, 100.00, 1.00, 0),  -- Cabbage
(28, 11, 80.00, 1.00, 0),  -- Red Bell Pepper
(28, 19, 15.00, 0.80, 0),  -- Garlic

-- Main 29: Wild Boar with Homemade Tomato Sauce - Add vegetables
(29, 11, 100.00, 1.00, 0), -- Red Bell Pepper
(29, 18, 80.00, 1.00, 0),  -- Onion
(29, 13, 100.00, 1.00, 0), -- Carrot
(29, 19, 15.00, 0.80, 0),  -- Garlic
(29, 82, 10.00, 0.80, 0),  -- Rosemary

-- Main 30: Seared Tuna with Avocado and Almonds - Add vegetables/nuts
(30, 9, 80.00, 1.00, 0),   -- Arugula
(30, 16, 80.00, 1.20, 0),  -- Tomato
(30, 67, 30.00, 1.80, 0),  -- Walnut
(30, 70, 25.00, 1.80, 0),  -- Pistachio
(30, 8, 60.00, 1.00, 0),   -- Lettuce

-- Main 31: Grilled Hake with Tomato and Arugula - Add vegetables
(31, 18, 60.00, 1.00, 0),  -- Onion
(31, 11, 80.00, 1.00, 0),  -- Red Bell Pepper
(31, 19, 15.00, 0.80, 0),  -- Garlic
(31, 1, 100.00, 1.00, 0),  -- Spinach
(31, 78, 15.00, 0.80, 0),  -- Parsley

-- Main 32: Cod Confit with Roasted Pepper and Eggplant - Add vegetables
(32, 16, 100.00, 1.20, 0), -- Tomato
(32, 5, 100.00, 1.00, 0),  -- Zucchini
(32, 19, 15.00, 0.80, 0),  -- Garlic
(32, 4, 100.00, 1.00, 0),  -- Cauliflower
(32, 78, 15.00, 0.80, 0),  -- Parsley

-- Main 33: Baked Sea Bream with Herbs - Add vegetables
(33, 16, 100.00, 1.20, 0), -- Tomato
(33, 18, 60.00, 1.00, 0),  -- Onion
(33, 9, 80.00, 1.00, 0),   -- Arugula
(33, 11, 80.00, 1.00, 0),  -- Red Bell Pepper
(33, 19, 15.00, 0.80, 0),  -- Garlic

-- Main 34: Sea Bass with Avocado Sauce and Spinach - Add vegetables
(34, 16, 80.00, 1.20, 0),  -- Tomato
(34, 9, 80.00, 1.00, 0),   -- Arugula
(34, 21, 60.00, 1.20, 0),  -- Lemon
(34, 11, 80.00, 1.00, 0),  -- Red Bell Pepper
(34, 78, 15.00, 0.80, 0),  -- Parsley

-- Main 35: Trout with Cabbage and Parsley - Add vegetables
(35, 13, 100.00, 1.00, 0), -- Carrot
(35, 18, 60.00, 1.00, 0),  -- Onion
(35, 11, 80.00, 1.00, 0),  -- Red Bell Pepper
(35, 19, 15.00, 0.80, 0),  -- Garlic
(35, 21, 30.00, 1.00, 0),  -- Lemon

-- Main 36: Monkfish with Tomato Stew - Add vegetables
(36, 18, 80.00, 1.00, 0),  -- Onion
(36, 11, 100.00, 1.00, 0), -- Red Bell Pepper
(36, 8, 120.00, 1.00, 0),  -- Potato (placeholder)
(36, 4, 100.00, 1.00, 0),  -- Cauliflower
(36, 82, 10.00, 0.80, 0),  -- Rosemary

-- Main 37: Egg and Vegetable Omelette with Aged Sheep Cheese - Add vegetables/meat
(37, 1, 100.00, 1.00, 0),  -- Spinach
(37, 17, 80.00, 1.20, 0),  -- Mushrooms
(37, 11, 80.00, 1.00, 0),  -- Red Bell Pepper
(37, 33, 80.00, 3.50, 0),  -- Chicken
(37, 78, 15.00, 0.80, 0),  -- Parsley

-- Main 38: Grilled Cuttlefish with Garlic and Salad - Add vegetables
(38, 16, 100.00, 1.20, 0), -- Tomato
(38, 14, 80.00, 1.00, 0),  -- Cucumber
(38, 9, 80.00, 1.00, 0),   -- Arugula
(38, 11, 80.00, 1.00, 0),  -- Red Bell Pepper
(38, 21, 30.00, 1.00, 0),  -- Lemon

-- Main 39: Octopus with Cauliflower Cream - Add vegetables
(39, 1, 100.00, 1.00, 0),  -- Spinach
(39, 11, 80.00, 1.00, 0),  -- Red Bell Pepper
(39, 18, 60.00, 1.00, 0),  -- Onion
(39, 19, 15.00, 0.80, 0),  -- Garlic
(39, 78, 15.00, 0.80, 0),  -- Parsley

-- Main 40: Lobster with Lemon and Fresh Herbs - Add vegetables
(40, 18, 80.00, 1.00, 0),  -- Onion
(40, 11, 100.00, 1.00, 0), -- Red Bell Pepper
(40, 19, 15.00, 0.80, 0),  -- Garlic
(40, 1, 100.00, 1.00, 0),  -- Spinach
(40, 8, 80.00, 1.00, 0),   -- Lettuce

-- Main 41: Roast Chicken with Baked Vegetables - Add more vegetables
(41, 11, 100.00, 1.00, 0), -- Red Bell Pepper
(41, 18, 80.00, 1.00, 0),  -- Onion
(41, 8, 150.00, 1.00, 0),  -- Potato (placeholder)
(41, 5, 100.00, 1.00, 0),  -- Zucchini
(41, 19, 15.00, 0.80, 0),  -- Garlic

-- Main 42: Beef and Vegetable Skewers - Add more vegetables
(42, 12, 100.00, 1.00, 0), -- Eggplant
(42, 17, 80.00, 1.20, 0),  -- Mushrooms
(42, 16, 80.00, 1.20, 0),  -- Tomato
(42, 19, 15.00, 0.80, 0),  -- Garlic
(42, 78, 15.00, 0.80, 0),  -- Parsley

-- Main 43: Horse Tenderloin with Mustard and Aged Cheese - Add vegetables
(43, 17, 100.00, 1.20, 0), -- Mushrooms
(43, 11, 80.00, 1.00, 0),  -- Red Bell Pepper
(43, 18, 60.00, 1.00, 0),  -- Onion
(43, 13, 100.00, 1.00, 0), -- Carrot
(43, 82, 10.00, 0.80, 0),  -- Rosemary

-- Main 44: Iberian Pork with Sautéed Cabbage - Add vegetables
(44, 13, 100.00, 1.00, 0), -- Carrot
(44, 11, 80.00, 1.00, 0),  -- Red Bell Pepper
(44, 18, 80.00, 1.00, 0),  -- Onion
(44, 19, 15.00, 0.80, 0),  -- Garlic
(44, 82, 10.00, 0.80, 0),  -- Rosemary

-- Main 45: Natural Curry Chicken with Zucchini - Add vegetables
(45, 11, 100.00, 1.00, 0), -- Red Bell Pepper
(45, 13, 100.00, 1.00, 0), -- Carrot
(45, 4, 100.00, 1.00, 0),  -- Cauliflower
(45, 1, 100.00, 1.00, 0),  -- Spinach
(45, 19, 15.00, 0.80, 0),  -- Garlic

-- Main 46: Vegetable Frittata with Eggs - Add more vegetables/cheese
(46, 11, 100.00, 1.00, 0), -- Red Bell Pepper
(46, 16, 100.00, 1.20, 0), -- Tomato
(46, 13, 80.00, 1.00, 0),  -- Carrot
(46, 62, 50.00, 2.50, 0),  -- Aged Sheep Cheese
(46, 78, 15.00, 0.80, 0),  -- Parsley

-- Main 47: Paleo Shakshuka with Peppers and Eggplant - Add vegetables
(47, 18, 80.00, 1.00, 0),  -- Onion
(47, 19, 15.00, 0.80, 0),  -- Garlic
(47, 1, 100.00, 1.00, 0),  -- Spinach
(47, 5, 100.00, 1.00, 0),  -- Zucchini
(47, 78, 15.00, 0.80, 0),  -- Parsley

-- Main 48: Warm Tuna Salad with Avocado, Berries and Almonds - Add nuts/fruits
(48, 67, 30.00, 1.80, 0),  -- Walnut
(48, 70, 25.00, 1.80, 0),  -- Pistachio
(48, 25, 50.00, 1.50, 0),  -- Raspberry
(48, 24, 50.00, 1.50, 0),  -- Strawberry
(48, 8, 80.00, 1.00, 0),   -- Lettuce

-- Main 49: Grilled Duck with Blueberries and Asparagus - Add fruits/vegetables
(49, 25, 60.00, 1.50, 0),  -- Raspberry
(49, 24, 60.00, 1.50, 0),  -- Strawberry
(49, 1, 100.00, 1.00, 0),  -- Spinach
(49, 11, 80.00, 1.00, 0),  -- Red Bell Pepper
(49, 22, 50.00, 1.00, 0),  -- Orange

-- Main 50: Beef Stew with Vegetables and Herb Bouquet - Add more vegetables
(50, 11, 100.00, 1.00, 0), -- Red Bell Pepper
(50, 18, 80.00, 1.00, 0),  -- Onion
(50, 8, 150.00, 1.00, 0),  -- Potato (placeholder)
(50, 17, 100.00, 1.20, 0), -- Mushrooms
(50, 19, 15.00, 0.80, 0),  -- Garlic

-- Dessert 51: Red Berry Sorbet - Add nuts/fruits
(51, 66, 25.00, 1.50, 0),  -- Almond
(51, 70, 20.00, 1.50, 0),  -- Pistachio
(51, 89, 20.00, 1.20, 0),  -- Raw Honey
(51, 30, 50.00, 1.00, 0),  -- Grape
(51, 23, 50.00, 1.00, 0),  -- Mandarin

-- Dessert 52: Lemon Sorbet - Add nuts/fruits
(52, 66, 25.00, 1.50, 0),  -- Almond
(52, 67, 25.00, 1.50, 0),  -- Walnut
(52, 24, 50.00, 1.20, 0),  -- Strawberry
(52, 22, 50.00, 1.00, 0),  -- Orange
(52, 89, 20.00, 1.20, 0),  -- Raw Honey

-- Dessert 53: Mandarin Sorbet - Add nuts/fruits
(53, 66, 25.00, 1.50, 0),  -- Almond
(53, 70, 20.00, 1.50, 0),  -- Pistachio
(53, 22, 60.00, 1.00, 0),  -- Orange
(53, 26, 40.00, 1.50, 0),  -- Blueberry
(53, 89, 20.00, 1.20, 0),  -- Raw Honey

-- Dessert 54: Melon Sorbet - Add nuts/fruits
(54, 66, 25.00, 1.50, 0),  -- Almond
(54, 67, 25.00, 1.50, 0),  -- Walnut
(54, 24, 50.00, 1.20, 0),  -- Strawberry
(54, 27, 60.00, 1.00, 0),  -- Watermelon
(54, 89, 20.00, 1.20, 0),  -- Raw Honey

-- Dessert 55: Orange Sorbet - Add nuts/fruits
(55, 66, 25.00, 1.50, 0),  -- Almond
(55, 70, 20.00, 1.50, 0),  -- Pistachio
(55, 23, 60.00, 1.00, 0),  -- Mandarin
(55, 26, 40.00, 1.50, 0),  -- Blueberry
(55, 89, 20.00, 1.20, 0),  -- Raw Honey

-- Dessert 56: Baked Apple with Walnuts - Add more nuts/fruits
(56, 66, 30.00, 1.50, 0),  -- Almond
(56, 68, 25.00, 1.50, 0),  -- Hazelnut
(56, 70, 20.00, 1.50, 0),  -- Pistachio
(56, 33, 50.00, 1.20, 0),  -- Pear
(56, 93, 15.00, 1.00, 0),  -- Maple Syrup

-- Dessert 57: Avocado Mousse with Pistachio - Add nuts/fruits
(57, 66, 25.00, 1.50, 0),  -- Almond
(57, 67, 25.00, 1.50, 0),  -- Walnut
(57, 68, 20.00, 1.50, 0),  -- Hazelnut
(57, 26, 40.00, 1.50, 0),  -- Blueberry
(57, 80, 5.00, 0.80, 0),   -- Cinnamon

-- Dessert 58: Watermelon and Melon Skewers - Add fruits/nuts
(58, 24, 60.00, 1.20, 0),  -- Strawberry
(58, 25, 50.00, 1.50, 0),  -- Raspberry
(58, 26, 40.00, 1.50, 0),  -- Blueberry
(58, 66, 20.00, 1.50, 0),  -- Almond
(58, 70, 15.00, 1.50, 0),  -- Pistachio

-- Dessert 59: Spiced Orange with Honey and Cinnamon - Add nuts/fruits
(59, 66, 25.00, 1.50, 0),  -- Almond
(59, 67, 25.00, 1.50, 0),  -- Walnut
(59, 23, 80.00, 1.00, 0),  -- Mandarin
(59, 21, 50.00, 1.00, 0),  -- Lemon
(59, 89, 15.00, 1.20, 0),  -- Raw Honey (extra)

-- Dessert 60: Grapes with Toasted Sheep Cheese - Add nuts/cheese
(60, 66, 30.00, 1.50, 0),  -- Almond
(60, 67, 30.00, 1.50, 0),  -- Walnut
(60, 63, 40.00, 2.50, 0),  -- Aged Cow Cheese
(60, 29, 50.00, 1.20, 0),  -- Fig
(60, 89, 20.00, 1.20, 0),  -- Raw Honey

-- Dessert 61: Figs with Mixed Nuts - Add more nuts/fruits
(61, 70, 25.00, 1.50, 0),  -- Pistachio
(61, 69, 25.00, 1.50, 0),  -- Cashew
(61, 71, 20.00, 1.50, 0),  -- Macadamia
(61, 30, 60.00, 1.00, 0),  -- Grape
(61, 89, 20.00, 1.20, 0);  -- Raw Honey
