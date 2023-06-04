# InfSecProject

Group members:
- Victoria Winkler
- Alice Frezza,
- Linda Maria Pircher

In this Github repository there are two branches:
- main: insecure version of the application
- secureversion: secure version of the application

# User manual
To install the application you need XAMPP installed on your PC.
Then follow the following steps:
- clone repository in the htdocs folder of your XAMPP application
- start in the XAMPP control panel the Apache and MySQL Server
- go in your browser on http://localhost/phpmyadmin/ and import the database
- check if the data in the `connect.php` is correct, you might need a different port
- launch http://localhost/InfSecProject/login.php in your browser

## SOLUTIONS for SETUP Issues
if SQL Database does not start -> kill in Activity Monitor -> search for _mysql

# Insecure Version Description

## **SQL Injection**
SQL attacks can be found in multiple pages. Some examples are:

- Login and Register Page.<br>
  Inserting in the username field the following query allows an attacker
  to login with a certain account and without knowing the password.
    ```
    carlo@gmail.com'#
    ```

- Landing Page.<br>
  Inserting in the search field the following query allows an attacker
  to not apply the filter for the world written, but to show all the products.
  It would not be too dangerous anyway.
    ```
    abcdefg%' OR 1=1 -- 
    ```

- Order Page. <br>
  These two SQL attacks are possible in the order page.
  - not dangerous.
      ``` sql 
      http://localhost/InfSecProject/orders.php?vendorId=5%20--
      -- This url does not order the orders
      ```
  - dangerous.
      ``` sql 
      http://localhost/InfSecProject/orders.php?vendorId=5%20OR%201=1%20--
      -- This url allows to see all the orders done by everyone
      ```

## **XSS Attacks**
XSS attacks can be found in multiple pages. Some examples are:

- In the Chat and ProductInfo page it is possible to perform XSS Stored attack like:
    ``` js 
    <script>alert("I am an attacker")</script>
    ```
  by inserting this string in the field.

- The same attack can be used also in the productNew.php page, in each of the three fields.
- A similar situation occurs when a user registers itself with a malicious username or email address. This is
  dangerous due to the fact that this data can be seen by other users in multiple parts of the website,
  making therefore possible the attack.

### Notes
All the pages that receive values from the field using GET are protected, making sure that the value inserted is
what it should be. In the `orders.php` page, for example, the id of the vendor is send through get from the landing page.
but in the orders.php` page, there is a check ensuring that the number passed corresponds to the id of the vendor:
``` php
if ($user['isVendor']==0) {
header('location: landingPage.php');
}`
```

## XSRF/CSRF
Cross Site Request Forgery can be used to manipulate or retrieve data whilst the user is logged in.(=ongoing session)
It can happen from a different Server and can often go unnoticed by the user.
It usually happens when doing Form submissions for example on the product info page.
- It is possible for a hacker to impersonate the currently logged in user.
  For example a click on an innocent Button on any web page might trigger a purchase of a product on this website.
  Example Code which can be used for XSRF:
    ```
    <form action="http://localhost/infsec_project01/productInfo.php?productId=2" method="post">
            <input type="hidden" name="buyProduct" value="BUY PRODUCT">
    <!--        NOT NEEDED FOR FIRST ATTEMPT WITHOUT TOKEN IN PLACE-->
            <input type="hidden" name="token" value="12345678765432">
            <input type="submit" name="hack2" value="BUY HACK">
    </form>
    ```


## Password Attacks (Burp Intruder)
Passwords can be simply brute-forced since the character set is not so large. Additionally, passwords can be discovered
with rainbow tables.

## Additional Vulnerabilities
- In the orders.php page there is no check ensuring that a user sees only his orders
    ``` sql 
    http://localhost/InfSecProject/orders.php?vendorId=...
    -- One could insert any value as vendorId
    ```


# Secure Version Description

## **SQL Sanitation**
For the SQL Sanitation against SQL injection attacks I used Prepared Statements to execute the queries, instead of the standard
``` mysqli::query()  ```method. Prepared Statement are useful against this type of attack because the parameters of the query are sent
to the server after the query itself. The security is even stronger by the use of input validation, which is done in the XSS
Sanitation part.

### Notes
In order to perform multiple queries in one statement, PHP requires to use the function :
``` php
public mysqli::multi_query(string $query): bool
```
Throughout our project we only used:
``` php
public mysqli::query(string $query, int $result_mode = MYSQLI_STORE_RESULT): mysqli_result|bool
```
Therefore, we don't need to worry about sql injection attacks which are based on executing multiple queries at the same time.
However, the developer should be careful about the possibility of attacks based on JOIN.

## **XSS Sanitation**
In order to protect the website from XSS attacks, both reflected and stored, I implemented the following safety measures:
- filtering the input values received from $GET and $POST fields. For this I used the following php functions:
  - ```trim()```
  - ```strip_tags()```
  - ```filter_var()```
- escaping special characters of the output string before outputting it. This has been done using ```htmlspecialchars()```.

### Tests
The website has been tested against most of the possible XSS attacks. Examples are:
- ```"><script >alert(document.cookie)</script >```
- ```"%3cscript%3ealert(document.cookie)%3c/script%3e```
- ```<scr<script>ipt>alert(document.cookie)</script>```

Reference: https://owasp.org/www-project-web-security-testing-guide/latest/4-Web_Application_Security_Testing/07-Input_Validation_Testing/01-Testing_for_Reflected_Cross_Site_Scripting

### xssSanitation.php file
xssSanitation.php implements a function called ```sanitation``` which takes in input three variables: ``` $text, $dataType, $quoteStrict ```. According to the data type of the variable inserted and whether we are encoding the quotes strictly,
it will return as output the safe version of the previous data. More documentation of the function can be found on the file itself.

## **Cross-Site-Request-Forgery (=CSRF or XSRF) protection**
Methods to prevent XSRF attacks are:
- forms should use POST instead of GET
- verifying the HTTP headers "origin" and "referer", unfortunately these can easily be corrupted and are not mandatory for browsers to include
  thus the website might not work on all browsers
- using anti-XSRF Tokens: can either be implemented for each form or for the entire session. If the token is sufficiently complex and has an expiry time it should be fine
  but obviously a new Token for each form is even more secure as it limits the time a Hacker has to intrude.

This website uses the POST method for all Forms and an anti-XSRF Token, which is generated once a user logs on and remains active for max 1h.

### Implementation
upon logging in a token is generated and stored in the session:
```
$_SESSION["token"] = bin2hex(random_bytes(32));  
$_SESSION["token-expiry"] = time() + 3600;  //after 1h
```

each form then contains a hidden field called token:
```
<form method="post">
    <input type="hidden" name="token" value="<?=$_SESSION["token"]?>">
    <input class="button" type="submit" name="search" value="Search" />
</form>
```

which is then validated before making a query to the DB:
```
$token = input($_POST['token']);
  if (verifyToken($token)) {
      // CALLS TO DB ...
  }
  else {
      exit('invalid token');
  }
```


## **Buy product with digital signature algorithm (=DSA)**
The DSA is used to ensure that the user who is buying a product is a valid user of the website and not an impersonator, hacker or computer.
### Implementation
The DSA produces a signature which uses a signature-message and the privateKey of the buyer and encodes it using an algorithm such as SHA256.
```
$signatureMessage = "rightful purchase";
openssl_sign($signatureMessage, $signature, $privateKey, OPENSSL_ALGO_SHA256);
```

On validation the Seller has access to the publicKey of the Buyer and knows the signature-message and using the same algorithm decodes the signature.
```
$verification = openssl_verify($signatureMessage, $signature, $publicKey, "sha256WithRSAEncryption");
```


## **Securing the login**
- Storing passwords with salt to prevent the usage of rainbow tables
  For every user in the database there is a new column salt. The salt is generated when the user is registering with
  a linear congruential generator and saved in this column in plain text.
  The password saved in the database is the encryption of the concatenation of userpassword and salt.
- check complexity of passwords to prevent bruteforce
  implement a function in php to validate the complexity of the password on the register page. It follows the following rules:
  - at least 8 characters
  - at least one uppercase letter
  - at least one lowercase letter
  - at least one number
  - at least one special character

