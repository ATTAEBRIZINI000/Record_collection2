<?php

namespace App\Manager;

use App\Entity\Records;
use App\Repository\RecordsRepository;
use Doctrine\ORM\EntityManagerInterface;

class RecordsManager
{
    private EntityManagerInterface $entityManager;
    private RecordsRepository $recordsRepository;

    public function __construct(EntityManagerInterface $entityManager, RecordsRepository $recordsRepository)
    {
        $this->entityManager = $entityManager;
        $this->recordsRepository = $recordsRepository;
    }

    public function update(Records $record): void
    {
        $this->entityManager->flush();
    }

    public function findRecordById(int $id): ?Records
    {
        return $this->recordsRepository->find($id);
    }

    public function findAllRecords(): array
    {
        return $this->recordsRepository->findAll();
    }

    public function removeRecord(Records $record): void
    {
        $this->entityManager->remove($record);
        $this->entityManager->flush();
    }
   

    public function save(Records $record): void
    {
        $this->entityManager->persist($record);
        $this->entityManager->flush();
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}
