<?php
class Model {
    function __construct() {
		$this->db = new Database();
	}

    // them moi du lieu
    function insert($table, $array){
        $cols = array();
        $bind = array();
        foreach($array as $key => $value){
            $cols[] = $key;
            $bind[] = "'".$value."'";
        }
        $query = $this->db->query("INSERT INTO ".$table." (".implode(",", $cols).") VALUES (".implode(",", $bind).")");
        return $query;
    }

    // cap nhat du lieu
    function update($table, $array, $where){
        $set = array();
        foreach($array as $key => $value){
            $set[] = $key." = '".$value."'";
        }
        $query = $this->db->query("UPDATE ".$table." SET ".implode(",", $set)." WHERE ".$where);
        return $query;
    }

    // xoa du lieu
    function delete($table, $where = ''){
        if($where == ''){
            $query = $this->db->query("DELETE FROM ".$table);
        }else{
        $query = $this->db->query("DELETE FROM ".$table." WHERE ".$where);
        }
        return $query;
    }
///////////////////////////// cac ham khac //////////////////////////////////////////////////////////////////////////////////
    function get_detail_import_pro($code){
        $query = $this->db->query("SELECT id_product AS id, qty, imp_price, exp_price, (SELECT title
                                FROM tbl_sanpham WHERE tbl_sanpham.id = id_product) AS title, (SELECT title
                                FROM tbldm_donvitinh WHERE tbldm_donvitinh.id = (SELECT donvitinh_id FROM tbl_sanpham
                                WHERE tbl_sanpham.id = id_product)) AS dvt FROM tbl_imports_detail WHERE code = '$code'");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function get_detail_sellers($code){
        $query = $this->db->query("SELECT id, qty, (SELECT title FROM tbl_sanpham WHERE tbl_sanpham.id = id_product)
                                    AS title, exp_price, discount FROM tbl_sellers_detail WHERE code = '$code'");
        return $query->fetchAll();
    }
    function get_all_seller_pass_date($date){
        $query = $this->db->query("SELECT id_product, exp_price, qty, discount, (SELECT imp_price FROM tbl_sanpham 
                                    WHERE tbl_sanpham.id = id_product) AS imp_price FROM tbl_sellers_detail 
                                    WHERE tbl_sellers_detail.code IN (SELECT code FROM tbl_sellers 
                                    WHERE DATE_FORMAT(date_seller, '%Y-%m-%d') = '$date')");
        return $query->fetchAll();
    }
    function get_all_seller_pass_month($month){
        $query = $this->db->query("SELECT id_product, exp_price, qty, discount, (SELECT imp_price FROM tbl_sanpham 
                                    WHERE tbl_sanpham.id = id_product) AS imp_price FROM tbl_sellers_detail 
                                    WHERE tbl_sellers_detail.code IN (SELECT code FROM tbl_sellers 
                                    WHERE DATE_FORMAT(date_seller, '%m-%Y') = '$month')");
        return $query->fetchAll();
    }
    function get_all_seller_pass_year($year){
        $query = $this->db->query("SELECT id_product, exp_price, qty, discount, (SELECT imp_price FROM tbl_sanpham 
                                    WHERE tbl_sanpham.id = id_product) AS imp_price FROM tbl_sellers_detail 
                                    WHERE tbl_sellers_detail.code IN (SELECT code FROM tbl_sellers 
                                    WHERE DATE_FORMAT(date_seller, '%Y') = '$year')");
        return $query->fetchAll();
    }
/////////////////////////////////////end cac ham khac ///////////////////////////////////////////////////////////////////////
}

?>
