<?php

class Database {

    var $host = "";
    var $user = "";
    var $password = "";
    var $database = "";
    var $selectdb = false;
    var $conn = NULL;
    var $result = false;

    function Database() {
        $config = new Config();
        $this->host = $config->host;
        $this->user = $config->user;
        $this->password = $config->password;
        $this->database = $config->database;
    }

    function open() {
        $this->conn = new MongoClient();
        $db = $this->database;
        return $this->conn->$db;
    }

    function find($table, $cond = null, $key = null, $sort = '-1', $skip = null, $limit = null) {
        $find = '';
        $find = $this->open()->$table->find($cond);
        if (!empty($key)) {
            $find = $find->sort(array($key => $sort));
        }
        if (!empty($skip)) {
            $find = $find->skip($skip);
        }
        if (!empty($limit)) {
           $find = $find->limit($limit);
        }
        
        return $find;
    }

    function insert($table, $datas = null) {
        return $this->open()->$table->insert($datas);
    }
    
    function update($table, $id, $data = null) {
      if(!empty($id)){
        return $this->open()->$table->update(array('_id' => $id),array('$set'=>$data));
      }
    }
    
    function delete($table, $id, $cond = null) {
      if(!empty($id)){
        return $this->open()->$table->remove(array('_id' => new MongoInt32($id)));
      }
    }

    function numRows($table, $cond = null) {
        return $this->open()->$table->count($cond);
    }

    function getNextSequence($fieldName) {
        $keys = $this->open()->counters->findAndModify(array('_id' => $fieldName), array('$inc' => array("seq" => 1)), null, array(
            "new" => true,
        ));
        return (int) $keys['seq'];
    }

    function lookup($sql, $skip = 0, $limit = 10) {
        $keys = $this->open()->$sql['mainCollection']->aggregate(
                array('$lookup' => array(
                        'from' => $sql['joinCollection'],
                        'localField' => $sql['localField'],
                        'foreignField' => $sql['foreignField'], // uid = _id.$id
                        'as' => $sql['as']
                    )),
                array('$match'=>$sql['match']),
                array('$sort'=>$sql['sort']),
                array('$skip'=>$skip),
                array('$limit'=>$limit)
        
                
                   
        );
        return $keys;
    }
    
    
    

}

?>