<?php

namespace CacheTask;

class TransformToCSV
{
    public function openCSV($source)
    {
        return fopen($source, 'r+');

    }

    public function put($source, $field)
    {
        return fputcsv($source, $field);
    }
}