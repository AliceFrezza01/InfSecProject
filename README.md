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

## Chat Page
Found vulnerabilities due to input fields in the Review:
- SQL Injection