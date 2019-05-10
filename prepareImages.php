<?php



require_once('php/productos/redimencion.php');



function getDirContents($dir, $dir2, &$results = array()){



    $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];



    $files = scandir($dir);

    $counter = 0;



    foreach($files as $key => $value){

        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);

        $path2 = realpath($dir2.DIRECTORY_SEPARATOR.$value);



        if(!is_dir($path)) {

            $tds = explode('/', $path);

            $tds2 = explode('/', $path2);



            $tdir = '';

            $tdir2 = '';

            $tfile = '';

            for($i = 0; $i < (count($tds)-1); $i++){

                $tdir = $tdir . $tds[$i] . '/';

            }

            for($j = 0; $j < (count($tds2)-1); $j++){

                $tdir2 = $tdir2 . $tds2[$j] . '/';

            }

            $tfile = $tds[(count($tds)-1)];

            //echo 'D1:'.$tdir.'<br>D2:'.$tdir2.'<br>F:'.$tfile.'<br><br>';

            $counter += 1;

            redimencionImagen($tdir,$tdir2,$tfile);

        } else if($value != "." && $value != "..") {

            getDirContents($path, $path2, $results);

        }

    }



    echo "Process Time: {$time} for " . $counter . ' files <br>';

}



$subFolder = '0';

echo $subFolder . '<br>';

getDirContents('imagenes/media/GUATEDIRECT_LLC/'.$subFolder, 'imagenes/media/cache/GUATEDIRECT_LLC/'.$subFolder);

echo 'done';

