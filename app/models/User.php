<?php

namespace app\models;

use app\core\Model;

class User extends Model
{
    private $tbl_user = '`users`';

    public function create($user)
    {
        $this->query('INSERT INTO '.$this->tbl_user.' 
        (`email`,`bank_account`,`name`,`last_name`,`zipcode`,`country`,`state`,`city`,`street`,`appartment`,`pass`) VALUES 
        (:email,:bank_account,:name,:last_name,:zipcode,:country,:state,:city,:street,:appartment,:pass)', $user);

        $user_id = $this->getLastInsertId();

        return $user_id;
    }

    public function getByEmail($email, array $fields = []): array
    {
        $res = $this->row('SELECT '.$this->genFields($fields).' FROM '.$this->tbl_user.' WHERE `email` = :email',
                          ['email' => $email]);
        return count($res)? $res[0] : [];
    }

    public function getById(int $id, array $fields=[])
    {
        $res = $this->row('SELECT '.$this->genFields($fields).' FROM '.$this->tbl_user.' WHERE `id` = :id',
                          ['id' => $id]);
        return count($res)? $res[0] : [];
    }

    public function getByIds(array $ids, array $fields = [])
    {
        return $this->row('SELECT '.$this->genFields($fields).' FROM '.$this->tbl_user.' 
                                WHERE `id` IN ('.implode(',', $ids).')');
    }

    public function updateScore(int $user_id, int $score)
    {
        $this->query('UPDATE '.$this->tbl_user.' SET `score` = :score WHERE `id` = :id',
                     ['score' => $score, 'id' => $user_id]);
    }

}