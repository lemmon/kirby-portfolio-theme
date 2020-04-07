<?php

return array_replace([
  // defaults
  // /defaults
], 'localhost' === $_SERVER['SERVER_NAME'] ? [
  // localhost
  'debug' => true,
  // /localhost
] : [
  // production
  // /production
]);
