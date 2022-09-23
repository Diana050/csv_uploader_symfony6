<?php

namespace App\MessageHandler;

use App\Entity\CsvFiles;
use App\Message\CsvAddFile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CsvAddFileHandler implements MessageHandlerInterface
{
    private EntityManagerInterface $db;

    public function __construct(EntityManagerInterface $db)
    {
        $this->db = $db;
    }

    public function __invoke(CsvAddFile $message)
    {
        $x=(new CsvFiles())
            ->setFirstName($message->getFirstName())
            ->setLastName($message->getLastName())
            ->setAge($message->getAge());

        $this->db->persist($x);
        $this->db->flush();
    }
}
