<?php

namespace App\Helpers;

class Validate
{
    private $db;
    private $errors = [];
    private $passed = false;
    private $recordId;
    private $source = [];

    public function __construct(array $source, $recordId = null)
    {
        $this->db = Database::getInstance();
        $this->recordId = $recordId;
        $this->source = $source;
    }

    private function addError($input, $error)
    {
        $this->errors[$input][] = str_replace(['-', '_'], ' ', ucfirst(strtolower($error)));
    }

    public function check(array $inputs)
    {
        $this->errors = [];
        $this->passed = false;
        foreach ($inputs as $input => $rules) {
            if (isset($this->source[$input])) {
                $value = trim($this->source[$input]);
                $this->validate($input, $value, $rules);
            } else {
                $this->addError($input, 'Unable to validate ' . $input);
            }
        }

        if (empty($this->errors)) {
            $this->passed = true;
        }

        return $this;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function passed(): bool
    {
        return $this->passed;
    }

    private function validate($input, $value, array $rules)
    {
        foreach ($rules as $rule => $ruleValue) {
            if (($rule === "required" && $ruleValue === true) && empty($value)) {
                $this->addError($input, $input . ' is required!');
            } elseif (!empty($value)) {
                $methodName = lcfirst(strtolower(str_replace(["-", "_"], "", $rule))) . "Rule";
                if (method_exists($this, $methodName)) {
                    $this->{$methodName}($input, $value, $ruleValue);
                } else {
                    $this->addError($input, 'Unable to validate' . $input);
                }
            }
        }
    }

    protected function filterRule($input, $value, $ruleValue)
    {
        switch ($ruleValue) {
            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($input, $input . ' is not a valid ' . $ruleValue);
                }
                break;
        }
    }

    protected function matchesRule($input, $value, $ruleValue)
    {
        if ($value != $this->source[$ruleValue]) {
            $this->addError($input, $input . ' must match ' . $ruleValue);
        }
    }

    protected function maxCharactersRule($input, $value, $ruleValue)
    {
        if (\strlen($value) > $ruleValue) {
            $this->addError($input, $input . ' can only be a maximum of ' . $ruleValue . ' characters.');
        }
    }

    protected function minCharactersRule($input, $value, $ruleValue)
    {
        if (strlen($value) < $ruleValue) {
            $this->addError($input, $input . ' must be a minimum of ' . $ruleValue . ' characters.');
        }
    }

    protected function requiredRule($input, $value, $ruleValue)
    {
        if ($ruleValue === true && empty($value)) {
            $this->addError($input, $input . '  is required!');
        }
    }

    protected function uniqueRule($input, $value, $ruleValue)
    {
        $check = $this->db->select($ruleValue, [$input, "=", $value]);
        if ($check->count()) {
            if ($this->recordId && $check->first()->id === $this->recordId) {
                return;
            }

            $this->addError($input, $input . ' already exists.');
        }
    }
}
