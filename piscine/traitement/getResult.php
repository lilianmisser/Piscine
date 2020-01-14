<?php

//fonction créer par @Sophivorus
//celle-çi permet de récupérer dans un tableau le résultat d'une requête préparée
function get_result(\mysqli_stmt $statement){
    $result = array();
    $statement->store_result();
    for ($i = 0; $i < $statement->num_rows; $i++)
    {
        $metadata = $statement->result_metadata();
        $params = array();
        while ($field = $metadata->fetch_field())
        {
            $params[] = &$result[$i][$field->name];
        }
        call_user_func_array(array($statement, 'bind_result'), $params);
        $statement->fetch();
	}
	    return $result;
	}
?>