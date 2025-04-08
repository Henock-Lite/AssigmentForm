<?php
require "config.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    session_start();
    //Récupérer les données du formulaire
               $course = htmlspecialchars(trim($_POST['course']));
               $subject = htmlspecialchars(trim($_POST['subject']));
               $title = htmlspecialchars(trim($_POST['title']));
               $description = htmlspecialchars(trim($_POST['description']));
               $submission_date = htmlspecialchars(trim($_POST['submission_date']));
               $name = htmlspecialchars(trim($_POST['name']));
               $roll_no = htmlspecialchars(trim($_POST['roll_no']));
               try {
                      
                $stmt = $pdo->prepare("INSERT INTO assignments (course,subject,title,description,submission_date,name,roll_no,file_path) VALUES (:course,:subject,:title,:description,:submission_date,:name,:roll_no,:file)");
                $stmt->bindParam(':course', $course);
                $stmt->bindParam(':subject', $subject);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':submission_date', $submission_date);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':roll_no', $roll_no);
                

                $stmt->execute();
                echo "Les informations ont été enregistrées avec succès.";
            } catch (PDOException $error) {
                echo "Erreur lors de l'enregistrement : " . $error->getMessage();
    
            }
               if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK){

                    
                    $Fichier = $_FILES['file']['name'];
                    $typeFichier = $_FILES['file']['type'];
                    $tailleFichier = $_FILES['file']['size'];
                    $tmpFichier = $_FILES['file']['tmp_name'];
                    $extFichier = pathinfo($Fichier, PATHINFO_EXTENSION); 
                    
                    
                    $Destination = 'uploads/';
                           

                           $extensionsValides = array('jpg', 'jpeg', 'png', 'pdf', 'txt');
                   if (in_array($extFichier, $extensionsValides)){ 
                               
                               
                               if ($tailleFichier <= 2 * 1024 * 1024) {
                    
                                   if (!file_exists($Destination)){
                                       mkdir($Destination, 0777, true);
                                   }
                
                                   $cheminDestination =$Destination . basename($Fichier);
                                   if (move_uploaded_file($tmpFichier, $cheminDestination)) {
               try {
                $stmt = $pdo->prepare("INSERT INTO assignments (file_path) VALUES (:file)");
                  
                   $stmt->bindParam(':file_path', $cheminDestination);
   
                   $stmt->execute();
                   echo "Les informations ont été enregistrées avec succès.";
               } catch (PDOException $error) {
                   echo "Erreur lors de l'enregistrement : " . $error->getMessage();
       
               }
            }
        }else{
            echo"non tele";
        }
    }else{
    echo"ders";
    }
}else{
    echo"dr";
}
 
}
echo "hj";
?>         


