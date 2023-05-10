<?php
	class Employee {		
		private $id;
		private $number;
		private $text;
		private $image;
		private $date;
				
		public function __construct($id, $number, $text, $date, $image) {
			$this->id = $id;
			$this->number = $number;
			$this->text = $text;
			$this->date = $date;
			$this->image = $image;
		}		
		
		public function getNumber() {
			return $this->number;
		}
		
		public function setNumber($number) {
			$this->number = $number;
		}
		
		public function getText() {
			return $this->text;
		}
		
		public function setText($text) {
			$this->text = $text;
		}

		public function getImage() {
			return $this->image;
		}

		public function setImage($image) {
			$this->image = $image;
		}

		public function setDate($date) {
			$this->date = $date;
		}

		public function getDate() {
			return $this->date;
		}

		public function setId($id) {
			$this->id = $id;
		}

		public function getId() {
			return $this->id;
		}
	}
?>
