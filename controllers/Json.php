<?php

namespace todo\controllers;

class Json
{
    public function __construct(private string $jsonFile)
    {
        if (!file_exists($this->jsonFile))
            throw new \Couchbase\DocumentNotFoundException();
    }

    public function getRows()
    {
        $jsonData = file_get_contents($this->jsonFile);
        $data = json_decode($jsonData, true);
        return !empty($data) ? $data : false;
    }

    public function insert()
    {
        $json = ['completed' => false];
        $json = json_encode(array($_POST['task'] => $json), JSON_FORCE_OBJECT);
        $json = json_decode($json, true);

        $inp = file_get_contents($this->jsonFile);
        $tempArray = json_decode($inp, true);


        $tempArray = array_merge($tempArray, $json);
        $jsonData = json_encode($tempArray);
        file_put_contents($this->jsonFile, $jsonData);

        require __DIR__ . "/../views/index.php";
    }

    public function update()
    {
        $inp = file_get_contents($this->jsonFile);
        $jsonArray = json_decode($inp, true);

        foreach ($jsonArray as $jsonName => $jsonValue) {
            if (isset($_POST[$jsonName]))
                $jsonArray[$jsonName]['completed'] = true;
            else
                $jsonArray[$jsonName]['completed'] = false;

        }

        $jsonData = json_encode($jsonArray);
        file_put_contents($this->jsonFile, $jsonData);

        require __DIR__ . "/../views/index.php";
    }

    public function delete()
    {

        $jsonData = file_get_contents($this->jsonFile);
        $data = json_decode($jsonData, true);

        $tasks = array_keys($data);

        foreach ($tasks as $task) {
            if ($task == $_GET['task']) {
                unset($data[$_GET['task']]);
            }
        }

        $delete = file_put_contents($this->jsonFile, json_encode($data));
        require __DIR__ . '/../views/index.php';
    }
}