zeusminer_web_controller
=======================

This is the web controller for zeusminer base on raspberry pi. You can use
this tool to control your miner in a very easy way!

## set up your raspberry

### step 1: Set up raspberry
Download the Raspberry offcial image in http://www.raspberrypi.org/downloads/
You can choice your favourite image. If you don't know which one to choice,
the RASPBIAN is recommand.

Then Install it on you SD card by following the offcial document:
http://www.raspberrypi.org/help/noobs-setup/

### step 2: Set up web server
If you use RASPBIAN, you can run the following command to set up web server.

Intall lighttpd
```
sudo apt-get update
sudo apt-get -y install lighttpd
```

Install php
```
sudo apt-get -y install php5-common php5-cgi php5
sudo lighty-enable-mod fastcgi-php
```

Restart lighttpd
```
sudo service lighttpd restart
```

Tweak Permissions
```
sudo chown www-data:www-data /var/www
```

### step 3: Set up zeusminer web controller
Put the zeusminer_web_controller on the directory /var/www

Then edit the /etc/lighttpd/lighttpd.conf change the server.document-root 
from /var/www to the directory of zeusminer_web_controller so you can
visit the controller directly by type the ip address.

The cgminer need root privilege to run. So we need add the www-data user
to the sudo users. By run following command:
```
sudo chmod +w /etc/sudoers
sudo echo "www-data ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers
sudo chmod -w /etc/sudoers
```

Then, run command
```
crontab -e
```
add the following line on the end:
```
*/1 * * * * /var/www/zeusminer_web_controller/cgminer/shell/cgminer_cron_check.sh >/dev/null 2>&1
```
This script check the cgminer process every minute, If one of the cgminer process is down,
it will run it again.

### step 4: test
Open you browser and type the ip of raspberry pi. You will see the welcome page, and it is
really easy to setup, enjoy!

## Zeusminer offcial image
You can find the The latest version of zeusminer web controller image of raspberry pi on
our user manual: http://zeusminer.com/user-manual-ver-1-0/


BTC Address: 17MCWaD1se8vVDdna6PWrtMxjoH41KcQzd

LTC Address: LY9nTc7jKA99vT2aubssov9yG6JX9N48Qk

