<?php

namespace Controllers;

use Db\Db;
use Helpers\Utils;
use PDO;
use Enums\StatusEnum;


class PostsController
{

    public function show() {

        $sql = 'SELECT * FROM posts where status= :status';
        $stmt = Db::conn()->prepare($sql);
        $stmt->execute([
            'status' => StatusEnum::PUBLISHED->value,
        ]);
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }
    public function store() {

    }
    public function edit() {

    }
    public function delete() {

    }
    public function getOne(int $id) {
        $sql = 'SELECT p.name, p.description, p.date, p.status, u.login as author, p.user_id FROM posts as p left join user as u on p.user_id=u.id where p.id= :id';
        $stmt = Db::conn()->prepare($sql);
        $stmt->execute([
            'id' => $id,
        ]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        return $post;
    }
    public function getMy($status = null) {
        $where = '';
        $arrayExecute = [
            'id' => $_SESSION['user']['id']
        ];
        if($status && StatusEnum::{strtoupper($status)}->value) {
            $status = StatusEnum::{strtoupper($status)}->value;
            $where = ' and status = :status';
            $arrayExecute['status'] = $status;
        }

        $sql = "SELECT * FROM posts where user_id= :id" .  $where;
        $stmt = Db::conn()->prepare($sql);
        $stmt->bindParam(':id', $arrayExecute['id'], PDO::PARAM_STR);
        if ($status) {
            $stmt->bindParam(':status', $arrayExecute['status'], PDO::PARAM_STR);
        }

        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }
}