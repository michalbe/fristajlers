<?php
class Template {
    var $tmpl;
    var $dane;

    function Template ($name)
    {
        $this->tmpl = implode('', file($name));
        $this->dane = Array();
    }

    function add($name, $value = '')
    {
        if (is_array($name)) {
            $this->dane = array_merge($this->dane, $name);
        } else if (!empty($value)) {
            $this->dane[$name] = $value;
        }
    }

    function execute() {
        return preg_replace('/{([^}]+)}/e', '$this->dane["\\1"]',
                $this->tmpl);
    }
}


?>