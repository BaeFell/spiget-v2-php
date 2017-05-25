# spiget-v2-php
PHP classes for Spiget V2 API

#### SpigetCore

SpigetCore is the class that does the actual exection, fetching and processing of data to and from Spiget.org. This class can be used by developers directly or indirectly used when using SpigetMapped (currently WIP).

Example:
```
<?php
require_once('SpigetCore.php');
$SpigetCore = new SpigetCore();
$SpigetCore->request("search/resources");
$SpigetCore->set("query", "Umbaska");
$SpigetCore->execute();
echo $SpigetCore->getLast()['0']['name'];
```
