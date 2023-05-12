<?php

namespace CodeHqDk\RepositoryInformation\PHPLOC\Provider;

use CodeHqDk\RepositoryInformation\PHPLOC\Factory\PhplocInformationFactory;
use CodeHqDk\RepositoryInformation\Factory\InformationFactoryProvider;
use CodeHqDk\RepositoryInformation\Service\ProviderDependencyService;

class PhplocInformationFactoryProvider implements InformationFactoryProvider
{
    public function __construct(private readonly string $phploc_output_path)
    {
    }

    public function addFactory(ProviderDependencyService $provider_dependency_service): void
    {
        $provider_dependency_service->registerClassInDependencyContainer(PhplocInformationFactory::class);
        $provider_dependency_service->addInformactionFactoryToRegistry(
            new PhplocInformationFactory(
                $this->phploc_output_path
            )
        );
    }
}
