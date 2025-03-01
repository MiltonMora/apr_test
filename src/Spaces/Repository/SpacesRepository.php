<?php

namespace App\Spaces\Repository;

use App\Spaces\Domain\Model\Spaces;
use App\Spaces\Domain\Ports\SpacesInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Spaces>
 *
 * @method Spaces|null find($id, $lockMode = null, $lockVersion = null)
 * @method Spaces|null findOneBy(array $criteria, array $orderBy = null)
 * @method Spaces[]    findAll()
 * @method Spaces[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpacesRepository extends ServiceEntityRepository implements SpacesInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Spaces::class);
    }

    public function save(Spaces $spaces): void
    {
        try {
            $this->getEntityManager()->persist($spaces);
            $this->getEntityManager()->flush();
        } catch (UniqueConstraintViolationException) {
            throw new \Exception('A ocurrido un error, intente de nuevo o hable con el adminstrador');
        }
    }

    public function listAll(): array
    {
        $data = $this->findAll();
        if (empty($data)) {
            return [];
        }

        return $data;
    }

    public function findById(string $id): ?Spaces
    {
        return $this->find($id);
    }
}
