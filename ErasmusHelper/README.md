sudo npm install -g sass -> Install watcher.xml
Upgrade php8.0 and enable it on apache
php composer.phar update to setup composer dependencies.

import firebase_auth.json

TODO when doing Auth :
- In Controller add REQUIRE_LOGIN var
- In Controller Construct ask if require_login && logged -> redirect, else -> 403

To swap layout :
Change in Controller the $layout value to desired.





php -v   
sudo apt update   
sudo apt install php8.0   
sudo apt install lsb-release ca-certificates apt-transport-https software-properties-common -y   
sudo add-apt-repository ppa:ondrej/php  
sudo apt install php8.0   
php -v  
cd /etc/php/8.0/  
sudo nano /etc/apache2/apache2.conf  
sudo a2dismod php7.4  
sudo a2enmod php8.0  
sudo systemctl restart apache2.service  
systemctl status apache2.service  
cd apache2/  
sudo nano php.ini  
sudo systemctl restart apache2.service  
sudo apt-get install php8.0-mbstring  
sudo apt-get install php8.0-mysqli  
sudo apt-get install php8.0-pdo  
sudo apt-get install php8.0-intl  
sudo apt-get install php8.0-smp  
sudo apt-get install php8.0-soap  
sudo systemctl restart apache2.service  
sudo a2enmod rewrite  
sudo chmod -R 777 /var/www/ErasmusHelper/data/logs/  
sudo chmod -R 777 /var/www/ErasmusHelper/data/  
npm -v  
sudo npm install -g sass  
sass -v  
