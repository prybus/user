<?php

declare(strict_types=1);

namespace MsgPhp\User\Infra\Form\Type;

use MsgPhp\User\Password\PasswordAlgorithm;
use MsgPhp\User\Password\PasswordHashingInterface;
use MsgPhp\User\Password\PasswordSalt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class HashedPasswordType extends AbstractType
{
    /**
     * @var PasswordHashingInterface
     */
    private $passwordHashing;

    /**
     * @var TokenStorageInterface|null
     */
    private $tokenStorage;

    public function __construct(PasswordHashingInterface $passwordHashing, TokenStorageInterface $tokenStorage = null)
    {
        $this->passwordHashing = $passwordHashing;
        $this->tokenStorage = $tokenStorage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $password = new Password();
        $password->current = $options['password_confirm_current'];
        $password->algorithm = $this->createAlgorithm($options['password_algorithm'], $password->current);

        $defaultOptions = ['required' => $options['required']];
        if (isset($options['invalid_message'])) {
            $defaultOptions += [
                'invalid_message' => $options['invalid_message'],
                'invalid_message_parameters' => $options['invalid_message_parameters'],
            ];
        }
        $passwordOptions = $options['password_options'] + $defaultOptions;

        if ($options['password_confirm_current']) {
            if (!class_exists(Callback::class)) {
                throw new \LogicException('Current password confirmation requires "symfony/validator".');
            }
            if (null === $this->tokenStorage) {
                throw new \LogicException('Current password confirmation requires "symfony/security".');
            }

            $passwordOptions = self::withConstraint($passwordOptions, new Callback(function ($value, ExecutionContextInterface $context) use ($password, $passwordOptions): void {
                $currentPassword = $this->getCurrentPassword();
                $valid = null !== $currentPassword && null !== $password->plainValue && $this->passwordHashing->isValid($currentPassword, $password->plainValue, $password->algorithm);

                if (!$valid) {
                    /** @var FormInterface $form */
                    $form = $context->getObject();
                    $form->addError($this->createError($passwordOptions));
                }
            }));
        }

        $builder->add('password', PasswordType::class, $passwordOptions);
        $builder->get('password')->addModelTransformer(new CallbackTransformer(function ($value): ?string {
            return null;
        }, function ($value) use ($password): ?string {
            $password->submit($value);

            if (null === $value) {
                return null;
            }

            if (\is_string($value) && \function_exists('sodium_memzero')) {
                sodium_memzero($value);
            }

            if (null === $password->plainValue) {
                throw new TransformationFailedException();
            }

            $password->hashedValue = $this->passwordHashing->hash($password->plainValue, $password->algorithm);
            if (!$password->current) {
                $password->plainValue = null;
            }

            return $password->hashedValue;
        }));

        if ($options['password_confirm']) {
            if (!class_exists(Callback::class)) {
                throw new \LogicException('Password confirmation requires "symfony/validator".');
            }

            $passwordConfirmOptions = ['mapped' => false] + $options['password_confirm_options'] + $defaultOptions;
            $passwordConfirmOptions = self::withConstraint($passwordConfirmOptions, new Callback(function ($value, ExecutionContextInterface $context) use ($password, $passwordConfirmOptions): void {
                if (null === $value && null === $password->hashedValue) {
                    return;
                }

                $valid = false;
                if (\is_string($value)) {
                    $valid = null == $password->hashedValue ? false : $this->passwordHashing->isValid($password->hashedValue, $value, $password->algorithm);
                    if (\function_exists('sodium_memzero')) {
                        sodium_memzero($value);
                    }
                }

                if (!$valid) {
                    /** @var FormInterface $form */
                    $form = $context->getObject();
                    $form->addError($this->createError($passwordConfirmOptions));
                }
            }));

            $builder->add('confirmation', PasswordType::class, $passwordConfirmOptions);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'inherit_data' => true,
            'label' => false,
            'password_algorithm' => null,
            'password_options' => [],
            'password_confirm' => false,
            'password_confirm_options' => function (Options $options, $value) {
                return $value ?? $options['password_options'];
            },
            'password_confirm_current' => false,
        ]);

        $resolver->setAllowedTypes('password_algorithm', ['null', 'callable', 'int', 'string', PasswordAlgorithm::class]);
        $resolver->setAllowedTypes('password_confirm', ['bool']);
        $resolver->setAllowedTypes('password_confirm_current', ['bool']);
        $resolver->setAllowedTypes('password_confirm_options', ['null', 'array']);
        $resolver->setAllowedTypes('password_options', ['array']);
    }

    private static function withConstraint(array $options, Constraint $constraint): array
    {
        if (!isset($options['constraints'])) {
            $options['constraints'] = [];
        } elseif (!\is_array($options['constraints'])) {
            $options['constraints'] = [$options['constraints']];
        }

        $options['constraints'][] = $constraint;

        return $options;
    }

    /**
     * @param callable|int|string|PasswordAlgorithm|null $algorithm
     */
    private function createAlgorithm($algorithm, bool $current = false): ?PasswordAlgorithm
    {
        if ($algorithm instanceof PasswordAlgorithm) {
            return $algorithm;
        }

        if (\is_int($algorithm)) {
            return PasswordAlgorithm::create($algorithm);
        }

        if (\is_string($algorithm)) {
            return PasswordAlgorithm::createLegacy($algorithm);
        }

        if ($current) {
            if (null === $this->tokenStorage) {
                throw new \LogicException('Current password confirmation requires "symfony/security".');
            }
            $token = $this->tokenStorage->getToken();
            $user = null === $token ? null : $token->getUser();

            if (\is_callable($algorithm)) {
                return $algorithm($user);
            }

            if ($user instanceof UserInterface && null !== $salt = $user->getSalt()) {
                return PasswordAlgorithm::createLegacySalted(new PasswordSalt($salt));
            }

            return null;
        }

        return \is_callable($algorithm) ? $algorithm() : null;
    }

    private function createError(array $options): FormError
    {
        $message = $options['invalid_message'] ?? 'This value is not valid.';

        return new FormError($message, $message, $options['invalid_message_parameters'] ?? [], null, $this);
    }

    private function getCurrentPassword(): ?string
    {
        if (null === $this->tokenStorage) {
            throw new \LogicException('Current password confirmation requires "symfony/security".');
        }

        $token = $this->tokenStorage->getToken();

        if (null === $token) {
            return null;
        }

        $user = $token->getUser();

        return $user instanceof UserInterface ? $user->getPassword() : null;
    }
}

/**
 * @internal
 */
final class Password
{
    /**
     * @var bool
     */
    public $current = false;

    /**
     * @var PasswordAlgorithm|null
     */
    public $algorithm;

    /**
     * @var string|null
     */
    public $plainValue;

    /**
     * @var string|null
     */
    public $hashedValue;

    /**
     * @param mixed $value
     */
    public function submit($value): void
    {
        $this->plainValue = \is_string($value) ? $value : null;
        $this->hashedValue = null;
    }
}
