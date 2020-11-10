<?php 
use PHPUnit\Framework\TestCase;



class WordsTest extends TestCase
{
	private $words;

	protected function setUp() : void{
		$this->words = new \App\Words();
	}

	public function testRevertEquals(){
		$this->words->setValue('Привет! Давно не виделись');
		$this->assertEquals('Тевирп! Онвад ен ьсиледив',$this->words->getResult());
		$this->words->setValue('Что то такое, чего я ранее не видел.');
		$this->assertEquals('Отч от еокат, огеч я еенар ен ледив.',$this->words->getResult());
	}
}



 ?>