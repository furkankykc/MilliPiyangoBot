<?php 
// function Curl($Url)
// {
//     if (!function_exists('curl_init')) {
//         die('Sorry cURL is not installed!');
//     }

//     $ch = curl_init();

//     curl_setopt($ch, CURLOPT_URL, $Url);
//     curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201");
//     curl_setopt($ch, CURLOPT_HEADER, 0);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//     curl_setopt($ch, CURLOPT_TIMEOUT, 30);

//     $output = curl_exec($ch);
//     $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

//     if($httpcode!=200){
        
//         return "";
//     }
//     if($output=='{}'){

//         $output = Curl($Url);
//     }


        
//     echo curl_error($ch);
//     curl_close($ch);

//     return $output;
// }

// $result ="https://www.millipiyangoonline.com/sisalsans/getyoutubeid.superloto.3.2020.json";
// $result_json = curl($result);
// $result_data = json_decode($result_json);
// echo $result_json
setlocale(LC_TIME, 'tr_TR.UTF-8');

echo strftime('%Y-%m-%d', strtotime("08/30/2020"));

// $tableResult = $result_data->tableResult;

// $cekilisTarihi = $result_data ->dateDetails;
// $cekilisTuru = "";
// $winningNumber = join('#', array_merge($result_data->winningNumber,$result_data->numberJolly));
// $winningNumber2 = join(' - ', array_merge($result_data->winningNumber,$result_data->numberJolly));
// $bilen1= $tableResult[2]->prizeWinner;
// $kazanan1= $tableResult[2]->totalWinners;
// echo $cekilisTarihi ." -- ".$kazanan1;


// $db_json = 
// '{
//     "success": true,
//     "data": {
//         "oid": "",
//         "hafta": "",
//         "buyukIkramiyeKazananIl": "",
//         "cekilisTarihi": "{},
//         "cekilisTuru": "{}",
//         "rakamlar": "{}",
//         "rakamlarNumaraSirasi": "{}",
//         "devretti": "",
//         "devirSayisi": "",
//         "bilenKisiler": [
//             {
//                 "oid": "",
//                 "kisiBasinaDusenIkramiye": {},
//                 "kisiSayisi": {},
//                 "tur": "$3_BILEN"
//             },
//             {
//                 "oid": "",
//                 "kisiBasinaDusenIkramiye": {},
//                 "kisiSayisi": {},
//                 "tur": "$4_BILEN"
//             },
//             {
//                 "oid": "",
//                 "kisiBasinaDusenIkramiye": {},
//                 "kisiSayisi": {},
//                 "tur": "$5_BILEN"
//             },
//             {
//                 "oid": "",
//                 "kisiBasinaDusenIkramiye": {},
//                 "kisiSayisi": {},
//                 "tur": "$6_BILEN"
//             }
//         ],
//         "buyukIkrKazananIlIlceler": [],
//         "kibrisHasilati": 0,
//         "devirTutari": 0,
//         "kolonSayisi": 0,
//         "kdv": 0,
//         "toplamHasilat": 0,
//         "hasilat": 0,
//         "sov": 0,
//         "ikramiyeEH": 0,
//         "buyukIkramiye": 0,
//         "haftayaDevredenTutar": 0
//     }
// }';
?>