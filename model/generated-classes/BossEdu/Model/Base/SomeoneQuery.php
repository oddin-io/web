<?php

namespace BossEdu\Model\Base;

use \Exception;
use \PDO;
use BossEdu\Model\Someone as ChildSomeone;
use BossEdu\Model\SomeoneQuery as ChildSomeoneQuery;
use BossEdu\Model\Map\SomeoneTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'someone' table.
 *
 * 
 *
 * @method     ChildSomeoneQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildSomeoneQuery orderByPassword($order = Criteria::ASC) Order by the password column
 * @method     ChildSomeoneQuery orderByRegistrationDate($order = Criteria::ASC) Order by the registration_date column
 * @method     ChildSomeoneQuery orderByAdmin($order = Criteria::ASC) Order by the admin column
 *
 * @method     ChildSomeoneQuery groupByEmail() Group by the email column
 * @method     ChildSomeoneQuery groupByPassword() Group by the password column
 * @method     ChildSomeoneQuery groupByRegistrationDate() Group by the registration_date column
 * @method     ChildSomeoneQuery groupByAdmin() Group by the admin column
 *
 * @method     ChildSomeoneQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSomeoneQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSomeoneQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSomeoneQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSomeoneQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSomeoneQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSomeoneQuery leftJoinPerson($relationAlias = null) Adds a LEFT JOIN clause to the query using the Person relation
 * @method     ChildSomeoneQuery rightJoinPerson($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Person relation
 * @method     ChildSomeoneQuery innerJoinPerson($relationAlias = null) Adds a INNER JOIN clause to the query using the Person relation
 *
 * @method     ChildSomeoneQuery joinWithPerson($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Person relation
 *
 * @method     ChildSomeoneQuery leftJoinWithPerson() Adds a LEFT JOIN clause and with to the query using the Person relation
 * @method     ChildSomeoneQuery rightJoinWithPerson() Adds a RIGHT JOIN clause and with to the query using the Person relation
 * @method     ChildSomeoneQuery innerJoinWithPerson() Adds a INNER JOIN clause and with to the query using the Person relation
 *
 * @method     \BossEdu\Model\PersonQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSomeone findOne(ConnectionInterface $con = null) Return the first ChildSomeone matching the query
 * @method     ChildSomeone findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSomeone matching the query, or a new ChildSomeone object populated from the query conditions when no match is found
 *
 * @method     ChildSomeone findOneByEmail(string $email) Return the first ChildSomeone filtered by the email column
 * @method     ChildSomeone findOneByPassword(string $password) Return the first ChildSomeone filtered by the password column
 * @method     ChildSomeone findOneByRegistrationDate(string $registration_date) Return the first ChildSomeone filtered by the registration_date column
 * @method     ChildSomeone findOneByAdmin(boolean $admin) Return the first ChildSomeone filtered by the admin column *

 * @method     ChildSomeone requirePk($key, ConnectionInterface $con = null) Return the ChildSomeone by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSomeone requireOne(ConnectionInterface $con = null) Return the first ChildSomeone matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSomeone requireOneByEmail(string $email) Return the first ChildSomeone filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSomeone requireOneByPassword(string $password) Return the first ChildSomeone filtered by the password column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSomeone requireOneByRegistrationDate(string $registration_date) Return the first ChildSomeone filtered by the registration_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSomeone requireOneByAdmin(boolean $admin) Return the first ChildSomeone filtered by the admin column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSomeone[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSomeone objects based on current ModelCriteria
 * @method     ChildSomeone[]|ObjectCollection findByEmail(string $email) Return ChildSomeone objects filtered by the email column
 * @method     ChildSomeone[]|ObjectCollection findByPassword(string $password) Return ChildSomeone objects filtered by the password column
 * @method     ChildSomeone[]|ObjectCollection findByRegistrationDate(string $registration_date) Return ChildSomeone objects filtered by the registration_date column
 * @method     ChildSomeone[]|ObjectCollection findByAdmin(boolean $admin) Return ChildSomeone objects filtered by the admin column
 * @method     ChildSomeone[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SomeoneQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \BossEdu\Model\Base\SomeoneQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\BossEdu\\Model\\Someone', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSomeoneQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSomeoneQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSomeoneQuery) {
            return $criteria;
        }
        $query = new ChildSomeoneQuery();
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
     * @return ChildSomeone|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SomeoneTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SomeoneTableMap::DATABASE_NAME);
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
     * @return ChildSomeone A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT email, password, registration_date, admin FROM someone WHERE email = :p0';
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
            /** @var ChildSomeone $obj */
            $obj = new ChildSomeone();
            $obj->hydrate($row);
            SomeoneTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildSomeone|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSomeoneQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SomeoneTableMap::COL_EMAIL, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSomeoneQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SomeoneTableMap::COL_EMAIL, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSomeoneQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $email)) {
                $email = str_replace('*', '%', $email);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SomeoneTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the password column
     *
     * Example usage:
     * <code>
     * $query->filterByPassword('fooValue');   // WHERE password = 'fooValue'
     * $query->filterByPassword('%fooValue%'); // WHERE password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $password The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSomeoneQuery The current query, for fluid interface
     */
    public function filterByPassword($password = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($password)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $password)) {
                $password = str_replace('*', '%', $password);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SomeoneTableMap::COL_PASSWORD, $password, $comparison);
    }

    /**
     * Filter the query on the registration_date column
     *
     * Example usage:
     * <code>
     * $query->filterByRegistrationDate('2011-03-14'); // WHERE registration_date = '2011-03-14'
     * $query->filterByRegistrationDate('now'); // WHERE registration_date = '2011-03-14'
     * $query->filterByRegistrationDate(array('max' => 'yesterday')); // WHERE registration_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $registrationDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSomeoneQuery The current query, for fluid interface
     */
    public function filterByRegistrationDate($registrationDate = null, $comparison = null)
    {
        if (is_array($registrationDate)) {
            $useMinMax = false;
            if (isset($registrationDate['min'])) {
                $this->addUsingAlias(SomeoneTableMap::COL_REGISTRATION_DATE, $registrationDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($registrationDate['max'])) {
                $this->addUsingAlias(SomeoneTableMap::COL_REGISTRATION_DATE, $registrationDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SomeoneTableMap::COL_REGISTRATION_DATE, $registrationDate, $comparison);
    }

    /**
     * Filter the query on the admin column
     *
     * Example usage:
     * <code>
     * $query->filterByAdmin(true); // WHERE admin = true
     * $query->filterByAdmin('yes'); // WHERE admin = true
     * </code>
     *
     * @param     boolean|string $admin The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSomeoneQuery The current query, for fluid interface
     */
    public function filterByAdmin($admin = null, $comparison = null)
    {
        if (is_string($admin)) {
            $admin = in_array(strtolower($admin), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SomeoneTableMap::COL_ADMIN, $admin, $comparison);
    }

    /**
     * Filter the query by a related \BossEdu\Model\Person object
     *
     * @param \BossEdu\Model\Person|ObjectCollection $person the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSomeoneQuery The current query, for fluid interface
     */
    public function filterByPerson($person, $comparison = null)
    {
        if ($person instanceof \BossEdu\Model\Person) {
            return $this
                ->addUsingAlias(SomeoneTableMap::COL_EMAIL, $person->getEmail(), $comparison);
        } elseif ($person instanceof ObjectCollection) {
            return $this
                ->usePersonQuery()
                ->filterByPrimaryKeys($person->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildSomeoneQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildSomeone $someone Object to remove from the list of results
     *
     * @return $this|ChildSomeoneQuery The current query, for fluid interface
     */
    public function prune($someone = null)
    {
        if ($someone) {
            $this->addUsingAlias(SomeoneTableMap::COL_EMAIL, $someone->getEmail(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the someone table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SomeoneTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SomeoneTableMap::clearInstancePool();
            SomeoneTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SomeoneTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SomeoneTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            SomeoneTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            SomeoneTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SomeoneQuery
