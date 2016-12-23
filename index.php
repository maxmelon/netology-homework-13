<?php
require_once "config.php";
require_once "autoloader.php";
$db = new DataBase();
$db->connectToDB();
$tasks = new Tasks($db);

// Проверяем, есть ли запросы от пользователя на изменение данных. Если есть, выполняем.
$tasks->action();
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TO-DO приложение</title>
    <style>
        table, td, th {
            border: 1px solid #ddd;
            text-align: left;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 15px;
        }

        tr:hover{background-color:#f5f5f5}

        form {
            text-align: center;
        }

        h2 {
            text-align: center;
        }

        .button {
            font: bold 11px Arial;
            text-decoration: none;
            background-color: #EEEEEE;
            color: #333333;
            padding: 2px 6px 2px 6px;
            border-top: 1px solid #CCCCCC;
            border-right: 1px solid #333333;
            border-bottom: 1px solid #333333;
            border-left: 1px solid #CCCCCC;
        }
    </style>
</head>
<body>
<h1  style="text-align: center">Список дел</h1>
<div style="text-align: center; margin: 20px">
    <form method="POST">
        <label for="new_task">Новая задача: </label><input type="text" name="new_task" value=""/>
        <input type="submit" name="save" value="Добавить"/>
        <label for="sort" style="margin-left: 30px">Сортировать по:</label>
        <select name="sort_by">
            <option value="date_added">Дате добавления</option>
            <option value="is_done">Статусу</option>
            <option value="description">Описанию</option>
        </select>
        <input type="submit" name="sort" value="Отсортировать" />
    </form>
</div>
<?php $allTasks = $tasks->allTasks(); ?>
<table>
    <tr>
        <th style="text-align: center">Дата добавления</th>
        <th style="text-align: center">Описание задачи</th>
        <th style="text-align: center">Статус</th>
        <th style="text-align: center">Действия</th>
    </tr>
    <?php foreach ($allTasks as $task): ?>
    <tr>
        <td>
            <?php if (isset($_POST['change']) && $_POST['change'] == $task['id']): ?>
            <form method="post">
                <input type="text" name="new_date_added" value="<?php echo $task['date_added']?>">
                <button type="submit" name="change_id" value="<?php echo $task['id']?>">Сохранить</button>
            <?php else: echo $task['date_added'];
            endif; ?>
        </td>
        <td><?php if (isset($_POST['change']) && $_POST['change'] == $task['id']): ?>
                    <input type="text" name="new_description" value="<?php echo $task['description']?>">
                    <button type="submit" name="change_id" value="<?php echo $task['id']?>">Сохранить</button>
            <?php else: echo $task['description'];
            endif; ?></td>
        <td><?php if (isset($_POST['change']) && $_POST['change'] == $task['id']): ?>
                <select name="new_is_done">
                    <option value="0">Не выполнено</option>
                    <option value="1">В процессе</option>
                    <option value="2">Выполнено</option>
                </select>
                    <button type="submit" name="change_id" value="<?php echo $task['id']?>">Сохранить</button>
                </form>
            <?php else: echo $task['is_done'];
            endif; ?></td>
        <td>
            <form method="post">
                <?php if ($task['is_done'] !== 'Выполнено') : ?>
                    <button type="submit" value="<?php echo $task['id']?>" name="mark_as_done">Выполнить</button>
                <?php endif; ?>
                <button type="submit" value="<?php echo $task['id']?>" name="change">Изменить</button>
                <button type="submit" value="<?php echo $task['id']?>" name="delete">Удалить</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>

