<?php

namespace BossEdu\Model\Base;

use \Exception;
use \PDO;
use BossEdu\Model\RsAvailable as ChildRsAvailable;
use BossEdu\Model\RsAvailableQuery as ChildRsAvailableQuery;
use BossEdu\Model\Map\RsAvailableTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'rs_available' table.
 *
 * 
 *
 * @method     ChildRsAvailableQuery orderByBuildingCode($order = Criteria::ASC) Order by the building_code column
 * @method     ChildRsAvailableQuery orderByRoomNumber($order = Criteria::ASC) Order by the room_number column
 * @method     ChildRsAvailableQuery orderByWeekday($order = Criteria::ASC) Order by the weekday column
 * @method     ChildRsAvailableQuery orderByStartTime($order = Criteria::ASC) Order by the start_time column
 * @method     ChildRsAvailableQuery orderByEndTime($order = Criteria::ASC) Order by the end_time column
 * @method     ChildRsAvailableQuery orderByStartDate($order = Criteria::ASC) Order by the start_date column
 * @method     ChildRsAvailableQuery orderByEndDate($order = Criteria::ASC) Order by the end_date column
 *
 * @method     ChildRsAvailableQuery groupByBuildingCode() Group by the building_code column
 * @method     ChildRsAvailableQuery groupByRoomNumber() Group by the room_number column
 * @method     ChildRsAvailableQuery groupByWeekday() Group by the weekday column
 * @method     ChildRsAvailableQuery groupByStartTime() Group by the start_time column
 * @method     ChildRsAvailableQuery groupByEndTime() Group by the end_time column
 * @method     ChildRsAvailableQuery groupByStartDate() Group by the start_date column
 * @method     ChildRsAvailableQuery groupByEndDate() Group by the end_date column
 *
 * @method     ChildRsAvailableQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRsAvailableQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRsAvailableQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRsAvailableQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRsAvailableQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRsAvailableQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRsAvailableQuery leftJoinSchedule($relationAlias = null) Adds a LEFT JOIN clause to the query using the Schedule relation
 * @method     ChildRsAvailableQuery rightJoinSchedule($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Schedule relation
 * @method     ChildRsAvailableQuery innerJoinSchedule($relationAlias = null) Adds a INNER JOIN clause to the query using the Schedule relation
 *
 * @method     ChildRsAvailableQuery joinWithSchedule($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Schedule relation
 *
 * @method     ChildRsAvailableQuery leftJoinWithSchedule() Adds a LEFT JOIN clause and with to the query using the Schedule relation
 * @method     ChildRsAvailableQuery rightJoinWithSchedule() Adds a RIGHT JOIN clause and with to the query using the Schedule relation
 * @method     ChildRsAvailableQuery innerJoinWithSchedule() Adds a INNER JOIN clause and with to the query using the Schedule relation
 *
 * @method     ChildRsAvailableQuery leftJoinRoom($relationAlias = null) Adds a LEFT JOIN clause to the query using the Room relation
 * @method     ChildRsAvailableQuery rightJoinRoom($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Room relation
 * @method     ChildRsAvailableQuery innerJoinRoom($relationAlias = null) Adds a INNER JOIN clause to the query using the Room relation
 *
 * @method     ChildRsAvailableQuery joinWithRoom($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Room relation
 *
 * @method     ChildRsAvailableQuery leftJoinWithRoom() Adds a LEFT JOIN clause and with to the query using the Room relation
 * @method     ChildRsAvailableQuery rightJoinWithRoom() Adds a RIGHT JOIN clause and with to the query using the Room relation
 * @method     ChildRsAvailableQuery innerJoinWithRoom() Adds a INNER JOIN clause and with to the query using the Room relation
 *
 * @method     ChildRsAvailableQuery leftJoinIsrLink($relationAlias = null) Adds a LEFT JOIN clause to the query using the IsrLink relation
 * @method     ChildRsAvailableQuery rightJoinIsrLink($relationAlias = null) Adds a RIGHT JOIN clause to the query using the IsrLink relation
 * @method     ChildRsAvailableQuery innerJoinIsrLink($relationAlias = null) Adds a INNER JOIN clause to the query using the IsrLink relation
 *
 * @method     ChildRsAvailableQuery joinWithIsrLink($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the IsrLink relation
 *
 * @method     ChildRsAvailableQuery leftJoinWithIsrLink() Adds a LEFT JOIN clause and with to the query using the IsrLink relation
 * @method     ChildRsAvailableQuery rightJoinWithIsrLink() Adds a RIGHT JOIN clause and with to the query using the IsrLink relation
 * @method     ChildRsAvailableQuery innerJoinWithIsrLink() Adds a INNER JOIN clause and with to the query using the IsrLink relation
 *
 * @method     \BossEdu\Model\ScheduleQuery|\BossEdu\Model\RoomQuery|\BossEdu\Model\IsrLinkQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRsAvailable findOne(ConnectionInterface $con = null) Return the first ChildRsAvailable matching the query
 * @method     ChildRsAvailable findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRsAvailable matching the query, or a new ChildRsAvailable object populated from the query conditions when no match is found
 *
 * @method     ChildRsAvailable findOneByBuildingCode(string $building_code) Return the first ChildRsAvailable filtered by the building_code column
 * @method     ChildRsAvailable findOneByRoomNumber(int $room_number) Return the first ChildRsAvailable filtered by the room_number column
 * @method     ChildRsAvailable findOneByWeekday(int $weekday) Return the first ChildRsAvailable filtered by the weekday column
 * @method     ChildRsAvailable findOneByStartTime(string $start_time) Return the first ChildRsAvailable filtered by the start_time column
 * @method     ChildRsAvailable findOneByEndTime(string $end_time) Return the first ChildRsAvailable filtered by the end_time column
 * @method     ChildRsAvailable findOneByStartDate(string $start_date) Return the first ChildRsAvailable filtered by the start_date column
 * @method     ChildRsAvailable findOneByEndDate(string $end_date) Return the first ChildRsAvailable filtered by the end_date column *

 * @method     ChildRsAvailable requirePk($key, ConnectionInterface $con = null) Return the ChildRsAvailable by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRsAvailable requireOne(ConnectionInterface $con = null) Return the first ChildRsAvailable matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRsAvailable requireOneByBuildingCode(string $building_code) Return the first ChildRsAvailable filtered by the building_code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRsAvailable requireOneByRoomNumber(int $room_number) Return the first ChildRsAvailable filtered by the room_number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRsAvailable requireOneByWeekday(int $weekday) Return the first ChildRsAvailable filtered by the weekday column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRsAvailable requireOneByStartTime(string $start_time) Return the first ChildRsAvailable filtered by the start_time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRsAvailable requireOneByEndTime(string $end_time) Return the first ChildRsAvailable filtered by the end_time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRsAvailable requireOneByStartDate(string $start_date) Return the first ChildRsAvailable filtered by the start_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRsAvailable requireOneByEndDate(string $end_date) Return the first ChildRsAvailable filtered by the end_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRsAvailable[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRsAvailable objects based on current ModelCriteria
 * @method     ChildRsAvailable[]|ObjectCollection findByBuildingCode(string $building_code) Return ChildRsAvailable objects filtered by the building_code column
 * @method     ChildRsAvailable[]|ObjectCollection findByRoomNumber(int $room_number) Return ChildRsAvailable objects filtered by the room_number column
 * @method     ChildRsAvailable[]|ObjectCollection findByWeekday(int $weekday) Return ChildRsAvailable objects filtered by the weekday column
 * @method     ChildRsAvailable[]|ObjectCollection findByStartTime(string $start_time) Return ChildRsAvailable objects filtered by the start_time column
 * @method     ChildRsAvailable[]|ObjectCollection findByEndTime(string $end_time) Return ChildRsAvailable objects filtered by the end_time column
 * @method     ChildRsAvailable[]|ObjectCollection findByStartDate(string $start_date) Return ChildRsAvailable objects filtered by the start_date column
 * @method     ChildRsAvailable[]|ObjectCollection findByEndDate(string $end_date) Return ChildRsAvailable objects filtered by the end_date column
 * @method     ChildRsAvailable[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RsAvailableQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \BossEdu\Model\Base\RsAvailableQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\BossEdu\\Model\\RsAvailable', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRsAvailableQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRsAvailableQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRsAvailableQuery) {
            return $criteria;
        }
        $query = new ChildRsAvailableQuery();
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
     * @param array[$building_code, $room_number, $weekday, $start_time, $end_time, $start_date] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildRsAvailable|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RsAvailableTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2]), (null === $key[3] || is_scalar($key[3]) || is_callable([$key[3], '__toString']) ? (string) $key[3] : $key[3]), (null === $key[4] || is_scalar($key[4]) || is_callable([$key[4], '__toString']) ? (string) $key[4] : $key[4]), (null === $key[5] || is_scalar($key[5]) || is_callable([$key[5], '__toString']) ? (string) $key[5] : $key[5])])))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RsAvailableTableMap::DATABASE_NAME);
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
     * @return ChildRsAvailable A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT building_code, room_number, weekday, start_time, end_time, start_date, end_date FROM rs_available WHERE building_code = :p0 AND room_number = :p1 AND weekday = :p2 AND start_time = :p3 AND end_time = :p4 AND start_date = :p5';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_STR);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);            
            $stmt->bindValue(':p2', $key[2], PDO::PARAM_INT);            
            $stmt->bindValue(':p3', $key[3] ? $key[3]->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);            
            $stmt->bindValue(':p4', $key[4] ? $key[4]->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);            
            $stmt->bindValue(':p5', $key[5] ? $key[5]->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildRsAvailable $obj */
            $obj = new ChildRsAvailable();
            $obj->hydrate($row);
            RsAvailableTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2]), (null === $key[3] || is_scalar($key[3]) || is_callable([$key[3], '__toString']) ? (string) $key[3] : $key[3]), (null === $key[4] || is_scalar($key[4]) || is_callable([$key[4], '__toString']) ? (string) $key[4] : $key[4]), (null === $key[5] || is_scalar($key[5]) || is_callable([$key[5], '__toString']) ? (string) $key[5] : $key[5])]));
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
     * @return ChildRsAvailable|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRsAvailableQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(RsAvailableTableMap::COL_BUILDING_CODE, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(RsAvailableTableMap::COL_ROOM_NUMBER, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(RsAvailableTableMap::COL_WEEKDAY, $key[2], Criteria::EQUAL);
        $this->addUsingAlias(RsAvailableTableMap::COL_START_TIME, $key[3], Criteria::EQUAL);
        $this->addUsingAlias(RsAvailableTableMap::COL_END_TIME, $key[4], Criteria::EQUAL);
        $this->addUsingAlias(RsAvailableTableMap::COL_START_DATE, $key[5], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRsAvailableQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(RsAvailableTableMap::COL_BUILDING_CODE, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(RsAvailableTableMap::COL_ROOM_NUMBER, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(RsAvailableTableMap::COL_WEEKDAY, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
            $cton3 = $this->getNewCriterion(RsAvailableTableMap::COL_START_TIME, $key[3], Criteria::EQUAL);
            $cton0->addAnd($cton3);
            $cton4 = $this->getNewCriterion(RsAvailableTableMap::COL_END_TIME, $key[4], Criteria::EQUAL);
            $cton0->addAnd($cton4);
            $cton5 = $this->getNewCriterion(RsAvailableTableMap::COL_START_DATE, $key[5], Criteria::EQUAL);
            $cton0->addAnd($cton5);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return $this|ChildRsAvailableQuery The current query, for fluid interface
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

        return $this->addUsingAlias(RsAvailableTableMap::COL_BUILDING_CODE, $buildingCode, $comparison);
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
     * @see       filterByRoom()
     *
     * @param     mixed $roomNumber The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRsAvailableQuery The current query, for fluid interface
     */
    public function filterByRoomNumber($roomNumber = null, $comparison = null)
    {
        if (is_array($roomNumber)) {
            $useMinMax = false;
            if (isset($roomNumber['min'])) {
                $this->addUsingAlias(RsAvailableTableMap::COL_ROOM_NUMBER, $roomNumber['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($roomNumber['max'])) {
                $this->addUsingAlias(RsAvailableTableMap::COL_ROOM_NUMBER, $roomNumber['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RsAvailableTableMap::COL_ROOM_NUMBER, $roomNumber, $comparison);
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
     * @see       filterBySchedule()
     *
     * @param     mixed $weekday The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRsAvailableQuery The current query, for fluid interface
     */
    public function filterByWeekday($weekday = null, $comparison = null)
    {
        if (is_array($weekday)) {
            $useMinMax = false;
            if (isset($weekday['min'])) {
                $this->addUsingAlias(RsAvailableTableMap::COL_WEEKDAY, $weekday['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($weekday['max'])) {
                $this->addUsingAlias(RsAvailableTableMap::COL_WEEKDAY, $weekday['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RsAvailableTableMap::COL_WEEKDAY, $weekday, $comparison);
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
     * @return $this|ChildRsAvailableQuery The current query, for fluid interface
     */
    public function filterByStartTime($startTime = null, $comparison = null)
    {
        if (is_array($startTime)) {
            $useMinMax = false;
            if (isset($startTime['min'])) {
                $this->addUsingAlias(RsAvailableTableMap::COL_START_TIME, $startTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($startTime['max'])) {
                $this->addUsingAlias(RsAvailableTableMap::COL_START_TIME, $startTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RsAvailableTableMap::COL_START_TIME, $startTime, $comparison);
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
     * @return $this|ChildRsAvailableQuery The current query, for fluid interface
     */
    public function filterByEndTime($endTime = null, $comparison = null)
    {
        if (is_array($endTime)) {
            $useMinMax = false;
            if (isset($endTime['min'])) {
                $this->addUsingAlias(RsAvailableTableMap::COL_END_TIME, $endTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($endTime['max'])) {
                $this->addUsingAlias(RsAvailableTableMap::COL_END_TIME, $endTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RsAvailableTableMap::COL_END_TIME, $endTime, $comparison);
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
     * @return $this|ChildRsAvailableQuery The current query, for fluid interface
     */
    public function filterByStartDate($startDate = null, $comparison = null)
    {
        if (is_array($startDate)) {
            $useMinMax = false;
            if (isset($startDate['min'])) {
                $this->addUsingAlias(RsAvailableTableMap::COL_START_DATE, $startDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($startDate['max'])) {
                $this->addUsingAlias(RsAvailableTableMap::COL_START_DATE, $startDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RsAvailableTableMap::COL_START_DATE, $startDate, $comparison);
    }

    /**
     * Filter the query on the end_date column
     *
     * Example usage:
     * <code>
     * $query->filterByEndDate('2011-03-14'); // WHERE end_date = '2011-03-14'
     * $query->filterByEndDate('now'); // WHERE end_date = '2011-03-14'
     * $query->filterByEndDate(array('max' => 'yesterday')); // WHERE end_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $endDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRsAvailableQuery The current query, for fluid interface
     */
    public function filterByEndDate($endDate = null, $comparison = null)
    {
        if (is_array($endDate)) {
            $useMinMax = false;
            if (isset($endDate['min'])) {
                $this->addUsingAlias(RsAvailableTableMap::COL_END_DATE, $endDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($endDate['max'])) {
                $this->addUsingAlias(RsAvailableTableMap::COL_END_DATE, $endDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RsAvailableTableMap::COL_END_DATE, $endDate, $comparison);
    }

    /**
     * Filter the query by a related \BossEdu\Model\Schedule object
     *
     * @param \BossEdu\Model\Schedule $schedule The related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRsAvailableQuery The current query, for fluid interface
     */
    public function filterBySchedule($schedule, $comparison = null)
    {
        if ($schedule instanceof \BossEdu\Model\Schedule) {
            return $this
                ->addUsingAlias(RsAvailableTableMap::COL_WEEKDAY, $schedule->getWeekday(), $comparison)
                ->addUsingAlias(RsAvailableTableMap::COL_START_TIME, $schedule->getStartTime(), $comparison)
                ->addUsingAlias(RsAvailableTableMap::COL_END_TIME, $schedule->getEndTime(), $comparison);
        } else {
            throw new PropelException('filterBySchedule() only accepts arguments of type \BossEdu\Model\Schedule');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Schedule relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRsAvailableQuery The current query, for fluid interface
     */
    public function joinSchedule($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Schedule');

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
            $this->addJoinObject($join, 'Schedule');
        }

        return $this;
    }

    /**
     * Use the Schedule relation Schedule object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BossEdu\Model\ScheduleQuery A secondary query class using the current class as primary query
     */
    public function useScheduleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSchedule($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Schedule', '\BossEdu\Model\ScheduleQuery');
    }

    /**
     * Filter the query by a related \BossEdu\Model\Room object
     *
     * @param \BossEdu\Model\Room $room The related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRsAvailableQuery The current query, for fluid interface
     */
    public function filterByRoom($room, $comparison = null)
    {
        if ($room instanceof \BossEdu\Model\Room) {
            return $this
                ->addUsingAlias(RsAvailableTableMap::COL_BUILDING_CODE, $room->getBuildingCode(), $comparison)
                ->addUsingAlias(RsAvailableTableMap::COL_ROOM_NUMBER, $room->getNumber(), $comparison);
        } else {
            throw new PropelException('filterByRoom() only accepts arguments of type \BossEdu\Model\Room');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Room relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRsAvailableQuery The current query, for fluid interface
     */
    public function joinRoom($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Room');

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
            $this->addJoinObject($join, 'Room');
        }

        return $this;
    }

    /**
     * Use the Room relation Room object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BossEdu\Model\RoomQuery A secondary query class using the current class as primary query
     */
    public function useRoomQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRoom($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Room', '\BossEdu\Model\RoomQuery');
    }

    /**
     * Filter the query by a related \BossEdu\Model\IsrLink object
     *
     * @param \BossEdu\Model\IsrLink|ObjectCollection $isrLink the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRsAvailableQuery The current query, for fluid interface
     */
    public function filterByIsrLink($isrLink, $comparison = null)
    {
        if ($isrLink instanceof \BossEdu\Model\IsrLink) {
            return $this
                ->addUsingAlias(RsAvailableTableMap::COL_BUILDING_CODE, $isrLink->getBuildingCode(), $comparison)
                ->addUsingAlias(RsAvailableTableMap::COL_ROOM_NUMBER, $isrLink->getRoomNumber(), $comparison)
                ->addUsingAlias(RsAvailableTableMap::COL_WEEKDAY, $isrLink->getWeekday(), $comparison)
                ->addUsingAlias(RsAvailableTableMap::COL_START_TIME, $isrLink->getStartTime(), $comparison)
                ->addUsingAlias(RsAvailableTableMap::COL_END_TIME, $isrLink->getEndTime(), $comparison)
                ->addUsingAlias(RsAvailableTableMap::COL_START_DATE, $isrLink->getStartDate(), $comparison);
        } else {
            throw new PropelException('filterByIsrLink() only accepts arguments of type \BossEdu\Model\IsrLink');
        }
    }

    /**
     * Adds a JOIN clause to the query using the IsrLink relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRsAvailableQuery The current query, for fluid interface
     */
    public function joinIsrLink($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('IsrLink');

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
            $this->addJoinObject($join, 'IsrLink');
        }

        return $this;
    }

    /**
     * Use the IsrLink relation IsrLink object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BossEdu\Model\IsrLinkQuery A secondary query class using the current class as primary query
     */
    public function useIsrLinkQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinIsrLink($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'IsrLink', '\BossEdu\Model\IsrLinkQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRsAvailable $rsAvailable Object to remove from the list of results
     *
     * @return $this|ChildRsAvailableQuery The current query, for fluid interface
     */
    public function prune($rsAvailable = null)
    {
        if ($rsAvailable) {
            $this->addCond('pruneCond0', $this->getAliasedColName(RsAvailableTableMap::COL_BUILDING_CODE), $rsAvailable->getBuildingCode(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(RsAvailableTableMap::COL_ROOM_NUMBER), $rsAvailable->getRoomNumber(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(RsAvailableTableMap::COL_WEEKDAY), $rsAvailable->getWeekday(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond3', $this->getAliasedColName(RsAvailableTableMap::COL_START_TIME), $rsAvailable->getStartTime(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond4', $this->getAliasedColName(RsAvailableTableMap::COL_END_TIME), $rsAvailable->getEndTime(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond5', $this->getAliasedColName(RsAvailableTableMap::COL_START_DATE), $rsAvailable->getStartDate(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2', 'pruneCond3', 'pruneCond4', 'pruneCond5'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the rs_available table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RsAvailableTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RsAvailableTableMap::clearInstancePool();
            RsAvailableTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RsAvailableTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RsAvailableTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            RsAvailableTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            RsAvailableTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RsAvailableQuery
