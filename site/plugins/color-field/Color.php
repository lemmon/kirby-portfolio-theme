<?php

namespace Lemmon;

class Color
{
  /* PHP 7.3 compatibility */
  private /*int*/ $_r;
  private /*int*/ $_g;
  private /*int*/ $_b;
  private /*?float*/ $_a;

  function __construct($input)
  {
    $res = preg_match('/^#([0-9a-f]{1,2})([0-9a-f]{1,2})([0-9a-f]{1,2})([0-9a-f]{1,2})?$/', $input, $m);
    for ($i=1; $i <= 4; $i++) {
      if (empty($m[$i]) or strlen($m[$i]) != 1) continue;
      $m[$i] = $m[$i] . $m[$i];
    }
    $this->_r = hexdec($m[1]);
    $this->_g = hexdec($m[2]);
    $this->_b = hexdec($m[3]);
    $this->_a = !empty($m[4]) ? (hexdec($m[4]) / 255) : null;
  }

  function __toString(): string
  {
    return $this->getValue();
  }

  function getValue(): string
  {
    return $this->_a
      ? sprintf('rgba(%d, %d, %d, %01.2F)', $this->_r, $this->_g, $this->_b, $this->_a)
      : sprintf('#%02s%02s%02s', dechex($this->_r), dechex($this->_g), dechex($this->_b))
      ;
  }

  function setAlpha(float $value): self
  {
    $this->_a = $value / 100;
    return $this;
  }
}
