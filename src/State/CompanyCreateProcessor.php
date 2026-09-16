<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Company;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Target;

class CompanyCreateProcessor implements ProcessorInterface
{
    public function __construct(
        #[Target('api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        private Security $security
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if ($data instanceof Company) {
            $currentUser = $this->security->getUser();

            if ($currentUser) {
                $data->setCreatedBy($currentUser);
            }
        }

        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}
