<?php

namespace Modules\Common\Transformers;

use Illuminate\Support\Collection;

class TransformerResult
{
    /**
     * The transformed data array.
     *
     * @var array
     */
    protected array $data;

    /**
     * The original model instance, if provided.
     *
     * @var object|null
     */
    protected ?object $model;

    /**
     * TransformerResult constructor.
     *
     * @param array       $data  The transformed data.
     * @param object|null $model The original model instance (optional).
     */
    public function __construct(array $data, ?object $model = null)
    {
        $this->data = $data;
        $this->model = $model;
    }

    /**
     * Get transformed data as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * Get transformed data as a collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function toCollection(): Collection
    {
        return collect($this->data);
    }

    /**
     * Get transformed data as an object.
     *
     * @return object
     */
    public function toObject(): object
    {
        return (object) $this->data;
    }

    /**
     * Get the original model instance.
     *
     * @return object|null
     */
    public function getModel(): ?object
    {
        return $this->model;
    }

    /**
     * Alias for getModel(), matches "toX" naming convention.
     *
     * @return object|null
     */
    public function toModel(): ?object
    {
        return $this->getModel();
    }

    /**
     * Get transformed data as JSON.
     *
     * @param int $options JSON encoding options.
     * @return string
     */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->data, $options);
    }

    /**
     * Magic method to return pretty JSON when object is echoed or cast to string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson(JSON_PRETTY_PRINT);
    }
}