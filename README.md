Economy plugin with API

## Code Samples
```php
use iAmROOT\Economy\API;

API::addMoney($player, 10);
API::reduceMoney($player, 10);
API::getUserMoney($player, function(Player $player, int $money){
    $player->sendMessage('Your money: ' . $money);
});
```
Depends on libasynql
Work in progress...