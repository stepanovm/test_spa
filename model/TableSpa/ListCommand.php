<?php


namespace model\TableSpa;


class ListCommand
{

    /** @var string */
    private $orderBy;
    /** @var int */
    private $page = 1;
    /** @var int */
    private $elements = 15; // 15 - how much to display on the page. TODO make a definition in the config
    /** @var string */
    private $filterField;
    /** @var string */
    private $filterOperator;
    /** @var string */
    private $filterValue;

    /**
     * ListCommand constructor.
     * @param null|string $filterField "nm", "qnt", "dst"
     * @param null|string $filterOperator "equals", "match", "greater", "less"
     * @param null|string $filterValue
     * @param null|string $orderBy "nm", "qnt", "dst"
     * @param null|string $orderType "descending", "ascending"
     * @param null|string $page
     * @throws \Exception
     */
    public function __construct(
        ?string $filterField,
        ?string $filterOperator,
        ?string $filterValue,
        ?string $orderBy,
        ?string $orderType,
        ?string $page
    )
    {
        $this->page = filter_var($page, FILTER_VALIDATE_INT) ?: 1;
        $this->parseSortString($orderBy, $orderType);
        $this->parseFilter($filterField, $filterOperator, $filterValue);
    }


    /**
     * @param $filterField
     * @param $filterOperator
     * @param $filterValue
     * @throws \Exception
     */
    public function parseFilter($filterField, $filterOperator, $filterValue): void
    {
        $filterFieldsMap = ['nm' => 'name', 'qnt' => 'quantity', 'dst' => 'distance'];
        $filterOperatorsMap = ['equals' => '=', 'match' => 'LIKE', 'greater' => '>', 'less' => '<'];

        if (!isset($filterField)) {
            return;
        }

        if (!array_key_exists($filterField, $filterFieldsMap) || !array_key_exists($filterOperator, $filterOperatorsMap)) {
            throw new \Exception('invalid value of the filter field');
        }

        $this->filterField = $filterFieldsMap[$filterField];
        $this->filterOperator = $filterOperatorsMap[$filterOperator];
        $this->filterValue = $filterValue;
    }


    /**
     * @param string|null $sortField
     * @param string|null $sortType
     * @throws \Exception
     */
    public function parseSortString(?string $sortField, ?string $sortType): void
    {
        if (!isset($sortField)) {
            return;
        }
        // for security reasons, the request fields are
        // different from the fields in the database
        $sortFieldsMap = ['nm' => 'name', 'qnt' => 'quantity', 'dst' => 'distance'];
        $sortTypesMap = ['descending' => 'DESC', 'ascending' => 'ASC'];

        if (!array_key_exists($sortField, $sortFieldsMap) || !array_key_exists($sortType, $sortTypesMap)) {
            throw new \Exception('invalid value of the sorting field');
        }

        $this->orderBy = $sortFieldsMap[$sortField] . ' ' . $sortTypesMap[$sortType];
    }

    /**
     * @return string
     */
    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return string
     */
    public function getFilterField(): ?string
    {
        return $this->filterField;
    }

    /**
     * @return string
     */
    public function getFilterOperator(): ?string
    {
        return $this->filterOperator;
    }

    /**
     * @return string
     */
    public function getFilterValue(): ?string
    {
        return $this->filterValue;
    }

    /**
     * @return int
     */
    public function getElements(): int
    {
        return $this->elements;
    }




}