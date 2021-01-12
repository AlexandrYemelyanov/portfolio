<?php

namespace app\models;

use app\core\Model;

class Raffle extends Model
{
    private $tbl_raffle = '`raffles`';
    private $tbl_prize_phys = '`prize_phys`';

    public function create(int $user_id)
    {
        $this->query('INSERT INTO '.$this->tbl_raffle.' (`user_id`) VALUE (:id)', ['id' => $user_id]);
    }

    public function getByUserId(int $user_id)
    {
        $res = $this->row('SELECT `mon`, `phys` FROM '.$this->tbl_raffle.' WHERE `user_id` = :id', ['id' => $user_id]);
        return count($res)?$res[0]:[];
    }

    public function addMon(int $user_id)
    {
        $this->query('UPDATE '.$this->tbl_raffle.' SET `mon` = `mon`+1 WHERE `user_id` = :id', ['id' => $user_id]);
    }

    public function addPhys(int $user_id)
    {
        $this->query('UPDATE '.$this->tbl_raffle.' SET `phys` = `phys`+1 WHERE `user_id` = :id', ['id' => $user_id]);
    }

    public function getPrizePhys()
    {
        $rows = $this->row('SELECT `name` FROM '.$this->tbl_prize_phys);

        $prizes = [];
        foreach ($rows as $item) {
            $prizes[] = $item['name'];
        }

        return $prizes;
    }

}