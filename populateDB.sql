TRUNCATE TABLE user;
TRUNCATE TABLE product;
TRUNCATE TABLE purchasedby;
TRUNCATE TABLE review;
TRUNCATE TABLE chatmessage;

-- Buyers
INSERT INTO user(email, password, salt, name, isVendor)
VALUES ("carlo@gmail.com", "psw_carlo", 0, "carlo", 0);

INSERT INTO user(email, password, salt, name, isVendor)
VALUES ("alex@gmail.com", "psw_alex", 0, "alex", 0);

INSERT INTO user(email, password, salt, name, isVendor)
VALUES ("maria@gmail.com", "psw_maria", 0, "maria", 0);

INSERT INTO user(email, password, salt, name, isVendor)
VALUES ("giancarlo@gmail.com", "psw_giancarlo", 0, "giancarlo", 0);

-- Sellers
INSERT INTO user(email, password, salt, name, isVendor)
VALUES ("filippo@gmail.com", "psw_filippo", 0, "filippo", 1);

INSERT INTO user(email, password, salt, name, isVendor)
VALUES ("irma@gmail.com", "psw_irma", 0, "irma", 1);

INSERT INTO user(email, password, salt, name, isVendor)
VALUES ("mariene@gmail.com", "psw_mariene", 0, "mariene", 1);

INSERT INTO user(email, password, salt, name, isVendor)
VALUES ("manuel@gmail.com", "psw_manuel", 0, "manuel", 1);

INSERT INTO user(email, password, salt, name, isVendor)
VALUES ("andrea@gmail.com", "psw_andrea", 0, "andrea", 1);

INSERT INTO user(email, password, salt, name, isVendor)
VALUES ("matilde@gmail.com", "psw_matilde", 0, "matilde", 1);

INSERT INTO user(email, password, salt, name, isVendor)
VALUES ("iacopo@gmail.com", "psw_iacopo", 0, "iacopo", 1);

INSERT INTO user(email, password, salt, name, isVendor)
VALUES ("goffredo@gmail.com", "psw_goffredo", 0, "goffredo", 1);

INSERT INTO user(email, password, salt, name, isVendor)
VALUES ("clio@gmail.com", "psw_clio", 0, "clio", 1);

INSERT INTO user(email, password, salt, name, isVendor)
VALUES ("adelaide@gmail.com", "psw_adelaide", 0, "adelaide", 1);


-- Products
-- all the picture have been taken from https://unsplash.com/

INSERT INTO product(name, price, imgLink, creatorUserID)
VALUES ("race bikecycle", 250.50, "https://images.unsplash.com/photo-1589556264800-08ae9e129a8c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80", 5);

INSERT INTO product(name, price, imgLink, creatorUserID)
VALUES ("vintage table", 70.00, "https://images.unsplash.com/photo-1577926103605-f426874bee28?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80", 6);

INSERT INTO product(name, price, imgLink, creatorUserID)
VALUES ("macbook air M2", 1520, "https://images.unsplash.com/photo-1514342959091-2bffd8a7c4ba?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80", 8);

INSERT INTO product(name, price, imgLink, creatorUserID)
VALUES ("yellow-gray running shoes", 170, "https://images.unsplash.com/photo-1610969770059-7084269fa3be?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80", 9);

INSERT INTO product(name, price, imgLink, creatorUserID)
VALUES ("quietcomfort 45", 400, "https://images.unsplash.com/photo-1546435770-a3e426bf472b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1165&q=80", 10);

INSERT INTO product(name, price, imgLink, creatorUserID)
VALUES ("elastic bands", 8.50, "https://images.unsplash.com/photo-1593714967758-8810365b6b69?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1172&q=80", 11);

INSERT INTO product(name, price, imgLink, creatorUserID)
VALUES ("smart watch", 180.00, "https://images.unsplash.com/photo-1544117519-31a4b719223d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1352&q=80", 12);

INSERT INTO product(name, price, imgLink, creatorUserID)
VALUES ("repair kit", 30.50, "https://images.unsplash.com/photo-1674503535026-a8f6ea1e3a30?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1287&q=80", 13);

INSERT INTO product(name, price, imgLink, creatorUserID)
VALUES ("colorful notebooks", 5.50, "https://images.unsplash.com/photo-1615502731978-f9d0c593d6c4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1171&q=80", 14);

INSERT INTO product(name, price, imgLink, creatorUserID)
VALUES ("red scooter", 4000.00, "https://images.unsplash.com/photo-1519750292352-c9fc17322ed7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1285&q=80", 15);

INSERT INTO product(name, price, imgLink, creatorUserID)
VALUES ("desk", 220.00, "https://images.unsplash.com/photo-1519219788971-8d9797e0928e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1444&q=80", 14);

INSERT INTO product(name, price, imgLink, creatorUserID)
VALUES ("skin products", 56.00, "https://images.unsplash.com/photo-1656147962576-613e7b936c31?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1285&q=80", 13);

INSERT INTO product(name, price, imgLink, creatorUserID)
VALUES ("fresh bread", 1.50, "https://images.unsplash.com/photo-1681766864796-f29d9bbad741?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1348&q=80", 12);

INSERT INTO product(name, price, imgLink, creatorUserID)
VALUES ("hand art", 240.00, "https://images.unsplash.com/photo-1681484357464-a9c81326c04b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1328&q=80", 11);

INSERT INTO product(name, price, imgLink, creatorUserID)
VALUES ("soap container", 7.20, "https://images.unsplash.com/photo-1614806686974-4d53169a47cd?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1287&q=80", 1);

INSERT INTO product(name, price, imgLink, creatorUserID)
VALUES ("donuts", 10.00, "https://images.unsplash.com/photo-1514517521153-1be72277b32f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1287&q=80", 1);

INSERT INTO product(name, price, imgLink, creatorUserID)
VALUES ("love sign, ideal for couples", 6.20, "https://images.unsplash.com/photo-1518414881329-0f96c8f2a924?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1189&q=80", 1);

INSERT INTO product(name, price, imgLink, creatorUserID)
VALUES ("chocolate eggs for easter", 3.75, "https://plus.unsplash.com/premium_photo-1676813808814-38617c86c419?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1335&q=80", 1);

-- Orders

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (1, 1, '2023-04-25 15:30:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (2, 3, '2023-05-25 10:00:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (3, 5, '2023-06-25 12:45:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (4, 7, '2023-07-25 08:15:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (5, 9, '2023-08-25 16:30:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (6, 11, '2023-09-25 11:00:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (7, 13, '2023-10-25 13:45:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (8, 2, '2023-11-25 18:00:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (9, 4, '2023-12-25 11:30:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (10, 6, '2024-01-25 08:15:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (11, 8, '2024-02-25 16:45:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (12, 10, '2024-03-25 10:00:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (13, 12, '2024-04-25 12:30:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (14, 14, '2024-05-25 17:00:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (15, 1, '2024-06-25 11:45:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (16, 3, '2024-07-25 08:30:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (1, 5, '2024-08-25 13:00:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (2, 7, '2024-09-25 15:45:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (3, 9, '2024-10-25 09:00:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (4, 11, '2024-11-25 14:30:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (7, 12, '2025-01-05 11:20:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (4, 9, '2025-02-10 09:30:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (2, 3, '2025-03-15 15:45:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (10, 7, '2025-04-20 12:00:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (13, 11, '2025-05-25 16:30:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (16, 14, '2025-06-30 10:45:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (5, 8, '2025-07-05 13:00:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (3, 6, '2025-08-10 11:15:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (1, 1, '2025-09-15 08:30:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (12, 10, '2025-10-20 14:00:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (6, 5, '2025-11-25 16:45:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (8, 13, '2025-12-30 10:00:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (14, 2, '2026-01-05 14:30:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (15, 14, '2026-02-10 11:00:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (11, 4, '2026-03-15 08:15:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (9, 7, '2026-04-20 13:45:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (7, 12, '2026-05-25 16:00:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (4, 9, '2026-06-30 09:30:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (2, 3, '2026-07-05 12:45:00');

INSERT INTO purchasedby(productId, userId, buyDate)
VALUES (10, 7, '2026-08-10 15:30:00');

-- Reviews

INSERT INTO review(text, replyOfReviewID, userID, productID) VALUES ("is this product new?", 0, 2, 10);

INSERT INTO review(text, replyOfReviewID, userID, productID) VALUES ("Is this product available in other colors?", 0, 9, 5);

INSERT INTO review(text, replyOfReviewID, userID, productID) VALUES ("How long does it take to charge?", 0, 6, 8);

INSERT INTO review(text, replyOfReviewID, userID, productID) VALUES ("Does this product come with a warranty?", 0, 12, 2);

INSERT INTO review(text, replyOfReviewID, userID, productID) VALUES ("Is this product easy to assemble?", 0, 1, 14);

INSERT INTO review(text, replyOfReviewID, userID, productID) VALUES ("How many sizes does this product come in?", 0, 4, 18);

INSERT INTO review(text, replyOfReviewID, userID, productID) VALUES ("Is this product durable?", 0, 11, 7);

INSERT INTO review(text, replyOfReviewID, userID, productID) VALUES ("Is this product dishwasher safe?", 0, 8, 12);

INSERT INTO review(text, replyOfReviewID, userID, productID) VALUES ("What is the weight of this product?", 0, 2, 10);

INSERT INTO review(text, replyOfReviewID, userID, productID) VALUES ("Does this product have any harmful chemicals?", 0, 10, 17);

INSERT INTO review(text, replyOfReviewID, userID, productID) VALUES ("What is the maximum weight limit for this product?", 0, 3, 6);

INSERT INTO review(text, replyOfReviewID, userID, productID) VALUES ("Does this product come with a user manual?", 0, 5, 11);

INSERT INTO review(text, replyOfReviewID, userID, productID) VALUES ("Is this product suitable for outdoor use?", 0, 13, 1);

INSERT INTO review(text, replyOfReviewID, userID, productID) VALUES ("What is the warranty period for this product?", 0, 7, 13);

INSERT INTO review(text, replyOfReviewID, userID, productID) VALUES ("Is this product easy to clean?", 0, 9, 8);

INSERT INTO review(text, replyOfReviewID, userID, productID) VALUES ("What is the material of this product?", 0, 6, 14);

INSERT INTO review(text, replyOfReviewID, userID, productID) VALUES ("Is this product BPA-free?", 0, 1, 5);

INSERT INTO review(text, replyOfReviewID, userID, productID) VALUES ("What is the capacity of this product?", 0, 4, 2);

INSERT INTO review(text, replyOfReviewID, userID, productID) VALUES ("Is this product suitable for a certain age group?", 0, 11, 14);

INSERT INTO review(text, replyOfReviewID, userID, productID) VALUES ("What is the size of this product?", 0, 8, 18);

-- SQL Statement to update the passwords with the salt

UPDATE user SET
    salt = cast(RAND()*10000 as decimal(4,0));

UPDATE user SET
    password = SHA2(CONCAT(password, salt), 384);


