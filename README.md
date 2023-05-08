# InfSecProject


#SOLUTIONS for SETUP Issues
if SQL Database does not restart -> kill in Activity Monitor search for _mysql

enable event_scheduler for compatibility with PHPStorm!
check: SELECT @@event_scheduler;
change temporarily -> go to Variables in phpMyAdmin -> event -> ON
change permanently -> my.cnf or my.ini -> add event_scheduler=ON to [mysqld]

a *mysql_upgrade* from directory: /Applications/XAMPP/xamppfiles/bin and type: sudo ./mysql_upgrade might be needed to allow for the scheduler to turn ON
to access *MariaDB Monitor*: /Applications/XAMPP/xamppfiles/bin and type ./mysql -u root

set up live edit: Deployment + local or mounted folder -> Folder: htdocs, Web Server: http://localhost/infsec_project01


#CSS not applying
Browser Refresh -> CMD/CTRL + SHIFT + R

# Insecure Version Description

## SQL Injection
## XSS Reflection
## XSS Storing
## XSRF
## Intercepting Chat Messages
## Password Attacks (Burp Intruder)
## Additional Vulnerabilities

## ProductInfo Page
Found vulnerabilities due to input fields in the Review:
- SQL Injection
- XSS Reflection

## Login and Register Page
Found vulnerabilities due to input fields in the Review:
- SQL Injection 
  For example insert in the username field the following query 
  to login with a certain account and without knowing the password
    ```
    carlo@gmail.com'#
    ```

## Chat Page
Found vulnerabilities due to input fields in the Review:
- SQL Injections in the chatmessage input field
- XSS stored
  For example add a script into the chat field, so if the person who the chatmessage was sendet opens the chat, this script will be executed
   ``` js 
    <script>alert("I am an attacker")</script>
    ```

## Landing Page
Found vulnerabilities due to input fields for filtering the products:
- SQL Injection. It is possible but does not make sense:
    ```
    abcdefg%' OR 1=1 -- 
    ```

## Order Page
Found vulnerabilities due to:
- there is no check ensuring that a user sees only its orders
    ``` sql 
    http://localhost/InfSecProject/orders.php?vendorId=...
    -- One could insert any value as vendorId
    ```
- sql injection.
    - not dangeours
        ``` sql 
        http://localhost/InfSecProject/orders.php?vendorId=5%20--
        -- This url does not order the orders
        ```
    - dangerous
        ``` sql 
        http://localhost/InfSecProject/orders.php?vendorId=5%20OR%201=1%20--
        -- This url allows to see all the orders done by everyone
        ```

## Add New Product
Found vulnerabilities due to the three input fields to add a product :
- XSS Stored, working then on Landing Page.
    One could enter as values of the new product a script, like the following:
    ``` js 
    <script>alert("I am an attacker")</script>
    ```

# Notes

- In order to perform multiple queries in one statement, PHP requires to use the function :
    ``` php
    public mysqli::multi_query(string $query): bool
    ```
    Throughout our project we only used: 
    ``` php
    public mysqli::query(string $query, int $result_mode = MYSQLI_STORE_RESULT): mysqli_result|bool
    ```
    Therefore we don't need to worry about sql injection attacks which are based on executing multiple queries at the same time. 
    However the developer should be careful about the possibility of attacks based on JOIN. 