<?php
declare(strict_types=1);

namespace Framework\Identity\Tables;

use Framework\Identity\IdentityUser;
use ReflectionClass;
use ReflectionProperty;

/**
 * Class ApplicationUser
 * @package Framework\Identity\Tables
 * @Table users
 */
final class ApplicationUser extends IdentityUser
{
    /**
     * @Field fullname
     * @Type NVARCHAR
     * @Length 255
     * @Null
     */
    private $fullName;

    /**
     * User constructor.
     * @param $username
     * @param $pass
     * @param $id
     * @param $fullName
     */
    public function __construct(string $username = null, string $pass = null, string $fullName = null, int $id = null) {
        parent::__construct($username, $pass, $id);
        $this->setFullName($fullName);
    }

    /**
     * @return mixed
     */
    function getFullName() : string
    {
        if ($this->fullName !== null) {
            return $this->fullName;
        }

        return '';
    }

    /**
     * @param $fullName
     * @return ApplicationUser
     */
    private function setFullName(string $fullName) : \Framework\Identity\Tables\ApplicationUser
    {
        $this->fullName = $fullName;
        return $this;
    }

//    function getVars()
//    {
//        $reflection = new ReflectionClass($this);
//        $vars = $reflection->getProperties(ReflectionProperty::IS_PRIVATE);
//        var_dump($vars);
//    }

//    public function getProperties() : array {
//        $properties = array();
//        try {
//            $rc = new \ReflectionClass($this);
//            do {
//                $rp = array();
//                /* @var $p \ReflectionProperty */
//                foreach ($rc->getProperties() as $p) {
//                    $p->setAccessible(true);
//                    $rp[$p->getName()] = $p->getValue($this);
//
//
//                }
//                $properties = array_merge($rp, $properties);
//            } while ($rc = $rc->getParentClass());
//        } catch (\ReflectionException $e) { }
//        return $properties;
//    }
//
//    public function getProperties() : array {
//        $properties = array();
//        try {
//            $rc = new \ReflectionClass($this);
//            do {
//                $rp = array();
//                /* @var $p \ReflectionProperty */
//                foreach ($rc->getProperties() as $p) {
//                    $p->setAccessible(true);
//                    $rp[$p->getName()] = $p->getValue($this);
//
//                    if ($p->getDocComment() && preg_match('/@Column\s*([^\n*]+)/', $p->getDocComment(), $matches)) {
//                        var_dump(json_decode($matches[1]));
//                    }
//                }
//
//                $properties = array_merge($rp, $properties);
//            } while ($rc = $rc->getParentClass());
//        } catch (\ReflectionException $e) { }
//        return $properties;
//    }
}