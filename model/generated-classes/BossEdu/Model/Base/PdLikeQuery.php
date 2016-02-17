<?php

namespace BossEdu\Model\Base;

use \Exception;
use \PDO;
use BossEdu\Model\PdLike as ChildPdLike;
use BossEdu\Model\PdLikeQuery as ChildPdLikeQuery;
use BossEdu\Model\Map\PdLikeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'pd_like' table.
 *
 * 
 *
 * @method     ChildPdLikeQuery orderByPersonId($order = Criteria::ASC) Order by the person_id column
 * @method     ChildPdLikeQuery orderByDoubtId($order = Criteria::ASC) Order by the doubt_id column
 * @method     ChildPdLikeQuery orderByUnderstand($order = Criteria::ASC) Order by the understand column
 *
 * @method     ChildPdLikeQuery groupByPersonId() Group by the person_id column
 * @method     ChildPdLikeQuery groupByDoubtId() Group by the doubt_id column
 * @method     ChildPdLikeQuery groupByUnderstand() Group by the understand column
 *
 * @method     ChildPdLikeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPdLikeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPdLikeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPdLikeQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPdLikeQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPdLikeQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPdLikeQuery leftJoinPerson($relationAlias = null) Adds a LEFT JOIN clause to the query using the Person relation
 * @method     ChildPdLikeQuery rightJoinPerson($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Person relation
 * @method     ChildPdLikeQuery innerJoinPerson($relationAlias = null) Adds a INNER JOIN clause to the query using the Person relation
 *
 * @method     ChildPdLikeQuery joinWithPerson($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Person relation
 *
 * @method     ChildPdLikeQuery leftJoinWithPerson() Adds a LEFT JOIN clause and with to the query using the Person relation
 * @method     ChildPdLikeQuery rightJoinWithPerson() Adds a RIGHT JOIN clause and with to the query using the Person relation
 * @method     ChildPdLikeQuery innerJoinWithPerson() Adds a INNER JOIN clause and with to the query using the Person relation
 *
 * @method     ChildPdLikeQuery leftJoinDoubt($relationAlias = null) Adds a LEFT JOIN clause to the query using the Doubt relation
 * @method     ChildPdLikeQuery rightJoinDoubt($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Doubt relation
 * @method     ChildPdLikeQuery innerJoinDoubt($relationAlias = null) Adds a INNER JOIN clause to the query using the Doubt relation
 *
 * @method     ChildPdLikeQuery joinWithDoubt($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Doubt relation
 *
 * @method     ChildPdLikeQuery leftJoinWithDoubt() Adds a LEFT JOIN clause and with to the query using the Doubt relation
 * @method     ChildPdLikeQuery rightJoinWithDoubt() Adds a RIGHT JOIN clause and with to the query using the Doubt relation
 * @method     ChildPdLikeQuery innerJoinWithDoubt() Adds a INNER JOIN clause and with to the query using the Doubt relation
 *
 * @method     \BossEdu\Model\PersonQuery|\BossEdu\Model\DoubtQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPdLike findOne(ConnectionInterface $con = null) Return the first ChildPdLike matching the query
 * @method     ChildPdLike findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPdLike matching the query, or a new ChildPdLike object populated from the query conditions when no match is found
 *
 * @method     ChildPdLike findOneByPersonId(int $person_id) Return the first ChildPdLike filtered by the person_id column
 * @method     ChildPdLike findOneByDoubtId(int $doubt_id) Return the first ChildPdLike filtered by the doubt_id column
 * @method     ChildPdLike findOneByUnderstand(boolean $understand) Return the first ChildPdLike filtered by the understand column *

 * @method     ChildPdLike requirePk($key, ConnectionInterface $con = null) Return the ChildPdLike by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPdLike requireOne(ConnectionInterface $con = null) Return the first ChildPdLike matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPdLike requireOneByPersonId(int $person_id) Return the first ChildPdLike filtered by the person_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPdLike requireOneByDoubtId(int $doubt_id) Return the first ChildPdLike filtered by the doubt_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPdLike requireOneByUnderstand(boolean $understand) Return the first ChildPdLike filtered by the understand column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPdLike[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPdLike objects based on current ModelCriteria
 * @method     ChildPdLike[]|ObjectCollection findByPersonId(int $person_id) Return ChildPdLike objects filtered by the person_id column
 * @method     ChildPdLike[]|ObjectCollection findByDoubtId(int $doubt_id) Return ChildPdLike objects filtered by the doubt_id column
 * @method     ChildPdLike[]|ObjectCollection findByUnderstand(boolean $understand) Return ChildPdLike objects filtered by the understand column
 * @method     ChildPdLike[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PdLikeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \BossEdu\Model\Base\PdLikeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\BossEdu\\Model\\PdLike', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPdLikeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPdLikeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPdLikeQuery) {
            return $criteria;
        }
        $query = new ChildPdLikeQuery();
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
     * @param array[$person_id, $doubt_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildPdLike|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PdLikeTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])])))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PdLikeTableMap::DATABASE_NAME);
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
     * @return ChildPdLike A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT person_id, doubt_id, understand FROM pd_like WHERE person_id = :p0 AND doubt_id = :p1';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildPdLike $obj */
            $obj = new ChildPdLike();
            $obj->hydrate($row);
            PdLikeTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildPdLike|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPdLikeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(PdLikeTableMap::COL_PERSON_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(PdLikeTableMap::COL_DOUBT_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPdLikeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(PdLikeTableMap::COL_PERSON_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(PdLikeTableMap::COL_DOUBT_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the person_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPersonId(1234); // WHERE person_id = 1234
     * $query->filterByPersonId(array(12, 34)); // WHERE person_id IN (12, 34)
     * $query->filterByPersonId(array('min' => 12)); // WHERE person_id > 12
     * </code>
     *
     * @see       filterByPerson()
     *
     * @param     mixed $personId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPdLikeQuery The current query, for fluid interface
     */
    public function filterByPersonId($personId = null, $comparison = null)
    {
        if (is_array($personId)) {
            $useMinMax = false;
            if (isset($personId['min'])) {
                $this->addUsingAlias(PdLikeTableMap::COL_PERSON_ID, $personId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($personId['max'])) {
                $this->addUsingAlias(PdLikeTableMap::COL_PERSON_ID, $personId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PdLikeTableMap::COL_PERSON_ID, $personId, $comparison);
    }

    /**
     * Filter the query on the doubt_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDoubtId(1234); // WHERE doubt_id = 1234
     * $query->filterByDoubtId(array(12, 34)); // WHERE doubt_id IN (12, 34)
     * $query->filterByDoubtId(array('min' => 12)); // WHERE doubt_id > 12
     * </code>
     *
     * @see       filterByDoubt()
     *
     * @param     mixed $doubtId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPdLikeQuery The current query, for fluid interface
     */
    public function filterByDoubtId($doubtId = null, $comparison = null)
    {
        if (is_array($doubtId)) {
            $useMinMax = false;
            if (isset($doubtId['min'])) {
                $this->addUsingAlias(PdLikeTableMap::COL_DOUBT_ID, $doubtId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($doubtId['max'])) {
                $this->addUsingAlias(PdLikeTableMap::COL_DOUBT_ID, $doubtId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PdLikeTableMap::COL_DOUBT_ID, $doubtId, $comparison);
    }

    /**
     * Filter the query on the understand column
     *
     * Example usage:
     * <code>
     * $query->filterByUnderstand(true); // WHERE understand = true
     * $query->filterByUnderstand('yes'); // WHERE understand = true
     * </code>
     *
     * @param     boolean|string $understand The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPdLikeQuery The current query, for fluid interface
     */
    public function filterByUnderstand($understand = null, $comparison = null)
    {
        if (is_string($understand)) {
            $understand = in_array(strtolower($understand), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PdLikeTableMap::COL_UNDERSTAND, $understand, $comparison);
    }

    /**
     * Filter the query by a related \BossEdu\Model\Person object
     *
     * @param \BossEdu\Model\Person|ObjectCollection $person The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPdLikeQuery The current query, for fluid interface
     */
    public function filterByPerson($person, $comparison = null)
    {
        if ($person instanceof \BossEdu\Model\Person) {
            return $this
                ->addUsingAlias(PdLikeTableMap::COL_PERSON_ID, $person->getId(), $comparison);
        } elseif ($person instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PdLikeTableMap::COL_PERSON_ID, $person->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPerson() only accepts arguments of type \BossEdu\Model\Person or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Person relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPdLikeQuery The current query, for fluid interface
     */
    public function joinPerson($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Person');

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
            $this->addJoinObject($join, 'Person');
        }

        return $this;
    }

    /**
     * Use the Person relation Person object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BossEdu\Model\PersonQuery A secondary query class using the current class as primary query
     */
    public function usePersonQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPerson($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Person', '\BossEdu\Model\PersonQuery');
    }

    /**
     * Filter the query by a related \BossEdu\Model\Doubt object
     *
     * @param \BossEdu\Model\Doubt|ObjectCollection $doubt The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPdLikeQuery The current query, for fluid interface
     */
    public function filterByDoubt($doubt, $comparison = null)
    {
        if ($doubt instanceof \BossEdu\Model\Doubt) {
            return $this
                ->addUsingAlias(PdLikeTableMap::COL_DOUBT_ID, $doubt->getId(), $comparison);
        } elseif ($doubt instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PdLikeTableMap::COL_DOUBT_ID, $doubt->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByDoubt() only accepts arguments of type \BossEdu\Model\Doubt or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Doubt relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPdLikeQuery The current query, for fluid interface
     */
    public function joinDoubt($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Doubt');

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
            $this->addJoinObject($join, 'Doubt');
        }

        return $this;
    }

    /**
     * Use the Doubt relation Doubt object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BossEdu\Model\DoubtQuery A secondary query class using the current class as primary query
     */
    public function useDoubtQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDoubt($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Doubt', '\BossEdu\Model\DoubtQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPdLike $pdLike Object to remove from the list of results
     *
     * @return $this|ChildPdLikeQuery The current query, for fluid interface
     */
    public function prune($pdLike = null)
    {
        if ($pdLike) {
            $this->addCond('pruneCond0', $this->getAliasedColName(PdLikeTableMap::COL_PERSON_ID), $pdLike->getPersonId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(PdLikeTableMap::COL_DOUBT_ID), $pdLike->getDoubtId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the pd_like table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PdLikeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PdLikeTableMap::clearInstancePool();
            PdLikeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PdLikeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PdLikeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            PdLikeTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            PdLikeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PdLikeQuery
