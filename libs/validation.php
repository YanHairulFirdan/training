<?php

if (!function_exists('required')) {
    function required($value)
    {
        return $value != '';
    }
}

if (!function_exists('is_valid_url')) {
    function is_valid_url($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }
}

if (!function_exists('min_length')) {
    function min_length($value, $minLength)
    {
        return strlen($value) >= $minLength;
    }
}

if (!function_exists('max_length')) {
    function max_length($value, $maxLength)
    {
        return strlen($value) <= $maxLength;
    }
}

if (!function_exists('min_value')) {
    function min_value($value, $min)
    {
        return $value >= $min;
    }
}

if (!function_exists('form_validation')) {
    function form_validation($inputs, $validators)
    {
        $errors = [];

        foreach ($inputs as $fieldname => $input) {
            foreach ($validators[$fieldname] as $rule) {
                try {
                    if (str_contains($rule, ':')) {
                        [$ruleName, $ruleArgs] = explode(':', $rule);
                        $errorMessage = call_user_func_array($ruleName, [$fieldname, $input, $ruleArgs]);
                    } else {
                        $errorMessage = call_user_func_array($rule, [$fieldname, $input]);
                    }
                } catch (\Throwable $th) {
                    throw $th;
                }

                if ($errorMessage !== '') {
                    $errors[$fieldname][] = $errorMessage;
                }
            }
        }

        return $errors;
    }
}
