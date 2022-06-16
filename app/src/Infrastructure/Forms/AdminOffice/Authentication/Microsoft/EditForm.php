<?php
    namespace App\Infrastructure\Forms\AdminOffice\Authentication\Microsoft;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;

    class EditForm extends AbstractType {

        public function buildForm(FormBuilderInterface $builder, array $options) {
            parent::buildForm($builder, $options);
            $builder
                ->add('security_microsoft_enabled', CheckboxType::class, [
                    'help'      => 'form.security.ldap.enabled',
                    'label'     => '',
                    'required'  => false
                ])
                ->add('security_microsoft_client_id', TextType::class, [
                    'label'     => 'form.security.clientID',
                    'required'  => false
                ])
                ->add('security_microsoft_client_secret', TextType::class, [
                    'label'     => 'form.security.clientSecret',
                    'required'  => false
                ])
                ->add('security_microsoft_redirectUri', TextType::class, [
                    'help'      => 'Example : http://localhost/microsoft/callback.html',
                    'label'     => 'form.security.microsoft.redirectUri',
                    'required'  => false
                ])
                ->add('security_microsoft_url_authorize', TextType::class, [
                    'help'      => 'Example : https://login.microsoftonline.com/common/oauth2/v2.0/authorize',
                    'label'     => 'form.security.microsoft.urlAuthorize',
                    'required'  => false
                ])
                ->add('security_microsoft_url_accessToken', TextType::class, [
                    'help'      => 'Example : https://login.microsoftonline.com/common/oauth2/v2.0/token',
                    'label'     => 'form.security.microsoft.urlAccessToken',
                    'required'  => false
                ])
                ->add('security_microsoft_url_ressource', TextType::class, [
                    'label'     => 'form.security.microsoft.urlRessource',
                    'required'  => false
                ])
                ->add('security_microsoft_scopes', TextType::class, [
                    'help'      => 'Example : openid profile User.Read User.ReadBasic.All',
                    'label'     => 'form.security.microsoft.scopes',
                    'required'  => false
                ])
                ->add('submit', SubmitType::class);
        }

    }