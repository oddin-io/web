<?php

namespace BossEdu\Model\Base;

use \Exception;
use \PDO;
use BossEdu\Model\ElHave as ChildElHave;
use BossEdu\Model\ElHaveQuery as ChildElHaveQuery;
use BossEdu\Model\Event as ChildEvent;
use BossEdu\Model\EventQuery as ChildEventQuery;
use BossEdu\Model\Instruction as ChildInstruction;
use BossEdu\Model\InstructionQuery as ChildInstructionQuery;
use BossEdu\Model\Lecture as ChildLecture;
use BossEdu\Model\LectureQuery as ChildLectureQuery;
use BossEdu\Model\Map\ElHaveTableMap;
use BossEdu\Model\Map\InstructionTableMap;
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
 * Base class that represents a row from the 'el_have' table.
 *
 * 
 *
* @package    propel.generator.BossEdu.Model.Base
*/
abstract class ElHave implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\BossEdu\\Model\\Map\\ElHaveTableMap';


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
     * The value for the event_code field.
     * 
     * @var        string
     */
    protected $event_code;

    /**
     * The value for the lecture_code field.
     * 
     * @var        string
     */
    protected $lecture_code;

    /**
     * @var        ChildEvent
     */
    protected $aEvent;

    /**
     * @var        ChildLecture
     */
    protected $aLecture;

    /**
     * @var        ObjectCollection|ChildInstruction[] Collection to store aggregation of ChildInstruction objects.
     */
    protected $collInstructions;
    protected $collInstructionsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildInstruction[]
     */
    protected $instructionsScheduledForDeletion = null;

    /**
     * Initializes internal state of BossEdu\Model\Base\ElHave object.
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
     * Compares this with another <code>ElHave</code> instance.  If
     * <code>obj</code> is an instance of <code>ElHave</code>, delegates to
     * <code>equals(ElHave)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|ElHave The current object, for fluid interface
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
     * Get the [event_code] column value.
     * 
     * @return string
     */
    public function getEventCode()
    {
        return $this->event_code;
    }

    /**
     * Get the [lecture_code] column value.
     * 
     * @return string
     */
    public function getLectureCode()
    {
        return $this->lecture_code;
    }

    /**
     * Set the value of [event_code] column.
     * 
     * @param string $v new value
     * @return $this|\BossEdu\Model\ElHave The current object (for fluent API support)
     */
    public function setEventCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->event_code !== $v) {
            $this->event_code = $v;
            $this->modifiedColumns[ElHaveTableMap::COL_EVENT_CODE] = true;
        }

        if ($this->aEvent !== null && $this->aEvent->getCode() !== $v) {
            $this->aEvent = null;
        }

        return $this;
    } // setEventCode()

    /**
     * Set the value of [lecture_code] column.
     * 
     * @param string $v new value
     * @return $this|\BossEdu\Model\ElHave The current object (for fluent API support)
     */
    public function setLectureCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->lecture_code !== $v) {
            $this->lecture_code = $v;
            $this->modifiedColumns[ElHaveTableMap::COL_LECTURE_CODE] = true;
        }

        if ($this->aLecture !== null && $this->aLecture->getCode() !== $v) {
            $this->aLecture = null;
        }

        return $this;
    } // setLectureCode()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ElHaveTableMap::translateFieldName('EventCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->event_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ElHaveTableMap::translateFieldName('LectureCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lecture_code = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 2; // 2 = ElHaveTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\BossEdu\\Model\\ElHave'), 0, $e);
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
        if ($this->aEvent !== null && $this->event_code !== $this->aEvent->getCode()) {
            $this->aEvent = null;
        }
        if ($this->aLecture !== null && $this->lecture_code !== $this->aLecture->getCode()) {
            $this->aLecture = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(ElHaveTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildElHaveQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aEvent = null;
            $this->aLecture = null;
            $this->collInstructions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see ElHave::setDeleted()
     * @see ElHave::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ElHaveTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildElHaveQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ElHaveTableMap::DATABASE_NAME);
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
                ElHaveTableMap::addInstanceToPool($this);
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

            if ($this->aEvent !== null) {
                if ($this->aEvent->isModified() || $this->aEvent->isNew()) {
                    $affectedRows += $this->aEvent->save($con);
                }
                $this->setEvent($this->aEvent);
            }

            if ($this->aLecture !== null) {
                if ($this->aLecture->isModified() || $this->aLecture->isNew()) {
                    $affectedRows += $this->aLecture->save($con);
                }
                $this->setLecture($this->aLecture);
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

            if ($this->instructionsScheduledForDeletion !== null) {
                if (!$this->instructionsScheduledForDeletion->isEmpty()) {
                    \BossEdu\Model\InstructionQuery::create()
                        ->filterByPrimaryKeys($this->instructionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->instructionsScheduledForDeletion = null;
                }
            }

            if ($this->collInstructions !== null) {
                foreach ($this->collInstructions as $referrerFK) {
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
        if ($this->isColumnModified(ElHaveTableMap::COL_EVENT_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'event_code';
        }
        if ($this->isColumnModified(ElHaveTableMap::COL_LECTURE_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'lecture_code';
        }

        $sql = sprintf(
            'INSERT INTO el_have (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'event_code':                        
                        $stmt->bindValue($identifier, $this->event_code, PDO::PARAM_STR);
                        break;
                    case 'lecture_code':                        
                        $stmt->bindValue($identifier, $this->lecture_code, PDO::PARAM_STR);
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
        $pos = ElHaveTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getEventCode();
                break;
            case 1:
                return $this->getLectureCode();
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

        if (isset($alreadyDumpedObjects['ElHave'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['ElHave'][$this->hashCode()] = true;
        $keys = ElHaveTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getEventCode(),
            $keys[1] => $this->getLectureCode(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aEvent) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'event';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'event';
                        break;
                    default:
                        $key = 'Event';
                }
        
                $result[$key] = $this->aEvent->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aLecture) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'lecture';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'lecture';
                        break;
                    default:
                        $key = 'Lecture';
                }
        
                $result[$key] = $this->aLecture->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collInstructions) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'instructions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'instructions';
                        break;
                    default:
                        $key = 'Instructions';
                }
        
                $result[$key] = $this->collInstructions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\BossEdu\Model\ElHave
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ElHaveTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\BossEdu\Model\ElHave
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setEventCode($value);
                break;
            case 1:
                $this->setLectureCode($value);
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
        $keys = ElHaveTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setEventCode($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setLectureCode($arr[$keys[1]]);
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
     * @return $this|\BossEdu\Model\ElHave The current object, for fluid interface
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
        $criteria = new Criteria(ElHaveTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ElHaveTableMap::COL_EVENT_CODE)) {
            $criteria->add(ElHaveTableMap::COL_EVENT_CODE, $this->event_code);
        }
        if ($this->isColumnModified(ElHaveTableMap::COL_LECTURE_CODE)) {
            $criteria->add(ElHaveTableMap::COL_LECTURE_CODE, $this->lecture_code);
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
        $criteria = ChildElHaveQuery::create();
        $criteria->add(ElHaveTableMap::COL_EVENT_CODE, $this->event_code);
        $criteria->add(ElHaveTableMap::COL_LECTURE_CODE, $this->lecture_code);

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
        $validPk = null !== $this->getEventCode() &&
            null !== $this->getLectureCode();

        $validPrimaryKeyFKs = 2;
        $primaryKeyFKs = [];

        //relation el_have_event_fk to table event
        if ($this->aEvent && $hash = spl_object_hash($this->aEvent)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

        //relation el_have_lecture_fk to table lecture
        if ($this->aLecture && $hash = spl_object_hash($this->aLecture)) {
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
        $pks[0] = $this->getEventCode();
        $pks[1] = $this->getLectureCode();

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
        $this->setEventCode($keys[0]);
        $this->setLectureCode($keys[1]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return (null === $this->getEventCode()) && (null === $this->getLectureCode());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \BossEdu\Model\ElHave (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setEventCode($this->getEventCode());
        $copyObj->setLectureCode($this->getLectureCode());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getInstructions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addInstruction($relObj->copy($deepCopy));
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
     * @return \BossEdu\Model\ElHave Clone of current object.
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
     * Declares an association between this object and a ChildEvent object.
     *
     * @param  ChildEvent $v
     * @return $this|\BossEdu\Model\ElHave The current object (for fluent API support)
     * @throws PropelException
     */
    public function setEvent(ChildEvent $v = null)
    {
        if ($v === null) {
            $this->setEventCode(NULL);
        } else {
            $this->setEventCode($v->getCode());
        }

        $this->aEvent = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildEvent object, it will not be re-added.
        if ($v !== null) {
            $v->addElHave($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildEvent object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildEvent The associated ChildEvent object.
     * @throws PropelException
     */
    public function getEvent(ConnectionInterface $con = null)
    {
        if ($this->aEvent === null && (($this->event_code !== "" && $this->event_code !== null))) {
            $this->aEvent = ChildEventQuery::create()->findPk($this->event_code, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aEvent->addElHaves($this);
             */
        }

        return $this->aEvent;
    }

    /**
     * Declares an association between this object and a ChildLecture object.
     *
     * @param  ChildLecture $v
     * @return $this|\BossEdu\Model\ElHave The current object (for fluent API support)
     * @throws PropelException
     */
    public function setLecture(ChildLecture $v = null)
    {
        if ($v === null) {
            $this->setLectureCode(NULL);
        } else {
            $this->setLectureCode($v->getCode());
        }

        $this->aLecture = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildLecture object, it will not be re-added.
        if ($v !== null) {
            $v->addElHave($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildLecture object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildLecture The associated ChildLecture object.
     * @throws PropelException
     */
    public function getLecture(ConnectionInterface $con = null)
    {
        if ($this->aLecture === null && (($this->lecture_code !== "" && $this->lecture_code !== null))) {
            $this->aLecture = ChildLectureQuery::create()->findPk($this->lecture_code, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aLecture->addElHaves($this);
             */
        }

        return $this->aLecture;
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
        if ('Instruction' == $relationName) {
            return $this->initInstructions();
        }
    }

    /**
     * Clears out the collInstructions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addInstructions()
     */
    public function clearInstructions()
    {
        $this->collInstructions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collInstructions collection loaded partially.
     */
    public function resetPartialInstructions($v = true)
    {
        $this->collInstructionsPartial = $v;
    }

    /**
     * Initializes the collInstructions collection.
     *
     * By default this just sets the collInstructions collection to an empty array (like clearcollInstructions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initInstructions($overrideExisting = true)
    {
        if (null !== $this->collInstructions && !$overrideExisting) {
            return;
        }

        $collectionClassName = InstructionTableMap::getTableMap()->getCollectionClassName();

        $this->collInstructions = new $collectionClassName;
        $this->collInstructions->setModel('\BossEdu\Model\Instruction');
    }

    /**
     * Gets an array of ChildInstruction objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildElHave is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildInstruction[] List of ChildInstruction objects
     * @throws PropelException
     */
    public function getInstructions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collInstructionsPartial && !$this->isNew();
        if (null === $this->collInstructions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collInstructions) {
                // return empty collection
                $this->initInstructions();
            } else {
                $collInstructions = ChildInstructionQuery::create(null, $criteria)
                    ->filterByElHave($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collInstructionsPartial && count($collInstructions)) {
                        $this->initInstructions(false);

                        foreach ($collInstructions as $obj) {
                            if (false == $this->collInstructions->contains($obj)) {
                                $this->collInstructions->append($obj);
                            }
                        }

                        $this->collInstructionsPartial = true;
                    }

                    return $collInstructions;
                }

                if ($partial && $this->collInstructions) {
                    foreach ($this->collInstructions as $obj) {
                        if ($obj->isNew()) {
                            $collInstructions[] = $obj;
                        }
                    }
                }

                $this->collInstructions = $collInstructions;
                $this->collInstructionsPartial = false;
            }
        }

        return $this->collInstructions;
    }

    /**
     * Sets a collection of ChildInstruction objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $instructions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildElHave The current object (for fluent API support)
     */
    public function setInstructions(Collection $instructions, ConnectionInterface $con = null)
    {
        /** @var ChildInstruction[] $instructionsToDelete */
        $instructionsToDelete = $this->getInstructions(new Criteria(), $con)->diff($instructions);

        
        $this->instructionsScheduledForDeletion = $instructionsToDelete;

        foreach ($instructionsToDelete as $instructionRemoved) {
            $instructionRemoved->setElHave(null);
        }

        $this->collInstructions = null;
        foreach ($instructions as $instruction) {
            $this->addInstruction($instruction);
        }

        $this->collInstructions = $instructions;
        $this->collInstructionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Instruction objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Instruction objects.
     * @throws PropelException
     */
    public function countInstructions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collInstructionsPartial && !$this->isNew();
        if (null === $this->collInstructions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collInstructions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getInstructions());
            }

            $query = ChildInstructionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByElHave($this)
                ->count($con);
        }

        return count($this->collInstructions);
    }

    /**
     * Method called to associate a ChildInstruction object to this object
     * through the ChildInstruction foreign key attribute.
     *
     * @param  ChildInstruction $l ChildInstruction
     * @return $this|\BossEdu\Model\ElHave The current object (for fluent API support)
     */
    public function addInstruction(ChildInstruction $l)
    {
        if ($this->collInstructions === null) {
            $this->initInstructions();
            $this->collInstructionsPartial = true;
        }

        if (!$this->collInstructions->contains($l)) {
            $this->doAddInstruction($l);

            if ($this->instructionsScheduledForDeletion and $this->instructionsScheduledForDeletion->contains($l)) {
                $this->instructionsScheduledForDeletion->remove($this->instructionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildInstruction $instruction The ChildInstruction object to add.
     */
    protected function doAddInstruction(ChildInstruction $instruction)
    {
        $this->collInstructions[]= $instruction;
        $instruction->setElHave($this);
    }

    /**
     * @param  ChildInstruction $instruction The ChildInstruction object to remove.
     * @return $this|ChildElHave The current object (for fluent API support)
     */
    public function removeInstruction(ChildInstruction $instruction)
    {
        if ($this->getInstructions()->contains($instruction)) {
            $pos = $this->collInstructions->search($instruction);
            $this->collInstructions->remove($pos);
            if (null === $this->instructionsScheduledForDeletion) {
                $this->instructionsScheduledForDeletion = clone $this->collInstructions;
                $this->instructionsScheduledForDeletion->clear();
            }
            $this->instructionsScheduledForDeletion[]= clone $instruction;
            $instruction->setElHave(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aEvent) {
            $this->aEvent->removeElHave($this);
        }
        if (null !== $this->aLecture) {
            $this->aLecture->removeElHave($this);
        }
        $this->event_code = null;
        $this->lecture_code = null;
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
            if ($this->collInstructions) {
                foreach ($this->collInstructions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collInstructions = null;
        $this->aEvent = null;
        $this->aLecture = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ElHaveTableMap::DEFAULT_STRING_FORMAT);
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
