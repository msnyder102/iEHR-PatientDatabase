<?php
require_once '../../../Restler/vendor/restler.php';
require_once 'api.php';
use Luracast\Restler\Restler;
spl_autoload_register('spl_autoload');
$r = new Restler();
$r->setSupportedFormats('JsonFormat');
$r->addAPIClass('API');
$r->handle();
?>