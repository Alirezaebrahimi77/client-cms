<?php

$started =  "01/20";
$finished = "02/21";

function calculateMagazines($started, $finished)
{

    $startedYear = "20" . substr($started, -2);
    $finishedYear = "20" . substr($finished, -2);

    $startedMonth = substr($started, 1, 1);
    $finishedMonth = substr($finished, 1, 1);

    $lehdet = [];

    for ($j = $startedYear; $j <= $finishedYear; $j++) {
        $loppu = 4;
        if ($j == $finishedYear) {
            $loppu = $finishedMonth;
        }
        for ($i = $startedMonth; $i <= $loppu; $i++) {
            $lehdet += [$j => $i];
            // echo $j;
        }

        $startedMonth = 1;
    }
    return $lehdet;
}


$man = " PiRj Ö @jdmm diagoRup.co m ";


$startedYear = "20" . substr($started, -2);
$finishedYear = "20" . substr($finished, -2);

$startedMonth = substr($started, 1, 1);
$finishedMonth = substr($finished, 1, 1);

$failedMail = array();
function clean($string)
{
    error_reporting(0);
    global $failedMail;
    $string = str_replace(' ', '', $string);
    $string = mb_strtolower($string, 'UTF-8');
    $copiedString = $string;

    if(preg_match('[ä|ö]', $string)) {
        array_push($failedMail, $copiedString);
        return;
     }

    $pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i';
    preg_match_all($pattern, $string, $matches);

    if(is_null($matches[0][0])){
        array_push($failedMail, $copiedString);
        return;

    }
    else{
        $com = ".com";
        $fi = ".fi";
        $net = ".net";
        $eu = ".eu";
        $expert = ".expert";
        $prefix = "@";
    
        // If this email contains one of these domains like {...".com"} AND that domain is AFTER @, then do the following
        if (strpos($matches[0][0], $com) && strpos(substr($matches[0][0], strpos($matches[0][0], $prefix) + strlen($prefix)), $com)) {

            $beforeAtSign = substr($matches[0][0], 0, strpos($matches[0][0], $prefix));
            $afterAtSign = substr($matches[0][0], strpos($matches[0][0], $prefix));
            $newValueAfterSign = substr($afterAtSign, 0, strpos($afterAtSign, $com));
            $addDomain = $newValueAfterSign . $com;
            $finalValue = $beforeAtSign . $addDomain;
            return $finalValue;
        }
        if (strpos($matches[0][0], $fi) && strpos(substr($matches[0][0], strpos($matches[0][0], $prefix) + strlen($prefix)), $fi) ) {

            $beforeAtSign = substr($matches[0][0], 0, strpos($matches[0][0], $prefix));
            $afterAtSign = substr($matches[0][0], strpos($matches[0][0], $prefix));
            $newValueAfterSign = substr($afterAtSign, 0, strpos($afterAtSign, $fi));
            $addDomain = $newValueAfterSign . $fi;
            $finalValue = $beforeAtSign . $addDomain;
            return $finalValue;
          
            
        }
        if (strpos($matches[0][0], $net) && strpos(substr($matches[0][0], strpos($matches[0][0], $prefix) + strlen($prefix)), $net)) {

            $beforeAtSign = substr($matches[0][0], 0, strpos($matches[0][0], $prefix));
            $afterAtSign = substr($matches[0][0], strpos($matches[0][0], $prefix));
            $newValueAfterSign = substr($afterAtSign, 0, strpos($afterAtSign, $net));
            $addDomain = $newValueAfterSign . $net;
            $finalValue = $beforeAtSign . $addDomain;
            return $finalValue;
        }
        if (strpos($matches[0][0], ".bosc")) {
            $newValue = substr($matches[0][0], 0, strpos($matches[0][0], ".bosc"));
            return $newValue .= ".bosch.com";
        }
        if (strpos($matches[0][0], $eu) && strpos(substr($matches[0][0], strpos($matches[0][0], $prefix) + strlen($prefix)), $eu)) {

            $beforeAtSign = substr($matches[0][0], 0, strpos($matches[0][0], $prefix));
            $afterAtSign = substr($matches[0][0], strpos($matches[0][0], $prefix));
            $newValueAfterSign = substr($afterAtSign, 0, strpos($afterAtSign, $eu));
            $addDomain = $newValueAfterSign . $eu;
            $finalValue = $beforeAtSign . $addDomain;
            return $finalValue;
        }
        if (!strpos($matches[0][0], $com) || !strpos($matches[0][0], $net) || !strpos($matches[0][0], $fi) || !strpos($matches[0][0], $eu)) {
            return $matches[0][0];
        }
    }

    


}

// var_dump(calculateMagazines($started, $finished));

// var_dump(clean($man));


// $string = 'Ruchika < ruchika@example.com >';
// $string = ": Aki. kontiai nen@netti.fi>";
// $string = ": delta ElemenTti@deltaelementti.fi >";
// $string = "ark@heikkinen-komonen.fiark@heikkinen-komonen.fiark@heikkinen-komonen.fiark@heikkinen-komonen.fiark@heikkinen-komonen.fiark@heikkinen-komonen.fiark@heikkinen-komonen.fi";

// $string = ": a Lir e äzA @ J dMm EDI AgrOUp . Co  Mfdsfsdgdf f<! ";
$string = "asiakaspalvelu@hardwork.expert";

var_dump(clean($string));


var_dump($failedMail);

// $string = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. @ felis diam, mattis id elementum eget, ullamcorper et purus.";
// $prefix = "@";


// $afterAtSign = ;
// echo $afterAtSign;

// $res = strpos(substr($string, strpos($string, $prefix) + strlen($prefix)), $fi);

// var_dump($res);
// $beforeAtSign = substr($string, 0, strpos($string, "@"));

// $afterAtSign = substr($string, strpos($string, "@"));
// $newValueAfterSign = substr($afterAtSign, 0, strpos($afterAtSign, ".fi"));
// $addDomain = $newValueAfterSign . '.fi';

// $finalValue = $beforeAtSign . $addDomain;

// return $finalValue;

// function($prefix, $domain, $string){

//     $beforeAtSign = substr($string, 0, strpos($string, $prefix));
//     $afterAtSign = substr($string, strpos($string, $prefix));
//     $newValueAfterSign = substr($afterAtSign, 0, strpos($afterAtSign, $domain));
//     $addDomain = $newValueAfterSign . $domain;
//     $finalValue = $beforeAtSign . $addDomain;
//     return $finalValue;

// }


// var_dump($finalValue);
