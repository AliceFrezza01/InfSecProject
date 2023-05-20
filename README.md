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
    - not dangeours.
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
- Similar situation is when a user registers itself with a malicous username or email address. This is 
  dangerous due to the fact that this data can be seen by other users in multiple parts of the website,
  making thefore possible the attack. 

### Notes

All the pages that receive values from the field using GET are protected, making sure that the value inserted is
what it should be. In the orders.php page, for example, the id of the vendor is sent though get from the landing page. 
But in the orders.php page, there is a check ensuring that the number passed corresponds to the id of the vendor: 
    ``` php
    if ($user['isVendor']==0) {
        header('location: landingPage.php');
    }
    ``` 


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
  For example add a script into the chat field, so if the person who the chatmessage was sent opens the chat, this script will be executed
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

## Other vulnerabilities

- In the orders.php page there is no check ensuring that a user sees only its orders
    ``` sql 
    http://localhost/InfSecProject/orders.php?vendorId=...
    -- One could insert any value as vendorId
    ```

# Secure Version Description

## **SQL Sanitation**

For the SQL Sanitation agains SQL injection attacks I used Prepared Statements to execute the queries, instead of the standard 
``` mysqli::query()  ```method. Prepared Statement are useful agains this type of attack because the parameters of the query are sent
to the server after the query itself. The security is even more stronger by the use of input validation, which is done in the XSS
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
    Therefore we don't need to worry about sql injection attacks which are based on executing multiple queries at the same time. 
    However the developer should be careful about the possibility of attacks based on JOIN. 

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

### xssSanification.php file

xssSanification implements a function called ```sanitation``` which takes in input three variables: ``` $text, $dataType, $quoteStrict ```. According to the data type of the variable inserted and whether we are encoding the quotes strictly, 
it will return as output the safe version of the previous data. More documentation of the function can be found on the file itself.

