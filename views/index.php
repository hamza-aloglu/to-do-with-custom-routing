<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <title>todo</title>
</head>
<body>
<div class="container">
    <form action="/to-do/to-do/insert" method="post" id="form-1">
        <input form="form-1" class="m-2" type="text" placeholder="enter your to-do" name="task">
    </form>

    <div class="row">
        <div class="col-6">
            <?php

            use todo\controllers\Json;

            $json = new JSON('to-do.json');
            $tasks = $json->getRows();

            if ($tasks === false)
                $tasks = [];

            foreach ($tasks as $taskName => $task):
                ?>
                <form id="form-update" action="/to-do/to-do/update" method="post">
                    <br>

                    <div class="row">
                        <div class="col-12" style="height: 30px">
                            <input id="todo" form="form-update" class="" name="<?php echo $taskName ?>"
                                   type="checkbox"<?php if ($task['completed']) echo "checked" ?>>
                            <?php
                            echo $taskName;
                            ?>
                        </div>

                    </div>


                </form>

            <?php
            endforeach;
            ?>
        </div>
        <div class="col-6">
            <?php
            foreach ($tasks as $taskName => $task) :
                ?>
                <br>
                <div class="row">
                    <div class="col-12" style="height: 30px">
                        <form method="post" style="display: inline-block"
                              action="/to-do/to-do/delete?task=<?php echo $taskName ?>">
                            <button type="submit" class="btn btn-outline-primary">delete</button>
                        </form>
                        <br>
                    </div>

                </div>


            <?php
            endforeach;
            ?>

        </div>
    </div>


    <button form="form-update" type="submit" class="btn btn-primary m-3">update</button>


</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous">
</script>

</body>
</html>

