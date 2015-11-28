<?php
declare(strict_types=1);

namespace Framework\Models\BindingModels;

class ChangeRoleBindingModel
{
    /**
     * @Required
     * @Display(New role)
     */
    private $newRole;

    /**
     * @return string
     */
    public function getNewRole() : string {
        return $this->newRole;
    }

    /**
     * @param string $newRole
     */
    public function setNewRole(string $newRole) {
        $this->newRole = $newRole;
    }
}