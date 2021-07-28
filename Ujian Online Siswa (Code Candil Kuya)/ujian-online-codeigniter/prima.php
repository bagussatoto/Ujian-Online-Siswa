<?php
$result=[];
for ($i=1; $i <= 50 ; $i++) {     // for 1, adalah bilangan yang akan di cek

    $t = 0;  

        for ($j=1; $j <= $i ; $j++) {  // for 2, bilangan pembagi 

            if ($i % $j == 0) { 
                $t++;
            }
           
        }

    if ($t == 2) {   // syarat atau kondisi bilangan prima
        $result[]=$i;
    }
}
$result