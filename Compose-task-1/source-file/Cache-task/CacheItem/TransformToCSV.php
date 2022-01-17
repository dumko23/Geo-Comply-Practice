<?php
namespace CacheTask;

class TransformToCSV
{
    public function openCSV($source)
    {
        return fopen($source, 'a+');

    }

    public function put($source, $field)
    {
        return fputcsv($source, $field);
    }
}