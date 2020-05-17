<?php

namespace Lemmon;

function is_color($input)
{
  return preg_match('/^#([0-9a-f]{1,2}){3,4}$/', $input);
}
