<?php

//interaction sa image like,saved,favorites
class artInteraction {
    private $conn;

    public function __construct($db_conn) {
        $this->conn = $db_conn;
    }
//store database
    public function addToFavorites($a_id) {
        $u_id = $_SESSION['u_id'];

        if ($this->isArtworkFavorited($u_id, $a_id)) {
            return $this->unfavoriteArtwork($a_id); 
        } else {
            $statement = $this->conn->prepare("INSERT INTO favorite (u_id, a_id) VALUES (:u_id, :a_id)");
            $statement->bindValue(':u_id', $u_id);
            $statement->bindValue(':a_id', $a_id);
            return $statement->execute();
        }
       
    }

    public function likeArtwork($a_id) {
        $u_id = $_SESSION['u_id'];

        if ($this->isArtworkLiked($u_id, $a_id)) {
            return $this->unlikeArtwork($a_id); 
        } else {
            $statement = $this->conn->prepare("INSERT INTO likes (u_id, a_id) VALUES (:u_id, :a_id)");
            $statement->bindValue(':u_id', $u_id);
            $statement->bindValue(':a_id', $a_id);
            return $statement->execute();
        }
    }

    public function saveArtwork($a_id) {
        $u_id = $_SESSION['u_id'];


        if ($this->isArtworkSaved($u_id, $a_id)) {
            return $this->unsaveArtwork($a_id); // Return true if unsaved successfully
        } else {
            $statement = $this->conn->prepare("INSERT INTO saved (u_id, a_id) VALUES (:u_id, :a_id)");
            $statement->bindValue(':u_id', $u_id);
            $statement->bindValue(':a_id', $a_id);
            return $statement->execute(); 
        }
    }

    //delete sa database once e unlike or e unsaved or wagtaong sa favorites
    public function unlikeArtwork($a_id) {
        $u_id = $_SESSION['u_id'];
        $statement = $this->conn->prepare("DELETE FROM likes WHERE u_id = :u_id AND a_id = :a_id");
        $statement->bindValue(':u_id', $u_id);
        $statement->bindValue(':a_id', $a_id);
        return $statement->execute();
    }

    public function unsaveArtwork($a_id) {
        $u_id = $_SESSION['u_id'];
        $statement = $this->conn->prepare("DELETE FROM saved WHERE u_id = :u_id AND a_id = :a_id");
        $statement->bindValue(':u_id', $u_id);
        $statement->bindValue(':a_id', $a_id);
        return $statement->execute(); 
    }

    public function unfavoriteArtwork($a_id) {
        $u_id = $_SESSION['u_id'];
        $statement = $this->conn->prepare("DELETE FROM favorite WHERE u_id = :u_id AND a_id = :a_id");
        $statement->bindValue(':u_id', $u_id);
        $statement->bindValue(':a_id', $a_id);
        return $statement->execute(); 
    }



    //tig check if na like ba sa user ang kana na artwork pwede rpd pang display
    private function isArtworkLiked($u_id, $a_id) {
        $query = "SELECT COUNT(*) FROM likes WHERE u_id = :u_id AND a_id = :a_id";
        $statement = $this->conn->prepare($query);
        $statement->bindValue(':u_id', $u_id);
        $statement->bindValue(':a_id', $a_id);
        $statement->execute();
        return $statement->fetchColumn() > 0;
    }


    private function isArtworkSaved($u_id, $a_id) {
        $query = "SELECT COUNT(*) FROM saved WHERE u_id = :u_id AND a_id = :a_id";
        $statement = $this->conn->prepare($query);
        $statement->bindValue(':u_id', $u_id);
        $statement->bindValue(':a_id', $a_id);
        $statement->execute();
        return $statement->fetchColumn() > 0; 
    }

   
    private function isArtworkFavorited($u_id, $a_id) {
        $query = "SELECT COUNT(*) FROM favorite WHERE u_id = :u_id AND a_id = :a_id";
        $statement = $this->conn->prepare($query);
        $statement->bindValue(':u_id', $u_id);
        $statement->bindValue(':a_id', $a_id);
        $statement->execute();
        return $statement->fetchColumn() > 0; 
    }

    //retrieve saved and favorties
    public function getSavedArtworks($u_id) {
        $statement = $this->conn->prepare("
            SELECT art_info.file, art_info.title, art_info.description, art_info.category, art_info.a_id, accounts.u_name, accounts.u_id
            FROM saved 
            JOIN art_info ON saved.a_id = art_info.a_id
            JOIN accounts ON art_info.u_id = accounts.u_id
            WHERE saved.u_id = :u_id
        ");
    
        $statement->bindValue(':u_id', $u_id);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //retrieve favorites
    public function getFavoriteArtworks($u_id) {
        $statement = $this->conn->prepare("
            SELECT art_info.file, art_info.title, art_info.description, art_info.category, art_info.a_id, accounts.u_name, accounts.u_id
            FROM favorite 
            INNER JOIN art_info ON favorite.a_id = art_info.a_id
            INNER JOIN accounts ON art_info.u_id = accounts.u_id
            WHERE favorite.u_id = :u_id
        ");
    
        $statement->bindValue(':u_id', $u_id);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
}



?>