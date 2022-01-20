<?php

namespace WithPattern;

use http\Exception\InvalidArgumentException;
use Traversable;

class ChooseStrategy
{
    private CacheItemPoolInterface $strategy;

    public function __construct(string $strategy)
    {
        $this->strategy = StaticFactory::createPool($strategy);
        echo "Creating with " . $this->strategy::getClassName() . " strategy. <br>" ;
    }

    public function setStrategy(string $strategy): static
    {
        $this->strategy = StaticFactory::createPool($strategy);
        echo "You now using " . $this->strategy::getClassName() . " strategy. <br>";
        return $this;
    }

    public function printGetItem(string $key): CacheItemInterface
    {
        echo "Getting item using " . $this->strategy::getClassName() . " strategy. Result is:";
        echo '<pre>';
        print_r($this->strategy->getItem($key));
        echo '</pre>';
        return $this->strategy->getItem($key);
    }

    public function printGetItems(array $keys): Traversable|array
    {
        echo "Getting items using " . $this->strategy::getClassName() . " strategy. Result is:";
        echo '<pre>';
        print_r($this->strategy->getItems($keys));
        echo '</pre>';
        return $this->strategy->getItems($keys);
    }

    public function printHasItem(string $key): static
    {
        echo "Checking item in pool using " . $this->strategy::getClassName() . " strategy. Result is:";
        echo '<pre>';
        var_dump($this->strategy->hasItem($key));
        echo '</pre>';
        return $this;
    }

    public function printClear(): static
    {
        echo "Clearing cache using " . $this->strategy::getClassName() . " strategy. Result is:";
        echo '<pre>';
        var_dump($this->strategy->clear());
        echo '</pre>';
        return $this;
    }

    public function printDeleteItem(string $key): static
    {
        echo "Deleting item using " . $this->strategy::getClassName() . " strategy. Result is:";
        echo '<pre>';
        var_dump($this->strategy->deleteItem($key));
        echo '</pre>';
        return $this;
    }

    public function printDeleteItems(array $keys): static
    {
        echo "Deleting items using " . $this->strategy::getClassName() . " strategy. Result is:";
        echo '<pre>';
        var_dump($this->strategy->deleteItems($keys));
        echo '</pre>';
        return $this;
    }

    public function printSave(CacheItemInterface $item): static
    {
        echo "Caching using " . $this->strategy::getClassName() . " strategy. Result is:";
        echo '<pre>';
        var_dump($this->strategy->save($item));
        echo '</pre>';
        return $this;
    }

    public function printSaveDeferred(CacheItemInterface $item): static
    {
        echo "Saving deffer item using " . $this->strategy::getClassName() . " strategy. Result is:";
        echo '<pre>';
        var_dump($this->strategy->saveDeferred($item));
        echo '</pre>';
        return $this;
    }

    public function printCommit(): static
    {
        echo "Committing deferred items to pool using " . $this->strategy::getClassName() . " strategy. Result is:";
        echo '<pre>';
        var_dump($this->strategy->commit());
        echo '</pre>';
        return $this;
    }

    public function printGetPoolInfo(): static
    {
        echo "Getting pool info using " . $this->strategy::getClassName() . " strategy. Result is:";
        echo '<pre>';
        var_dump($this->strategy::info());
        echo '</pre>';
        return $this;
    }

}