<?php
/**
 * Created by PhpStorm.
 * User: ybarra
 * Date: 10/13/16
 * Time: 1:20 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User {
  /**
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string")
   */
  private $name;

  /**
   * @ORM\Column(type="string")
   */
  private $password;

  /**
   * @ORM\Column(type="string")
   */
  private $email;

  /**
   * @ORM\Column(type="integer")
   */
  private $access;

  /**
   * @ORM\Column(type="integer")
   */
  private $created;

  /**
   * @ORM\Column(type="integer")
   */
  private $last_login;
}