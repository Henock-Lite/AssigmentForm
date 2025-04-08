session_start();
require "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        // Récupération des données du formulaire
        $course = htmlspecialchars(trim($_POST['course']));
        $subject = htmlspecialchars(trim($_POST['subject']));
        $title = htmlspecialchars(trim($_POST['title']));
        $description = htmlspecialchars(trim($_POST['description']));
        $submission_date = htmlspecialchars(trim($_POST['submission_date']));
        $name = htmlspecialchars(trim($_POST['name']));
        $roll_no = htmlspecialchars(trim($_POST['roll_no']));

        // Gestion du fichier
        $Fichier = $_FILES['file']['name'];
        $tmpFichier = $_FILES['file']['tmp_name'];
        $Destination = 'uploads/';
        $cheminDestination = $Destination . basename($Fichier);

        if (!is_dir($Destination)) {
            mkdir($Destination, 0777, true);
        }

        if (move_uploaded_file($tmpFichier, $cheminDestination)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO assignments (course, subject, title, description, submission_date, name, roll_no, file_path) 
                VALUES (:course, :subject, :title, :description, :submission_date, :name, :roll_no, :file_path)");
                $stmt->bindParam(':course', $course);
                $stmt->bindParam(':subject', $subject);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':submission_date', $submission_date);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':roll_no', $roll_no);
                $stmt->bindParam(':file_path', $cheminDestination);

                $stmt->execute();
                echo "Les informations ont été enregistrées avec succès.";
            } catch (PDOException $error) {
                echo "Erreur : " . $error->getMessage();
            }
        } else {
            echo "Erreur lors du téléchargement du fichier.";
        }
    } else {
        echo "Aucun fichier n'a été téléchargé.";
    }
} else {
    echo "Requête invalide.";
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Récupération des données du formulaire ($_POST)
    $course = htmlspecialchars(trim($_POST['course']));
    $subject = htmlspecialchars(trim($_POST['subject']));

    // Gestion du fichier ($_FILES)
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['file']['name'];
        $tmpFile = $_FILES['file']['tmp_name'];
        $destinationFolder = 'uploads/';
        $filePath = $destinationFolder . basename($fileName);

        // Créer le dossier s'il n'existe pas
        if (!is_dir($destinationFolder)) {
            mkdir($destinationFolder, 0777, true);
        }

        // Déplacer le fichier dans le dossier de destination
        if (move_uploaded_file($tmpFile, $filePath)) {
            echo "Fichier téléchargé avec succès : $filePath";

            // Enregistrement des données dans la base de données
            try {
                require "config.php"; // Inclure la connexion à la base de données

                $stmt = $pdo->prepare("INSERT INTO assignments (course, subject, file_path) VALUES (:course, :subject, :file_path)");
                $stmt->bindParam(':course', $course);
                $stmt->bindParam(':subject', $subject);
                $stmt->bindParam(':file_path', $filePath);

                $stmt->execute();
                echo "Les données ont été enregistrées avec succès.";
            } catch (PDOException $e) {
                echo "Erreur lors de l'enregistrement : " . $e->getMessage();
            }
        } else {
            echo "Erreur lors du téléchargement du fichier.";
        }
    } else {
        echo "Aucun fichier n'a été téléchargé ou une erreur s'est produite.";
    }
} else {
    echo "Requête invalide.";
}
?>
// require "config.php";
// if (isset($_POST['submit'])) {
    
//     // Vérifier si un fichier a été téléchargé
//        if (isset($_FILES['file']) && $_FILES['file']['error'] == 0){
//     // Informations sur le fichier téléchargénom
//     $Fichier = $_FILES['file']['name'];
//     $typeFichier = $_FILES['file']['type'];
//     $tailleFichier = $_FILES['file']['size'];
//     $tmpFichier = $_FILES['file']['tmp_name'];
//     $extFichier = pathinfo($Fichier, PATHINFO_EXTENSION); // Obtenir l'extension du fichier
//     // Dossier où les fichiers seront stockésdossier
//     $Destination = 'uploads/';
           
//            // Vérification de l'extension du fichier
//            $extensionsValides = array('jpg', 'jpeg', 'png', 'pdf', 'txt'); // Extensions autorisées
//    if (in_array($extFichier, $extensionsValides)){ 
               
//                // Vérification de la taille du fichier (par exemple, 5 Mo max)
//                if ($tailleFichier <= 2 * 1024 * 1024) {
//     // Créer le dossier s'il n'existe pas
//                    if (!file_exists($Destination)){
//                        mkdir($Destination, 0777, true);
//                    }
//     // Déplacer le fichier téléchargé vers le dossier de destination
//                    $cheminDestination =$Destination . basename($Fichier);
//                    if (move_uploaded_file($tmpFichier, $cheminDestination)) {
//                       echo "Le fichier a été téléchargé avec succès.";
//                    } else {
//                        echo "Une erreur s'est produite lors du téléchargement du fichier.";
//                    }
//                } else {
//                        echo "Le fichier est trop volumineux. La taille maximale autorisée est 5 Mo.";
//                }
//            } else {
//                echo "L'extension du fichier n'est pas autorisée. Seuls les fichiers JPG, PNG, PDF et TXT sont autorisés.";
//            }
//     } else {
//            echo "Aucun fichier n'a été téléchargé.";
//        }
//    }    

