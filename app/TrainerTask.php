<?php

namespace App;

use function array_unique;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Array_;
use const PREG_SET_ORDER;
use function preg_split;
use function str_split;

class TrainerTask extends Model
{
  protected $fillable = [
    'name',
    'speed',
    'category_id',
    'operation',
    'sort',
    'count_examples',
    'minimal_number',
    'maximal_number',
    'examples',
    'exercise_id'
  ];

  protected $default = [
    'speed' => 0.3,
  ];

  protected $appends = ['numbers', 'generatedOperations'];

  /**
   * Генерирует числа в заданном диапазоне
   *
   * @return array of generated numbers
   */

  public function getNumbersAttribute(): array
  {
    $numbers = [];
    if ($this->attributes['examples']) {
      preg_match_all('/\d+/', $this->attributes['examples'], $numbers);
      return $numbers[0];
    }
    for ($i = 0; $i < $this->count_examples; $i += 1) {
      $numbers[$i] = rand($this->minimal_number, $this->maximal_number);
    }

    return $numbers;
  }

  public function getOperationAttribute($operation): array
  {
    return preg_split('/,/', $operation);
  }

  public function setOperationAttribute(array $operations)
  {
    $this->attributes['operation'] = implode(',', $operations);
  }

  public function getGeneratedOperationsAttribute()
  {
    $operations = [];
    if ($this->attributes['examples']) {
      preg_match_all('/\D/', $this->attributes['examples'], $operations);
      return collect($operations)->flatten()->toArray();
    }
    foreach ($operations as $i => $operation) {
      $operations[$i] = $this->getOperationChar($operation);
    }
    for ($i = count($operations); $i < $this->count_examples - 1; $i++) {
      $operations[$i] = $this->operation[rand(0, count($this->operation) - 1)];
    }

    return $operations;
  }

  public function exercise()
  {
    return $this->belongsTo(Exercise::class, 'id', 'exercise_id');
  }
}
