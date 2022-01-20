<?php

namespace WithPattern;

use http\Exception\InvalidArgumentException;
use Traversable;

class ChooseStrategy
{
    private CacheItemPoolInterface $strategy;

    /**
     * @param string $strategy - can be 'mysql', 'session' or 'items'.
     * Otherwise, throws an InvalidArgumentException.
     */
    public function __construct(string $strategy)
    {
        $this->strategy = StaticFactory::createPool($strategy);
        echo "Creating with " . $this->strategy::getClassName() . " strategy. <br>" ;
    }

    /**
     * @param string $strategy - can be 'mysql', 'session' or 'items'.
     * @return $this - to make this instance chainable.
     */
    public function setStrategy(string $strategy): static
    {
        $this->strategy = StaticFactory::createPool($strategy);
        echo "You now using " . $this->strategy::getClassName() . " strategy. <br>";
        return $this;
    }

    /**
     * @param string $key - key of the searched item.
     * @return CacheItemInterface to be able to use item's methods.
     */
    public function printGetItem(string $key): CacheItemInterface
    {
        echo "Getting item using " . $this->strategy::getClassName() . " strategy. Result is:";
        echo '<pre>';
        print_r($this->strategy->getItem($key));
        echo '</pre>';
        return $this->strategy->getItem($key);
    }

    /**
     * @param array $keys - array of searched items keys.
     * @return Traversable|array - to interact with items in array.
     */
    public function printGetItems(array $keys): Traversable|array
    {
        echo "Getting items using " . $this->strategy::getClassName() . " strategy. Result is:";
        echo '<pre>';
        print_r($this->strategy->getItems($keys));
        echo '</pre>';
        return $this->strategy->getItems($keys);
    }

    /**
     * @param string $key - key of the searched item.
     * @return $this - as method 'HasItem' return bool,
     * returning $this making able to continue method chaining if needed.
     */
    public function printHasItem(string $key): static
    {
        echo "Checking item in pool using " . $this->strategy::getClassName() . " strategy. Result is:";
        echo '<pre>';
        var_dump($this->strategy->hasItem($key));
        echo '</pre>';
        return $this;
    }

    /**
     * @return $this - as method 'Clear' returns bool,
     * returning $this making able to continue method chaining if needed.
     */
    public function printClear(): static
    {
        echo "Clearing cache using " . $this->strategy::getClassName() . " strategy. Result is:";
        echo '<pre>';
        var_dump($this->strategy->clear());
        echo '</pre>';
        return $this;
    }

    /**
     * @param string $key - key of the searched item.
     * @return $this - as method 'DeleteItem' returns bool,
     * returning $this making able to continue method chaining if needed.
     */
    public function printDeleteItem(string $key): static
    {
        echo "Deleting item using " . $this->strategy::getClassName() . " strategy. Result is:";
        echo '<pre>';
        var_dump($this->strategy->deleteItem($key));
        echo '</pre>';
        return $this;
    }

    /**
     * @param array $keys - array of searched items keys.
     * @return $this - as method 'DeleteItems' returns bool,
     * returning $this making able to continue method chaining if needed.
     */
    public function printDeleteItems(array $keys): static
    {
        echo "Deleting items using " . $this->strategy::getClassName() . " strategy. Result is:";
        echo '<pre>';
        var_dump($this->strategy->deleteItems($keys));
        echo '</pre>';
        return $this;
    }

    /**
     * @param CacheItemInterface $item - item object from 'new CacheItemSQL|CacheItemSession|CacheItem($key, $value)'.
     * @return $this - as method 'Save' returns bool,
     * returning $this making able to continue method chaining if needed.
     */
    public function printSave(CacheItemInterface $item): static
    {
        echo "Caching using " . $this->strategy::getClassName() . " strategy. Result is:";
        echo '<pre>';
        var_dump($this->strategy->save($item));
        echo '</pre>';
        return $this;
    }

    /**
     * @param CacheItemInterface $item - item object from 'new CacheItemSQL|CacheItemSession|CacheItem($key, $value)'.
     * @return $this - as method 'SaveDeffer' returns bool,
     * returning $this making able to continue method chaining if needed.
     */
    public function printSaveDeferred(CacheItemInterface $item): static
    {
        echo "Saving deffer item using " . $this->strategy::getClassName() . " strategy. Result is:";
        echo '<pre>';
        var_dump($this->strategy->saveDeferred($item));
        echo '</pre>';
        return $this;
    }

    /**
     * @return $this - as method 'Commit' returns bool,
     * returning $this making able to continue method chaining if needed.
     */
    public function printCommit(): static
    {
        echo "Committing deferred items to pool using " . $this->strategy::getClassName() . " strategy. Result is:";
        echo '<pre>';
        var_dump($this->strategy->commit());
        echo '</pre>';
        return $this;
    }

    /**
     * @return mixed - returns pool to interact.
     */
    public function printGetPoolInfo(): mixed
    {
        echo "Getting pool info using " . $this->strategy::getClassName() . " strategy. Result is:";
        echo '<pre>';
        var_dump($this->strategy::info());
        echo '</pre>';
        return $this->strategy::info();
    }

}