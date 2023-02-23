<?php
namespace Makaroni\Core\Validation;

class Validation
{

    /**
     * @var array $patterns
     */
    private $patterns = array(
        'uri' => '[A-Za-z0-9-\/_?&=]+',
        'url' => '[A-Za-z0-9-:.\/_?&=#]+',
        'string' => '[\p{L}]+',
        'words' => '[\p{L}\s]+',
        'strnum' => '[\p{L}]+|[0-9]+',
        'alphanum' => '[\p{L}0-9]+',
        'int' => '[0-9]+',
        'float' => '[0-9\.,]+',
        'tel' => '[0-9+\s()-]+',
        'text' => '[\p{L}0-9\s-.,;:!"%&()?+\'°#\/@]+',
        'file' => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+\.[A-Za-z0-9]{2,4}',
        'folder' => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+',
        'address' => '[\p{L}0-9\s.,()°-]+',
        'date_dmy' => '[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4}',
        'date_ymd' => '[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}',
        'email' => '[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+[.]+[a-z-A-Z]',
        'password' => '(?=.*\d).{4,15}',
        'phone_number' => '[0-9]+',
    );

    /**
     * @var array $errors
     */
    private $errors = array();

    private function name($name)
    {

        $this->name = $name;
        return $this;

    }

    private function value($value)
    {

        $this->value = $value;
        return $this;

    }

    private function file($value)
    {

        $this->file = $value;
        return $this;

    }

    private function pattern($name)
    {

        if ($name == 'array') {

            if (!is_array($this->value)) {
                $this->errors[] = 'Format ' . $this->name . ' is not valid.';
            }

        } else {

            $regex = '/^(' . $this->patterns[$name] . ')$/u';
            if ($this->value != '' && !preg_match($regex, $this->value)) {
                $this->errors[] = 'Format ' . $this->name . ' is not valid.';

            }

        }
        return $this;

    }

    private function customPattern($pattern)
    {

        $regex = '/^(' . $pattern . ')$/u';
        if ($this->value != '' && !preg_match($regex, $this->value)) {
            $this->errors[] = 'Format ' . $this->name . ' is not valid.';

        }
        return $this;

    }

    private function required()
    {

        if ((isset($this->file) && $this->file['error'] == 4) || ($this->value == '' || $this->value == null)) {
            $this->errors[] = 'The ' . $this->name . ' is required.';
        }
        return $this;

    }

    private function min($length)
    {

        if (is_string($this->value)) {

            if (strlen($this->value) < $length) {
                $this->errors[] = 'Field value ' . $this->name . ' less than the minimum value';
            }

        } else {

            if ($this->value < $length) {
                $this->errors[] = 'Field value ' . $this->name . ' less than the minimum value';
            }

        }
        return $this;

    }

    private function max($length)
    {

        if (is_string($this->value)) {

            if (strlen($this->value) > $length) {
                $this->errors[] = 'Field value ' . $this->name . ' greater than the maximum value';
            }

        } else {

            if ($this->value > $length) {
                $this->errors[] = 'Field value ' . $this->name . ' greater than the maximum value';
            }

        }
        return $this;

    }

    private function equal($value)
    {

        if ($this->value != $value) {
            $this->errors[] = 'Field value ' . $this->name . ' does not match.';
        }
        return $this;

    }

    private function maxSize($size)
    {

        if ($this->file['error'] != 4 && $this->file['size'] > $size) {
            $this->errors[] = 'The file ' . $this->name . ' exceeds the maximum size of ' . number_format($size / 1048576, 2) . 'MB.';
        }
        return $this;

    }

    private function ext($extension)
    {

        if ($this->file['error'] != 4 && pathinfo($this->file['name'], PATHINFO_EXTENSION) != $extension && strtoupper(pathinfo($this->file['name'], PATHINFO_EXTENSION)) != $extension) {
            $this->errors[] = 'The file ' . $this->name . ' it`s not a  ' . $extension . '.';
        }
        return $this;

    }

    private function purify($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    private function isSuccess()
    {
        if (empty($this->errors)) {
            return true;
        }

    }

    private function getErrors()
    {
        if (!$this->isSuccess()) {
            return $this->errors;
        }

    }

    private function displayErrors()
    {

        $html = '<ul>';
        foreach ($this->getErrors() as $error) {
            $html .= '<li>' . $error . '</li>';
        }
        $html .= '</ul>';

        return $html;

    }

    private function result()
    {

        if (!$this->isSuccess()) {

            foreach ($this->getErrors() as $error) {
                echo "$error\n";
            }
            exit;

        } else {
            return true;
        }

    }

    private static function is_int($value)
    {
        if (filter_var($value, FILTER_VALIDATE_INT)) {
            return true;
        }

    }

    private static function is_float($value)
    {
        if (filter_var($value, FILTER_VALIDATE_FLOAT)) {
            return true;
        }

    }

    private static function is_alpha($value)
    {
        if (filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z]+$/")))) {
            return true;
        }

    }

    private static function is_alphanum($value)
    {
        if (filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z0-9]+$/")))) {
            return true;
        }

    }

    private static function is_url($value)
    {
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return true;
        }

    }

    private static function is_uri($value)
    {
        if (filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[A-Za-z0-9-\/_]+$/")))) {
            return true;
        }

    }

    private static function is_bool($value)
    {
        if (is_bool(filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))) {
            return true;
        }

    }

    private static function is_email($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

    }

    public function validate(array $rules): void
    {
        foreach ($rules as $rule) {

            $name = $rule[0];
            $value = $rule[1];
            $pattern = $rule[2];

            $this->name($name)->value($value)->pattern($pattern)->required();

        }
        if (!$this->isSuccess()) {
            exit($this->displayErrors());
        }
    }

}
