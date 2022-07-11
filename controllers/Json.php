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
        $inp = file_get_contents($this->jsonFile);
        $tempArray = json_decode($inp, true);

        $tempArray[$_POST['task']] = ['completed' => false];
        file_put_contents($this->jsonFile, json_encode($tempArray, JSON_PRETTY_PRINT));

        header('Location: /to-do/to-do/');
    }

    public function update()
    {
        $inp = file_get_contents($this->jsonFile);
        $jsonArray = json_decode($inp, true);

        foreach ($jsonArray as $jsonName => $jsonValue) {
            if (isset($_POST[$jsonName]))  // if checkbox is set change json value to true, if not set change it to false.
                $jsonArray[$jsonName]['completed'] = true;
            else
                $jsonArray[$jsonName]['completed'] = false;

        }

        $jsonData = json_encode($jsonArray);
        file_put_contents($this->jsonFile, $jsonData);

        header('Location: /to-do/to-do/');
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
        header('Location: /to-do/to-do/');
    }
}