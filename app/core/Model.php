<?php

namespace app\core;

use PDO;

abstract class Model {

	public $db;

    public function __construct()
    {
        $config = require dirname(__FILE__).'/../config/db.php';
        $this->db = new PDO('mysql:host='.$config['host'].';dbname='.$config['name'].'', $config['user'], $config['password']);
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);

        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $stmt->bindValue(':'.$key, $val);
            }
        }
        $stmt->execute();

        return $stmt;
    }

    public function row($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function column($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }

    public function getLastInsertId()
    {
        return $this->db->lastInsertId();
    }

    protected function genFields($fields = [])
    {
        if (!count($fields)) {
            return '*';
        } else {
            return '`'.implode('` ,`',$fields).'`';
        }
    }

}