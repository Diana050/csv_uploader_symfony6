<?php

namespace App\Message;

final class CsvAddFile
{
    /*
     * Add whatever properties and methods you need
     * to hold the data for this message class.
     */

     private string $first_name;
     private string $last_name;
     private int $age;

     public function __construct(string $first_name,string $last_name,int $age)
     {
         $this->first_name = $first_name;
         $this->last_name = $last_name;
         $this->age = $age;
     }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function getAge(): int
    {
        return $this->age;
    }
}
