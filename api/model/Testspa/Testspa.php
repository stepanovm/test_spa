<?php


namespace api\model\Testspa;


use api\model\DB;

class Testspa
{
    /**
     * @param array|null $params
     * @return array
     * @throws \Exception
     */
    public function getManyByParams(array $params = null): array
    {
        $sortBy = $this->parseParamsSort($params['sortBy'], $params['sortType']);

        $filter = [];

        $filterFieldsMap = ['nm' => 'name', 'qnt' => 'quantity', 'dst' => 'distance'];
        $filterOperatorsMap = ['equals' => '=', 'contains' => 'LIKE', 'greater' => '>', 'less' => '<'];

        if (isset($params['filterField']) && isset($params['filterOperator']) && isset($params['filterValue'])) {
            $a = 0;
        }


        $pdo = DB::getPdo();
        $stmt = $pdo->prepare('SELECT * FROM table_spa ' . $sortBy);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * return mysql qyury string (ORDER BY ... )
     * @param string $sortStr incoming string
     * @param string $sortType incoming string
     * @return string
     * @throws \Exception
     */
    private function parseParamsSort(string $sortStr = null, string $sortType = null): string
    {
        // for security reasons, the request fields are
        // different from the fields in the database
        $sortFieldsMap = ['nm' => 'name', 'qnt' => 'quantity', 'dst' => 'distance'];
        $sortTypesMap = ['descending' => 'DESC', 'ascending' => 'ASC'];
        $sortBy = '';

        if (isset($sortStr)) {
            $sortArr = [];
            foreach (explode(',', $sortStr) as $sortparam) {
                // verification of the sort fields
                if (!array_key_exists($sortparam, $sortFieldsMap)) {
                    throw new \Exception('invalid value of the sorting field');
                }
                $sortArr[] = $sortFieldsMap[$sortparam];
            }
            $sortBy = ' ORDER BY ' . implode(', ', $sortArr);
        }

        $sortBy .= $sortType ? ' ' . $sortTypesMap[$sortType] : '';
        return $sortBy;
    }

}