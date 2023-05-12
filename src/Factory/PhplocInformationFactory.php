<?php

namespace CodeHqDk\RepositoryInformation\PHPLOC\Factory;

use CodeHqDk\LinuxBashHelper\Bash;
use CodeHqDk\LinuxBashHelper\Environment;
use CodeHqDk\RepositoryInformation\Factory\InformationFactory;
use CodeHqDk\RepositoryInformation\Model\RepositoryRequirements;
use CodeHqDk\RepositoryInformation\PHPLOC\InformationBlocks\CyclomaticComplexityInformationBlock;
use CodeHqDk\RepositoryInformation\PHPLOC\InformationBlocks\SizeInformationBlock;
use Lcobucci\Clock\Clock;
use Lcobucci\Clock\SystemClock;

class PhplocInformationFactory implements InformationFactory
{
    public const DEFAULT_ENABLED_BLOCKS = [
        SizeInformationBlock::class
    ];

    public function __construct(
        private readonly string $phploc_output_path,
        private ?Clock $clock = null
    ) {
        if ($this->clock === null) {
            $this->clock = SystemClock::fromSystemTimezone();
        }
    }

    public function createBlocks(
        string $local_path_to_code,
        array $information_block_types_to_create = self::DEFAULT_ENABLED_BLOCKS
    ): array {
        if (!in_array(SizeInformationBlock::class, $information_block_types_to_create)) {
            return [];
        }

        $phploc_json = $this->getPhploc($local_path_to_code);

        $array = json_decode($phploc_json, true);

        $size_details = "Number of LLOC inside classes: {$array[PhpLocSize::LLOC_INSIDE_CLASSES]}
            Average length of LLOC inside classes: {$array[PhpLocSize::LLOC_AVG_LENGTH_INSIDE_CLASSES]}
            Maximum length of LLOC inside classes: {$array[PhpLocSize::LLOC_MAX_LENGTH_INSIDE_CLASSES]}";

        $cc_details = "Average CC per class: {$array[PhpLocCC::CC_AVG_COMPLEXITY_PER_CLASS]}
            Maximum class CC: {$array[PhpLocCC::CC_MAX_COMPLEXITY_PER_CLASS]}
            Average CC per method: {$array[PhpLocCC::CC_AVG_COMPLEXITY_PER_METHOD]}
            Maximum method CC: {$array[PhpLocCC::CC_MAX_COMPLEXITY_PER_METHOD]}";

        return [
            new SizeInformationBlock(
                'Php lines of code information (using PHPLOC)',
                'Total lines of code in src/ folder (Sizes section)',
                $array[PhpLocSize::LINES_OF_CODE],
                $this->clock->now()->getTimestamp(),
                $size_details,
                'This is information from the Phploc Information Factory',
            ),
            new CyclomaticComplexityInformationBlock(
                'Php lines of code information (using PHPLOC)',
                'Average Complexity per LLOC of code in src/ folder (CC section)',
                $array[PhpLocCC::CC_AVG_COMPLEXITY_PER_LLOC],
                $this->clock->now()->getTimestamp(),
                $cc_details,
                'This is information from the Phploc Information Factory'
            ),
        ];
    }

    public function getRepositoryRequirements(): RepositoryRequirements
    {
        return new RepositoryRequirements(false, false, false, false);
    }

    public function listAvailableInformationBlocks(): array
    {
        return [
            SizeInformationBlock::class,
            CyclomaticComplexityInformationBlock::class
        ];
    }


    private function getPhploc(string $local_path_to_code): string
    {
        $php = Environment::getPhpPath();
        $phploc = dirname(__FILE__, 3) . '/phploc.phar';
        $path_to_code = $local_path_to_code . '/src';
        $output_path = $this->phploc_output_path . "/phploc_report.json";

        $command_to_run = "{$php} {$phploc} {$path_to_code} --log-json={$output_path}";

        Bash::runCommand($command_to_run);

        return file_get_contents($output_path);
    }
}
