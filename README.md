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
$cli->addCommandWO('serve', function (TCommand $command) {
    var_dump($command);
}, false, "This command rise up the WEB server")
    ->addOption('port', true, "take port", 'p')
    ->addOption('websocket', false, "Enable WebSocket Server", 'wss');

// make:profile NewProfile --copy OldProfile
$cli->addCommandWO('make:profile', function (TCommand $command) {

    //code....

    // take Option or Option Value
    $optionCopy = $command->getOption('--copy');
    if ($optionCopy->isUsed()) {
        $profileName = $optionCopy->getValue();
        // code....
    }
    var_dump($command);
}, true, "This command generates a new profile for the servlet")
    ->addOption('copy', true, "Use this option if you need copy already generated profile", 'c')
    ->addOption('version', true, 'Use this option if yoy need generate profile for a spec. version', 'v');


$cli->addCommandWO('up:servlet', fn ($command) => var_dump($command->getValue()), true, "up [target] servlet");
$cli->addCommandWO('up:servlets', fn ($command) => var_dump($command->getValue()), false, 'up all reolved servlets on this launchServer');




//redefine HEPLERS command for custom handling
$cli->addCommandWO('help', fn ($command) => var_dump($command->getValue()), true, "custom helper function");
$cli->addCommandWO('?', fn ($command) => var_dump($command->getValue()), true, "custom helper function");


$cli->handle();





// And now we will color the output to the terminal...

$formattingMain = TFormatting::create(['magenta', '_white_bg', 'bold', 'underline']);
$formattingItalic = TFormatting::create('italic');

echo (TPrinter::startWith($formattingMain))
	->concat('Magenta text as MAIN')
	->concatWith("{$formattingItalic->get()} cyan color as included", TFormatting::create('cyan'))
    ->concat('Magenta return is the main one')
    ->concatWith('text with YELLOW background', TFormatting::create('_yellow_bg'))
    ->concat('and again return magenta as main')
	->print();
```