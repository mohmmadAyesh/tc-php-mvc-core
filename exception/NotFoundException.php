<?php

namespace app\Core\exception;

class NotFoundException extends \Exception
{
   protected $code=404;
   protected $message='Page not found';
}
