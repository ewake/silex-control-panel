<?php
$files = glob(dirname(__DIR__).'/127.0.0.1/*.{ini,json,xml,yaml,properties,php}', GLOB_BRACE);
return Zend\Config\Factory::fromFiles($files);