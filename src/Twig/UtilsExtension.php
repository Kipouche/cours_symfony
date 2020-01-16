<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class UtilsExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_class', [$this, 'getClass']),
            new TwigFunction('is_date', [$this, 'isDate']),
            new TwigFunction('is_datetime', [$this, 'isDatetime']),
            new TwigFunction('is_string', [$this, 'isString']),
            new TwigFunction('is_int', [$this, 'isInt']),
            new TwigFunction('is_float', [$this, 'isFloat']),
            new TwigFunction('is_bool', [$this, 'isBool']),
            new TwigFunction('is_array', [$this, 'isArray']),
        ];
    }

    public function getClass($value): string
    {
        return get_class($value);
    }

    public function isDate($value): bool
    {
        if($value instanceof \DateTime){
            return $value->format("H:i:s") == "00:00:00";
        }
        return false;
    }

    public function isDatetime($value): bool
    {
        if($value instanceof \DateTime){
            return $value->format("H:i:s") != "00:00:00";
        }
        return false;
    }

    public function isString($value): bool
    {
        return is_string($value);
    }

    public function isInt($value): bool
    {
        return is_int($value);
    }

    public function isFloat($value): bool
    {
        return is_float($value);
    }

    public function isBool($value): bool
    {
        return is_bool($value);
    }

    public function isArray($value): bool
    {
        return is_array($value);
    }


}
