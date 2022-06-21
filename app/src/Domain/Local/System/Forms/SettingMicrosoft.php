<?php
    namespace App\Domain\Local\System\Forms;

    use App\Application\Services\SettingService;

    class SettingMicrosoft {

        private $security_microsoft_enabled;
        private $security_microsoft_client_id;
        private $security_microsoft_client_secret;
        private $security_microsoft_redirectUri;
        private $security_microsoft_url_authorize;
        private $security_microsoft_url_accessToken;
        private $security_microsoft_url_ressource;
        private $security_microsoft_scopes;

        public function __construct(SettingService $settingService){
            $this->setSecurityMicrosoftEnabled($settingService->getSetting('security.microsoft.enabled'));
            $this->setSecurityMicrosoftClientId($settingService->getSetting('security.microsoft.client.id'));
            $this->setSecurityMicrosoftClientSecret($settingService->getSetting('security.microsoft.client.secret'));
            $this->setSecurityMicrosoftRedirectUri($settingService->getSetting('security.microsoft.redirectUri'));
            $this->setSecurityMicrosoftUrlAuthorize($settingService->getSetting('security.microsoft.url.authorize'));
            $this->setSecurityMicrosoftUrlAccessToken($settingService->getSetting('security.microsoft.url.accessToken'));
            $this->setSecurityMicrosoftUrlRessource($settingService->getSetting('security.microsoft.url.ressource'));
            $this->setSecurityMicrosoftScopes($settingService->getSetting('security.microsoft.scopes'));
        }

        public function getSecurityMicrosoftEnabled() {
            return $this->security_microsoft_enabled;
        }

        public function setSecurityMicrosoftEnabled($security_microsoft_enabled): self {
            $this->security_microsoft_enabled = $security_microsoft_enabled;
            return $this;
        }

        public function getSecurityMicrosoftClientId() {
            return $this->security_microsoft_client_id;
        }

        public function setSecurityMicrosoftClientId($security_microsoft_client_id): self {
            $this->security_microsoft_client_id = $security_microsoft_client_id;
            return $this;
        }

        public function getSecurityMicrosoftClientSecret() {
            return $this->security_microsoft_client_secret;
        }

        public function setSecurityMicrosoftClientSecret($security_microsoft_client_secret): self {
            $this->security_microsoft_client_secret = $security_microsoft_client_secret;
            return $this;
        }

        public function getSecurityMicrosoftRedirectUri() {
            return $this->security_microsoft_redirectUri;
        }

        public function setSecurityMicrosoftRedirectUri($security_microsoft_redirectUri): self {
            $this->security_microsoft_redirectUri = $security_microsoft_redirectUri;
            return $this;
        }

        public function getSecurityMicrosoftUrlAuthorize() {
            return $this->security_microsoft_url_authorize;
        }

        public function setSecurityMicrosoftUrlAuthorize($security_microsoft_url_authorize): self {
            $this->security_microsoft_url_authorize = $security_microsoft_url_authorize;
            return $this;
        }

        public function getSecurityMicrosoftUrlAccessToken() {
            return $this->security_microsoft_url_accessToken;
        }

        public function setSecurityMicrosoftUrlAccessToken($security_microsoft_url_accessToken): self {
            $this->security_microsoft_url_accessToken = $security_microsoft_url_accessToken;
            return $this;
        }

        public function getSecurityMicrosoftUrlRessource() {
            return $this->security_microsoft_url_ressource;
        }

        public function setSecurityMicrosoftUrlRessource($security_microsoft_url_ressource): self {
            $this->security_microsoft_url_ressource = $security_microsoft_url_ressource;
            return $this;
        }

        public function getSecurityMicrosoftScopes() {
            return $this->security_microsoft_scopes;
        }

        public function setSecurityMicrosoftScopes($security_microsoft_scopes): self {
            $this->security_microsoft_scopes = $security_microsoft_scopes;
            return $this;
        }

    }