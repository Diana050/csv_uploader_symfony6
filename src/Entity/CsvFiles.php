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

    #[ORM\Column(length: 255)]
    private ?string $CsvFileName = null;

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
}


