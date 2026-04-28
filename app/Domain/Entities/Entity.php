<?php

declare(strict_types=1);

namespace App\Domain\Entities;

/**
 * Base abstract class for all domain objects that require a unique identity.
 */
abstract class Entity
{
    public function __construct(
        protected ?int $id = null
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
