<?php

error_reporting(E_ERROR);
set_time_limit(60000);
ini_set('memory_limit', '34M');
date_default_timezone_set('Europe/Istanbul');

define('MYSQL_HOST', 'localhost');
define('MYSQL_DB', 'loto');
define('MYSQL_USER', 'loto');
define('MYSQL_PASS', '*******');

 
try {
   $db = new PDO('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DB, MYSQL_USER, MYSQL_PASS,array(
     PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  ));
} catch ( PDOException $e ){
     print $e->getMessage();
}
  

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
    echo curl_error($ch);
    curl_close($ch);

    return $output;
}

class DB
{
    static $pdo = null;
    static $charset = 'UTF8';
    static $last_stmt = null;

    public static function getVar($query, $bindings = null)
    {
        if (!$stmt = self::query($query, $bindings)) {
            return false;
        }

        return $stmt->fetchColumn();
    }

    public static function query($query, $bindings = null)
    {

        if (is_null($bindings)) {

            if (!self::$last_stmt = self::instance()->query($query)) {
                return false;
            }

        } else {

            self::$last_stmt = self::prepare($query);

            if (!self::$last_stmt->execute($bindings)) {
                return false;
            }

        }

        return self::$last_stmt;
    }

    public static function instance()
    {
        return self::$pdo == null ? self::init() : self::$pdo;
    }

    public static function init()
    {
        self::$pdo = new PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB, MYSQL_USER, MYSQL_PASS);

        self::$pdo->exec('SET NAMES `' . self::$charset . '`');
        self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        return self::$pdo;
    }

    public static function getRow($query, $bindings = null)
    {
        if (!$stmt = self::query($query, $bindings)) {
            return false;
        }

        return $stmt->fetch();
    }

    public static function get($query, $bindings = null)
    {
        if (!$stmt = self::query($query, $bindings)) {
            return false;
        }

        $result = array();

        foreach ($stmt as $row) {
            $result[] = $row;
        }

        return $result;
    }

    public static function exec($query, $bindings = null)
    {
        if (!$stmt = self::query($query, $bindings)) {
            return false;
        }

        return $stmt->rowCount();
    }

    public static function insert($query, $bindings = null)
    {
        if (!$stmt = self::query($query, $bindings)) {
            return false;
        }

        return self::$pdo->lastInsertId();
    }

    public static function getLastError()
    {
        $error_info = self::$last_stmt->errorInfo();
        if ($error_info[0] == 00000) {
            return false;
        }

        return $error_info;
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array(
            array(self::instance(), $name),
            $arguments
        );
    }
}


$types = ["piyango", "sayisal", "sanstopu", "onnumara", "superloto", "superpiyango"];



foreach ($types as $index => $type) {
    $da = Curl("http://www.mpi.gov.tr/sonuclar/listCekilisleriTarihleri.php?tur=" . $type);
    preg_match_all('/\{(?!.*\\\\)(.*?)(?=})/', $da, $list);
	

    foreach ($list[0] as $value) {
        $value = json_decode($value . '}');
        $tarih = substr($value->tarih, 0, 4) . "-" . substr($value->tarih, 4, 2) . "-" . substr($value->tarih, 6, 2);
        $created = date('Y-m-d H:i:s');
        setlocale(LC_TIME, 'tr_TR.UTF-8');
        $tarihmetin = strftime('%d %B %Y', strtotime($tarih));
        
		$numara = $index + 1;
        $state = "1";
        $created_by = "832";
        $access = "1";
        $cekilis	 = $numara;
        $cekilisurl	 = $numara;
        $cekilis     = str_replace(['1', '2', '3', '4', '5', '6'], ['Milli Piyango Çekiliş Sonuçları', 'Sayısal Loto Sonuçları', 'Şans Topu Sonuçları', 'On Numara Sonuçları', 'Süper Loto Sonuçları' , 'Süper Piyango Sonuçları'], $cekilis);
        $cekilisurl  = str_replace(['1', '2', '3', '4', '5', '6'], ['milli-piyango', 'sayisal-loto', 'sans-topu', 'on-numara', 'super-loto' , 'super-piyango' ], $cekilisurl);
		$numara 	 = str_replace(['1'], ['10'], $numara);
        $title		 = $tarihmetin ." ". $cekilis;
        $alias 		 = $cekilisurl ."-". $tarih;
        $images 	 = '{"image_intro":"images\/'.$cekilisurl.'-sonuclari.jpg"}';
        
 
        
        if (DB::exec("SELECT type,date FROM loto_content WHERE type = ? AND date = ?", array($index + 1, $tarih)) == 0) {
            $Rurl = "http://www.mpi.gov.tr/sonuclar/cekilisler/" . $type . "/" . $value->tarih . ".json";
            if ($type == "sayisal") {
                $Rurl = "http://www.mpi.gov.tr/sonuclar/cekilisler/" . $type . "/SAY_" . $value->tarih . ".json";
            } 
 
           $result = cUrl($Rurl);
        if ($result != "" && substr($result, 0, 1) != "<" ) {             
             
$query = $db->prepare("INSERT INTO loto_content SET result = ?, type = ?, date = ?, created = ?, state = ?, title = ?, alias = ?, catid = ?, created_by = ?, images = ?, access = ? ");
$insert = $query->execute(array($result, $index + 1, $tarih, $created, $state, $title, $alias, $numara, $created_by, $images, $access));
           
     echo $result."<br>";
			
        } else {
           echo "hata!"; 
        }
		 

        } else { 
            echo  "ok";
                   }
    }
}