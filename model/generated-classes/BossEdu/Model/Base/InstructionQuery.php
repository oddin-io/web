<?php

namespace BossEdu\Model\Base;

use \Exception;
use \PDO;
use BossEdu\Model\Instruction as ChildInstruction;
use BossEdu\Model\InstructionQuery as ChildInstructionQuery;
use BossEdu\Model\Map\InstructionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'instruction' table.
 *
 * 
 *
 * @method     ChildInstructionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildInstructionQuery orderByClass($order = Criteria::ASC) Order by the class column
 * @method     ChildInstructionQuery orderByStartDate($order = Criteria::ASC) Order by the start_date column
 * @method     ChildInstructionQuery orderByEndDate($order = Criteria::ASC) Order by the end_date column
 * @method     ChildInstructionQuery orderByEventCode($order = Criteria::ASC) Order by the event_code column
 * @method     ChildInstructionQuery orderByLectureCode($order = Criteria::ASC) Order by the lecture_code column
 *
 * @method     ChildInstructionQuery groupById() Group by the id column
 * @method     ChildInstructionQuery groupByClass() Group by the class column
 * @method     ChildInstructionQuery groupByStartDate() Group by the start_date column
 * @method     ChildInstructionQuery groupByEndDate() Group by the end_date column
 * @method     ChildInstructionQuery groupByEventCode() Group by the event_code column
 * @method     ChildInstructionQuery groupByLectureCode() Group by the lecture_code column
 *
 * @method     ChildInstructionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildInstructionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildInstructionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildInstructionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildInstructionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildInstructionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildInstructionQuery leftJoinElHave($relationAlias = null) Adds a LEFT JOIN clause to the query using the ElHave relation
 * @method     ChildInstructionQuery rightJoinElHave($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ElHave relation
 * @method     ChildInstructionQuery innerJoinElHave($relationAlias = null) Adds a INNER JOIN clause to the query using the ElHave relation
 *
 * @method     ChildInstructionQuery joinWithElHave($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ElHave relation
 *
 * @method     ChildInstructionQuery leftJoinWithElHave() Adds a LEFT JOIN clause and with to the query using the ElHave relation
 * @method     ChildInstructionQuery rightJoinWithElHave() Adds a RIGHT JOIN clause and with to the query using the ElHave relation
 * @method     ChildInstructionQuery innerJoinWithElHave() Adds a INNER JOIN clause and with to the query using the ElHave relation
 *
 * @method     ChildInstructionQuery leftJoinPerson($relationAlias = null) Adds a LEFT JOIN clause to the query using the Person relation
 * @method     ChildInstructionQuery rightJoinPerson($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Person relation
 * @method     ChildInstructionQuery innerJoinPerson($relationAlias = null) Adds a INNER JOIN clause to the query using the Person relation
 *
 * @method     ChildInstructionQuery joinWithPerson($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Person relation
 *
 * @method     ChildInstructionQuery leftJoinWithPerson() Adds a LEFT JOIN clause and with to the query using the Person relation
 * @method     ChildInstructionQuery rightJoinWithPerson() Adds a RIGHT JOIN clause and with to the query using the Person relation
 * @method     ChildInstructionQuery innerJoinWithPerson() Adds a INNER JOIN clause and with to the query using the Person relation
 *
 * @method     ChildInstructionQuery leftJoinPiLink($relationAlias = null) Adds a LEFT JOIN clause to the query using the PiLink relation
 * @method     ChildInstructionQuery rightJoinPiLink($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PiLink relation
 * @method     ChildInstructionQuery innerJoinPiLink($relationAlias = null) Adds a INNER JOIN clause to the query using the PiLink relation
 *
 * @method     ChildInstructionQuery joinWithPiLink($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PiLink relation
 *
 * @method     ChildInstructionQuery leftJoinWithPiLink() Adds a LEFT JOIN clause and with to the query using the PiLink relation
 * @method     ChildInstructionQuery rightJoinWithPiLink() Adds a RIGHT JOIN clause and with to the query using the PiLink relation
 * @method     ChildInstructionQuery innerJoinWithPiLink() Adds a INNER JOIN clause and with to the query using the PiLink relation
 *
 * @method     ChildInstructionQuery leftJoinIsrLink($relationAlias = null) Adds a LEFT JOIN clause to the query using the IsrLink relation
 * @method     ChildInstructionQuery rightJoinIsrLink($relationAlias = null) Adds a RIGHT JOIN clause to the query using the IsrLink relation
 * @method     ChildInstructionQuery innerJoinIsrLink($relationAlias = null) Adds a INNER JOIN clause to the query using the IsrLink relation
 *
 * @method     ChildInstructionQuery joinWithIsrLink($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the IsrLink relation
 *
 * @method     ChildInstructionQuery leftJoinWithIsrLink() Adds a LEFT JOIN clause and with to the query using the IsrLink relation
 * @method     ChildInstructionQuery rightJoinWithIsrLink() Adds a RIGHT JOIN clause and with to the query using the IsrLink relation
 * @method     ChildInstructionQuery innerJoinWithIsrLink() Adds a INNER JOIN clause and with to the query using the IsrLink relation
 *
 * @method     ChildInstructionQuery leftJoinMiMaterial($relationAlias = null) Adds a LEFT JOIN clause to the query using the MiMaterial relation
 * @method     ChildInstructionQuery rightJoinMiMaterial($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MiMaterial relation
 * @method     ChildInstructionQuery innerJoinMiMaterial($relationAlias = null) Adds a INNER JOIN clause to the query using the MiMaterial relation
 *
 * @method     ChildInstructionQuery joinWithMiMaterial($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the MiMaterial relation
 *
 * @method     ChildInstructionQuery leftJoinWithMiMaterial() Adds a LEFT JOIN clause and with to the query using the MiMaterial relation
 * @method     ChildInstructionQuery rightJoinWithMiMaterial() Adds a RIGHT JOIN clause and with to the query using the MiMaterial relation
 * @method     ChildInstructionQuery innerJoinWithMiMaterial() Adds a INNER JOIN clause and with to the query using the MiMaterial relation
 *
 * @method     ChildInstructionQuery leftJoinPresentation($relationAlias = null) Adds a LEFT JOIN clause to the query using the Presentation relation
 * @method     ChildInstructionQuery rightJoinPresentation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Presentation relation
 * @method     ChildInstructionQuery innerJoinPresentation($relationAlias = null) Adds a INNER JOIN clause to the query using the Presentation relation
 *
 * @method     ChildInstructionQuery joinWithPresentation($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Presentation relation
 *
 * @method     ChildInstructionQuery leftJoinWithPresentation() Adds a LEFT JOIN clause and with to the query using the Presentation relation
 * @method     ChildInstructionQuery rightJoinWithPresentation() Adds a RIGHT JOIN clause and with to the query using the Presentation relation
 * @method     ChildInstructionQuery innerJoinWithPresentation() Adds a INNER JOIN clause and with to the query using the Presentation relation
 *
 * @method     \BossEdu\Model\ElHaveQuery|\BossEdu\Model\PersonQuery|\BossEdu\Model\PiLinkQuery|\BossEdu\Model\IsrLinkQuery|\BossEdu\Model\MiMaterialQuery|\BossEdu\Model\PresentationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildInstruction findOne(ConnectionInterface $con = null) Return the first ChildInstruction matching the query
 * @method     ChildInstruction findOneOrCreate(ConnectionInterface $con = null) Return the first ChildInstruction matching the query, or a new ChildInstruction object populated from the query conditions when no match is found
 *
 * @method     ChildInstruction findOneById(int $id) Return the first ChildInstruction filtered by the id column
 * @method     ChildInstruction findOneByClass(int $class) Return the first ChildInstruction filtered by the class column
 * @method     ChildInstruction findOneByStartDate(string $start_date) Return the first ChildInstruction filtered by the start_date column
 * @method     ChildInstruction findOneByEndDate(string $end_date) Return the first ChildInstruction filtered by the end_date column
 * @method     ChildInstruction findOneByEventCode(string $event_code) Return the first ChildInstruction filtered by the event_code column
 * @method     ChildInstruction findOneByLectureCode(string $lecture_code) Return the first ChildInstruction filtered by the lecture_code column *

 * @method     ChildInstruction requirePk($key, ConnectionInterface $con = null) Return the ChildInstruction by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInstruction requireOne(ConnectionInterface $con = null) Return the first ChildInstruction matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInstruction requireOneById(int $id) Return the first ChildInstruction filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInstruction requireOneByClass(int $class) Return the first ChildInstruction filtered by the class column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInstruction requireOneByStartDate(string $start_date) Return the first ChildInstruction filtered by the start_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInstruction requireOneByEndDate(string $end_date) Return the first ChildInstruction filtered by the end_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInstruction requireOneByEventCode(string $event_code) Return the first ChildInstruction filtered by the event_code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInstruction requireOneByLectureCode(string $lecture_code) Return the first ChildInstruction filtered by the lecture_code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInstruction[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildInstruction objects based on current ModelCriteria
 * @method     ChildInstruction[]|ObjectCollection findById(int $id) Return ChildInstruction objects filtered by the id column
 * @method     ChildInstruction[]|ObjectCollection findByClass(int $class) Return ChildInstruction objects filtered by the class column
 * @method     ChildInstruction[]|ObjectCollection findByStartDate(string $start_date) Return ChildInstruction objects filtered by the start_date column
 * @method     ChildInstruction[]|ObjectCollection findByEndDate(string $end_date) Return ChildInstruction objects filtered by the end_date column
 * @method     ChildInstruction[]|ObjectCollection findByEventCode(string $event_code) Return ChildInstruction objects filtered by the event_code column
 * @method     ChildInstruction[]|ObjectCollection findByLectureCode(string $lecture_code) Return ChildInstruction objects filtered by the lecture_code column
 * @method     ChildInstruction[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class InstructionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \BossEdu\Model\Base\InstructionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\BossEdu\\Model\\Instruction', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildInstructionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildInstructionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildInstructionQuery) {
            return $criteria;
        }
        $query = new ChildInstructionQuery();
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
     * @return ChildInstruction|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = InstructionTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(InstructionTableMap::DATABASE_NAME);
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
     * @return ChildInstruction A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, class, start_date, end_date, event_code, lecture_code FROM instruction WHERE id = :p0';
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
            /** @var ChildInstruction $obj */
            $obj = new ChildInstruction();
            $obj->hydrate($row);
            InstructionTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildInstruction|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildInstructionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(InstructionTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildInstructionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(InstructionTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildInstructionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(InstructionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(InstructionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InstructionTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the class column
     *
     * Example usage:
     * <code>
     * $query->filterByClass(1234); // WHERE class = 1234
     * $query->filterByClass(array(12, 34)); // WHERE class IN (12, 34)
     * $query->filterByClass(array('min' => 12)); // WHERE class > 12
     * </code>
     *
     * @param     mixed $class The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInstructionQuery The current query, for fluid interface
     */
    public function filterByClass($class = null, $comparison = null)
    {
        if (is_array($class)) {
            $useMinMax = false;
            if (isset($class['min'])) {
                $this->addUsingAlias(InstructionTableMap::COL_CLASS, $class['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($class['max'])) {
                $this->addUsingAlias(InstructionTableMap::COL_CLASS, $class['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InstructionTableMap::COL_CLASS, $class, $comparison);
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
     * @return $this|ChildInstructionQuery The current query, for fluid interface
     */
    public function filterByStartDate($startDate = null, $comparison = null)
    {
        if (is_array($startDate)) {
            $useMinMax = false;
            if (isset($startDate['min'])) {
                $this->addUsingAlias(InstructionTableMap::COL_START_DATE, $startDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($startDate['max'])) {
                $this->addUsingAlias(InstructionTableMap::COL_START_DATE, $startDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InstructionTableMap::COL_START_DATE, $startDate, $comparison);
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
     * @return $this|ChildInstructionQuery The current query, for fluid interface
     */
    public function filterByEndDate($endDate = null, $comparison = null)
    {
        if (is_array($endDate)) {
            $useMinMax = false;
            if (isset($endDate['min'])) {
                $this->addUsingAlias(InstructionTableMap::COL_END_DATE, $endDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($endDate['max'])) {
                $this->addUsingAlias(InstructionTableMap::COL_END_DATE, $endDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InstructionTableMap::COL_END_DATE, $endDate, $comparison);
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
     * @return $this|ChildInstructionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(InstructionTableMap::COL_EVENT_CODE, $eventCode, $comparison);
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
     * @return $this|ChildInstructionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(InstructionTableMap::COL_LECTURE_CODE, $lectureCode, $comparison);
    }

    /**
     * Filter the query by a related \BossEdu\Model\ElHave object
     *
     * @param \BossEdu\Model\ElHave $elHave The related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInstructionQuery The current query, for fluid interface
     */
    public function filterByElHave($elHave, $comparison = null)
    {
        if ($elHave instanceof \BossEdu\Model\ElHave) {
            return $this
                ->addUsingAlias(InstructionTableMap::COL_EVENT_CODE, $elHave->getEventCode(), $comparison)
                ->addUsingAlias(InstructionTableMap::COL_LECTURE_CODE, $elHave->getLectureCode(), $comparison);
        } else {
            throw new PropelException('filterByElHave() only accepts arguments of type \BossEdu\Model\ElHave');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ElHave relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInstructionQuery The current query, for fluid interface
     */
    public function joinElHave($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ElHave');

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
            $this->addJoinObject($join, 'ElHave');
        }

        return $this;
    }

    /**
     * Use the ElHave relation ElHave object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BossEdu\Model\ElHaveQuery A secondary query class using the current class as primary query
     */
    public function useElHaveQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinElHave($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ElHave', '\BossEdu\Model\ElHaveQuery');
    }

    /**
     * Filter the query by a related \BossEdu\Model\Person object
     *
     * @param \BossEdu\Model\Person|ObjectCollection $person the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildInstructionQuery The current query, for fluid interface
     */
    public function filterByPerson($person, $comparison = null)
    {
        if ($person instanceof \BossEdu\Model\Person) {
            return $this
                ->addUsingAlias(InstructionTableMap::COL_ID, $person->getCurrentInstruction(), $comparison);
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
     * @return $this|ChildInstructionQuery The current query, for fluid interface
     */
    public function joinPerson($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function usePersonQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPerson($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Person', '\BossEdu\Model\PersonQuery');
    }

    /**
     * Filter the query by a related \BossEdu\Model\PiLink object
     *
     * @param \BossEdu\Model\PiLink|ObjectCollection $piLink the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildInstructionQuery The current query, for fluid interface
     */
    public function filterByPiLink($piLink, $comparison = null)
    {
        if ($piLink instanceof \BossEdu\Model\PiLink) {
            return $this
                ->addUsingAlias(InstructionTableMap::COL_ID, $piLink->getInstructionId(), $comparison);
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
     * @return $this|ChildInstructionQuery The current query, for fluid interface
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
     * Filter the query by a related \BossEdu\Model\IsrLink object
     *
     * @param \BossEdu\Model\IsrLink|ObjectCollection $isrLink the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildInstructionQuery The current query, for fluid interface
     */
    public function filterByIsrLink($isrLink, $comparison = null)
    {
        if ($isrLink instanceof \BossEdu\Model\IsrLink) {
            return $this
                ->addUsingAlias(InstructionTableMap::COL_ID, $isrLink->getInstructionId(), $comparison);
        } elseif ($isrLink instanceof ObjectCollection) {
            return $this
                ->useIsrLinkQuery()
                ->filterByPrimaryKeys($isrLink->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByIsrLink() only accepts arguments of type \BossEdu\Model\IsrLink or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the IsrLink relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInstructionQuery The current query, for fluid interface
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
     * Filter the query by a related \BossEdu\Model\MiMaterial object
     *
     * @param \BossEdu\Model\MiMaterial|ObjectCollection $miMaterial the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildInstructionQuery The current query, for fluid interface
     */
    public function filterByMiMaterial($miMaterial, $comparison = null)
    {
        if ($miMaterial instanceof \BossEdu\Model\MiMaterial) {
            return $this
                ->addUsingAlias(InstructionTableMap::COL_ID, $miMaterial->getInstructionId(), $comparison);
        } elseif ($miMaterial instanceof ObjectCollection) {
            return $this
                ->useMiMaterialQuery()
                ->filterByPrimaryKeys($miMaterial->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMiMaterial() only accepts arguments of type \BossEdu\Model\MiMaterial or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MiMaterial relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInstructionQuery The current query, for fluid interface
     */
    public function joinMiMaterial($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MiMaterial');

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
            $this->addJoinObject($join, 'MiMaterial');
        }

        return $this;
    }

    /**
     * Use the MiMaterial relation MiMaterial object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BossEdu\Model\MiMaterialQuery A secondary query class using the current class as primary query
     */
    public function useMiMaterialQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMiMaterial($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MiMaterial', '\BossEdu\Model\MiMaterialQuery');
    }

    /**
     * Filter the query by a related \BossEdu\Model\Presentation object
     *
     * @param \BossEdu\Model\Presentation|ObjectCollection $presentation the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildInstructionQuery The current query, for fluid interface
     */
    public function filterByPresentation($presentation, $comparison = null)
    {
        if ($presentation instanceof \BossEdu\Model\Presentation) {
            return $this
                ->addUsingAlias(InstructionTableMap::COL_ID, $presentation->getInstructionId(), $comparison);
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
     * @return $this|ChildInstructionQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildInstruction $instruction Object to remove from the list of results
     *
     * @return $this|ChildInstructionQuery The current query, for fluid interface
     */
    public function prune($instruction = null)
    {
        if ($instruction) {
            $this->addUsingAlias(InstructionTableMap::COL_ID, $instruction->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the instruction table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InstructionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            InstructionTableMap::clearInstancePool();
            InstructionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(InstructionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(InstructionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            InstructionTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            InstructionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // InstructionQuery
