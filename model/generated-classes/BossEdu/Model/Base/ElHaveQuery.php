<?php

namespace BossEdu\Model\Base;

use \Exception;
use \PDO;
use BossEdu\Model\ElHave as ChildElHave;
use BossEdu\Model\ElHaveQuery as ChildElHaveQuery;
use BossEdu\Model\Map\ElHaveTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'el_have' table.
 *
 * 
 *
 * @method     ChildElHaveQuery orderByEventCode($order = Criteria::ASC) Order by the event_code column
 * @method     ChildElHaveQuery orderByLectureCode($order = Criteria::ASC) Order by the lecture_code column
 *
 * @method     ChildElHaveQuery groupByEventCode() Group by the event_code column
 * @method     ChildElHaveQuery groupByLectureCode() Group by the lecture_code column
 *
 * @method     ChildElHaveQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildElHaveQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildElHaveQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildElHaveQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildElHaveQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildElHaveQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildElHaveQuery leftJoinEvent($relationAlias = null) Adds a LEFT JOIN clause to the query using the Event relation
 * @method     ChildElHaveQuery rightJoinEvent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Event relation
 * @method     ChildElHaveQuery innerJoinEvent($relationAlias = null) Adds a INNER JOIN clause to the query using the Event relation
 *
 * @method     ChildElHaveQuery joinWithEvent($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Event relation
 *
 * @method     ChildElHaveQuery leftJoinWithEvent() Adds a LEFT JOIN clause and with to the query using the Event relation
 * @method     ChildElHaveQuery rightJoinWithEvent() Adds a RIGHT JOIN clause and with to the query using the Event relation
 * @method     ChildElHaveQuery innerJoinWithEvent() Adds a INNER JOIN clause and with to the query using the Event relation
 *
 * @method     ChildElHaveQuery leftJoinLecture($relationAlias = null) Adds a LEFT JOIN clause to the query using the Lecture relation
 * @method     ChildElHaveQuery rightJoinLecture($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Lecture relation
 * @method     ChildElHaveQuery innerJoinLecture($relationAlias = null) Adds a INNER JOIN clause to the query using the Lecture relation
 *
 * @method     ChildElHaveQuery joinWithLecture($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Lecture relation
 *
 * @method     ChildElHaveQuery leftJoinWithLecture() Adds a LEFT JOIN clause and with to the query using the Lecture relation
 * @method     ChildElHaveQuery rightJoinWithLecture() Adds a RIGHT JOIN clause and with to the query using the Lecture relation
 * @method     ChildElHaveQuery innerJoinWithLecture() Adds a INNER JOIN clause and with to the query using the Lecture relation
 *
 * @method     ChildElHaveQuery leftJoinInstruction($relationAlias = null) Adds a LEFT JOIN clause to the query using the Instruction relation
 * @method     ChildElHaveQuery rightJoinInstruction($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Instruction relation
 * @method     ChildElHaveQuery innerJoinInstruction($relationAlias = null) Adds a INNER JOIN clause to the query using the Instruction relation
 *
 * @method     ChildElHaveQuery joinWithInstruction($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Instruction relation
 *
 * @method     ChildElHaveQuery leftJoinWithInstruction() Adds a LEFT JOIN clause and with to the query using the Instruction relation
 * @method     ChildElHaveQuery rightJoinWithInstruction() Adds a RIGHT JOIN clause and with to the query using the Instruction relation
 * @method     ChildElHaveQuery innerJoinWithInstruction() Adds a INNER JOIN clause and with to the query using the Instruction relation
 *
 * @method     \BossEdu\Model\EventQuery|\BossEdu\Model\LectureQuery|\BossEdu\Model\InstructionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildElHave findOne(ConnectionInterface $con = null) Return the first ChildElHave matching the query
 * @method     ChildElHave findOneOrCreate(ConnectionInterface $con = null) Return the first ChildElHave matching the query, or a new ChildElHave object populated from the query conditions when no match is found
 *
 * @method     ChildElHave findOneByEventCode(string $event_code) Return the first ChildElHave filtered by the event_code column
 * @method     ChildElHave findOneByLectureCode(string $lecture_code) Return the first ChildElHave filtered by the lecture_code column *

 * @method     ChildElHave requirePk($key, ConnectionInterface $con = null) Return the ChildElHave by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildElHave requireOne(ConnectionInterface $con = null) Return the first ChildElHave matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildElHave requireOneByEventCode(string $event_code) Return the first ChildElHave filtered by the event_code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildElHave requireOneByLectureCode(string $lecture_code) Return the first ChildElHave filtered by the lecture_code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildElHave[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildElHave objects based on current ModelCriteria
 * @method     ChildElHave[]|ObjectCollection findByEventCode(string $event_code) Return ChildElHave objects filtered by the event_code column
 * @method     ChildElHave[]|ObjectCollection findByLectureCode(string $lecture_code) Return ChildElHave objects filtered by the lecture_code column
 * @method     ChildElHave[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ElHaveQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \BossEdu\Model\Base\ElHaveQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\BossEdu\\Model\\ElHave', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildElHaveQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildElHaveQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildElHaveQuery) {
            return $criteria;
        }
        $query = new ChildElHaveQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$event_code, $lecture_code] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildElHave|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ElHaveTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])])))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ElHaveTableMap::DATABASE_NAME);
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
     * @return ChildElHave A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT event_code, lecture_code FROM el_have WHERE event_code = :p0 AND lecture_code = :p1';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_STR);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildElHave $obj */
            $obj = new ChildElHave();
            $obj->hydrate($row);
            ElHaveTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildElHave|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildElHaveQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ElHaveTableMap::COL_EVENT_CODE, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ElHaveTableMap::COL_LECTURE_CODE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildElHaveQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ElHaveTableMap::COL_EVENT_CODE, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ElHaveTableMap::COL_LECTURE_CODE, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the event_code column
     *
     * Example usage:
     * <code>
     * $query->filterByEventCode('fooValue');   // WHERE event_code = 'fooValue'
     * $query->filterByEventCode('%fooValue%'); // WHERE event_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $eventCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildElHaveQuery The current query, for fluid interface
     */
    public function filterByEventCode($eventCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($eventCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $eventCode)) {
                $eventCode = str_replace('*', '%', $eventCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ElHaveTableMap::COL_EVENT_CODE, $eventCode, $comparison);
    }

    /**
     * Filter the query on the lecture_code column
     *
     * Example usage:
     * <code>
     * $query->filterByLectureCode('fooValue');   // WHERE lecture_code = 'fooValue'
     * $query->filterByLectureCode('%fooValue%'); // WHERE lecture_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lectureCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildElHaveQuery The current query, for fluid interface
     */
    public function filterByLectureCode($lectureCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lectureCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $lectureCode)) {
                $lectureCode = str_replace('*', '%', $lectureCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ElHaveTableMap::COL_LECTURE_CODE, $lectureCode, $comparison);
    }

    /**
     * Filter the query by a related \BossEdu\Model\Event object
     *
     * @param \BossEdu\Model\Event|ObjectCollection $event The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildElHaveQuery The current query, for fluid interface
     */
    public function filterByEvent($event, $comparison = null)
    {
        if ($event instanceof \BossEdu\Model\Event) {
            return $this
                ->addUsingAlias(ElHaveTableMap::COL_EVENT_CODE, $event->getCode(), $comparison);
        } elseif ($event instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ElHaveTableMap::COL_EVENT_CODE, $event->toKeyValue('PrimaryKey', 'Code'), $comparison);
        } else {
            throw new PropelException('filterByEvent() only accepts arguments of type \BossEdu\Model\Event or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Event relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildElHaveQuery The current query, for fluid interface
     */
    public function joinEvent($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Event');

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
            $this->addJoinObject($join, 'Event');
        }

        return $this;
    }

    /**
     * Use the Event relation Event object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BossEdu\Model\EventQuery A secondary query class using the current class as primary query
     */
    public function useEventQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEvent($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Event', '\BossEdu\Model\EventQuery');
    }

    /**
     * Filter the query by a related \BossEdu\Model\Lecture object
     *
     * @param \BossEdu\Model\Lecture|ObjectCollection $lecture The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildElHaveQuery The current query, for fluid interface
     */
    public function filterByLecture($lecture, $comparison = null)
    {
        if ($lecture instanceof \BossEdu\Model\Lecture) {
            return $this
                ->addUsingAlias(ElHaveTableMap::COL_LECTURE_CODE, $lecture->getCode(), $comparison);
        } elseif ($lecture instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ElHaveTableMap::COL_LECTURE_CODE, $lecture->toKeyValue('PrimaryKey', 'Code'), $comparison);
        } else {
            throw new PropelException('filterByLecture() only accepts arguments of type \BossEdu\Model\Lecture or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Lecture relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildElHaveQuery The current query, for fluid interface
     */
    public function joinLecture($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Lecture');

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
            $this->addJoinObject($join, 'Lecture');
        }

        return $this;
    }

    /**
     * Use the Lecture relation Lecture object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BossEdu\Model\LectureQuery A secondary query class using the current class as primary query
     */
    public function useLectureQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinLecture($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Lecture', '\BossEdu\Model\LectureQuery');
    }

    /**
     * Filter the query by a related \BossEdu\Model\Instruction object
     *
     * @param \BossEdu\Model\Instruction|ObjectCollection $instruction the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildElHaveQuery The current query, for fluid interface
     */
    public function filterByInstruction($instruction, $comparison = null)
    {
        if ($instruction instanceof \BossEdu\Model\Instruction) {
            return $this
                ->addUsingAlias(ElHaveTableMap::COL_EVENT_CODE, $instruction->getEventCode(), $comparison)
                ->addUsingAlias(ElHaveTableMap::COL_LECTURE_CODE, $instruction->getLectureCode(), $comparison);
        } else {
            throw new PropelException('filterByInstruction() only accepts arguments of type \BossEdu\Model\Instruction');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Instruction relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildElHaveQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildElHave $elHave Object to remove from the list of results
     *
     * @return $this|ChildElHaveQuery The current query, for fluid interface
     */
    public function prune($elHave = null)
    {
        if ($elHave) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ElHaveTableMap::COL_EVENT_CODE), $elHave->getEventCode(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ElHaveTableMap::COL_LECTURE_CODE), $elHave->getLectureCode(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the el_have table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ElHaveTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ElHaveTableMap::clearInstancePool();
            ElHaveTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ElHaveTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ElHaveTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            ElHaveTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ElHaveTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ElHaveQuery
