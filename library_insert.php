<?php
include 'params.php';

class database{

	private $connessione;
	private $titolo;
	private $categoria;


// COSTRUTTORE

	public function __construct($host,$dbn,$user,$pwd){

		$this->host=$host;
		$this->dbn=$dbn;
		$this->user=$user;
		$this->pwd=$pwd;


		$this->connetti($this->host, $this->dbn, $this->user, $this->pwd);

	}



// FUNZIONE CONNETTI

	public function connetti($host, $dbn, $user, $pwd){
		try{
			$opt = [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
  ];

			$this->connessione = new PDO("mysql:host=$this->host;dbname=$this->dbn;", $user, $pwd, $opt);

		}catch(PDOException $e){
			echo "Errore: " . $e->getMessage();
			die;



		}

	}

	// select categories

	public function cat_sel ()
	{
		$query = "SELECT * FROM categories";
		$conn = $this->connessione->prepare($query);
		$conn->execute();
	}

	// FUNZIONE INSERT

	public function inserisci($titolo, $categoria){

		try{
			$this->titolo = (string)$this->titolo;
			$this->categoria = (int)$this->categoria;

			

			$dbq = "INSERT INTO books (title, category, created_at) VALUES (:titolo, :categoria, :now)";


		$query = $this->connessione->prepare($dbq);
		$query->bindValue(':titolo', $titolo, PDO::PARAM_INT);
		$query->bindValue(':categoria', $categoria, PDO::PARAM_INT);
		$query->bindValue(':now', date('Y-m-d H:i:s'), PDO::PARAM_STR);

		$query->execute();
		echo "Inserito nuovo libro: $titolo.";


	} catch(PDOException $e) {
	echo "Errore nel caricamento del contenuto";
	print $e->getMessage();
}


}

//FUNZIONE JSON

public function creaJson($id_cat = null){
	$add_query = '';
	if($id_cat > 0){
		$add_query = "WHERE books.category = $id_cat";
	}		
	$risultato = [];
	
	$ogg = $this->connessione->prepare("SELECT title, created_at, name AS category  FROM books LEFT JOIN categories ON categories.id_categories = books.category $add_query");
	$ogg->execute();


	while ($row = $ogg->fetch(PDO::FETCH_ASSOC)){

		$risultato[] = $row;

	}
	echo json_encode($risultato);




}
}
