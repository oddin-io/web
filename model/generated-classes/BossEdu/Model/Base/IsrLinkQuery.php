<?php

namespace BossEdu\Model\Base;

use \Exception;
use \PDO;
use BossEdu\Model\IsrLink as ChildIsrLink;
use BossEdu\Model\IsrLinkQuery as ChildIsrLinkQuery;
use BossEdu\Model\Map\IsrLinkTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'isr_link' table.
 *
 * 
 *
 * @method     ChildIsrLinkQuery orderByInstructionId($order = Criteria::ASC) Order by the instruction_id column
 * @method     ChildIsrLinkQuery orderByBuildingCode($order = Criteria::ASC) Order by the building_code column
 * @method     ChildIsrLinkQuery orderByRoomNumber($order = Criteria::ASC) Order by the room_number column
 * @method     ChildIsrLinkQuery orderByWeekday($order = Criteria::ASC) Order by the weekday column
 * @method     ChildIsrLinkQuery orderByStartTime($order = Criteria::ASC) Order by the start_time column
 * @method     ChildIsrLinkQuery orderByEndTime($order = Criteria::ASC) Order by the end_time column
 * @method     ChildIsrLinkQuery orderByStartDate($order = Criteria::ASC) Order by the start_date column
 *
 * @method     ChildIsrLinkQuery groupByInstructionId() Group by the instruction_id column
 * @method     ChildIsrLinkQuery groupByBuildingCode() Group by the building_code column
 * @method     ChildIsrLinkQuery groupByRoomNumber() Group by the room_number column
 * @method     ChildIsrLinkQuery groupByWeekday() Group by the weekday column
 * @method     ChildIsrLinkQuery groupByStartTime() Group by the start_time column
 * @method     ChildIsrLinkQuery groupByEndTime() Group by the end_time column
 * @method     ChildIsrLinkQuery groupByStartDate() Group by the start_date column
 *
 * @method     ChildIsrLinkQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildIsrLinkQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildIsrLinkQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildIsrLinkQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildIsrLinkQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildIsrLinkQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildIsrLinkQuery leftJoinInstruction($relationAlias = null) Adds a LEFT JOIN clause to the query using the Instruction relation
 * @method     ChildIsrLinkQuery rightJoinInstruction($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Instruction relation
 * @method     ChildIsrLinkQuery innerJoinInstruction($relationAlias = null) Adds a INNER JOIN clause to the query using the Instruction relation
 *
 * @method     ChildIsrLinkQuery joinWithInstruction($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Instruction relation
 *
 * @method     ChildIsrLinkQuery leftJoinWithInstruction() Adds a LEFT JOIN clause and with to the query using the Instruction relation
 * @method     ChildIsrLinkQuery rightJoinWithInstruction() Adds a RIGHT JOIN clause and with to the query using the Instruction relation
 * @method     ChildIsrLinkQuery innerJoinWithInstruction() Adds a INNER JOIN clause and with to the query using the Instruction relation
 *
 * @method     ChildIsrLinkQuery leftJoinRsAvailable($relationAlias = null) Adds a LEFT JOIN clause to the query using the RsAvailable relation
 * @method     ChildIsrLinkQuery rightJoinRsAvailable($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RsAvailable relation
 * @method     ChildIsrLinkQuery innerJoinRsAvailable($relationAlias = null) Adds a INNER JOIN clause to the query using the RsAvailable relation
 *
 * @method     ChildIsrLinkQuery joinWithRsAvailable($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RsAvailable relation
 *
 * @method     ChildIsrLinkQuery leftJoinWithRsAvailable() Adds a LEFT JOIN clause and with to the query using the RsAvailable relation
 * @method     ChildIsrLinkQuery rightJoinWithRsAvailable() Adds a RIGHT JOIN clause and with to the query using the RsAvailable relation
 * @method     ChildIsrLinkQuery innerJoinWithRsAvailable() Adds a INNER JOIN clause and with to the query using the RsAvailable relation
 *
 * @method     \BossEdu\Model\InstructionQuery|\BossEdu\Model\RsAvailableQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildIsrLink findOne(ConnectionInterface $con = null) Return the first ChildIsrLink matching the query
 * @method     ChildIsrLink findOneOrCreate(ConnectionInterface $con = null) Return the first ChildIsrLink matching the query, or a new ChildIsrLink object populated from the query conditions when no match is found
 *
 * @method     ChildIsrLink findOneByInstructionId(int $instruction_id) Return the first ChildIsrLink filtered by the instruction_id column
 * @method     ChildIsrLink findOneByBuildingCode(string $building_code) Return the first ChildIsrLink filtered by the building_code column
 * @method     ChildIsrLink findOneByRoomNumber(int $room_number) Return the first ChildIsrLink filtered by the room_number column
 * @method     ChildIsrLink findOneByWeekday(int $weekday) Return the first ChildIsrLink filtered by the weekday column
 * @method     ChildIsrLink findOneByStartTime(string $start_time) Return the first ChildIsrLink filtered by the start_time column
 * @method     ChildIsrLink findOneByEndTime(string $end_time) Return the first ChildIsrLink filtered by the end_time column
 * @method     ChildIsrLink findOneByStartDate(string $start_date) Return the first ChildIsrLink filtered by the start_date column *

 * @method     ChildIsrLink requirePk($key, ConnectionInterface $con = null) Return the ChildIsrLink by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIsrLink requireOne(ConnectionInterface $con = null) Return the first ChildIsrLink matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildIsrLink requireOneByInstructionId(int $instruction_id) Return the first ChildIsrLink filtered by the instruction_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIsrLink requireOneByBuildingCode(string $building_code) Return the first ChildIsrLink filtered by the building_code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIsrLink requireOneByRoomNumber(int $room_number) Return the first ChildIsrLink filtered by the room_number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIsrLink requireOneByWeekday(int $weekday) Return the first ChildIsrLink filtered by the weekday column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIsrLink requireOneByStartTime(string $start_time) Return the first ChildIsrLink filtered by the start_time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIsrLink requireOneByEndTime(string $end_time) Return the first ChildIsrLink filtered by the end_time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIsrLink requireOneByStartDate(string $start_date) Return the first ChildIsrLink filtered by the start_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildIsrLink[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildIsrLink objects based on current ModelCriteria
 * @method     ChildIsrLink[]|ObjectCollection findByInstructionId(int $instruction_id) Return ChildIsrLink objects filtered by the instruction_id column
 * @method     ChildIsrLink[]|ObjectCollection findByBuildingCode(string $building_code) Return ChildIsrLink objects filtered by the building_code column
 * @method     ChildIsrLink[]|ObjectCollection findByRoomNumber(int $room_number) Return ChildIsrLink objects filtered by the room_number column
 * @method     ChildIsrLink[]|ObjectCollection findByWeekday(int $weekday) Return ChildIsrLink objects filtered by the weekday column
 * @method     ChildIsrLink[]|ObjectCollection findByStartTime(string $start_time) Return ChildIsrLink objects filtered by the start_time column
 * @method     ChildIsrLink[]|ObjectCollection findByEndTime(string $end_time) Return ChildIsrLink objects filtered by the end_time column
 * @method     ChildIsrLink[]|ObjectCollection findByStartDate(string $start_date) Return ChildIsrLink objects filtered by the start_date column
 * @method     ChildIsrLink[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class IsrLinkQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \BossEdu\Model\Base\IsrLinkQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\BossEdu\\Model\\IsrLink', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildIsrLinkQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildIsrLinkQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildIsrLinkQuery) {
            return $criteria;
        }
        $query = new ChildIsrLinkQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj = $c->findPk(array(12, 34, 56, 78, 91), $con);
     * </code>
     *
     * @param array[$instruction_id, $building_code, $room_number, $weekday, $start_time, $end_time, $start_date] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildIsrLink|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = IsrLinkTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2]), (null === $key[3] || is_scalar($key[3]) || is_callable([$key[3], '__toString']) ? (string) $key[3] : $key[3]), (null === $key[4] || is_scalar($key[4]) || is_callable([$key[4], '__toString']) ? (string) $key[4] : $key[4]), (null === $key[5] || is_scalar($key[5]) || is_callable([$key[5], '__toString']) ? (string) $key[5] : $key[5]), (null === $key[6] || is_scalar($key[6]) || is_callable([$key[6], '__toString']) ? (string) $key[6] : $key[6])])))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(IsrLinkTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildIsrLink A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT instruction_id, building_code, room_number, weekday, start_time, end_time, start_date FROM isr_link WHERE instruction_id = :p0 AND building_code = :p1 AND room_number = :p2 AND weekday = :p3 AND start_time = :p4 AND end_time = :p5 AND start_date = :p6';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);            
            $stmt->bindValue(':p2', $key[2], PDO::PARAM_INT);            
            $stmt->bindValue(':p3', $key[3], PDO::PARAM_INT);            
            $stmt->bindValue(':p4', $key[4] ? $key[4]->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);            
            $stmt->bindValue(':p5', $key[5] ? $key[5]->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);            
            $stmt->bindValue(':p6', $key[6] ? $key[6]->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildIsrLink $obj */
            $obj = new ChildIsrLink();
            $obj->hydrate($row);
            IsrLinkTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2]), (null === $key[3] || is_scalar($key[3]) || is_callable([$key[3], '__toString']) ? (string) $key[3] : $key[3]), (null === $key[4] || is_scalar($key[4]) || is_callable([$key[4], '__toString']) ? (string) $key[4] : $key[4]), (null === $key[5] || is_scalar($key[5]) || is_callable([$key[5], '__toString']) ? (string) $key[5] : $key[5]), (null === $key[6] || is_scalar($key[6]) || is_callable([$key[6], '__toString']) ? (string) $key[6] : $key[6])]));
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildIsrLink|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildIsrLinkQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(IsrLinkTableMap::COL_INSTRUCTION_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(IsrLinkTableMap::COL_BUILDING_CODE, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(IsrLinkTableMap::COL_ROOM_NUMBER, $key[2], Criteria::EQUAL);
        $this->addUsingAlias(IsrLinkTableMap::COL_WEEKDAY, $key[3], Criteria::EQUAL);
        $this->addUsingAlias(IsrLinkTableMap::COL_START_TIME, $key[4], Criteria::EQUAL);
        $this->addUsingAlias(IsrLinkTableMap::COL_END_TIME, $key[5], Criteria::EQUAL);
        $this->addUsingAlias(IsrLinkTableMap::COL_START_DATE, $key[6], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildIsrLinkQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(IsrLinkTableMap::COL_INSTRUCTION_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(IsrLinkTableMap::COL_BUILDING_CODE, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(IsrLinkTableMap::COL_ROOM_NUMBER, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
            $cton3 = $this->getNewCriterion(IsrLinkTableMap::COL_WEEKDAY, $key[3], Criteria::EQUAL);
            $cton0->addAnd($cton3);
            $cton4 = $this->getNewCriterion(IsrLinkTableMap::COL_START_TIME, $key[4], Criteria::EQUAL);
            $cton0->addAnd($cton4);
            $cton5 = $this->getNewCriterion(IsrLinkTableMap::COL_END_TIME, $key[5], Criteria::EQUAL);
            $cton0->addAnd($cton5);
            $cton6 = $this->getNewCriterion(IsrLinkTableMap::COL_START_DATE, $key[6], Criteria::EQUAL);
            $cton0->addAnd($cton6);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the instruction_id column
     *
     * Example usage:
     * <code>
     * $query->filterByInstructionId(1234); // WHERE instruction_id = 1234
     * $query->filterByInstructionId(array(12, 34)); // WHERE instruction_id IN (12, 34)
     * $query->filterByInstructionId(array('min' => 12)); // WHERE instruction_id > 12
     * </code>
     *
     * @see       filterByInstruction()
     *
     * @param     mixed $instructionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIsrLinkQuery The current query, for fluid interface
     */
    public function filterByInstructionId($instructionId = null, $comparison = null)
    {
        if (is_array($instructionId)) {
            $useMinMax = false;
            if (isset($instructionId['min'])) {
                $this->addUsingAlias(IsrLinkTableMap::COL_INSTRUCTION_ID, $instructionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($instructionId['max'])) {
                $this->addUsingAlias(IsrLinkTableMap::COL_INSTRUCTION_ID, $instructionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IsrLinkTableMap::COL_INSTRUCTION_ID, $instructionId, $comparison);
    }

    /**
     * Filter the query on the building_code column
     *
     * Example usage:
     * <code>
     * $query->filterByBuildingCode('fooValue');   // WHERE building_code = 'fooValue'
     * $query->filterByBuildingCode('%fooValue%'); // WHERE building_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $buildingCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIsrLinkQuery The current query, for fluid interface
     */
    public function filterByBuildingCode($buildingCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($buildingCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $buildingCode)) {
                $buildingCode = str_replace('*', '%', $buildingCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(IsrLinkTableMap::COL_BUILDING_CODE, $buildingCode, $comparison);
    }

    /**
     * Filter the query on the room_number column
     *
     * Example usage:
     * <code>
     * $query->filterByRoomNumber(1234); // WHERE room_number = 1234
     * $query->filterByRoomNumber(array(12, 34)); // WHERE room_number IN (12, 34)
     * $query->filterByRoomNumber(array('min' => 12)); // WHERE room_number > 12
     * </code>
     *
     * @see       filterByRsAvailable()
     *
     * @param     mixed $roomNumber The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIsrLinkQuery The current query, for fluid interface
     */
    public function filterByRoomNumber($roomNumber = null, $comparison = null)
    {
        if (is_array($roomNumber)) {
            $useMinMax = false;
            if (isset($roomNumber['min'])) {
                $this->addUsingAlias(IsrLinkTableMap::COL_ROOM_NUMBER, $roomNumber['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($roomNumber['max'])) {
                $this->addUsingAlias(IsrLinkTableMap::COL_ROOM_NUMBER, $roomNumber['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IsrLinkTableMap::COL_ROOM_NUMBER, $roomNumber, $comparison);
    }

    /**
     * Filter the query on the weekday column
     *
     * Example usage:
     * <code>
     * $query->filterByWeekday(1234); // WHERE weekday = 1234
     * $query->filterByWeekday(array(12, 34)); // WHERE weekday IN (12, 34)
     * $query->filterByWeekday(array('min' => 12)); // WHERE weekday > 12
     * </code>
     *
     * @see       filterByRsAvailable()
     *
     * @param     mixed $weekday The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIsrLinkQuery The current query, for fluid interface
     */
    public function filterByWeekday($weekday = null, $comparison = null)
    {
        if (is_array($weekday)) {
            $useMinMax = false;
            if (isset($weekday['min'])) {
                $this->addUsingAlias(IsrLinkTableMap::COL_WEEKDAY, $weekday['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($weekday['max'])) {
                $this->addUsingAlias(IsrLinkTableMap::COL_WEEKDAY, $weekday['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IsrLinkTableMap::COL_WEEKDAY, $weekday, $comparison);
    }

    /**
     * Filter the query on the start_time column
     *
     * Example usage:
     * <code>
     * $query->filterByStartTime('2011-03-14'); // WHERE start_time = '2011-03-14'
     * $query->filterByStartTime('now'); // WHERE start_time = '2011-03-14'
     * $query->filterByStartTime(array('max' => 'yesterday')); // WHERE start_time > '2011-03-13'
     * </code>
     *
     * @param     mixed $startTime The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIsrLinkQuery The current query, for fluid interface
     */
    public function filterByStartTime($startTime = null, $comparison = null)
    {
        if (is_array($startTime)) {
            $useMinMax = false;
            if (isset($startTime['min'])) {
                $this->addUsingAlias(IsrLinkTableMap::COL_START_TIME, $startTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($startTime['max'])) {
                $this->addUsingAlias(IsrLinkTableMap::COL_START_TIME, $startTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IsrLinkTableMap::COL_START_TIME, $startTime, $comparison);
    }

    /**
     * Filter the query on the end_time column
     *
     * Example usage:
     * <code>
     * $query->filterByEndTime('2011-03-14'); // WHERE end_time = '2011-03-14'
     * $query->filterByEndTime('now'); // WHERE end_time = '2011-03-14'
     * $query->filterByEndTime(array('max' => 'yesterday')); // WHERE end_time > '2011-03-13'
     * </code>
     *
     * @param     mixed $endTime The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIsrLinkQuery The current query, for fluid interface
     */
    public function filterByEndTime($endTime = null, $comparison = null)
    {
        if (is_array($endTime)) {
            $useMinMax = false;
            if (isset($endTime['min'])) {
                $this->addUsingAlias(IsrLinkTableMap::COL_END_TIME, $endTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($endTime['max'])) {
                $this->addUsingAlias(IsrLinkTableMap::COL_END_TIME, $endTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IsrLinkTableMap::COL_END_TIME, $endTime, $comparison);
    }

    /**
     * Filter the query on the start_date column
     *
     * Example usage:
     * <code>
     * $query->filterByStartDate('2011-03-14'); // WHERE start_date = '2011-03-14'
     * $query->filterByStartDate('now'); // WHERE start_date = '2011-03-14'
     * $query->filterByStartDate(array('max' => 'yesterday')); // WHERE start_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $startDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIsrLinkQuery The current query, for fluid interface
     */
    public function filterByStartDate($startDate = null, $comparison = null)
    {
        if (is_array($startDate)) {
            $useMinMax = false;
            if (isset($startDate['min'])) {
                $this->addUsingAlias(IsrLinkTableMap::COL_START_DATE, $startDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($startDate['max'])) {
                $this->addUsingAlias(IsrLinkTableMap::COL_START_DATE, $startDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IsrLinkTableMap::COL_START_DATE, $startDate, $comparison);
    }

    /**
     * Filter the query by a related \BossEdu\Model\Instruction object
     *
     * @param \BossEdu\Model\Instruction|ObjectCollection $instruction The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildIsrLinkQuery The current query, for fluid interface
     */
    public function filterByInstruction($instruction, $comparison = null)
    {
        if ($instruction instanceof \BossEdu\Model\Instruction) {
            return $this
                ->addUsingAlias(IsrLinkTableMap::COL_INSTRUCTION_ID, $instruction->getId(), $comparison);
        } elseif ($instruction instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(IsrLinkTableMap::COL_INSTRUCTION_ID, $instruction->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByInstruction() only accepts arguments of type \BossEdu\Model\Instruction or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Instruction relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildIsrLinkQuery The current query, for fluid interface
     */
    public function joinInstruction($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Instruction');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Instruction');
        }

        return $this;
    }

    /**
     * Use the Instruction relation Instruction object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BossEdu\Model\InstructionQuery A secondary query class using the current class as primary query
     */
    public function useInstructionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinInstruction($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Instruction', '\BossEdu\Model\InstructionQuery');
    }

    /**
     * Filter the query by a related \BossEdu\Model\RsAvailable object
     *
     * @param \BossEdu\Model\RsAvailable $rsAvailable The related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildIsrLinkQuery The current query, for fluid interface
     */
    public function filterByRsAvailable($rsAvailable, $comparison = null)
    {
        if ($rsAvailable instanceof \BossEdu\Model\RsAvailable) {
            return $this
                ->addUsingAlias(IsrLinkTableMap::COL_BUILDING_CODE, $rsAvailable->getBuildingCode(), $comparison)
                ->addUsingAlias(IsrLinkTableMap::COL_ROOM_NUMBER, $rsAvailable->getRoomNumber(), $comparison)
                ->addUsingAlias(IsrLinkTableMap::COL_WEEKDAY, $rsAvailable->getWeekday(), $comparison)
                ->addUsingAlias(IsrLinkTableMap::COL_START_TIME, $rsAvailable->getStartTime(), $comparison)
                ->addUsingAlias(IsrLinkTableMap::COL_END_TIME, $rsAvailable->getEndTime(), $comparison)
                ->addUsingAlias(IsrLinkTableMap::COL_START_DATE, $rsAvailable->getStartDate(), $comparison);
        } else {
            throw new PropelException('filterByRsAvailable() only accepts arguments of type \BossEdu\Model\RsAvailable');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RsAvailable relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildIsrLinkQuery The current query, for fluid interface
     */
    public function joinRsAvailable($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RsAvailable');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'RsAvailable');
        }

        return $this;
    }

    /**
     * Use the RsAvailable relation RsAvailable object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BossEdu\Model\RsAvailableQuery A secondary query class using the current class as primary query
     */
    public function useRsAvailableQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRsAvailable($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RsAvailable', '\BossEdu\Model\RsAvailableQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildIsrLink $isrLink Object to remove from the list of results
     *
     * @return $this|ChildIsrLinkQuery The current query, for fluid interface
     */
    public function prune($isrLink = null)
    {
        if ($isrLink) {
            $this->addCond('pruneCond0', $this->getAliasedColName(IsrLinkTableMap::COL_INSTRUCTION_ID), $isrLink->getInstructionId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(IsrLinkTableMap::COL_BUILDING_CODE), $isrLink->getBuildingCode(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(IsrLinkTableMap::COL_ROOM_NUMBER), $isrLink->getRoomNumber(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond3', $this->getAliasedColName(IsrLinkTableMap::COL_WEEKDAY), $isrLink->getWeekday(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond4', $this->getAliasedColName(IsrLinkTableMap::COL_START_TIME), $isrLink->getStartTime(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond5', $this->getAliasedColName(IsrLinkTableMap::COL_END_TIME), $isrLink->getEndTime(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond6', $this->getAliasedColName(IsrLinkTableMap::COL_START_DATE), $isrLink->getStartDate(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2', 'pruneCond3', 'pruneCond4', 'pruneCond5', 'pruneCond6'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the isr_link table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(IsrLinkTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            IsrLinkTableMap::clearInstancePool();
            IsrLinkTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(IsrLinkTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(IsrLinkTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            IsrLinkTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            IsrLinkTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // IsrLinkQuery
