<?php
    namespace App\Application\Services;

    use Symfony\Component\Ldap\Ldap;

    class LDAPService {

        private SettingService $settingService;

        private $authPassword;
        private $authUsername;
        private $userSchemaAttribute;
        private $userSchemaObject;
        private $userSearchRoot;
        private $servers;

        public function __construct(SettingService $settingService){
            $this->settingService = $settingService;

            $this->authPassword = $this->settingService->getSetting('security.ldap.authentication.password');
            $this->authUsername = $this->settingService->getSetting('security.ldap.authentication.username');
            $this->userSchemaAttribute = $this->settingService->getSetting('security.ldap.schema.user.search');
            $this->userSchemaObject = $this->settingService->getSetting('security.ldap.schema.user.object');
            $this->userSearchRoot = $this->settingService->getSetting('security.ldap.search.user');
            $servers = $this->settingService->getSetting('security.ldap.connections');
            foreach ($servers as $s){
                $this->servers[$s['ip']] = $s;
            }
        }

        public function getServers(){
            $data = [];
            foreach ($this->servers as $k => $v) $data[] = $k;
            return $data;
        }

        public function searchUser($username){
            foreach ($this->servers as $server){
                try {
                    $ldap = Ldap::create('ext_ldap', ['host' => $server['ip'], 'encryption' => $server['encryption']]);
                    $ldap->bind($this->authUsername, $this->authPassword);
                    $query = $ldap->query($this->userSearchRoot, '(&(objectclass='. $this->userSchemaObject .')('.$this->userSchemaAttribute.'='.$username.'))');
                    $result = $query->execute()->toArray();
                    if(sizeof($result) == 1){
                        return $result[0]->getDn();
                    } else {
                        return false;
                    }
                } catch (\Exception $e) {
                    throw new \Exception($e->getMessage());
                }
            }
        }

        public function testConnection($server = null, $username = null, $password = null, $searchUser = false){
            if($searchUser === true){
                $username = $this->searchUser($username);
                if($username === false) throw new \Exception("Request LDAP error");
            }

            if($server !== null){
                if(array_key_exists($server, $this->servers)){
                    try {
                        $ldap = Ldap::create('ext_ldap', ['host' => $this->servers[$server]['ip'], 'encryption' => $this->servers[$server]['encryption']]);
                        if($username !== null && $password !== null) $ldap->bind($username, $password);
                        else $ldap->bind($this->authUsername, $this->authPassword);

                        return true;
                    } catch (\Exception $e) {
                        return false;
                    }
                } else throw new \Exception("Server not found");
            } else {
                $results = [];
                foreach ($this->servers as $server){
                    try {
                        $ldap = Ldap::create('ext_ldap', ['host' => $server['ip'], 'encryption' => $server['encryption']]);
                        if($username !== null && $password !== null) $ldap->bind($username, $password);
                        else $ldap->bind($this->authUsername, $this->authPassword);
                        $results[$server['ip']] = true;
                    } catch (\Exception $e) {
                        $results[$server['ip']] = false;
                    }
                }
                return $results;
            }
        }

    }