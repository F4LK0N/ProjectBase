# RUN
Commands to run in shell terminal, from host and container.  
If you are using PHP Storm IDE you can run one entire block of code with one click in the green arrow in the top left corner. 
---



# Container Management
```shell
stty -echo;BKP=$PS1;PS1="";clear;echo "### CONTAINERS - UP ###";docker-compose up -d;echo "";stty echo;PS1=$BKP;
```
```shell
stty -echo;BKP=$PS1;PS1="";clear;echo "### CONTAINERS - UP (BUILD) ###";docker-compose up -d --build;echo "";stty echo;PS1=$BKP;
```
```shell
stty -echo;BKP=$PS1;PS1="";clear;echo "### CONTAINERS - DOWN ###";docker-compose down;echo "";stty echo;PS1=$BKP;
```
---
```shell
stty -echo;BKP=$PS1;PS1="";clear;echo "### CONTAINERS - LIST (ALL) ###";docker ps --no-trunc --filter name="^project_base\-.*$" --format "table {{.Names}}\t{{upper .State}}\t{{.Status}}\t{{.RunningFor}}\t{{.Ports}}\t{{.Image}}\t{{.Size}}\t{{.Command}}";echo "";stty echo;PS1=$BKP;
```
```shell
stty -echo;BKP=$PS1;PS1="";clear;echo "### CONTAINERS - LIST (NETWORKS) ###";docker ps --no-trunc --filter name="^project_base\-.*$" --format "table {{.Names}}\t{{upper .State}}\t{{.Ports}}\t{{.Networks}}";echo "";stty echo;PS1=$BKP;
```
```shell
stty -echo;BKP=$PS1;PS1="";clear;echo "### CONTAINERS - LIST (VOLUMES) ###";docker ps --no-trunc --filter name="^project_base\-.*$" --format "table {{.Names}}\t{{upper .State}}\t{{.Size}}\t{{.Mounts}}";echo "";stty echo;PS1=$BKP;
```
---



# Server
```shell
docker-compose exec server bash
```
---
```shell
stty -echo;BKP=$PS1;PS1="";clear;echo "### COMPOSER - DUMP AUTOLOAD ###";docker-compose exec server composer da;echo "";stty echo;PS1=$BKP;
```
---
```shell
stty -echo;BKP=$PS1;PS1="";clear;echo "### PHP UNIT - TEST ###";docker-compose exec server composer test;echo "";stty echo;PS1=$BKP;
```
```shell
stty -echo;BKP=$PS1;PS1="";clear;echo "### PHP UNIT - TEST (DOX) ###";docker-compose exec server composer dox;echo "";stty echo;PS1=$BKP;
```
```shell
stty -echo;BKP=$PS1;PS1="";clear;echo "### PHP UNIT - TEST (COVERAGE) ###";docker-compose exec server composer cover;echo "";stty echo;PS1=$BKP;
```
---
```shell
stty -echo;BKP=$PS1;PS1="";clear;echo "### PHP UNIT - CORE TEST ###";docker-compose exec server composer core-test;echo "";stty echo;PS1=$BKP;
```
```shell
stty -echo;BKP=$PS1;PS1="";clear;echo "### PHP UNIT - CORE TEST (DOX) ###";docker-compose exec server composer core-dox;echo "";stty echo;PS1=$BKP;
```
```shell
stty -echo;BKP=$PS1;PS1="";clear;echo "### PHP UNIT - CORE TEST (COVERAGE) ###";docker-compose exec server composer core-cover;echo "";stty echo;PS1=$BKP;
```
