<?php
    namespace App\UI\BackOffice;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

    /**
     * @Route("", name="security.")
     */
    class SecurityController extends AbstractController {

        /**
         * @Route("login.html", name="login")
         */
        public function login(AuthenticationUtils $authenticationUtils){
            $error = $authenticationUtils->getLastAuthenticationError();
            $lastUsername = $authenticationUtils->getLastUsername();

            return $this->render("BackOffice/Security/login.html.twig", [
                'error'         => $error,
                'last_username' => $lastUsername
            ]);
        }

        /**
         * @Route("logout.html", name="logout")
         */
        public function logout(){
        }

    }