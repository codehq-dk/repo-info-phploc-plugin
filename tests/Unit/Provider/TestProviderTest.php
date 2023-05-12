<?php

namespace CodeHqDk\RepositoryInformation\PHPLOC\Tests\Unit\Provider;

use CodeHqDk\RepositoryInformation\PHPLOC\Provider\PhplocInformationFactoryProvider;
use CodeHqDk\RepositoryInformation\PHPLOC\Tests\Mock\MockProvider;
use PHPUnit\Framework\TestCase;

/**
 * @group whitelisted
 */
class TestProviderTest extends TestCase
{
    public function testAddFactory(): void
    {
        $provider = new MockProvider();

        $composer_provider = new PhplocInformationFactoryProvider(dirname(__FILE__, 2) . '/data');

        $this->assertFalse($provider->register_in_dependency_injection_container_called);
        $this->assertFalse($provider->add_information_factory_to_registry_called);

        $composer_provider->addFactory($provider);

        $this->assertTrue($provider->register_in_dependency_injection_container_called);
        $this->assertTrue($provider->add_information_factory_to_registry_called);
    }
}
