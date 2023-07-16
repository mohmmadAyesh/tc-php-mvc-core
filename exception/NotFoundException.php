<?php

namespace tco\phpmvc\exception;

class NotFoundException extends \Exception
{
   protected $code = 404;
   protected $message = 'Page not found';
}
