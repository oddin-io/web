<?php

namespace BossEdu\Model\Map;

use BossEdu\Model\Doubt;
use BossEdu\Model\DoubtQuery;
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
 * This class defines the structure of the 'doubt' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class DoubtTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'BossEdu.Model.Map.DoubtTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'doubt';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\BossEdu\\Model\\Doubt';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'BossEdu.Model.Doubt';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the id field
     */
    const COL_ID = 'doubt.id';

    /**
     * the column name for the status field
     */
    const COL_STATUS = 'doubt.status';

    /**
     * the column name for the text field
     */
    const COL_TEXT = 'doubt.text';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'doubt.created_at';

    /**
     * the column name for the anonymous field
     */
    const COL_ANONYMOUS = 'doubt.anonymous';

    /**
     * the column name for the understand field
     */
    const COL_UNDERSTAND = 'doubt.understand';

    /**
     * the column name for the presentation_id field
     */
    const COL_PRESENTATION_ID = 'doubt.presentation_id';

    /**
     * the column name for the person_id field
     */
    const COL_PERSON_ID = 'doubt.person_id';

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
        self::TYPE_PHPNAME       => array('Id', 'Status', 'Text', 'CreatedAt', 'Anonymous', 'Understand', 'PresentationId', 'PersonId', ),
        self::TYPE_CAMELNAME     => array('id', 'status', 'text', 'createdAt', 'anonymous', 'understand', 'presentationId', 'personId', ),
        self::TYPE_COLNAME       => array(DoubtTableMap::COL_ID, DoubtTableMap::COL_STATUS, DoubtTableMap::COL_TEXT, DoubtTableMap::COL_CREATED_AT, DoubtTableMap::COL_ANONYMOUS, DoubtTableMap::COL_UNDERSTAND, DoubtTableMap::COL_PRESENTATION_ID, DoubtTableMap::COL_PERSON_ID, ),
        self::TYPE_FIELDNAME     => array('id', 'status', 'text', 'created_at', 'anonymous', 'understand', 'presentation_id', 'person_id', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Status' => 1, 'Text' => 2, 'CreatedAt' => 3, 'Anonymous' => 4, 'Understand' => 5, 'PresentationId' => 6, 'PersonId' => 7, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'status' => 1, 'text' => 2, 'createdAt' => 3, 'anonymous' => 4, 'understand' => 5, 'presentationId' => 6, 'personId' => 7, ),
        self::TYPE_COLNAME       => array(DoubtTableMap::COL_ID => 0, DoubtTableMap::COL_STATUS => 1, DoubtTableMap::COL_TEXT => 2, DoubtTableMap::COL_CREATED_AT => 3, DoubtTableMap::COL_ANONYMOUS => 4, DoubtTableMap::COL_UNDERSTAND => 5, DoubtTableMap::COL_PRESENTATION_ID => 6, DoubtTableMap::COL_PERSON_ID => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'status' => 1, 'text' => 2, 'created_at' => 3, 'anonymous' => 4, 'understand' => 5, 'presentation_id' => 6, 'person_id' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
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
        $this->setName('doubt');
        $this->setPhpName('Doubt');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\BossEdu\\Model\\Doubt');
        $this->setPackage('BossEdu.Model');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('doubt_id_seq');
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('status', 'Status', 'INTEGER', false, null, 0);
        $this->addColumn('text', 'Text', 'VARCHAR', true, 140, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, 'now');
        $this->addColumn('anonymous', 'Anonymous', 'BOOLEAN', false, null, false);
        $this->addColumn('understand', 'Understand', 'BOOLEAN', false, null, false);
        $this->addForeignKey('presentation_id', 'PresentationId', 'INTEGER', 'presentation', 'id', true, null, null);
        $this->addForeignKey('person_id', 'PersonId', 'INTEGER', 'person', 'id', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Presentation', '\\BossEdu\\Model\\Presentation', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':presentation_id',
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
        $this->addRelation('PdLike', '\\BossEdu\\Model\\PdLike', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':doubt_id',
    1 => ':id',
  ),
), null, null, 'PdLikes', false);
        $this->addRelation('Contribution', '\\BossEdu\\Model\\Contribution', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':doubt_id',
    1 => ':id',
  ),
), null, null, 'Contributions', false);
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
        return $withPrefix ? DoubtTableMap::CLASS_DEFAULT : DoubtTableMap::OM_CLASS;
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
     * @return array           (Doubt object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = DoubtTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = DoubtTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + DoubtTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = DoubtTableMap::OM_CLASS;
            /** @var Doubt $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            DoubtTableMap::addInstanceToPool($obj, $key);
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
            $key = DoubtTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = DoubtTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Doubt $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                DoubtTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(DoubtTableMap::COL_ID);
            $criteria->addSelectColumn(DoubtTableMap::COL_STATUS);
            $criteria->addSelectColumn(DoubtTableMap::COL_TEXT);
            $criteria->addSelectColumn(DoubtTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(DoubtTableMap::COL_ANONYMOUS);
            $criteria->addSelectColumn(DoubtTableMap::COL_UNDERSTAND);
            $criteria->addSelectColumn(DoubtTableMap::COL_PRESENTATION_ID);
            $criteria->addSelectColumn(DoubtTableMap::COL_PERSON_ID);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.status');
            $criteria->addSelectColumn($alias . '.text');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.anonymous');
            $criteria->addSelectColumn($alias . '.understand');
            $criteria->addSelectColumn($alias . '.presentation_id');
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
        return Propel::getServiceContainer()->getDatabaseMap(DoubtTableMap::DATABASE_NAME)->getTable(DoubtTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(DoubtTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(DoubtTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new DoubtTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Doubt or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Doubt object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(DoubtTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \BossEdu\Model\Doubt) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(DoubtTableMap::DATABASE_NAME);
            $criteria->add(DoubtTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = DoubtQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            DoubtTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                DoubtTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the doubt table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return DoubtQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Doubt or Criteria object.
     *
     * @param mixed               $criteria Criteria or Doubt object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DoubtTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Doubt object
        }

        if ($criteria->containsKey(DoubtTableMap::COL_ID) && $criteria->keyContainsValue(DoubtTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.DoubtTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = DoubtQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // DoubtTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
DoubtTableMap::buildTableMap();
