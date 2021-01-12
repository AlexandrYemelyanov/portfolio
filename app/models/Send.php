<?php

namespace app\models;

use app\core\Model;

class Send extends Model
{
    private $tbl_send = '`prize_to_send`';

    public function add(int $user_id, int $sum)
    {
        $this->query('INSERT INTO '.$this->tbl_send.' (`user_id`,`sum`) VALUES (:id,:sum)',
                     ['id' => $user_id, 'sum' => $sum]);

        return $this->getLastInsertId();
    }

    public function getAll(int $count_row=0)
    {
        $limit = '';
        if ($count_row) {
            $limit = ' LIMIT 0, '.$count_row;
        }
        return $this->row('SELECT * FROM '.$this->tbl_send.$limit);
    }

    public function removeByIds(array $ids)
    {
        $this->query('DELETE FROM '.$this->tbl_send.' WHERE `id` IN ('.implode(',', $ids).')');
    }

}