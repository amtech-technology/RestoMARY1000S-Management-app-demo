<?php
/////////////////////////////////////////////////////////////////////////
session_start();
require_once('./config.php');

$type_de_mouvment = htmlspecialchars($_POST['type']);
$produit = htmlspecialchars($_POST['produit']);
$quantite = htmlspecialchars($_POST['quantite']);
$date_du_mouvement = htmlspecialchars($_POST['date']);
$observation = htmlspecialchars($_POST['observation']);
$observationEmp = "Aucune Observation";
$service = htmlspecialchars($_POST['service']);
$responsable_id = $_SESSION['user_uniqueID'];

$unique_id = rand(1000, 100000);

if (!empty($type_de_mouvment) && !empty($produit) && !empty($quantite) && !empty($date_du_mouvement)) {

    $sql_responsable = "SELECT * FROM utilisateur WHERE unique_id = ?";
    $query_responsable = $pdo->prepare($sql_responsable);
    $query_responsable->execute([$responsable_id]);
    $res_responsable = $query_responsable->fetchAll(PDO::FETCH_ASSOC);
    if (count($res_responsable) > 0) {
        foreach ($res_responsable as $row_responsable) {

            $sql_from_prod = "SELECT * FROM produit WHERE nom_produit = ?";
            $query_from_prod = $pdo->prepare($sql_from_prod);
            $query_from_prod->execute([$produit]);
            $res_prod = $query_from_prod->fetchAll(PDO::FETCH_ASSOC);
            if (count($res_prod) > 0) {
                foreach ($res_prod as $row_prod) {
                    if ($type_de_mouvment == "sortie") {
                        $actual_quantity = (int)$row_prod['quantite'] - (int)$quantite;

                        $sql_prod2 = "UPDATE produit SET quantite = ? WHERE nom_produit = ?";
                        $query_prod2 = $pdo->prepare($sql_prod2);
                        if ($query_prod2->execute([$actual_quantity, $produit])) {
                            if (!empty($observation)) {
                                $sql = "INSERT INTO mouvement(`unique_id`,`type_mouvement`,`produit`,`quantite`,`date_mouvement`,`Observation`,`service`,`responsable`) VALUES(?,?,?,?,?,?,?,?)";
                                $query = $pdo->prepare($sql);
                                $execution = $query->execute([$unique_id, $type_de_mouvment, $produit, $quantite, $date_du_mouvement, $observation, $service, $row_responsable['nom_utilisateur']]);
                                if ($execution) {
                                    echo "success";
                                } else {
                                    echo "L'erreur s'est produit lors de l'enregistrement!";
                                }
                            } else {
                                $sql = "INSERT INTO mouvement(`unique_id`,`type_mouvement`,`produit`,`quantite`,`date_mouvement`,`Observation`,`service`,`responsable`) VALUES(?,?,?,?,?,?,?,?)";
                                $query = $pdo->prepare($sql);
                                $execution = $query->execute([$unique_id, $type_de_mouvment, $produit, $quantite, $date_du_mouvement, $observationEmp, $service, $row_responsable['nom_utilisateur']]);
                                if ($execution) {
                                    echo "success";
                                } else {
                                    echo "L'erreur s'est produit lors de l'enregistrement!";
                                }
                            }
                        } else {
                            echo "Le mis-à-jour à echoué dans la table produit";
                        }
                    } else {
                        $actual_quantity = (int)$row_prod['quantite'] + (int)$quantite;

                        $sql_prod2 = "UPDATE produit SET quantite = ? WHERE nom_produit = ?";
                        $query_prod2 = $pdo->prepare($sql_prod2);
                        if ($query_prod2->execute([$actual_quantity, $produit])) {
                            if (!empty($observation)) {
                                $sql = "INSERT INTO mouvement(`unique_id`,`type_mouvement`,`produit`,`quantite`,`date_mouvement`,`Observation`,`service`,`responsable`) VALUES(?,?,?,?,?,?,?,?)";
                                $query = $pdo->prepare($sql);
                                $execution = $query->execute([$unique_id, $type_de_mouvment, $produit, $quantite, $date_du_mouvement, $observation, $service, $row_responsable['nom_utilisateur']]);
                                if ($execution) {
                                    echo "success";
                                } else {
                                    echo "L'erreur s'est produit lors de l'enregistrement!";
                                }
                            } else {
                                $sql = "INSERT INTO mouvement(`unique_id`,`type_mouvement`,`produit`,`quantite`,`date_mouvement`,`Observation`,`service`,`responsable`) VALUES(?,?,?,?,?,?,?,?)";
                                $query = $pdo->prepare($sql);
                                $execution = $query->execute([$unique_id, $type_de_mouvment, $produit, $quantite, $date_du_mouvement, $observationEmp, $service, $row_responsable['nom_utilisateur']]);
                                if ($execution) {
                                    echo "success";
                                } else {
                                    echo "L'erreur s'est produit lors de l'enregistrement!";
                                }
                            }
                        } else {
                            echo "Le mis-à-jour à echoué dans la table produit";
                        }
                    }
                }
            } else {
                echo "Ce produit n'existe pas dans la table produit";
            }
        }
    } else {
        echo "Le responsable n'existe pas!";
    }
} else {
    echo "Remplissez tous les champs s'il vous plaît!";
}
