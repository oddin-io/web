<?php

namespace BossEdu\Model\Base;

use \Exception;
use \PDO;
use BossEdu\Model\Schedule as ChildSchedule;
use BossEdu\Model\ScheduleQuery as ChildScheduleQuery;
use BossEdu\Model\Map\ScheduleTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'schedule' table.
 *
 * 
 *
 * @method     ChildScheduleQuery orderByWeekday($order = Criteria::ASC) Order by the weekday column
 * @method     ChildScheduleQuery orderByStartTime($order = Criteria::ASC) Order by the start_time column
 * @method     ChildScheduleQuery orderByEndTime($order = Criteria::ASC) Order by the end_time column
 *
 * @method     ChildScheduleQuery groupByWeekday() Group by the weekday column
 * @method     ChildScheduleQuery groupByStartTime() Group by the start_time column
 * @method     ChildScheduleQuery groupByEndTime() Group by the end_time column
 *
 * @method     ChildScheduleQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildScheduleQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildScheduleQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildScheduleQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildScheduleQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildScheduleQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildScheduleQuery leftJoinRsAvailable($relationAlias = null) Adds a LEFT JOIN clause to the query using the RsAvailable relation
 * @method     ChildScheduleQuery rightJoinRsAvailable($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RsAvailable relation
 * @method     ChildScheduleQuery innerJoinRsAvailable($relationAlias = null) Adds a INNER JOIN clause to the query using the RsAvailable relation
 *
 * @method     ChildScheduleQuery joinWithRsAvailable($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RsAvailable relation
 *
 * @method     ChildScheduleQuery leftJoinWithRsAvailable() Adds a LEFT JOIN clause and with to the query using the RsAvailable relation
 * @method     ChildScheduleQuery rightJoinWithRsAvailable() Adds a RIGHT JOIN clause and with to the query using the RsAvailable relation
 * @method     ChildScheduleQuery innerJoinWithRsAvailable() Adds a INNER JOIN clause and with to the query using the RsAvailable relation
 *
 * @method     \BossEdu\Model\RsAvailableQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSchedule findOne(ConnectionInterface $con = null) Return the first ChildSchedule matching the query
 * @method     ChildSchedule findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSchedule matching the query, or a new ChildSchedule object populated from the query conditions when no match is found
 *
 * @method     ChildSchedule findOneByWeekday(int $weekday) Return the first ChildSchedule filtered by the weekday column
 * @method     ChildSchedule findOneByStartTime(string $start_time) Return the first ChildSchedule filtered by the start_time column
 * @method     ChildSchedule findOneByEndTime(string $end_time) Return the first ChildSchedule filtered by the end_time column *

 * @method     ChildSchedule requirePk($key, ConnectionInterface $con = null) Return the ChildSchedule by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSchedule requireOne(ConnectionInterface $con = null) Return the first ChildSchedule matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSchedule requireOneByWeekday(int $weekday) Return the first ChildSchedule filtered by the weekday column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSchedule requireOneByStartTime(string $start_time) Return the first ChildSchedule filtered by the start_time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSchedule requireOneByEndTime(string $end_time) Return the first ChildSchedule filtered by the end_time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSchedule[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSchedule objects based on current ModelCriteria
 * @method     ChildSchedule[]|ObjectCollection findByWeekday(int $weekday) Return ChildSchedule objects filtered by the weekday column
 * @method     ChildSchedule[]|ObjectCollection findByStartTime(string $start_time) Return ChildSchedule objects filtered by the start_time column
 * @method     ChildSchedule[]|ObjectCollection findByEndTime(string $end_time) Return ChildSchedule objects filtered by the end_time column
 * @method     ChildSchedule[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ScheduleQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \BossEdu\Model\Base\ScheduleQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\BossEdu\\Model\\Schedule', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildScheduleQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildScheduleQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildScheduleQuery) {
            return $criteria;
        }
        $query = new ChildScheduleQuery();
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
     * $obj = $c->findPk(array(12, 34, 56), $con);
     * </code>
     *
     * @param array[$weekday, $start_time, $end_time] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildSchedule|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ScheduleTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])])))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ScheduleTableMap::DATABASE_NAME);
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
     * @return ChildSchedule A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT weekday, start_time, end_time FROM schedule WHERE weekday = :p0 AND start_time = :p1 AND end_time = :p2';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);            
            $stmt->bindValue(':p1', $key[1] ? $key[1]->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);            
            $stmt->bindValue(':p2', $key[2] ? $key[2]->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildSchedule $obj */
            $obj = new ChildSchedule();
            $obj->hydrate($row);
            ScheduleTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]));
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
     * @return ChildSchedule|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ScheduleTableMap::COL_WEEKDAY, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ScheduleTableMap::COL_START_TIME, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(ScheduleTableMap::COL_END_TIME, $key[2], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ScheduleTableMap::COL_WEEKDAY, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ScheduleTableMap::COL_START_TIME, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(ScheduleTableMap::COL_END_TIME, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
            $this->addOr($cton0);
        }

        return $this;
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
     * @param     mixed $weekday The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function filterByWeekday($weekday = null, $comparison = null)
    {
        if (is_array($weekday)) {
            $useMinMax = false;
            if (isset($weekday['min'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_WEEKDAY, $weekday['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($weekday['max'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_WEEKDAY, $weekday['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScheduleTableMap::COL_WEEKDAY, $weekday, $comparison);
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
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function filterByStartTime($startTime = null, $comparison = null)
    {
        if (is_array($startTime)) {
            $useMinMax = false;
            if (isset($startTime['min'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_START_TIME, $startTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($startTime['max'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_START_TIME, $startTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScheduleTableMap::COL_START_TIME, $startTime, $comparison);
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
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function filterByEndTime($endTime = null, $comparison = null)
    {
        if (is_array($endTime)) {
            $useMinMax = false;
            if (isset($endTime['min'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_END_TIME, $endTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($endTime['max'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_END_TIME, $endTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScheduleTableMap::COL_END_TIME, $endTime, $comparison);
    }

    /**
     * Filter the query by a related \BossEdu\Model\RsAvailable object
     *
     * @param \BossEdu\Model\RsAvailable|ObjectCollection $rsAvailable the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildScheduleQuery The current query, for fluid interface
     */
    public function filterByRsAvailable($rsAvailable, $comparison = null)
    {
        if ($rsAvailable instanceof \BossEdu\Model\RsAvailable) {
            return $this
                ->addUsingAlias(ScheduleTableMap::COL_WEEKDAY, $rsAvailable->getWeekday(), $comparison)
                ->addUsingAlias(ScheduleTableMap::COL_START_TIME, $rsAvailable->getStartTime(), $comparison)
                ->addUsingAlias(ScheduleTableMap::COL_END_TIME, $rsAvailable->getEndTime(), $comparison);
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
     * @return $this|ChildScheduleQuery The current query, for fluid interface
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
     * @param   ChildSchedule $schedule Object to remove from the list of results
     *
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function prune($schedule = null)
    {
        if ($schedule) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ScheduleTableMap::COL_WEEKDAY), $schedule->getWeekday(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ScheduleTableMap::COL_START_TIME), $schedule->getStartTime(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(ScheduleTableMap::COL_END_TIME), $schedule->getEndTime(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the schedule table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ScheduleTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ScheduleTableMap::clearInstancePool();
            ScheduleTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ScheduleTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ScheduleTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            ScheduleTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ScheduleTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ScheduleQuery
