<?php 
namespace App\ValueObject;

use InvalidArgumentException;

class Comments
{
  private string $value;

  public function __construct(string $value)
  {
    if (empty($value)) {
      throw new InvalidArgumentException('コメントを入力してください。');
    }

    $this->value = $value;
  }

  public function getValue(): string
  {
    return $this->value;
  }
}