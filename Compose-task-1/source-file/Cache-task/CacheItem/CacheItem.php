<?php
namespace CacheTask;

use WithPattern\CacheItemInterface;

class CacheItem implements CacheItemInterface
{
    private string $key;
    private mixed $value;

    public function __construct(string $key, mixed $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function get(): mixed
    {
        if($this->value) {
            return $this->value;
        } else {
            return false;
        }
    }

    public function isHit(): bool
    {
        if($this->value){
            return true;
        }else {
            return false;
        }
    }

    public function set(mixed $value): static
    {
        $this->value = $value;
        $_COOKIE[$this->key] = $value;
        return $this;
    }
}