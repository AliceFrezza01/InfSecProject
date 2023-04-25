TRUNCATE TABLE user;
TRUNCATE TABLE product;

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


-- Orders