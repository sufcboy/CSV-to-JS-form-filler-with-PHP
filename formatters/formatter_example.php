<?php

class formatter_example
{
    public function format($original)
    {
        // Only after epoch dates
        $dateObj = \DateTime::createFromFormat('Y-m-d', $original);

        if ($dateObj instanceof \DateTime) {
            return $dateObj->format('jS M Y');
        }

        return '';
    }
}