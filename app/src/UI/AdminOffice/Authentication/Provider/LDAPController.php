<?php
    namespace App\UI\AdminOffice\Authentication\Provider;

    use App\Application\Services\LDAPService;
    use App\Application\Services\SettingService;
    use App\Domain\_local\System\Forms\SettingLdap;
    use App\Domain\_local\System\Forms\SettingLdapConnection;
    use App\Infrastructure\Forms\AdminOffice\Authentication\LDAP\EditForm;
    use App\Infrastructure\Forms\AdminOffice\Authentication\LDAP\EditServerForm;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
    use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("authentication/provider/ldap", "authentication.provider.ldap.")
     */
    class LDAPController extends AbstractController {

        /**
         * @Route(".html", name="index", methods={"GET", "POST"})
         */
        public function index(Request $request, SettingService $settingService){
            $settingLDAP = new SettingLdap($settingService);
            $connections = $settingService->getSetting('security.ldap.connections');

            $form = $this->createForm(EditForm::class, $settingLDAP);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $settingService->setSetting('security.ldap.authentication.username', $settingLDAP->getSecurityLdapAuthenticationUsername());

                if($settingLDAP->getSecurityLdapAuthenticationPassword() !== null)
                    $settingService->setSetting('security.ldap.authentication.password', $settingLDAP->getSecurityLdapAuthenticationPassword());

                $settingService->setSetting('security.ldap.search.user', $settingLDAP->getSecurityLdapSearchUser());
                $settingService->setSetting('security.ldap.schema.user.object', $settingLDAP->getSecurityLdapSchemaUserObject());
                $settingService->setSetting('security.ldap.schema.user.search', $settingLDAP->getSecurityLdapSchemaUserSearch());
                $settingService->setSetting('security.ldap.enabled', $settingLDAP->getSecurityLdapEnabled());

                return $this->redirectToRoute('adminoffice.authentication.provider.ldap.index');
            }

            return $this->render("AdminOffice/Authentication/Provider/LDAP/index.html.twig", [
                'connections'   => $connections,
                'form'          => $form->createView()
            ]);
        }

        /**
         * @Route("/server/new.html", name="server.new", methods={"GET", "POST"})
         */
        public function serverNew(Request $request, SettingService $settingService){
            $server = new SettingLdapConnection();

            $form = $this->createForm(EditServerForm::class, $server);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $servers = $settingService->getSetting('security.ldap.connections');
                $servers[] = [
                    'ip'            => $server->getIp(),
                    'encryption'    => $server->getEncryption()
                ];
                $settingService->setSetting('security.ldap.connections', $servers);

                return $this->redirectToRoute('adminoffice.authentication.provider.ldap.index');
            }

            return $this->render("AdminOffice/Authentication/Provider/LDAP/server.new.html.twig", [
                'form'  => $form->createView()
            ]);
        }

        /**
         * @Route("/server/edit/{id}.html", name="server.edit", methods={"GET", "POST"})
         */
        public function serverEdit(Request $request, SettingService $settingService){
            $id = $request->get('id');
            $servers = $settingService->getSetting('security.ldap.connections');

            if(array_key_exists($id, $servers)){
                $server = new SettingLdapConnection($servers[$id]);
                $form = $this->createForm(EditServerForm::class, $server);
                $form->handleRequest($request);

                if($form->isSubmitted() && $form->isValid()){
                    $servers[$id] = [
                        'ip'            => $server->getIp(),
                        'encryption'    => $server->getEncryption()
                    ];
                    $settingService->setSetting('security.ldap.connections', $servers);
                    return $this->redirectToRoute('adminoffice.authentication.provider.ldap.index');
                }

                return $this->render("AdminOffice/Authentication/Provider/LDAP/server.edit.html.twig", [
                    'form'      => $form->createView(),
                    'id'        => $id,
                    'server'    => $server
                ]);
            } else {
                throw new NotFoundHttpException();
            }
        }

        /**
         * @Route("/server/{id}/down.html", name="server.down", methods={"GET", "POST"})
         */
        public function serverDown(Request $request, SettingService $settingService){
            $sId = $request->get('id');
            $dId = $sId + 1;

            $servers = $settingService->getSetting('security.ldap.connections');
            $sServer = $servers[$sId];
            $dServer = $servers[$dId];

            $servers[$dId] = $sServer;
            $servers[$sId] = $dServer;

            $settingService->setSetting('security.ldap.connections', $servers);

            return $this->redirectToRoute('adminoffice.authentication.provider.ldap.index');
        }

        /**
         * @Route("/server/{id}/up.html", name="server.up", methods={"GET", "POST"})
         */
        public function serverUp(Request $request, SettingService $settingService){
            $sId = $request->get('id');
            $dId = $sId - 1;

            $servers = $settingService->getSetting('security.ldap.connections');
            $sServer = $servers[$sId];
            $dServer = $servers[$dId];

            $servers[$dId] = $sServer;
            $servers[$sId] = $dServer;

            $settingService->setSetting('security.ldap.connections', $servers);

            return $this->redirectToRoute('adminoffice.authentication.provider.ldap.index');
        }

        /**
         * @Route("/server/delete/{id}.html", name="server.delete", methods={"GET", "POST"})
         */
        public function serverDelete(Request $request, SettingService $settingService){
            $id = $request->get('id');
            $servers = $settingService->getSetting('security.ldap.connections');

            if(array_key_exists($id, $servers)){
                if($this->isCsrfTokenValid('delete-'. $id, $request->get('_token'))){
                    unset($servers[$id]);
                    $settingService->setSetting('security.ldap.connections', $servers);

                    return $this->redirectToRoute('adminoffice.authentication.provider.ldap.index');
                }
            } else {
                throw new NotFoundHttpException();
            }
        }

        /**
         * @Route("/test.html", name="test", methods={"GET", "POST"})
         */
        public function test(LDAPService $LDAPService, Request $request){
            $form = $this->createFormBuilder()->add('search', TextType::class)->add('Submit', SubmitType::class)->getForm();
            $form->handleRequest($request);

            $results = [];

            if($form->isSubmitted() && $form->isValid()){
                $servers = $LDAPService->getServers();
                foreach ($servers as $s){
                    if($LDAPService->testConnection($s)){
                        $results[] = [
                            'type'      => 'success',
                            'message'   => 'Successful connection to ldap <b>'. $s .'</b> server'
                        ];

                        $search = $LDAPService->searchUser($form->getData()['search']);
                        if($search !== false){
                            $results[] = [
                                'type'      => 'success',
                                'message'   => 'User <b>'. $form->getData()['search'] .'</b> was found on the LDAP server.<br/>The user\'s DN is: <b>'. $search .'</b>'
                            ];
                        } else {
                            $results[] = [
                                'type'      => 'error',
                                'message'   => 'The user was not found on the LDAP server'
                            ];
                        }
                    } else {
                        $results[] = [
                            'type'      => 'error',
                            'message'   => 'Failure connection to ldap <b>'. $s .'</b> server'
                        ];
                    }
                }
            }

            return $this->render("AdminOffice/Authentication/Provider/LDAP/test.html.twig", [
                'form'      => $form->createView(),
                'results'   => $results
            ]);
        }

    }