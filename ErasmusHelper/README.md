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

# Important:

Edit the SMTP.php in PHPMailer with this:
```
protected function edebug($str, $level = 0) {
    if ($level > $this->do_debug) {
    return;
    }
    
    //Is this a PSR-3 logger?
    
    if ($this->Debugoutput instanceof \Psr\Log\LoggerInterface) {
        $this->Debugoutput->debug($str);
        return;
        }
        //Avoid clash with built-in function names
        if (is_callable($this->Debugoutput) && !in_array($this->Debugoutput, ['error_log', 'html', 'echo'])) {
            call_user_func($this->Debugoutput, $str, $level);

            return;
        }
        switch ($this->Debugoutput) {
            case 'error_log':
                //Don't output, just log
                error_log($str);
                break;
            case 'html':
                //Cleans up output a bit for a better looking, HTML-safe output
                /*echo gmdate('Y-m-d H:i:s'), ' ', htmlentities(
                    preg_replace('/[\r\n]+/', '', $str),
                    ENT_QUOTES,
                    'UTF-8'
                ), "<br>\n";*/
                break;
            case 'echo':
                break;
            default:
                //Normalize line breaks
                $str = preg_replace('/\r\n|\r/m', "\n", $str);
                echo gmdate('Y-m-d H:i:s'),
                "\t",
                    //Trim trailing space
                trim(
                    //Indent for readability, except for trailing break
                    str_replace(
                        "\n",
                        "\n                   \t                  ",
                        trim($str)
                    )
                ),
                "\n";
        }
    }
```
or it will break the excel import