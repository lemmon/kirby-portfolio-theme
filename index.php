<?php

define('KIRBY_HELPER_DUMP', false);

require 'kirby/bootstrap.php';

echo (new Kirby)->render();
