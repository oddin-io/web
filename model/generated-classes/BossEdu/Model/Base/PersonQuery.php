<?php

namespace BossEdu\Model\Base;

use \Exception;
use \PDO;
use BossEdu\Model\Person as ChildPerson;
use BossEdu\Model\PersonQuery as ChildPersonQuery;
use BossEdu\Model\Map\PersonTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'person' table.
 *
 * 
 *
 * @method     ChildPersonQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPersonQuery orderByDocumentName($order = Criteria::ASC) Order by the document_name column
 * @method     ChildPersonQuery orderByDocumentNumber($order = Criteria::ASC) Order by the document_number column
 * @method     ChildPersonQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildPersonQuery orderByBirthDate($order = Criteria::ASC) Order by the birth_date column
 * @method     ChildPersonQuery orderByTelephone($order = Criteria::ASC) Order by the telephone column
 * @method     ChildPersonQuery orderByCountry($order = Criteria::ASC) Order by the country column
 * @method     ChildPersonQuery orderByState($order = Criteria::ASC) Order by the state column
 * @method     ChildPersonQuery orderByTown($order = Criteria::ASC) Order by the town column
 * @method     ChildPersonQuery orderByDistrict($order = Criteria::ASC) Order by the district column
 * @method     ChildPersonQuery orderByStreet($order = Criteria::ASC) Order by the street column
 * @method     ChildPersonQuery orderByNumber($order = Criteria::ASC) Order by the number column
 * @method     ChildPersonQuery orderByEmail($order = Criteria::ASC) Order by the email column
 *
 * @method     ChildPersonQuery groupById() Group by the id column
 * @method     ChildPersonQuery groupByDocumentName() Group by the document_name column
 * @method     ChildPersonQuery groupByDocumentNumber() Group by the document_number column
 * @method     ChildPersonQuery groupByName() Group by the name column
 * @method     ChildPersonQuery groupByBirthDate() Group by the birth_date column
 * @method     ChildPersonQuery groupByTelephone() Group by the telephone column
 * @method     ChildPersonQuery groupByCountry() Group by the country column
 * @method     ChildPersonQuery groupByState() Group by the state column
 * @method     ChildPersonQuery groupByTown() Group by the town column
 * @method     ChildPersonQuery groupByDistrict() Group by the district column
 * @method     ChildPersonQuery groupByStreet() Group by the street column
 * @method     ChildPersonQuery groupByNumber() Group by the number column
 * @method     ChildPersonQuery groupByEmail() Group by the email column
 *
 * @method     ChildPersonQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPersonQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPersonQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPersonQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPersonQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPersonQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPersonQuery leftJoinSomeone($relationAlias = null) Adds a LEFT JOIN clause to the query using the Someone relation
 * @method     ChildPersonQuery rightJoinSomeone($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Someone relation
 * @method     ChildPersonQuery innerJoinSomeone($relationAlias = null) Adds a INNER JOIN clause to the query using the Someone relation
 *
 * @method     ChildPersonQuery joinWithSomeone($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Someone relation
 *
 * @method     ChildPersonQuery leftJoinWithSomeone() Adds a LEFT JOIN clause and with to the query using the Someone relation
 * @method     ChildPersonQuery rightJoinWithSomeone() Adds a RIGHT JOIN clause and with to the query using the Someone relation
 * @method     ChildPersonQuery innerJoinWithSomeone() Adds a INNER JOIN clause and with to the query using the Someone relation
 *
 * @method     ChildPersonQuery leftJoinPiLink($relationAlias = null) Adds a LEFT JOIN clause to the query using the PiLink relation
 * @method     ChildPersonQuery rightJoinPiLink($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PiLink relation
 * @method     ChildPersonQuery innerJoinPiLink($relationAlias = null) Adds a INNER JOIN clause to the query using the PiLink relation
 *
 * @method     ChildPersonQuery joinWithPiLink($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PiLink relation
 *
 * @method     ChildPersonQuery leftJoinWithPiLink() Adds a LEFT JOIN clause and with to the query using the PiLink relation
 * @method     ChildPersonQuery rightJoinWithPiLink() Adds a RIGHT JOIN clause and with to the query using the PiLink relation
 * @method     ChildPersonQuery innerJoinWithPiLink() Adds a INNER JOIN clause and with to the query using the PiLink relation
 *
 * @method     ChildPersonQuery leftJoinPresentation($relationAlias = null) Adds a LEFT JOIN clause to the query using the Presentation relation
 * @method     ChildPersonQuery rightJoinPresentation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Presentation relation
 * @method     ChildPersonQuery innerJoinPresentation($relationAlias = null) Adds a INNER JOIN clause to the query using the Presentation relation
 *
 * @method     ChildPersonQuery joinWithPresentation($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Presentation relation
 *
 * @method     ChildPersonQuery leftJoinWithPresentation() Adds a LEFT JOIN clause and with to the query using the Presentation relation
 * @method     ChildPersonQuery rightJoinWithPresentation() Adds a RIGHT JOIN clause and with to the query using the Presentation relation
 * @method     ChildPersonQuery innerJoinWithPresentation() Adds a INNER JOIN clause and with to the query using the Presentation relation
 *
 * @method     ChildPersonQuery leftJoinDoubt($relationAlias = null) Adds a LEFT JOIN clause to the query using the Doubt relation
 * @method     ChildPersonQuery rightJoinDoubt($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Doubt relation
 * @method     ChildPersonQuery innerJoinDoubt($relationAlias = null) Adds a INNER JOIN clause to the query using the Doubt relation
 *
 * @method     ChildPersonQuery joinWithDoubt($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Doubt relation
 *
 * @method     ChildPersonQuery leftJoinWithDoubt() Adds a LEFT JOIN clause and with to the query using the Doubt relation
 * @method     ChildPersonQuery rightJoinWithDoubt() Adds a RIGHT JOIN clause and with to the query using the Doubt relation
 * @method     ChildPersonQuery innerJoinWithDoubt() Adds a INNER JOIN clause and with to the query using the Doubt relation
 *
 * @method     ChildPersonQuery leftJoinPdLike($relationAlias = null) Adds a LEFT JOIN clause to the query using the PdLike relation
 * @method     ChildPersonQuery rightJoinPdLike($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PdLike relation
 * @method     ChildPersonQuery innerJoinPdLike($relationAlias = null) Adds a INNER JOIN clause to the query using the PdLike relation
 *
 * @method     ChildPersonQuery joinWithPdLike($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PdLike relation
 *
 * @method     ChildPersonQuery leftJoinWithPdLike() Adds a LEFT JOIN clause and with to the query using the PdLike relation
 * @method     ChildPersonQuery rightJoinWithPdLike() Adds a RIGHT JOIN clause and with to the query using the PdLike relation
 * @method     ChildPersonQuery innerJoinWithPdLike() Adds a INNER JOIN clause and with to the query using the PdLike relation
 *
 * @method     ChildPersonQuery leftJoinContribution($relationAlias = null) Adds a LEFT JOIN clause to the query using the Contribution relation
 * @method     ChildPersonQuery rightJoinContribution($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Contribution relation
 * @method     ChildPersonQuery innerJoinContribution($relationAlias = null) Adds a INNER JOIN clause to the query using the Contribution relation
 *
 * @method     ChildPersonQuery joinWithContribution($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Contribution relation
 *
 * @method     ChildPersonQuery leftJoinWithContribution() Adds a LEFT JOIN clause and with to the query using the Contribution relation
 * @method     ChildPersonQuery rightJoinWithContribution() Adds a RIGHT JOIN clause and with to the query using the Contribution relation
 * @method     ChildPersonQuery innerJoinWithContribution() Adds a INNER JOIN clause and with to the query using the Contribution relation
 *
 * @method     \BossEdu\Model\SomeoneQuery|\BossEdu\Model\PiLinkQuery|\BossEdu\Model\PresentationQuery|\BossEdu\Model\DoubtQuery|\BossEdu\Model\PdLikeQuery|\BossEdu\Model\ContributionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPerson findOne(ConnectionInterface $con = null) Return the first ChildPerson matching the query
 * @method     ChildPerson findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPerson matching the query, or a new ChildPerson object populated from the query conditions when no match is found
 *
 * @method     ChildPerson findOneById(int $id) Return the first ChildPerson filtered by the id column
 * @method     ChildPerson findOneByDocumentName(string $document_name) Return the first ChildPerson filtered by the document_name column
 * @method     ChildPerson findOneByDocumentNumber(string $document_number) Return the first ChildPerson filtered by the document_number column
 * @method     ChildPerson findOneByName(string $name) Return the first ChildPerson filtered by the name column
 * @method     ChildPerson findOneByBirthDate(string $birth_date) Return the first ChildPerson filtered by the birth_date column
 * @method     ChildPerson findOneByTelephone(string $telephone) Return the first ChildPerson filtered by the telephone column
 * @method     ChildPerson findOneByCountry(string $country) Return the first ChildPerson filtered by the country column
 * @method     ChildPerson findOneByState(string $state) Return the first ChildPerson filtered by the state column
 * @method     ChildPerson findOneByTown(string $town) Return the first ChildPerson filtered by the town column
 * @method     ChildPerson findOneByDistrict(string $district) Return the first ChildPerson filtered by the district column
 * @method     ChildPerson findOneByStreet(string $street) Return the first ChildPerson filtered by the street column
 * @method     ChildPerson findOneByNumber(string $number) Return the first ChildPerson filtered by the number column
 * @method     ChildPerson findOneByEmail(string $email) Return the first ChildPerson filtered by the email column *

 * @method     ChildPerson requirePk($key, ConnectionInterface $con = null) Return the ChildPerson by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerson requireOne(ConnectionInterface $con = null) Return the first ChildPerson matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPerson requireOneById(int $id) Return the first ChildPerson filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerson requireOneByDocumentName(string $document_name) Return the first ChildPerson filtered by the document_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerson requireOneByDocumentNumber(string $document_number) Return the first ChildPerson filtered by the document_number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerson requireOneByName(string $name) Return the first ChildPerson filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerson requireOneByBirthDate(string $birth_date) Return the first ChildPerson filtered by the birth_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerson requireOneByTelephone(string $telephone) Return the first ChildPerson filtered by the telephone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerson requireOneByCountry(string $country) Return the first ChildPerson filtered by the country column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerson requireOneByState(string $state) Return the first ChildPerson filtered by the state column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerson requireOneByTown(string $town) Return the first ChildPerson filtered by the town column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerson requireOneByDistrict(string $district) Return the first ChildPerson filtered by the district column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerson requireOneByStreet(string $street) Return the first ChildPerson filtered by the street column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerson requireOneByNumber(string $number) Return the first ChildPerson filtered by the number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerson requireOneByEmail(string $email) Return the first ChildPerson filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPerson[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPerson objects based on current ModelCriteria
 * @method     ChildPerson[]|ObjectCollection findById(int $id) Return ChildPerson objects filtered by the id column
 * @method     ChildPerson[]|ObjectCollection findByDocumentName(string $document_name) Return ChildPerson objects filtered by the document_name column
 * @method     ChildPerson[]|ObjectCollection findByDocumentNumber(string $document_number) Return ChildPerson objects filtered by the document_number column
 * @method     ChildPerson[]|ObjectCollection findByName(string $name) Return ChildPerson objects filtered by the name column
 * @method     ChildPerson[]|ObjectCollection findByBirthDate(string $birth_date) Return ChildPerson objects filtered by the birth_date column
 * @method     ChildPerson[]|ObjectCollection findByTelephone(string $telephone) Return ChildPerson objects filtered by the telephone column
 * @method     ChildPerson[]|ObjectCollection findByCountry(string $country) Return ChildPerson objects filtered by the country column
 * @method     ChildPerson[]|ObjectCollection findByState(string $state) Return ChildPerson objects filtered by the state column
 * @method     ChildPerson[]|ObjectCollection findByTown(string $town) Return ChildPerson objects filtered by the town column
 * @method     ChildPerson[]|ObjectCollection findByDistrict(string $district) Return ChildPerson objects filtered by the district column
 * @method     ChildPerson[]|ObjectCollection findByStreet(string $street) Return ChildPerson objects filtered by the street column
 * @method     ChildPerson[]|ObjectCollection findByNumber(string $number) Return ChildPerson objects filtered by the number column
 * @method     ChildPerson[]|ObjectCollection findByEmail(string $email) Return ChildPerson objects filtered by the email column
 * @method     ChildPerson[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PersonQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \BossEdu\Model\Base\PersonQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\BossEdu\\Model\\Person', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPersonQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPersonQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPersonQuery) {
            return $criteria;
        }
        $query = new ChildPersonQuery();
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
     * @return ChildPerson|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PersonTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PersonTableMap::DATABASE_NAME);
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
     * @return ChildPerson A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, document_name, document_number, name, birth_date, telephone, country, state, town, district, street, number, email FROM person WHERE id = :p0';
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
            /** @var ChildPerson $obj */
            $obj = new ChildPerson();
            $obj->hydrate($row);
            PersonTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPerson|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PersonTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PersonTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PersonTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PersonTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersonTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the document_name column
     *
     * Example usage:
     * <code>
     * $query->filterByDocumentName('fooValue');   // WHERE document_name = 'fooValue'
     * $query->filterByDocumentName('%fooValue%'); // WHERE document_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $documentName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function filterByDocumentName($documentName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($documentName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $documentName)) {
                $documentName = str_replace('*', '%', $documentName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PersonTableMap::COL_DOCUMENT_NAME, $documentName, $comparison);
    }

    /**
     * Filter the query on the document_number column
     *
     * Example usage:
     * <code>
     * $query->filterByDocumentNumber('fooValue');   // WHERE document_number = 'fooValue'
     * $query->filterByDocumentNumber('%fooValue%'); // WHERE document_number LIKE '%fooValue%'
     * </code>
     *
     * @param     string $documentNumber The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function filterByDocumentNumber($documentNumber = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($documentNumber)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $documentNumber)) {
                $documentNumber = str_replace('*', '%', $documentNumber);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PersonTableMap::COL_DOCUMENT_NUMBER, $documentNumber, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PersonTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the birth_date column
     *
     * Example usage:
     * <code>
     * $query->filterByBirthDate('2011-03-14'); // WHERE birth_date = '2011-03-14'
     * $query->filterByBirthDate('now'); // WHERE birth_date = '2011-03-14'
     * $query->filterByBirthDate(array('max' => 'yesterday')); // WHERE birth_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $birthDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function filterByBirthDate($birthDate = null, $comparison = null)
    {
        if (is_array($birthDate)) {
            $useMinMax = false;
            if (isset($birthDate['min'])) {
                $this->addUsingAlias(PersonTableMap::COL_BIRTH_DATE, $birthDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($birthDate['max'])) {
                $this->addUsingAlias(PersonTableMap::COL_BIRTH_DATE, $birthDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersonTableMap::COL_BIRTH_DATE, $birthDate, $comparison);
    }

    /**
     * Filter the query on the telephone column
     *
     * Example usage:
     * <code>
     * $query->filterByTelephone('fooValue');   // WHERE telephone = 'fooValue'
     * $query->filterByTelephone('%fooValue%'); // WHERE telephone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $telephone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function filterByTelephone($telephone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($telephone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $telephone)) {
                $telephone = str_replace('*', '%', $telephone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PersonTableMap::COL_TELEPHONE, $telephone, $comparison);
    }

    /**
     * Filter the query on the country column
     *
     * Example usage:
     * <code>
     * $query->filterByCountry('fooValue');   // WHERE country = 'fooValue'
     * $query->filterByCountry('%fooValue%'); // WHERE country LIKE '%fooValue%'
     * </code>
     *
     * @param     string $country The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function filterByCountry($country = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($country)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $country)) {
                $country = str_replace('*', '%', $country);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PersonTableMap::COL_COUNTRY, $country, $comparison);
    }

    /**
     * Filter the query on the state column
     *
     * Example usage:
     * <code>
     * $query->filterByState('fooValue');   // WHERE state = 'fooValue'
     * $query->filterByState('%fooValue%'); // WHERE state LIKE '%fooValue%'
     * </code>
     *
     * @param     string $state The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function filterByState($state = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($state)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $state)) {
                $state = str_replace('*', '%', $state);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PersonTableMap::COL_STATE, $state, $comparison);
    }

    /**
     * Filter the query on the town column
     *
     * Example usage:
     * <code>
     * $query->filterByTown('fooValue');   // WHERE town = 'fooValue'
     * $query->filterByTown('%fooValue%'); // WHERE town LIKE '%fooValue%'
     * </code>
     *
     * @param     string $town The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function filterByTown($town = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($town)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $town)) {
                $town = str_replace('*', '%', $town);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PersonTableMap::COL_TOWN, $town, $comparison);
    }

    /**
     * Filter the query on the district column
     *
     * Example usage:
     * <code>
     * $query->filterByDistrict('fooValue');   // WHERE district = 'fooValue'
     * $query->filterByDistrict('%fooValue%'); // WHERE district LIKE '%fooValue%'
     * </code>
     *
     * @param     string $district The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function filterByDistrict($district = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($district)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $district)) {
                $district = str_replace('*', '%', $district);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PersonTableMap::COL_DISTRICT, $district, $comparison);
    }

    /**
     * Filter the query on the street column
     *
     * Example usage:
     * <code>
     * $query->filterByStreet('fooValue');   // WHERE street = 'fooValue'
     * $query->filterByStreet('%fooValue%'); // WHERE street LIKE '%fooValue%'
     * </code>
     *
     * @param     string $street The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function filterByStreet($street = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($street)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $street)) {
                $street = str_replace('*', '%', $street);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PersonTableMap::COL_STREET, $street, $comparison);
    }

    /**
     * Filter the query on the number column
     *
     * Example usage:
     * <code>
     * $query->filterByNumber('fooValue');   // WHERE number = 'fooValue'
     * $query->filterByNumber('%fooValue%'); // WHERE number LIKE '%fooValue%'
     * </code>
     *
     * @param     string $number The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function filterByNumber($number = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($number)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $number)) {
                $number = str_replace('*', '%', $number);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PersonTableMap::COL_NUMBER, $number, $comparison);
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
     * @return $this|ChildPersonQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PersonTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query by a related \BossEdu\Model\Someone object
     *
     * @param \BossEdu\Model\Someone|ObjectCollection $someone The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPersonQuery The current query, for fluid interface
     */
    public function filterBySomeone($someone, $comparison = null)
    {
        if ($someone instanceof \BossEdu\Model\Someone) {
            return $this
                ->addUsingAlias(PersonTableMap::COL_EMAIL, $someone->getEmail(), $comparison);
        } elseif ($someone instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PersonTableMap::COL_EMAIL, $someone->toKeyValue('PrimaryKey', 'Email'), $comparison);
        } else {
            throw new PropelException('filterBySomeone() only accepts arguments of type \BossEdu\Model\Someone or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Someone relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function joinSomeone($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Someone');

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
            $this->addJoinObject($join, 'Someone');
        }

        return $this;
    }

    /**
     * Use the Someone relation Someone object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BossEdu\Model\SomeoneQuery A secondary query class using the current class as primary query
     */
    public function useSomeoneQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSomeone($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Someone', '\BossEdu\Model\SomeoneQuery');
    }

    /**
     * Filter the query by a related \BossEdu\Model\PiLink object
     *
     * @param \BossEdu\Model\PiLink|ObjectCollection $piLink the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPersonQuery The current query, for fluid interface
     */
    public function filterByPiLink($piLink, $comparison = null)
    {
        if ($piLink instanceof \BossEdu\Model\PiLink) {
            return $this
                ->addUsingAlias(PersonTableMap::COL_ID, $piLink->getPersonId(), $comparison);
        } elseif ($piLink instanceof ObjectCollection) {
            return $this
                ->usePiLinkQuery()
                ->filterByPrimaryKeys($piLink->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPiLink() only accepts arguments of type \BossEdu\Model\PiLink or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PiLink relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function joinPiLink($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PiLink');

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
            $this->addJoinObject($join, 'PiLink');
        }

        return $this;
    }

    /**
     * Use the PiLink relation PiLink object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BossEdu\Model\PiLinkQuery A secondary query class using the current class as primary query
     */
    public function usePiLinkQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPiLink($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PiLink', '\BossEdu\Model\PiLinkQuery');
    }

    /**
     * Filter the query by a related \BossEdu\Model\Presentation object
     *
     * @param \BossEdu\Model\Presentation|ObjectCollection $presentation the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPersonQuery The current query, for fluid interface
     */
    public function filterByPresentation($presentation, $comparison = null)
    {
        if ($presentation instanceof \BossEdu\Model\Presentation) {
            return $this
                ->addUsingAlias(PersonTableMap::COL_ID, $presentation->getPersonId(), $comparison);
        } elseif ($presentation instanceof ObjectCollection) {
            return $this
                ->usePresentationQuery()
                ->filterByPrimaryKeys($presentation->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildPersonQuery The current query, for fluid interface
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
     * Filter the query by a related \BossEdu\Model\Doubt object
     *
     * @param \BossEdu\Model\Doubt|ObjectCollection $doubt the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPersonQuery The current query, for fluid interface
     */
    public function filterByDoubt($doubt, $comparison = null)
    {
        if ($doubt instanceof \BossEdu\Model\Doubt) {
            return $this
                ->addUsingAlias(PersonTableMap::COL_ID, $doubt->getPersonId(), $comparison);
        } elseif ($doubt instanceof ObjectCollection) {
            return $this
                ->useDoubtQuery()
                ->filterByPrimaryKeys($doubt->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildPersonQuery The current query, for fluid interface
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
     * Filter the query by a related \BossEdu\Model\PdLike object
     *
     * @param \BossEdu\Model\PdLike|ObjectCollection $pdLike the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPersonQuery The current query, for fluid interface
     */
    public function filterByPdLike($pdLike, $comparison = null)
    {
        if ($pdLike instanceof \BossEdu\Model\PdLike) {
            return $this
                ->addUsingAlias(PersonTableMap::COL_ID, $pdLike->getPersonId(), $comparison);
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
     * @return $this|ChildPersonQuery The current query, for fluid interface
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
     * @return ChildPersonQuery The current query, for fluid interface
     */
    public function filterByContribution($contribution, $comparison = null)
    {
        if ($contribution instanceof \BossEdu\Model\Contribution) {
            return $this
                ->addUsingAlias(PersonTableMap::COL_ID, $contribution->getPersonId(), $comparison);
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
     * @return $this|ChildPersonQuery The current query, for fluid interface
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
     * @param   ChildPerson $person Object to remove from the list of results
     *
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function prune($person = null)
    {
        if ($person) {
            $this->addUsingAlias(PersonTableMap::COL_ID, $person->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the person table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PersonTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PersonTableMap::clearInstancePool();
            PersonTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PersonTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PersonTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            PersonTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            PersonTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PersonQuery
