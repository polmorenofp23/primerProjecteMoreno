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
('brentford_staff', 'Brentford FC staff member with special privileges');

-- =====================================================================
-- DISCOUNTS FOR USER TYPES (excluding 'basic')
-- =====================================================================
INSERT INTO discount (name, description, percentage, status, type, id_user_type) VALUES
('Membership Discount', 'Exclusive 15% discount for premium members', 15, 'active', 'user_type', 
    (SELECT id_user_type FROM user_type WHERE name = 'membership')),
('Brentford Player VIP', 'VIP 100% discount for Brentford FC players', 100, 'active', 'user_type', 
    (SELECT id_user_type FROM user_type WHERE name = 'brentford_player')),
('Brentford Staff Discount', 'Special 50% discount for Brentford FC staff', 50, 'active', 'user_type', 
    (SELECT id_user_type FROM user_type WHERE name = 'brentford_staff'));

-- =====================================================================
-- USERS (password: 1234 hashed with bcrypt)
-- Hash: $2y$10$3gUfX2.nQ1tQAmETObIRaO3ZFLhO4qkMdJKZMVRoJK.iraK9qFQIu
-- =====================================================================

-- Admin user: Pol Moreno Queraltó (force id_user = 6)
INSERT INTO user (id_user, id_user_type, username, role, email, password_hash, first_name, last_name, phone, address, birth_date) VALUES
(6, (SELECT id_user_type FROM user_type WHERE name = 'basic'), 
    'polmoreno', 'admin', 'pol.moreno@beescavern.com', 
    '$2y$10$Mu41XUGr0ep9x5CODkb25ORlufnm2PvPQFGyI4aqSqqmKNQLQkARi', 
    'Pol', 'Moreno Queraltó', '+34 600 000 006', 
    '{"street": "", "city": "Molins de Rei", "postcode": "08750", "country": "ES"}', 
    '2001-02-18');

INSERT INTO user (id_user_type, username, role, email, password_hash, first_name, last_name, phone, address, birth_date) VALUES
-- Basic users
((SELECT id_user_type FROM user_type WHERE name = 'basic'), 
    'johndoe', 'client', 'john.doe@email.com', 
    '$2y$10$3gUfX2.nQ1tQAmETObIRaO3ZFLhO4qkMdJKZMVRoJK.iraK9qFQIu', 
    'John', 'Doe', '+44 20 1234 5601', 
    '{"street": "123 High Street", "city": "London", "postcode": "SW1A 1AA", "country": "UK"}', 
    '1990-05-15'),

((SELECT id_user_type FROM user_type WHERE name = 'basic'), 
    'janesmith', 'client', 'jane.smith@email.com', 
    '$2y$10$3gUfX2.nQ1tQAmETObIRaO3ZFLhO4qkMdJKZMVRoJK.iraK9qFQIu', 
    'Jane', 'Smith', '+44 20 1234 5602', 
    '{"street": "456 Oxford Road", "city": "Manchester", "postcode": "M1 1AD", "country": "UK"}', 
    '1985-08-22'),

-- Membership users
((SELECT id_user_type FROM user_type WHERE name = 'membership'), 
    'sarahwilliams', 'client', 'sarah.williams@email.com', 
    '$2y$10$3gUfX2.nQ1tQAmETObIRaO3ZFLhO4qkMdJKZMVRoJK.iraK9qFQIu', 
    'Sarah', 'Williams', '+44 20 1234 5604', 
    '{"street": "321 Premium Avenue", "city": "Birmingham", "postcode": "B1 1AA", "country": "UK"}', 
    '1992-11-03'),

((SELECT id_user_type FROM user_type WHERE name = 'membership'), 
    'davidbrown', 'client', 'david.brown@email.com', 
    '$2y$10$3gUfX2.nQ1tQAmETObIRaO3ZFLhO4qkMdJKZMVRoJK.iraK9qFQIu', 
    'David', 'Brown', '+44 20 1234 5605', 
    '{"street": "654 Member Street", "city": "Liverpool", "postcode": "L1 1AA", "country": "UK"}', 
    '1988-07-18'),

-- Brentford Players
((SELECT id_user_type FROM user_type WHERE name = 'brentford_player'), 
    'ivantoneyfc', 'client', 'ivan.toney@brentfordfc.com', 
    '$2y$10$3gUfX2.nQ1tQAmETObIRaO3ZFLhO4qkMdJKZMVRoJK.iraK9qFQIu', 
    'Ivan', 'Toney', '+44 20 1234 5606', 
    '{"street": "1 Jersey Road", "city": "Brentford", "postcode": "TW8 0NT", "country": "UK"}', 
    '1996-03-16'),

((SELECT id_user_type FROM user_type WHERE name = 'brentford_player'), 
    'bryanmbeumo', 'client', 'bryan.mbeumo@brentfordfc.com', 
    '$2y$10$3gUfX2.nQ1tQAmETObIRaO3ZFLhO4qkMdJKZMVRoJK.iraK9qFQIu', 
    'Bryan', 'Mbeumo', '+44 20 1234 5607', 
    '{"street": "19 Stadium Way", "city": "Brentford", "postcode": "TW8 0NT", "country": "UK"}', 
    '1999-08-07'),

((SELECT id_user_type FROM user_type WHERE name = 'brentford_player'), 
    'yoanewissa', 'client', 'yoane.wissa@brentfordfc.com', 
    '$2y$10$3gUfX2.nQ1tQAmETObIRaO3ZFLhO4qkMdJKZMVRoJK.iraK9qFQIu', 
    'Yoane', 'Wissa', '+44 20 1234 5608', 
    '{"street": "11 Gtech Road", "city": "Brentford", "postcode": "TW8 0NT", "country": "UK"}', 
    '1996-09-03'),

-- Brentford Staff
((SELECT id_user_type FROM user_type WHERE name = 'brentford_staff'), 
    'thomasfrank', 'client', 'thomas.frank@brentfordfc.com', 
    '$2y$10$3gUfX2.nQ1tQAmETObIRaO3ZFLhO4qkMdJKZMVRoJK.iraK9qFQIu', 
    'Thomas', 'Frank', '+44 20 1234 5609', 
    '{"street": "1 Manager Office", "city": "Brentford", "postcode": "TW8 0NT", "country": "UK"}', 
    '1973-10-09'),

((SELECT id_user_type FROM user_type WHERE name = 'brentford_staff'), 
    'philgiles', 'client', 'phil.giles@brentfordfc.com', 
    '$2y$10$3gUfX2.nQ1tQAmETObIRaO3ZFLhO4qkMdJKZMVRoJK.iraK9qFQIu', 
    'Phil', 'Giles', '+44 20 1234 5610', 
    '{"street": "2 Director Suite", "city": "Brentford", "postcode": "TW8 0NT", "country": "UK"}', 
    '1975-06-21');

-- =====================================================================
-- Summary
-- =====================================================================
-- User Types: 4 (basic, membership, brentford_player, brentford_staff)
-- Discounts: 3 (for membership, brentford_player, brentford_staff)
-- Users: 10 total
--   - 3 basic (2 clients + 1 admin)
--   - 2 membership
--   - 3 brentford_player
--   - 2 brentford_staff
-- All passwords: 1234
-- =====================================================================
