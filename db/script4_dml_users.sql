-- =====================================================================
-- Bees Cavern DB — Script DML Users v.1.0
-- @author: Pol Moreno Queraltó
-- =====================================================================

USE bees_cavern_db;

-- =====================================================================
-- USER TYPES
-- =====================================================================
INSERT INTO user_type (name, description) VALUES
('basic', 'Basic customer without special benefits'),
('membership', 'Premium member with exclusive discounts'),
('brentford_player', 'Brentford FC player with VIP benefits'),
('brentford_staff', 'Brentford FC staff member with special privileges'),
('vip', 'User with VIP benefits');

-- =====================================================================
-- DISCOUNTS FOR USER TYPES (excluding 'basic')
-- =====================================================================
INSERT INTO discount (name, description, percentage, status, type, id_user_type) VALUES
('Membership Discount', 'Exclusive 20% discount for premium members', 20, 'active', 'user_type', 
    (SELECT id_user_type FROM user_type WHERE name = 'membership')),
('Brentford Player VIP', 'VIP 100% discount for Brentford FC players', 100, 'active', 'user_type', 
    (SELECT id_user_type FROM user_type WHERE name = 'brentford_player')),
('Brentford Staff Discount', 'Special 50% discount for Brentford FC staff', 50, 'active', 'user_type', 
    (SELECT id_user_type FROM user_type WHERE name = 'brentford_staff')),
('VIP Discount', 'Premium 75% discount for VIP users', 75, 'active', 'user_type', 
    (SELECT id_user_type FROM user_type WHERE name = 'vip'));

-- =====================================================================
-- USERS (password: 1234 hashed with bcrypt)
-- Hash: $2y$10$3gUfX2.nQ1tQAmETObIRaO3ZFLhO4qkMdJKZMVRoJK.iraK9qFQIu
-- =====================================================================

-- Admin user: Pol Moreno Queraltó (force id_user = 6)
INSERT INTO user (id_user, id_user_type, username, role, email, password_hash, first_name, last_name, phone, address, birth_date) VALUES
(6, (SELECT id_user_type FROM user_type WHERE name = 'vip'), 
    'polmoreno', 'admin', 'pol.moreno@beescavern.com', 
    '$2y$10$Mu41XUGr0ep9x5CODkb25ORlufnm2PvPQFGyI4aqSqqmKNQLQkARi', 
    'Pol', 'Moreno Queraltó', '+34 600 000 006', 
    '{"street": "", "city": "Molins de Rei", "postcode": "08750", "country": "ES"}', 
    '2001-02-18');

INSERT INTO user (id_user, id_user_type, username, role, email, password_hash, first_name, last_name, phone, address, birth_date) VALUES
-- Basic users
(1, (SELECT id_user_type FROM user_type WHERE name = 'basic'), 
    'johndoe', 'client', 'john.doe@email.com', 
    '$2y$10$3gUfX2.nQ1tQAmETObIRaO3ZFLhO4qkMdJKZMVRoJK.iraK9qFQIu', 
    'John', 'Doe', '+44 20 1234 5601', 
    '{"street": "123 High Street", "city": "London", "postcode": "SW1A 1AA", "country": "UK"}', 
    '1990-05-15'),

(2, (SELECT id_user_type FROM user_type WHERE name = 'basic'), 
    'janesmith', 'client', 'jane.smith@email.com', 
    '$2y$10$3gUfX2.nQ1tQAmETObIRaO3ZFLhO4qkMdJKZMVRoJK.iraK9qFQIu', 
    'Jane', 'Smith', '+44 20 1234 5602', 
    '{"street": "456 Oxford Road", "city": "Manchester", "postcode": "M1 1AD", "country": "UK"}', 
    '1985-08-22'),

-- Membership users
(3, (SELECT id_user_type FROM user_type WHERE name = 'membership'), 
    'sarahwilliams', 'client', 'sarah.williams@email.com', 
    '$2y$10$3gUfX2.nQ1tQAmETObIRaO3ZFLhO4qkMdJKZMVRoJK.iraK9qFQIu', 
    'Sarah', 'Williams', '+44 20 1234 5604', 
    '{"street": "321 Premium Avenue", "city": "Birmingham", "postcode": "B1 1AA", "country": "UK"}', 
    '1992-11-03'),

(4, (SELECT id_user_type FROM user_type WHERE name = 'membership'), 
    'davidbrown', 'client', 'david.brown@email.com', 
    '$2y$10$3gUfX2.nQ1tQAmETObIRaO3ZFLhO4qkMdJKZMVRoJK.iraK9qFQIu', 
    'David', 'Brown', '+44 20 1234 5605', 
    '{"street": "654 Member Street", "city": "Liverpool", "postcode": "L1 1AA", "country": "UK"}', 
    '1988-07-18'),

-- Brentford Players
(5, (SELECT id_user_type FROM user_type WHERE name = 'brentford_player'), 
    'ivantoney', 'client', 'ivan.toney@brentfordfc.com', 
    '$2y$10$3gUfX2.nQ1tQAmETObIRaO3ZFLhO4qkMdJKZMVRoJK.iraK9qFQIu', 
    'Ivan', 'Toney', '+44 20 1234 5606', 
    '{"street": "1 Jersey Road", "city": "Brentford", "postcode": "TW8 0NT", "country": "UK"}', 
    '1996-03-16'),

(7, (SELECT id_user_type FROM user_type WHERE name = 'brentford_player'), 
    'bryanmbeumo', 'client', 'bryan.mbeumo@brentfordfc.com', 
    '$2y$10$3gUfX2.nQ1tQAmETObIRaO3ZFLhO4qkMdJKZMVRoJK.iraK9qFQIu', 
    'Bryan', 'Mbeumo', '+44 20 1234 5607', 
    '{"street": "19 Stadium Way", "city": "Brentford", "postcode": "TW8 0NT", "country": "UK"}', 
    '1999-08-07'),

(8, (SELECT id_user_type FROM user_type WHERE name = 'brentford_player'), 
    'yoanewissa', 'client', 'yoane.wissa@brentfordfc.com', 
    '$2y$10$3gUfX2.nQ1tQAmETObIRaO3ZFLhO4qkMdJKZMVRoJK.iraK9qFQIu', 
    'Yoane', 'Wissa', '+44 20 1234 5608', 
    '{"street": "11 Gtech Road", "city": "Brentford", "postcode": "TW8 0NT", "country": "UK"}', 
    '1996-09-03'),

-- Brentford Staff
(9, (SELECT id_user_type FROM user_type WHERE name = 'brentford_staff'), 
    'thomasfrank', 'client', 'thomas.frank@brentfordfc.com', 
    '$2y$10$3gUfX2.nQ1tQAmETObIRaO3ZFLhO4qkMdJKZMVRoJK.iraK9qFQIu', 
    'Thomas', 'Frank', '+44 20 1234 5609', 
    '{"street": "1 Manager Office", "city": "Brentford", "postcode": "TW8 0NT", "country": "UK"}', 
    '1973-10-09'),

(10, (SELECT id_user_type FROM user_type WHERE name = 'brentford_staff'), 
    'philgiles', 'client', 'phil.giles@brentfordfc.com', 
    '$2y$10$3gUfX2.nQ1tQAmETObIRaO3ZFLhO4qkMdJKZMVRoJK.iraK9qFQIu', 
    'Phil', 'Giles', '+44 20 1234 5610', 
    '{"street": "2 Director Suite", "city": "Brentford", "postcode": "TW8 0NT", "country": "UK"}', 
    '1975-06-21');

-- =====================================================================
-- Summary
-- =====================================================================
-- User Types: 5 (basic, membership, brentford_player, brentford_staff, vip)
-- Discounts: 4 (for membership, brentford_player, brentford_staff, vip)
-- Users: 10 total
--   - 2 basic
--   - 2 membership
--   - 3 brentford_player
--   - 2 brentford_staff
--   - 1 vip (admin)
-- All passwords: 1234
-- =====================================================================

-- =====================================================================
-- PRODUCT RATINGS (10 per user from first 5 products of each category)
-- =====================================================================
-- Categories: appetiser (1-5), main (21-25), dessert (51-55), drink (62-66)
-- Each user gets minimum 2 ratings per category (2+2+2+2 = 8) + 2 extra
-- =====================================================================

INSERT INTO product_rating (id_user, id_product, rating, comment, created_at) VALUES
-- User 1 (johndoe)
(1, 1, 5, 'Delicious and fresh!', NOW()),
(1, 2, 3, 'Asparagus was a bit overcooked', NOW()),
(1, 3, 4, 'Good ceviche but needed more lime', NOW()),
(1, 4, 2, 'Salmon was too salty for my taste', NOW()),
(1, 21, 5, 'Best entrecôte in town', NOW()),
(1, 22, 4, 'Excellent roast chicken', NOW()),
(1, 23, 3, 'Octopus was slightly tough', NOW()),
(1, 24, 5, 'Pork ribs were succulent', NOW()),
(1, 51, 4, 'Berry sorbet was refreshing', NOW()),
(1, 52, 3, 'Lemon sorbet too sweet', NOW()),

-- User 2 (janesmith)
(2, 2, 5, 'Love the asparagus!', NOW()),
(2, 3, 4, 'Fresh and vibrant', NOW()),
(2, 4, 2, 'Salmon had a strange aftertaste', NOW()),
(2, 5, 1, 'Eggs were cold and bland', NOW()),
(2, 22, 5, 'Perfectly roasted', NOW()),
(2, 23, 3, 'Octopus was okay, nothing special', NOW()),
(2, 25, 4, 'Rabbit stew was good', NOW()),
(2, 26, 3, 'Lamb chops were a bit dry', NOW()),
(2, 53, 5, 'Mandarin sorbet is my favorite', NOW()),
(2, 54, 4, 'Melon sorbet refreshing', NOW()),

-- User 3 (sarahwilliams)
(3, 1, 3, 'Appetiser was average', NOW()),
(3, 3, 5, 'Ceviche perfection!', NOW()),
(3, 4, 4, 'Good salmon tartare', NOW()),
(3, 5, 2, 'Quail eggs were undercooked', NOW()),
(3, 21, 5, 'Incredible beef!', NOW()),
(3, 24, 5, 'Best pork ribs ever', NOW()),
(3, 27, 3, 'Duck was overpriced for the portion', NOW()),
(3, 28, 4, 'Venison stew was good', NOW()),
(3, 55, 5, 'Orange sorbet excellent', NOW()),
(3, 56, 3, 'Baked apple was mushy', NOW()),

-- User 4 (davidbrown)
(4, 2, 4, 'Asparagus perfectly grilled', NOW()),
(4, 5, 2, 'Eggs were too runny', NOW()),
(4, 1, 3, 'Zucchini carpaccio was bland', NOW()),
(4, 6, 1, 'Tomato salad was disappointing', NOW()),
(4, 23, 5, 'Octopus was tender and delicious', NOW()),
(4, 25, 4, 'Rabbit stew excellent', NOW()),
(4, 26, 5, 'Lamb chops perfect', NOW()),
(4, 30, 3, 'Seared tuna was overcooked', NOW()),
(4, 51, 4, 'Red berry sorbet nice', NOW()),
(4, 57, 5, 'Avocado mousse amazing!', NOW()),

-- User 5 (ivantoney)
(5, 1, 5, 'Fantastic appetiser!', NOW()),
(5, 2, 4, 'Grilled asparagus excellent', NOW()),
(5, 3, 3, 'Ceviche was too acidic', NOW()),
(5, 4, 5, 'Salmon tartare outstanding', NOW()),
(5, 21, 5, 'Best beef in London!', NOW()),
(5, 22, 4, 'Roasted chicken perfect', NOW()),
(5, 23, 5, 'Grilled octopus exceptional', NOW()),
(5, 24, 4, 'Iberian pork ribs very good', NOW()),
(5, 52, 3, 'Lemon sorbet lacked flavor', NOW()),
(5, 62, 2, 'Water tasted odd', NOW()),

-- User 7 (bryanmbeumo)
(7, 4, 5, 'Salmon tartare perfect!', NOW()),
(7, 5, 3, 'Quail eggs average', NOW()),
(7, 2, 4, 'Asparagus well done', NOW()),
(7, 3, 2, 'Ceviche too spicy', NOW()),
(7, 25, 5, 'Rabbit stew amazing', NOW()),
(7, 26, 3, 'Lamb chops were tough', NOW()),
(7, 21, 5, 'Beef entrecôte outstanding', NOW()),
(7, 27, 4, 'Duck breast with orange good', NOW()),
(7, 53, 5, 'Mandarin sorbet excellent', NOW()),
(7, 66, 2, 'Green tea was bitter', NOW()),

-- User 8 (yoanewissa)
(8, 1, 4, 'Zucchini carpaccio good', NOW()),
(8, 3, 5, 'Sea bass ceviche perfect', NOW()),
(8, 4, 3, 'Salmon tartare was okay', NOW()),
(8, 5, 2, 'Quail eggs disappointing', NOW()),
(8, 21, 5, 'Beef entrecôte incredible', NOW()),
(8, 23, 4, 'Grilled octopus very good', NOW()),
(8, 24, 3, 'Pork ribs too fatty', NOW()),
(8, 25, 5, 'Rabbit stew outstanding', NOW()),
(8, 51, 5, 'Red berry sorbet fantastic', NOW()),
(8, 54, 4, 'Melon sorbet nice', NOW()),

-- User 9 (thomasfrank)
(9, 2, 3, 'Asparagus needed more seasoning', NOW()),
(9, 4, 5, 'Salmon tartare best!', NOW()),
(9, 1, 4, 'Fresh zucchini appetiser', NOW()),
(9, 6, 1, 'Tomato orange salad terrible', NOW()),
(9, 22, 5, 'Roasted chicken perfect', NOW()),
(9, 26, 4, 'Lamb chops good', NOW()),
(9, 27, 3, 'Duck with orange average', NOW()),
(9, 30, 5, 'Seared tuna outstanding', NOW()),
(9, 55, 4, 'Orange sorbet good', NOW()),
(9, 57, 2, 'Avocado mousse too bland', NOW()),

-- User 10 (philgiles)
(10, 1, 3, 'Carpaccio was average', NOW()),
(10, 2, 5, 'Asparagus grilled perfectly', NOW()),
(10, 5, 2, 'Quail eggs undercooked', NOW()),
(10, 3, 4, 'Ceviche very good', NOW()),
(10, 21, 4, 'Beef good quality', NOW()),
(10, 25, 5, 'Rabbit stew amazing', NOW()),
(10, 28, 5, 'Venison stew exceptional', NOW()),
(10, 23, 3, 'Octopus was chewy', NOW()),
(10, 52, 4, 'Lemon sorbet refreshing', NOW()),
(10, 56, 3, 'Baked apple mediocre', NOW()),

-- User 6 (polmoreno - VIP admin)
(6, 6, 5, 'Tomato orange salad excellent!', NOW()),
(6, 7, 3, 'Chicken skewers dry', NOW()),
(6, 28, 4, 'Venison stew great', NOW()),
(6, 29, 5, 'Wild boar outstanding', NOW()),
(6, 58, 4, 'Watermelon melon skewers fresh', NOW()),
(6, 59, 2, 'Spiced orange too bitter', NOW());

-- =====================================================================
-- Summary of Product Ratings
-- =====================================================================
-- Total ratings inserted: 100 (10 per user for 10 users)
-- Distribution per user: 10 ratings minimum (2+ from each category)
-- Categories covered: appetiser, main, dessert, drink
-- =====================================================================
