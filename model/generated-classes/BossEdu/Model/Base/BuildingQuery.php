<?php

namespace BossEdu\Model\Base;

use \Exception;
use \PDO;
use BossEdu\Model\Building as ChildBuilding;
use BossEdu\Model\BuildingQuery as ChildBuildingQuery;
use BossEdu\Model\Map\BuildingTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'building' table.
 *
 * 
 *
 * @method     ChildBuildingQuery orderByCode($order = Criteria::ASC) Order by the code column
 * @method     ChildBuildingQuery orderByDescription($order = Criteria::ASC) Order by the description column
 *
 * @method     ChildBuildingQuery groupByCode() Group by the code column
 * @method     ChildBuildingQuery groupByDescription() Group by the description column
 *
 * @method     ChildBuildingQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBuildingQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBuildingQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBuildingQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildBuildingQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildBuildingQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildBuildingQuery leftJoinRoom($relationAlias = null) Adds a LEFT JOIN clause to the query using the Room relation
 * @method     ChildBuildingQuery rightJoinRoom($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Room relation
 * @method     ChildBuildingQuery innerJoinRoom($relationAlias = null) Adds a INNER JOIN clause to the query using the Room relation
 *
 * @method     ChildBuildingQuery joinWithRoom($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Room relation
 *
 * @method     ChildBuildingQuery leftJoinWithRoom() Adds a LEFT JOIN clause and with to the query using the Room relation
 * @method     ChildBuildingQuery rightJoinWithRoom() Adds a RIGHT JOIN clause and with to the query using the Room relation
 * @method     ChildBuildingQuery innerJoinWithRoom() Adds a INNER JOIN clause and with to the query using the Room relation
 *
 * @method     \BossEdu\Model\RoomQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildBuilding findOne(ConnectionInterface $con = null) Return the first ChildBuilding matching the query
 * @method     ChildBuilding findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBuilding matching the query, or a new ChildBuilding object populated from the query conditions when no match is found
 *
 * @method     ChildBuilding findOneByCode(string $code) Return the first ChildBuilding filtered by the code column
 * @method     ChildBuilding findOneByDescription(string $description) Return the first ChildBuilding filtered by the description column *

 * @method     ChildBuilding requirePk($key, ConnectionInterface $con = null) Return the ChildBuilding by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBuilding requireOne(ConnectionInterface $con = null) Return the first ChildBuilding matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBuilding requireOneByCode(string $code) Return the first ChildBuilding filtered by the code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBuilding requireOneByDescription(string $description) Return the first ChildBuilding filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBuilding[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBuilding objects based on current ModelCriteria
 * @method     ChildBuilding[]|ObjectCollection findByCode(string $code) Return ChildBuilding objects filtered by the code column
 * @method     ChildBuilding[]|ObjectCollection findByDescription(string $description) Return ChildBuilding objects filtered by the description column
 * @method     ChildBuilding[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BuildingQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \BossEdu\Model\Base\BuildingQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\BossEdu\\Model\\Building', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBuildingQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBuildingQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBuildingQuery) {
            return $criteria;
        }
        $query = new ChildBuildingQuery();
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
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildBuilding|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = BuildingTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BuildingTableMap::DATABASE_NAME);
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
     * @return ChildBuilding A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT code, description FROM building WHERE code = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildBuilding $obj */
            $obj = new ChildBuilding();
            $obj->hydrate($row);
            BuildingTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildBuilding|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(12, 56, 832), $con);
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
     * @return $this|ChildBuildingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BuildingTableMap::COL_CODE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBuildingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BuildingTableMap::COL_CODE, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the code column
     *
     * Example usage:
     * <code>
     * $query->filterByCode('fooValue');   // WHERE code = 'fooValue'
     * $query->filterByCode('%fooValue%'); // WHERE code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $code The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBuildingQuery The current query, for fluid interface
     */
    public function filterByCode($code = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($code)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $code)) {
                $code = str_replace('*', '%', $code);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BuildingTableMap::COL_CODE, $code, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBuildingQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BuildingTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query by a related \BossEdu\Model\Room object
     *
     * @param \BossEdu\Model\Room|ObjectCollection $room the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBuildingQuery The current query, for fluid interface
     */
    public function filterByRoom($room, $comparison = null)
    {
        if ($room instanceof \BossEdu\Model\Room) {
            return $this
                ->addUsingAlias(BuildingTableMap::COL_CODE, $room->getBuildingCode(), $comparison);
        } elseif ($room instanceof ObjectCollection) {
            return $this
                ->useRoomQuery()
                ->filterByPrimaryKeys($room->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRoom() only accepts arguments of type \BossEdu\Model\Room or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Room relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBuildingQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildBuilding $building Object to remove from the list of results
     *
     * @return $this|ChildBuildingQuery The current query, for fluid interface
     */
    public function prune($building = null)
    {
        if ($building) {
            $this->addUsingAlias(BuildingTableMap::COL_CODE, $building->getCode(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the building table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BuildingTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BuildingTableMap::clearInstancePool();
            BuildingTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BuildingTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BuildingTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            BuildingTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            BuildingTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BuildingQuery
