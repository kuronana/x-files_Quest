<?php include('inc/head.php'); ?>
<?php


    /*if ($dossier = opendir('./files/')) {

        while (false !== ($fichier = readdir($dossier))) {
            if ($fichier != '.' && $fichier != '..') {
                echo '<li>'. $fichier . '</li>';
                if ($dossier = opendir('./files/')) {

                    while (false !== ($fichier = readdir($dossier))) {
                        if ($fichier != '.' && $fichier != '..') {
                            echo '<li>'. $fichier . '</li>';
                        }
                    }
                }
            }
        }
    }*/



    function xfiles($dir)
    {
        echo '<ul>';
        if (isset($_GET['delete'])) {
            unlink($dir. DIRECTORY_SEPARATOR .$_GET['delete']);
        }
        if (isset($_GET['deleteAll'])) {
            rmdir($dir. DIRECTORY_SEPARATOR .$_GET['deleteAll']);
        }
        $tab1 = scandir($dir);

        foreach ($tab1 as $file1) {
            if ($file1 != '.' && $file1 != '..') {
                if(is_dir($dir. DIRECTORY_SEPARATOR .$file1)){


                    echo '<li style="color: red;">' .$file1 . '<a style="color: yellow;" href="?deleteAll=' .$file1. '">      Delete</a></li>';
                    echo "<br/>";
                    xfiles($dir. DIRECTORY_SEPARATOR .$file1);
                }
                else
                {
                    echo '<li style="color: orange">'.$file1.'<a style="color: yellow;" href="?delete=' .$file1.'">      Delete</a> <a style="color: rebeccapurple;" href="?edit=' .$file1. '">      Edit</a> </li>';
                    echo '<br/>';
                    $mime = mime_content_type($dir. DIRECTORY_SEPARATOR .$_GET['edit']);
                    echo $mime;
                    if ($_GET['edit'] == $file1 && $mime == "text/plain" or $_GET['edit'] == $file1 && $mime == "text/html") {

                        if (isset($_POST["contenu"])) {
                            $fileEdit = $dir. DIRECTORY_SEPARATOR .$_GET['edit'];
                            $edit = fopen($fileEdit, "w");
                            fwrite($edit, $_POST["contenu"]);
                            fclose($edit);

                        }

                        $contEdit = file_get_contents($dir. DIRECTORY_SEPARATOR .$_GET['edit']);
                        ?>

                        <form method="post"">
                            <textarea style="height: 200px; width: 100%;" name="contenu"><?=$contEdit?></textarea>
                            <input type="submit" value="envoyer">
                        </form>


                        <?php
                    }
                    echo '<br/>';
                }
            }
        }
        echo '</ul>';
    }

xfiles('files');

?>
<?php include('inc/foot.php'); ?>