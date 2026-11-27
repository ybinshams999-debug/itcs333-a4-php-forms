<?php
declare(strict_types=1);

/**
 * ITCS333 A4 starter — implement the three pure validation functions.
 * They are unit-tested by the autograder (tests/UnitTest.php).
 */

function validate_required(string $v): bool
{
    return trim($v) !== '';
}

function validate_email(string $v): bool
{
    return filter_var($v, FILTER_VALIDATE_EMAIL) !== false;
}

function validate_length(string $v, int $min, int $max): bool
{
    $len = mb_strlen($v);
    return $len >= $min && $len <= $max;
}
