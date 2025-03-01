<?php

namespace App\Events\Repository;

use App\Events\Domain\Model\Events;
use App\Events\Domain\Ports\EventsInterface;
use App\Spaces\Domain\Model\Spaces;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Events>
 *
 * @method Events|null find($id, $lockMode = null, $lockVersion = null)
 * @method Events|null findOneBy(array $criteria, array $orderBy = null)
 * @method Events[]    findAll()
 * @method Events[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventsRepository extends ServiceEntityRepository implements EventsInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Events::class);
    }

    public function save(Events $events): void
    {
        try {
            $this->getEntityManager()->persist($events);
            $this->getEntityManager()->flush();
        } catch (UniqueConstraintViolationException) {
            throw new \Exception('A ocurrido un error, intente de nuevo o hable con el adminstrador');
        }
    }

    public function listAll(): array
    {
        $data = $this->findBy(['state' => true]);
        if (empty($data)) {
            return [];
        }

        return $data;
    }

    public function findById(string $id): ?Events
    {
        return $this->find($id);
    }

    public function findBySpaces(Spaces $space): array
    {
        return $this->findBy(['space' => $space, 'state' => true]);
    }

    public function findByEventIdBetweenData(\DateTime $start, \DateTime $end): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.state = true')
            ->andWhere('e.start BETWEEN :start AND :end')
            ->orWhere('e.end BETWEEN :start AND :end')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getQuery()
            ->getResult();
    }
}
