<?php 
namespace App\ValueObject;

use InvalidArgumentException;

class CommenterName
{
  private string $value;

  public function __construct(string $value)
  {
    if (empty($value)) {
      throw new InvalidArgumentException('コメント名を入力してください。');
    }

    if (strlen($value) > 20) {
      throw new InvalidArgumentException('コメント名は20文字までです。');
    }

    $this->value = $value;
  }

  public function getValue(): string
  {
    return $this->value;
  }
}