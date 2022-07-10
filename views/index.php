<form action="/to-do/to-do/insert" method="post">
    <input type="text" placeholder="enter your to-do" name="task">
    <br>


<?php
use todo\controllers\Json;

    $json = new JSON('to-do.json');
    $tasks = $json->getRows();
    foreach ($tasks as $taskName => $task)  {
?>
        <input name="<?php echo $taskName ?>" type="checkbox"<?php if ($task['completed']) echo "checked"?>>
<?php
        echo $taskName . '<br>';
    }
?>
</form>

