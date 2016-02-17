<?php

namespace BossEdu\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use BossEdu\Model\RsAvailable as ChildRsAvailable;
use BossEdu\Model\RsAvailableQuery as ChildRsAvailableQuery;
use BossEdu\Model\Schedule as ChildSchedule;
use BossEdu\Model\ScheduleQuery as ChildScheduleQuery;
use BossEdu\Model\Map\RsAvailableTableMap;
use BossEdu\Model\Map\ScheduleTableMap;
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
 * Base class that represents a row from the 'schedule' table.
 *
 * 
 *
* @package    propel.generator.BossEdu.Model.Base
*/
abstract class Schedule implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\BossEdu\\Model\\Map\\ScheduleTableMap';


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
     * @var        ObjectCollection|ChildRsAvailable[] Collection to store aggregation of ChildRsAvailable objects.
     */
    protected $collRsAvailables;
    protected $collRsAvailablesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRsAvailable[]
     */
    protected $rsAvailablesScheduledForDeletion = null;

    /**
     * Initializes internal state of BossEdu\Model\Base\Schedule object.
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
     * Compares this with another <code>Schedule</code> instance.  If
     * <code>obj</code> is an instance of <code>Schedule</code>, delegates to
     * <code>equals(Schedule)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Schedule The current object, for fluid interface
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
     * Set the value of [weekday] column.
     * 
     * @param int $v new value
     * @return $this|\BossEdu\Model\Schedule The current object (for fluent API support)
     */
    public function setWeekday($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->weekday !== $v) {
            $this->weekday = $v;
            $this->modifiedColumns[ScheduleTableMap::COL_WEEKDAY] = true;
        }

        return $this;
    } // setWeekday()

    /**
     * Sets the value of [start_time] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\BossEdu\Model\Schedule The current object (for fluent API support)
     */
    public function setStartTime($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->start_time !== null || $dt !== null) {
            if ($this->start_time === null || $dt === null || $dt->format("H:i:s") !== $this->start_time->format("H:i:s")) {
                $this->start_time = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ScheduleTableMap::COL_START_TIME] = true;
            }
        } // if either are not null

        return $this;
    } // setStartTime()

    /**
     * Sets the value of [end_time] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\BossEdu\Model\Schedule The current object (for fluent API support)
     */
    public function setEndTime($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->end_time !== null || $dt !== null) {
            if ($this->end_time === null || $dt === null || $dt->format("H:i:s") !== $this->end_time->format("H:i:s")) {
                $this->end_time = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ScheduleTableMap::COL_END_TIME] = true;
            }
        } // if either are not null

        return $this;
    } // setEndTime()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ScheduleTableMap::translateFieldName('Weekday', TableMap::TYPE_PHPNAME, $indexType)];
            $this->weekday = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ScheduleTableMap::translateFieldName('StartTime', TableMap::TYPE_PHPNAME, $indexType)];
            $this->start_time = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ScheduleTableMap::translateFieldName('EndTime', TableMap::TYPE_PHPNAME, $indexType)];
            $this->end_time = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = ScheduleTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\BossEdu\\Model\\Schedule'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(ScheduleTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildScheduleQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collRsAvailables = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Schedule::setDeleted()
     * @see Schedule::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ScheduleTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildScheduleQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ScheduleTableMap::DATABASE_NAME);
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
                ScheduleTableMap::addInstanceToPool($this);
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

            if ($this->rsAvailablesScheduledForDeletion !== null) {
                if (!$this->rsAvailablesScheduledForDeletion->isEmpty()) {
                    \BossEdu\Model\RsAvailableQuery::create()
                        ->filterByPrimaryKeys($this->rsAvailablesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rsAvailablesScheduledForDeletion = null;
                }
            }

            if ($this->collRsAvailables !== null) {
                foreach ($this->collRsAvailables as $referrerFK) {
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
        if ($this->isColumnModified(ScheduleTableMap::COL_WEEKDAY)) {
            $modifiedColumns[':p' . $index++]  = 'weekday';
        }
        if ($this->isColumnModified(ScheduleTableMap::COL_START_TIME)) {
            $modifiedColumns[':p' . $index++]  = 'start_time';
        }
        if ($this->isColumnModified(ScheduleTableMap::COL_END_TIME)) {
            $modifiedColumns[':p' . $index++]  = 'end_time';
        }

        $sql = sprintf(
            'INSERT INTO schedule (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'weekday':                        
                        $stmt->bindValue($identifier, $this->weekday, PDO::PARAM_INT);
                        break;
                    case 'start_time':                        
                        $stmt->bindValue($identifier, $this->start_time ? $this->start_time->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'end_time':                        
                        $stmt->bindValue($identifier, $this->end_time ? $this->end_time->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
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
        $pos = ScheduleTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getWeekday();
                break;
            case 1:
                return $this->getStartTime();
                break;
            case 2:
                return $this->getEndTime();
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

        if (isset($alreadyDumpedObjects['Schedule'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Schedule'][$this->hashCode()] = true;
        $keys = ScheduleTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getWeekday(),
            $keys[1] => $this->getStartTime(),
            $keys[2] => $this->getEndTime(),
        );
        if ($result[$keys[1]] instanceof \DateTime) {
            $result[$keys[1]] = $result[$keys[1]]->format('c');
        }
        
        if ($result[$keys[2]] instanceof \DateTime) {
            $result[$keys[2]] = $result[$keys[2]]->format('c');
        }
        
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->collRsAvailables) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rsAvailables';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'rs_availables';
                        break;
                    default:
                        $key = 'RsAvailables';
                }
        
                $result[$key] = $this->collRsAvailables->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\BossEdu\Model\Schedule
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ScheduleTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\BossEdu\Model\Schedule
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setWeekday($value);
                break;
            case 1:
                $this->setStartTime($value);
                break;
            case 2:
                $this->setEndTime($value);
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
        $keys = ScheduleTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setWeekday($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setStartTime($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setEndTime($arr[$keys[2]]);
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
     * @return $this|\BossEdu\Model\Schedule The current object, for fluid interface
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
        $criteria = new Criteria(ScheduleTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ScheduleTableMap::COL_WEEKDAY)) {
            $criteria->add(ScheduleTableMap::COL_WEEKDAY, $this->weekday);
        }
        if ($this->isColumnModified(ScheduleTableMap::COL_START_TIME)) {
            $criteria->add(ScheduleTableMap::COL_START_TIME, $this->start_time);
        }
        if ($this->isColumnModified(ScheduleTableMap::COL_END_TIME)) {
            $criteria->add(ScheduleTableMap::COL_END_TIME, $this->end_time);
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
        $criteria = ChildScheduleQuery::create();
        $criteria->add(ScheduleTableMap::COL_WEEKDAY, $this->weekday);
        $criteria->add(ScheduleTableMap::COL_START_TIME, $this->start_time);
        $criteria->add(ScheduleTableMap::COL_END_TIME, $this->end_time);

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
        $validPk = null !== $this->getWeekday() &&
            null !== $this->getStartTime() &&
            null !== $this->getEndTime();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

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
        $pks[0] = $this->getWeekday();
        $pks[1] = $this->getStartTime();
        $pks[2] = $this->getEndTime();

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
        $this->setWeekday($keys[0]);
        $this->setStartTime($keys[1]);
        $this->setEndTime($keys[2]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return (null === $this->getWeekday()) && (null === $this->getStartTime()) && (null === $this->getEndTime());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \BossEdu\Model\Schedule (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setWeekday($this->getWeekday());
        $copyObj->setStartTime($this->getStartTime());
        $copyObj->setEndTime($this->getEndTime());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getRsAvailables() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRsAvailable($relObj->copy($deepCopy));
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
     * @return \BossEdu\Model\Schedule Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('RsAvailable' == $relationName) {
            return $this->initRsAvailables();
        }
    }

    /**
     * Clears out the collRsAvailables collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRsAvailables()
     */
    public function clearRsAvailables()
    {
        $this->collRsAvailables = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRsAvailables collection loaded partially.
     */
    public function resetPartialRsAvailables($v = true)
    {
        $this->collRsAvailablesPartial = $v;
    }

    /**
     * Initializes the collRsAvailables collection.
     *
     * By default this just sets the collRsAvailables collection to an empty array (like clearcollRsAvailables());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRsAvailables($overrideExisting = true)
    {
        if (null !== $this->collRsAvailables && !$overrideExisting) {
            return;
        }

        $collectionClassName = RsAvailableTableMap::getTableMap()->getCollectionClassName();

        $this->collRsAvailables = new $collectionClassName;
        $this->collRsAvailables->setModel('\BossEdu\Model\RsAvailable');
    }

    /**
     * Gets an array of ChildRsAvailable objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSchedule is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRsAvailable[] List of ChildRsAvailable objects
     * @throws PropelException
     */
    public function getRsAvailables(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRsAvailablesPartial && !$this->isNew();
        if (null === $this->collRsAvailables || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRsAvailables) {
                // return empty collection
                $this->initRsAvailables();
            } else {
                $collRsAvailables = ChildRsAvailableQuery::create(null, $criteria)
                    ->filterBySchedule($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRsAvailablesPartial && count($collRsAvailables)) {
                        $this->initRsAvailables(false);

                        foreach ($collRsAvailables as $obj) {
                            if (false == $this->collRsAvailables->contains($obj)) {
                                $this->collRsAvailables->append($obj);
                            }
                        }

                        $this->collRsAvailablesPartial = true;
                    }

                    return $collRsAvailables;
                }

                if ($partial && $this->collRsAvailables) {
                    foreach ($this->collRsAvailables as $obj) {
                        if ($obj->isNew()) {
                            $collRsAvailables[] = $obj;
                        }
                    }
                }

                $this->collRsAvailables = $collRsAvailables;
                $this->collRsAvailablesPartial = false;
            }
        }

        return $this->collRsAvailables;
    }

    /**
     * Sets a collection of ChildRsAvailable objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rsAvailables A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSchedule The current object (for fluent API support)
     */
    public function setRsAvailables(Collection $rsAvailables, ConnectionInterface $con = null)
    {
        /** @var ChildRsAvailable[] $rsAvailablesToDelete */
        $rsAvailablesToDelete = $this->getRsAvailables(new Criteria(), $con)->diff($rsAvailables);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rsAvailablesScheduledForDeletion = clone $rsAvailablesToDelete;

        foreach ($rsAvailablesToDelete as $rsAvailableRemoved) {
            $rsAvailableRemoved->setSchedule(null);
        }

        $this->collRsAvailables = null;
        foreach ($rsAvailables as $rsAvailable) {
            $this->addRsAvailable($rsAvailable);
        }

        $this->collRsAvailables = $rsAvailables;
        $this->collRsAvailablesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RsAvailable objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RsAvailable objects.
     * @throws PropelException
     */
    public function countRsAvailables(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRsAvailablesPartial && !$this->isNew();
        if (null === $this->collRsAvailables || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRsAvailables) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRsAvailables());
            }

            $query = ChildRsAvailableQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySchedule($this)
                ->count($con);
        }

        return count($this->collRsAvailables);
    }

    /**
     * Method called to associate a ChildRsAvailable object to this object
     * through the ChildRsAvailable foreign key attribute.
     *
     * @param  ChildRsAvailable $l ChildRsAvailable
     * @return $this|\BossEdu\Model\Schedule The current object (for fluent API support)
     */
    public function addRsAvailable(ChildRsAvailable $l)
    {
        if ($this->collRsAvailables === null) {
            $this->initRsAvailables();
            $this->collRsAvailablesPartial = true;
        }

        if (!$this->collRsAvailables->contains($l)) {
            $this->doAddRsAvailable($l);

            if ($this->rsAvailablesScheduledForDeletion and $this->rsAvailablesScheduledForDeletion->contains($l)) {
                $this->rsAvailablesScheduledForDeletion->remove($this->rsAvailablesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRsAvailable $rsAvailable The ChildRsAvailable object to add.
     */
    protected function doAddRsAvailable(ChildRsAvailable $rsAvailable)
    {
        $this->collRsAvailables[]= $rsAvailable;
        $rsAvailable->setSchedule($this);
    }

    /**
     * @param  ChildRsAvailable $rsAvailable The ChildRsAvailable object to remove.
     * @return $this|ChildSchedule The current object (for fluent API support)
     */
    public function removeRsAvailable(ChildRsAvailable $rsAvailable)
    {
        if ($this->getRsAvailables()->contains($rsAvailable)) {
            $pos = $this->collRsAvailables->search($rsAvailable);
            $this->collRsAvailables->remove($pos);
            if (null === $this->rsAvailablesScheduledForDeletion) {
                $this->rsAvailablesScheduledForDeletion = clone $this->collRsAvailables;
                $this->rsAvailablesScheduledForDeletion->clear();
            }
            $this->rsAvailablesScheduledForDeletion[]= clone $rsAvailable;
            $rsAvailable->setSchedule(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Schedule is new, it will return
     * an empty collection; or if this Schedule has previously
     * been saved, it will retrieve related RsAvailables from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Schedule.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRsAvailable[] List of ChildRsAvailable objects
     */
    public function getRsAvailablesJoinRoom(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRsAvailableQuery::create(null, $criteria);
        $query->joinWith('Room', $joinBehavior);

        return $this->getRsAvailables($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->weekday = null;
        $this->start_time = null;
        $this->end_time = null;
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
            if ($this->collRsAvailables) {
                foreach ($this->collRsAvailables as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collRsAvailables = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ScheduleTableMap::DEFAULT_STRING_FORMAT);
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
