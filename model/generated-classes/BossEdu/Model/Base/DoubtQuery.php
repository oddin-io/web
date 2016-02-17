<?php

namespace BossEdu\Model\Base;

use \Exception;
use \PDO;
use BossEdu\Model\Doubt as ChildDoubt;
use BossEdu\Model\DoubtQuery as ChildDoubtQuery;
use BossEdu\Model\Map\DoubtTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'doubt' table.
 *
 * 
 *
 * @method     ChildDoubtQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildDoubtQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildDoubtQuery orderByText($order = Criteria::ASC) Order by the text column
 * @method     ChildDoubtQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildDoubtQuery orderByAnonymous($order = Criteria::ASC) Order by the anonymous column
 * @method     ChildDoubtQuery orderByUnderstand($order = Criteria::ASC) Order by the understand column
 * @method     ChildDoubtQuery orderByPresentationId($order = Criteria::ASC) Order by the presentation_id column
 * @method     ChildDoubtQuery orderByPersonId($order = Criteria::ASC) Order by the person_id column
 *
 * @method     ChildDoubtQuery groupById() Group by the id column
 * @method     ChildDoubtQuery groupByStatus() Group by the status column
 * @method     ChildDoubtQuery groupByText() Group by the text column
 * @method     ChildDoubtQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildDoubtQuery groupByAnonymous() Group by the anonymous column
 * @method     ChildDoubtQuery groupByUnderstand() Group by the understand column
 * @method     ChildDoubtQuery groupByPresentationId() Group by the presentation_id column
 * @method     ChildDoubtQuery groupByPersonId() Group by the person_id column
 *
 * @method     ChildDoubtQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDoubtQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDoubtQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDoubtQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDoubtQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDoubtQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDoubtQuery leftJoinPresentation($relationAlias = null) Adds a LEFT JOIN clause to the query using the Presentation relation
 * @method     ChildDoubtQuery rightJoinPresentation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Presentation relation
 * @method     ChildDoubtQuery innerJoinPresentation($relationAlias = null) Adds a INNER JOIN clause to the query using the Presentation relation
 *
 * @method     ChildDoubtQuery joinWithPresentation($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Presentation relation
 *
 * @method     ChildDoubtQuery leftJoinWithPresentation() Adds a LEFT JOIN clause and with to the query using the Presentation relation
 * @method     ChildDoubtQuery rightJoinWithPresentation() Adds a RIGHT JOIN clause and with to the query using the Presentation relation
 * @method     ChildDoubtQuery innerJoinWithPresentation() Adds a INNER JOIN clause and with to the query using the Presentation relation
 *
 * @method     ChildDoubtQuery leftJoinPerson($relationAlias = null) Adds a LEFT JOIN clause to the query using the Person relation
 * @method     ChildDoubtQuery rightJoinPerson($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Person relation
 * @method     ChildDoubtQuery innerJoinPerson($relationAlias = null) Adds a INNER JOIN clause to the query using the Person relation
 *
 * @method     ChildDoubtQuery joinWithPerson($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Person relation
 *
 * @method     ChildDoubtQuery leftJoinWithPerson() Adds a LEFT JOIN clause and with to the query using the Person relation
 * @method     ChildDoubtQuery rightJoinWithPerson() Adds a RIGHT JOIN clause and with to the query using the Person relation
 * @method     ChildDoubtQuery innerJoinWithPerson() Adds a INNER JOIN clause and with to the query using the Person relation
 *
 * @method     ChildDoubtQuery leftJoinPdLike($relationAlias = null) Adds a LEFT JOIN clause to the query using the PdLike relation
 * @method     ChildDoubtQuery rightJoinPdLike($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PdLike relation
 * @method     ChildDoubtQuery innerJoinPdLike($relationAlias = null) Adds a INNER JOIN clause to the query using the PdLike relation
 *
 * @method     ChildDoubtQuery joinWithPdLike($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PdLike relation
 *
 * @method     ChildDoubtQuery leftJoinWithPdLike() Adds a LEFT JOIN clause and with to the query using the PdLike relation
 * @method     ChildDoubtQuery rightJoinWithPdLike() Adds a RIGHT JOIN clause and with to the query using the PdLike relation
 * @method     ChildDoubtQuery innerJoinWithPdLike() Adds a INNER JOIN clause and with to the query using the PdLike relation
 *
 * @method     ChildDoubtQuery leftJoinContribution($relationAlias = null) Adds a LEFT JOIN clause to the query using the Contribution relation
 * @method     ChildDoubtQuery rightJoinContribution($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Contribution relation
 * @method     ChildDoubtQuery innerJoinContribution($relationAlias = null) Adds a INNER JOIN clause to the query using the Contribution relation
 *
 * @method     ChildDoubtQuery joinWithContribution($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Contribution relation
 *
 * @method     ChildDoubtQuery leftJoinWithContribution() Adds a LEFT JOIN clause and with to the query using the Contribution relation
 * @method     ChildDoubtQuery rightJoinWithContribution() Adds a RIGHT JOIN clause and with to the query using the Contribution relation
 * @method     ChildDoubtQuery innerJoinWithContribution() Adds a INNER JOIN clause and with to the query using the Contribution relation
 *
 * @method     \BossEdu\Model\PresentationQuery|\BossEdu\Model\PersonQuery|\BossEdu\Model\PdLikeQuery|\BossEdu\Model\ContributionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDoubt findOne(ConnectionInterface $con = null) Return the first ChildDoubt matching the query
 * @method     ChildDoubt findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDoubt matching the query, or a new ChildDoubt object populated from the query conditions when no match is found
 *
 * @method     ChildDoubt findOneById(int $id) Return the first ChildDoubt filtered by the id column
 * @method     ChildDoubt findOneByStatus(int $status) Return the first ChildDoubt filtered by the status column
 * @method     ChildDoubt findOneByText(string $text) Return the first ChildDoubt filtered by the text column
 * @method     ChildDoubt findOneByCreatedAt(string $created_at) Return the first ChildDoubt filtered by the created_at column
 * @method     ChildDoubt findOneByAnonymous(boolean $anonymous) Return the first ChildDoubt filtered by the anonymous column
 * @method     ChildDoubt findOneByUnderstand(boolean $understand) Return the first ChildDoubt filtered by the understand column
 * @method     ChildDoubt findOneByPresentationId(int $presentation_id) Return the first ChildDoubt filtered by the presentation_id column
 * @method     ChildDoubt findOneByPersonId(int $person_id) Return the first ChildDoubt filtered by the person_id column *

 * @method     ChildDoubt requirePk($key, ConnectionInterface $con = null) Return the ChildDoubt by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDoubt requireOne(ConnectionInterface $con = null) Return the first ChildDoubt matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDoubt requireOneById(int $id) Return the first ChildDoubt filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDoubt requireOneByStatus(int $status) Return the first ChildDoubt filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDoubt requireOneByText(string $text) Return the first ChildDoubt filtered by the text column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDoubt requireOneByCreatedAt(string $created_at) Return the first ChildDoubt filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDoubt requireOneByAnonymous(boolean $anonymous) Return the first ChildDoubt filtered by the anonymous column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDoubt requireOneByUnderstand(boolean $understand) Return the first ChildDoubt filtered by the understand column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDoubt requireOneByPresentationId(int $presentation_id) Return the first ChildDoubt filtered by the presentation_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDoubt requireOneByPersonId(int $person_id) Return the first ChildDoubt filtered by the person_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDoubt[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDoubt objects based on current ModelCriteria
 * @method     ChildDoubt[]|ObjectCollection findById(int $id) Return ChildDoubt objects filtered by the id column
 * @method     ChildDoubt[]|ObjectCollection findByStatus(int $status) Return ChildDoubt objects filtered by the status column
 * @method     ChildDoubt[]|ObjectCollection findByText(string $text) Return ChildDoubt objects filtered by the text column
 * @method     ChildDoubt[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildDoubt objects filtered by the created_at column
 * @method     ChildDoubt[]|ObjectCollection findByAnonymous(boolean $anonymous) Return ChildDoubt objects filtered by the anonymous column
 * @method     ChildDoubt[]|ObjectCollection findByUnderstand(boolean $understand) Return ChildDoubt objects filtered by the understand column
 * @method     ChildDoubt[]|ObjectCollection findByPresentationId(int $presentation_id) Return ChildDoubt objects filtered by the presentation_id column
 * @method     ChildDoubt[]|ObjectCollection findByPersonId(int $person_id) Return ChildDoubt objects filtered by the person_id column
 * @method     ChildDoubt[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DoubtQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \BossEdu\Model\Base\DoubtQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\BossEdu\\Model\\Doubt', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDoubtQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDoubtQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDoubtQuery) {
            return $criteria;
        }
        $query = new ChildDoubtQuery();
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
     * @return ChildDoubt|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = DoubtTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DoubtTableMap::DATABASE_NAME);
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
     * @return ChildDoubt A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, status, text, created_at, anonymous, understand, presentation_id, person_id FROM doubt WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildDoubt $obj */
            $obj = new ChildDoubt();
            $obj->hydrate($row);
            DoubtTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildDoubt|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildDoubtQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DoubtTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDoubtQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DoubtTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDoubtQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(DoubtTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DoubtTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DoubtTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus(1234); // WHERE status = 1234
     * $query->filterByStatus(array(12, 34)); // WHERE status IN (12, 34)
     * $query->filterByStatus(array('min' => 12)); // WHERE status > 12
     * </code>
     *
     * @param     mixed $status The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDoubtQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (is_array($status)) {
            $useMinMax = false;
            if (isset($status['min'])) {
                $this->addUsingAlias(DoubtTableMap::COL_STATUS, $status['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($status['max'])) {
                $this->addUsingAlias(DoubtTableMap::COL_STATUS, $status['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DoubtTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the text column
     *
     * Example usage:
     * <code>
     * $query->filterByText('fooValue');   // WHERE text = 'fooValue'
     * $query->filterByText('%fooValue%'); // WHERE text LIKE '%fooValue%'
     * </code>
     *
     * @param     string $text The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDoubtQuery The current query, for fluid interface
     */
    public function filterByText($text = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($text)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $text)) {
                $text = str_replace('*', '%', $text);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DoubtTableMap::COL_TEXT, $text, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDoubtQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(DoubtTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(DoubtTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DoubtTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the anonymous column
     *
     * Example usage:
     * <code>
     * $query->filterByAnonymous(true); // WHERE anonymous = true
     * $query->filterByAnonymous('yes'); // WHERE anonymous = true
     * </code>
     *
     * @param     boolean|string $anonymous The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDoubtQuery The current query, for fluid interface
     */
    public function filterByAnonymous($anonymous = null, $comparison = null)
    {
        if (is_string($anonymous)) {
            $anonymous = in_array(strtolower($anonymous), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(DoubtTableMap::COL_ANONYMOUS, $anonymous, $comparison);
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
     * @return $this|ChildDoubtQuery The current query, for fluid interface
     */
    public function filterByUnderstand($understand = null, $comparison = null)
    {
        if (is_string($understand)) {
            $understand = in_array(strtolower($understand), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(DoubtTableMap::COL_UNDERSTAND, $understand, $comparison);
    }

    /**
     * Filter the query on the presentation_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPresentationId(1234); // WHERE presentation_id = 1234
     * $query->filterByPresentationId(array(12, 34)); // WHERE presentation_id IN (12, 34)
     * $query->filterByPresentationId(array('min' => 12)); // WHERE presentation_id > 12
     * </code>
     *
     * @see       filterByPresentation()
     *
     * @param     mixed $presentationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDoubtQuery The current query, for fluid interface
     */
    public function filterByPresentationId($presentationId = null, $comparison = null)
    {
        if (is_array($presentationId)) {
            $useMinMax = false;
            if (isset($presentationId['min'])) {
                $this->addUsingAlias(DoubtTableMap::COL_PRESENTATION_ID, $presentationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($presentationId['max'])) {
                $this->addUsingAlias(DoubtTableMap::COL_PRESENTATION_ID, $presentationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DoubtTableMap::COL_PRESENTATION_ID, $presentationId, $comparison);
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
     * @return $this|ChildDoubtQuery The current query, for fluid interface
     */
    public function filterByPersonId($personId = null, $comparison = null)
    {
        if (is_array($personId)) {
            $useMinMax = false;
            if (isset($personId['min'])) {
                $this->addUsingAlias(DoubtTableMap::COL_PERSON_ID, $personId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($personId['max'])) {
                $this->addUsingAlias(DoubtTableMap::COL_PERSON_ID, $personId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DoubtTableMap::COL_PERSON_ID, $personId, $comparison);
    }

    /**
     * Filter the query by a related \BossEdu\Model\Presentation object
     *
     * @param \BossEdu\Model\Presentation|ObjectCollection $presentation The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDoubtQuery The current query, for fluid interface
     */
    public function filterByPresentation($presentation, $comparison = null)
    {
        if ($presentation instanceof \BossEdu\Model\Presentation) {
            return $this
                ->addUsingAlias(DoubtTableMap::COL_PRESENTATION_ID, $presentation->getId(), $comparison);
        } elseif ($presentation instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DoubtTableMap::COL_PRESENTATION_ID, $presentation->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPresentation() only accepts arguments of type \BossEdu\Model\Presentation or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Presentation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDoubtQuery The current query, for fluid interface
     */
    public function joinPresentation($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Presentation');

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
            $this->addJoinObject($join, 'Presentation');
        }

        return $this;
    }

    /**
     * Use the Presentation relation Presentation object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BossEdu\Model\PresentationQuery A secondary query class using the current class as primary query
     */
    public function usePresentationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPresentation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Presentation', '\BossEdu\Model\PresentationQuery');
    }

    /**
     * Filter the query by a related \BossEdu\Model\Person object
     *
     * @param \BossEdu\Model\Person|ObjectCollection $person The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDoubtQuery The current query, for fluid interface
     */
    public function filterByPerson($person, $comparison = null)
    {
        if ($person instanceof \BossEdu\Model\Person) {
            return $this
                ->addUsingAlias(DoubtTableMap::COL_PERSON_ID, $person->getId(), $comparison);
        } elseif ($person instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DoubtTableMap::COL_PERSON_ID, $person->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildDoubtQuery The current query, for fluid interface
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
     * Filter the query by a related \BossEdu\Model\PdLike object
     *
     * @param \BossEdu\Model\PdLike|ObjectCollection $pdLike the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDoubtQuery The current query, for fluid interface
     */
    public function filterByPdLike($pdLike, $comparison = null)
    {
        if ($pdLike instanceof \BossEdu\Model\PdLike) {
            return $this
                ->addUsingAlias(DoubtTableMap::COL_ID, $pdLike->getDoubtId(), $comparison);
        } elseif ($pdLike instanceof ObjectCollection) {
            return $this
                ->usePdLikeQuery()
                ->filterByPrimaryKeys($pdLike->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPdLike() only accepts arguments of type \BossEdu\Model\PdLike or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PdLike relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDoubtQuery The current query, for fluid interface
     */
    public function joinPdLike($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PdLike');

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
            $this->addJoinObject($join, 'PdLike');
        }

        return $this;
    }

    /**
     * Use the PdLike relation PdLike object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BossEdu\Model\PdLikeQuery A secondary query class using the current class as primary query
     */
    public function usePdLikeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPdLike($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PdLike', '\BossEdu\Model\PdLikeQuery');
    }

    /**
     * Filter the query by a related \BossEdu\Model\Contribution object
     *
     * @param \BossEdu\Model\Contribution|ObjectCollection $contribution the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDoubtQuery The current query, for fluid interface
     */
    public function filterByContribution($contribution, $comparison = null)
    {
        if ($contribution instanceof \BossEdu\Model\Contribution) {
            return $this
                ->addUsingAlias(DoubtTableMap::COL_ID, $contribution->getDoubtId(), $comparison);
        } elseif ($contribution instanceof ObjectCollection) {
            return $this
                ->useContributionQuery()
                ->filterByPrimaryKeys($contribution->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByContribution() only accepts arguments of type \BossEdu\Model\Contribution or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Contribution relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDoubtQuery The current query, for fluid interface
     */
    public function joinContribution($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Contribution');

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
            $this->addJoinObject($join, 'Contribution');
        }

        return $this;
    }

    /**
     * Use the Contribution relation Contribution object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BossEdu\Model\ContributionQuery A secondary query class using the current class as primary query
     */
    public function useContributionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinContribution($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Contribution', '\BossEdu\Model\ContributionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDoubt $doubt Object to remove from the list of results
     *
     * @return $this|ChildDoubtQuery The current query, for fluid interface
     */
    public function prune($doubt = null)
    {
        if ($doubt) {
            $this->addUsingAlias(DoubtTableMap::COL_ID, $doubt->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the doubt table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DoubtTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DoubtTableMap::clearInstancePool();
            DoubtTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DoubtTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DoubtTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            DoubtTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            DoubtTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DoubtQuery
