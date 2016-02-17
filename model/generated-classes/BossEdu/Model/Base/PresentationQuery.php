<?php

namespace BossEdu\Model\Base;

use \Exception;
use \PDO;
use BossEdu\Model\Presentation as ChildPresentation;
use BossEdu\Model\PresentationQuery as ChildPresentationQuery;
use BossEdu\Model\Map\PresentationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'presentation' table.
 *
 * 
 *
 * @method     ChildPresentationQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPresentationQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildPresentationQuery orderBySubject($order = Criteria::ASC) Order by the subject column
 * @method     ChildPresentationQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildPresentationQuery orderByInstructionId($order = Criteria::ASC) Order by the instruction_id column
 * @method     ChildPresentationQuery orderByPersonId($order = Criteria::ASC) Order by the person_id column
 *
 * @method     ChildPresentationQuery groupById() Group by the id column
 * @method     ChildPresentationQuery groupByStatus() Group by the status column
 * @method     ChildPresentationQuery groupBySubject() Group by the subject column
 * @method     ChildPresentationQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildPresentationQuery groupByInstructionId() Group by the instruction_id column
 * @method     ChildPresentationQuery groupByPersonId() Group by the person_id column
 *
 * @method     ChildPresentationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPresentationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPresentationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPresentationQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPresentationQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPresentationQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPresentationQuery leftJoinInstruction($relationAlias = null) Adds a LEFT JOIN clause to the query using the Instruction relation
 * @method     ChildPresentationQuery rightJoinInstruction($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Instruction relation
 * @method     ChildPresentationQuery innerJoinInstruction($relationAlias = null) Adds a INNER JOIN clause to the query using the Instruction relation
 *
 * @method     ChildPresentationQuery joinWithInstruction($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Instruction relation
 *
 * @method     ChildPresentationQuery leftJoinWithInstruction() Adds a LEFT JOIN clause and with to the query using the Instruction relation
 * @method     ChildPresentationQuery rightJoinWithInstruction() Adds a RIGHT JOIN clause and with to the query using the Instruction relation
 * @method     ChildPresentationQuery innerJoinWithInstruction() Adds a INNER JOIN clause and with to the query using the Instruction relation
 *
 * @method     ChildPresentationQuery leftJoinPerson($relationAlias = null) Adds a LEFT JOIN clause to the query using the Person relation
 * @method     ChildPresentationQuery rightJoinPerson($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Person relation
 * @method     ChildPresentationQuery innerJoinPerson($relationAlias = null) Adds a INNER JOIN clause to the query using the Person relation
 *
 * @method     ChildPresentationQuery joinWithPerson($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Person relation
 *
 * @method     ChildPresentationQuery leftJoinWithPerson() Adds a LEFT JOIN clause and with to the query using the Person relation
 * @method     ChildPresentationQuery rightJoinWithPerson() Adds a RIGHT JOIN clause and with to the query using the Person relation
 * @method     ChildPresentationQuery innerJoinWithPerson() Adds a INNER JOIN clause and with to the query using the Person relation
 *
 * @method     ChildPresentationQuery leftJoinMpMaterial($relationAlias = null) Adds a LEFT JOIN clause to the query using the MpMaterial relation
 * @method     ChildPresentationQuery rightJoinMpMaterial($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MpMaterial relation
 * @method     ChildPresentationQuery innerJoinMpMaterial($relationAlias = null) Adds a INNER JOIN clause to the query using the MpMaterial relation
 *
 * @method     ChildPresentationQuery joinWithMpMaterial($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the MpMaterial relation
 *
 * @method     ChildPresentationQuery leftJoinWithMpMaterial() Adds a LEFT JOIN clause and with to the query using the MpMaterial relation
 * @method     ChildPresentationQuery rightJoinWithMpMaterial() Adds a RIGHT JOIN clause and with to the query using the MpMaterial relation
 * @method     ChildPresentationQuery innerJoinWithMpMaterial() Adds a INNER JOIN clause and with to the query using the MpMaterial relation
 *
 * @method     ChildPresentationQuery leftJoinDoubt($relationAlias = null) Adds a LEFT JOIN clause to the query using the Doubt relation
 * @method     ChildPresentationQuery rightJoinDoubt($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Doubt relation
 * @method     ChildPresentationQuery innerJoinDoubt($relationAlias = null) Adds a INNER JOIN clause to the query using the Doubt relation
 *
 * @method     ChildPresentationQuery joinWithDoubt($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Doubt relation
 *
 * @method     ChildPresentationQuery leftJoinWithDoubt() Adds a LEFT JOIN clause and with to the query using the Doubt relation
 * @method     ChildPresentationQuery rightJoinWithDoubt() Adds a RIGHT JOIN clause and with to the query using the Doubt relation
 * @method     ChildPresentationQuery innerJoinWithDoubt() Adds a INNER JOIN clause and with to the query using the Doubt relation
 *
 * @method     \BossEdu\Model\InstructionQuery|\BossEdu\Model\PersonQuery|\BossEdu\Model\MpMaterialQuery|\BossEdu\Model\DoubtQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPresentation findOne(ConnectionInterface $con = null) Return the first ChildPresentation matching the query
 * @method     ChildPresentation findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPresentation matching the query, or a new ChildPresentation object populated from the query conditions when no match is found
 *
 * @method     ChildPresentation findOneById(int $id) Return the first ChildPresentation filtered by the id column
 * @method     ChildPresentation findOneByStatus(int $status) Return the first ChildPresentation filtered by the status column
 * @method     ChildPresentation findOneBySubject(string $subject) Return the first ChildPresentation filtered by the subject column
 * @method     ChildPresentation findOneByCreatedAt(string $created_at) Return the first ChildPresentation filtered by the created_at column
 * @method     ChildPresentation findOneByInstructionId(int $instruction_id) Return the first ChildPresentation filtered by the instruction_id column
 * @method     ChildPresentation findOneByPersonId(int $person_id) Return the first ChildPresentation filtered by the person_id column *

 * @method     ChildPresentation requirePk($key, ConnectionInterface $con = null) Return the ChildPresentation by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPresentation requireOne(ConnectionInterface $con = null) Return the first ChildPresentation matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPresentation requireOneById(int $id) Return the first ChildPresentation filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPresentation requireOneByStatus(int $status) Return the first ChildPresentation filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPresentation requireOneBySubject(string $subject) Return the first ChildPresentation filtered by the subject column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPresentation requireOneByCreatedAt(string $created_at) Return the first ChildPresentation filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPresentation requireOneByInstructionId(int $instruction_id) Return the first ChildPresentation filtered by the instruction_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPresentation requireOneByPersonId(int $person_id) Return the first ChildPresentation filtered by the person_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPresentation[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPresentation objects based on current ModelCriteria
 * @method     ChildPresentation[]|ObjectCollection findById(int $id) Return ChildPresentation objects filtered by the id column
 * @method     ChildPresentation[]|ObjectCollection findByStatus(int $status) Return ChildPresentation objects filtered by the status column
 * @method     ChildPresentation[]|ObjectCollection findBySubject(string $subject) Return ChildPresentation objects filtered by the subject column
 * @method     ChildPresentation[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildPresentation objects filtered by the created_at column
 * @method     ChildPresentation[]|ObjectCollection findByInstructionId(int $instruction_id) Return ChildPresentation objects filtered by the instruction_id column
 * @method     ChildPresentation[]|ObjectCollection findByPersonId(int $person_id) Return ChildPresentation objects filtered by the person_id column
 * @method     ChildPresentation[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PresentationQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \BossEdu\Model\Base\PresentationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\BossEdu\\Model\\Presentation', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPresentationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPresentationQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPresentationQuery) {
            return $criteria;
        }
        $query = new ChildPresentationQuery();
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
     * @return ChildPresentation|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PresentationTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PresentationTableMap::DATABASE_NAME);
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
     * @return ChildPresentation A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, status, subject, created_at, instruction_id, person_id FROM presentation WHERE id = :p0';
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
            /** @var ChildPresentation $obj */
            $obj = new ChildPresentation();
            $obj->hydrate($row);
            PresentationTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPresentation|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPresentationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PresentationTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPresentationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PresentationTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPresentationQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PresentationTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PresentationTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PresentationTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildPresentationQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (is_array($status)) {
            $useMinMax = false;
            if (isset($status['min'])) {
                $this->addUsingAlias(PresentationTableMap::COL_STATUS, $status['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($status['max'])) {
                $this->addUsingAlias(PresentationTableMap::COL_STATUS, $status['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PresentationTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the subject column
     *
     * Example usage:
     * <code>
     * $query->filterBySubject('fooValue');   // WHERE subject = 'fooValue'
     * $query->filterBySubject('%fooValue%'); // WHERE subject LIKE '%fooValue%'
     * </code>
     *
     * @param     string $subject The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPresentationQuery The current query, for fluid interface
     */
    public function filterBySubject($subject = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($subject)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $subject)) {
                $subject = str_replace('*', '%', $subject);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PresentationTableMap::COL_SUBJECT, $subject, $comparison);
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
     * @return $this|ChildPresentationQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(PresentationTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(PresentationTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PresentationTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildPresentationQuery The current query, for fluid interface
     */
    public function filterByInstructionId($instructionId = null, $comparison = null)
    {
        if (is_array($instructionId)) {
            $useMinMax = false;
            if (isset($instructionId['min'])) {
                $this->addUsingAlias(PresentationTableMap::COL_INSTRUCTION_ID, $instructionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($instructionId['max'])) {
                $this->addUsingAlias(PresentationTableMap::COL_INSTRUCTION_ID, $instructionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PresentationTableMap::COL_INSTRUCTION_ID, $instructionId, $comparison);
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
     * @return $this|ChildPresentationQuery The current query, for fluid interface
     */
    public function filterByPersonId($personId = null, $comparison = null)
    {
        if (is_array($personId)) {
            $useMinMax = false;
            if (isset($personId['min'])) {
                $this->addUsingAlias(PresentationTableMap::COL_PERSON_ID, $personId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($personId['max'])) {
                $this->addUsingAlias(PresentationTableMap::COL_PERSON_ID, $personId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PresentationTableMap::COL_PERSON_ID, $personId, $comparison);
    }

    /**
     * Filter the query by a related \BossEdu\Model\Instruction object
     *
     * @param \BossEdu\Model\Instruction|ObjectCollection $instruction The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPresentationQuery The current query, for fluid interface
     */
    public function filterByInstruction($instruction, $comparison = null)
    {
        if ($instruction instanceof \BossEdu\Model\Instruction) {
            return $this
                ->addUsingAlias(PresentationTableMap::COL_INSTRUCTION_ID, $instruction->getId(), $comparison);
        } elseif ($instruction instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PresentationTableMap::COL_INSTRUCTION_ID, $instruction->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildPresentationQuery The current query, for fluid interface
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
     * Filter the query by a related \BossEdu\Model\Person object
     *
     * @param \BossEdu\Model\Person|ObjectCollection $person The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPresentationQuery The current query, for fluid interface
     */
    public function filterByPerson($person, $comparison = null)
    {
        if ($person instanceof \BossEdu\Model\Person) {
            return $this
                ->addUsingAlias(PresentationTableMap::COL_PERSON_ID, $person->getId(), $comparison);
        } elseif ($person instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PresentationTableMap::COL_PERSON_ID, $person->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildPresentationQuery The current query, for fluid interface
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
     * Filter the query by a related \BossEdu\Model\MpMaterial object
     *
     * @param \BossEdu\Model\MpMaterial|ObjectCollection $mpMaterial the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPresentationQuery The current query, for fluid interface
     */
    public function filterByMpMaterial($mpMaterial, $comparison = null)
    {
        if ($mpMaterial instanceof \BossEdu\Model\MpMaterial) {
            return $this
                ->addUsingAlias(PresentationTableMap::COL_ID, $mpMaterial->getPresentationId(), $comparison);
        } elseif ($mpMaterial instanceof ObjectCollection) {
            return $this
                ->useMpMaterialQuery()
                ->filterByPrimaryKeys($mpMaterial->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMpMaterial() only accepts arguments of type \BossEdu\Model\MpMaterial or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MpMaterial relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPresentationQuery The current query, for fluid interface
     */
    public function joinMpMaterial($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MpMaterial');

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
            $this->addJoinObject($join, 'MpMaterial');
        }

        return $this;
    }

    /**
     * Use the MpMaterial relation MpMaterial object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BossEdu\Model\MpMaterialQuery A secondary query class using the current class as primary query
     */
    public function useMpMaterialQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMpMaterial($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MpMaterial', '\BossEdu\Model\MpMaterialQuery');
    }

    /**
     * Filter the query by a related \BossEdu\Model\Doubt object
     *
     * @param \BossEdu\Model\Doubt|ObjectCollection $doubt the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPresentationQuery The current query, for fluid interface
     */
    public function filterByDoubt($doubt, $comparison = null)
    {
        if ($doubt instanceof \BossEdu\Model\Doubt) {
            return $this
                ->addUsingAlias(PresentationTableMap::COL_ID, $doubt->getPresentationId(), $comparison);
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
     * @return $this|ChildPresentationQuery The current query, for fluid interface
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
     * @param   ChildPresentation $presentation Object to remove from the list of results
     *
     * @return $this|ChildPresentationQuery The current query, for fluid interface
     */
    public function prune($presentation = null)
    {
        if ($presentation) {
            $this->addUsingAlias(PresentationTableMap::COL_ID, $presentation->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the presentation table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PresentationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PresentationTableMap::clearInstancePool();
            PresentationTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PresentationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PresentationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            PresentationTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            PresentationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PresentationQuery
