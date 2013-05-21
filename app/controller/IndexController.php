<?php
class IndexController extends \Rokko\Controller {
	public function test() {
		$str = "Parent: ". parent::test(). "<br/>";
		$person = new Person();
		$str .= $person->name;
		return $str;
	}	
}
