<?php

if (!function_exists('required')) {
    function required($value, $fieldName)
    {
        if ($value === '') {
            return "{$fieldName} is required";
        }

        return '';
    }
}

if (!function_exists('is_valid_url')) {
    function is_valid_url($url, $fieldName)
    {
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            return "{$fieldName} is not valid url";
        }

        return '';
    }
}

if (!function_exists('min_length')) {
    function min_length($value, $fieldName, $minLength)
    {
        if (strlen($value) < $minLength) {
            return "{$fieldName} must be at least {$minLength} characters";
        }

        return '';
    }
}

if (!function_exists('max_length')) {
    function max_length($value, $fieldName, $maxLength)
    {
        if (strlen($value) > $maxLength) {
            return "{$fieldName} must be at most {$maxLength} characters";
        }

        return '';
    }
}

if (!function_exists('min_value')) {
    function min_value($value, $fieldName, $min)
    {
        if($value < $min){
            return "{$fieldName} must be at least {$min}";
        }

        return '';
    }
}

if(!function_exists('form_validation')) {
    function form_validation($inputs, $rules) 
    {
        $errors = [];

        foreach($inputs as $fieldInput => $input){
            foreach ($rules[$fieldInput] as $rule) {
                if (strpos($rule, ':')) {
                    [$rule, $argument] = explode(':', $rule);

                    $error = call_user_func($rule, $input, $fieldInput, $argument);
                } else {
                    $error = call_user_func($rule, $input, $fieldInput); 
                }

               if($error !== ''){
                    $errors[$fieldInput][] = $error;
               }
            }
        }

        return $errors;
    }   
}