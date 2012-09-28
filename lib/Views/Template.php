<?php
define('TEMPLATE_DIR', '/app/Views/Templates/');

class Template
{
   public $path;
   public $template;

   public function __construct($template)
   {
      $this->template = $template.'.php';
      $this->path  = $_SERVER['DOCUMENT_ROOT'].TEMPLATE_DIR;
   }

   function __destruct()
   {
      $this->_display();
   }

   protected function _display()
   {
      require_once($this->path.$this->template);
   }
}
