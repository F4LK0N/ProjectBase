# Project

## Requirements
* **Docker** (20.10.17 or greater)
* **Docker Compose** (2.10.2 or greater)
* **PHP Storm** (Recommended Tool - 2022.2.1 or greater)

## Structure
* **Docker** - (Platform as a Service)
* **Docker Compose** - (Multi-container Docker Management)
* **Debian** 11.5 - (Linux Operational System)
* **Apache** 2.4.54 - (HTTP Server)
* **PHP** 8.1 - (Scripting Language)
* **XDebug** 3.1.5 - (Debugger and Profiler Tool)
* **Composer** 2.4.3 - (PHP Dependency Manager)
* **Slim** 4.10 - (PHP Micro Framework)
* **PSR-4** - (Specification: Classes Autoloader)
* **PSR-7** - (Specification: HTTP Message Interfaces)
* **PHP Unit** 9.5.25 - (Testing Framework)
* **Mockery** 1.5.1 - (Mock Object Framework)
* **PHP Storm Integration**

## Build and Run
```
docker-compose build
docker-compose up -d
docker-compose up -d --build
http://127.0.0.1
https://127.0.0.1
http://127.0.0.1:3306 (MySQL)
http://127.0.0.1:8080 (PHP My Admin)
```

## Manage

### Server
```
docker exec -it project_base-server /bin/bash
docker-compose exec server bash
composer install
composer update
composer dumpautoload
composer test
composer testdox
composer coverage
```

### MySQL
```
docker exec -it project_base-mysql /bin/bash
docker-compose exec mysql bash
```

### PHP My Admin
```
docker exec -it project_base-phpmyadmin /bin/bash
docker-compose exec phpmyadmin bash
```
---



# IDE - PHP Storm

## PHP Unit
- On PHP Storm, go to **"File > Settings"** to open the Settings menu;
- Open **"PHP > Test Frameworks"**;
- Click on the **"+"** button in the top left corner, and select **"PHP Unit from remote interpreter"**;
- Select **"PHP-Apache"**;  
  ![Image](%23DOCs/images/phpstorm-phpunit/1-0-Test-Frameworks.png)
  ![Image](%23DOCs/images/phpstorm-phpunit/1-2-Remote-Interpreter.png)

## XDebug
- On PHP Storm, go to **"File > Settings"** to open the Settings menu.
- Open **"PHP"**;
    - On **"PHP language level"** select **"8.1"**;
    - On **"CLI interpreter"** click on **"..."** on the right and a window to manage the CLI interpreters will open;
        - On that windows click on the **"+"** button in the top left corner, and select **"From Docker ..."**;
        - A windows to configure the remote PHP interpreter will open;
            - Select **"Docker Composer"**;
            - On **"Server"** click on **"New"**;
                - Select **"Unix Socket"** and click **"OK"**;
            - On **"Configuration files"** select **"./docker-compose.yml"**;
            - On **"Service"** select **"php-apache"**;
![Image](%23DOCs/images/phpstorm-xdebug/1-0-PHP.png)
![Image](%23DOCs/images/phpstorm-xdebug/1-1-Cli-Interpreter.png)
![Image](%23DOCs/images/phpstorm-xdebug/1-2-Remote-PHP-Interpreter.png)
![Image](%23DOCs/images/phpstorm-xdebug/1-3-Server.png)
![Image](%23DOCs/images/phpstorm-xdebug/1-4-PHP-Final.png)

- Open **"PHP > Debug"**, and go to the **"XDebug"** panel;
    - On the field **"Debug Port"** put the value **"10000"**.
![Image](%23DOCs/images/phpstorm-xdebug/2-0-Debug.png)

- Open **"PHP > Server"**, and click on the **"Add"** button;
    - On the field **"Name"** put the value **"127.0.0.1"**;
    - On the field **"Host"** put the value **"127.0.0.1"**;
    - On the field **"Port"** put the value **"80"**;
    - On the field **"Debugger:"** select **"Xdebug"**;
    - Mark the checkbox **"Use path mappings"**;
        - On the files lists that opened:
            - Map the folder **"Project files/.../src/"** to **"/var/www/html"**;
            - Map the folder **"Project files/.../src/public/"** to **"/var/www/html/public"**;
![Image](%23DOCs/images/phpstorm-xdebug/3-0-Server.png)
---



# References
* https://www.docker.com/
* https://docs.docker.com/compose/
* https://www.jetbrains.com/phpstorm/
* https://www.debian.org/
* https://httpd.apache.org/
* https://www.php.net/
* https://xdebug.org/
* https://getcomposer.org/
* https://www.slimframework.com/
* https://www.php-fig.org/psr/psr-4/
* https://www.php-fig.org/psr/psr-7/
* https://phpunit.de/
* http://docs.mockery.io/en/latest/
