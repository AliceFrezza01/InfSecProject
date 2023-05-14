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


###CSS not applying
Browser Refresh -> CMD/CTRL + SHIFT + R

###Multiple Ports for XAMPP -> test XSRF
- XAMPP/etc -> httpd.conf add Listen Port and uncomment:
    add Listen 8001
    uncomment: Options Indexes FollowSymLinks ExecCGI Includes
    uncomment: AllowOverride All + Require all granted under <Directory>

- XAMPP/etc/extra -> httpd-vhosts.conf add new port:

    <VirtualHost *:8001>
        ServerAdmin webmaster@dummy-host2.example.com
        DocumentRoot "/Applications/XAMPP/xamppfiles/htdocs/xsrf_project"
        ServerName localhost:8001
        ErrorLog "logs/dummy-8001.example.com-error_log"
        CustomLog "logs/dummy-8001.example.com-access_log" common
    </VirtualHost>
    
    and change: DocumentRoot of one VirtualHost:80 to: 
    DocumentRoot "/Applications/XAMPP/xamppfiles/htdocs"
    
- XAMPP/xamppfiles/apache2/conf -> httpd.conf add all:
    <Directory "/Applications/XAMPP/xamppfiles/apache2/htdocs">
        Options Indexes FollowSymLinks
        AllowOverride All
        Order allow,deny
        Allow from all
        Require all granted
    </Directory>



# Insecure Version Description

## SQL Injection
## XSS Reflection
## XSS Storing
## XSRF/CSRF
## Intercepting Chat Messages
## Password Attacks (Burp Intruder)
## Additional Vulnerabilities

## ProductInfo Page
Found vulnerabilities:
- XSRF=CSRF due to Form submissions: it is possibl for a hacker to impersonate another User whilst the User is logged in.
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

- SQL Injection
- XSS Reflection

Solution to prevent XSRF:
- forms should use POST instead of GET
- one could verify the HTTP headers "origin" and "referer", unfortunately these can easily be corrupted and are not mandatory for browsers to include
  thus the website might not work on all browsers
- using anti-XSRF Tokens: can either be implemented for each form or for the entire session. If the token is sufficiently complex and has an expiry time it should be fine
  but obviously a new Token for each form is even more secure as it limits the time a Hacker has to intrude.
- This website uses the POST method for all Forms and an anti-XSRF Token, which is generated once a user logs on and remains active for max 1h.


## Login and Register Page
Found vulnerabilities due to input fields:
- SQL Injection 
  For example insert in the username field the following query 
  to login with a certain account and without knowing the password
    ```
    carlo@gmail.com'#
    ```

## Chat Page
Found vulnerabilities due to input fields:
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

# Secure Version Description

## SQL Sanitation

For the SQL Sanitation agains SQL injection attacks I used Prepared Statements to execute the queries, instead of the standard 
``` mysqli::query()  ```method. Prepared Statement are useful agains this type of attack because the parameters of the query are sent
to the server after the query itself. The security is even more stronger by the use of input validation, which is done in the XSS
Sanitation part. 

## XSS Sanitation

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