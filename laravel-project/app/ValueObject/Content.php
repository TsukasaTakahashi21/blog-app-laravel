<?php
namespace App\ValueObject;

use InvalidArgumentException;

class Content
{
  private string $value;

  public function __construct(string $value)
  {
    if (empty($value)) {
      throw new InvalidArgumentException('内容を入力してください。');
    }
    $this->value = $value;
  }

  public function getValue(): string
  {
    return $this->value;
  }
}