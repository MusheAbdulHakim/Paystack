<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\ValueObjects;

use MusheAbdulHakim\Paystack\Contracts\StringableContract;

/**
 * @internal
 */
final readonly class ResourceUri implements StringableContract
{
    /**
     * Creates a new ResourceUri value object.
     */
    private function __construct(private string $uri)
    {
        // ..
    }

    /**
     * Creates a new ResourceUri value object that creates the given resource.
     */
    public static function create(string $resource): self
    {
        return new self($resource);
    }

    /**
     * Creates a new ResourceUri value object that uploads to the given resource.
     */
    public static function upload(string $resource): self
    {
        return new self($resource);
    }

    /**
     * Creates a new ResourceUri value object that lists the given resource.
     */
    public static function list(string $resource): self
    {
        return new self($resource);
    }

    /**
     * Creates a new ResourceUri value object that retrieves the given resource.
     */
    public static function retrieve(string $resource, string $id, string $suffix): self
    {
        return new self("$resource/$id.$suffix");
    }

    /**
     * Creates a new ResourceUri value object that retrieves the given resource.
     */
    public static function get(string $resource): self
    {
        return new self("$resource");
    }

    /**
     * Creates a new ResourceUri value object that modifies the given resource.
     */
    public static function modify(string $resource, string $id): self
    {
        return new self("$resource/$id");
    }

    /**
     * Creates a new ResourceUri value object that retrieves the given resource content.
     */
    public static function retrieveContent(string $resource, string $id): self
    {
        return new self("$resource/$id/content");
    }

    /**
     * Creates a new ResourceUri value object that deletes the given resource.
     */
    public static function delete(string $resource, string $id): self
    {
        return new self("$resource/$id");
    }

    /**
     * {@inheritDoc}
     */
    public function toString(): string
    {
        return $this->uri;
    }
}
