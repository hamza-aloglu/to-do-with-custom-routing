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
        // update if checked...
        $json = ['completed' => false];
        $json = json_encode(array($_POST['task'] => $json), JSON_FORCE_OBJECT);
        $json = json_decode($json, true);


        $inp = file_get_contents($this->jsonFile);
        $tempArray = json_decode($inp, true);

        $tempArray = $this->update($tempArray);

        $tempArray = array_merge($tempArray, $json);
        $jsonData = json_encode($tempArray);
        file_put_contents($this->jsonFile, $jsonData);

        require __DIR__ . "/../views/index.php";
    }

    private function update($jsonArray)
    {
        foreach ($jsonArray as $jsonName => $jsonValue) {
            if (isset($_POST[$jsonName]))
                $jsonArray[$jsonName]['completed'] = true;
            else
                $jsonArray[$jsonName]['completed'] = false;

        }

        return $jsonArray;
    }
}