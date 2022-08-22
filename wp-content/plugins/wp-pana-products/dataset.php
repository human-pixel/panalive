<?php
class WPPANADataset
{
    private $prefixedTableName;
    /**
     * WPPANADataset constructor.
     * @param $tableName - name of table
     */
    public function __construct($tableName){
        //FIXME: if you want to parametrise tableName then find a way to sanitise it against SQL injection (missing here)
        global $wpdb; $this->prefixedTableName = $tableName;
    }

    /**
     * Return resultset of a table with given limit applied.
     * @Table Products
     * @param $args array
     * @return mixed
     */

    public function get_products($args=false){
        global $wpdb;  //echo '<pre>'; print_r($args); echo '</pre>';
        $series=!empty($args['series'])?$args['series']:'G';
        $type=!empty($args['type'])?$args['type']:'Camera';
        $qry=sprintf("SELECT %s FROM $this->prefixedTableName WHERE active = 1 AND type='$type' AND series='$series' ", "*");
        return $wpdb->get_results($qry, OBJECT);
    }
    public function get_eligibility_criteria($args=false){
        global $wpdb;  //echo '<pre>'; print_r($args); echo '</pre>';
        $qry=sprintf("SELECT %s FROM $this->prefixedTableName WHERE status=1 AND membership!='Black' AND price!=0 ORDER BY id DESC ", "*");
        return $wpdb->get_results($qry, OBJECT);
    }

}