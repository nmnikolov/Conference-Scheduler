<?php
declare(strict_types=1);

namespace Framework\Identity\Tables;

/**
 * Class Role
 * @package Framework\Identity\Tables
 * @Table roles
 */
final class Role
{
    /**
     * @Field id
     * @Type INT
     * @Length 11
     * @Primary
     * @Increment
     */
    protected $id;

    /**
     * @Field name
     * @Type NVARCHAR
     * @Length 255
     * @Unique
     */
    private $name;

    public function __construct(string $name) {
        $this->setName($name);
    }

    /**
     * @return mixed
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Role
     */
    public function setName(string $name) {
        $this->name = $name;
        return $this;
    }
}