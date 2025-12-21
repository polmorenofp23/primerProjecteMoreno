-- SCRIPT DML ---------------------

-- macronutrient (id_macronutrient, name, description, icon_dir)
-- INSERTS
INSERT INTO macronutrient (name, description, icon_dir) VALUES
('Protein', 'Macronutrient responsible for muscle repair and growth.',
  JSON_OBJECT(
    'txt', '/assets/icons/macronutrient/icon_macronutrient_protein_txt.svg',
    'color', '/assets/icons/macronutrient/icon_macronutrient_protein.svg',
    'black', '/assets/icons/macronutrient/icon_macronutrient_protein_black.svg',
    'white', '/assets/icons/macronutrient/icon_macronutrient_protein_white.svg'
  )
),
('Fat', 'Essential fats used for energy storage and metabolic functions.',
  JSON_OBJECT(
    'txt', '/assets/icons/macronutrient/icon_macronutrient_fat_txt.svg',
    'color', '/assets/icons/macronutrient/icon_macronutrient_fat.svg',
    'black', '/assets/icons/macronutrient/icon_macronutrient_fat_black.svg',
    'white', '/assets/icons/macronutrient/icon_macronutrient_fat_white.svg'
  )
),
('Carbohydrate', 'Primary source of energy for the human body.',
  JSON_OBJECT(
    'txt', '/assets/icons/macronutrient/icon_macronutrient_carbohydrate_txt.svg',
    'color', '/assets/icons/macronutrient/icon_macronutrient_carbohydrate.svg',
    'black', '/assets/icons/macronutrient/icon_macronutrient_carbohydrate_black.svg',
    'white', '/assets/icons/macronutrient/icon_macronutrient_carbohydrate_white.svg'
  )
),
('Water', 'Hydration component essential for all metabolic processes.',
  JSON_OBJECT(
    'txt', '/assets/icons/macronutrient/icon_macronutrient_water_txt.svg',
    'color', '/assets/icons/macronutrient/icon_macronutrient_water.svg',
    'black', '/assets/icons/macronutrient/icon_macronutrient_water_black.svg',
    'white', '/assets/icons/macronutrient/icon_macronutrient_water_white.svg'
  )
);

-- allergen (id_allergen, name, description, icon_dir)
-- INSERTS
INSERT INTO allergen (name, description, icon_dir) VALUES
('Gluten', 'Protein found in wheat and related grains.',
  JSON_OBJECT(
    'txt', '/assets/icons/contain_allergen/icon_contain_allergen_gluten_txt.svg',
    'color', '/assets/icons/contain_allergen/icon_contain_allergen_gluten.svg',
    'black', '/assets/icons/contain_allergen/icon_contain_allergen_gluten_black.svg',
    'white', '/assets/icons/contain_allergen/icon_contain_allergen_gluten_white.svg'
  )
),
('Soy', 'Allergen present in soybeans and soy-based products.',
  JSON_OBJECT(
    'txt', '/assets/icons/contain_allergen/icon_contain_allergen_soy_txt.svg',
    'color', '/assets/icons/contain_allergen/icon_contain_allergen_soy.svg',
    'black', '/assets/icons/contain_allergen/icon_contain_allergen_soy_black.svg',
    'white', '/assets/icons/contain_allergen/icon_contain_allergen_soy_white.svg'
  )
),
('Fish', 'Allergen present in all types of fish.',
  JSON_OBJECT(
    'txt', '/assets/icons/contain_allergen/icon_contain_allergen_fish_txt.svg',
    'color', '/assets/icons/contain_allergen/icon_contain_allergen_fish.svg',
    'black', '/assets/icons/contain_allergen/icon_contain_allergen_fish_black.svg',
    'white', '/assets/icons/contain_allergen/icon_contain_allergen_fish_white.svg'
  )
),
('Crustaceans', 'Allergen found in crustacean shellfish such as prawns and crabs.',
  JSON_OBJECT(
    'txt', '/assets/icons/contain_allergen/icon_contain_allergen_crustaceans_txt.svg',
    'color', '/assets/icons/contain_allergen/icon_contain_allergen_crustaceans.svg',
    'black', '/assets/icons/contain_allergen/icon_contain_allergen_crustaceans_black.svg',
    'white', '/assets/icons/contain_allergen/icon_contain_allergen_crustaceans_white.svg'
  )
),
('Molluscs', 'Allergen found in mollusk shellfish such as clams and squid.',
  JSON_OBJECT(
    'txt', '/assets/icons/contain_allergen/icon_contain_allergen_molluscs_txt.svg',
    'color', '/assets/icons/contain_allergen/icon_contain_allergen_molluscs.svg',
    'black', '/assets/icons/contain_allergen/icon_contain_allergen_molluscs_black.svg',
    'white', '/assets/icons/contain_allergen/icon_contain_allergen_molluscs_white.svg'
  )
),
('Egg', 'Allergen derived from bird eggs.',
  JSON_OBJECT(
    'txt', '/assets/icons/contain_allergen/icon_contain_allergen_egg_txt.svg',
    'color', '/assets/icons/contain_allergen/icon_contain_allergen_egg.svg',
    'black', '/assets/icons/contain_allergen/icon_contain_allergen_egg_black.svg',
    'white', '/assets/icons/contain_allergen/icon_contain_allergen_egg_white.svg'
  )
),
('Lactose', 'Milk sugar present in dairy products.',
  JSON_OBJECT(
    'txt', '/assets/icons/contain_allergen/icon_contain_allergen_lactose_txt.svg',
    'color', '/assets/icons/contain_allergen/icon_contain_allergen_lactose.svg',
    'black', '/assets/icons/contain_allergen/icon_contain_allergen_lactose_black.svg',
    'white', '/assets/icons/contain_allergen/icon_contain_allergen_lactose_white.svg'
  )
),
('Mustard', 'Plant-based allergen used commonly in sauces and condiments.',
  JSON_OBJECT(
    'txt', '/assets/icons/contain_allergen/icon_contain_allergen_mustard_txt.svg',
    'color', '/assets/icons/contain_allergen/icon_contain_allergen_mustard.svg',
    'black', '/assets/icons/contain_allergen/icon_contain_allergen_mustard_black.svg',
    'white', '/assets/icons/contain_allergen/icon_contain_allergen_mustard_white.svg'
  )
),
('Tree Nuts', 'Allergen present in nuts such as walnuts, almonds, and hazelnuts.',
  JSON_OBJECT(
    'txt', '/assets/icons/contain_allergen/icon_contain_allergen_tree_nuts_txt.svg',
    'color', '/assets/icons/contain_allergen/icon_contain_allergen_tree_nuts.svg',
    'black', '/assets/icons/contain_allergen/icon_contain_allergen_tree_nuts_black.svg',
    'white', '/assets/icons/contain_allergen/icon_contain_allergen_tree_nuts_white.svg'
  )
);  

-- VEGETABLES (name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
INSERT INTO ingredient 
(id_ingredient, name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
(1, 'Spinach', 'vegetable', 'Fresh green spinach leaves.', 2.50, 23, 0, 'England', 1),
(2, 'Broccoli', 'vegetable', 'Fresh broccoli florets.', 2.50, 34, 0, 'Italy', 1),
(3, 'Cabbage', 'vegetable', 'Green cabbage head.', 2.00, 25, 0, 'England', 1),
(4, 'Cauliflower', 'vegetable', 'White cauliflower head.', 2.20, 30, 0, 'Spain', 1),
(5, 'Zucchini', 'vegetable', 'Fresh zucchini.', 2.00, 21, 0, 'Italy', 1),
(6, 'Artichoke', 'vegetable', 'Fresh artichoke.', 3.50, 47, 0, 'Spain', 1),
(7, 'Asparagus', 'vegetable', 'Fresh green asparagus stalks.', 4.50, 25, 0, 'Peru', 1),
(8, 'Potato', 'vegetable', 'Fresh potato suitable for multiple preparations.', 2.00, 77, 0, 'England', 1),
(9, 'Lettuce', 'vegetable', 'Fresh lettuce leaves.', 1.50, 15, 0, 'England', 1),
(10, 'Arugula', 'vegetable', 'Fresh arugula leaves.', 2.80, 30, 0, 'Italy', 1),
(11, 'Red Bell Pepper', 'vegetable', 'Sweet red bell pepper.', 2.80, 31, 0, 'Spain', 1),
(12, 'Green Bell Pepper', 'vegetable', 'Fresh green bell pepper.', 2.40, 24, 0, 'Mexico', 1),
(13, 'Eggplant', 'vegetable', 'Fresh eggplant.', 2.20, 30, 0, 'Italy', 1),
(14, 'Carrot', 'vegetable', 'Fresh orange carrots.', 2.00, 41, 0, 'France', 1),
(15, 'Cucumber', 'vegetable', 'Fresh cucumber.', 1.80, 16, 0, 'England', 1),
(16, 'Celery', 'vegetable', 'Fresh celery stalks.', 2.20, 16, 0, 'Netherlands', 1),
(17, 'Tomato', 'vegetable', 'Fresh tomatoes.', 2.50, 18, 0, 'Spain', 1),
(18, 'Mushrooms', 'vegetable', 'Fresh mushrooms.', 4.00, 28, 0, 'Poland', 1),
(19, 'Onion', 'vegetable', 'Fresh onions.', 2.00, 40, 0, 'England', 1),
(20, 'Garlic', 'vegetable', 'Fresh garlic bulbs.', 3.00, 149, 0, 'China', 1);

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
(id_ingredient, name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
(21, 'Avocado', 'fruit', 'Fresh ripe avocado.', 4.00, 160, 0, 'Mexico', 1),
(22, 'Lemon', 'fruit', 'Fresh yellow lemons.', 2.00, 29, 0, 'Spain', 1),
(23, 'Orange', 'fruit', 'Fresh sweet oranges.', 2.50, 47, 0, 'England', 1),
(24, 'Mandarin', 'fruit', 'Fresh mandarin oranges.', 2.80, 53, 0, 'Spain', 1),
(25, 'Strawberry', 'fruit', 'Fresh strawberries.', 3.80, 32, 0, 'England', 1),
(26, 'Raspberry', 'fruit', 'Fresh raspberries.', 4.20, 52, 0, 'Serbia', 1),
(27, 'Blueberry', 'fruit', 'Fresh blueberries.', 4.50, 57, 0, 'Poland', 1),
(28, 'Watermelon', 'fruit', 'Sweet red watermelon.', 2.20, 30, 0, 'Spain', 1),
(29, 'Melon', 'fruit', 'Fresh sweet melon.', 2.40, 34, 0, 'Spain', 1),
(30, 'Mango', 'fruit', 'Fresh ripe mango.', 3.50, 60, 0, 'Peru', 1),
(31, 'Grape', 'fruit', 'Fresh table grapes.', 2.80, 69, 0, 'Italy', 1),
(32, 'Apple', 'fruit', 'Fresh crunchy apples.', 2.00, 52, 0, 'England', 1),
(33, 'Pear', 'fruit', 'Fresh sweet pears.', 2.00, 57, 0, 'Belgium', 1),
(34, 'Fig', 'fruit', 'Fresh ripe figs.', 4.00, 74, 0, 'Turkey', 1);

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
(id_ingredient, name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
(35, 'Beef', 'meat', 'Fresh beef meat.', 7.50, 250, 1, 'England', 1),
(36, 'Chicken', 'meat', 'Fresh chicken meat.', 4.50, 140, 1, 'Spain', 1),
(37, 'Turkey', 'meat', 'Fresh turkey meat.', 5.00, 135, 1, 'England', 1),
(38, 'Iberian Pork', 'meat', 'Fresh Iberian pork meat.', 8.50, 270, 1, 'Spain', 1),
(39, 'Rabbit', 'meat', 'Fresh rabbit meat.', 6.00, 145, 1, 'France', 1),
(40, 'Lamb', 'meat', 'Fresh lamb meat.', 8.00, 290, 1, 'England', 1),
(41, 'Duck', 'meat', 'Fresh duck meat.', 9.00, 285, 1, 'France', 1),
(42, 'Venison', 'meat', 'Fresh venison meat.', 9.50, 160, 1, 'New Zealand', 1),
(43, 'Wild Boar', 'meat', 'Fresh wild boar meat.', 8.50, 180, 1, 'Italy', 1),
(44, 'Horse Meat', 'meat', 'Fresh horse meat.', 7.00, 175, 1, 'England', 1);

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
(id_ingredient, name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
(45, 'Hake', 'fish', 'Fresh hake fillet.', 6.00, 90, 0, 'Spain', 1),
(46, 'Salmon', 'fish', 'Fresh salmon fillet.', 8.50, 208, 0, 'Norway', 1),
(47, 'Tuna', 'fish', 'Fresh tuna loin.', 9.00, 145, 0, 'England', 1),
(48, 'Cod', 'fish', 'Fresh cod fillet.', 6.50, 82, 0, 'Iceland', 1),
(49, 'Sea Bass', 'fish', 'Fresh sea bass fillet.', 8.00, 96, 0, 'England', 1),
(50, 'Sea Bream', 'fish', 'Fresh sea bream fillet.', 8.00, 118, 0, 'Greece', 1),
(51, 'Trout', 'fish', 'Fresh trout fillet.', 6.50, 110, 0, 'England', 1),
(52, 'Monkfish', 'fish', 'Fresh monkfish tail.', 7.50, 82, 0, 'Portugal', 1),
(53, 'Sardine', 'fish', 'Fresh sardines.', 6.00, 208, 0, 'Morocco', 1),
(54, 'Anchovy', 'fish', 'Fresh anchovy fillets.', 5.50, 150, 0, 'England', 1);

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
(id_ingredient, name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
(55, 'Shrimp', 'seafood', 'Fresh shrimp.', 10.00, 100, 0, 'England', 1),
(56, 'Lobster', 'seafood', 'Fresh lobster meat.', 14.00, 90, 0, 'Canada', 1),
(57, 'Cuttlefish', 'seafood', 'Fresh cuttlefish.', 8.00, 85, 0, 'Spain', 1),
(58, 'Octopus', 'seafood', 'Fresh octopus.', 9.00, 82, 0, 'Portugal', 1),
(59, 'Mussel', 'seafood', 'Fresh mussels.', 6.00, 130, 0, 'England', 1);
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
(id_ingredient, name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
(60, 'Chicken Egg', 'animal_derivative', 'Fresh chicken eggs.', 2.00, 155, 0, 'England', 1),
(61, 'Quail Egg', 'animal_derivative', 'Fresh quail eggs.', 3.00, 155, 0, 'France', 1),
(62, 'Aged Sheep Cheese', 'animal_derivative', 'Aged sheep cheese (lactose removed).', 7.00, 420, 0, 'Spain', 1),
(63, 'Aged Cow Cheese', 'animal_derivative', 'Aged cow cheese (lactose removed).', 6.50, 400, 0, 'Netherlands', 1),
(64, 'Aged Goat Cheese', 'animal_derivative', 'Aged goat cheese (lactose removed).', 6.50, 390, 0, 'England', 1),
(65, 'Aged Mixed Cheese', 'animal_derivative', 'Aged cheese mix of sheep, cow and goat.', 6.50, 410, 0, 'Italy', 1);
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
(id_ingredient, name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
(66, 'Almond', 'tree_nut', 'Raw natural almonds.', 5.00, 575, 0, 'USA', 1),
(67, 'Walnut', 'tree_nut', 'Raw walnut kernels.', 5.50, 654, 0, 'England', 1),
(68, 'Hazelnut', 'tree_nut', 'Raw hazelnuts.', 5.00, 628, 0, 'Turkey', 1),
(69, 'Cashew', 'tree_nut', 'Raw cashew nuts.', 5.50, 553, 0, 'Vietnam', 1),
(70, 'Pistachio', 'tree_nut', 'Raw pistachio nuts.', 6.00, 560, 0, 'Iran', 1),
(71, 'Macadamia', 'tree_nut', 'Raw macadamia nuts.', 6.50, 718, 0, 'Australia', 1),
(72, 'Pine Nut', 'tree_nut', 'Raw pine nuts.', 7.00, 673, 0, 'England', 1);

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
(id_ingredient, name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
(73, 'Sea Salt', 'spice', 'Natural sea salt.', 0.80, 0, 0, 'England', 1),
(74, 'Black Pepper', 'spice', 'Ground black pepper.', 3.00, 255, 0, 'India', 1),
(75, 'Paprika', 'spice', 'Sweet red paprika powder.', 3.00, 289, 0, 'Spain', 1),
(76, 'Natural Curry', 'spice', 'Natural curry blend.', 3.50, 325, 0, 'India', 1),
(77, 'Turmeric', 'spice', 'Ground turmeric root.', 3.00, 312, 0, 'India', 1),
(78, 'Parsley', 'spice', 'Fresh or dried parsley.', 2.50, 36, 0, 'England', 1),
(79, 'Cumin', 'spice', 'Ground cumin seeds.', 2.50, 375, 0, 'Turkey', 1),
(80, 'Cinnamon', 'spice', 'Ground cinnamon.', 2.50, 247, 0, 'Madagascar', 1),
(81, 'Ginger', 'spice', 'Ground ginger root.', 3.00, 80, 0, 'China', 1),
(82, 'Garlic Powder', 'spice', 'Dehydrated garlic powder.', 2.50, 330, 0, 'England', 1),
(83, 'Chives', 'spice', 'Fresh or dried chives.', 2.00, 30, 0, 'England', 1),
(84, 'Basil', 'spice', 'Fresh or dried basil leaves.', 2.00, 23, 0, 'Italy', 1),
(85, 'Thyme', 'spice', 'Fresh or dried thyme.', 2.50, 100, 0, 'England', 1),
(86, 'Rosemary', 'spice', 'Fresh or dried rosemary.', 2.50, 131, 0, 'Spain', 1),
(87, 'Oregano', 'spice', 'Fresh or dried oregano.', 2.50, 265, 0, 'Greece', 1),
(88, 'Bay Leaf', 'spice', 'Dried bay leaves.', 2.00, 313, 0, 'Turkey', 1);

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
(id_ingredient, name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
(89, 'Raw Honey', 'sweetener', 'Unprocessed natural raw honey.', 3.50, 304, 0, 'England', 1),
(90, 'Maple Syrup', 'sweetener', 'Pure natural maple syrup.', 3.80, 260, 0, 'Canada', 1),
(91, 'Coconut Sugar', 'sweetener', 'Organic coconut sugar.', 3.00, 375, 0, 'Philippines', 1);

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
(id_ingredient, name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
(92, 'Homemade Tomato Sauce', 'condiment', 'Natural homemade tomato sauce without sugar.', 2.50, 30, 0, 'Italy', 1),
(93, 'Natural Mustard', 'condiment', 'Pure natural mustard without sugar.', 3.00, 90, 0, 'France', 1),
(94, 'Apple Vinegar', 'condiment', 'Pure apple cider vinegar.', 1.50, 21, 0, 'England', 1),
(95, 'Avocado Sauce', 'condiment', 'Creamy natural avocado sauce.', 4.00, 160, 0, 'Mexico', 1),
(96, 'Mushroom Sauce', 'condiment', 'Creamy natural mushroom sauce.', 3.50, 55, 0, 'Poland', 1),
(97, 'Herb Bouquet', 'condiment', 'Mixed natural fresh herbs.', 2.50, 45, 0, 'England', 1),
(98, 'Blueberry Sauce', 'condiment', 'Natural blueberry sweet sauce.', 4.00, 110, 0, 'England', 1),
(99, 'Natural Orange Sauce', 'condiment', 'Fresh orange reduction sauce.', 3.00, 55, 0, 'Spain', 1);

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
(id_ingredient, name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
(100, 'Extra Virgin Olive Oil', 'natural_fat', 'Premium extra virgin olive oil.', 2.50, 900, 0, 'Spain', 1),
(101, 'Coconut Oil', 'natural_fat', 'Unrefined natural coconut oil.', 2.50, 890, 0, 'Philippines', 1),
(102, 'Avocado Oil', 'natural_fat', 'Cold-pressed avocado oil.', 3.00, 884, 0, 'Mexico', 1),
(103, 'Natural Pork Fat', 'natural_fat', 'Rendered natural pork fat.', 2.00, 897, 0, 'England', 1),
(104, 'Natural Beef Fat', 'natural_fat', 'Rendered natural beef fat.', 2.00, 900, 0, 'Argentina', 1);

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
(id_ingredient, name, category, description, price_per_100g, kcal_per_100g, has_doneness, country, available)
VALUES
(105, 'Mineral Water', 'drink', 'Natural still mineral water.', 0.60, 0, 0, 'England', 1),
(106, 'Sparkling Water', 'drink', 'Natural sparkling water.', 0.65, 0, 0, 'Italy', 1),
(107, 'Herbal Infusion', 'drink', 'Infused herbal drink.', 1.50, 2, 0, 'Morocco', 1),
(108, 'Green Tea', 'drink', 'Fresh brewed green tea.', 1.80, 1, 0, 'China', 1),
(109, 'Black Coffee', 'drink', 'Fresh brewed black coffee.', 1.20, 1, 0, 'Colombia', 1),
(110, 'Dry Wine', 'drink', 'Natural dry wine.', 2.50, 70, 0, 'Spain', 1);

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


-- PRODUCTS/PLATES (id_product, name, description, dish_type, price, img_dir, available)
INSERT INTO product (id_product, name, description, dish_type, price, img_dir, available)
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

  -- Drinks: dish_type set to 'drink' to respect current ENUM
  (62, 'Still Mineral Water - Small Bottle 330ml', 'Small bottle or glass of still mineral water (330 ml).', 'drink', 0.00, JSON_OBJECT(), 1),
  (63, 'Still Mineral Water - Large Bottle 1000ml', 'Large bottle of still mineral water (1000 ml).', 'drink', 0.00, JSON_OBJECT(), 1),
  (64, 'Sparkling Water - Small Bottle 330ml', 'Small bottle or glass of natural sparkling water (330 ml).', 'drink', 0.00, JSON_OBJECT(), 1),
  (65, 'Sparkling Water - Large Bottle 1000ml', 'Large bottle of natural sparkling water (1000 ml).', 'drink', 0.00, JSON_OBJECT(), 1),
  (66, 'Herbal Infusion - Cup 250ml', 'Individual cup of herbal infusion (250 ml).', 'drink', 0.00, JSON_OBJECT(), 1),
  (67, 'Herbal Infusion - Teapot 600ml', 'Large teapot of herbal infusion for 2-3 people (600 ml).', 'drink', 0.00, JSON_OBJECT(), 1),
  (68, 'Green Tea - Cup 250ml', 'Individual cup of green tea (250 ml).', 'drink', 0.00, JSON_OBJECT(), 1),
  (69, 'Green Tea - Teapot 600ml', 'Large teapot of green tea for 2-3 people (600 ml).', 'drink', 0.00, JSON_OBJECT(), 1),
  (70, 'Herbal Tea Blend - Cup 250ml', 'Individual cup of herbal tea blend (250 ml).', 'drink', 0.00, JSON_OBJECT(), 1),
  (71, 'Herbal Tea Blend - Teapot 600ml', 'Large teapot of herbal tea blend (600 ml).', 'drink', 0.00, JSON_OBJECT(), 1),
  (72, 'Black Coffee - Espresso 60ml', 'Single espresso of black coffee (60 ml).', 'drink', 0.00, JSON_OBJECT(), 1),
  (73, 'Black Coffee - Americano 120ml', 'Double or long black coffee (americano) (120 ml).', 'drink', 0.00, JSON_OBJECT(), 1),
  (74, 'Dry Red Wine - Glass 150ml', 'Individual glass of dry red wine (150 ml).', 'drink', 0.00, JSON_OBJECT(), 1),
  (75, 'Dry Red Wine - Bottle 750ml', 'Full bottle of dry red wine (750 ml).', 'drink', 0.00, JSON_OBJECT(), 1);

-- Populate product.img_dir with standard asset paths per product id
-- Disable safe updates temporarily to allow mass update
SET SQL_SAFE_UPDATES = 0;
UPDATE product
SET img_dir = JSON_OBJECT(
  'A', CONCAT('/assets/img/products/', id_product, '_A.webp'),
  'B', CONCAT('/assets/img/products/', id_product, '_B.webp'),
  'C', CONCAT('/assets/img/products/', id_product, '_C.webp'),
  'nobg', CONCAT('/assets/img/products/', id_product, '_nobg.webp')
)
WHERE id_product IS NOT NULL; -- satisfies safe update condition by using key column
SET SQL_SAFE_UPDATES = 1;



-- PRODUCT INGREDIENTS
INSERT INTO product_ingredient (id_product, id_ingredient, grams_per_portion, portion_price, is_default)
VALUES
  -- Appetisers
  -- Appetiser 1: Zucchini and Avocado Carpaccio (nuts)
  (1, 5, 110.00, 0.00, 1),  -- Zucchini (id 5)
  (1, 21, 80.00, 0.00, 1),  -- Avocado (id 21)
  (1, 66, 20.00, 0.00, 1),  -- Almond (id 66)
  (1, 22, 20.00, 0.00, 1),  -- Lemon (id 22)
  (1, 85, 5.00, 0.00, 1),   -- Thyme (id 85)
  (1, 100,15.00, 0.00, 1),  -- Extra Virgin Olive Oil (id 100)

  -- Appetiser 2: Grilled Asparagus with Natural Mustard
  (2, 7, 190.00, 0.00, 1),  -- Asparagus (id 7)
  (2, 93, 25.00, 0.00, 1),  -- Natural Mustard (id 93)
  (2, 86, 5.00, 0.00, 1),   -- Rosemary (id 86)
  (2, 100,30.00, 0.00, 1),  -- Extra Virgin Olive Oil (id 100)

  -- Appetiser 3: Sea Bass Ceviche with Mango
  (3, 49, 120.00, 0.00, 1), -- Sea Bass (id 49)
  (3, 30, 60.00, 0.00, 1),  -- Mango (id 30)
  (3, 19, 25.00, 0.00, 1),  -- Onion (id 19)
  (3, 78, 10.00, 0.00, 1),  -- Parsley (id 78)
  (3, 22, 20.00, 0.00, 1),  -- Lemon (id 22)
  (3, 100,15.00, 0.00, 1),  -- Extra Virgin Olive Oil (id 100)

  -- Appetiser 4: Salmon Tartare with Avocado and Pistachio
  (4, 46, 130.00, 0.00, 1), -- Salmon (id 46)
  (4, 21, 70.00, 0.00, 1),  -- Avocado (id 21)
  (4, 70, 20.00, 0.00, 1),  -- Pistachio (id 70)
  (4, 74, 5.00, 0.00, 1),   -- Black Pepper (id 74)
  (4, 100,25.00, 0.00, 1),  -- Extra Virgin Olive Oil (id 100)

  -- Appetiser 5: Quail Eggs with Grilled Mushrooms
  (5, 61, 120.00, 0.00, 1), -- Quail Egg (id 61)
  (5, 18, 100.00, 0.00, 1), -- Mushrooms (id 18)
  (5, 83, 5.00, 0.00, 1),   -- Chives (id 83)
  (5, 82, 3.00, 0.00, 1),   -- Garlic Powder (id 82)
  (5, 100,22.00, 0.00, 1),  -- Extra Virgin Olive Oil (id 100)

  -- Appetiser 6: Tomato and Orange Salad with Anchovy
  (6, 17, 100.00, 0.00, 1), -- Tomato (id 17)
  (6, 23, 70.00, 0.00, 1),  -- Orange (id 23)
  (6, 54, 30.00, 0.00, 1),  -- Anchovy (id 54)
  (6, 10, 30.00, 0.00, 1),  -- Arugula (id 10)
  (6, 100,15.00, 0.00, 1),  -- Extra Virgin Olive Oil (id 100)
  (6, 87, 5.00, 0.00, 1),   -- Oregano (id 87)

  -- Appetiser 7: Chicken Skewers with Avocado
  (7, 36, 150.00, 0.00, 1), -- Chicken (id 36)
  (7, 21, 60.00, 0.00, 1),  -- Avocado (id 21)
  (7, 95, 20.00, 0.00, 1),  -- Avocado Sauce / Guacamole (id 95)
  (7, 79, 5.00, 0.00, 1),   -- Cumin (id 79)
  (7, 74, 5.00, 0.00, 1),   -- Black Pepper (id 74)
  (7, 100,15.00, 0.00, 1),  -- Extra Virgin Olive Oil (id 100)

  -- Appetiser 8: Beef Carpaccio with Aged Cheese and Pine Nuts
  (8, 35, 150.00, 0.00, 1), -- Beef (id 35)
  (8, 10, 40.00, 0.00, 1),  -- Arugula (id 10)
  (8, 72, 15.00, 0.00, 1),  -- Pine Nut (id 72)
  (8, 65, 25.00, 0.00, 1),  -- Aged Mixed Cheese (id 65)
  (8, 22, 10.00, 0.00, 1),  -- Lemon (id 22)
  (8, 100,10.00, 0.00, 1),  -- Extra Virgin Olive Oil (id 100)

  -- Appetiser 9: Avocado and Broccoli Dip
  (9, 21, 100.00, 0.00, 1), -- Avocado (id 21)
  (9, 2, 80.00, 0.00, 1),   -- Broccoli (id 2)
  (9, 14, 40.00, 0.00, 1),  -- Carrot (id 14)
  (9, 16, 15.00, 0.00, 1),  -- Celery (id 16)
  (9, 78, 5.00, 0.00, 1),   -- Parsley (id 78)
  (9, 100,10.00, 0.00, 1),  -- Extra Virgin Olive Oil (id 100)

  -- Appetiser 10: Steamed Mussels with Lemon and Parsley
  (10, 59, 180.00, 0.00, 1),-- Mussel (id 59)
  (10, 22, 30.00, 0.00, 1), -- Lemon (id 22)
  (10, 78, 10.00, 0.00, 1), -- Parsley (id 78)
  (10, 100,30.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Appetiser 11: Sautéed Shrimp with Green Salad
  (11, 55, 150.00, 0.00, 1),-- Shrimp (id 55)
  (11, 20, 10.00, 0.00, 1), -- Garlic (id 20)
  (11, 88, 5.00, 0.00, 1),  -- Bay Leaf (id 88)
  (11, 9, 65.00, 0.00, 1),  -- Lettuce (id 9)
  (11, 100,20.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Appetiser 12: Baked Cauliflower Chips with Curry
  (12, 4, 180.00, 0.00, 1), -- Cauliflower (id 4)
  (12, 76, 5.00, 0.00, 1),  -- Natural Curry (id 76)
  (12, 92, 35.00, 0.00, 1), -- Homemade Tomato Sauce (id 92)
  (12, 100,30.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Appetiser 13: Scrambled Eggs with Spinach and Onion
  (13, 60, 120.00, 0.00, 1),-- Chicken Egg (id 60)
  (13, 1, 100.00, 0.00, 1), -- Spinach (id 1)
  (13, 19, 20.00, 0.00, 1), -- Onion (id 19)
  (13, 100,10.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Appetiser 14: Roasted Eggplant with Almond and Honey
  (14, 13, 160.00, 0.00, 1),-- Eggplant (id 13)
  (14, 66, 30.00, 0.00, 1), -- Almond (id 66)
  (14, 89, 10.00, 0.00, 1), -- Raw Honey (id 89)
  (14, 74, 5.00, 0.00, 1),  -- Black Pepper (id 74)
  (14, 100,20.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Appetiser 15: Marinated Sardines with Lemon and Thyme
  (15, 53, 150.00, 0.00, 1),-- Sardine (id 53)
  (15, 22, 40.00, 0.00, 1), -- Lemon (id 22)
  (15, 85, 10.00, 0.00, 1), -- Thyme (id 85)
  (15, 100,50.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Appetiser 16: Watermelon and Cucumber Salad with Pistachio
  (16, 28, 120.00, 0.00, 1),-- Watermelon (id 28)
  (16, 15, 80.00, 0.00, 1), -- Cucumber (id 15)
  (16, 70, 15.00, 0.00, 1), -- Pistachio (id 70)
  (16, 22, 20.00, 0.00, 1), -- Lemon (id 22)
  (16, 84, 5.00, 0.00, 1),  -- Basil (id 84)
  (16, 100,10.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Appetiser 17: Grilled Mushrooms and Onion with Maple
  (17, 18, 160.00, 0.00, 1),-- Mushrooms (id 18)
  (17, 19, 60.00, 0.00, 1), -- Onion (id 19)
  (17, 90, 10.00, 0.00, 1), -- Maple Syrup (id 90)
  (17, 74, 5.00, 0.00, 1),  -- Black Pepper (id 74)
  (17, 100,15.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Appetiser 18: Cured Cheese Board with Figs
  (18, 62, 60.00, 0.00, 1), -- Aged Sheep Cheese (id 62)
  (18, 63, 60.00, 0.00, 1), -- Aged Cow Cheese (id 63)
  (18, 64, 60.00, 0.00, 1), -- Aged Goat Cheese (id 64)
  (18, 65, 40.00, 0.00, 1), -- Aged Mixed Cheese (id 65)
  (18, 34, 30.00, 0.00, 1), -- Fig (id 34)

  -- Appetiser 19: Avocado and Strawberry Salad with Macadamia
  (19, 21, 100.00, 0.00, 1),-- Avocado (id 21)
  (19, 25, 80.00, 0.00, 1), -- Strawberry (id 25)
  (19, 71, 20.00, 0.00, 1), -- Macadamia (id 71)
  (19, 22, 30.00, 0.00, 1), -- Lemon (id 22)
  (19, 100,20.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Appetiser 20: Cabbage and Shredded Cod Broth
  (20, 48, 100.00, 0.00, 1),-- Cod (id 48)
  (20, 3, 120.00, 0.00, 1), -- Cabbage (id 3)
  (20, 83, 10.00, 0.00, 1), -- Chives (id 83)
  (20, 100,20.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Mains
  -- Main 21: Beef Entrecôte with Asparagus and Mushroom Sauce
  (21, 35, 350.00, 0.00, 1),-- Beef (id 35)
  (21, 7, 120.00, 0.00, 1), -- Asparagus (id 7)
  (21, 96, 20.00, 0.00, 1), -- Mushroom Sauce (id 96)
  (21, 100,10.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 22: Lemon Roasted Chicken with Vegetables
  (22, 36, 300.00, 0.00, 1),-- Chicken (id 36)
  (22, 14, 100.00, 0.00, 1),-- Carrot (id 14)
  (22, 5, 80.00, 0.00, 1),  -- Zucchini (id 5)
  (22, 22, 10.00, 0.00, 1), -- Lemon (id 22)
  (22, 85, 5.00, 0.00, 1),  -- Thyme (id 85)
  (22, 100,5.00, 0.00, 1),  -- Extra Virgin Olive Oil (id 100)

  -- Main 23: Grilled Octopus with Vegetables
  (23, 58, 300.00, 0.00, 1),-- Octopus (id 58)
  (23, 14, 100.00, 0.00, 1),-- Carrot (placeholder for potato) (id 14)
  (23, 20, 10.00, 0.00, 1), -- Garlic (id 20)
  (23, 75, 5.00, 0.00, 1),  -- Paprika (id 75)
  (23, 74, 5.00, 0.00, 1),  -- Black Pepper (id 74)
  (23, 100,80.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 24: Iberian Pork Ribs with Honey Salad
  (24, 38, 320.00, 0.00, 1),-- Iberian Pork (id 38)
  (24, 9, 130.00, 0.00, 1), -- Lettuce (id 9)
  (24, 89, 10.00, 0.00, 1), -- Raw Honey (id 89)
  (24, 86, 5.00, 0.00, 1),  -- Rosemary (id 86)
  (24, 100,35.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 25: Rabbit with Garlic and Parsley
  (25, 39, 300.00, 0.00, 1),-- Rabbit (id 39)
  (25, 18, 100.00, 0.00, 1),-- Mushrooms (id 18)
  (25, 19, 60.00, 0.00, 1), -- Onion (id 19)
  (25, 78, 10.00, 0.00, 1), -- Parsley (id 78)
  (25, 100,30.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 26: Grilled Lamb Chops with Artichoke
  (26, 40, 330.00, 0.00, 1),-- Lamb (id 40)
  (26, 6, 120.00, 0.00, 1), -- Artichoke (id 6)
  (26, 86, 10.00, 0.00, 1), -- Rosemary (id 86)
  (26, 100,40.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 27: Duck Breast with Orange and Asparagus
  (27, 41, 300.00, 0.00, 1),-- Duck (id 41)
  (27, 23, 100.00, 0.00, 1),-- Orange (id 23)
  (27, 7, 80.00, 0.00, 1),  -- Asparagus (id 7)
  (27, 100,20.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 28: Venison Stew with Mushrooms and Carrot
  (28, 42, 320.00, 0.00, 1),-- Venison (id 42)
  (28, 18, 100.00, 0.00, 1),-- Mushrooms (id 18)
  (28, 14, 60.00, 0.00, 1), -- Carrot (id 14)
  (28, 85, 10.00, 0.00, 1), -- Thyme (id 85)
  (28, 100,10.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 29: Wild Boar with Homemade Tomato Sauce
  (29, 43, 320.00, 0.00, 1),-- Wild Boar (id 43)
  (29, 17, 100.00, 0.00, 1),-- Tomato (id 17)
  (29, 3, 60.00, 0.00, 1),  -- Cabbage (id 3)
  (29, 74, 10.00, 0.00, 1), -- Black Pepper (id 74)
  (29, 100,10.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 30: Seared Tuna with Avocado and Almonds
  (30, 47, 300.00, 0.00, 1),-- Tuna (id 47)
  (30, 21, 80.00, 0.00, 1), -- Avocado (id 21)
  (30, 15, 60.00, 0.00, 1), -- Cucumber (id 15)
  (30, 66, 40.00, 0.00, 1), -- Almond (id 66)
  (30, 100,20.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 31: Grilled Hake with Tomato and Arugula
  (31, 45, 320.00, 0.00, 1),-- Hake (id 45)
  (31, 17, 80.00, 0.00, 1), -- Tomato (id 17)
  (31, 10, 80.00, 0.00, 1),  -- Arugula (id 10)
  (31, 22, 10.00, 0.00, 1), -- Lemon (id 22)
  (31, 100,10.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 32: Cod Confit with Roasted Pepper and Eggplant
  (32, 48, 280.00, 0.00, 1),-- Cod (id 48)
  (32, 11, 80.00, 0.00, 1), -- Red Bell Pepper (id 11)
  (32, 13, 80.00, 0.00, 1), -- Eggplant (id 13)
  (32, 19, 40.00, 0.00, 1), -- Onion (id 19)
  (32, 100,20.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 33: Baked Sea Bream with Herbs
  (33, 50, 320.00, 0.00, 1),-- Sea Bream (id 50)
  (33, 22, 30.00, 0.00, 1), -- Lemon (id 22)
  (33, 85, 10.00, 0.00, 1), -- Thyme (id 85)
  (33, 87, 10.00, 0.00, 1), -- Oregano (id 87)
  (33, 100,30.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)
  (33, 9, 100.00, 0.00, 1), -- Lettuce (id 9)

  -- Main 34: Sea Bass with Avocado Sauce and Spinach
  (34, 49, 300.00, 0.00, 1),-- Sea Bass (id 49)
  (34, 21, 100.00, 0.00, 1),-- Avocado (id 21)
  (34, 1, 80.00, 0.00, 1),  -- Spinach (id 1)
  (34, 100,20.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 35: Trout with Cabbage and Parsley
  (35, 51, 320.00, 0.00, 1),-- Trout (id 51)
  (35, 3, 120.00, 0.00, 1), -- Cabbage (id 3)
  (35, 78, 10.00, 0.00, 1), -- Parsley (id 78)
  (35, 100,50.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 36: Monkfish with Tomato Stew
  (36, 52, 300.00, 0.00, 1),-- Monkfish (id 52)
  (36, 17, 120.00, 0.00, 1),-- Tomato (id 17)
  (36, 20, 10.00, 0.00, 1), -- Garlic (id 20)
  (36, 78, 10.00, 0.00, 1), -- Parsley (id 78)
  (36, 100,60.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 37: Egg and Vegetable Omelette with Aged Sheep Cheese
  (37, 60, 180.00, 0.00, 1),-- Chicken Egg (id 60)
  (37, 14, 200.00, 0.00, 1),-- Carrot (placeholder for potato) (id 14)
  (37, 19, 80.00, 0.00, 1), -- Onion (id 19)
  (37, 62, 40.00, 0.00, 1), -- Aged Sheep Cheese (id 62)

  -- Main 38: Grilled Cuttlefish with Garlic and Salad
  (38, 57, 320.00, 0.00, 1),-- Cuttlefish (id 57)
  (38, 20, 10.00, 0.00, 1), -- Garlic (id 20)
  (38, 78, 10.00, 0.00, 1), -- Parsley (id 78)
  (38, 9, 120.00, 0.00, 1), -- Lettuce (id 9)
  (38, 100,40.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 39: Octopus with Cauliflower Cream
  (39, 58, 280.00, 0.00, 1),-- Octopus (id 58)
  (39, 4, 180.00, 0.00, 1), -- Cauliflower (id 4)
  (39, 74, 10.00, 0.00, 1), -- Black Pepper (id 74)
  (39, 100,30.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 40: Lobster with Lemon and Fresh Herbs
  (40, 56, 300.00, 0.00, 1),-- Lobster (id 56)
  (40, 17, 100.00, 0.00, 1),-- Tomato (id 17)
  (40, 97, 20.00, 0.00, 1), -- Herb Bouquet (id 97)
  (40, 22, 30.00, 0.00, 1), -- Lemon (id 22)
  (40, 100,50.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 41: Roast Chicken with Baked Vegetables
  (41, 36, 300.00, 0.00, 1),-- Chicken (id 36)
  (41, 14, 150.00, 0.00, 1),-- Carrot (placeholder for baked potatoes) (id 14)
  (41, 97, 20.00, 0.00, 1), -- Herb Bouquet (id 97)
  (41, 22, 10.00, 0.00, 1), -- Lemon (id 22)
  (41, 100,20.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 42: Beef and Vegetable Skewers
  (42, 35, 250.00, 0.00, 1),-- Beef (id 35)
  (42, 11, 80.00, 0.00, 1), -- Red Bell Pepper (id 11)
  (42, 5, 80.00, 0.00, 1),  -- Zucchini (id 5)
  (42, 19, 60.00, 0.00, 1), -- Onion (id 19)
  (42, 79, 10.00, 0.00, 1), -- Cumin (id 79)
  (42, 74, 10.00, 0.00, 1), -- Black Pepper (id 74)
  (42, 100,20.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 43: Horse Tenderloin with Mustard and Aged Cheese
  (43, 44, 300.00, 0.00, 1),-- Horse Meat (id 44)
  (43, 1, 120.00, 0.00, 1), -- Spinach (id 1)
  (43, 93, 30.00, 0.00, 1), -- Natural Mustard (id 93)
  (43, 65, 30.00, 0.00, 1), -- Aged Mixed Cheese (id 65)
  (43, 100,20.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 44: Iberian Pork with Sautéed Cabbage
  (44, 38, 320.00, 0.00, 1),-- Iberian Pork (id 38)
  (44, 3, 100.00, 0.00, 1), -- Cabbage (id 3)
  (44, 94, 10.00, 0.00, 1), -- Apple Vinegar (id 94)
  (44, 85, 10.00, 0.00, 1), -- Thyme (id 85)
  (44, 100,60.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 45: Natural Curry Chicken with Zucchini
  (45, 36, 300.00, 0.00, 1),-- Chicken (id 36)
  (45, 19, 100.00, 0.00, 1),-- Onion (id 19)
  (45, 5, 80.00, 0.00, 1),  -- Zucchini (id 5)
  (45, 76, 10.00, 0.00, 1), -- Natural Curry (id 76)
  (45, 101,10.00, 0.00, 1), -- Coconut Oil (id 101)

  -- Main 46: Vegetable Frittata with Eggs
  (46, 60, 180.00, 0.00, 1),-- Chicken Egg (id 60)
  (46, 18, 150.00, 0.00, 1),-- Mushrooms (id 18)
  (46, 1, 120.00, 0.00, 1), -- Spinach (id 1)
  (46, 19, 30.00, 0.00, 1), -- Onion (id 19)
  (46, 100,20.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 47: Paleo Shakshuka with Peppers and Eggplant
  (47, 60, 120.00, 0.00, 1),-- Chicken Egg (id 60)
  (47, 17, 200.00, 0.00, 1),-- Tomato (id 17)
  (47, 13, 80.00, 0.00, 1), -- Eggplant (id 13)
  (47, 11, 50.00, 0.00, 1), -- Red Bell Pepper (id 11)
  (47, 12, 30.00, 0.00, 1), -- Green Bell Pepper (id 12)
  (47, 100,20.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 48: Warm Tuna Salad with Avocado, Berries and Almonds
  (48, 47, 200.00, 0.00, 1),-- Tuna (id 47)
  (48, 21, 100.00, 0.00, 1),-- Avocado (id 21)
  (48, 10, 80.00, 0.00, 1),  -- Arugula (id 10)
  (48, 27, 60.00, 0.00, 1), -- Blueberry (id 27)
  (48, 66, 30.00, 0.00, 1), -- Almond (id 66)
  (48, 100,30.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 49: Grilled Duck with Blueberries and Asparagus
  (49, 41, 300.00, 0.00, 1),-- Duck (id 41)
  (49, 27, 60.00, 0.00, 1), -- Blueberry (id 27)
  (49, 89, 20.00, 0.00, 1), -- Raw Honey (id 89)
  (49, 7, 100.00, 0.00, 1), -- Asparagus (id 7)
  (49, 100,20.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Main 50: Beef Stew with Vegetables and Herb Bouquet
  (50, 35, 320.00, 0.00, 1),-- Beef (id 35)
  (50, 14, 80.00, 0.00, 1), -- Carrot (id 14)
  (50, 3, 80.00, 0.00, 1),  -- Cabbage (id 3)
  (50, 97, 10.00, 0.00, 1), -- Herb Bouquet (id 97)
  (50, 100,10.00, 0.00, 1), -- Extra Virgin Olive Oil (id 100)

  -- Desserts
  -- Dessert 51: Red Berry Sorbet
  (51, 25, 70.00, 0.00, 1), -- Strawberry (id 25)
  (51, 26, 50.00, 0.00, 1), -- Raspberry (id 26)
  (51, 27, 40.00, 0.00, 1), -- Blueberry (id 27)
  (51, 89, 20.00, 0.00, 1), -- Raw Honey (id 89)

  -- Dessert 52: Lemon Sorbet
  (52, 22, 150.00, 0.00, 1),-- Lemon (id 22)
  (52, 89, 30.00, 0.00, 1), -- Raw Honey (id 89)

  -- Dessert 53: Mandarin Sorbet
  (53, 24, 150.00, 0.00, 1),-- Mandarin (id 24)
  (53, 89, 30.00, 0.00, 1), -- Raw Honey (id 89)

  -- Dessert 54: Melon Sorbet
  (54, 29, 150.00, 0.00, 1),-- Melon (id 29)
  (54, 89, 30.00, 0.00, 1), -- Raw Honey (id 89)

  -- Dessert 55: Orange Sorbet
  (55, 23, 150.00, 0.00, 1),-- Orange (id 23)
  (55, 89, 30.00, 0.00, 1), -- Raw Honey (id 89)

  -- Dessert 56: Baked Apple with Walnuts
  (56, 32, 120.00, 0.00, 1),-- Apple (id 32)
  (56, 89, 30.00, 0.00, 1), -- Raw Honey (id 89)
  (56, 80, 5.00, 0.00, 1),  -- Cinnamon (id 80)
  (56, 67, 25.00, 0.00, 1), -- Walnut (id 67)

  -- Dessert 57: Avocado Mousse with Pistachio
  (57, 21, 100.00, 0.00, 1),-- Avocado (id 21)
  (57, 89, 40.00, 0.00, 1), -- Raw Honey (id 89)
  (57, 22, 20.00, 0.00, 1), -- Lemon (id 22)
  (57, 70, 20.00, 0.00, 1), -- Pistachio (id 70)

  -- Dessert 58: Watermelon and Melon Skewers
  (58, 28, 90.00, 0.00, 1), -- Watermelon (id 28)
  (58, 29, 70.00, 0.00, 1), -- Melon (id 29)
  (58, 22, 10.00, 0.00, 1), -- Lemon (id 22)
  (58, 84, 10.00, 0.00, 1), -- Basil (id 84)

  -- Dessert 59: Spiced Orange with Honey and Cinnamon
  (59, 23, 150.00, 0.00, 1),-- Orange (id 23)
  (59, 89, 20.00, 0.00, 1), -- Raw Honey (id 89)
  (59, 80, 10.00, 0.00, 1), -- Cinnamon (id 80)

  -- Dessert 60: Grapes with Toasted Sheep Cheese
  (60, 31, 120.00, 0.00, 1),-- Grape (id 31)
  (60, 62, 60.00, 0.00, 1), -- Aged Sheep Cheese (id 62)

  -- Dessert 61: Figs with Mixed Nuts
  (61, 34, 100.00, 0.00, 1),-- Fig (id 34)
  (61, 67, 30.00, 0.00, 1), -- Walnut (id 67)
  (61, 66, 30.00, 0.00, 1), -- Almond (id 66)
  (61, 68, 20.00, 0.00, 1), -- Hazelnut (id 68)

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
(1, 67, 15.00, 0.00, 0), -- Walnut
(1, 70, 15.00, 0.00, 0), -- Pistachio
(1, 62, 40.00, 0.00, 0), -- Aged Sheep Cheese
(1, 17, 50.00, 0.00, 0), -- Tomato (id 17)
(1, 10, 30.00, 0.00, 0),  -- Arugula (id 10)

-- Appetiser 2: Grilled Asparagus with Natural Mustard - Add proteins/nuts
(2, 60, 80.00, 0.00, 0), -- Chicken Egg (id 60)
(2, 66, 20.00, 0.00, 0), -- Almond
(2, 63, 30.00, 0.00, 0), -- Aged Cow Cheese
(2, 18, 40.00, 0.00, 0), -- Mushrooms (id 18)
(2, 17, 50.00, 0.00, 0), -- Tomato (id 17)

-- Appetiser 3: Sea Bass Ceviche with Mango - Add fruits/vegetables
(3, 21, 30.00, 0.00, 0), -- Avocado (id 21)
(3, 15, 40.00, 0.00, 0), -- Cucumber (id 15)
(3, 11, 30.00, 0.00, 0), -- Red Bell Pepper
(3, 66, 15.00, 0.00, 0), -- Almond
(3, 25, 40.00, 0.00, 0), -- Strawberry (id 25)

-- Appetiser 4: Salmon Tartare with Avocado and Pistachio - Add more nuts
(4, 66, 20.00, 0.00, 0), -- Almond
(4, 67, 20.00, 0.00, 0), -- Walnut
(4, 15, 50.00, 0.00, 0), -- Cucumber (id 15)
(4, 10, 30.00, 0.00, 0),  -- Arugula (id 10)
(4, 23, 20.00, 0.00, 0), -- Orange (id 23)

-- Appetiser 5: Quail Eggs with Grilled Mushrooms - Add cheeses/vegetables
(5, 62, 40.00, 0.00, 0), -- Aged Sheep Cheese
(5, 1, 50.00, 0.00, 0),  -- Spinach
(5, 17, 50.00, 0.00, 0), -- Tomato (id 17)
(5, 19, 30.00, 0.00, 0), -- Onion (id 19)
(5, 78, 5.00, 0.00, 0),  -- Parsley

-- Appetiser 6: Tomato and Orange Salad with Anchovy - Add nuts/cheese
(6, 66, 20.00, 0.00, 0), -- Almond
(6, 70, 15.00, 0.00, 0), -- Pistachio
(6, 62, 30.00, 0.00, 0), -- Aged Sheep Cheese
(6, 15, 50.00, 0.00, 0), -- Cucumber (id 15)
(6, 9, 40.00, 0.00, 0),  -- Lettuce (id 9)

-- Appetiser 7: Chicken Skewers with Avocado - Add vegetables
(7, 11, 50.00, 0.00, 0), -- Red Bell Pepper
(7, 19, 40.00, 0.00, 0), -- Onion (id 19)
(7, 17, 50.00, 0.00, 0), -- Tomato (id 17)
(7, 9, 40.00, 0.00, 0),  -- Lettuce (id 9)
(7, 66, 15.00, 0.00, 0), -- Almond

-- Appetiser 8: Beef Carpaccio with Aged Cheese and Pine Nuts - Add more nuts/cheese
(8, 66, 20.00, 0.00, 0), -- Almond
(8, 67, 20.00, 0.00, 0), -- Walnut
(8, 62, 30.00, 0.00, 0), -- Aged Sheep Cheese
(8, 17, 50.00, 0.00, 0), -- Tomato (id 17)
(8, 70, 15.00, 0.00, 0), -- Pistachio

-- Appetiser 9: Avocado and Broccoli Dip - Add vegetables/nuts
(9, 17, 60.00, 0.00, 0), -- Tomato (id 17)
(9, 11, 40.00, 0.00, 0), -- Red Bell Pepper
(9, 66, 20.00, 0.00, 0), -- Almond
(9, 9, 40.00, 0.00, 0),  -- Lettuce (id 9)
(9, 19, 30.00, 0.00, 0), -- Onion (id 19)

-- Appetiser 10: Steamed Mussels with Lemon and Parsley - Add vegetables
(10, 17, 80.00, 0.00, 0), -- Tomato (id 17)
(10, 19, 40.00, 0.00, 0), -- Onion (id 19)
(10, 20, 10.00, 0.00, 0), -- Garlic (id 20)
(10, 11, 50.00, 0.00, 0), -- Red Bell Pepper
(10, 9, 50.00, 0.00, 0),  -- Lettuce (id 9)

-- Appetiser 11: Sautéed Shrimp with Green Salad - Add vegetables
(11, 17, 60.00, 0.00, 0), -- Tomato (id 17)
(11, 15, 50.00, 0.00, 0), -- Cucumber (id 15)
(11, 10, 40.00, 0.00, 0),  -- Arugula (id 10)
(11, 21, 50.00, 0.00, 0), -- Avocado (id 21)
(11, 11, 40.00, 0.00, 0), -- Red Bell Pepper

-- Appetiser 12: Baked Cauliflower Chips with Curry - Add cheese/nuts
(12, 62, 40.00, 0.00, 0), -- Aged Sheep Cheese
(12, 66, 20.00, 0.00, 0), -- Almond
(12, 78, 10.00, 0.00, 0), -- Parsley
(12, 19, 40.00, 0.00, 0), -- Onion (id 19)
(12, 20, 10.00, 0.00, 0), -- Garlic (id 20)

-- Appetiser 13: Scrambled Eggs with Spinach and Onion - Add cheese/meat
(13, 62, 40.00, 0.00, 0), -- Aged Sheep Cheese
(13, 18, 60.00, 0.00, 0), -- Mushrooms (id 18)
(13, 17, 50.00, 0.00, 0), -- Tomato (id 17)
(13, 36, 50.00, 0.00, 0), -- Chicken (id 36)
(13, 78, 10.00, 0.00, 0), -- Parsley

-- Appetiser 14: Roasted Eggplant with Almond and Honey - Add nuts/cheese
(14, 67, 25.00, 0.00, 0), -- Walnut
(14, 70, 20.00, 0.00, 0), -- Pistachio
(14, 62, 40.00, 0.00, 0), -- Aged Sheep Cheese
(14, 10, 30.00, 0.00, 0),  -- Arugula (id 10)
(14, 17, 50.00, 0.00, 0), -- Tomato (id 17)

-- Appetiser 15: Marinated Sardines with Lemon and Thyme - Add vegetables
(15, 17, 80.00, 0.00, 0), -- Tomato (id 17)
(15, 19, 40.00, 0.00, 0), -- Onion (id 19)
(15, 11, 50.00, 0.00, 0), -- Red Bell Pepper
(15, 9, 50.00, 0.00, 0),  -- Lettuce (id 9)
(15, 10, 40.00, 0.00, 0),  -- Arugula (id 10)

-- Appetiser 16: Watermelon and Cucumber Salad with Pistachio - Add nuts/cheese
(16, 66, 20.00, 0.00, 0), -- Almond
(16, 67, 20.00, 0.00, 0), -- Walnut
(16, 62, 30.00, 0.00, 0), -- Aged Sheep Cheese
(16, 26, 40.00, 0.00, 0), -- Raspberry (id 26)
(16, 10, 30.00, 0.00, 0),  -- Arugula (id 10)

-- Appetiser 17: Grilled Mushrooms and Onion with Maple - Add cheese/nuts
(17, 62, 40.00, 0.00, 0), -- Aged Sheep Cheese
(17, 66, 20.00, 0.00, 0), -- Almond
(17, 78, 10.00, 0.00, 0), -- Parsley
(17, 20, 10.00, 0.00, 0), -- Garlic (id 20)
(17, 86, 5.00, 0.00, 0),  -- Rosemary (id 86)

-- Appetiser 18: Cured Cheese Board with Figs - Add nuts/fruits
(18, 66, 30.00, 0.00, 0), -- Almond
(18, 67, 30.00, 0.00, 0), -- Walnut
(18, 68, 25.00, 0.00, 0), -- Hazelnut
(18, 31, 60.00, 0.00, 0), -- Grape (id 31)
(18, 89, 20.00, 0.00, 0), -- Raw Honey

-- Appetiser 19: Avocado and Strawberry Salad with Macadamia - Add nuts/fruits
(19, 66, 20.00, 0.00, 0), -- Almond
(19, 70, 20.00, 0.00, 0), -- Pistachio
(19, 27, 40.00, 0.00, 0), -- Blueberry (id 27)
(19, 26, 40.00, 0.00, 0), -- Raspberry (id 26)
(19, 9, 50.00, 0.00, 0),  -- Lettuce (id 9)

-- Appetiser 20: Cabbage and Shredded Cod Broth - Add vegetables
(20, 14, 80.00, 0.00, 0), -- Carrot (id 14)
(20, 8, 60.00, 0.00, 0),  -- Potato (placeholder)
(20, 19, 40.00, 0.00, 0), -- Onion (id 19)
(20, 78, 10.00, 0.00, 0), -- Parsley
(20, 20, 10.00, 0.00, 0), -- Garlic (id 20)

-- Main 21: Beef Entrecôte with Asparagus and Mushroom Sauce - Add vegetables/cheese
(21, 1, 100.00, 0.00, 0), -- Spinach
(21, 11, 80.00, 0.00, 0), -- Red Bell Pepper
(21, 62, 50.00, 0.00, 0), -- Aged Sheep Cheese
(21, 19, 60.00, 0.00, 0), -- Onion (id 19)
(21, 86, 10.00, 0.00, 0), -- Rosemary (id 86)

-- Main 22: Lemon Roasted Chicken with Vegetables - Add more vegetables
(22, 2, 100.00, 0.00, 0), -- Broccoli
(22, 4, 100.00, 0.00, 0), -- Cauliflower
(22, 11, 80.00, 0.00, 0), -- Red Bell Pepper
(22, 19, 60.00, 0.00, 0), -- Onion (id 19)
(22, 20, 15.00, 0.00, 0), -- Garlic (id 20)

-- Main 23: Grilled Octopus with Vegetables - Add more vegetables
(23, 17, 100.00, 0.00, 0), -- Tomato (id 17)
(23, 11, 80.00, 0.00, 0),  -- Red Bell Pepper
(23, 19, 60.00, 0.00, 0),  -- Onion (id 19)
(23, 8, 80.00, 0.00, 0),   -- Potato (placeholder)
(23, 78, 15.00, 0.00, 0),  -- Parsley

-- Main 24: Iberian Pork Ribs with Honey Salad - Add vegetables/cheese
(24, 17, 100.00, 0.00, 0), -- Tomato (id 17)
(24, 15, 80.00, 0.00, 0),  -- Cucumber (id 15)
(24, 10, 60.00, 0.00, 0),   -- Arugula (id 10)
(24, 62, 50.00, 0.00, 0),  -- Aged Sheep Cheese
(24, 21, 50.00, 0.00, 0),  -- Avocado

-- Main 25: Rabbit with Garlic and Parsley - Add vegetables
(25, 14, 100.00, 0.00, 0), -- Carrot (id 14)
(25, 11, 80.00, 0.00, 0),  -- Red Bell Pepper
(25, 17, 80.00, 0.00, 0),  -- Tomato (id 17)
(25, 4, 100.00, 0.00, 0),  -- Cauliflower
(25, 86, 10.00, 0.00, 0),  -- Rosemary (id 86)

-- Main 26: Grilled Lamb Chops with Artichoke - Add vegetables
(26, 1, 100.00, 0.00, 0),  -- Spinach
(26, 14, 100.00, 0.00, 0), -- Carrot (id 14)
(26, 11, 80.00, 0.00, 0),  -- Red Bell Pepper
(26, 19, 60.00, 0.00, 0),  -- Onion (id 19)
(26, 20, 15.00, 0.00, 0),  -- Garlic (id 20)

-- Main 27: Duck Breast with Orange and Asparagus - Add fruits/vegetables
(27, 24, 80.00, 0.00, 0),  -- Mandarin (id 24)
(27, 1, 100.00, 0.00, 0),  -- Spinach
(27, 11, 80.00, 0.00, 0),  -- Red Bell Pepper
(27, 27, 50.00, 0.00, 0),  -- Blueberry (id 27)
(27, 89, 20.00, 0.00, 0),  -- Raw Honey

-- Main 28: Venison Stew with Mushrooms and Carrot - Add vegetables
(28, 8, 120.00, 0.00, 0),  -- Potato (placeholder)
(28, 19, 80.00, 0.00, 0),  -- Onion (id 19)
(28, 3, 100.00, 0.00, 0),  -- Cabbage
(28, 11, 80.00, 0.00, 0),  -- Red Bell Pepper
(28, 20, 15.00, 0.00, 0),  -- Garlic (id 20)

-- Main 29: Wild Boar with Homemade Tomato Sauce - Add vegetables
(29, 11, 100.00, 0.00, 0), -- Red Bell Pepper
(29, 19, 80.00, 0.00, 0),  -- Onion (id 19)
(29, 14, 100.00, 0.00, 0), -- Carrot (id 14)
(29, 20, 15.00, 0.00, 0),  -- Garlic (id 20)
(29, 86, 10.00, 0.00, 0),  -- Rosemary (id 86)

-- Main 30: Seared Tuna with Avocado and Almonds - Add vegetables/nuts
(30, 10, 80.00, 0.00, 0),   -- Arugula (id 10)
(30, 17, 80.00, 0.00, 0),  -- Tomato (id 17)
(30, 67, 30.00, 0.00, 0),  -- Walnut
(30, 70, 25.00, 0.00, 0),  -- Pistachio
(30, 9, 60.00, 0.00, 0),   -- Lettuce (id 9)

-- Main 31: Grilled Hake with Tomato and Arugula - Add vegetables
(31, 19, 60.00, 0.00, 0),  -- Onion (id 19)
(31, 11, 80.00, 0.00, 0),  -- Red Bell Pepper
(31, 20, 15.00, 0.00, 0),  -- Garlic (id 20)
(31, 1, 100.00, 0.00, 0),  -- Spinach
(31, 78, 15.00, 0.00, 0),  -- Parsley

-- Main 32: Cod Confit with Roasted Pepper and Eggplant - Add vegetables
(32, 17, 100.00, 0.00, 0), -- Tomato (id 17)
(32, 5, 100.00, 0.00, 0),  -- Zucchini
(32, 20, 15.00, 0.00, 0),  -- Garlic (id 20)
(32, 4, 100.00, 0.00, 0),  -- Cauliflower
(32, 78, 15.00, 0.00, 0),  -- Parsley

-- Main 33: Baked Sea Bream with Herbs - Add vegetables
(33, 17, 100.00, 0.00, 0), -- Tomato (id 17)
(33, 19, 60.00, 0.00, 0),  -- Onion (id 19)
(33, 10, 80.00, 0.00, 0),   -- Arugula (id 10)
(33, 11, 80.00, 0.00, 0),  -- Red Bell Pepper
(33, 20, 15.00, 0.00, 0),  -- Garlic (id 20)

-- Main 34: Sea Bass with Avocado Sauce and Spinach - Add vegetables
(34, 17, 80.00, 0.00, 0),  -- Tomato (id 17)
(34, 10, 80.00, 0.00, 0),   -- Arugula (id 10)
(34, 22, 60.00, 0.00, 0),  -- Lemon (id 22)
(34, 11, 80.00, 0.00, 0),  -- Red Bell Pepper
(34, 78, 15.00, 0.00, 0),  -- Parsley

-- Main 35: Trout with Cabbage and Parsley - Add vegetables
(35, 14, 100.00, 0.00, 0), -- Carrot (id 14)
(35, 19, 60.00, 0.00, 0),  -- Onion (id 19)
(35, 11, 80.00, 0.00, 0),  -- Red Bell Pepper
(35, 20, 15.00, 0.00, 0),  -- Garlic (id 20)
(35, 22, 30.00, 0.00, 0),  -- Lemon (id 22)

-- Main 36: Monkfish with Tomato Stew - Add vegetables
(36, 19, 80.00, 0.00, 0),  -- Onion (id 19)
(36, 11, 100.00, 0.00, 0), -- Red Bell Pepper
(36, 8, 120.00, 0.00, 0),  -- Potato (placeholder)
(36, 4, 100.00, 0.00, 0),  -- Cauliflower
(36, 86, 10.00, 0.00, 0),  -- Rosemary (id 86)

-- Main 37: Egg and Vegetable Omelette with Aged Sheep Cheese - Add vegetables/meat
(37, 1, 100.00, 0.00, 0),  -- Spinach
(37, 18, 80.00, 0.00, 0),  -- Mushrooms (id 18)
(37, 11, 80.00, 0.00, 0),  -- Red Bell Pepper
(37, 36, 80.00, 0.00, 0),  -- Chicken (id 36)
(37, 78, 15.00, 0.00, 0),  -- Parsley

-- Main 38: Grilled Cuttlefish with Garlic and Salad - Add vegetables
(38, 17, 100.00, 0.00, 0), -- Tomato (id 17)
(38, 15, 80.00, 0.00, 0),  -- Cucumber (id 15)
(38, 10, 80.00, 0.00, 0),   -- Arugula (id 10)
(38, 11, 80.00, 0.00, 0),  -- Red Bell Pepper
(38, 22, 30.00, 0.00, 0),  -- Lemon (id 22)

-- Main 39: Octopus with Cauliflower Cream - Add vegetables
(39, 1, 100.00, 0.00, 0),  -- Spinach
(39, 11, 80.00, 0.00, 0),  -- Red Bell Pepper
(39, 19, 60.00, 0.00, 0),  -- Onion (id 19)
(39, 20, 15.00, 0.00, 0),  -- Garlic (id 20)
(39, 78, 15.00, 0.00, 0),  -- Parsley

-- Main 40: Lobster with Lemon and Fresh Herbs - Add vegetables
(40, 19, 80.00, 0.00, 0),  -- Onion (id 19)
(40, 11, 100.00, 0.00, 0), -- Red Bell Pepper
(40, 20, 15.00, 0.00, 0),  -- Garlic (id 20)
(40, 1, 100.00, 0.00, 0),  -- Spinach
(40, 9, 80.00, 0.00, 0),   -- Lettuce (id 9)

-- Main 41: Roast Chicken with Baked Vegetables - Add more vegetables
(41, 11, 100.00, 0.00, 0), -- Red Bell Pepper
(41, 19, 80.00, 0.00, 0),  -- Onion (id 19)
(41, 8, 150.00, 0.00, 0),  -- Potato (placeholder)
(41, 5, 100.00, 0.00, 0),  -- Zucchini
(41, 20, 15.00, 0.00, 0),  -- Garlic (id 20)

-- Main 42: Beef and Vegetable Skewers - Add more vegetables
(42, 13, 100.00, 0.00, 0), -- Eggplant (id 13)
(42, 18, 80.00, 0.00, 0),  -- Mushrooms (id 18)
(42, 17, 80.00, 0.00, 0),  -- Tomato (id 17)
(42, 20, 15.00, 0.00, 0),  -- Garlic (id 20)
(42, 78, 15.00, 0.00, 0),  -- Parsley

-- Main 43: Horse Tenderloin with Mustard and Aged Cheese - Add vegetables
(43, 18, 100.00, 0.00, 0), -- Mushrooms (id 18)
(43, 11, 80.00, 0.00, 0),  -- Red Bell Pepper
(43, 19, 60.00, 0.00, 0),  -- Onion (id 19)
(43, 14, 100.00, 0.00, 0), -- Carrot (id 14)
(43, 86, 10.00, 0.00, 0),  -- Rosemary (id 86)

-- Main 44: Iberian Pork with Sautéed Cabbage - Add vegetables
(44, 14, 100.00, 0.00, 0), -- Carrot (id 14)
(44, 11, 80.00, 0.00, 0),  -- Red Bell Pepper
(44, 19, 80.00, 0.00, 0),  -- Onion (id 19)
(44, 20, 15.00, 0.00, 0),  -- Garlic (id 20)
(44, 86, 10.00, 0.00, 0),  -- Rosemary (id 86)

-- Main 45: Natural Curry Chicken with Zucchini - Add vegetables
(45, 11, 100.00, 0.00, 0), -- Red Bell Pepper
(45, 14, 100.00, 0.00, 0), -- Carrot (id 14)
(45, 4, 100.00, 0.00, 0),  -- Cauliflower
(45, 1, 100.00, 0.00, 0),  -- Spinach
(45, 20, 15.00, 0.00, 0),  -- Garlic (id 20)

-- Main 46: Vegetable Frittata with Eggs - Add more vegetables/cheese
(46, 11, 100.00, 0.00, 0), -- Red Bell Pepper
(46, 17, 100.00, 0.00, 0), -- Tomato (id 17)
(46, 14, 80.00, 0.00, 0),  -- Carrot (id 14)
(46, 62, 50.00, 0.00, 0),  -- Aged Sheep Cheese
(46, 78, 15.00, 0.00, 0),  -- Parsley

-- Main 47: Paleo Shakshuka with Peppers and Eggplant - Add vegetables
(47, 19, 80.00, 0.00, 0),  -- Onion (id 19)
(47, 20, 15.00, 0.00, 0),  -- Garlic (id 20)
(47, 1, 100.00, 0.00, 0),  -- Spinach
(47, 5, 100.00, 0.00, 0),  -- Zucchini
(47, 78, 15.00, 0.00, 0),  -- Parsley

-- Main 48: Warm Tuna Salad with Avocado, Berries and Almonds - Add nuts/fruits
(48, 67, 30.00, 0.00, 0),  -- Walnut
(48, 70, 25.00, 0.00, 0),  -- Pistachio
(48, 26, 50.00, 0.00, 0),  -- Raspberry (id 26)
(48, 25, 50.00, 0.00, 0),  -- Strawberry (id 25)
(48, 9, 80.00, 0.00, 0),   -- Lettuce (id 9)

-- Main 49: Grilled Duck with Blueberries and Asparagus - Add fruits/vegetables
(49, 26, 60.00, 0.00, 0),  -- Raspberry (id 26)
(49, 25, 60.00, 0.00, 0),  -- Strawberry (id 25)
(49, 1, 100.00, 0.00, 0),  -- Spinach
(49, 11, 80.00, 0.00, 0),  -- Red Bell Pepper
(49, 23, 50.00, 0.00, 0),  -- Orange (id 23)

-- Main 50: Beef Stew with Vegetables and Herb Bouquet - Add more vegetables
(50, 11, 100.00, 0.00, 0), -- Red Bell Pepper
(50, 19, 80.00, 0.00, 0),  -- Onion (id 19)
(50, 8, 150.00, 0.00, 0),  -- Potato (placeholder)
(50, 18, 100.00, 0.00, 0), -- Mushrooms (id 18)
(50, 20, 15.00, 0.00, 0),  -- Garlic (id 20)

-- Dessert 51: Red Berry Sorbet - Add nuts/fruits
(51, 66, 25.00, 0.00, 0),  -- Almond
(51, 70, 20.00, 0.00, 0),  -- Pistachio
(51, 81, 5.00, 0.00, 0),   -- Ginger (replace honey duplicate)
(51, 31, 50.00, 0.00, 0),  -- Grape (id 31)
(51, 24, 50.00, 0.00, 0),  -- Mandarin (id 24)

-- Dessert 52: Lemon Sorbet - Add nuts/fruits
(52, 66, 25.00, 0.00, 0),  -- Almond
(52, 67, 25.00, 0.00, 0),  -- Walnut
(52, 25, 50.00, 0.00, 0),  -- Strawberry (id 25)
(52, 23, 50.00, 0.00, 0),  -- Orange (id 23)
(52, 90, 15.00, 0.00, 0),  -- Maple Syrup (replace honey duplicate)

-- Dessert 53: Mandarin Sorbet - Add nuts/fruits
(53, 66, 25.00, 0.00, 0),  -- Almond
(53, 70, 20.00, 0.00, 0),  -- Pistachio
(53, 23, 60.00, 0.00, 0),  -- Orange (id 23)
(53, 27, 40.00, 0.00, 0),  -- Blueberry (id 27)
(53, 91, 15.00, 0.00, 0),  -- Coconut Sugar (replace honey duplicate)

-- Dessert 54: Melon Sorbet - Add nuts/fruits
(54, 66, 25.00, 0.00, 0),  -- Almond
(54, 67, 25.00, 0.00, 0),  -- Walnut
(54, 25, 50.00, 0.00, 0),  -- Strawberry (id 25)
(54, 28, 60.00, 0.00, 0),  -- Watermelon (id 28)
(54, 90, 15.00, 0.00, 0),  -- Maple Syrup (replace honey duplicate)

-- Dessert 55: Orange Sorbet - Add nuts/fruits
(55, 66, 25.00, 0.00, 0),  -- Almond
(55, 70, 20.00, 0.00, 0),  -- Pistachio
(55, 24, 60.00, 0.00, 0),  -- Mandarin (id 24)
(55, 27, 40.00, 0.00, 0),  -- Blueberry (id 27)
(55, 91, 15.00, 0.00, 0),  -- Coconut Sugar (replace honey duplicate)

-- Dessert 56: Baked Apple with Walnuts - Add more nuts/fruits
(56, 66, 30.00, 0.00, 0),  -- Almond
(56, 68, 25.00, 0.00, 0),  -- Hazelnut
(56, 70, 20.00, 0.00, 0),  -- Pistachio
(56, 33, 50.00, 0.00, 0),  -- Pear
(56, 90, 15.00, 0.00, 0),  -- Maple Syrup (id 90)

-- Dessert 57: Avocado Mousse with Pistachio - Add nuts/fruits
(57, 66, 25.00, 0.00, 0),  -- Almond
(57, 67, 25.00, 0.00, 0),  -- Walnut
(57, 68, 20.00, 0.00, 0),  -- Hazelnut
(57, 27, 40.00, 0.00, 0),  -- Blueberry (id 27)
(57, 80, 5.00, 0.00, 0),   -- Cinnamon

-- Dessert 58: Watermelon and Melon Skewers - Add fruits/nuts
(58, 25, 60.00, 0.00, 0),  -- Strawberry (id 25)
(58, 26, 50.00, 0.00, 0),  -- Raspberry (id 26)
(58, 27, 40.00, 0.00, 0),  -- Blueberry (id 27)
(58, 66, 20.00, 0.00, 0),  -- Almond
(58, 70, 15.00, 0.00, 0),  -- Pistachio

-- Dessert 59: Spiced Orange with Honey and Cinnamon - Add nuts/fruits
(59, 66, 25.00, 0.00, 0),  -- Almond
(59, 67, 25.00, 0.00, 0),  -- Walnut
(59, 24, 80.00, 0.00, 0),  -- Mandarin (id 24)
(59, 22, 50.00, 0.00, 0),  -- Lemon (id 22)

-- Dessert 60: Grapes with Toasted Sheep Cheese - Add nuts/cheese
(60, 66, 30.00, 0.00, 0),  -- Almond
(60, 67, 30.00, 0.00, 0),  -- Walnut
(60, 63, 40.00, 0.00, 0),  -- Aged Cow Cheese
(60, 34, 50.00, 0.00, 0),  -- Fig (id 34)
(60, 89, 20.00, 0.00, 0),  -- Raw Honey

-- Dessert 61: Figs with Mixed Nuts - Add more nuts/fruits
(61, 70, 25.00, 0.00, 0),  -- Pistachio
(61, 69, 25.00, 0.00, 0),  -- Cashew
(61, 71, 20.00, 0.00, 0),  -- Macadamia
(61, 31, 60.00, 0.00, 0),  -- Grape (id 31)
(61, 89, 20.00, 0.00, 0);  -- Raw Honey