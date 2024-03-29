# ~/.bashrc: executed by bash(1) for non-login shells.

# Note: PS1 and umask are already set in /etc/profile. You should not
# need this unless you want different defaults for root.
# PS1='${debian_chroot:+($debian_chroot)}\h:\w\$ '
# PS1='${debian_chroot:+($debian_chroot)}\u@\h:\w\$ '
# umask 022

###################################################
### QUICK REFERENCES ###
###################################################
#################
### PS1 CODES ###
#################
# \u: Current User
# \h: Hostname Short
# \h: Hostname Long
# \w: Workdir Full Path
# \W: Workdir Current Folder Only
# \d: Date with weekday name, month name, and date.
##############
### COLORS ###
##############
# SYNTAX:
# \e[<STYLE>;<COLOR>m<TEXT>\e[m
#
# WHERE:
# <TEXT>: Your text or variable containing text;
# <STYLE>: A number indicating a text mode;
# <COLOR>: A number indicating a foreground color;
#
###################################################
### FULL GUIDE ###
###################################################
# References:
# https://stackoverflow.com/questions/5947742/how-to-change-the-output-color-of-echo-in-linux
# |------------+----------+---------+-------+------------------+------------------------------+--------------------------------------|
# | color-mode | octal    | hex     | bash  | description      | example (= in octal)         | NOTE                                 |
# |------------+----------+---------+-------+------------------+------------------------------+--------------------------------------|
# |          0 | \033[0m  | \x1b[0m | \e[0m | reset any affect | echo -e "\033[0m"            | 0m equals to m                       |
# |          1 | \033[1m  |         |       | light (= bright) | echo -e "\033[1m####\033[m"  | -                                    |
# |          2 | \033[2m  |         |       | dark (= fade)    | echo -e "\033[2m####\033[m"  | -                                    |
# |------------+----------+---------+-------+------------------+------------------------------+--------------------------------------|
# |  text-mode | ~        |         |       | ~                | ~                            | ~                                    |
# |------------+----------+---------+-------+------------------+------------------------------+--------------------------------------|
# |          3 | \033[3m  |         |       | italic           | echo -e "\033[3m####\033[m"  |                                      |
# |          4 | \033[4m  |         |       | underline        | echo -e "\033[4m####\033[m"  |                                      |
# |          5 | \033[5m  |         |       | blink (slow)     | echo -e "\033[3m####\033[m"  |                                      |
# |          6 | \033[6m  |         |       | blink (fast)     | ?                            | not wildly support                   |
# |          7 | \003[7m  |         |       | reverse          | echo -e "\033[7m####\033[m"  | it affects the background/foreground |
# |          8 | \033[8m  |         |       | hide             | echo -e "\033[8m####\033[m"  | it affects the background/foreground |
# |          9 | \033[9m  |         |       | cross            | echo -e "\033[9m####\033[m"  |                                      |
# |------------+----------+---------+-------+------------------+------------------------------+--------------------------------------|
# | foreground | ~        |         |       | ~                | ~                            | ~                                    |
# |------------+----------+---------+-------+------------------+------------------------------+--------------------------------------|
# |         30 | \033[30m |         |       | black            | echo -e "\033[30m####\033[m" |                                      |
# |         31 | \033[31m |         |       | red              | echo -e "\033[31m####\033[m" |                                      |
# |         32 | \033[32m |         |       | green            | echo -e "\033[32m####\033[m" |                                      |
# |         33 | \033[33m |         |       | yellow           | echo -e "\033[33m####\033[m" |                                      |
# |         34 | \033[34m |         |       | blue             | echo -e "\033[34m####\033[m" |                                      |
# |         35 | \033[35m |         |       | purple           | echo -e "\033[35m####\033[m" | real name: magenta = reddish-purple  |
# |         36 | \033[36m |         |       | cyan             | echo -e "\033[36m####\033[m" |                                      |
# |         37 | \033[37m |         |       | white            | echo -e "\033[37m####\033[m" |                                      |
# |------------+----------+---------+-------+------------------+------------------------------+--------------------------------------|
# |         38 | 8/24     |                    This is for special use of 8-bit or 24-bit                                            |
# |------------+----------+---------+-------+------------------+------------------------------+--------------------------------------|
# | background | ~        |         |       | ~                | ~                            | ~                                    |
# |------------+----------+---------+-------+------------------+------------------------------+--------------------------------------|
# |         40 | \033[40m |         |       | black            | echo -e "\033[40m####\033[m" |                                      |
# |         41 | \033[41m |         |       | red              | echo -e "\033[41m####\033[m" |                                      |
# |         42 | \033[42m |         |       | green            | echo -e "\033[42m####\033[m" |                                      |
# |         43 | \033[43m |         |       | yellow           | echo -e "\033[43m####\033[m" |                                      |
# |         44 | \033[44m |         |       | blue             | echo -e "\033[44m####\033[m" |                                      |
# |         45 | \033[45m |         |       | purple           | echo -e "\033[45m####\033[m" | real name: magenta = reddish-purple  |
# |         46 | \033[46m |         |       | cyan             | echo -e "\033[46m####\033[m" |                                      |
# |         47 | \033[47m |         |       | white            | echo -e "\033[47m####\033[m" |                                      |
# |------------+----------+---------+-------+------------------+------------------------------+--------------------------------------|
# |         48 | 8/24     |                    This is for special use of 8-bit or 24-bit                                            |                                                                                       |
# |------------+----------+---------+-------+------------------+------------------------------+--------------------------------------|



#Without Color:
#PS1='\u@\H:\w/\n\u@\W/#'

#With Color:
PS1_TOP_USER='\e[0;31m\u\e[m'
PS1_TOP_HOST='\e[0;34m\H\e[m'
PS1_TOP_PATH='\e[0;33m\w/\e[m'
PS1_USER='\e[1;31m\u\e[m'
PS1_PATH='\e[1;33m\W\e[m'
PS1="$PS1_TOP_USER@$PS1_TOP_HOST:$PS1_TOP_PATH\n$PS1_USER:$PS1_PATH# "

# You may uncomment the following lines if you want `ls' to be colorized:
# export LS_OPTIONS='--color=auto'
# eval "$(dircolors)"
# alias ls='ls $LS_OPTIONS'
# alias ll='ls $LS_OPTIONS -l'
# alias l='ls $LS_OPTIONS -lA'
#
# Some more alias to avoid making mistakes:
# alias rm='rm -i'
# alias cp='cp -i'
# alias mv='mv -i'

alias ls='ls --color=auto --group-directories-first -lAs'
alias cdWd="cd /var/www/html"
alias cdScripts="cd /usr/local/bin"
alias cdApache="cd /etc/apache2"
alias cdPHP="cd /usr/local/etc/php"
alias cdLogsApache="cd /var/log/apache2"
alias cdLogsPHP="cd /var/log/php"
