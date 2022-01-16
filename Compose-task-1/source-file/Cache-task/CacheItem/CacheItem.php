<?php
require_once 'CacheItemInterface.php';

class CacheItem implements CacheItemInterface
{
    private string $key;
    private mixed $value = '';

    public function __construct(string $key)
    {
        $this->key = $key;
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
        return $this;
    }
}