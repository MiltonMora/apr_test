<?php

namespace App\User\Repository;

use App\User\Domain\Dto\UserDTO;
use App\User\Domain\Model\User;
use App\User\Domain\Ports\UserInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $user): void
    {
        try {
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();
        } catch (UniqueConstraintViolationException) {
            throw new \Exception('A ocurrido un error, intente de nuevo o hable con el adminstrador');
        }
    }

    public function listAll(): array
    {
        $data = $this->findBy(['isActive' => true]);
        if (empty($data)) {
            return [];
        }

        return $this->userArrayToUserDTO($data);
    }

    public function findById(string $id): ?User
    {
        return $this->find($id);
    }

    private function userArrayToUserDTO(array $users): array
    {
        $usersDTO = [];
        foreach ($users as $user) {
            $usersDTO[] = $this->UserToUserDTO($user);
        }

        return $usersDTO;
    }

    private function UserToUserDTO(User $user): UserDTO
    {
        return new UserDTO(
            $user->getId(),
            $user->getName(),
            $user->getSurnames(),
            $user->getEmail(),
            $user->getRoles(),
            $user->isActive()
        );
    }
}
