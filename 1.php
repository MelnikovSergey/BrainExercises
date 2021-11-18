<?php

/*
Реализовать функцию findSimple($a, $b). 
Результат её выполнения: массив простых чисел от $a до $b.
*/
function findSimple($a, $b) {

	$largerNumber = max($a, $b);
	$smallerNumber = min($a, $b);

	for($i = 0; $smallerNumber <= $largerNumber; $smallerNumber++, $i++) {
		$result[$i] = $smallerNumber;
	}

	if($a > $b) {
		return array_reverse($result);
	}
		
	return $result;
}

print_r(findSimple(8, 18));
echo '<br>';
print_r(findSimple(18, 8));
echo '<hr>';



/*
Реализовать функцию createTrapeze($a). $a – массив положительных чисел, количество элементов кратно 3. Результат её выполнения: двумерный массив (массив состоящий из ассоциативных массива с ключами a, b, c). Пример для входных массива [1, 2, 3, 4, 5, 6] результат [[‘a’=>1,’b’=>2,’с’=>3],[‘a’=>4,’b’=>5 ,’c’=>6]].
*/
function createTrapeze($a) {

	$keys = ['a', 'b', 'c'];

	foreach ($a as $value) {
		$tmpArray[] = $value;

		if(count($keys) == count($tmpArray)) {
			$result[] = array_combine($keys, $tmpArray);
			$tmpArray = null;
		}
	}

	return $result;
}

print_r(createTrapeze([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]));
echo '<hr>';



/*
Реализовать функцию squareTrapeze($a). $a – массив результата выполнения функции createTrapeze(). Результат её выполнения: в исходный массив для каждой тройки чисел добавляется дополнительный ключ s, содержащий результат расчета площади трапеции со сторонами a и b, и высотой c.
*/
function squareTrapeze($a) {

	foreach ($a as $value) {
		$s = ($value['a'] + $value['b'])/2 * $value['c'];
		$value['s'] = $s;
		
		$result[] = $value;
	}

	return $result;
}

print_r(squareTrapeze(createTrapeze([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12])));
echo '<hr>';



/*
Реализовать функцию getSizeForLimit($a, $b). $a – массив результата выполнения функции squareTrapeze(), $b – максимальная площадь. Результат её выполнения: массив размеров трапеции с максимальной площадью, но меньше или равной $b.
*/
function getSizeForLimit($a, $b) { 
	$tmpArray = null;

	foreach ($a as $key => $value) {

		if($value['s'] <= $b) {
			$tmpArray[] = $value['s'];
		}
	}

	if(!is_array($tmpArray)) {
		echo 'Необходимого массива не обнаружено. Попробуйте другие параметры.';
		$result = null;
	} else {
		$maxSquare = array_keys($tmpArray, max($tmpArray))[0];
		$result = $a[$maxSquare];
	}

	return $result; 
}

print_r(getSizeForLimit(squareTrapeze(createTrapeze([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12])), 28));
echo '<hr>';


/*
Реализовать функцию getMin($a). $a – массив чисел. Результат её выполнения: минимальное числа в массиве (не используя функцию min, ключи массива могут быть ассоциативными).
*/
function getMin($a) {

	$min = count($a);

	foreach ($a as $value) {
		if($value < $min) {
			$min = $value;
		}
	}

	return $min;
}

print_r(getMin([ 0 => -0.101, 1 => -1, 2 => -2, 3 => 0, 4 => 1 ]));
echo '<hr>';



/*
Реализовать функцию printTrapeze($a). $a – массив результата выполнения функции squareTrapeze(). Результат её выполнения: ВЫВОД таблицы с размерами трапеций, строки с нечетной площадью трапеции отметить любым способом.
*/
function printTrapeze($a) {

	if(!is_array($a) or count($a) < 1) {
		echo "Что-то пошло не так...";
		return null;
	}

	echo '<table border="1" cellpadding="5" cellspacing="0">';

	foreach ($a as $key => $value) {
		echo '<tr>';
			echo '<td>Трапеция ' . ($key + 1) . '</td>';

			foreach ($value as $key => $val) {
				$mesh = round($val) !== $val ? 0.0 : 0;

				if($val % 2 !== $mesh and $key === 's') {
					echo '<td style="background-color:#b8b8b8">' . $val . '</td>';
				} else {
					echo '<td>' . $val . '</td>';
				}
			}
		
		echo '</tr>';
	}

	echo '</table>';
}

print_r(printTrapeze(squareTrapeze(createTrapeze([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]))));
echo '<hr>';


/*
Реализовать абстрактный класс BaseMath содержащий 3 метода: exp1($a, $b, $c) и exp2($a, $b, $c), getValue(). Метода exp1 реализует расчет по формуле a*(b^c). Метода exp2 реализует расчет по формуле (a/b)^c. Метод getValue() возвращает результат расчета класса наследника.
*/
abstract class BaseMath {
 
    public function exp1($a=1, $b=1, $c=1) {
        return $a * ($b ** $c);
    }

    public function exp2($a=1, $b=1, $c=1) {
        return ($a / $b) ** $c;
    }

    abstract public function getValue();
}
 


/*
Реализовать класс F1 наследующий методы BaseMath, содержащий конструктор с параметрами ($a, $b, $c) и метод getValue(). Класс реализует расчет по формуле f=(a*(b^c)+(((a/c)^b)%3)^min(a,b,c)).
*/
class F1 extends BaseMath {

	protected $_a, $_b, $_c;

	public function __construct($a=1, $b=1, $c=1) {
		$this->_a = $a;
		$this->_b = $b;
		$this->_c = $c;
	}

    public function getValue() {

    	// $f = $this->exp1($this->_a, $this->_b, $this->_c) + $this->exp2($this->_a, $this->_b, $this->_c) % 3 etc... 
    	$f = ($this->_a * ($this->_b ** $this->_c) + ((($this->_a / $this->_c) ** $this->_b) % 3) ** min($this->_a, $this->_b, $this->_c));

        return $f;
    }
}
 
$F1Object = new F1(32, 10, 18);

echo $F1Object->exp1();
echo '<br>';

echo $F1Object->exp1(1,2);
echo '<br>';

echo $F1Object->exp2(10,12,8);
echo '<br>';

echo $F1Object->getValue();
echo '<br>';

$F2Object = new F1();
echo $F2Object->getValue();

echo '<hr>';
