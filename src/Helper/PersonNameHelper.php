<?php

declare(strict_types=1);

namespace App\Helper;

class PersonNameHelper
{
    public static function getPersonFullName(string $name): array
    {
        $firstname = '';
        $lastname = '';

        $explodedName = explode(' ', $name);

        if (count($explodedName) === 1) {
            $firstname = $explodedName[0];
        }

        if (count($explodedName) === 2) {
            [$firstname, $lastname] = $explodedName;
        }

        if (count($explodedName) > 2) {
            $firstname = $explodedName[0];

            array_shift($explodedName);
            $lastname = implode(' ', $explodedName);
        }

        return [
            'firstname' => $firstname,
            'lastname' => $lastname,
        ];
    }
}
