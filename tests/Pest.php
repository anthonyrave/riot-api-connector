<?php

use Tests\TestCase;

uses(TestCase::class)->in('../packages/anthonyrave/riot-api-connector/tests/Unit');

/**
 * @throws ReflectionException
 */
function callMethod($obj, $name, $args = [])
{
    $class = new ReflectionClass($obj);
    $method = $class->getMethod($name);

    return $method->invokeArgs($obj, $args);
}
