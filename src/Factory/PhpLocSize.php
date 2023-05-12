<?php

namespace CodeHqDk\RepositoryInformation\PHPLOC\Factory;

/**
 * PhpLoc Size constants
 */
class PhpLocSize
{
    public const NO_OF_FILES       = 'files';

    // SIZE constants
    public const LINES_OF_CODE             = 'loc';
    public const COMMENT_LINES_OF_CODE     = 'cloc';
    public const NON_COMMENT_LINES_OF_CODE = 'ncloc';
    public const LOGICAL_LINES_OF_CODE     = 'lloc';

    // LLOC = LOGICAL_LINES_OF_CODE
    public const LLOC_INSIDE_CLASSES              = 'llocClasses';
    public const LLOC_AVG_LENGTH_INSIDE_CLASSES   = 'classLlocAvg';
    public const LLOC_MIN_LENGTH_INSIDE_CLASSES   = 'classLlocMin';
    public const LLOC_MAX_LENGTH_INSIDE_CLASSES   = 'classLlocMax';
    public const LLOC_AVG_LENGTH_INSIDE_METHODS   = 'methodLlocAvg';
    public const LLOC_MIN_LENGTH_INSIDE_METHODS   = 'methodLlocMin';
    public const LLOC_MAX_LENGTH_INSIDE_METHODS   = 'methodLlocMax';
    public const LLOC_INSIDE_FUNCTIONS            = 'llocFunctions';
    public const LLOC_AVG_LENGTH_INSIDE_FUNCTIONS = '?';
    public const LLOC_NOT_IN_CLASSES_OR_FUNCTIONS = 'llocGlobal';
}
