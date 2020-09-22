<?php


namespace model\TableSpa;


class ListRequest
{
    /**
     * @param ListCommand $command
     * @return array TableSpa as array
     */
    public function getRequest(ListCommand $command)
    {
        $tableSpa = new TableSpa();
        return $tableSpa->findByParams(
            $command->getOrderBy(),
            $command->getPage(),
            $command->getElements(),
            $command->getFilterField(),
            $command->getFilterOperator(),
            $command->getFilterValue()
        );
    }
}