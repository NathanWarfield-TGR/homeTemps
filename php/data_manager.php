<?php

//these may not be copy and paste-able but there a close approximation check http://php.net/manual/en/class.mysqli.php for exact syntax

class DataManager {
    static function getCurrentTemps() 
    {
        $dbc = //SOME CONNECTION
        $query = "SELECT pollingTime, insideTemp, garageTemp, outsideTemp FROM v_combinedTemps WHERE pollingTime >= now() - INTERVAL 1 DAY;";
        return $result = $dbc->query($query);
    }

    static function getTempForLocation($location)
    {
        $dbc = //SOME MSQLI CONNECTION
        $stmt = $dbc->prepare($dbc, "SELECT min(A.tempF) as 'MIN', avg(A.tempF) as 'AVG', max(A.tempF) as 'MAX' FROM t_readings A, t_zones B WHERE A.zoneIndex = B.zoneIndex and B.zoneName = ? and A.pollingTime >= now() - INTERVAL 1 DAY");
        $stmt->bind_parm("s", $location);
        return $stmt->execute();
    }
}

?>