<?php
require_once 'connectdb.php';
setlocale(LC_TIME, 'tr_TR.UTF-8');
function Curl($Url)
{
    if (!function_exists('curl_init')) {
        die('Sorry cURL is not installed!');
    }

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpcode != 200) {

        return "";
    }
    if ($output == '{}') {

        $output = Curl($Url);
    }



    echo curl_error($ch);
    curl_close($ch);

    return $output;
}
$db_milli_sonuc_json = '{
    "haneSayisi": {},
    "tip": "${}_RAKAM",
    "ikramiye": "{}",
    "numaralar": [
        {}
    ]

}';
$db_milli_json = '{
    "cekilisNo": {},
    "cekilisTuru": "{}",
    "cekilisTarihi": "{}",
    "haneSayisi": 6,
    "birinciKategoriAdi": "{}",
    "birinciKategoriSonucu": [
        "{}"
    ],
    "ikinciKategoriAdi": "{}",
    "ikinciKategoriSonucu": [
        "{}"
    ],
    "raporUrl": "{}",
    "sonuclar": [
            {}
    ],
    "buyukIkrKazananIlIlceler": []
}';
$db_bilen_json =
    '{
    "oid": "",
    "kisiBasinaDusenIkramiye": {},
    "kisiSayisi": {},
    "tur": "${}_BILEN"
}';
$db_json =
    '{
    "success": true,
    "data": {
        "oid": "",
        "hafta": "",
        "buyukIkramiyeKazananIl": "",
        "cekilisNo": {},
        "cekilisTarihi": "{}",
        "cekilisTuru": "{}",
        "rakamlar": "{}",
        "rakamlarNumaraSirasi": "{}",
        "devretti": "",
        "devirSayisi": "",
        "bilenKisiler": [
            {}
        ],
        "buyukIkrKazananIlIlceler": [],
        "kibrisHasilati": 0,
        "devirTutari": 0,
        "kolonSayisi": 0,
        "kdv": 0,
        "toplamHasilat": 0,
        "hasilat": 0,
        "sov": 0,
        "ikramiyeEH": 0,
        "buyukIkramiye": 0,
        "haftayaDevredenTutar": 0,
        "youtube": "{}"
    }
}';
function format($msg, $vars)
{
    $vars = (array)$vars;

    $msg = preg_replace_callback('#\{\}#', function ($r) {
        static $i = 0;
        return '{' . ($i++) . '}';
    }, $msg);

    return str_replace(
        array_map(function ($k) {
            return '{' . $k . '}';
        }, array_keys($vars)),

        array_values($vars),

        $msg
    );
}
$insert_sql = "INSERT INTO `loto_data` (`result`, `type`, `date`, `created`, `state`, `hits`, `title`, `alias`) 
VALUES ('{}','{}','{}','{}','{}','{}','{}','{}') ";
$control_sql = "select COUNT(*) as counter from loto_data where alias='{}'";
$type = array(1 => 'millipiyango', 5 => 'superloto', 2 => 'sayisaloto');
$type_literal = array(1 => 'PIYANGO', 2 => 'SAYISAL_LOTO', 5 => 'SUPER_LOTO');
$date_url = "https://www.millipiyangoonline.com/sisalsans/result.{}.{}.{}.json";
$result_url = "https://www.millipiyangoonline.com/sisalsans/drawdetails.{}.{}.{}.json";
$youtube_url = "https://www.millipiyangoonline.com/sisalsans/getyoutubeid.{}.{}.{}.json";
$youtube_embed_url = "https://www.youtube.com/embed/{}";
foreach ($type as $type_key => $type_name) {
    for ($month = 1; $month <= 12; $month++) {
        // get current year 
        $year = date('Y');
        $date = format($date_url, array($type_name, $month, $year));
        $date_json = curl($date);
        $date_data = json_decode($date_json, true);
        foreach ($date_data as $value) {
            // echo "number : ".$value['drawnNr'] ."\t" .$type_name ."\n";
            // Generate required urls for instance 
            $draw_number = $value['drawnNr'];
            $draw_year = $value['drawYear'];
            $date_now = date("Y-m-d h:m:s"); // this format is string comparable
            $loto_datetime = $value['drawDateTime'];
            $loto_date = $value['drawDate'];
            // echo "Today is the day : " .$date_now ."\n";
            // echo $value['drawDateTime'] ."\n";
            // echo $loto_datetime . " " . $date_now . "\t" . $loto_datetime > $date_now . "\n";
            if ($loto_datetime > $date_now) {

                break;
            }

            if ($draw_number != null) {
                if ($type_key != 1) {
                    $result = format($result_url, array($type_name, $draw_number, $draw_year));
                } else {
                    $result = format($result_url, array("millypiyango", $draw_number, $draw_year));
                }
                // hotfix for 'sayısaloto' to 'sayısalloto' for youtube_id :/
                if ($type_key != 2) {
                    $youtube = format($youtube_url, array($type_name, $draw_number, $draw_year));
                } else {
                    $youtube = format($youtube_url, array('sayisalloto', $draw_number, $draw_year));
                }
                // Fetch Json Data From Instance urls
                $result_json = curl($result);
                // echo $result_json;
                if (!$result_json) {
                    break;
                }
                $youtube_json = curl($youtube);


                $result_data = json_decode($result_json);
                // Parse Json into Data
                if ($youtube_json) {
                    // echo "youtube result=" .$youtube_json ."\t" .$youtube ."\n";
                    $youtube_data = json_decode($youtube_json);


                    // $youtube_link = $youtube_data->yt;
                    if ($youtube_data->yt) {
                        $youtube_link = format($youtube_embed_url, array($youtube_data->yt));
                    } else {
                        $youtube_link = "";
                    }
                } else {
                    $youtube_link = "";
                }
                // echo $youtube_json ."\t " .$youtube_data->yt ."\t" .$youtube ."\n" ;
                // add youtube link to result json
                // $result_data->youtube = $youtube_link;
                // echo $youtube_link;
                // $result_json = json_encode($result_data);



                $cekilisTarihi = $result_data->dateDetails;
                $cekilisTuru = $type_literal[$type_key];
                $cekilisNo = $draw_number;
                $db_result = "";

                if ($cekilisTarihi) {
                    if ($type_key == 1) {

                        $birinci_kategori_adi = $result_data->firstCategoryName ?: "";

                        $birinci_kategori_sonucu = join(",", $result_data->firstCategoryWinning);
                        // foreach ($result_data->firstCategoryWinning as $bir_sonuc) {
                        //     $poststr = "";
                        //     if ($numaralar) {
                        //         $poststr = ",";
                        //     }

                        //     $birinci_kategori_sonucu .= $poststr .$bir_sonuc ;
                        // }
                        $ikinci_kategori_adi = $result_data->secondCategoryName ?: "";
                        $ikinci_kategori_sonucu = join(",", $result_data->secondCategoryWinning);
                        $rapor_url = "https://www.millipiyangoonline.com/milli-piyango/" . $result_data->reportURL ?: "";


                        // foreach ($winningSeries as $winner) {
                        //     $poststr = "";
                        //     if ($numaralar) {
                        //         $poststr = ",";
                        //     }

                        //     $numaralar .= $poststr .'"'.$winner .'"';
                        // }
                        $sonuclar = array();
                        foreach ($result_data->categories as $sonuc) {
                            $hane_sayisi = $sonuc->numberExtract;
                            $tip = $sonuc->numberExtract;
                            $ikramiye = $sonuc->category;
                            $numaralar = join(",", $sonuc->winningSeries);
                            $res_str = format($db_milli_sonuc_json, array(
                                $hane_sayisi,
                                $tip,
                                $ikramiye,
                                $numaralar
                            ));
                            $sonuclar[] = $res_str;
                        }

                        $db_result = format($db_milli_json, array(
                            $cekilisNo,
                            $cekilisTuru,
                            $cekilisTarihi,
                            $birinci_kategori_adi,
                            $birinci_kategori_sonucu,
                            $ikinci_kategori_adi,
                            $ikinci_kategori_sonucu,
                            $rapor_url,
                            join(",", $sonuclar)
                        ));
                    } elseif ($type_key == 2 || $type_key == 5) {

                        $tableResult = $result_data->tableResult;
                        $winningNumber = join('#', array_merge($result_data->winningNumber, $result_data->numberJolly));
                        $winningNumber2 = join(' - ', array_merge($result_data->winningNumber, $result_data->numberJolly));

                        $bilenler = "";
                        foreach ($tableResult as $bilen) {
                            $poststr = "";
                            if ($bilenler) {
                                $poststr = ",";
                            }
                            $res_str =  format($db_bilen_json, array(
                                $bilen->prizeWinner,
                                $bilen->totalWinners,
                                str_replace('+', '_', $bilen->numbersMatched)
                            ));
                            $bilenler .= $poststr . $res_str;
                        }
                        $db_result = format($db_json, array(
                            $cekilisNo,$cekilisTarihi, $cekilisTuru, $winningNumber, $winningNumber2, $bilenler,
                            $youtube_link
                        ));
                    }
                    // echo $db_result;
                    // echo "Result: ".$type_key ." " .$result_data->dateDetails . "\n";
                    // echo $youtube_json ."\t " . json_decode($result_json)->youtube ."\t".$result ."\n";
                    $alias = $type_name . "-" . strftime('%Y-%m-%d', strtotime($cekilisTarihi));;




                    $literal_date =  strftime('%d %B %Y', strtotime($cekilisTarihi));
                    $title = $literal_date . " " . ucfirst(strtolower(str_replace("_", " ", $type_literal[$type_key]))) . " Sonuçları";
                    $sql_query_data = format($insert_sql, array($db_result, $type_key, $loto_datetime, $date_now, 1, 0, $title, $alias));

                    $r = $conn->query(format($control_sql, array($alias)));
                    // echo format($control_sql,array($alias));
                    $row = $r->fetch_assoc();
                    if ($row['counter'] < 1) {
                        if ($conn->query($sql_query_data) === TRUE) {
                            echo "New record created successfully\t alias:" . $alias . "\t url:" . $result . "\n";
                        } else {
                            echo "Error: " . $sql_query_data . "\n" . $conn->error;
                        }
                    } else {
                        echo "Record already Exists\t" . $alias . "\n";
                    }
                }
            }
        }
    }
}
$conn->close();
