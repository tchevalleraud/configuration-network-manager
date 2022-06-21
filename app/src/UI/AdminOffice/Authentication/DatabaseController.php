<?php
    namespace App\UI\AdminOffice\Authentication;

    use App\Domain\Mysql\System\Entity\User;
    use App\Domain\Mysql\System\Repository\UserRepository;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("authentication/database", name="authentication.database.")
     */
    class DatabaseController extends AbstractController {

        /**
         * @Route(".html", name="index", methods={"GET"})
         */
        public function index(UserRepository $userRepository){
            return $this->render("AdminOffice/Authentication/Database/index.html.twig", [
                'users'  => $userRepository->findBy([], ['username' => 'ASC'])
            ]);
        }

        /**
         * @Route("/{user}.html", name="view", methods={"GET"})
         */
        public function view(User $user){
            return $this->render("AdminOffice/Authentication/Database/view.html.twig", [
                'user'  => $user
            ]);
        }

        /**
         * @Route("/{user}/delete.html", name="delete", methods={"GET"})
         */
        public function delete(EntityManagerInterface $entityManager, Request $request, User $user){
            if($this->isCsrfTokenValid('delete-'. $user->getId(), $request->get('_token'))){
                if($user->getUsername() !== "root"){
                    $entityManager->remove($user);
                    $entityManager->flush();
                }
            }

            return $this->redirectToRoute('adminoffice.authentication.database.index');
        }

    }