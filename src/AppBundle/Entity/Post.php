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
 * @ORM\Table(name="post")
 */
class Post {
  /**
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="integer")
   */
  private $uid;

  /**
   * @ORM\Column(type="string")
   */
  private $title;

  /**
   * @ORM\Column(type="text", nullable=true)
   */
  private $body;


  /**
   * @ORM\Column(type="integer")
   */
  private $created;

  /**
   * @ORM\Column(type="integer")
   */
  private $updated;

  /**
   * Get id
   *
   * @return integer
   */
  public function getId()
  {
      return $this->id;
  }

  /**
   * Set uid
   *
   * @param integer $uid
   *
   * @return Post
   */
  public function setUid($uid)
  {
      $this->uid = $uid;

      return $this;
  }

  /**
   * Get uid
   *
   * @return integer
   */
  public function getUid()
  {
      return $this->uid;
  }

  /**
   * Set title
   *
   * @param string $title
   *
   * @return Post
   */
  public function setTitle($title)
  {
      $this->title = $title;

      return $this;
  }

  /**
   * Get title
   *
   * @return string
   */
  public function getTitle()
  {
      return $this->title;
  }

  /**
   * Set body
   *
   * @param string $body
   *
   * @return Post
   */
  public function setBody($body)
  {
      $this->body = $body;

      return $this;
  }

  /**
   * Get body
   *
   * @return string
   */
  public function getBody()
  {
      return $this->body;
  }

  /**
   * Set created
   *
   * @param integer $created
   *
   * @return Post
   */
  public function setCreated($created)
  {
      $this->created = $created;

      return $this;
  }

  /**
   * Get created
   *
   * @return integer
   */
  public function getCreated()
  {
      return $this->created;
  }

  /**
   * Set updated
   *
   * @param integer $updated
   *
   * @return Post
   */
  public function setUpdated($updated)
  {
      $this->updated = $updated;

      return $this;
  }

  /**
   * Get updated
   *
   * @return integer
   */
  public function getUpdated()
  {
      return $this->updated;
  }
}
