
@@ -0,0 +1,46 @@
# JPHP Command Line Interface Handler

Minecraft Launcher module for parse and run classic version.json from Mojang LAUNCHERMETA 

## How it work ??? ✨Magic ✨

```php
<?php

use kosogroup\cli\dto\TCommand;
use kosogroup\cli\TColor;
use kosogroup\cli\TCommandLineInterface;

$cli = new TCommandLineInterface();


// serve --port 1488 --wss
$cli->addCommandWO('serve', function (TCommand $command)
{
    var_dump($command);
}, false, "This command rise up the WEB server")
    ->addOption('port', true, null, 'p')
    ->addOption('websocket', false, null, 'wss');

// make:profile NewProfile --copy OldProfile
$cli->addCommandWO('make:profile', function (TCommand $command) {
    
    //code....

    // take Option or Option Value
    $optionCopy = $command->getOption('--copy');
    if($optionCopy->isUsed())
    {
        $profileName = $optionCopy->getValue();
        // code....
    }
    var_dump($command);
}, true)
    ->addOption('copy', true, null, 'c')
    ->addOption('version', true, null, 'v');

$cli->handle();
```