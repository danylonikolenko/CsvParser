<?php


namespace App\Dto;


class PersonDto implements \JsonSerializable
{

    private int $id;

    private string $name;

    private string $surname;

    private string $sex;

    private string $birth_date;


    public function __construct(int $id, string $name, string $surname, string $sex, string $birth_date)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->sex = $sex;
        $this->birth_date = $birth_date;
    }


    public function getId(): int
    {
        return $this->id;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function getSurname(): string
    {
        return $this->surname;
    }


    public function getSex(): string
    {
        return $this->sex;
    }


    public function getBirthDate() : string
    {
        return $this->birth_date;
    }


    public function jsonSerialize()
    {
       return get_object_vars($this);
    }
}
