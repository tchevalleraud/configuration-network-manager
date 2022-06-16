<?php
    namespace App\UI\API\V2;

    use App\Domain\_mysql\System\Repository\UserRepository;
    use App\UI\API\APIExtendController;
    use Firebase\JWT\JWT;
    use Symfony\Component\Config\FileLocator;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
    use Symfony\Component\Security\Core\Exception\UserNotFoundException;

    /**
     * @Route("", name="security.")
     */
    class SecurityController extends APIExtendController {

        /**
         * @Route("login", name="login")
         */
        public function login(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher){
            $requestLogin = $request->toArray();
            if(array_key_exists("username", $requestLogin) && array_key_exists("password", $requestLogin)){
                $user = $userRepository->findOneBy(['email' => $requestLogin['username']]);
                if($user){
                    if($passwordHasher->isPasswordValid($user, $requestLogin['password'])){
                        $fileLocator = new FileLocator([__DIR__.'/../../../../config/jwt/']);
                        $privateKey = file_get_contents($fileLocator->locate("private_key.pem", null, false)[0]);

                        return new JsonResponse([
                            'token' => JWT::encode([
                                'token' => $user->getId(),
                                'date'  => (new \DateTime())->format("d/m/Y H:i:s")
                            ], $privateKey, 'RS256')
                        ]);
                    } else throw new CustomUserMessageAuthenticationException("password not match");
                } else throw new UserNotFoundException();
            }
        }

    }