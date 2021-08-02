<?php

declare(strict_types=1);

namespace Bruny\Rendering;

final class HTMLEncoder
{
    private function __construct()
    {
    }

    /**
     * @param object $data
     * @return mixed
     */
    public static function safelyPrepareData(object $data)
    {
        return self::recursivelyPrep($data);
    }

    /**
     * @param mixed $item
     * @return mixed
     */
    private static function recursivelyPrep($item)
    {

        return match (true) {
            is_string($item) => htmlspecialchars($item, ENT_COMPAT | ENT_HTML5, "UTF-8", false),

            is_object($item) => self::traverseObject($item),

            is_iterable($item) => self::traverseIterable($item),

            is_callable($item), is_resource($item) => "",

            default => $item
        };
    }

    private static function traverseIterable(iterable $arr): array
    {
        $result = [];
        foreach ($arr as $key => $item) {
            $safe = self::recursivelyPrep($item);
            $result[$key] = $safe;
        }
        return $result;
    }

    private static function traverseObject(object $obj): object
    {
        foreach ($obj as $propName => $propVal) {
            $obj->$propName = self::recursivelyPrep($propVal);
        }
        return $obj;
    }
}
