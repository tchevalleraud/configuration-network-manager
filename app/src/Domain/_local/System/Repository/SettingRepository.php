<?php
    namespace App\Domain\_local\System\Repository;

    use App\Domain\_local\System\Entity\Setting;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    class SettingRepository extends ServiceEntityRepository {

        public function __construct(ManagerRegistry $registry) {
            parent::__construct($registry, Setting::class);
        }

    }