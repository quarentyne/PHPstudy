<?php

function deleteSpaces($string) {
    if(gettype($string) !== 'string') {
        throw new Exception('Only string can be a parameter');
    }

    return preg_replace('/\s+/', '', $string);
}

function customTrim ($string) {
    if(gettype($string) !== 'string') {
        throw new Exception('Only string can be a parameter');
    }

    return preg_replace('/^[\sFEFF\xA0]+|[\sFEFF\xA0]+$/', '', $string);
}

function myExplode($string, $separator, $limit = PHP_INT_MAX) {
    if(gettype($string) !== 'string') {
        throw new Exception('Only string can be exploded');
    }
    if(gettype($separator) !== 'string') {
        throw new Exception('Only string can be a separator');
    }
    if(gettype($limit) !== 'integer') {
        throw new Exception('Only integer can be a limit parameter');
    }

    $word = '';
    $result = array();

    for($i = 0; $i < strlen($string); $i++) {
        if($string[$i] !== $separator) {
            $word .= $string[$i];
        }
        if($string[$i] === $separator || $i === strlen($string) - 1) {
            $result[] = $word;
            $word = '';
            if(count($result) === $limit) {
                break;
            }
        }
    }

    return $result;
}

function mySort(&$array, $callback = '') {
    if(gettype($array) !== 'array' && gettype($array) !== 'string') {
        throw new Exception('The parameter must be iterable');
    }

    if(!$callback || !is_callable($callback)) {
        $callback = function ($a, $b) {
            return $a > $b;
        };
    }

    $length = count($array) - 1;
    for($i = 0; $i < $length; $i++) {
        for($j = 0; $j < $length - $i; $j++) {
            if($callback($array[$j], $array[$j + 1])) {
                $currentItem = $array[$j];
                $array[$j] = $array[$j + 1];
                $array[$j + 1] = $currentItem;
            }
        }
    }
    return $array;
}

function myFilter($array, $callback) {
    if(gettype($array) !== 'array') {
        throw new Exception('The first parameter must be an array');
    }
    if(gettype($callback) !== 'object') {
        throw new Exception('The callback must be a function');
    }

    $result = array();
    for($i = 0; $i < count($array); $i++) {
        if($callback($array[$i])) {
            $result[] = $array[$i];
        }
    }

    return $result;
}

function myInArray($array, $needle) {
    if(gettype($array) !== 'array') {
        throw new Exception('The first parameter must be an array');
    }

    foreach ($array as $item) {
        if($item === $needle) {
            return true;
        }
    }

    return false;
}

function myReduce($array) {
    if(gettype($array) !== 'array') {
        throw new Exception('The first parameter must be an array');
    }

    $result = 0;
    for($i = 0; $i < count($array); $i++) {
        $result += $array[$i];
    }
    return $result;
}

function myIncludes($array, $target) {
    if(gettype($array) !== 'array') {
        throw new Exception('The first parameter must be an array');
    }

    for($i = 0; $i < count($array); $i++) {
        if($array[$i] === $target) {
            return true;
        }
    }
    return false;
}

function checkIsAnagram($firstString, $secondString) {
    if(gettype($firstString) !== 'string' || gettype($secondString) !== 'string') {
        throw new Exception('The parameters type has to be a String');
    }

    $firstString = deleteSpaces($firstString);
    $secondString = deleteSpaces($secondString);

    if(strlen($firstString) !== strlen($secondString)) {
        return false;
    }

    $firstArray = array();
    $secondArray = array();

    for($i = 0; $i < strlen($firstString); $i++) {
        $firstArray[] = $firstString[$i];
    }

    for($i = 0; $i < strlen($secondString); $i++) {
        $secondArray[] = $secondString[$i];
    }

    mySort($firstArray);
    mySort($secondArray);

    for ($i = 0; $i < count($firstArray); $i++) {
        if ($firstArray[$i] !== $secondArray[$i]) {
            return false;
        }
    }
    return true;
}

function countDigitsInNumber($number) {
    if(gettype($number) !== 'integer' && gettype($number) !== 'double') {
        throw new Exception('The parameter type must be an Integer');
    }

    for($count = 0; $number >= 1; $count++) {
        $number /= 10;
    }

    return $count;
}

function countDigitsInNumberRecursion($number, $count = 0) {
    if(gettype($number) !== 'integer' && gettype($number) !== 'double') {
        throw new Exception('The parameter type must be an Integer');
    }

    if ($number > -10 && $number < 10) {
        return ++$count;
    }

    return countDigitsInNumberRecursion($number / 10, $count + 1);
}

function checkIsPalindrom($string) {
    if (gettype($string) !== 'string') {
        throw new Exception('The parameter type must be a String');
    }

    $stringLength = strlen($string);

    for($i = 0; $i < $stringLength; $i++) {
        if($string[$i] !== $string[$stringLength - 1 - $i]) {
            return false;
        }
    }

    return true;
}

function countUniqWords($string) {
    if (gettype($string) !== 'string') {
        throw new Exception('The parameter type must be a String');
    }

    $string = preg_replace('/[^a-zа-яё\s]/', '', strtolower(customTrim($string)));

    $callback = function($value) {
        return $value;
    };

    $wordsInString = myFilter(myExplode($string, ' '), $callback);

    $result = array();

    foreach ($wordsInString as $word) {
        if(!myInArray($result, $word)) {
            $result[] = $word;
        }
    }

    return count($result);
}

function countWordsInString($string) {
    if (gettype($string) !== 'string') {
        throw new Exception('The parameter type must be a String');
    }

    $string = preg_replace('/[^a-zа-яё\s]/', '', strtolower(customTrim($string)));

    $result = array();

    $callback = function($value) {
        return $value;
    };

    $wordsInString = myFilter(myExplode($string, ' '), $callback);

    foreach ($wordsInString as $word) {
        if(isset($result[$word])) {
            $result[$word]++;
        } else {
            $result[$word] = 1;
        }
    }

    return $result;
}

class Triangle {
    protected $base;
    protected $firstAdditionalSide;
    protected $secondAdditionalSide;

    function __construct($base, $firstAdditionalSide, $secondAdditionalSide) {
        if ((gettype($base) !== 'integer' && gettype($base) !== 'double') || $base < 1 ||
            (gettype($firstAdditionalSide) !== 'integer' && gettype($firstAdditionalSide) !== 'double') || $firstAdditionalSide < 1 ||
            (gettype($secondAdditionalSide) !== 'integer' && gettype($secondAdditionalSide) !== 'double') || $secondAdditionalSide < 1
        ) {
            throw new Exception('Operators cannot be less then 1 and have to be Numbers');
        }

        $this->base = $base;
        $this->secondAdditionalSide = $secondAdditionalSide;
        $this->firstAdditionalSide = $firstAdditionalSide;
    }

    public function getPerimeter () {
        return $this->base + $this->secondAdditionalSide + $this->firstAdditionalSide;
    }

    public function getSquare () {
        $halfPerimeter = $this->getPerimeter() / 2;

        return sqrt($halfPerimeter * ($halfPerimeter - $this->base) * ($halfPerimeter - $this->firstAdditionalSide) *
            ($halfPerimeter - $this->secondAdditionalSide));
    }
}

class Circle {
    private $radius;

    function __construct($radius) {
        if ((gettype($radius) !== 'integer' && gettype($radius) !== 'double') || $radius < 1) {
            throw new Exception('Operator cannot be less then 1 and have to be a Number');
        }

        $this->radius = $radius;
    }

    public function getPerimeter() {
        return 2 * $this->radius * M_PI;
    }
    public function getSquare() {
        return M_PI * ($this->radius ** 2);
    }
}

class Rectangle {
    private $width;
    private $length;

    function __construct($length, $width) {
        if ((gettype($length) !== 'integer' && gettype($length) !== 'double') || $length < 1 ||
            (gettype($width) !== 'integer' && gettype($width) !== 'double') || $width < 1)
        {
            throw new Exception('Operators cannot be less then 1 and have to be Numbers');
        }

        $this->length = $length;
        $this->width = $width;
    }

    public function getPerimeter() {
        return 2 * ($this->width + $this->length);
    }
    public function getSquare() {
        return $this->width * $this->length;
    }
}

function getFactorial($number) {
    if (gettype($number) !== 'integer' && gettype($number) !== 'double')
    {
        throw new Exception('Operator must be a Number');
    }

    $result = 1;

    for($i = 1; $i <= $number; $i++) {
        $result *= $i;
    }

    return $result;
}

function getFactorialMemo($number) {
    if ((gettype($number)) !== 'integer' && gettype($number) !== 'double')
    {
        throw new Exception('Operator must be a Number');
    }

    static $memory = array();

    if($number === 0) {
        return 1;
    }

    if(!isset($memory[$number])) {
        $memory[$number] = getFactorialMemo($number - 1);
    }

    return $number * $memory[$number];
}

function getSumFromArray($array, $callback) {
    if(!is_callable($callback) || gettype($array) !== 'array') {
        throw new Exception('Operators incorrect type. Must be an array and a function');
    }

    $result = 0;

    for($i = 0; $i < count($array); $i++) {
        if($callback($array[$i])) {
            $result += $array[$i];
        }
    }
    return $result;
}

function getSumFromArrayRecursion($array, $callback, $result = 0, $index = 0) {
    if(!is_callable($callback) || gettype($array) !== 'array') {
        throw new Exception('Operators incorrect type. Must be an array and a function');
    }

    if($index >= count($array)) {
        return $result;
    }

    if($callback($array[$index])) {
        $result += $array[$index];
    }

    return getSumFromArrayRecursion($array, $callback, $result, ++$index);
}

function getElementsCount($array, $callback) {
    if(!is_callable($callback) || gettype($array) !== 'array') {
        throw new Exception('Operators incorrect type. Must be an array and a function');
    }

    $count = 0;

    foreach ($array as $item) {
        if($callback($item)) {
            $count++;
        }
    }

    return $count;
}

function toBinary($number) {
    if(gettype($number) !== 'integer') {
        throw new Exception('Incorrect operator type. Use integer');
    }

    $numbersArray = array();
    $result = '';

    while ($number / 2 > 0) {
        $numbersArray[] = ($number % 2);
        $number = floor($number / 2);
    }
    for ($i = count($numbersArray) - 1; $i >= 0; $i--){
        $result .= $numbersArray[$i];
    }
    return $result;
}

function toDecimal($number) {
    if(gettype($number) !== 'integer') {
        throw new Exception('Incorrect operator type. Use integer');
    }

    $result = 0;
    $numbersArray  = array();
    $numberLength = ceil(log10($number));
    $maxLength = 10 ** ($numberLength - 1);

    while ($maxLength >= 1) {
        $rounded = round($number / $maxLength, 0, PHP_ROUND_HALF_DOWN);
        $numbersArray[] = $rounded;
        $rounded = $rounded * $maxLength;
        $maxLength = $maxLength / 10;
        $number = $number - $rounded;
    }

    for ($i = 0; $i < count($numbersArray); $i++) {
        $result = $result * 2 + $numbersArray[$i];
    }

    return $result;
}

function getSumTwoDimensionArray($array, $callback) {
    if(!is_callable($callback) || gettype($array) !== 'array') {
        throw new Exception('Operators incorrect type. Must be an array and a function');
    }

    $result = 0;

    for($i = 0; $i < count($array); $i++) {
        for($j = 0; $j < count($array[$i]); $j++) {
            if ($callback($array[$i][$j])) {
                $result += $array[$i][$j];
            }
        }
    }

    return $result;
}

function getElemsCountTwoDimensionalArray($array, $callback) {
    if(!is_callable($callback) || gettype($array) !== 'array') {
        throw new Exception('Operators incorrect type. Must be an array and a function');
    }

    $result = 0;

    for($i = 0; $i < count($array); $i++) {
        for($j = 0; $j < count($array[$i]); $j++) {
            if($callback($array[$i][$j])) {
                $result++;
            }
        }
    }

    return $result;
}

function getSumFromSegmentOfNumbers($min, $max, $callback) {
    if(gettype($min) !== 'integer' || gettype($max) !== 'integer' || !is_callable($callback)) {
        throw new Exception('Operators incorrect type. Must be integers and a function');
    }

    $result = 0;

    for($i = $min; $i <= $max; $i++) {
        if ($callback($i)) {
            $result += $i;
        }
    }
    return $result;
}

function getSumFromSegmentOfNumbersRecursion($min, $max, $callback, $result = 0) {
    if(gettype($min) !== 'integer' || gettype($max) !== 'integer' || !is_callable($callback)) {
        throw new Exception('Operators incorrect type. Must be integers and a function');
    }

    if ($min > $max) {
        return $result;
    }

    if ($callback($min)) {
        $result += $min;
    }

    return getSumFromSegmentOfNumbersRecursion(++$min, $max, $callback, $result);
}

function takeAverageArrayElements($array, $callback) {
    if(!is_callable($callback) || gettype($array) !== 'array') {
        throw new Exception('Operators incorrect type. Must be an array and a function');
    }

    $filteredArray = myFilter($array, $callback);
    return myReduce($filteredArray) / count($filteredArray);
}

function takeAverageTwoDimensionalArrayElements($array, $callback) {
    if(!is_callable($callback) || gettype($array) !== 'array') {
        throw new Exception('Operators incorrect type. Must be an array and a function');
    }

    $result = 0;
    $arraysCount = 0;

    for($i = 0; $i < count($array); $i++) {
        $filteredArray = myFilter($array[$i], $callback);
        if(count($filteredArray)) {
            $result += myReduce($filteredArray);
            $arraysCount += count($filteredArray);
        }
    }

    return $result / $arraysCount;
}

function transposeMatrix($matrix) {
    if(gettype($matrix) !== 'array') {
        throw new Exception('Operator incorrect type. Must be an array');
    }

    $result = array();
    $maxLength = count($matrix);

    while($maxLength > 0) {
        $result[] = array();
        $maxLength--;
    }

    for($i = 0; $i < count($matrix); $i++) {
        if(count($matrix[$i]) !== count($matrix)) {
            throw new Exception('This matrix cant be transposed');
        }
        for($j = 0; $j < count($matrix[$i]); $j++) {
            $result[$j][] = $matrix[$i][$j];
        }
    }

    return $result;
}

function getMatrixSum($matrix1, $matrix2) {
    if(gettype($matrix1) !== 'array' || gettype($matrix2) !== 'array') {
        throw new Exception('Operators incorrect type. Must be arrays');
    }

    $matrixSum = array();

    for($i = 0; $i < count($matrix1); $i++) {
        if(count($matrix1[$i]) !== count($matrix2[$i])) {
            throw new Exception('The arrays are not the same size. Sum operation isnt possible');
        }

        $matrixSum[$i] = array();
        for($j = 0; $j < count($matrix1[$i]); $j++) {
            $matrixSum[$i][$j] = $matrix1[$i][$j] + $matrix2[$i][$j];
        }
    }

    return $matrixSum;
}

function deleteRowsWithZero($array) {
    if(gettype($array) !== 'array') {
        throw new Exception('Operator incorrect type. Must be an array');
    }

    for($i = 0; $i < count($array); $i++) {
        if(myIncludes($array[$i], 0)) {
            array_splice($array, $i--, 1);
        }
    }

    return $array;
}

function deleteColumnWithZero($array) {
    if(gettype($array) !== 'array') {
        throw new Exception('Operator incorrect type. Must be an array');
    }

    $deleteIndex = array();

    for($i = 0; $i < count($array); $i++) {
        for($j = 0; $j < count($array[$i]); $j++) {
            if($array[$i][$j] === 0) {
                if(!myIncludes($deleteIndex, $j)) {
                    $deleteIndex[] = $j;
                }
            }
        }
    }

    $count = 0;
    mySort($deleteIndex, function ($a, $b) {
        return $a > $b;
    });

    foreach ($deleteIndex as $index) {
        for($i = 0; $i < count($array); $i++) {
            array_splice($array[$i], $index + $count, 1);
        }
        $count--;
    }

    return $array;
}

function takeActionOnMatrix ($matrix, $direction, $function) {
    if(!is_callable($direction) || !is_callable($function)) {
        throw new Exception('Check the introduced functions');
    }
    if(gettype($matrix) !== 'array') {
        throw new Exception('Operator incorrect type. Must be an array');
    }

    $result = 0;

    for($i = 0; $i < count($matrix); $i++) {
        for($j = 0; $j < count($matrix[$i]); $j++) {
            if($direction($i, $j)) {
                $result += $function($matrix[$i][$j]);
            }
        }
    }

    return $result;
}

function fibonacciGenerator() {
    $prev = 0;
    $current = 1;
    while(true) {
        $result = $prev;
        $prev = $current;
        $current = $result + $prev;
        yield $result;
    }
}

function fibonacciRecursion($number) {
    if(gettype($number) !== 'integer') {
        throw new Exception('Incorrect operator type. Use integer');
    }

    if($number <= 1) {
        return $number;
    }

    return fibonacciRecursion($number - 1) + fibonacciRecursion($number - 2);
}

class FibonacciIterator implements Iterator {
    private $position = 0;
    private $target = 0;
    private $current = 1;
    private $previous = 1;
    private $result = 0;

    public function __construct($iteration) {
        if(gettype($iteration) !== 'integer') {
            throw new Exception('Incorrect operator type. Use integer');
        }

        $this->target = $iteration;
    }

    public function rewind() {
        $this->position = 0;
        $this->current = 1;
        $this->previous = 1;
        $this->result = 0;
    }

    public function valid() {
        return $this->position < $this->target;
    }

    public function current() {
        return $this->result;
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        ++$this->position;
        $this->result = $this->previous;
        $this->previous = $this->current;
        $this->current = $this->current + $this->result;
    }
}

class TrafficLightIterator implements Iterator {
    private $colors = array('red', 'yellow', 'green', 'yellow');
    private $position = 0;

    public function __construct(){}

    public function rewind() {
        $this->position = 0;
    }

    public function valid(){
        return $this->colors[$this->position];
    }

    public function current() {
        return $this->colors[$this->position];
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        ++$this->position;
        if($this->position >= count($this->colors)) {
            $this->position = 0;
        }
    }
}

function trafficLightGenerator() {
    while(true) {
        yield 'red';
        yield 'yellow';
        yield 'green';
        yield 'yellow';
    }
}

function checkIsNegativeNumber($number) {
    if(gettype($number) !== 'integer') {
        throw new Exception('Incorrect operator type. Use integer');
    }

    return ($number & (1 << 31)) === (1 << 31);
}

function getNumberOfBits($number) {
    if(gettype($number) !== 'integer') {
        throw new Exception('Incorrect operator type. Use integer');
    }

    $binaryNumber = toBinary($number);
    $zeroes = 32;
    $units = 0;

    for ($i = 0; $i < strlen($binaryNumber); $i++) {
        if($binaryNumber[$i] === '1') {
            $units++;
        }
    }

    return array(
        '1' => $units,
        '0' => $zeroes - $units,
    );
}

function bitwiseNot($number) {
    if(gettype($number) !== 'integer') {
        throw new Exception('Incorrect operator type. Use integer');
    }

    $systemBitRate = PHP_INT_SIZE * 8;
    $result = 0;

    for($i = 0; $i < $systemBitRate; $i++) {
        if ((($number >> $i) & 1) !== 1) {
            $result |= (1<<$i);
        }
    }

    return $result;
}

function bitwiseNotEasy($number) {
    if(gettype($number) !== 'integer') {
        throw new Exception('Incorrect operator type. Use integer');
    }
    return $number ^ (-1);
}