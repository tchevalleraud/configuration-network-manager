<?php
    namespace App\Infrastructure\Forms\AdminOffice\Authentication\LDAP;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
    use Symfony\Component\Form\Extension\Core\Type\PasswordType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;

    class EditForm extends AbstractType {

        public function buildForm(FormBuilderInterface $builder, array $options) {
            parent::buildForm($builder, $options);
            $builder
                ->add('security_ldap_enabled', CheckboxType::class, [
                    'help'      => 'form.security.ldap.enabled',
                    'label'     => '',
                    'required'  => false
                ])
                ->add('security_ldap_authentication_username', TextType::class, [
                    'help'      => 'Example : CN=ldap,DC=domain,DC=local',
                    'label'     => 'form.security.authentication.username',
                    'required'  => false
                ])
                ->add('security_ldap_authentication_password', PasswordType::class, [
                    'always_empty'  => false,
                    'label'         => 'form.security.authentication.password',
                    'required'      => false
                ])
                ->add('security_ldap_search_user', TextType::class, [
                    'help'      => 'Example : DC=domain,DC=local',
                    'label'     => 'form.security.ldap.search.user',
                    'required'  => false
                ])
                ->add('security_ldap_schema_user_object', TextType::class, [
                    'help'      => 'Example : person',
                    'label'     => 'form.security.ldap.schema.user.object',
                    'required'  => false
                ])
                ->add('security_ldap_schema_user_search', TextType::class, [
                    'help'      => 'Example : userPrincipalName',
                    'label'     => 'form.security.ldap.schema.user.search',
                    'required'  => false
                ])
                ->add('submit', SubmitType::class);
        }

    }