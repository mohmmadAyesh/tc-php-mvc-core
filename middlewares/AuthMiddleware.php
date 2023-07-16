<?php

namespace tco\phpmvc\middlewares;

use tco\phpmvc\Application;
use tco\phpmvc\exception\ForbiddenException;

// use tco\phpmvc\exception\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{
    public array $actions = [];
    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }
    public function execute()
    {
        if (Application::isGuest()) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                throw new \tco\phpmvc\exception\ForbiddenException();
            }
        }
    }
}
