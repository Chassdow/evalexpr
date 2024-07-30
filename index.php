<?php

function eval_expr(string $expr)
{
    $expr = str_replace("--", "+", $expr);
    $tokens = tokenize($expr);
    $result = evaluate($tokens);
    return $result;
}

function tokenize($expr)
{
    $tokens = [];
    $number = '';
    $length = strlen($expr);

    for ($i = 0; $i < $length; $i++) {
        $char = $expr[$i];

        if (is_numeric($char) || $char == '.') {
            $number .= $char;
        } else {
            if ($number !== '') {
                $tokens[] = $number;
                $number = '';
            }
            $tokens[] = $char;
        }
    }

    if ($number !== '') {
        $tokens[] = $number;
    }

    return $tokens;
}

function evaluate($tokens)
{
    $tokens = firstoperation($tokens);
    return secondoperation($tokens);
}

function firstoperation($tokens)
{
    $result = [];
    $length = count($tokens);
    
    for ($i = 0; $i < $length; $i++) {
        $token = $tokens[$i];

        if ($token == '*' || $token == '/' || $token == '%') {
            $prev = array_pop($result);
            $next = $tokens[++$i];

            switch ($token) {
                case '*':
                    $result[] = $prev * $next;
                    break;
                case '/':
                    $result[] = $prev / $next;
                    break;
                case '%':
                    $result[] = $prev % $next;
                    break;
            }
        } else {
            $result[] = $token;
        }
    }

    return $result;
}

function secondoperation($tokens)
{
    $result = $tokens[0];
    $length = count($tokens);

    for ($i = 1; $i < $length; $i++) {
        $token = $tokens[$i];

        if ($token == '+' || $token == '-') {
            $next = $tokens[++$i];

            switch ($token) {
                case '+':
                    $result += $next;
                    break;
                case '-':
                    $result -= $next;
                    break;
            }
        }
    }

    return $result;
}
