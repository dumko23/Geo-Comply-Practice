<?php
namespace WithPattern;

class TransformToCSV
{
    public function openCSV($source)
    {
        return fopen($source, 'a+');

    }

    public function put($source, $pool, $field)
    {
        return fputcsv($source, [($pool->getItem($field)->getKey() . ':' . serialize($pool->getItem($field)->get()))]);
    }
}