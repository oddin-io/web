<?php

namespace BossEdu\Model\Map;

use BossEdu\Model\RsAvailable;
use BossEdu\Model\RsAvailableQuery;
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
 * This class defines the structure of the 'rs_available' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class RsAvailableTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'BossEdu.Model.Map.RsAvailableTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'rs_available';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\BossEdu\\Model\\RsAvailable';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'BossEdu.Model.RsAvailable';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the building_code field
     */
    const COL_BUILDING_CODE = 'rs_available.building_code';

    /**
     * the column name for the room_number field
     */
    const COL_ROOM_NUMBER = 'rs_available.room_number';

    /**
     * the column name for the weekday field
     */
    const COL_WEEKDAY = 'rs_available.weekday';

    /**
     * the column name for the start_time field
     */
    const COL_START_TIME = 'rs_available.start_time';

    /**
     * the column name for the end_time field
     */
    const COL_END_TIME = 'rs_available.end_time';

    /**
     * the column name for the start_date field
     */
    const COL_START_DATE = 'rs_available.start_date';

    /**
     * the column name for the end_date field
     */
    const COL_END_DATE = 'rs_available.end_date';

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
        self::TYPE_PHPNAME       => array('BuildingCode', 'RoomNumber', 'Weekday', 'StartTime', 'EndTime', 'StartDate', 'EndDate', ),
        self::TYPE_CAMELNAME     => array('buildingCode', 'roomNumber', 'weekday', 'startTime', 'endTime', 'startDate', 'endDate', ),
        self::TYPE_COLNAME       => array(RsAvailableTableMap::COL_BUILDING_CODE, RsAvailableTableMap::COL_ROOM_NUMBER, RsAvailableTableMap::COL_WEEKDAY, RsAvailableTableMap::COL_START_TIME, RsAvailableTableMap::COL_END_TIME, RsAvailableTableMap::COL_START_DATE, RsAvailableTableMap::COL_END_DATE, ),
        self::TYPE_FIELDNAME     => array('building_code', 'room_number', 'weekday', 'start_time', 'end_time', 'start_date', 'end_date', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('BuildingCode' => 0, 'RoomNumber' => 1, 'Weekday' => 2, 'StartTime' => 3, 'EndTime' => 4, 'StartDate' => 5, 'EndDate' => 6, ),
        self::TYPE_CAMELNAME     => array('buildingCode' => 0, 'roomNumber' => 1, 'weekday' => 2, 'startTime' => 3, 'endTime' => 4, 'startDate' => 5, 'endDate' => 6, ),
        self::TYPE_COLNAME       => array(RsAvailableTableMap::COL_BUILDING_CODE => 0, RsAvailableTableMap::COL_ROOM_NUMBER => 1, RsAvailableTableMap::COL_WEEKDAY => 2, RsAvailableTableMap::COL_START_TIME => 3, RsAvailableTableMap::COL_END_TIME => 4, RsAvailableTableMap::COL_START_DATE => 5, RsAvailableTableMap::COL_END_DATE => 6, ),
        self::TYPE_FIELDNAME     => array('building_code' => 0, 'room_number' => 1, 'weekday' => 2, 'start_time' => 3, 'end_time' => 4, 'start_date' => 5, 'end_date' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
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
        $this->setName('rs_available');
        $this->setPhpName('RsAvailable');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\BossEdu\\Model\\RsAvailable');
        $this->setPackage('BossEdu.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('building_code', 'BuildingCode', 'VARCHAR' , 'room', 'building_code', true, 15, null);
        $this->addForeignPrimaryKey('room_number', 'RoomNumber', 'INTEGER' , 'room', 'number', true, null, null);
        $this->addForeignPrimaryKey('weekday', 'Weekday', 'INTEGER' , 'schedule', 'weekday', true, null, null);
        $this->addForeignPrimaryKey('start_time', 'StartTime', 'TIME' , 'schedule', 'start_time', true, null, null);
        $this->addForeignPrimaryKey('end_time', 'EndTime', 'TIME' , 'schedule', 'end_time', true, null, null);
        $this->addPrimaryKey('start_date', 'StartDate', 'DATE', true, null, null);
        $this->addColumn('end_date', 'EndDate', 'DATE', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Schedule', '\\BossEdu\\Model\\Schedule', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':weekday',
    1 => ':weekday',
  ),
  1 =>
  array (
    0 => ':start_time',
    1 => ':start_time',
  ),
  2 =>
  array (
    0 => ':end_time',
    1 => ':end_time',
  ),
), null, null, null, false);
        $this->addRelation('Room', '\\BossEdu\\Model\\Room', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':building_code',
    1 => ':building_code',
  ),
  1 =>
  array (
    0 => ':room_number',
    1 => ':number',
  ),
), null, null, null, false);
        $this->addRelation('IsrLink', '\\BossEdu\\Model\\IsrLink', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':building_code',
    1 => ':building_code',
  ),
  1 =>
  array (
    0 => ':room_number',
    1 => ':room_number',
  ),
  2 =>
  array (
    0 => ':weekday',
    1 => ':weekday',
  ),
  3 =>
  array (
    0 => ':start_time',
    1 => ':start_time',
  ),
  4 =>
  array (
    0 => ':end_time',
    1 => ':end_time',
  ),
  5 =>
  array (
    0 => ':start_date',
    1 => ':start_date',
  ),
), null, null, 'IsrLinks', false);
    } // buildRelations()

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \BossEdu\Model\RsAvailable $obj A \BossEdu\Model\RsAvailable object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize([(null === $obj->getBuildingCode() || is_scalar($obj->getBuildingCode()) || is_callable([$obj->getBuildingCode(), '__toString']) ? (string) $obj->getBuildingCode() : $obj->getBuildingCode()), (null === $obj->getRoomNumber() || is_scalar($obj->getRoomNumber()) || is_callable([$obj->getRoomNumber(), '__toString']) ? (string) $obj->getRoomNumber() : $obj->getRoomNumber()), (null === $obj->getWeekday() || is_scalar($obj->getWeekday()) || is_callable([$obj->getWeekday(), '__toString']) ? (string) $obj->getWeekday() : $obj->getWeekday()), (null === $obj->getStartTime() || is_scalar($obj->getStartTime()) || is_callable([$obj->getStartTime(), '__toString']) ? (string) $obj->getStartTime() : $obj->getStartTime()), (null === $obj->getEndTime() || is_scalar($obj->getEndTime()) || is_callable([$obj->getEndTime(), '__toString']) ? (string) $obj->getEndTime() : $obj->getEndTime()), (null === $obj->getStartDate() || is_scalar($obj->getStartDate()) || is_callable([$obj->getStartDate(), '__toString']) ? (string) $obj->getStartDate() : $obj->getStartDate())]);
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \BossEdu\Model\RsAvailable object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \BossEdu\Model\RsAvailable) {
                $key = serialize([(null === $value->getBuildingCode() || is_scalar($value->getBuildingCode()) || is_callable([$value->getBuildingCode(), '__toString']) ? (string) $value->getBuildingCode() : $value->getBuildingCode()), (null === $value->getRoomNumber() || is_scalar($value->getRoomNumber()) || is_callable([$value->getRoomNumber(), '__toString']) ? (string) $value->getRoomNumber() : $value->getRoomNumber()), (null === $value->getWeekday() || is_scalar($value->getWeekday()) || is_callable([$value->getWeekday(), '__toString']) ? (string) $value->getWeekday() : $value->getWeekday()), (null === $value->getStartTime() || is_scalar($value->getStartTime()) || is_callable([$value->getStartTime(), '__toString']) ? (string) $value->getStartTime() : $value->getStartTime()), (null === $value->getEndTime() || is_scalar($value->getEndTime()) || is_callable([$value->getEndTime(), '__toString']) ? (string) $value->getEndTime() : $value->getEndTime()), (null === $value->getStartDate() || is_scalar($value->getStartDate()) || is_callable([$value->getStartDate(), '__toString']) ? (string) $value->getStartDate() : $value->getStartDate())]);

            } elseif (is_array($value) && count($value) === 6) {
                // assume we've been passed a primary key";
                $key = serialize([(null === $value[0] || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string) $value[0] : $value[0]), (null === $value[1] || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string) $value[1] : $value[1]), (null === $value[2] || is_scalar($value[2]) || is_callable([$value[2], '__toString']) ? (string) $value[2] : $value[2]), (null === $value[3] || is_scalar($value[3]) || is_callable([$value[3], '__toString']) ? (string) $value[3] : $value[3]), (null === $value[4] || is_scalar($value[4]) || is_callable([$value[4], '__toString']) ? (string) $value[4] : $value[4]), (null === $value[5] || is_scalar($value[5]) || is_callable([$value[5], '__toString']) ? (string) $value[5] : $value[5])]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \BossEdu\Model\RsAvailable object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
    }

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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('BuildingCode', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('RoomNumber', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('Weekday', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 3 + $offset : static::translateFieldName('StartTime', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 4 + $offset : static::translateFieldName('EndTime', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 5 + $offset : static::translateFieldName('StartDate', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([(null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('BuildingCode', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('BuildingCode', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('BuildingCode', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('BuildingCode', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('BuildingCode', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('RoomNumber', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('RoomNumber', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('RoomNumber', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('RoomNumber', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('RoomNumber', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('Weekday', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('Weekday', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('Weekday', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('Weekday', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('Weekday', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 3 + $offset : static::translateFieldName('StartTime', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 3 + $offset : static::translateFieldName('StartTime', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 3 + $offset : static::translateFieldName('StartTime', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 3 + $offset : static::translateFieldName('StartTime', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 3 + $offset : static::translateFieldName('StartTime', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 4 + $offset : static::translateFieldName('EndTime', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 4 + $offset : static::translateFieldName('EndTime', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 4 + $offset : static::translateFieldName('EndTime', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 4 + $offset : static::translateFieldName('EndTime', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 4 + $offset : static::translateFieldName('EndTime', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 5 + $offset : static::translateFieldName('StartDate', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 5 + $offset : static::translateFieldName('StartDate', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 5 + $offset : static::translateFieldName('StartDate', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 5 + $offset : static::translateFieldName('StartDate', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 5 + $offset : static::translateFieldName('StartDate', TableMap::TYPE_PHPNAME, $indexType)])]);
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
            $pks = [];
            
        $pks[] = (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('BuildingCode', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 1 + $offset
                : self::translateFieldName('RoomNumber', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 2 + $offset
                : self::translateFieldName('Weekday', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 3 + $offset
                : self::translateFieldName('StartTime', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 4 + $offset
                : self::translateFieldName('EndTime', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 5 + $offset
                : self::translateFieldName('StartDate', TableMap::TYPE_PHPNAME, $indexType)
        ];

        return $pks;
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
        return $withPrefix ? RsAvailableTableMap::CLASS_DEFAULT : RsAvailableTableMap::OM_CLASS;
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
     * @return array           (RsAvailable object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = RsAvailableTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = RsAvailableTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + RsAvailableTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = RsAvailableTableMap::OM_CLASS;
            /** @var RsAvailable $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            RsAvailableTableMap::addInstanceToPool($obj, $key);
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
            $key = RsAvailableTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = RsAvailableTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var RsAvailable $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                RsAvailableTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(RsAvailableTableMap::COL_BUILDING_CODE);
            $criteria->addSelectColumn(RsAvailableTableMap::COL_ROOM_NUMBER);
            $criteria->addSelectColumn(RsAvailableTableMap::COL_WEEKDAY);
            $criteria->addSelectColumn(RsAvailableTableMap::COL_START_TIME);
            $criteria->addSelectColumn(RsAvailableTableMap::COL_END_TIME);
            $criteria->addSelectColumn(RsAvailableTableMap::COL_START_DATE);
            $criteria->addSelectColumn(RsAvailableTableMap::COL_END_DATE);
        } else {
            $criteria->addSelectColumn($alias . '.building_code');
            $criteria->addSelectColumn($alias . '.room_number');
            $criteria->addSelectColumn($alias . '.weekday');
            $criteria->addSelectColumn($alias . '.start_time');
            $criteria->addSelectColumn($alias . '.end_time');
            $criteria->addSelectColumn($alias . '.start_date');
            $criteria->addSelectColumn($alias . '.end_date');
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
        return Propel::getServiceContainer()->getDatabaseMap(RsAvailableTableMap::DATABASE_NAME)->getTable(RsAvailableTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(RsAvailableTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(RsAvailableTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new RsAvailableTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a RsAvailable or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or RsAvailable object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(RsAvailableTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \BossEdu\Model\RsAvailable) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(RsAvailableTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(RsAvailableTableMap::COL_BUILDING_CODE, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(RsAvailableTableMap::COL_ROOM_NUMBER, $value[1]));
                $criterion->addAnd($criteria->getNewCriterion(RsAvailableTableMap::COL_WEEKDAY, $value[2]));
                $criterion->addAnd($criteria->getNewCriterion(RsAvailableTableMap::COL_START_TIME, $value[3]));
                $criterion->addAnd($criteria->getNewCriterion(RsAvailableTableMap::COL_END_TIME, $value[4]));
                $criterion->addAnd($criteria->getNewCriterion(RsAvailableTableMap::COL_START_DATE, $value[5]));
                $criteria->addOr($criterion);
            }
        }

        $query = RsAvailableQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            RsAvailableTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                RsAvailableTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the rs_available table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return RsAvailableQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a RsAvailable or Criteria object.
     *
     * @param mixed               $criteria Criteria or RsAvailable object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RsAvailableTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from RsAvailable object
        }


        // Set the correct dbName
        $query = RsAvailableQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // RsAvailableTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
RsAvailableTableMap::buildTableMap();
