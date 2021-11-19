<?php


namespace App\Services;


use App\Dto\PersonDto;
use DateTime;

class Mankind
{

    private static array $instances = [];

    /** @var PersonDto[] */
    private array $personList = [];

    private int $countM = 0;

    private int $countF = 0;


    protected function __construct()
    {
    }


    public function getPercentageOfMen(): float
    {
        return ($this->countM / ($this->countM + $this->countF)) * 100;

    }

    public function getPersonAgeInDays(int $id) : int
    {
        $personBirthDate = $this->personList[$id]->getBirthDate();

        return date_diff(new DateTime(), new DateTime($personBirthDate))->days;
    }


    public function getPersonById(int $id): array
    {
        return json_decode(json_encode($this->personList[$id]), true) ?? [];
    }

    public function getCountM(): int
    {
        return $this->countM;
    }


    public function getCountF(): int
    {
        return $this->countF;
    }


    public function getPersonList(): array
    {
        return $this->personList;
    }


    public function toArray(): array
    {
        return json_decode(json_encode($this->personList), true);
    }


    public function parse(): void
    {
        $handle = fopen(public_path() . "/csv1.csv", "r");

        while (($raw_string = fgets($handle)) !== false) {

            $row = str_getcsv($raw_string);
            if (trim($row[0]) == '') {
                continue;
            }
            $row = explode(";", $row[0]);

            $id = intval($row[0]) ?? 0;
            $name = trim($row[1]) ?? '';
            $surname = trim($row[2]) ?? '';
            $sex = strtoupper(trim($row[3]));
            $birth_date = trim($row[4]) ?? '';

            $person = new PersonDto($id, $name, $surname, $sex, $birth_date);

            $this->personList[$person->getId()] = $person;

            if ($sex == 'M') {
                $this->countM++;
            } elseif ($sex == "F") {
                $this->countF++;
            }
        }

        fclose($handle);
    }


    public static function getInstance(): Mankind
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }


    protected function __clone()
    {
    }


    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }


}
