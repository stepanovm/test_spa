<?php

namespace api\controller;


use api\model\Testspa\Testspa;

class TestspaController
{
    public function list()
    {
        try {
            /** @var array $params */
            $params = filter_input_array(INPUT_GET) ?: [];

            $testSpa = new Testspa();
            echo json_encode($testSpa->getManyByParams($params));
        } catch (\Throwable $ex) {
            echo json_encode(['error' => $ex->getMessage()]);
        }

    }
}