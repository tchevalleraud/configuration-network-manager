<?php
    namespace App\Domain\_local\System\Forms;

    use App\Application\Services\SettingService;

    class SettingLdap {

        private $security_ldap_authentication_username;
        private $security_ldap_authentication_password;
        private $security_ldap_search_user;
        private $security_ldap_schema_user_object;
        private $security_ldap_schema_user_search;
        private $security_ldap_enabled;

        public function __construct(SettingService $settingService){
            $this->setSecurityLdapAuthenticationUsername($settingService->getSetting('security.ldap.authentication.username'));
            $this->setSecurityLdapAuthenticationPassword($settingService->getSetting('security.ldap.authentication.password'));
            $this->setSecurityLdapSearchUser($settingService->getSetting('security.ldap.search.user'));
            $this->setSecurityLdapSchemaUserObject($settingService->getSetting('security.ldap.schema.user.object'));
            $this->setSecurityLdapSchemaUserSearch($settingService->getSetting('security.ldap.schema.user.search'));
            $this->setSecurityLdapEnabled($settingService->getSetting('security.ldap.enabled'));
        }

        public function getSecurityLdapAuthenticationUsername(){
            return $this->security_ldap_authentication_username;
        }

        public function setSecurityLdapAuthenticationUsername($security_ldap_authentication_username): self {
            $this->security_ldap_authentication_username = $security_ldap_authentication_username;
            return $this;
        }

        public function getSecurityLdapAuthenticationPassword(){
            return $this->security_ldap_authentication_password;
        }

        public function setSecurityLdapAuthenticationPassword($security_ldap_authentication_password): self {
            $this->security_ldap_authentication_password = $security_ldap_authentication_password;
            return $this;
        }

        public function getSecurityLdapSearchUser() {
            return $this->security_ldap_search_user;
        }

        public function setSecurityLdapSearchUser($security_ldap_search_user): self {
            $this->security_ldap_search_user = $security_ldap_search_user;
            return $this;
        }

        public function getSecurityLdapSchemaUserObject() {
            return $this->security_ldap_schema_user_object;
        }

        public function setSecurityLdapSchemaUserObject($security_ldap_schema_user_object): self {
            $this->security_ldap_schema_user_object = $security_ldap_schema_user_object;
            return $this;
        }

        public function getSecurityLdapSchemaUserSearch() {
            return $this->security_ldap_schema_user_search;
        }

        public function setSecurityLdapSchemaUserSearch($security_ldap_schema_user_search): self {
            $this->security_ldap_schema_user_search = $security_ldap_schema_user_search;
            return $this;
        }

        public function getSecurityLdapEnabled() {
            return $this->security_ldap_enabled;
        }

        public function setSecurityLdapEnabled($security_ldap_enabled): self {
            $this->security_ldap_enabled = $security_ldap_enabled;
            return $this;
        }

    }