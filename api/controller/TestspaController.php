<?php

namespace api\controller;


use model\TableSpa;

class TestspaController
{
    public function list()
    {
        try {
            /**
             * init params
             * @var array $params
             */
            $params = $params ?: filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING) ?: [];

            $command = new TableSpa\ListCommand(
                $params['f_by'],
                $params['f_opr'],
                $params['f_val'],
                $params['sortby'],
                $params['sorttype'],
                $params['page']
            );

            $request = new TableSpa\ListRequest();
            $resultTable = $request->getRequest($command);

            echo json_encode($resultTable);

        } catch (\Throwable $ex) {
            echo json_encode(['error' => $ex->getMessage()]);
        }

    }
}