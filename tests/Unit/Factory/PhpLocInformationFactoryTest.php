<?php

namespace CodeHqDk\RepositoryInformation\PHPLOC\Tests\Unit\Factory;

use CodeHqDk\RepositoryInformation\PHPLOC\Factory\PhpLocInformationFactory;
use CodeHqDk\RepositoryInformation\PHPLOC\InformationBlocks\CyclomaticComplexityInformationBlock;
use CodeHqDk\RepositoryInformation\PHPLOC\InformationBlocks\SizeInformationBlock;
use CodeHqDk\RepositoryInformation\Model\RepositoryRequirements;
use Lcobucci\Clock\FrozenClock;
use PHPUnit\Framework\TestCase;

/**
 * @group whitelisted
 */
class PhpLocInformationFactoryTest extends TestCase
{
    private string $output_path;

    protected function setup(): void
    {
        $this->output_path = dirname(__FILE__, 3) . '/data';
    }

    public function testListAvailable(): void
    {
        $factory = new PhpLocInformationFactory($this->output_path);
        $expected = [
            SizeInformationBlock::class,
            CyclomaticComplexityInformationBlock::class
        ];
        $this->assertEquals($expected, $factory->listAvailableInformationBlocks());
    }

    public function testGetRepositoryRequirements(): void
    {
        $factory = new PhpLocInformationFactory($this->output_path);
        $this->assertInstanceOf(RepositoryRequirements::class, $factory->getRepositoryRequirements());
    }

    public function testCreateBlocks(): void
    {
        $factory = new PhpLocInformationFactory(
            $this->output_path,
            FrozenClock::fromUTC()
        );

        $expected_size_block = new SizeInformationBlock(
            'Php lines of code information (using PHPLOC)',
            'Total lines of code in src/ folder (Sizes section)',
            '75',
            time(),
            'Number of LLOC inside classes: 8
            Average length of LLOC inside classes: 2.6666666666667
            Maximum length of LLOC inside classes: 5',
            'This is information from the Phploc Information Factory',
        );

        $expected_cc_block = new CyclomaticComplexityInformationBlock(
            'Php lines of code information (using PHPLOC)',
            'Average Complexity per LLOC of code in src/ folder (CC section)',
            '0.125',
            time(),
            'Average CC per class: 1.3333333333333
            Maximum class CC: 2
            Average CC per method: 1.2
            Maximum method CC: 2',
            'This is information from the Phploc Information Factory',
        );

        $path_to_sample_repository = dirname(__FILE__, 4) . '/vendor/codehq-dk/repo-info-example-plugin';

        $actual_blocks = $factory->createBlocks($path_to_sample_repository);
        /**
         * @var SizeInformationBlock $actual_size_block
         */
        $actual_size_block = array_shift($actual_blocks);

        $this->assertEquals($expected_size_block->getHeadline(), $actual_size_block->getHeadline());
        $this->assertEquals($expected_size_block->getLabel(), $actual_size_block->getLabel());
        $this->assertEquals($expected_size_block->getValue(), $actual_size_block->getValue());
        $this->assertEquals($expected_size_block->getModifiedTimestamp(), $actual_size_block->getModifiedTimestamp());
        $this->assertEquals($expected_size_block->getDetails(), $actual_size_block->getDetails());
        $this->assertEquals($expected_size_block->getInformationOrigin(), $actual_size_block->getInformationOrigin());

        /**
         * @var CyclomaticComplexityInformationBlock $actual_cc_block
         */
        $actual_cc_block = array_shift($actual_blocks);

        $this->assertEquals($expected_cc_block->getHeadline(), $actual_cc_block->getHeadline());
        $this->assertEquals($expected_cc_block->getLabel(), $actual_cc_block->getLabel());
        $this->assertEquals($expected_cc_block->getValue(), $actual_cc_block->getValue());
        $this->assertEquals($expected_cc_block->getModifiedTimestamp(), $actual_cc_block->getModifiedTimestamp());
        $this->assertEquals($expected_cc_block->getDetails(), $actual_cc_block->getDetails());
        $this->assertEquals($expected_cc_block->getInformationOrigin(), $actual_cc_block->getInformationOrigin());
    }
}
