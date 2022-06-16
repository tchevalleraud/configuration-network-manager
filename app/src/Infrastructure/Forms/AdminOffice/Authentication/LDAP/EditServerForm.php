<?php
    namespace App\Infrastructure\Forms\AdminOffice\Authentication\LDAP;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;

    class EditServerForm extends AbstractType {

        public function buildForm(FormBuilderInterface $builder, array $options) {
            parent::buildForm($builder, $options);

            $builder
                ->add('ip', TextType::class)
                ->add('encryption', ChoiceType::class, [
                    'choices'   => [
                        'none'  => 'none',
                        'ssl'   => 'ssl',
                        'tls'   => 'tls'
                    ]
                ])
                ->add('submit', SubmitType::class);
        }

    }