<?php
namespace CacheTask;

class TransformToCSV
{
    public function openCSV($source)
    {
        return fopen($source, 'a+');

    }

    public function put($source, $pool, $field)
    {
        return fputcsv($source, [($pool->getItem($field)->getKey() . ':' . $pool->getItem($field)->get())]);
    }
}