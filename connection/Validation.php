<?php

/**
 * Validation 
 *
 * Simple PHP class for validation.
 *
 * @author Davide Cesarano <davide.cesarano@unipegaso.it>
 * @copyright (c) 2016, Davide Cesarano
 * @license https://github.com/davidecesarano/Validation/blob/master/LICENSE MIT License
 * @link https://github.com/davidecesarano/Validation
 */

class Validation
{

    /**
     * @var array $patterns
     */
    public $patterns = array(
        'uri'           => '[A-Za-z0-9-\/_?&=]+',
        'url'           => '[A-Za-z0-9-:.\/_?&=#]+',
        'alpha'         => '[\p{L}]+',
        'words'         => '[\p{L}\s]+',
        'alphanum'      => '[\p{L}0-9]+',
        'int'           => '[0-9]+',
        'float'         => '[0-9\.,]+',
        'tel'           => '[0-9+\s()-]+',
        'text'          => '[\p{L}0-9\s-.,;:!"%&()?+\'°#\/@]+',
        'file'          => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+\.[A-Za-z0-9]{2,4}',
        'folder'        => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+',
        'address'       => '[\p{L}0-9\s.,()°-]+',
        'date_dmy'      => '[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4}',
        'date_ymd'      => '[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}',
        'email'         => '[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+[.]+[a-z-A-Z]'
    );

    /**
     * @var array $errors
     */
    public $errors = array();

    /**
     * Field name
     * 
     * @param string $name
     * @return this
     */
    public function name($name)
    {

        $this->name = $name;
        return $this;
    }

    /**
     * Field value
     * 
     * @param mixed $value
     * @return this
     */
    public function value($value)
    {

        $this->value = $value;
        return $this;
    }

    /**
     * File
     * 
     * @param mixed $value
     * @return this
     */
    public function file($value)
    {

        $this->file = $value;
        return $this;
    }

    /**
     * Pattern to apply for regex recognition
     * 
     * @param string $name pattern name
     * @return this
     */
    public function pattern($name)
    {

        if ($name == 'array') {

            if (!is_array($this->value)) {
                $this->errors[] = 'Field format ' . $this->name . ' invalid.';
            }
        } else {

            $regex = '/^(' . $this->patterns[$name] . ')$/u';
            if ($this->value != '' && !preg_match($regex, $this->value)) {
                $this->errors[] = 'Field format ' . $this->name . ' invalid.';
            }
        }
        return $this;
    }

    /**
     * Custom pattern
     * 
     * @param string $pattern
     * @return this
     */
    public function customPattern($pattern)
    {

        $regex = '/^(' . $pattern . ')$/u';
        if ($this->value != '' && !preg_match($regex, $this->value)) {
            $this->errors[] = 'Field format ' . $this->name . ' invalid.';
        }
        return $this;
    }

    /**
     * Required field
     * 
     * @return this
     */
    public function required()
    {

        if ((isset($this->file) && $this->file['error'] == 4) || ($this->value == '' || $this->value == null)) {
            $this->errors[] = 'Field ' . $this->name . ' required.';
        }
        return $this;
    }

    /**
     * Minimum length of the field value
     * 
     * @param int $min
     * @return this
     */
    public function min($length)
    {

        if (is_string($this->value)) {

            if (strlen($this->value) < $length) {
                $this->errors[] = 'Field value ' . $this->name . ' less than minimum value';
            }
        } else {

            if ($this->value < $length) {
                $this->errors[] = 'Field value ' . $this->name . ' less than minimum value';
            }
        }
        return $this;
    }

    /**
     * Maximum length of the field value
     * 
     * @param int $max
     * @return this
     */
    public function max($length)
    {

        if (is_string($this->value)) {

            if (strlen($this->value) > $length) {
                $this->errors[] = 'Field value ' . $this->name . ' greater than maximum value';
            }
        } else {

            if ($this->value > $length) {
                $this->errors[] = 'Field value ' . $this->name . ' greater than maximum value';
            }
        }
        return $this;
    }

    /**
     * Compare with the value of
     * another field
     * 
     * @param mixed $value
     * @return this
     */
    public function equal($value)
    {

        if ($this->value != $value) {
            $this->errors[] = 'Field value ' . $this->name . ' not matching.';
        }
        return $this;
    }

    /**
     * Maximum file size 
     *
     * @param int $size
     * @return this 
     */
    public function maxSize($size)
    {

        if ($this->file['error'] != 4 && $this->file['size'] > $size) {
            $this->errors[] = 'The file ' . $this->name . ' exceeds the maximum size of ' . number_format($size / 1048576, 2) . ' MB.';
        }
        return $this;
    }

    /**
     * File extension (format)
     *
     * @param string $extension
     * @return this 
     */
    public function ext($extension)
    {

        if ($this->file['error'] != 4 && pathinfo($this->file['name'], PATHINFO_EXTENSION) != $extension && strtoupper(pathinfo($this->file['name'], PATHINFO_EXTENSION)) != $extension) {
            $this->errors[] = 'The file ' . $this->name . ' is not a ' . $extension . '.';
        }
        return $this;
    }

    /**
     * Purify to prevent XSS attacks
     *
     * @param string $string
     * @return $string
     */
    public function purify($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Validated fields
     * 
     * @return boolean
     */
    public function isSuccess()
    {
        if (empty($this->errors)) return true;
    }

    /**
     * Validation errors
     * 
     * @return array $this->errors
     */
    public function getErrors()
    {
        if (!$this->isSuccess()) return $this->errors;
    }

    /**
     * Display errors in Html format
     * 
     * @return string $html
     */
    public function displayErrors()
    {

        $html = '<ul>';
        foreach ($this->getErrors() as $error) {
            $html .= '<li>' . $error . '</li>';
        }
        $html .= '</ul>';

        return $html;
    }

    /**
     * Display validation result
     *
     * @return booelan|string
     */
    public function result()
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

    /**
     * Check if the value is
     * an integer
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_int($value)
    {
        if (filter_var($value, FILTER_VALIDATE_INT)) return true;
    }

    /**
     * Check if the value is
     * a float number
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_float($value)
    {
        if (filter_var($value, FILTER_VALIDATE_FLOAT)) return true;
    }

    /**
     * Check if the value is
     * an alphabet letter
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_alpha($value)
    {
        if (filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z]+$/")))) return true;
    }

    /**
     * Check if the value is
     * an alphabet letter or a number
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_alphanum($value)
    {
        if (filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z0-9]+$/")))) return true;
    }

    /**
     * Check if the value is
     * a url
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_url($value)
    {
        if (filter_var($value, FILTER_VALIDATE_URL)) return true;
    }

    /**
     * Check if the value is
     * a uri
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_uri($value)
    {
        if (filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[A-Za-z0-9-\/_]+$/")))) return true;
    }

    /**
     * Check if the value is
     * true or false
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_bool($value)
    {
        if (is_bool(filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))) return true;
    }

    /**
     * Check if the value is
     * an email
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_email($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) return true;
    }
}
