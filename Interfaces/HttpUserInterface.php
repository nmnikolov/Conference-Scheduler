<?php

namespace Framework\Interfaces;

use Framework\Models\ViewModels\UserProfileViewModel;

interface HttpUserInterface
{
    function isLogged() : bool;
    function isAdmin() : bool;
    function getCurrentUser() : UserProfileViewModel;
    function setCurrentUser();
    function logout();
}