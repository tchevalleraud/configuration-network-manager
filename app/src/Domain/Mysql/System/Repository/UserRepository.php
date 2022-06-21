<?php
    namespace App\Domain\Mysql\System\Repository;

    use App\Domain\Mysql\System\Entity\User;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    class UserRepository extends ServiceEntityRepository {

        public function __construct(ManagerRegistry $registry) {
            parent::__construct($registry, User::class);
        }

    }