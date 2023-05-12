<?php

namespace CodeHqDk\RepositoryInformation\PHPLOC\InformationBlocks;

use CodeHqDk\RepositoryInformation\Model\BaseInformationBlock;

class SizeInformationBlock extends BaseInformationBlock
{
    public static function fromArray(array $array): self {
        return new self(
            $array['headline'],
            $array['label'],
            $array['value'],
            $array['modified_timestamp'],
            $array['details'],
            $array['information_origin'],
       );
    }
}
