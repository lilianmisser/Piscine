<?php
	include("../connectbdd.php");
    #TO DO : Il faut que ce soit accessible seulement aux admins (rajouter un isAdmin?)
    
    #Fonction prenant une "date"(on ne sait pas encore) et un format de date
    #return true si la date en paramètre correspond au format indiqué, false sinon
    function validateDate($date, $format){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
    
        $errSujet=0;
        $errDate=0;
        $errDate2=0;
        $errGrp=0;
        if(!isset($_POST["nom_sujet"])){
             $errSujet=1;
        }
       if((!isset($_POST["date_session"]) || !validateDate($_POST["date_session"],'Y-m-d'))){    
             $errDate=1;
        }
        if($errDate==0 && date($_POST["date_session"])  < date("Y-m-d") ){
            $errDate2=1;
        }
        if(!isset($_POST["groupes"][0])){
            $errGrp=1;
        }
        if($errSujet==1 || $errDate==1 || $errDate2==1 || $errGrp==1){
            header("Location: ../gererSession.php?errSujet=".$errSujet."&errDate=".$errDate."&errDate2=".$errDate2."&errGrp=".$errGrp."#NewSession");
            exit;
        }
        

        if($requete = $bdd->prepare('SELECT id_sujet FROM sujet_toeic WHERE sujet_toeic.nom_sujet = ?')){
            $requete->bind_param("s",$_POST["nom_sujet"]);
            $requete->execute();
            $requete->store_result();
            if($requete->num_rows == 1){
                $requete->bind_result($sujetid);
                $requete->fetch();
                if($requete = $bdd->prepare("INSERT INTO session (date_session,id_sujet) VALUES (?,?)")){
                    $requete->bind_param("si",$_POST["date_session"],$sujetid);
                    $requete->execute();
                    $sessionid = $requete->insert_id;
                    for($i=0 ; $i < count($_POST["groupes"]) ; $i++){    
                        if($requete = $bdd->prepare("INSERT INTO participe (id_grp,id_session) VALUES (?,?)")){
                            $requete->bind_param("ii",strval($_POST["groupes"][$i]),$sessionid);
                            $requete->execute();
                        }
                    }
                    header("Location: ../gererSession.php?success=1#NewSession");
                    exit;
                }
            }else{
                header("Location: ../gererSession.php?erreur=errBDD#NewSession");
                exit;
            }
        }
    $bdd->close();
?>