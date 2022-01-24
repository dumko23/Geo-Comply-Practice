<?php

namespace WithPattern;

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
    public function GetItem(string $key): CacheItemInterface
    {
        echo "Getting item using " . $this->strategy::getClassName() . " strategy. Result is:";
        $this->prettyPrint($this->strategy->getItem($key));
        return $this->strategy->getItem($key);
    }

    /**
     * @param array $keys - array of searched items keys.
     * @return Traversable|array - to interact with items in array.
     */
    public function GetItems(array $keys): Traversable|array
    {
        echo "Getting items using " . $this->strategy::getClassName() . " strategy. Result is:";
        $this->prettyPrint($this->strategy->getItems($keys));
        return $this->strategy->getItems($keys);
    }

    /**
     * @param string $key - key of the searched item.
     * @return $this - as method 'HasItem' return bool,
     * returning $this making able to continue method chaining if needed.
     */
    public function HasItem(string $key): static
    {
        echo "Checking item in pool using " . $this->strategy::getClassName() . " strategy. Result is:";
        $this->prettyVarDump($this->strategy->hasItem($key));
        return $this;
    }

    /**
     * @return $this - as method 'Clear' returns bool,
     * returning $this making able to continue method chaining if needed.
     */
    public function Clear(): static
    {
        echo "Clearing cache using " . $this->strategy::getClassName() . " strategy. Result is:";
        $this->prettyVarDump($this->strategy->clear());
        return $this;
    }

    /**
     * @param string $key - key of the searched item.
     * @return $this - as method 'DeleteItem' returns bool,
     * returning $this making able to continue method chaining if needed.
     */
    public function DeleteItem(string $key): static
    {
        echo "Deleting item using " . $this->strategy::getClassName() . " strategy. Result is:" . PHP_EOL;
        $this->prettyVarDump($this->strategy->deleteItem($key));
        return $this;
    }

    /**
     * @param array $keys - array of searched items keys.
     * @return $this - as method 'DeleteItems' returns bool,
     * returning $this making able to continue method chaining if needed.
     */
    public function DeleteItems(array $keys): static
    {
        echo "Deleting items using " . $this->strategy::getClassName() . " strategy. Result is:" . PHP_EOL;
        $this->prettyVarDump($this->strategy->deleteItems($keys));
        return $this;
    }

    /**
     * @param CacheItemInterface $item - item object from 'new CacheItemSQL|CacheItemSession|CacheItem($key, $value)'.
     * @return $this - as method 'Save' returns bool,
     * returning $this making able to continue method chaining if needed.
     */
    public function Save(CacheItemInterface $item): static
    {
        echo "Caching using " . $this->strategy::getClassName() . " strategy. Result is:" . PHP_EOL;
        $this->prettyVarDump($this->strategy->save($item));
        return $this;
    }

    /**
     * @param CacheItemInterface $item - item object from 'new CacheItemSQL|CacheItemSession|CacheItem($key, $value)'.
     * @return $this - as method 'SaveDeffer' returns bool,
     * returning $this making able to continue method chaining if needed.
     */
    public function SaveDeferred(CacheItemInterface $item): static
    {
        echo "Saving deffer item using " . $this->strategy::getClassName() . " strategy. Result is:";
        $this->prettyVarDump($this->strategy->saveDeferred($item));
        return $this;
    }

    /**
     * @return $this - as method 'Commit' returns bool,
     * returning $this making able to continue method chaining if needed.
     */
    public function Commit(): static
    {
        echo "Committing deferred items to pool using " . $this->strategy::getClassName() . " strategy. Result is:";
        $this->prettyVarDump($this->strategy->commit());
        return $this;
    }

    /**
     * @return mixed - returns pool to interact.
     */
    public function GetPoolInfo(): mixed
    {
        echo "Getting pool info using " . $this->strategy::getClassName() . " strategy. Result is:";
        $this->prettyVarDump($this->strategy::info());
        return $this->strategy::info();
    }

    private function prettyPrint($data){
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    private function prettyVarDump($data){
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
}