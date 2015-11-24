<?php
declare(strict_types=1);

namespace Framework\Config;

class AppConfig
{
    const DEFAULT_CONTROLLER = 'home';
    const DEFAULT_ACTION = 'home';
    const DEFAULT_LAYOUT = 'default';
    const DEFAULT_VIEW = 'home';
    const DEFAULT_REDIRECTION = '';

    const DEFAULT_USER_IDENTITY = 'ApplicationUser';
    const DEFAULT_REGISTRATION_ROLE = 'User';
    CONST DEFAULT_ADMIN_ROLE = "Admin";

    const VIEW_FOLDER = 'Views';
    const LAYOUT_FOLDER = 'layouts';
    const VIEW_EXTENSION = '.php';

    const CONTROLLERS_NAMESPACE = 'Framework\\Controllers\\';
    const CONTROLLERS_SUFFIX = 'Controller';

    const ANNOTATIONS_NAMESPACE = 'Framework\\Annotations\\';
    const ANNOTATIONS_SUFFIX = 'Annotation';
}