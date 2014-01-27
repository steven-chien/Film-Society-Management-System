<?php
class movie {

	private $queryString;

	private $ID;
	private $type;
	private $Title;
	private $Director;
	private $Actors;
	private $Plot;
	private $Poster;
	private $Runtime;
	private $Genre;
	private $Released;
	private $Year;
	private $Rated;
	private $imdb;
	private $Status;

	function __construct($ID, $type, $title, $status, $year=NULL) {

		$this->ID = $ID;
		$this->type = $type;
		$this->name = $title;
		$this->Year = $year;
		$this->Status = $status;
		$this->queryString = "http://www.omdbapi.com/?t=";
	}

	private function dateConvert($date) {

		if($date=="N/A")
			return "N/A";

		$token = strtok($date, ' ');
		$day = $token;

		$token = strtok(' ');
		if($token=="Dec")
			$month = '12';
		else if($token=="Nov")
			$month = '11';
		else if($token=="Oct")
			$month = '10';
		else if($token=="Sep")
			$month = '9';
		else if($token=="Aug")
			$month = '8';
		else if($token=="Jul")
			$month = '7';
		else if($token=="Jun")
			$month = '6';
		else if($token=="May")
			$month = '5';
		else if($token=="Apr")
			$month = '4';
		else if($token=="Mar")
			$month = '3';
		else if($token=="Feb")
			$month = '2';
		else if($token=="Jan")
			$month = '1';
		$token = strtok(' ');
		$year = $token;

		return trim($year) . '-' . trim($month) . '-' . trim($day);
	}

	private function timeConvert($time) {

		if($time=="N/A") {
			return "N/A";
		}

		$tempA = strlen($time);

		$token = strtok($time, 'h');

		if($tempA==strlen($token)) {
			$hour = 0;
			$min = trim($token);
		}
		else {
			$hour = trim($token);
			if(($token=strtok('h'))!=false)
				$min = trim($token);
		}

		return $hour . ':' . $min . ':0';
	}

	public function parse() {

		$token = strtok($this->name, ' ');
		while($token!=false) {

			$this->queryString .= $token . '+';
			$token = strtok(' ');
		}

		if($this->Year!=NULL) {
			$this->queryString .= '&y=' . $this->Year;
		}

		$ch = curl_init($this->queryString);
		$file = fopen("/tmp/movie.json", "w");
                
		curl_setopt($ch, CURLOPT_FILE, $file);
		curl_setopt($ch, CURLOPT_HEADER, 0);

		curl_exec($ch);
		curl_close($ch);
		fclose($file);

		$data = json_decode(file_get_contents('/tmp/movie.json'), true);
                #var_dump($data);
                if($data['Response']=='False') {
                    echo $this->Title . ' not inserted<br>';
                    throw new Exception('Response from server is false');
                }
                else {
                    $this->Title = $data['Title'];
                    $this->Released = $this->dateConvert($data['Released']);
                    $this->Director = $data['Director'];
                    $this->Writer = $data['Writer'];
                    $this->Actors = $data['Actors'];
                    $this->Plot = $data['Plot'];
                    if($data['Poster']!="N/A")
			$this->Poster = $data['Poster'];
                    else
			$this->Poster = "N/A";
                    $this->Runtime = $this->timeConvert($data['Runtime']);
                    $this->Genre = $data['Genre'];
                    $this->Year = $data['Year'];
                    $this->Rated = $data['Rated'];
                    $this->imdb = $data['imdbID'];
                }
	}

	public function storeData() {

		$mysql = mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['password'], $_SESSION['db']);
                if(!$mysql) {
                    throw new Exception(mysqli_connect_error());
                }

		$queryString = sprintf("INSERT INTO movie(ID, Title, Year, Rated, Released, Runtime, Genre, Director, Writer, Actor, Plot, Poster, imdb, Media, Status) VALUES(\"%s\", \"%s\", \"%s\", \"%s\", \"%s\", \"%s\", \"%s\", \"%s\", \"%s\", \"%s\", \"%s\", \"%s\", \"%s\", \"%s\", \"%s\")", mysqli_real_escape_string($mysql,$this->ID), mysqli_real_escape_string($mysql,$this->Title), mysqli_real_escape_string($mysql,$this->Year), mysqli_real_escape_string($mysql,$this->Rated), mysqli_real_escape_string($mysql,$this->Released), mysqli_real_escape_string($mysql,$this->Runtime), mysqli_real_escape_string($mysql,$this->Genre), mysqli_real_escape_string($mysql,$this->Director), mysqli_real_escape_string($mysql,$this->Writer), mysqli_real_escape_string($mysql,$this->Actors), mysqli_real_escape_string($this->Plot), mysqli_real_escape_string($mysql,$this->Poster), mysqli_real_escape_string($mysql,$this->imdb), $this->type, mysqli_real_escape_string($mysql,$this->Status));
                
		$result = $mysql->query($queryString);

		if(!$result) {
                        throw new Exception(mysqli_error($mysql));
		}

		mysqli_close($mysql);
		echo $this->Title . ' inserted<br>';
	}

}
?>
