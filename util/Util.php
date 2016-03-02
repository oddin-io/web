<?php
namespace BossEdu\Util;

class Util {
    public static function stdClassToArray($data, $case = null) {
        $array = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = Util::stdClassToArray($value, $case);
            }

            switch ($case) {
                case "lower":
                    $array[strtolower($key)] = $value;
                    break;
                case "upper":
                    $array[strtoupper($key)] = $value;
                    break;
                case "underscore":
                    $array[self::underscoreStyle($key)] = $value;
                    break;
                default:
                    $array[$key] = $value;
            }
        }

        return $array;
    }

    /**
     * @param string $string Entry string in camelCase format
     * @return string $string transformed in underscore_style
     */
    public static function underscoreStyle($string) {
        if (!is_string($string)) {
            return $string;
        }

        $result = strtolower($string[0]);
        for ($i = 1, $length = strlen($string); $i < $length; $i++) {
            $result .= (ctype_upper($string[$i]) ? "_".strtolower($string[$i]) : $string[$i]);
        }

        return $result;
    }

    public static function adjustArrayCase($data, $case) {
        return Util::stdClassToArray($data, $case);
    }

    public static function getPostContents($case = null) {
        $data = file_get_contents("php://input");
        $data = json_decode($data);

        return self::stdClassToArray($data, $case);
    }

    public static function namespacedArrayToNormal($array, $base = null, $delimiter = ".") {
        $result = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = Util::namespacedArrayToNormal($value, $base, $delimiter);
            }

            $namespace = array_reverse(explode($delimiter, $key));

            $output = [array_shift($namespace) => $value];
            $aux = [];
            foreach ($namespace as $name) {
                $aux[$name] = $output;
                $output = $aux;
                unset($aux[$name]);
            }

            $result = array_merge_recursive($result, $output);
        }

        if ($base) {
            if (is_string($base)) {
                $base = [$base];
            }

            foreach ($base as $key) {
                if (array_key_exists($key, $result)) {
                    $result = array_merge($result, $result[$key]);
                    unset($result[$key]);
                }
            }
        }

        return $result;
    }
}
