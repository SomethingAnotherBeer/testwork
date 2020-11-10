<?php 
namespace App;

class Words
{	

	private $default_words; // Словосочетание без изменений
	private $completion_marks = ['!','.','?']; //Знаки препинания, завершающие предложения
	private $separation_marks = [',',';','-']; //Знаки препинания, резделяющие предложение
	
	

	private function revertCharacters(array $words) : string{
		$result = []; // Инициализация переменной результата
		$word_length = 0; // Инициализация переменной длины текущего слова
		$multibyte_word_length = 0; // Инициализация переменной длины текущего слова в многобайтовой кодировке в словосочетании


		for($i = 0;$i<count($words);$i++){ // Цикл обходит все слова в словосочетании

			$current_reversed_word = ''; // Инициализация переменной слова, должной быть перевернутой

			$current_word_punctuation_mark = null; // Инициализация переменной знака пунткуации после текущего слова

			$word_length = strlen($words[$i])-1; // Длина текущего слова с учетом отсчета от 0

			$previous_word_length = isset($words[$i-1]) ? strlen($words[$i-1])-1 : 0; // Длина предыдущего слова

			$multibyte_word_length = mb_strlen($words[$i])-1; // Длина текущего слова с учетом отсчета индекса от 0 с учетом многобайтовой кодировки
			
			if($multibyte_word_length  === 0) { // Если у нас частица или предлог
				$result[] = $words[$i]; //1) То присваиваемы его в результат без изменений.
				continue; //2) Пропускаем дальнейшие действия
			} 

			if(in_array($words[$i][$word_length], array_merge($this->completion_marks,$this->separation_marks))) { // Если последний символ слова является знаком пунткуации, то :
				$current_word_punctuation_mark = $words[$i][$word_length]; // 1) присваиваем переменной знака пунктуации знак пунктуации после текущего слова
				$multibyte_word_length--; // 2) уменьшаем длину слова, в рамках которой будет происходить цикл переворачивания
			}  

			for($j = $multibyte_word_length;$j>=0;$j--){ // Начиная с конца текущего слова: 
				$current_reversed_word.= mb_substr($words[$i], $j,1); // 1) Присваиваем поочередно символы новому слову
			}

			$current_reversed_word.= ($current_word_punctuation_mark != null) ? $current_word_punctuation_mark : ''; // Если после текущего слова имеется знак пунткуации, то присваиваем его в конец перевернутого слова

			if($i !== 0){ // Если это не первое слово в итерации:
				if(in_array($words[$i-1][$previous_word_length], $this->completion_marks)) { //Если последний символ предыдущего слова является знаком пунктуации, завершащим предложение:
				$current_reversed_word = $this->prepareFirstSymbolToUpperCase($current_reversed_word); //Тогда первый символ текущего перевернутого слова переводим в верхний регистр, переведя остальные его символы в нижний 
				}
			}
			else{
				$current_reversed_word = $this->prepareFirstSymbolToUpperCase($current_reversed_word); // В противном случае, делаем то же самое, но с первым словом
			}


			$result[] = $current_reversed_word; //Добавляем перевернутое слово в массив результатов

		}

		return implode(' ', $result); // Возвращаем результат в виде строки
		
	}

	public function setValue(string $value){ //Установить значение словосочетания
		$this->default_words = explode(' ', $value);
	}

	public function getResult() : string{ // Получить результат в виде строки перевернутых слов
		return $this->revertCharacters($this->default_words);
	}

	public function getDefaultWords(){ // Получить необработанный результат
		return implode(' ', $this->default_words);
	}

	private function prepareFirstSymbolToUpperCase(string $word):string{ // Перевести первый символ слова в верхний регистр, переведя при этом остальные его символы в нижний
		return $prepared_word = mb_convert_case(mb_substr($word,0,1), MB_CASE_UPPER) . mb_substr(mb_convert_case($word, MB_CASE_LOWER),1);
	}

	



}










 ?>
