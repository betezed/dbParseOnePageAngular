<?php
include('config.php');
header("Content-Type: application/json");
$column = isset($_REQUEST['column']) ? $_REQUEST['column'] : false;
$result = array();
if (!$column) {
    $sql = '
        SELECT COLUMN_NAME
        FROM information_schema.columns
        WHERE TABLE_SCHEMA = "' . $db_name . '" 
        ORDER BY COLUMN_NAME ASC
    ';
    $req = $db->prepare($sql);
    $req->execute();
    $columns = $req->fetchAll();
    foreach($columns as $column) {
        if ($column['COLUMN_NAME'] != "age")
            $result[] = $column['COLUMN_NAME'];
    }
} else {

    /*
     * Total number of value and rowss
     */
    $sql = "SELECT COUNT(DISTINCT(`" . $column . "`)) AS total_values, COUNT(*) AS total_rows FROM `" . $table_name . "`";
    $req = $db->prepare($sql);
    $req->execute();
    $res_total = $req->fetchAll();
    $total_values = $res_total[0]['total_values'];
    $total_rows = $res_total[0]['total_rows'];

    /*
     * Selecting the 100 first values, with count of rows and age average
     */
    $sql = "SELECT `" . $column . "` AS name, AVG(age) AS age, COUNT(*) AS total FROM `" . $table_name . "` GROUP BY `" . $column . "` ORDER BY `total` DESC LIMIT 100";
    $req = $db->prepare($sql);
    $req->execute();
    $res = $req->fetchAll();
    $rows_displayed = 0;
    $datas = array();
    $data = array();
    foreach($res as $value) {
        $data['name'] = !is_null($value['name']) ? $value['name'] : "None";
        $data['age'] = !is_null($value['age']) ? intval($value['age']) : "None";
        $data['total'] = !is_null($value['total']) ? $value['total'] : "None";
        $datas[] = $data;
        $rows_displayed += $value['total'];
    }
    $result = array(
        "datas"=> $datas,
        "total"=> array(
            "total_values"=> $total_values,
            "total_rows"=> intval($total_rows),
            "total_rows_displayed"=> $rows_displayed,
            "total_rows_not_displayed"=> intval($total_rows) - $rows_displayed
        )
    );
}
print(json_encode($result));
