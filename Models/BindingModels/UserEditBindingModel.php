<?php
declare(strict_types=1);

namespace Framework\Models\BindingModels;

class UserEditBindingModel
{
    /**
     * @Required
     * @MinLength(2)
     * @MaxLength(30)
     * @Display(Full Name)
     */
    private $fullName;

    /**
     * @return string
     */
    public function getFullName() : string {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName(string $fullName) {
        $this->fullName = $fullName;
    }
}