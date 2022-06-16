<?php
    namespace App\Infrastructure\Forms\AdminOffice\Authentication\Configuration;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\IntegerType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\FormBuilderInterface;

    class EditForm extends AbstractType {

        public function buildForm(FormBuilderInterface $builder, array $options) {
            parent::buildForm($builder, $options);
            $builder
                ->add('security_session_idle', IntegerType::class, [
                    'label'     => 'form.security.sessionIdle',
                    'required'  => true
                ])
                ->add('submit', SubmitType::class);
        }

    }