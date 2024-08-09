<?php
namespace App\ValueObject;

use InvalidArgumentException;

class Title
{
  private string $value;

  public function __construct(string $value)
  {
    if (empty($value)) {
      throw new InvalidArgumentException('タイトルを入力してください。');
    }

    if (strlen($value) > 255) {
      throw new InvalidArgumentException('タイトルは255字以内で記入してください');
    }

    $this->value = $value;
  }

  public function getValue(): string
  {
    return $this->value;
  }
}