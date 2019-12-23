<?php
	include("connectbdd.php");
    #TO DO : Il faut que ce soit accessible seulement aux admins (rajouter un isAdmin?)
    
    #Fonction prenant une "date"(on ne sait pas encore) et un format de date
    #return true si la date en paramètre correspond au format indiqué, false sinon
    function validateDate($date, $format){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
    
    if(isset($_POST["nom_sujet"]) && isset($_POST["date_session"])){
        if($_POST["nom_sujet"] == ""){
            header("Location: creation_session.php?erreur=Veuillez entrer un nom de sujet non vide");
            exit;
        }
        elseif(!(validateDate($_POST["date_session"],'Y-m-d'))){    
            header("Location: creation_session.php?erreur=Date non valide");
            exit;
        }
        elseif( date($_POST["date_session"])  < date("Y-m-d") ){
            header("Location: creation_session.php?erreur=Veuillez insérez une date qui est aujourd'hui ou après");
            exit;    
        }
    

        if($requete = $bdd->prepare('SELECT id_sujet FROM sujet_toeic WHERE sujet_toeic.nom_sujet = ?')){
            $requete->bind_param("s",$_POST["nom_sujet"]);
            $requete->execute();
            $requete->store_result();
            if($requete->num_rows == 0){
                header("Location: creation_session.php?erreur=Il n'existe pas de sujet avec ce nom");
                exit;
            }
            elseif($requete->num_rows == 1){
                $requete->bind_result($sujetid);
                $requete->fetch();
                if($requete = $bdd->prepare("INSERT INTO session (date_session,id_sujet) VALUES (?,?)")){
                    $requete->bind_param("si",$_POST["date_session"],$sujetid);
                    $requete->execute();
                    header("Location: creation_session.php");
                }
            }
        }
    }
    else{
        header("Location: page_accueil.php");
        exit;
    }
    $bdd->close();
?>