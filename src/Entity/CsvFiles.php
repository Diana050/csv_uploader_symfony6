<?php

namespace App\Entity;

use App\Repository\CsvFilesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CsvFilesRepository::class)]
class CsvFiles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255,nullable: true)]
    private ?string $CsvFileName = null;

    #[ORM\Column(nullable: true)]
    private ?int $id_csv = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $first_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $last_name = null;

    #[ORM\Column(nullable: true)]
    private ?int $age = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCsvFileName(): ?string
    {
        return $this->CsvFileName;
    }

    public function setCsvFileName(string $CsvFileName): self
    {
        $this->CsvFileName = $CsvFileName;

        return $this;
    }

    public function getIdCsv(): ?int
    {
        return $this->id_csv;
    }

    public function setIdCsv(?int $id_csv): self
    {
        $this->id_csv = $id_csv;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(?string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(?string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }
}


