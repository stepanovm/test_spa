<?php


namespace model\TableSpa;


use core\DB;

class TableSpa
{
    /**
     * @param string|null $orderBy
     * @param int $page
     * @param int $elements
     * @param string|null $filterField
     * @param string|null $filterOperator
     * @param string|null $filterValue
     * @return array
     */
    public function findByParams(?string $orderBy, int $page, int $elements, ?string $filterField, ?string $filterOperator, ?string $filterValue): array
    {
        // init condition
        if (!empty($filterField)) {
            $conditionString = ' WHERE ' . $filterField . ' ' . $filterOperator . ' :filter_value';
            $filterValue = $filterOperator == 'LIKE' ? '%' . $filterValue . '%' : $filterValue;
            $conditionParams = [':filter_value' => $filterValue];
        } else {
            $conditionString = '';
            $conditionParams = [];
        }

        // init orderby
        $orderBy = !empty($orderBy) ? ' ORDER BY ' . $orderBy : '';

        // init limit
        // 15 - how much to display on the page. TODO make a definition in the config
        $limit = ' LIMIT ' . ($page - 1) * $elements . ',' . $elements;

        $query = 'SELECT * FROM table_spa' . $conditionString . $orderBy . $limit;

        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($query);
        $stmt->execute($conditionParams);

        $result = ['spa_data' => $stmt->fetchAll()];

        //$stmt->closeCursor();
        $stmt = $pdo->prepare('SELECT COUNT(*) as cnt FROM table_spa' . $conditionString);
        $stmt->execute($conditionParams);

        $result['spa_size'] = ceil($stmt->fetch()['cnt'] / $elements);


        return $result;
    }

}