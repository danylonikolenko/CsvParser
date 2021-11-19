<?php


namespace App\Http\Controllers;


use App\Services\Mankind;

class PersonController
{
    private Mankind $mankind;

    public function __construct()
    {
        $mankind = Mankind::getInstance();
        $this->mankind = $mankind;
    }

    public function index()
    {
        $this->mankind->parse();

        echo "Array of DTO <pre>";
        print_r($this->mankind->getPersonList());

        echo "Associative Array <pre>";
        $array = $this->mankind->toArray();
        print_r($array);

        $days = $this->mankind->getPersonAgeInDays(current($array)['id']);
        echo "Person age in days : " . $days . " <pre>";

        echo "Count M : " . $this->mankind->getCountM() . " <pre>";
        echo "Count F : " . $this->mankind->getCountF() . " <pre>";

        echo "Percentage of Men : " . $this->mankind->getPercentageOfMen() . "% <pre>";

        echo "Get person By id <pre>";
        print_r($this->mankind->getPersonById(current($array)['id']));
    }


}
