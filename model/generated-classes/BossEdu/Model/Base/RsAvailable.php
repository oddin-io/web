<?php

namespace BossEdu\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use BossEdu\Model\IsrLink as ChildIsrLink;
use BossEdu\Model\IsrLinkQuery as ChildIsrLinkQuery;
use BossEdu\Model\Room as ChildRoom;
use BossEdu\Model\RoomQuery as ChildRoomQuery;
use BossEdu\Model\RsAvailable as ChildRsAvailable;
use BossEdu\Model\RsAvailableQuery as ChildRsAvailableQuery;
use BossEdu\Model\Schedule as ChildSchedule;
use BossEdu\Model\ScheduleQuery as ChildScheduleQuery;
use BossEdu\Model\Map\IsrLinkTableMap;
use BossEdu\Model\Map\RsAvailableTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'rs_available' table.
 *
 * 
 *
* @package    propel.generator.BossEdu.Model.Base
*/
abstract class RsAvailable implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\BossEdu\\Model\\Map\\RsAvailableTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the building_code field.
     * 
     * @var        string
     */
    protected $building_code;

    /**
     * The value for the room_number field.
     * 
     * @var        int
     */
    protected $room_number;

    /**
     * The value for the weekday field.
     * 
     * @var        int
     */
    protected $weekday;

    /**
     * The value for the start_time field.
     * 
     * @var        \DateTime
     */
    protected $start_time;

    /**
     * The value for the end_time field.
     * 
     * @var        \DateTime
     */
    protected $end_time;

    /**
     * The value for the start_date field.
     * 
     * @var        \DateTime
     */
    protected $start_date;

    /**
     * The value for the end_date field.
     * 
     * @var        \DateTime
     */
    protected $end_date;

    /**
     * @var        ChildSchedule
     */
    protected $aSchedule;

    /**
     * @var        ChildRoom
     */
    protected $aRoom;

    /**
     * @var        ObjectCollection|ChildIsrLink[] Collection to store aggregation of ChildIsrLink objects.
     */
    protected $collIsrLinks;
    protected $collIsrLinksPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildIsrLink[]
     */
    protected $isrLinksScheduledForDeletion = null;

    /**
     * Initializes internal state of BossEdu\Model\Base\RsAvailable object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>RsAvailable</code> instance.  If
     * <code>obj</code> is an instance of <code>RsAvailable</code>, delegates to
     * <code>equals(RsAvailable)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|RsAvailable The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));
        
        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }
        
        return $propertyNames;
    }

    /**
     * Get the [building_code] column value.
     * 
     * @return string
     */
    public function getBuildingCode()
    {
        return $this->building_code;
    }

    /**
     * Get the [room_number] column value.
     * 
     * @return int
     */
    public function getRoomNumber()
    {
        return $this->room_number;
    }

    /**
     * Get the [weekday] column value.
     * 
     * @return int
     */
    public function getWeekday()
    {
        return $this->weekday;
    }

    /**
     * Get the [optionally formatted] temporal [start_time] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getStartTime($format = NULL)
    {
        if ($format === null) {
            return $this->start_time;
        } else {
            return $this->start_time instanceof \DateTime ? $this->start_time->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [end_time] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getEndTime($format = NULL)
    {
        if ($format === null) {
            return $this->end_time;
        } else {
            return $this->end_time instanceof \DateTime ? $this->end_time->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [start_date] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getStartDate($format = NULL)
    {
        if ($format === null) {
            return $this->start_date;
        } else {
            return $this->start_date instanceof \DateTime ? $this->start_date->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [end_date] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getEndDate($format = NULL)
    {
        if ($format === null) {
            return $this->end_date;
        } else {
            return $this->end_date instanceof \DateTime ? $this->end_date->format($format) : null;
        }
    }

    /**
     * Set the value of [building_code] column.
     * 
     * @param string $v new value
     * @return $this|\BossEdu\Model\RsAvailable The current object (for fluent API support)
     */
    public function setBuildingCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->building_code !== $v) {
            $this->building_code = $v;
            $this->modifiedColumns[RsAvailableTableMap::COL_BUILDING_CODE] = true;
        }

        if ($this->aRoom !== null && $this->aRoom->getBuildingCode() !== $v) {
            $this->aRoom = null;
        }

        return $this;
    } // setBuildingCode()

    /**
     * Set the value of [room_number] column.
     * 
     * @param int $v new value
     * @return $this|\BossEdu\Model\RsAvailable The current object (for fluent API support)
     */
    public function setRoomNumber($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->room_number !== $v) {
            $this->room_number = $v;
            $this->modifiedColumns[RsAvailableTableMap::COL_ROOM_NUMBER] = true;
        }

        if ($this->aRoom !== null && $this->aRoom->getNumber() !== $v) {
            $this->aRoom = null;
        }

        return $this;
    } // setRoomNumber()

    /**
     * Set the value of [weekday] column.
     * 
     * @param int $v new value
     * @return $this|\BossEdu\Model\RsAvailable The current object (for fluent API support)
     */
    public function setWeekday($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->weekday !== $v) {
            $this->weekday = $v;
            $this->modifiedColumns[RsAvailableTableMap::COL_WEEKDAY] = true;
        }

        if ($this->aSchedule !== null && $this->aSchedule->getWeekday() !== $v) {
            $this->aSchedule = null;
        }

        return $this;
    } // setWeekday()

    /**
     * Sets the value of [start_time] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\BossEdu\Model\RsAvailable The current object (for fluent API support)
     */
    public function setStartTime($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->start_time !== null || $dt !== null) {
            if ($this->start_time === null || $dt === null || $dt->format("H:i:s") !== $this->start_time->format("H:i:s")) {
                $this->start_time = $dt === null ? null : clone $dt;
                $this->modifiedColumns[RsAvailableTableMap::COL_START_TIME] = true;
            }
        } // if either are not null

        if ($this->aSchedule !== null && $this->aSchedule->getStartTime() !== $v) {
            $this->aSchedule = null;
        }

        return $this;
    } // setStartTime()

    /**
     * Sets the value of [end_time] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\BossEdu\Model\RsAvailable The current object (for fluent API support)
     */
    public function setEndTime($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->end_time !== null || $dt !== null) {
            if ($this->end_time === null || $dt === null || $dt->format("H:i:s") !== $this->end_time->format("H:i:s")) {
                $this->end_time = $dt === null ? null : clone $dt;
                $this->modifiedColumns[RsAvailableTableMap::COL_END_TIME] = true;
            }
        } // if either are not null

        if ($this->aSchedule !== null && $this->aSchedule->getEndTime() !== $v) {
            $this->aSchedule = null;
        }

        return $this;
    } // setEndTime()

    /**
     * Sets the value of [start_date] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\BossEdu\Model\RsAvailable The current object (for fluent API support)
     */
    public function setStartDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->start_date !== null || $dt !== null) {
            if ($this->start_date === null || $dt === null || $dt->format("Y-m-d") !== $this->start_date->format("Y-m-d")) {
                $this->start_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[RsAvailableTableMap::COL_START_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setStartDate()

    /**
     * Sets the value of [end_date] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\BossEdu\Model\RsAvailable The current object (for fluent API support)
     */
    public function setEndDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->end_date !== null || $dt !== null) {
            if ($this->end_date === null || $dt === null || $dt->format("Y-m-d") !== $this->end_date->format("Y-m-d")) {
                $this->end_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[RsAvailableTableMap::COL_END_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setEndDate()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : RsAvailableTableMap::translateFieldName('BuildingCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->building_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : RsAvailableTableMap::translateFieldName('RoomNumber', TableMap::TYPE_PHPNAME, $indexType)];
            $this->room_number = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : RsAvailableTableMap::translateFieldName('Weekday', TableMap::TYPE_PHPNAME, $indexType)];
            $this->weekday = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : RsAvailableTableMap::translateFieldName('StartTime', TableMap::TYPE_PHPNAME, $indexType)];
            $this->start_time = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : RsAvailableTableMap::translateFieldName('EndTime', TableMap::TYPE_PHPNAME, $indexType)];
            $this->end_time = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : RsAvailableTableMap::translateFieldName('StartDate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->start_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : RsAvailableTableMap::translateFieldName('EndDate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->end_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = RsAvailableTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\BossEdu\\Model\\RsAvailable'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aRoom !== null && $this->building_code !== $this->aRoom->getBuildingCode()) {
            $this->aRoom = null;
        }
        if ($this->aRoom !== null && $this->room_number !== $this->aRoom->getNumber()) {
            $this->aRoom = null;
        }
        if ($this->aSchedule !== null && $this->weekday !== $this->aSchedule->getWeekday()) {
            $this->aSchedule = null;
        }
        if ($this->aSchedule !== null && $this->start_time !== $this->aSchedule->getStartTime()) {
            $this->aSchedule = null;
        }
        if ($this->aSchedule !== null && $this->end_time !== $this->aSchedule->getEndTime()) {
            $this->aSchedule = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RsAvailableTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildRsAvailableQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aSchedule = null;
            $this->aRoom = null;
            $this->collIsrLinks = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see RsAvailable::setDeleted()
     * @see RsAvailable::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(RsAvailableTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildRsAvailableQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(RsAvailableTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                RsAvailableTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aSchedule !== null) {
                if ($this->aSchedule->isModified() || $this->aSchedule->isNew()) {
                    $affectedRows += $this->aSchedule->save($con);
                }
                $this->setSchedule($this->aSchedule);
            }

            if ($this->aRoom !== null) {
                if ($this->aRoom->isModified() || $this->aRoom->isNew()) {
                    $affectedRows += $this->aRoom->save($con);
                }
                $this->setRoom($this->aRoom);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->isrLinksScheduledForDeletion !== null) {
                if (!$this->isrLinksScheduledForDeletion->isEmpty()) {
                    \BossEdu\Model\IsrLinkQuery::create()
                        ->filterByPrimaryKeys($this->isrLinksScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->isrLinksScheduledForDeletion = null;
                }
            }

            if ($this->collIsrLinks !== null) {
                foreach ($this->collIsrLinks as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(RsAvailableTableMap::COL_BUILDING_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'building_code';
        }
        if ($this->isColumnModified(RsAvailableTableMap::COL_ROOM_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'room_number';
        }
        if ($this->isColumnModified(RsAvailableTableMap::COL_WEEKDAY)) {
            $modifiedColumns[':p' . $index++]  = 'weekday';
        }
        if ($this->isColumnModified(RsAvailableTableMap::COL_START_TIME)) {
            $modifiedColumns[':p' . $index++]  = 'start_time';
        }
        if ($this->isColumnModified(RsAvailableTableMap::COL_END_TIME)) {
            $modifiedColumns[':p' . $index++]  = 'end_time';
        }
        if ($this->isColumnModified(RsAvailableTableMap::COL_START_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'start_date';
        }
        if ($this->isColumnModified(RsAvailableTableMap::COL_END_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'end_date';
        }

        $sql = sprintf(
            'INSERT INTO rs_available (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'building_code':                        
                        $stmt->bindValue($identifier, $this->building_code, PDO::PARAM_STR);
                        break;
                    case 'room_number':                        
                        $stmt->bindValue($identifier, $this->room_number, PDO::PARAM_INT);
                        break;
                    case 'weekday':                        
                        $stmt->bindValue($identifier, $this->weekday, PDO::PARAM_INT);
                        break;
                    case 'start_time':                        
                        $stmt->bindValue($identifier, $this->start_time ? $this->start_time->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'end_time':                        
                        $stmt->bindValue($identifier, $this->end_time ? $this->end_time->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'start_date':                        
                        $stmt->bindValue($identifier, $this->start_date ? $this->start_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'end_date':                        
                        $stmt->bindValue($identifier, $this->end_date ? $this->end_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = RsAvailableTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getBuildingCode();
                break;
            case 1:
                return $this->getRoomNumber();
                break;
            case 2:
                return $this->getWeekday();
                break;
            case 3:
                return $this->getStartTime();
                break;
            case 4:
                return $this->getEndTime();
                break;
            case 5:
                return $this->getStartDate();
                break;
            case 6:
                return $this->getEndDate();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['RsAvailable'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['RsAvailable'][$this->hashCode()] = true;
        $keys = RsAvailableTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getBuildingCode(),
            $keys[1] => $this->getRoomNumber(),
            $keys[2] => $this->getWeekday(),
            $keys[3] => $this->getStartTime(),
            $keys[4] => $this->getEndTime(),
            $keys[5] => $this->getStartDate(),
            $keys[6] => $this->getEndDate(),
        );
        if ($result[$keys[3]] instanceof \DateTime) {
            $result[$keys[3]] = $result[$keys[3]]->format('c');
        }
        
        if ($result[$keys[4]] instanceof \DateTime) {
            $result[$keys[4]] = $result[$keys[4]]->format('c');
        }
        
        if ($result[$keys[5]] instanceof \DateTime) {
            $result[$keys[5]] = $result[$keys[5]]->format('c');
        }
        
        if ($result[$keys[6]] instanceof \DateTime) {
            $result[$keys[6]] = $result[$keys[6]]->format('c');
        }
        
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aSchedule) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'schedule';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'schedule';
                        break;
                    default:
                        $key = 'Schedule';
                }
        
                $result[$key] = $this->aSchedule->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aRoom) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'room';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'room';
                        break;
                    default:
                        $key = 'Room';
                }
        
                $result[$key] = $this->aRoom->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collIsrLinks) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'isrLinks';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'isr_links';
                        break;
                    default:
                        $key = 'IsrLinks';
                }
        
                $result[$key] = $this->collIsrLinks->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\BossEdu\Model\RsAvailable
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = RsAvailableTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\BossEdu\Model\RsAvailable
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setBuildingCode($value);
                break;
            case 1:
                $this->setRoomNumber($value);
                break;
            case 2:
                $this->setWeekday($value);
                break;
            case 3:
                $this->setStartTime($value);
                break;
            case 4:
                $this->setEndTime($value);
                break;
            case 5:
                $this->setStartDate($value);
                break;
            case 6:
                $this->setEndDate($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = RsAvailableTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setBuildingCode($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setRoomNumber($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setWeekday($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setStartTime($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setEndTime($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setStartDate($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setEndDate($arr[$keys[6]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\BossEdu\Model\RsAvailable The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(RsAvailableTableMap::DATABASE_NAME);

        if ($this->isColumnModified(RsAvailableTableMap::COL_BUILDING_CODE)) {
            $criteria->add(RsAvailableTableMap::COL_BUILDING_CODE, $this->building_code);
        }
        if ($this->isColumnModified(RsAvailableTableMap::COL_ROOM_NUMBER)) {
            $criteria->add(RsAvailableTableMap::COL_ROOM_NUMBER, $this->room_number);
        }
        if ($this->isColumnModified(RsAvailableTableMap::COL_WEEKDAY)) {
            $criteria->add(RsAvailableTableMap::COL_WEEKDAY, $this->weekday);
        }
        if ($this->isColumnModified(RsAvailableTableMap::COL_START_TIME)) {
            $criteria->add(RsAvailableTableMap::COL_START_TIME, $this->start_time);
        }
        if ($this->isColumnModified(RsAvailableTableMap::COL_END_TIME)) {
            $criteria->add(RsAvailableTableMap::COL_END_TIME, $this->end_time);
        }
        if ($this->isColumnModified(RsAvailableTableMap::COL_START_DATE)) {
            $criteria->add(RsAvailableTableMap::COL_START_DATE, $this->start_date);
        }
        if ($this->isColumnModified(RsAvailableTableMap::COL_END_DATE)) {
            $criteria->add(RsAvailableTableMap::COL_END_DATE, $this->end_date);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildRsAvailableQuery::create();
        $criteria->add(RsAvailableTableMap::COL_BUILDING_CODE, $this->building_code);
        $criteria->add(RsAvailableTableMap::COL_ROOM_NUMBER, $this->room_number);
        $criteria->add(RsAvailableTableMap::COL_WEEKDAY, $this->weekday);
        $criteria->add(RsAvailableTableMap::COL_START_TIME, $this->start_time);
        $criteria->add(RsAvailableTableMap::COL_END_TIME, $this->end_time);
        $criteria->add(RsAvailableTableMap::COL_START_DATE, $this->start_date);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getBuildingCode() &&
            null !== $this->getRoomNumber() &&
            null !== $this->getWeekday() &&
            null !== $this->getStartTime() &&
            null !== $this->getEndTime() &&
            null !== $this->getStartDate();

        $validPrimaryKeyFKs = 5;
        $primaryKeyFKs = [];

        //relation rs_available_schedule_fk to table schedule
        if ($this->aSchedule && $hash = spl_object_hash($this->aSchedule)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

        //relation rs_available_room_fk to table room
        if ($this->aRoom && $hash = spl_object_hash($this->aRoom)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }
        
    /**
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getBuildingCode();
        $pks[1] = $this->getRoomNumber();
        $pks[2] = $this->getWeekday();
        $pks[3] = $this->getStartTime();
        $pks[4] = $this->getEndTime();
        $pks[5] = $this->getStartDate();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param      array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setBuildingCode($keys[0]);
        $this->setRoomNumber($keys[1]);
        $this->setWeekday($keys[2]);
        $this->setStartTime($keys[3]);
        $this->setEndTime($keys[4]);
        $this->setStartDate($keys[5]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return (null === $this->getBuildingCode()) && (null === $this->getRoomNumber()) && (null === $this->getWeekday()) && (null === $this->getStartTime()) && (null === $this->getEndTime()) && (null === $this->getStartDate());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \BossEdu\Model\RsAvailable (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setBuildingCode($this->getBuildingCode());
        $copyObj->setRoomNumber($this->getRoomNumber());
        $copyObj->setWeekday($this->getWeekday());
        $copyObj->setStartTime($this->getStartTime());
        $copyObj->setEndTime($this->getEndTime());
        $copyObj->setStartDate($this->getStartDate());
        $copyObj->setEndDate($this->getEndDate());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getIsrLinks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addIsrLink($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \BossEdu\Model\RsAvailable Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildSchedule object.
     *
     * @param  ChildSchedule $v
     * @return $this|\BossEdu\Model\RsAvailable The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSchedule(ChildSchedule $v = null)
    {
        if ($v === null) {
            $this->setWeekday(NULL);
        } else {
            $this->setWeekday($v->getWeekday());
        }

        if ($v === null) {
            $this->setStartTime(NULL);
        } else {
            $this->setStartTime($v->getStartTime());
        }

        if ($v === null) {
            $this->setEndTime(NULL);
        } else {
            $this->setEndTime($v->getEndTime());
        }

        $this->aSchedule = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSchedule object, it will not be re-added.
        if ($v !== null) {
            $v->addRsAvailable($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSchedule object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSchedule The associated ChildSchedule object.
     * @throws PropelException
     */
    public function getSchedule(ConnectionInterface $con = null)
    {
        if ($this->aSchedule === null && ($this->weekday !== null && ($this->start_time !== "" && $this->start_time !== null) && ($this->end_time !== "" && $this->end_time !== null))) {
            $this->aSchedule = ChildScheduleQuery::create()->findPk(array($this->weekday, $this->start_time, $this->end_time), $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSchedule->addRsAvailables($this);
             */
        }

        return $this->aSchedule;
    }

    /**
     * Declares an association between this object and a ChildRoom object.
     *
     * @param  ChildRoom $v
     * @return $this|\BossEdu\Model\RsAvailable The current object (for fluent API support)
     * @throws PropelException
     */
    public function setRoom(ChildRoom $v = null)
    {
        if ($v === null) {
            $this->setBuildingCode(NULL);
        } else {
            $this->setBuildingCode($v->getBuildingCode());
        }

        if ($v === null) {
            $this->setRoomNumber(NULL);
        } else {
            $this->setRoomNumber($v->getNumber());
        }

        $this->aRoom = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildRoom object, it will not be re-added.
        if ($v !== null) {
            $v->addRsAvailable($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildRoom object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildRoom The associated ChildRoom object.
     * @throws PropelException
     */
    public function getRoom(ConnectionInterface $con = null)
    {
        if ($this->aRoom === null && (($this->building_code !== "" && $this->building_code !== null) && $this->room_number !== null)) {
            $this->aRoom = ChildRoomQuery::create()->findPk(array($this->building_code, $this->room_number), $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aRoom->addRsAvailables($this);
             */
        }

        return $this->aRoom;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('IsrLink' == $relationName) {
            return $this->initIsrLinks();
        }
    }

    /**
     * Clears out the collIsrLinks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addIsrLinks()
     */
    public function clearIsrLinks()
    {
        $this->collIsrLinks = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collIsrLinks collection loaded partially.
     */
    public function resetPartialIsrLinks($v = true)
    {
        $this->collIsrLinksPartial = $v;
    }

    /**
     * Initializes the collIsrLinks collection.
     *
     * By default this just sets the collIsrLinks collection to an empty array (like clearcollIsrLinks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initIsrLinks($overrideExisting = true)
    {
        if (null !== $this->collIsrLinks && !$overrideExisting) {
            return;
        }

        $collectionClassName = IsrLinkTableMap::getTableMap()->getCollectionClassName();

        $this->collIsrLinks = new $collectionClassName;
        $this->collIsrLinks->setModel('\BossEdu\Model\IsrLink');
    }

    /**
     * Gets an array of ChildIsrLink objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRsAvailable is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildIsrLink[] List of ChildIsrLink objects
     * @throws PropelException
     */
    public function getIsrLinks(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collIsrLinksPartial && !$this->isNew();
        if (null === $this->collIsrLinks || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collIsrLinks) {
                // return empty collection
                $this->initIsrLinks();
            } else {
                $collIsrLinks = ChildIsrLinkQuery::create(null, $criteria)
                    ->filterByRsAvailable($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collIsrLinksPartial && count($collIsrLinks)) {
                        $this->initIsrLinks(false);

                        foreach ($collIsrLinks as $obj) {
                            if (false == $this->collIsrLinks->contains($obj)) {
                                $this->collIsrLinks->append($obj);
                            }
                        }

                        $this->collIsrLinksPartial = true;
                    }

                    return $collIsrLinks;
                }

                if ($partial && $this->collIsrLinks) {
                    foreach ($this->collIsrLinks as $obj) {
                        if ($obj->isNew()) {
                            $collIsrLinks[] = $obj;
                        }
                    }
                }

                $this->collIsrLinks = $collIsrLinks;
                $this->collIsrLinksPartial = false;
            }
        }

        return $this->collIsrLinks;
    }

    /**
     * Sets a collection of ChildIsrLink objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $isrLinks A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildRsAvailable The current object (for fluent API support)
     */
    public function setIsrLinks(Collection $isrLinks, ConnectionInterface $con = null)
    {
        /** @var ChildIsrLink[] $isrLinksToDelete */
        $isrLinksToDelete = $this->getIsrLinks(new Criteria(), $con)->diff($isrLinks);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->isrLinksScheduledForDeletion = clone $isrLinksToDelete;

        foreach ($isrLinksToDelete as $isrLinkRemoved) {
            $isrLinkRemoved->setRsAvailable(null);
        }

        $this->collIsrLinks = null;
        foreach ($isrLinks as $isrLink) {
            $this->addIsrLink($isrLink);
        }

        $this->collIsrLinks = $isrLinks;
        $this->collIsrLinksPartial = false;

        return $this;
    }

    /**
     * Returns the number of related IsrLink objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related IsrLink objects.
     * @throws PropelException
     */
    public function countIsrLinks(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collIsrLinksPartial && !$this->isNew();
        if (null === $this->collIsrLinks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collIsrLinks) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getIsrLinks());
            }

            $query = ChildIsrLinkQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRsAvailable($this)
                ->count($con);
        }

        return count($this->collIsrLinks);
    }

    /**
     * Method called to associate a ChildIsrLink object to this object
     * through the ChildIsrLink foreign key attribute.
     *
     * @param  ChildIsrLink $l ChildIsrLink
     * @return $this|\BossEdu\Model\RsAvailable The current object (for fluent API support)
     */
    public function addIsrLink(ChildIsrLink $l)
    {
        if ($this->collIsrLinks === null) {
            $this->initIsrLinks();
            $this->collIsrLinksPartial = true;
        }

        if (!$this->collIsrLinks->contains($l)) {
            $this->doAddIsrLink($l);

            if ($this->isrLinksScheduledForDeletion and $this->isrLinksScheduledForDeletion->contains($l)) {
                $this->isrLinksScheduledForDeletion->remove($this->isrLinksScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildIsrLink $isrLink The ChildIsrLink object to add.
     */
    protected function doAddIsrLink(ChildIsrLink $isrLink)
    {
        $this->collIsrLinks[]= $isrLink;
        $isrLink->setRsAvailable($this);
    }

    /**
     * @param  ChildIsrLink $isrLink The ChildIsrLink object to remove.
     * @return $this|ChildRsAvailable The current object (for fluent API support)
     */
    public function removeIsrLink(ChildIsrLink $isrLink)
    {
        if ($this->getIsrLinks()->contains($isrLink)) {
            $pos = $this->collIsrLinks->search($isrLink);
            $this->collIsrLinks->remove($pos);
            if (null === $this->isrLinksScheduledForDeletion) {
                $this->isrLinksScheduledForDeletion = clone $this->collIsrLinks;
                $this->isrLinksScheduledForDeletion->clear();
            }
            $this->isrLinksScheduledForDeletion[]= clone $isrLink;
            $isrLink->setRsAvailable(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this RsAvailable is new, it will return
     * an empty collection; or if this RsAvailable has previously
     * been saved, it will retrieve related IsrLinks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in RsAvailable.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildIsrLink[] List of ChildIsrLink objects
     */
    public function getIsrLinksJoinInstruction(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildIsrLinkQuery::create(null, $criteria);
        $query->joinWith('Instruction', $joinBehavior);

        return $this->getIsrLinks($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aSchedule) {
            $this->aSchedule->removeRsAvailable($this);
        }
        if (null !== $this->aRoom) {
            $this->aRoom->removeRsAvailable($this);
        }
        $this->building_code = null;
        $this->room_number = null;
        $this->weekday = null;
        $this->start_time = null;
        $this->end_time = null;
        $this->start_date = null;
        $this->end_date = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collIsrLinks) {
                foreach ($this->collIsrLinks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collIsrLinks = null;
        $this->aSchedule = null;
        $this->aRoom = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(RsAvailableTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
