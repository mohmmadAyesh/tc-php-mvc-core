<?php

namespace tco\phpmvc;

use tco\phpmvc\db\DBModel;

abstract class UserModel extends DBModel
{
    abstract public function getDisplayName(): string;
}
