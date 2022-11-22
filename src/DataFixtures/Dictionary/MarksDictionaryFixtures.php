<?php

declare(strict_types=1);

namespace App\DataFixtures\Dictionary;

use App\DataFixtures\AppFixtures;
use App\Entity\Dictionary\MarksDictionary;
use Doctrine\Persistence\ObjectManager;

class MarksDictionaryFixtures extends AppFixtures
{
    private const DATA = [
        ['name' => 'Niedostateczny', 'position' => 0, 'importance' => 1],
        ['name' => 'Dostateczny', 'position' => 1, 'importance' => 3],
        ['name' => 'Dobry', 'position' => 2, 'importance' => 4],
        ['name' => 'Bardzo dobry', 'position' => 3, 'importance' => 5],
        ['name' => 'Celujący', 'position' => 4, 'importance' => 6],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $mark) {
            $this->createMark($manager, $mark['name'], $mark['position'], $mark['importance']);
        }

        $manager->flush();
    }

    public function createMark(ObjectManager $manager, string $name, int $position, int $importance): void
    {
        $mark = (new MarksDictionary())
            ->setName($name)
            ->setPosition($position)
            ->setImportance($importance)
        ;

        $manager->persist($mark);
    }
}
