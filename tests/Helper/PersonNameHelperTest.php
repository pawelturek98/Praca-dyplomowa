<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use App\Helper\PersonNameHelper;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PersonNameHelperTest extends KernelTestCase
{
    private Generator $faker;

    public function setUp(): void
    {
        $this->faker = Factory::create();
    }

    public function testJustFirstName()
    {
        $expectedFirstname = $this->faker->firstName();
        $expectedLastname = '';
        $name = sprintf('%s', $expectedFirstname);

        $this->assertEquals(
            ['firstname' => $expectedFirstname, 'lastname' => $expectedLastname],
            PersonNameHelper::getPersonFullName($name)
        );
    }

    public function testFirstAndLastName()
    {
        $expectedFirstname = $this->faker->firstName();
        $expectedLastname = $this->faker->lastName();
        $name = sprintf('%s %s', $expectedFirstname, $expectedLastname);

        $this->assertEquals(
            ['firstname' => $expectedFirstname, 'lastname' => $expectedLastname],
            PersonNameHelper::getPersonFullName($name)
        );
    }

    public function testLongName()
    {
        $expectedFirstname = $this->faker->firstName();
        $expectedLastname = $this->faker->lastName();
        $expectedSecondLastname = $this->faker->lastName();
        $expectedThirdLastname = $this->faker->lastName();
        $name = sprintf(
            '%s %s %s %s',
            $expectedFirstname,
            $expectedLastname,
            $expectedSecondLastname,
            $expectedThirdLastname
        );

        $expectedLastname = sprintf(
            '%s %s %s',
            $expectedLastname,
            $expectedSecondLastname,
            $expectedThirdLastname
        );

        $this->assertEquals(
            ['firstname' => $expectedFirstname, 'lastname' => $expectedLastname],
            PersonNameHelper::getPersonFullName($name)
        );
    }
}
