<?php

namespace CodeHqDk\RepositoryInformation\PHPLOC\Tests\Unit\InformationBlock;

use CodeHqDk\RepositoryInformation\PHPLOC\InformationBlocks\SizeInformationBlock;
use PHPUnit\Framework\TestCase;

/**
 * @group whitelisted
 */
class SizeInformationBlockTest extends TestCase
{
    public function testConstructionAndGetters()
    {
        $block = new SizeInformationBlock(
            $expected_headline = 'expected headline',
            $expected_label = 'expected label',
            $expected_value = 'expected value',
            $expected_time_stamp = time(),
            $expected_details = 'expected details',
            $expected_information_origin = 'expected information origin'
        );

        $this->assertEquals($expected_headline, $block->getHeadline());
        $this->assertEquals($expected_label, $block->getLabel());
        $this->assertEquals($expected_value, $block->getValue());
        $this->assertEquals($expected_time_stamp, $block->getModifiedTimestamp());
        $this->assertEquals($expected_details, $block->getDetails());
        $this->assertEquals($expected_information_origin, $block->getInformationOrigin());

        $this->assertEquals(SizeInformationBlock::class, $block->getInfoTypeId());
    }

    public function testSerialization()
    {
        $original_block = new SizeInformationBlock(
            'expected headline',
            'expected label',
            'expected value',
            time(),
            'expected details',
            'expected information origin'
        );

        $block_as_array = $original_block->toArray();

        $new_block = SizeInformationBlock::fromArray($block_as_array);

        $this->assertEquals($original_block, $new_block);
    }
}
