# Setup and Configuration

After importing the project folder:
- sudo npm install -g sass -> Set up your watcher.xml
- composer update
- npm install
- copy the conf.inc.example.php into "conf.inc.php" and set the correct email address and password
- import the json authentication file from Firebase for the Firebase SDK (name it "firebase_adminSDK.json")   
If you have any question, feel free to ask eliott.tardieu@etu.univ-tours.fr.

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
or it will break the Excel import feature.