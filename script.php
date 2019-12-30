<?php

// Composer Autoload.
require_once __DIR__ . "/vendor/autoload.php";

use Config\Config;
Config::get();

$connAL = new PDO("mysql:host=".$json["hostAL"].";port=". $json["portAL"] .";dbname=".$json["databaseAL"], $json["userAL"], $json["passwordAL"], array(PDO::ATTR_PERSISTENT => true));

$TOTAL = $connAL->query("SELECT 
            count(*) as qtd 
        FROM webmail 
        INNER JOIN usuarios from_usu ON (from_usu.usu_cod = webmail.webm_from) 
        INNER JOIN usuarios to_usu ON (to_usu.usu_cod = webmail.webm_to) 
        WHERE 
            from_usu.has_cometchat = 1 AND to_usu.has_cometchat = 1 "
)->fetch()["qtd"];

echo $TOTAL . " mensagens\n";

while (true) {
    $mensagens = array();
    $mensagens = capturaMensagens($connAL, $i*4000);
    insereMensagens($connCC, $mensagens);
    if ($STOP){
        $connAL = NULL;
        $connCC = NULL;
        break;
    }
    $i++;
}

function capturaMensagens($link, $offset){
    global $STOP;
    global $TOTAL;
    echo "Capturando...\n";
    $mensagens = array();

    $query = "SELECT 
        (select usu_id from usuarios where usu_cod=webm_from) as mail_from, 
        (select usu_id from usuarios where usu_cod=webm_to) as mail_to, 
        CONVERT(CAST(webm_texto as BINARY) USING utf8) webm_texto, 
        webm_data 
    FROM webmail
    INNER JOIN 
        usuarios from_usu ON (from_usu.usu_cod = webmail.webm_from)
        INNER JOIN
        usuarios to_usu ON (to_usu.usu_cod = webmail.webm_to)
    WHERE 
        from_usu.has_cometchat = 1 AND
        to_usu.has_cometchat = 1 AND
        webmail.webm_deleted = 'N'
    LIMIT 4000
    OFFSET $offset";

    foreach ($link->query($query) as $row){
        array_push($mensagens, array(
                "from"  => $row["mail_from"],
                "to"    => $row["mail_to"],
                "texto" => $row["webm_texto"],
                "sent"  => $row["webm_data"])
        );
    }
    $count = count($mensagens);
    if ($count < 1999){
        $STOP = TRUE;
    }
    echo $count . " mensagens capturadas\n->".($offset +$count)*100/$TOTAL. "%\n";
    return $mensagens;
}

function insereMensagens($link, $mensagens){
    $regex = "/.+?(?=--------------------------------------------------------)/s";
    $insert =  "INSERT INTO 
            cometchat (cometchat.from, cometchat.to, cometchat.message, cometchat.sent, cometchat.read) 
        VALUES ";
    $vals = "(%s, %s, '%s', %s, 1),";
    foreach ($mensagens as $mensagem){
        $texto = $mensagem["texto"];
        if (strpos($mensagem["texto"], '--------------------------------------------------------') !== false){
            preg_match($regex, $mensagem["texto"], $matches);
            $texto = $matches[0];
        }
        $texto = str_replace("\\", "", str_replace("'", "", trim($texto)));
        $insert .= sprintf($vals, $mensagem["from"], $mensagem["to"], $texto, strtotime($mensagem["sent"]));

    }

    if (!$link->exec(rtrim($insert,","))){
        print_r($link->errorInfo());
        echo strlen($insert);
        exit;
    }

}