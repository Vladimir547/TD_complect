<?php

namespace Controllers;

use Db\Db;
use Helpers\Utils;
use PDO;
use Enums\StatusEnum;


class PostsController
{

    public function show()
    {

        $sql = 'SELECT * FROM posts where status= :status';
        $stmt = Db::conn()->prepare($sql);
        $stmt->execute([
            'status' => StatusEnum::PUBLISHED->value,
        ]);
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }

    public function store(string $name, string $description)
    {
        $name = Utils::sanitize($name);
        $description = Utils::sanitize($description);
        $data = ['status' => 'success'];
        if (strlen($name) < 1 && strlen($description) < 1) {
            Utils::setFlash('post_error', 'Описание и название не должно быть пустым!');
            $data['status'] = 'error';

            echo json_encode($data);
        } else {

            $sql = 'INSERT INTO posts (name, description, date, status, user_id) VALUES (:name, :description, :dates, :status, :user_id)';
            $stmt = Db::conn()->prepare($sql);

            $stmt->execute([
                'name' => $name,
                'description' => $description,
                'dates' => date('Y-m-d H:i:s'),
                'status' => StatusEnum::WAIT->value,
                'user_id' => $_SESSION['user']['id']
            ]);

            Utils::setFlash('post_success', 'Запись добавлена!');
            echo json_encode($data);
        }
    }

    public function edit(string $id,string $name,string $description)
    {
        $id = Utils::sanitize($id);
        $name = Utils::sanitize($name);
        $description = Utils::sanitize($description);
        $data = ['status' => 'success'];
        if (strlen($name) < 1 && strlen($description) < 1) {
            Utils::setFlash('post_edit_error', 'Описание и название не должно быть пустым!');
            $data['status'] = 'error';

            echo json_encode($data);
        } else {

            $sql = 'UPDATE posts SET name = :name, description = :description  WHERE id = :id';
            $stmt = Db::conn()->prepare($sql);

            $stmt->execute([
                'id' => $id,
                'name' => $name,
                'description' => $description,
            ]);

            Utils::setFlash('post_edit_success', 'Запись обновленна!');
            echo json_encode($data);
        }
    }

    public function delete(int $id)
    {
        $sql = 'DELETE FROM posts WHERE  id= :id';
        $stmt = Db::conn()->prepare($sql);
        $stmt->execute([
            'id' => $id,
        ]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        return true;
        ;
    }

    public function getOne(int $id)
    {
        $sql = 'SELECT p.id,p.name, p.description, p.date, p.status, u.login as author, p.user_id FROM posts as p left join user as u on p.user_id=u.id where p.id= :id';
        $stmt = Db::conn()->prepare($sql);
        $stmt->execute([
            'id' => $id,
        ]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        return $post;
    }

    public function getMy($status = null)
    {
        $where = '';
        $arrayExecute = [
            'id' => $_SESSION['user']['id']
        ];
        if ($status && StatusEnum::{
        strtoupper($status)}->value) {
        $status = StatusEnum::{
            strtoupper($status)}->value;
            $where = ' and status = :status';
            $arrayExecute['status'] = $status;
        }

        $sql = "SELECT * FROM posts where user_id= :id" . $where;
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