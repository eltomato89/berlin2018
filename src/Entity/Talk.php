<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DoctrineTalkRepository")
 * @ORM\Table(name="talks")
 */
class Talk
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $speaker;

    public static function create(string $title, string $speaker): Talk
    {
        $talk = new static();
        $talk->id = Uuid::uuid4()->toString();
        $talk->setTitle($title);
        $talk->setSpeaker($speaker);

        return $talk;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getSpeaker(): string
    {
        return $this->speaker;
    }

    /**
     * @param string $speaker
     */
    public function setSpeaker(string $speaker): void
    {
        $this->speaker = $speaker;
    }
}
