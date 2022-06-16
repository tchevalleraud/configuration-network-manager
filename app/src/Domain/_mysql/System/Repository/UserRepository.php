<?php
    namespace App\Domain\_mysql\System\Repository;

    use App\Domain\_mysql\System\Entity\User;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    class UserRepository extends ServiceEntityRepository {

        public function __construct(ManagerRegistry $registry) {
            parent::__construct($registry, User::class);
        }

    }