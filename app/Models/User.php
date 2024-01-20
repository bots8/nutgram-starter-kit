<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    public int|null $id = null;

    /**
     * @ORM\Column(type="string")
     */
    public string $telegramId;
    
    /**
     * @ORM\Column(type="string")
     */
    public string $username;
    
    /**
     * @ORM\Column(type="string")
     */
    public string $name;

    public function getId(): int|null
    {
        return $this->id;
    }
}