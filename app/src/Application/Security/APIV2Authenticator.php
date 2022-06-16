<?php
    namespace App\Application\Security;

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    use Symfony\Component\Config\FileLocator;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
    use Symfony\Component\Security\Core\Exception\AuthenticationException;
    use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
    use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
    use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
    use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
    use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

    class APIV2Authenticator extends AbstractAuthenticator {

        public function supports(Request $request): ?bool {
            if($request->headers->has('authorization')) return $request->headers->has('authorization');
            else return false;
        }

        public function authenticate(Request $request): Passport {
            if($request->headers->has('authorization')) {
                $fileLocator = new FileLocator([__DIR__.'/../../../config/jwt/']);
                $publicKey = file_get_contents($fileLocator->locate("public_key.pem", null, false)[0]);
                $jwt = str_replace("Bearer ", "", $request->headers->get('authorization'));
                $jwt = str_replace("Bearer", "", $jwt);
                if($jwt != ""){
                    $data = JWT::decode($jwt, new Key($publicKey, 'RS256'));
                    $token = $data->token;
                } else throw new CustomUserMessageAuthenticationException('API token error');
            } else throw new CustomUserMessageAuthenticationException('No API token provided');

            return new SelfValidatingPassport(new UserBadge($token), []);
        }

        public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response {
            return null;
        }

        public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response {
            return new JsonResponse(['message' => strtr($exception->getMessageKey(), $exception->getMessageData())], Response::HTTP_UNAUTHORIZED);
        }

    }