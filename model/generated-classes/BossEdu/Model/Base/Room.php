<?php

namespace BossEdu\Model\Base;

use \Exception;
use \PDO;
use BossEdu\Model\Building as ChildBuilding;
use BossEdu\Model\BuildingQuery as ChildBuildingQuery;
use BossEdu\Model\Room as ChildRoom;
use BossEdu\Model\RoomQuery as ChildRoomQuery;
use BossEdu\Model\RsAvailable as ChildRsAvailable;
use BossEdu\Model\RsAvailableQuery as ChildRsAvailableQuery;
use BossEdu\Model\Map\RoomTableMap;
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

/**
 * Base class that represents a row from the 'room' table.
 *
 * 
 *
* @package    propel.generator.BossEdu.Model.Base
*/
abstract class Room implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\BossEdu\\Model\\Map\\RoomTableMap';


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
     * The value for the number field.
     * 
     * @var        int
     */
    protected $number;

    /**
     * The value for the type field.
     * 
     * @var        string
     */
    protected $type;

    /**
     * The value for the capacity field.
     * 
     * @var        int
     */
    protected $capacity;

    /**
     * @var        ChildBuilding
     */
    protected $aBuilding;

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
     * Initializes internal state of BossEdu\Model\Base\Room object.
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
     * Compares this with another <code>Room</code> instance.  If
     * <code>obj</code> is an instance of <code>Room</code>, delegates to
     * <code>equals(Room)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Room The current object, for fluid interface
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
     * Get the [number] column value.
     * 
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Get the [type] column value.
     * 
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the [capacity] column value.
     * 
     * @return int
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Set the value of [building_code] column.
     * 
     * @param string $v new value
     * @return $this|\BossEdu\Model\Room The current object (for fluent API support)
     */
    public function setBuildingCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->building_code !== $v) {
            $this->building_code = $v;
            $this->modifiedColumns[RoomTableMap::COL_BUILDING_CODE] = true;
        }

        if ($this->aBuilding !== null && $this->aBuilding->getCode() !== $v) {
            $this->aBuilding = null;
        }

        return $this;
    } // setBuildingCode()

    /**
     * Set the value of [number] column.
     * 
     * @param int $v new value
     * @return $this|\BossEdu\Model\Room The current object (for fluent API support)
     */
    public function setNumber($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->number !== $v) {
            $this->number = $v;
            $this->modifiedColumns[RoomTableMap::COL_NUMBER] = true;
        }

        return $this;
    } // setNumber()

    /**
     * Set the value of [type] column.
     * 
     * @param string $v new value
     * @return $this|\BossEdu\Model\Room The current object (for fluent API support)
     */
    public function setType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[RoomTableMap::COL_TYPE] = true;
        }

        return $this;
    } // setType()

    /**
     * Set the value of [capacity] column.
     * 
     * @param int $v new value
     * @return $this|\BossEdu\Model\Room The current object (for fluent API support)
     */
    public function setCapacity($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->capacity !== $v) {
            $this->capacity = $v;
            $this->modifiedColumns[RoomTableMap::COL_CAPACITY] = true;
        }

        return $this;
    } // setCapacity()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : RoomTableMap::translateFieldName('BuildingCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->building_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : RoomTableMap::translateFieldName('Number', TableMap::TYPE_PHPNAME, $indexType)];
            $this->number = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : RoomTableMap::translateFieldName('Type', TableMap::TYPE_PHPNAME, $indexType)];
            $this->type = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : RoomTableMap::translateFieldName('Capacity', TableMap::TYPE_PHPNAME, $indexType)];
            $this->capacity = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = RoomTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\BossEdu\\Model\\Room'), 0, $e);
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
        if ($this->aBuilding !== null && $this->building_code !== $this->aBuilding->getCode()) {
            $this->aBuilding = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(RoomTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildRoomQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aBuilding = null;
            $this->collRsAvailables = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Room::setDeleted()
     * @see Room::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(RoomTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildRoomQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(RoomTableMap::DATABASE_NAME);
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
                RoomTableMap::addInstanceToPool($this);
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

            if ($this->aBuilding !== null) {
                if ($this->aBuilding->isModified() || $this->aBuilding->isNew()) {
                    $affectedRows += $this->aBuilding->save($con);
                }
                $this->setBuilding($this->aBuilding);
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
        if ($this->isColumnModified(RoomTableMap::COL_BUILDING_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'building_code';
        }
        if ($this->isColumnModified(RoomTableMap::COL_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'number';
        }
        if ($this->isColumnModified(RoomTableMap::COL_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'type';
        }
        if ($this->isColumnModified(RoomTableMap::COL_CAPACITY)) {
            $modifiedColumns[':p' . $index++]  = 'capacity';
        }

        $sql = sprintf(
            'INSERT INTO room (%s) VALUES (%s)',
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
                    case 'number':                        
                        $stmt->bindValue($identifier, $this->number, PDO::PARAM_INT);
                        break;
                    case 'type':                        
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_STR);
                        break;
                    case 'capacity':                        
                        $stmt->bindValue($identifier, $this->capacity, PDO::PARAM_INT);
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
        $pos = RoomTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getNumber();
                break;
            case 2:
                return $this->getType();
                break;
            case 3:
                return $this->getCapacity();
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

        if (isset($alreadyDumpedObjects['Room'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Room'][$this->hashCode()] = true;
        $keys = RoomTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getBuildingCode(),
            $keys[1] => $this->getNumber(),
            $keys[2] => $this->getType(),
            $keys[3] => $this->getCapacity(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aBuilding) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'building';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'building';
                        break;
                    default:
                        $key = 'Building';
                }
        
                $result[$key] = $this->aBuilding->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
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
     * @return $this|\BossEdu\Model\Room
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = RoomTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\BossEdu\Model\Room
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setBuildingCode($value);
                break;
            case 1:
                $this->setNumber($value);
                break;
            case 2:
                $this->setType($value);
                break;
            case 3:
                $this->setCapacity($value);
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
        $keys = RoomTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setBuildingCode($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setNumber($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setType($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCapacity($arr[$keys[3]]);
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
     * @return $this|\BossEdu\Model\Room The current object, for fluid interface
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
        $criteria = new Criteria(RoomTableMap::DATABASE_NAME);

        if ($this->isColumnModified(RoomTableMap::COL_BUILDING_CODE)) {
            $criteria->add(RoomTableMap::COL_BUILDING_CODE, $this->building_code);
        }
        if ($this->isColumnModified(RoomTableMap::COL_NUMBER)) {
            $criteria->add(RoomTableMap::COL_NUMBER, $this->number);
        }
        if ($this->isColumnModified(RoomTableMap::COL_TYPE)) {
            $criteria->add(RoomTableMap::COL_TYPE, $this->type);
        }
        if ($this->isColumnModified(RoomTableMap::COL_CAPACITY)) {
            $criteria->add(RoomTableMap::COL_CAPACITY, $this->capacity);
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
        $criteria = ChildRoomQuery::create();
        $criteria->add(RoomTableMap::COL_BUILDING_CODE, $this->building_code);
        $criteria->add(RoomTableMap::COL_NUMBER, $this->number);

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
            null !== $this->getNumber();

        $validPrimaryKeyFKs = 1;
        $primaryKeyFKs = [];

        //relation room_building_fk to table building
        if ($this->aBuilding && $hash = spl_object_hash($this->aBuilding)) {
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
        $pks[1] = $this->getNumber();

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
        $this->setNumber($keys[1]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return (null === $this->getBuildingCode()) && (null === $this->getNumber());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \BossEdu\Model\Room (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setBuildingCode($this->getBuildingCode());
        $copyObj->setNumber($this->getNumber());
        $copyObj->setType($this->getType());
        $copyObj->setCapacity($this->getCapacity());

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
     * @return \BossEdu\Model\Room Clone of current object.
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
     * Declares an association between this object and a ChildBuilding object.
     *
     * @param  ChildBuilding $v
     * @return $this|\BossEdu\Model\Room The current object (for fluent API support)
     * @throws PropelException
     */
    public function setBuilding(ChildBuilding $v = null)
    {
        if ($v === null) {
            $this->setBuildingCode(NULL);
        } else {
            $this->setBuildingCode($v->getCode());
        }

        $this->aBuilding = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildBuilding object, it will not be re-added.
        if ($v !== null) {
            $v->addRoom($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildBuilding object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildBuilding The associated ChildBuilding object.
     * @throws PropelException
     */
    public function getBuilding(ConnectionInterface $con = null)
    {
        if ($this->aBuilding === null && (($this->building_code !== "" && $this->building_code !== null))) {
            $this->aBuilding = ChildBuildingQuery::create()->findPk($this->building_code, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aBuilding->addRooms($this);
             */
        }

        return $this->aBuilding;
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
     * If this ChildRoom is new, it will return
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
                    ->filterByRoom($this)
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
     * @return $this|ChildRoom The current object (for fluent API support)
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
            $rsAvailableRemoved->setRoom(null);
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
                ->filterByRoom($this)
                ->count($con);
        }

        return count($this->collRsAvailables);
    }

    /**
     * Method called to associate a ChildRsAvailable object to this object
     * through the ChildRsAvailable foreign key attribute.
     *
     * @param  ChildRsAvailable $l ChildRsAvailable
     * @return $this|\BossEdu\Model\Room The current object (for fluent API support)
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
        $rsAvailable->setRoom($this);
    }

    /**
     * @param  ChildRsAvailable $rsAvailable The ChildRsAvailable object to remove.
     * @return $this|ChildRoom The current object (for fluent API support)
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
            $rsAvailable->setRoom(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Room is new, it will return
     * an empty collection; or if this Room has previously
     * been saved, it will retrieve related RsAvailables from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Room.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRsAvailable[] List of ChildRsAvailable objects
     */
    public function getRsAvailablesJoinSchedule(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRsAvailableQuery::create(null, $criteria);
        $query->joinWith('Schedule', $joinBehavior);

        return $this->getRsAvailables($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aBuilding) {
            $this->aBuilding->removeRoom($this);
        }
        $this->building_code = null;
        $this->number = null;
        $this->type = null;
        $this->capacity = null;
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
        $this->aBuilding = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(RoomTableMap::DEFAULT_STRING_FORMAT);
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
