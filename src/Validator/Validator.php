<?php

namespace App\Validator;

use App\Validator\Exception\SetterNotFoundException;
use App\Validator\Exception\ValidatorNotFoundException;
use App\Validator\Interface\ValidatorAwareInterface;
use App\Validator\Interface\ValidatorInterface;
use Sruuua\DependencyInjection\Container;

class Validator
{
    /**
     * @var ValidatorInterface[]
     */
    private array $validators;

    private Container $container;

    private function realValidate(mixed $data)
    {
        foreach ($this->validators as $validator) {
            if ($validator->supports($data)) {
                return $validator->validate($data);
            }
        }
    }

    public function __construct(Container $container)
    {
        $this->validators = array();

        $this->container = $container;

        foreach ($this->container->getAllByType(ValidatorInterface::class) as $validator) {
            $this->addValidator($validator);
        }
    }

    public function addValidator(ValidatorInterface $validator)
    {
        if ($validator instanceof ValidatorAwareInterface) {
            $validator->setValidator($this);
        }

        $this->validators[$validator::class] = $validator;
    }

    public function validate(object $data): array
    {
        $return = array();
        $class = new \ReflectionClass($data::class);

        foreach ($class->getProperties() as $property) {
            $attribute = $property->getAttributes();
            if (!empty($attribute)) {
                $constraint = $attribute[0]->newInstance();

                $getter = 'get' . ucfirst($property->getName());

                if (!$class->hasMethod($getter)) {
                    throw new SetterNotFoundException(sprintf('Getter for %s not found you should create method %s()', $property->getName(), $getter));
                }

                if (!$this->getValidator($constraint->getValidator())->validate($data->$getter())) {
                    $return[$property->getName()] = $constraint->getMessage();
                }
            }
        }

        return $return;

        throw new ValidatorNotFoundException(sprintf('No validator found for %s', $data::class));
    }

    public function hasValidator(string $validatorName): bool
    {
        return in_array($validatorName, $this->validators);
    }

    public function getValidator(string $validatorName): ValidatorInterface
    {
        return $this->validators[$validatorName];
    }
}
