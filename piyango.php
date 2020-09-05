<?php
require_once 'connectdb.php';
// // Perform query
// $result = $conn -> query("SELECT * FROM loto_data ORDER BY date DESC LIMIT 1");
//     $row = mysqli_fetch_assoc($result);
//     echo "selected row is : ".$row['date'] ."\n";
//     // Free result set
//     $result -> free_result();
  
function format($msg, $vars)
{
    $vars = (array)$vars;

    $msg = preg_replace_callback('#\{\}#', function($r){
        static $i = 0;
        return '{'.($i++).'}';
    }, $msg);

    return str_replace(
        array_map(function($k) {
            return '{'.$k.'}';
        }, array_keys($vars)),

        array_values($vars),

        $msg
    );
}
    $insert_sql = "INSERT INTO `loto_data` (`id`, `result`, `type`, `date`, `created`, `state`, `hits`, `title`, `alias`) 
    VALUES ('{}','{}','{}','{}','{}','{}','{}','{}','{}') ";
    $control_sql = "select COUNT(*) as counter from loto_data where alias='{}'";
    $type = array(5=>'superloto',2=>'sayisaloto');
    $date_url = "https://www.millipiyangoonline.com/sisalsans/result.{}.{}.{}.json";
    $result_url = "https://www.millipiyangoonline.com/sisalsans/drawdetails.{}.{}.{}.json";
    $youtube_url = "https://www.millipiyangoonline.com/sisalsans/getyoutubeid.{}.{}.{}.json";
    $youtube_embed_url = "https://www.youtube.com/embed/{}";
    foreach ($type as $type_key => $type_name){
        for ($month = 1; $month <= 12; $month++) {
            // $month = 9;
            $year = 2020;
            $date = format($date_url,array($type_name,$month,$year));
            $date_json = file_get_contents($date);
            $date_data = json_decode($date_json, true);
            foreach ($date_data as $value){
                // echo "number : ".$instance['drawnNr'];
                // Generate required urls for instance 
                $draw_number = $value['drawnNr'];
                $draw_year = $value['drawYear'];
                $date_now = date("Y-m-d h:m:s"); // this format is string comparable
                $loto_datetime = $value['drawDateTime'];
                $loto_date = $value['drawDate'];
                // echo "Today is the day : " .$date_now ."\n";
                // echo $value['drawDateTime'] ."\n";
                if ($loto_datetime>$date_now){
                    break;
                }
                
                if ($draw_number != null){
                    $result= format($result_url,array($type_name,$draw_number,$draw_year));

                    // hotfix for 'sayısaloto' to 'sayısalloto' for youtube_id :/
                    if($type_key!=2){
                        $youtube= format($youtube_url,array($type_name,$draw_number,$draw_year));
                    }else{
                        $youtube= format($youtube_url,array('sayisalloto',$draw_number,$draw_year));
                    }
                    // Fetch Json Data From Instance urls
                    $result_json = file_get_contents($result);
                    $youtube_json = file_get_contents($youtube);
                    // Parse Json into Data
                    $result_data = json_decode($result_json);
                    $youtube_data = json_decode($youtube_json);
                    // $youtube_link = $youtube_data->yt;
                    if($youtube_data->yt){
                    $youtube_link = format($youtube_embed_url,array($youtube_data->yt));
                    }else{
                    $youtube_link="";
                    }
                    // echo $youtube_json ."\t " .$youtube_data->yt ."\t" .$youtube ."\n" ;
                    // add youtube link to result json
                    $result_data->youtube = $youtube_link;
                    // echo $youtube_link;
                    $result_json = json_encode($result_data);
                    // echo "Result: ".$type_key ." " .$result_data->dateDetails . "\n";
                    // echo $youtube_json ."\t " . json_decode($result_json)->youtube ."\t".$result ."\n";

                    $alias =$type_name.".".$draw_number.".".$draw_year;
                    $sql_query_data = format($insert_sql,array($draw_number.$draw_year,$result_json,$type_key,$loto_datetime,$date_now,1,0,$loto_date,$alias));
                    
                    $r=$conn->query(format($control_sql,array($alias)));
                    // echo format($control_sql,array($alias));
                    $row = $r->fetch_assoc();
                    if($row['counter'] < 1) {
                        if ($conn->query($sql_query_data) === TRUE) {
                            echo "New record created successfully\n";
                        } else {
                            echo "Error: " . $sql_query_data . "\n" . $conn->error;
                        }
                    }else{
                        echo "Record already Exists\n";
                    }
                }
            }
        }
    }
    $conn->close();
?>