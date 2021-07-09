<?php

namespace App\Helpers;

use App\Traits\CallMethodStaticAndDynamicTrait;

/**
 * Class Helpers.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 *
 * @method static string  convertToStudlyCapsStatic( $string )
 * @method static $this  convertToCamelCaseStatic( $string )
 * @method static $this  convertToSnakeCaseStatic( $string )
 * @method static $this  convertStudlyCapsToNormalSpaceStatic( $string )
 * @method static $this  strposaStatic( $haystack, $needle, $offset = 0 )
 * @method static $this  removeDuplicateValuesStatic( &$items )
 * @method static $this  search_array_diffStatic( array &$array1, array $array2, $index )
 * @method static $this  trimObjectStatic( $item )
 * @method static $this  isRequestMethodOptionsStatic()
 * @method static $this  faNumbersToEngStatic( $string )
 * @method static $this  engNumbersToFaStatic( $string )
 * @method static $this  convertSimpleArrayToAssociatedStatic(array $array, bool $isOverwriteValue = false, $overwriteValue = 0): array
 * @method static $this  getKeyByMaxValueStatic(array $array)
 * @method static void   deleteFilesStatic(string $target)
 * @method static string faWordsToNumberStatic(string $input)
 * @method static string enWordsToNumberStatic(string $input)
 * @method static array arrayFlattenStatic(array $array)
 */
class Helpers
{
    use CallMethodStaticAndDynamicTrait;

    /**
     * Convert a string with hyphens to StudlyCaps format e.g. create-post => CreatePost.
     *
     * @param string $string String to convert
     */
    public function convertToStudlyCaps(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    }

    /**
     * Convert a string with hyphens to camelCase format e.g. create-post => createPost.
     *
     * @param string $string String to convert
     */
    public function convertToCamelCase(string $string): string
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    public function convertToSnakeCase(string $string): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $this->convertToCamelCase($string)));
    }

    /**
     * Convert a StudlyCaps string to normal with space StudyCaps => study caps.
     */
    public function convertStudlyCapsToNormalSpace(string $string): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', ' $0', $this->convertToCamelCase($string)));
    }

    /**
     * Find the position of the first occurrence of a substring in a array values.
     */
    public function strposa(string $haystack, array $needle, int $offset = 0): bool
    {
        if (!is_array($needle)) {
            $needle = [$needle];
        }
        foreach ($needle as $query) {
            if (false !== strpos($query, $haystack, $offset)) {
                return true;
            } // stop on first true result
        }

        return false;
    }

    /**
     * Remove duplicate values from array.
     */
    public function removeDuplicateValues(array &$items): array
    {
        return array_values(array_unique($items));
    }

    /**
     * @param $index
     */
    public function search_array_diff(array &$array1, array $array2, $index): array
    {
        foreach ($array1 as $key => $value) {
            if (in_array($value[$index], $array2)) {
                unset($array1[$key]);
            }
        }

        return array_values($array1);
    }

    /**
     * @param $item
     */
    public function trimObject($item): string
    {
        return !is_string($item) ? $item : trim($item);
    }

    public function isRequestMethodOptions(): bool
    {
        if ('OPTIONS' == $_SERVER['REQUEST_METHOD']) {
            return true;
        }

        return false;
    }

    /**
     * convert Persian numbers to English number.
     *
     * @param $string
     */
    public function faNumbersToEng(string $string): string
    {
        return strtr($string, [
            '۰' => '0',
            '۱' => '1',
            '۲' => '2',
            '۳' => '3',
            '۴' => '4',
            '۵' => '5',
            '۶' => '6',
            '۷' => '7',
            '۸' => '8',
            '۹' => '9',
            '٠' => '0',
            '١' => '1',
            '٢' => '2',
            '٣' => '3',
            '٤' => '4',
            '٥' => '5',
            '٦' => '6',
            '٧' => '7',
            '٨' => '8',
            '٩' => '9', ]);
    }

    /**
     * convert English numbers to Persian numbers.
     *
     * @param $string
     */
    public function engNumbersToFa(string $string): string
    {
        return strtr(
            $string,
            [
                '0' => '۰',
                '1' => '۱',
                '2' => '۲',
                '3' => '۳',
                '4' => '۴',
                '5' => '۵',
                '6' => '۶',
                '7' => '۷',
                '8' => '۸',
                '9' => '۹',
            ]
        );
    }

    /**
     * convert simple array to associated by default value or original value.
     *
     * @param int $overwriteValue
     */
    public function convertSimpleArrayToAssociated(array $array, bool $isOverwriteValue = false, $overwriteValue = 0): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            if ($isOverwriteValue) {
                $result[$value] = $overwriteValue;
            } else {
                $result[$value] = $key;
            }
        }

        return $result;
    }

    /**
     * get key in array that has max value.
     *
     * @return string|null
     */
    public function getKeyByMaxValue(array $array)
    {
        $rKey = null;
        $rMax = null;
        foreach ($array as $key => $value) {
            if ($value > $rMax) {
                $rKey = $key;
                $rMax = $value;
            }
        }

        return $rKey;
    }

    /**
     *  php delete function that deals with directories recursively.
     *
     * @param $target
     */
    public function deleteFiles($target)
    {
        if (is_dir($target)) {
            $files = glob($target.'*', GLOB_MARK);

            foreach ($files as $file) {
                dump($file);
                $this->deleteFiles($file);
            }

            rmdir($target);
        } elseif (is_file($target)) {
            unlink($target);
        }
    }

    /**
     * Convert fa words to numerals to digits.
     *
     * @return string
     */
    public function faWordsToNumber(string $input)
    {
        static $tokens = [
            //fa
            'صفر' => ['val' => '0', 'power' => 1],
            'یکم' => ['val' => '1', 'power' => 1],
            'یک' => ['val' => '1', 'power' => 1],
            'ویک' => ['val' => '1', 'power' => 1],
            'اول' => ['val' => '1', 'suffix' => '', 'power' => 1],
            'دوم' => ['val' => '2', 'suffix' => '', 'power' => 1],
            'دو' => ['val' => '2', 'power' => 1],
            'ودو' => ['val' => '2', 'power' => 1],
            'سوم' => ['val' => '3', 'suffix' => '', 'power' => 1],
            'سه' => ['val' => '3', 'power' => 1],
            'وسه' => ['val' => '3', 'power' => 1],
            'چهارم' => ['val' => '4', 'suffix' => '', 'power' => 1],
            'چهار' => ['val' => '4', 'power' => 1],
            'وچهار' => ['val' => '4', 'power' => 1],
            'پنجم' => ['val' => '5', 'suffix' => '', 'power' => 1],
            'پنج' => ['val' => '5', 'power' => 1],
            'وپنج' => ['val' => '5', 'power' => 1],
            'ششم' => ['val' => '6', 'suffix' => '', 'power' => 1],
            'شش' => ['val' => '6', 'power' => 1],
            'وشش' => ['val' => '6', 'power' => 1],
            'هفتم' => ['val' => '7', 'suffix' => '', 'power' => 1],
            'هفت' => ['val' => '7', 'power' => 1],
            'وهفت' => ['val' => '7', 'power' => 1],
            'هشتم' => ['val' => '8', 'suffix' => '', 'power' => 1],
            'هشت' => ['val' => '8', 'power' => 1],
            'وهشت' => ['val' => '8', 'power' => 1],
            'نهم' => ['val' => '9', 'suffix' => '', 'power' => 1],
            'نه' => ['val' => '9', 'power' => 1],
            'ونه' => ['val' => '9', 'power' => 1],
            'دهم' => ['val' => '10', 'suffix' => '', 'power' => 1],
            'ده' => ['val' => '10', 'power' => 10],
            'وده' => ['val' => '10', 'power' => 10],
            'یازدهم' => ['val' => '11', 'suffix' => '', 'power' => 10],
            'یازده' => ['val' => '11', 'power' => 10],
            'ویازده' => ['val' => '11', 'power' => 10],
            'دوازدهم' => ['val' => '12', 'suffix' => '', 'power' => 10],
            'دوازده' => ['val' => '12', 'power' => 10],
            'ودوازده' => ['val' => '12', 'power' => 10],
            'سیزدهم' => ['val' => '13', 'suffix' => '', 'power' => 10],
            'سیزده' => ['val' => '13', 'power' => 10],
            'وسیزده' => ['val' => '13', 'power' => 10],
            'چهاردهم' => ['val' => '14', 'suffix' => '', 'power' => 10],
            'چهارده' => ['val' => '14', 'power' => 10],
            'وچهارده' => ['val' => '14', 'power' => 10],
            'پانزدهم' => ['val' => '15', 'suffix' => '', 'power' => 10],
            'پانزده' => ['val' => '15', 'power' => 10],
            'وپانزده' => ['val' => '15', 'power' => 10],
            'شانزدهم' => ['val' => '16', 'suffix' => '', 'power' => 10],
            'شانزده' => ['val' => '16', 'power' => 10],
            'وشانزده' => ['val' => '16', 'power' => 10],
            'هفدهم' => ['val' => '17', 'suffix' => '', 'power' => 10],
            'هفده' => ['val' => '17', 'power' => 10],
            'وهفده' => ['val' => '17', 'power' => 10],
            'هجدهم' => ['val' => '18', 'suffix' => '', 'power' => 10],
            'هیجدهم' => ['val' => '18', 'suffix' => '', 'power' => 10],
            'هچدهم' => ['val' => '18', 'suffix' => '', 'power' => 10],
            'هجده' => ['val' => '18', 'power' => 10],
            'وهجده' => ['val' => '18', 'power' => 10],
            'نوزدهم' => ['val' => '19', 'suffix' => '', 'power' => 10],
            'نوزده' => ['val' => '19', 'power' => 10],
            'ونوزده' => ['val' => '19', 'power' => 10],
            'بیستم' => ['val' => '20', 'suffix' => '', 'power' => 10],
            'بیسستم' => ['val' => '20', 'suffix' => '', 'power' => 10],
            'بیتسم' => ['val' => '20', 'suffix' => '', 'power' => 10],
            'بیست' => ['val' => '20', 'power' => 10],
            'وبیست' => ['val' => '20', 'power' => 10],
            'سی' => ['val' => '30', 'power' => 10],
            'سی ام' => ['val' => '30', 'power' => 10],
            'وسی' => ['val' => '30', 'power' => 10],
            'چهل' => ['val' => '40', 'power' => 10],
            'چهلم' => ['val' => '40', 'power' => 10],
            'وچهل' => ['val' => '40', 'power' => 10],
            'پنجاه' => ['val' => '50', 'power' => 10],
            'وپنجاه' => ['val' => '50', 'power' => 10],
            'شصت' => ['val' => '60', 'power' => 10],
            'وشصت' => ['val' => '60', 'power' => 10],
            'هفتاد' => ['val' => '70', 'power' => 10],
            'وهفتاد' => ['val' => '70', 'power' => 10],
            'هشتاد' => ['val' => '80', 'power' => 10],
            'وهشتاد' => ['val' => '80', 'power' => 10],
            'نود' => ['val' => '90', 'power' => 10],
            'ونود' => ['val' => '90', 'power' => 10],
            'صد' => ['val' => '100', 'power' => 100],
            'وصد' => ['val' => '100', 'power' => 100],
            'دویست' => ['val' => '200', 'power' => 100],
            'ودویست' => ['val' => '200', 'power' => 100],
            'سیصد' => ['val' => '300', 'power' => 100],
            'وسیصد' => ['val' => '300', 'power' => 100],
            'چهارصد' => ['val' => '400', 'power' => 100],
            'وچهارصد' => ['val' => '400', 'power' => 100],
            'چارصد' => ['val' => '400', 'power' => 100],
            'وچارصد' => ['val' => '400', 'power' => 100],
            'پانصد' => ['val' => '500', 'power' => 100],
            'وپانصد' => ['val' => '500', 'power' => 100],
            'ششصد' => ['val' => '600', 'power' => 100],
            'وششصد' => ['val' => '600', 'power' => 100],
            'شیشصد' => ['val' => '600', 'power' => 100],
            'وشیشصد' => ['val' => '600', 'power' => 100],
            'هفتصد' => ['val' => '700', 'power' => 100],
            'وهفتصد' => ['val' => '700', 'power' => 100],
            'هشتصد' => ['val' => '800', 'power' => 100],
            'وهشتصد' => ['val' => '800', 'power' => 100],
            'هشصد' => ['val' => '800', 'power' => 100],
            'وهشصد' => ['val' => '800', 'power' => 100],
            'نهصد' => ['val' => '900', 'power' => 100],
            'ونهصد' => ['val' => '900', 'power' => 100],
            'هزار' => ['val' => '1000', 'power' => 1000],
            'وهزار' => ['val' => '1000', 'power' => 1000],
            'ملیون' => ['val' => '1000000', 'power' => 1000000],
            'وملیون' => ['val' => '1000000', 'power' => 1000000],
            'میلیون' => ['val' => '1000000', 'power' => 1000000],
            'ومیلیون' => ['val' => '1000000', 'power' => 1000000],
            'ملیارد' => ['val' => '1000000000', 'power' => 1000000000],
            'میلیارد' => ['val' => '1000000000', 'power' => 1000000000],
            'ومیلیارد' => ['val' => '1000000000', 'power' => 1000000000],
            'و' => ['val' => '', 'power' => null],
        ];

        return $this->wordToNumber($input, $tokens);
    }

    /**
     * Convert en words to numerals to digits.
     *
     * @return string
     */
    public function enWordsToNumber(string $input)
    {
        static $tokens = [
            'zero' => ['val' => '0', 'power' => 1],
            'a' => ['val' => '1', 'power' => 1],
            'first' => ['val' => '1', 'suffix' => 'st', 'power' => 1],
            'one' => ['val' => '1', 'power' => 1],
            'second' => ['val' => '2', 'suffix' => 'nd', 'power' => 1],
            'two' => ['val' => '2', 'power' => 1],
            'third' => ['val' => '3', 'suffix' => 'rd', 'power' => 1],
            'three' => ['val' => '3', 'power' => 1],
            'fourth' => ['val' => '4', 'suffix' => 'th', 'power' => 1],
            'four' => ['val' => '4', 'power' => 1],
            'fifth' => ['val' => '5', 'suffix' => 'th', 'power' => 1],
            'five' => ['val' => '5', 'power' => 1],
            'sixth' => ['val' => '6', 'suffix' => 'th', 'power' => 1],
            'six' => ['val' => '6', 'power' => 1],
            'seventh' => ['val' => '7', 'suffix' => 'th', 'power' => 1],
            'seven' => ['val' => '7', 'power' => 1],
            'eighth' => ['val' => '8', 'suffix' => 'th', 'power' => 1],
            'eight' => ['val' => '8', 'power' => 1],
            'ninth' => ['val' => '9', 'suffix' => 'th', 'power' => 1],
            'nine' => ['val' => '9', 'power' => 1],
            'tenth' => ['val' => '10', 'suffix' => 'th', 'power' => 1],
            'ten' => ['val' => '10', 'power' => 10],
            'eleventh' => ['val' => '11', 'suffix' => 'th', 'power' => 10],
            'eleven' => ['val' => '11', 'power' => 10],
            'twelveth' => ['val' => '12', 'suffix' => 'th', 'power' => 10],
            'twelfth' => ['val' => '12', 'suffix' => 'th', 'power' => 10],
            'twelve' => ['val' => '12', 'power' => 10],
            'thirteenth' => ['val' => '13', 'suffix' => 'th', 'power' => 10],
            'thirteen' => ['val' => '13', 'power' => 10],
            'fourteenth' => ['val' => '14', 'suffix' => 'th', 'power' => 10],
            'fourteen' => ['val' => '14', 'power' => 10],
            'fifteenth' => ['val' => '15', 'suffix' => 'th', 'power' => 10],
            'fifteen' => ['val' => '15', 'power' => 10],
            'sixteenth' => ['val' => '16', 'suffix' => 'th', 'power' => 10],
            'sixteen' => ['val' => '16', 'power' => 10],
            'seventeenth' => ['val' => '17', 'suffix' => 'th', 'power' => 10],
            'seventeen' => ['val' => '17', 'power' => 10],
            'eighteenth' => ['val' => '18', 'suffix' => 'th', 'power' => 10],
            'eighteen' => ['val' => '18', 'power' => 10],
            'nineteenth' => ['val' => '19', 'suffix' => 'th', 'power' => 10],
            'nineteen' => ['val' => '19', 'power' => 10],
            'twentieth' => ['val' => '20', 'suffix' => 'th', 'power' => 10],
            'twenty' => ['val' => '20', 'power' => 10],
            'thirty' => ['val' => '30', 'power' => 10],
            'forty' => ['val' => '40', 'power' => 10],
            'fourty' => ['val' => '40', 'power' => 10], // common misspelling
            'fifty' => ['val' => '50', 'power' => 10],
            'sixty' => ['val' => '60', 'power' => 10],
            'seventy' => ['val' => '70', 'power' => 10],
            'eighty' => ['val' => '80', 'power' => 10],
            'ninety' => ['val' => '90', 'power' => 10],
            'hundred' => ['val' => '100', 'power' => 100],
            'thousand' => ['val' => '1000', 'power' => 1000],
            'million' => ['val' => '1000000', 'power' => 1000000],
            'billion' => ['val' => '1000000000', 'power' => 1000000000],
            'and' => ['val' => '', 'power' => null],
        ];

        return $this->wordToNumber($input, $tokens);
    }

    /**
     * Convert word to numerals to digits
     * answer to https://stackoverflow.com/questions/1077600/converting-words-to-numbers-in-php.
     *
     * @see https://github.com/thefish/words-to-number-converter
     *
     * @param $input
     * @param $tokens
     */
    private function wordToNumber($input, $tokens): string
    {
        static $delims = " \-,.!?:;\\/&\(\)\[\]";
        $powers = array_column($tokens, 'power', 'val');

        $mutate = function ($parts) use (&$mutate, $powers) {
            $stack = new \SplStack();
            $sum = 0;
            $last = null;
            foreach ($parts as $idx => $arr) {
                $part = $arr['val'];

                if (!$stack->isEmpty()) {
                    $check = $last ?? $part;

                    if ((float) $stack->top() < 20 && (float) $part < 20 ?? (float) $part < $stack->top()) { //пропускаем спец числительные
                        return $stack->top().(isset($parts[$idx - $stack->count()]['suffix']) ? $parts[$idx - $stack->count()]['suffix'] : '').' '.$mutate(array_slice($parts, $idx));
                    }
                    if (isset($powers[$check]) && $powers[$check] <= $arr['power'] && $arr['power'] <= 10) { //но добавляем степени (сотни, тысячи, миллионы итп)
                        return $stack->top().(isset($parts[$idx - $stack->count()]['suffix']) ? $parts[$idx - $stack->count()]['suffix'] : '').' '.$mutate(array_slice($parts, $idx));
                    }
                    if ($stack->top() > $part) {
                        if ($last >= 1000) {
                            $sum += $stack->pop();
                            $stack->push($part);
                        } else {
                            // twenty one -> "20 1" -> "20 + 1"
                            $stack->push($stack->pop() + (float) $part);
                        }
                    } else {
                        $current = $stack->pop();
                        if (is_numeric($current)) {
                            $stack->push($current * (float) $part);
                        } else {
                            $stack->push($part);
                        }
                    }
                } else {
                    $stack->push($part);
                }

                $last = $part;
            }
            $s = $stack->pop();

            if ('' !== trim($s)) {
                return $sum + $s;
            }

            return $sum;
        };

        $prepared = preg_split('/(['.$delims.'])/', $input, -1, PREG_SPLIT_DELIM_CAPTURE);
        $original = $prepared;
        //Замена на токены
        foreach ($prepared as $idx => $word) {
            if (is_array($word)) {
                continue;
            }
            $maybeNumPart = trim(strtolower($word));
            if (isset($tokens[$maybeNumPart])) {
                $item = $tokens[$maybeNumPart];
                if (isset($prepared[$idx - 1]) && !is_array($prepared[$idx - 1]) && '' === trim($item['val'])) {
                    continue;
                }
                if (isset($prepared[$idx + 1])) {
                    $maybeDelim = $prepared[$idx + 1];
                    if (' ' === $maybeDelim) {
                        $item['delim'] = $maybeDelim;
                        unset($prepared[$idx + 1]);
                    } elseif (null == $item['power'] && !isset($tokens[$maybeDelim])) {
                        continue;
                    }
                }
                $prepared[$idx] = $item;
            }
        }

        $result = [];
        $accumulator = [];

        $lastKey = null;
        $lastPart = null;
        foreach ($prepared as $key => $prepare) {
            if (
                !is_array($prepare) &&
                is_array($lastPart) &&
                '' === trim($lastPart['val'])) {
                $prepared[$lastKey] = $original[$lastKey];
                $prepared[$lastKey + 1] = ' ';
            }

            $lastKey = $key;
            $lastPart = $prepare;
        }

        ksort($prepared);

        $getNumeral = function () use ($mutate, &$accumulator, &$result) {
            $last = end($accumulator);
            $result[] = $mutate($accumulator).(isset($last['suffix']) ? $last['suffix'] : '').(isset($last['delim']) ? $last['delim'] : '');
            $accumulator = [];
        };

        foreach ($prepared as $part) {
            if (is_array($part)) {
                $accumulator[] = $part;
            } else {
                if (!empty($accumulator)) {
                    $getNumeral();
                }
                $result[] = $part;
            }
        }
        if (!empty($accumulator)) {
            $getNumeral();
        }

        return implode('', array_filter($result));
    }

    /**
     * flat an array and return values.
     *
     * @param $array
     *
     * @return array
     */
    private function arrayFlatten(array $array): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, $this->arrayFlatten($value));
            } else {
                $result = array_merge($result, [$key => $value]);
            }
        }

        return $result;
    }
}
