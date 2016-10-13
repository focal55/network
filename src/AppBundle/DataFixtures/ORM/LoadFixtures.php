<?php
/**
 * Created by PhpStorm.
 * User: ybarra
 * Date: 10/13/16
 * Time: 4:05 PM
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadFixtures implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    Fixtures::load(__DIR__ . '/fixtures.yml', $manager);
  }
}