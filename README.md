# JPHP Command Line Interface Handler

Minecraft Launcher module for parse and run classic version.json from Mojang LAUNCHERMETA 

## How it work ??? ✨Magic ✨

```php
<?php

use kosogroup\cli\dto\TCommand;
use kosogroup\cli\TCommandLineInterface;
use kosogroup\cli\TFormatting;
use kosogroup\cli\TPrinter;

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





// And now we will color the output to the terminal...


$formattingMagenta = TFormatting::create('magenta');
$formattingItalic = TFormatting::create('italic');

var_dump((TPrinter::startWith($formattingMagenta))
	->concat('Magenta text as MAIN')
	->concatWith("{$formattingItalic->get()} cyan color as included", TFormatting::create('cyan'))
    ->concat('Magenta return is the main one')
    ->concatWith('text with YELLOW background', TFormatting::create('_yellow_bg'))
    ->concat('and again return magenta as main')
	->print());
```