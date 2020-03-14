<?php

return array_replace([
  // defaults
  'debug' => true,
  // /defaults
], 'localhost' === $_SERVER['SERVER_NAME'] ? [
  // localhost
  // /localhost
] : [
  // production
  // /production
]);
