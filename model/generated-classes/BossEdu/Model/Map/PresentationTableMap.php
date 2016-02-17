<?php

namespace BossEdu\Model\Map;

use BossEdu\Model\Presentation;
use BossEdu\Model\PresentationQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'presentation' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PresentationTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'BossEdu.Model.Map.PresentationTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'presentation';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\BossEdu\\Model\\Presentation';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'BossEdu.Model.Presentation';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the id field
     */
    const COL_ID = 'presentation.id';

    /**
     * the column name for the status field
     */
    const COL_STATUS = 'presentation.status';

    /**
     * the column name for the subject field
     */
    const COL_SUBJECT = 'presentation.subject';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'presentation.created_at';

    /**
     * the column name for the instruction_id field
     */
    const COL_INSTRUCTION_ID = 'presentation.instruction_id';

    /**
     * the column name for the person_id field
     */
    const COL_PERSON_ID = 'presentation.person_id';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Status', 'Subject', 'CreatedAt', 'InstructionId', 'PersonId', ),
        self::TYPE_CAMELNAME     => array('id', 'status', 'subject', 'createdAt', 'instructionId', 'personId', ),
        self::TYPE_COLNAME       => array(PresentationTableMap::COL_ID, PresentationTableMap::COL_STATUS, PresentationTableMap::COL_SUBJECT, PresentationTableMap::COL_CREATED_AT, PresentationTableMap::COL_INSTRUCTION_ID, PresentationTableMap::COL_PERSON_ID, ),
        self::TYPE_FIELDNAME     => array('id', 'status', 'subject', 'created_at', 'instruction_id', 'person_id', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Status' => 1, 'Subject' => 2, 'CreatedAt' => 3, 'InstructionId' => 4, 'PersonId' => 5, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'status' => 1, 'subject' => 2, 'createdAt' => 3, 'instructionId' => 4, 'personId' => 5, ),
        self::TYPE_COLNAME       => array(PresentationTableMap::COL_ID => 0, PresentationTableMap::COL_STATUS => 1, PresentationTableMap::COL_SUBJECT => 2, PresentationTableMap::COL_CREATED_AT => 3, PresentationTableMap::COL_INSTRUCTION_ID => 4, PresentationTableMap::COL_PERSON_ID => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'status' => 1, 'subject' => 2, 'created_at' => 3, 'instruction_id' => 4, 'person_id' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('presentation');
        $this->setPhpName('Presentation');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\BossEdu\\Model\\Presentation');
        $this->setPackage('BossEdu.Model');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('presentation_id_seq');
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('status', 'Status', 'INTEGER', false, null, 0);
        $this->addColumn('subject', 'Subject', 'VARCHAR', false, 25, 'Class X');
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, 'now');
        $this->addForeignKey('instruction_id', 'InstructionId', 'INTEGER', 'instruction', 'id', true, null, null);
        $this->addForeignKey('person_id', 'PersonId', 'INTEGER', 'person', 'id', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Instruction', '\\BossEdu\\Model\\Instruction', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':instruction_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Person', '\\BossEdu\\Model\\Person', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':person_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('MpMaterial', '\\BossEdu\\Model\\MpMaterial', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':presentation_id',
    1 => ':id',
  ),
), null, null, 'MpMaterials', false);
        $this->addRelation('Doubt', '\\BossEdu\\Model\\Doubt', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':presentation_id',
    1 => ':id',
  ),
), null, null, 'Doubts', false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }
    
    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? PresentationTableMap::CLASS_DEFAULT : PresentationTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Presentation object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PresentationTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PresentationTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PresentationTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PresentationTableMap::OM_CLASS;
            /** @var Presentation $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PresentationTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();
    
        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = PresentationTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PresentationTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Presentation $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PresentationTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(PresentationTableMap::COL_ID);
            $criteria->addSelectColumn(PresentationTableMap::COL_STATUS);
            $criteria->addSelectColumn(PresentationTableMap::COL_SUBJECT);
            $criteria->addSelectColumn(PresentationTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(PresentationTableMap::COL_INSTRUCTION_ID);
            $criteria->addSelectColumn(PresentationTableMap::COL_PERSON_ID);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.status');
            $criteria->addSelectColumn($alias . '.subject');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.instruction_id');
            $criteria->addSelectColumn($alias . '.person_id');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(PresentationTableMap::DATABASE_NAME)->getTable(PresentationTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PresentationTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PresentationTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PresentationTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Presentation or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Presentation object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PresentationTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \BossEdu\Model\Presentation) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PresentationTableMap::DATABASE_NAME);
            $criteria->add(PresentationTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PresentationQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PresentationTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PresentationTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the presentation table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PresentationQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Presentation or Criteria object.
     *
     * @param mixed               $criteria Criteria or Presentation object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PresentationTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Presentation object
        }

        if ($criteria->containsKey(PresentationTableMap::COL_ID) && $criteria->keyContainsValue(PresentationTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PresentationTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PresentationQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PresentationTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PresentationTableMap::buildTableMap();
