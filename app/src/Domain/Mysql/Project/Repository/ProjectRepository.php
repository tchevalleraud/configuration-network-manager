<?php
    namespace App\Domain\Mysql\Project\Repository;

    use App\Domain\Mysql\Project\Entity\Project;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    class ProjectRepository extends ServiceEntityRepository {

        public function __construct(ManagerRegistry $registry) {
            parent::__construct($registry, Project::class);
        }

    }