<?php

namespace BossEdu\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use BossEdu\Model\ElHave as ChildElHave;
use BossEdu\Model\ElHaveQuery as ChildElHaveQuery;
use BossEdu\Model\Instruction as ChildInstruction;
use BossEdu\Model\InstructionQuery as ChildInstructionQuery;
use BossEdu\Model\IsrLink as ChildIsrLink;
use BossEdu\Model\IsrLinkQuery as ChildIsrLinkQuery;
use BossEdu\Model\MiMaterial as ChildMiMaterial;
use BossEdu\Model\MiMaterialQuery as ChildMiMaterialQuery;
use BossEdu\Model\Person as ChildPerson;
use BossEdu\Model\PersonQuery as ChildPersonQuery;
use BossEdu\Model\PiLink as ChildPiLink;
use BossEdu\Model\PiLinkQuery as ChildPiLinkQuery;
use BossEdu\Model\Presentation as ChildPresentation;
use BossEdu\Model\PresentationQuery as ChildPresentationQuery;
use BossEdu\Model\Map\InstructionTableMap;
use BossEdu\Model\Map\IsrLinkTableMap;
use BossEdu\Model\Map\MiMaterialTableMap;
use BossEdu\Model\Map\PersonTableMap;
use BossEdu\Model\Map\PiLinkTableMap;
use BossEdu\Model\Map\PresentationTableMap;
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
 * Base class that represents a row from the 'instruction' table.
 *
 * 
 *
* @package    propel.generator.BossEdu.Model.Base
*/
abstract class Instruction implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\BossEdu\\Model\\Map\\InstructionTableMap';


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
     * The value for the id field.
     * 
     * @var        int
     */
    protected $id;

    /**
     * The value for the class field.
     * 
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $class;

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
     * @var        ChildElHave
     */
    protected $aElHave;

    /**
     * @var        ObjectCollection|ChildPerson[] Collection to store aggregation of ChildPerson objects.
     */
    protected $collPeople;
    protected $collPeoplePartial;

    /**
     * @var        ObjectCollection|ChildPiLink[] Collection to store aggregation of ChildPiLink objects.
     */
    protected $collPiLinks;
    protected $collPiLinksPartial;

    /**
     * @var        ObjectCollection|ChildIsrLink[] Collection to store aggregation of ChildIsrLink objects.
     */
    protected $collIsrLinks;
    protected $collIsrLinksPartial;

    /**
     * @var        ObjectCollection|ChildMiMaterial[] Collection to store aggregation of ChildMiMaterial objects.
     */
    protected $collMiMaterials;
    protected $collMiMaterialsPartial;

    /**
     * @var        ObjectCollection|ChildPresentation[] Collection to store aggregation of ChildPresentation objects.
     */
    protected $collPresentations;
    protected $collPresentationsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPerson[]
     */
    protected $peopleScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPiLink[]
     */
    protected $piLinksScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildIsrLink[]
     */
    protected $isrLinksScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMiMaterial[]
     */
    protected $miMaterialsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPresentation[]
     */
    protected $presentationsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->class = 1;
    }

    /**
     * Initializes internal state of BossEdu\Model\Base\Instruction object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
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
     * Compares this with another <code>Instruction</code> instance.  If
     * <code>obj</code> is an instance of <code>Instruction</code>, delegates to
     * <code>equals(Instruction)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Instruction The current object, for fluid interface
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
     * Get the [id] column value.
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [class] column value.
     * 
     * @return int
     */
    public function getClass()
    {
        return $this->class;
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
     * Set the value of [id] column.
     * 
     * @param int $v new value
     * @return $this|\BossEdu\Model\Instruction The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[InstructionTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [class] column.
     * 
     * @param int $v new value
     * @return $this|\BossEdu\Model\Instruction The current object (for fluent API support)
     */
    public function setClass($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->class !== $v) {
            $this->class = $v;
            $this->modifiedColumns[InstructionTableMap::COL_CLASS] = true;
        }

        return $this;
    } // setClass()

    /**
     * Sets the value of [start_date] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\BossEdu\Model\Instruction The current object (for fluent API support)
     */
    public function setStartDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->start_date !== null || $dt !== null) {
            if ($this->start_date === null || $dt === null || $dt->format("Y-m-d") !== $this->start_date->format("Y-m-d")) {
                $this->start_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[InstructionTableMap::COL_START_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setStartDate()

    /**
     * Sets the value of [end_date] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\BossEdu\Model\Instruction The current object (for fluent API support)
     */
    public function setEndDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->end_date !== null || $dt !== null) {
            if ($this->end_date === null || $dt === null || $dt->format("Y-m-d") !== $this->end_date->format("Y-m-d")) {
                $this->end_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[InstructionTableMap::COL_END_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setEndDate()

    /**
     * Set the value of [event_code] column.
     * 
     * @param string $v new value
     * @return $this|\BossEdu\Model\Instruction The current object (for fluent API support)
     */
    public function setEventCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->event_code !== $v) {
            $this->event_code = $v;
            $this->modifiedColumns[InstructionTableMap::COL_EVENT_CODE] = true;
        }

        if ($this->aElHave !== null && $this->aElHave->getEventCode() !== $v) {
            $this->aElHave = null;
        }

        return $this;
    } // setEventCode()

    /**
     * Set the value of [lecture_code] column.
     * 
     * @param string $v new value
     * @return $this|\BossEdu\Model\Instruction The current object (for fluent API support)
     */
    public function setLectureCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->lecture_code !== $v) {
            $this->lecture_code = $v;
            $this->modifiedColumns[InstructionTableMap::COL_LECTURE_CODE] = true;
        }

        if ($this->aElHave !== null && $this->aElHave->getLectureCode() !== $v) {
            $this->aElHave = null;
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
            if ($this->class !== 1) {
                return false;
            }

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : InstructionTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : InstructionTableMap::translateFieldName('Class', TableMap::TYPE_PHPNAME, $indexType)];
            $this->class = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : InstructionTableMap::translateFieldName('StartDate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->start_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : InstructionTableMap::translateFieldName('EndDate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->end_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : InstructionTableMap::translateFieldName('EventCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->event_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : InstructionTableMap::translateFieldName('LectureCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lecture_code = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = InstructionTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\BossEdu\\Model\\Instruction'), 0, $e);
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
        if ($this->aElHave !== null && $this->event_code !== $this->aElHave->getEventCode()) {
            $this->aElHave = null;
        }
        if ($this->aElHave !== null && $this->lecture_code !== $this->aElHave->getLectureCode()) {
            $this->aElHave = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(InstructionTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildInstructionQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aElHave = null;
            $this->collPeople = null;

            $this->collPiLinks = null;

            $this->collIsrLinks = null;

            $this->collMiMaterials = null;

            $this->collPresentations = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Instruction::setDeleted()
     * @see Instruction::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(InstructionTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildInstructionQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(InstructionTableMap::DATABASE_NAME);
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
                InstructionTableMap::addInstanceToPool($this);
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

            if ($this->aElHave !== null) {
                if ($this->aElHave->isModified() || $this->aElHave->isNew()) {
                    $affectedRows += $this->aElHave->save($con);
                }
                $this->setElHave($this->aElHave);
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

            if ($this->peopleScheduledForDeletion !== null) {
                if (!$this->peopleScheduledForDeletion->isEmpty()) {
                    foreach ($this->peopleScheduledForDeletion as $person) {
                        // need to save related object because we set the relation to null
                        $person->save($con);
                    }
                    $this->peopleScheduledForDeletion = null;
                }
            }

            if ($this->collPeople !== null) {
                foreach ($this->collPeople as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->piLinksScheduledForDeletion !== null) {
                if (!$this->piLinksScheduledForDeletion->isEmpty()) {
                    \BossEdu\Model\PiLinkQuery::create()
                        ->filterByPrimaryKeys($this->piLinksScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->piLinksScheduledForDeletion = null;
                }
            }

            if ($this->collPiLinks !== null) {
                foreach ($this->collPiLinks as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
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

            if ($this->miMaterialsScheduledForDeletion !== null) {
                if (!$this->miMaterialsScheduledForDeletion->isEmpty()) {
                    \BossEdu\Model\MiMaterialQuery::create()
                        ->filterByPrimaryKeys($this->miMaterialsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->miMaterialsScheduledForDeletion = null;
                }
            }

            if ($this->collMiMaterials !== null) {
                foreach ($this->collMiMaterials as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->presentationsScheduledForDeletion !== null) {
                if (!$this->presentationsScheduledForDeletion->isEmpty()) {
                    \BossEdu\Model\PresentationQuery::create()
                        ->filterByPrimaryKeys($this->presentationsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->presentationsScheduledForDeletion = null;
                }
            }

            if ($this->collPresentations !== null) {
                foreach ($this->collPresentations as $referrerFK) {
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

        $this->modifiedColumns[InstructionTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . InstructionTableMap::COL_ID . ')');
        }
        if (null === $this->id) {
            try {                
                $dataFetcher = $con->query("SELECT nextval('instruction_id_seq')");
                $this->id = $dataFetcher->fetchColumn();
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', 0, $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(InstructionTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(InstructionTableMap::COL_CLASS)) {
            $modifiedColumns[':p' . $index++]  = 'class';
        }
        if ($this->isColumnModified(InstructionTableMap::COL_START_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'start_date';
        }
        if ($this->isColumnModified(InstructionTableMap::COL_END_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'end_date';
        }
        if ($this->isColumnModified(InstructionTableMap::COL_EVENT_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'event_code';
        }
        if ($this->isColumnModified(InstructionTableMap::COL_LECTURE_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'lecture_code';
        }

        $sql = sprintf(
            'INSERT INTO instruction (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':                        
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'class':                        
                        $stmt->bindValue($identifier, $this->class, PDO::PARAM_INT);
                        break;
                    case 'start_date':                        
                        $stmt->bindValue($identifier, $this->start_date ? $this->start_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'end_date':                        
                        $stmt->bindValue($identifier, $this->end_date ? $this->end_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
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
        $pos = InstructionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getId();
                break;
            case 1:
                return $this->getClass();
                break;
            case 2:
                return $this->getStartDate();
                break;
            case 3:
                return $this->getEndDate();
                break;
            case 4:
                return $this->getEventCode();
                break;
            case 5:
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

        if (isset($alreadyDumpedObjects['Instruction'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Instruction'][$this->hashCode()] = true;
        $keys = InstructionTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getClass(),
            $keys[2] => $this->getStartDate(),
            $keys[3] => $this->getEndDate(),
            $keys[4] => $this->getEventCode(),
            $keys[5] => $this->getLectureCode(),
        );
        if ($result[$keys[2]] instanceof \DateTime) {
            $result[$keys[2]] = $result[$keys[2]]->format('c');
        }
        
        if ($result[$keys[3]] instanceof \DateTime) {
            $result[$keys[3]] = $result[$keys[3]]->format('c');
        }
        
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aElHave) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'elHave';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'el_have';
                        break;
                    default:
                        $key = 'ElHave';
                }
        
                $result[$key] = $this->aElHave->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collPeople) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'people';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'people';
                        break;
                    default:
                        $key = 'People';
                }
        
                $result[$key] = $this->collPeople->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPiLinks) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'piLinks';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'pi_links';
                        break;
                    default:
                        $key = 'PiLinks';
                }
        
                $result[$key] = $this->collPiLinks->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
            if (null !== $this->collMiMaterials) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'miMaterials';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'mi_materials';
                        break;
                    default:
                        $key = 'MiMaterials';
                }
        
                $result[$key] = $this->collMiMaterials->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPresentations) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'presentations';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'presentations';
                        break;
                    default:
                        $key = 'Presentations';
                }
        
                $result[$key] = $this->collPresentations->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\BossEdu\Model\Instruction
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = InstructionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\BossEdu\Model\Instruction
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setClass($value);
                break;
            case 2:
                $this->setStartDate($value);
                break;
            case 3:
                $this->setEndDate($value);
                break;
            case 4:
                $this->setEventCode($value);
                break;
            case 5:
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
        $keys = InstructionTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setClass($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setStartDate($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setEndDate($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setEventCode($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setLectureCode($arr[$keys[5]]);
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
     * @return $this|\BossEdu\Model\Instruction The current object, for fluid interface
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
        $criteria = new Criteria(InstructionTableMap::DATABASE_NAME);

        if ($this->isColumnModified(InstructionTableMap::COL_ID)) {
            $criteria->add(InstructionTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(InstructionTableMap::COL_CLASS)) {
            $criteria->add(InstructionTableMap::COL_CLASS, $this->class);
        }
        if ($this->isColumnModified(InstructionTableMap::COL_START_DATE)) {
            $criteria->add(InstructionTableMap::COL_START_DATE, $this->start_date);
        }
        if ($this->isColumnModified(InstructionTableMap::COL_END_DATE)) {
            $criteria->add(InstructionTableMap::COL_END_DATE, $this->end_date);
        }
        if ($this->isColumnModified(InstructionTableMap::COL_EVENT_CODE)) {
            $criteria->add(InstructionTableMap::COL_EVENT_CODE, $this->event_code);
        }
        if ($this->isColumnModified(InstructionTableMap::COL_LECTURE_CODE)) {
            $criteria->add(InstructionTableMap::COL_LECTURE_CODE, $this->lecture_code);
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
        $criteria = ChildInstructionQuery::create();
        $criteria->add(InstructionTableMap::COL_ID, $this->id);

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
        $validPk = null !== $this->getId();

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
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \BossEdu\Model\Instruction (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setClass($this->getClass());
        $copyObj->setStartDate($this->getStartDate());
        $copyObj->setEndDate($this->getEndDate());
        $copyObj->setEventCode($this->getEventCode());
        $copyObj->setLectureCode($this->getLectureCode());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPeople() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPerson($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPiLinks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPiLink($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getIsrLinks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addIsrLink($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMiMaterials() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMiMaterial($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPresentations() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPresentation($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \BossEdu\Model\Instruction Clone of current object.
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
     * Declares an association between this object and a ChildElHave object.
     *
     * @param  ChildElHave $v
     * @return $this|\BossEdu\Model\Instruction The current object (for fluent API support)
     * @throws PropelException
     */
    public function setElHave(ChildElHave $v = null)
    {
        if ($v === null) {
            $this->setEventCode(NULL);
        } else {
            $this->setEventCode($v->getEventCode());
        }

        if ($v === null) {
            $this->setLectureCode(NULL);
        } else {
            $this->setLectureCode($v->getLectureCode());
        }

        $this->aElHave = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildElHave object, it will not be re-added.
        if ($v !== null) {
            $v->addInstruction($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildElHave object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildElHave The associated ChildElHave object.
     * @throws PropelException
     */
    public function getElHave(ConnectionInterface $con = null)
    {
        if ($this->aElHave === null && (($this->event_code !== "" && $this->event_code !== null) && ($this->lecture_code !== "" && $this->lecture_code !== null))) {
            $this->aElHave = ChildElHaveQuery::create()->findPk(array($this->event_code, $this->lecture_code), $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aElHave->addInstructions($this);
             */
        }

        return $this->aElHave;
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
        if ('Person' == $relationName) {
            return $this->initPeople();
        }
        if ('PiLink' == $relationName) {
            return $this->initPiLinks();
        }
        if ('IsrLink' == $relationName) {
            return $this->initIsrLinks();
        }
        if ('MiMaterial' == $relationName) {
            return $this->initMiMaterials();
        }
        if ('Presentation' == $relationName) {
            return $this->initPresentations();
        }
    }

    /**
     * Clears out the collPeople collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPeople()
     */
    public function clearPeople()
    {
        $this->collPeople = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPeople collection loaded partially.
     */
    public function resetPartialPeople($v = true)
    {
        $this->collPeoplePartial = $v;
    }

    /**
     * Initializes the collPeople collection.
     *
     * By default this just sets the collPeople collection to an empty array (like clearcollPeople());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPeople($overrideExisting = true)
    {
        if (null !== $this->collPeople && !$overrideExisting) {
            return;
        }

        $collectionClassName = PersonTableMap::getTableMap()->getCollectionClassName();

        $this->collPeople = new $collectionClassName;
        $this->collPeople->setModel('\BossEdu\Model\Person');
    }

    /**
     * Gets an array of ChildPerson objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildInstruction is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPerson[] List of ChildPerson objects
     * @throws PropelException
     */
    public function getPeople(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPeoplePartial && !$this->isNew();
        if (null === $this->collPeople || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPeople) {
                // return empty collection
                $this->initPeople();
            } else {
                $collPeople = ChildPersonQuery::create(null, $criteria)
                    ->filterByInstruction($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPeoplePartial && count($collPeople)) {
                        $this->initPeople(false);

                        foreach ($collPeople as $obj) {
                            if (false == $this->collPeople->contains($obj)) {
                                $this->collPeople->append($obj);
                            }
                        }

                        $this->collPeoplePartial = true;
                    }

                    return $collPeople;
                }

                if ($partial && $this->collPeople) {
                    foreach ($this->collPeople as $obj) {
                        if ($obj->isNew()) {
                            $collPeople[] = $obj;
                        }
                    }
                }

                $this->collPeople = $collPeople;
                $this->collPeoplePartial = false;
            }
        }

        return $this->collPeople;
    }

    /**
     * Sets a collection of ChildPerson objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $people A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildInstruction The current object (for fluent API support)
     */
    public function setPeople(Collection $people, ConnectionInterface $con = null)
    {
        /** @var ChildPerson[] $peopleToDelete */
        $peopleToDelete = $this->getPeople(new Criteria(), $con)->diff($people);

        
        $this->peopleScheduledForDeletion = $peopleToDelete;

        foreach ($peopleToDelete as $personRemoved) {
            $personRemoved->setInstruction(null);
        }

        $this->collPeople = null;
        foreach ($people as $person) {
            $this->addPerson($person);
        }

        $this->collPeople = $people;
        $this->collPeoplePartial = false;

        return $this;
    }

    /**
     * Returns the number of related Person objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Person objects.
     * @throws PropelException
     */
    public function countPeople(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPeoplePartial && !$this->isNew();
        if (null === $this->collPeople || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPeople) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPeople());
            }

            $query = ChildPersonQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByInstruction($this)
                ->count($con);
        }

        return count($this->collPeople);
    }

    /**
     * Method called to associate a ChildPerson object to this object
     * through the ChildPerson foreign key attribute.
     *
     * @param  ChildPerson $l ChildPerson
     * @return $this|\BossEdu\Model\Instruction The current object (for fluent API support)
     */
    public function addPerson(ChildPerson $l)
    {
        if ($this->collPeople === null) {
            $this->initPeople();
            $this->collPeoplePartial = true;
        }

        if (!$this->collPeople->contains($l)) {
            $this->doAddPerson($l);

            if ($this->peopleScheduledForDeletion and $this->peopleScheduledForDeletion->contains($l)) {
                $this->peopleScheduledForDeletion->remove($this->peopleScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPerson $person The ChildPerson object to add.
     */
    protected function doAddPerson(ChildPerson $person)
    {
        $this->collPeople[]= $person;
        $person->setInstruction($this);
    }

    /**
     * @param  ChildPerson $person The ChildPerson object to remove.
     * @return $this|ChildInstruction The current object (for fluent API support)
     */
    public function removePerson(ChildPerson $person)
    {
        if ($this->getPeople()->contains($person)) {
            $pos = $this->collPeople->search($person);
            $this->collPeople->remove($pos);
            if (null === $this->peopleScheduledForDeletion) {
                $this->peopleScheduledForDeletion = clone $this->collPeople;
                $this->peopleScheduledForDeletion->clear();
            }
            $this->peopleScheduledForDeletion[]= $person;
            $person->setInstruction(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Instruction is new, it will return
     * an empty collection; or if this Instruction has previously
     * been saved, it will retrieve related People from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Instruction.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPerson[] List of ChildPerson objects
     */
    public function getPeopleJoinSomeone(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPersonQuery::create(null, $criteria);
        $query->joinWith('Someone', $joinBehavior);

        return $this->getPeople($query, $con);
    }

    /**
     * Clears out the collPiLinks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPiLinks()
     */
    public function clearPiLinks()
    {
        $this->collPiLinks = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPiLinks collection loaded partially.
     */
    public function resetPartialPiLinks($v = true)
    {
        $this->collPiLinksPartial = $v;
    }

    /**
     * Initializes the collPiLinks collection.
     *
     * By default this just sets the collPiLinks collection to an empty array (like clearcollPiLinks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPiLinks($overrideExisting = true)
    {
        if (null !== $this->collPiLinks && !$overrideExisting) {
            return;
        }

        $collectionClassName = PiLinkTableMap::getTableMap()->getCollectionClassName();

        $this->collPiLinks = new $collectionClassName;
        $this->collPiLinks->setModel('\BossEdu\Model\PiLink');
    }

    /**
     * Gets an array of ChildPiLink objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildInstruction is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPiLink[] List of ChildPiLink objects
     * @throws PropelException
     */
    public function getPiLinks(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPiLinksPartial && !$this->isNew();
        if (null === $this->collPiLinks || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPiLinks) {
                // return empty collection
                $this->initPiLinks();
            } else {
                $collPiLinks = ChildPiLinkQuery::create(null, $criteria)
                    ->filterByInstruction($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPiLinksPartial && count($collPiLinks)) {
                        $this->initPiLinks(false);

                        foreach ($collPiLinks as $obj) {
                            if (false == $this->collPiLinks->contains($obj)) {
                                $this->collPiLinks->append($obj);
                            }
                        }

                        $this->collPiLinksPartial = true;
                    }

                    return $collPiLinks;
                }

                if ($partial && $this->collPiLinks) {
                    foreach ($this->collPiLinks as $obj) {
                        if ($obj->isNew()) {
                            $collPiLinks[] = $obj;
                        }
                    }
                }

                $this->collPiLinks = $collPiLinks;
                $this->collPiLinksPartial = false;
            }
        }

        return $this->collPiLinks;
    }

    /**
     * Sets a collection of ChildPiLink objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $piLinks A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildInstruction The current object (for fluent API support)
     */
    public function setPiLinks(Collection $piLinks, ConnectionInterface $con = null)
    {
        /** @var ChildPiLink[] $piLinksToDelete */
        $piLinksToDelete = $this->getPiLinks(new Criteria(), $con)->diff($piLinks);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->piLinksScheduledForDeletion = clone $piLinksToDelete;

        foreach ($piLinksToDelete as $piLinkRemoved) {
            $piLinkRemoved->setInstruction(null);
        }

        $this->collPiLinks = null;
        foreach ($piLinks as $piLink) {
            $this->addPiLink($piLink);
        }

        $this->collPiLinks = $piLinks;
        $this->collPiLinksPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PiLink objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PiLink objects.
     * @throws PropelException
     */
    public function countPiLinks(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPiLinksPartial && !$this->isNew();
        if (null === $this->collPiLinks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPiLinks) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPiLinks());
            }

            $query = ChildPiLinkQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByInstruction($this)
                ->count($con);
        }

        return count($this->collPiLinks);
    }

    /**
     * Method called to associate a ChildPiLink object to this object
     * through the ChildPiLink foreign key attribute.
     *
     * @param  ChildPiLink $l ChildPiLink
     * @return $this|\BossEdu\Model\Instruction The current object (for fluent API support)
     */
    public function addPiLink(ChildPiLink $l)
    {
        if ($this->collPiLinks === null) {
            $this->initPiLinks();
            $this->collPiLinksPartial = true;
        }

        if (!$this->collPiLinks->contains($l)) {
            $this->doAddPiLink($l);

            if ($this->piLinksScheduledForDeletion and $this->piLinksScheduledForDeletion->contains($l)) {
                $this->piLinksScheduledForDeletion->remove($this->piLinksScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPiLink $piLink The ChildPiLink object to add.
     */
    protected function doAddPiLink(ChildPiLink $piLink)
    {
        $this->collPiLinks[]= $piLink;
        $piLink->setInstruction($this);
    }

    /**
     * @param  ChildPiLink $piLink The ChildPiLink object to remove.
     * @return $this|ChildInstruction The current object (for fluent API support)
     */
    public function removePiLink(ChildPiLink $piLink)
    {
        if ($this->getPiLinks()->contains($piLink)) {
            $pos = $this->collPiLinks->search($piLink);
            $this->collPiLinks->remove($pos);
            if (null === $this->piLinksScheduledForDeletion) {
                $this->piLinksScheduledForDeletion = clone $this->collPiLinks;
                $this->piLinksScheduledForDeletion->clear();
            }
            $this->piLinksScheduledForDeletion[]= clone $piLink;
            $piLink->setInstruction(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Instruction is new, it will return
     * an empty collection; or if this Instruction has previously
     * been saved, it will retrieve related PiLinks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Instruction.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPiLink[] List of ChildPiLink objects
     */
    public function getPiLinksJoinPerson(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPiLinkQuery::create(null, $criteria);
        $query->joinWith('Person', $joinBehavior);

        return $this->getPiLinks($query, $con);
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
     * If this ChildInstruction is new, it will return
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
                    ->filterByInstruction($this)
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
     * @return $this|ChildInstruction The current object (for fluent API support)
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
            $isrLinkRemoved->setInstruction(null);
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
                ->filterByInstruction($this)
                ->count($con);
        }

        return count($this->collIsrLinks);
    }

    /**
     * Method called to associate a ChildIsrLink object to this object
     * through the ChildIsrLink foreign key attribute.
     *
     * @param  ChildIsrLink $l ChildIsrLink
     * @return $this|\BossEdu\Model\Instruction The current object (for fluent API support)
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
        $isrLink->setInstruction($this);
    }

    /**
     * @param  ChildIsrLink $isrLink The ChildIsrLink object to remove.
     * @return $this|ChildInstruction The current object (for fluent API support)
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
            $isrLink->setInstruction(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Instruction is new, it will return
     * an empty collection; or if this Instruction has previously
     * been saved, it will retrieve related IsrLinks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Instruction.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildIsrLink[] List of ChildIsrLink objects
     */
    public function getIsrLinksJoinRsAvailable(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildIsrLinkQuery::create(null, $criteria);
        $query->joinWith('RsAvailable', $joinBehavior);

        return $this->getIsrLinks($query, $con);
    }

    /**
     * Clears out the collMiMaterials collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMiMaterials()
     */
    public function clearMiMaterials()
    {
        $this->collMiMaterials = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collMiMaterials collection loaded partially.
     */
    public function resetPartialMiMaterials($v = true)
    {
        $this->collMiMaterialsPartial = $v;
    }

    /**
     * Initializes the collMiMaterials collection.
     *
     * By default this just sets the collMiMaterials collection to an empty array (like clearcollMiMaterials());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMiMaterials($overrideExisting = true)
    {
        if (null !== $this->collMiMaterials && !$overrideExisting) {
            return;
        }

        $collectionClassName = MiMaterialTableMap::getTableMap()->getCollectionClassName();

        $this->collMiMaterials = new $collectionClassName;
        $this->collMiMaterials->setModel('\BossEdu\Model\MiMaterial');
    }

    /**
     * Gets an array of ChildMiMaterial objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildInstruction is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildMiMaterial[] List of ChildMiMaterial objects
     * @throws PropelException
     */
    public function getMiMaterials(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMiMaterialsPartial && !$this->isNew();
        if (null === $this->collMiMaterials || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMiMaterials) {
                // return empty collection
                $this->initMiMaterials();
            } else {
                $collMiMaterials = ChildMiMaterialQuery::create(null, $criteria)
                    ->filterByInstruction($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collMiMaterialsPartial && count($collMiMaterials)) {
                        $this->initMiMaterials(false);

                        foreach ($collMiMaterials as $obj) {
                            if (false == $this->collMiMaterials->contains($obj)) {
                                $this->collMiMaterials->append($obj);
                            }
                        }

                        $this->collMiMaterialsPartial = true;
                    }

                    return $collMiMaterials;
                }

                if ($partial && $this->collMiMaterials) {
                    foreach ($this->collMiMaterials as $obj) {
                        if ($obj->isNew()) {
                            $collMiMaterials[] = $obj;
                        }
                    }
                }

                $this->collMiMaterials = $collMiMaterials;
                $this->collMiMaterialsPartial = false;
            }
        }

        return $this->collMiMaterials;
    }

    /**
     * Sets a collection of ChildMiMaterial objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $miMaterials A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildInstruction The current object (for fluent API support)
     */
    public function setMiMaterials(Collection $miMaterials, ConnectionInterface $con = null)
    {
        /** @var ChildMiMaterial[] $miMaterialsToDelete */
        $miMaterialsToDelete = $this->getMiMaterials(new Criteria(), $con)->diff($miMaterials);

        
        $this->miMaterialsScheduledForDeletion = $miMaterialsToDelete;

        foreach ($miMaterialsToDelete as $miMaterialRemoved) {
            $miMaterialRemoved->setInstruction(null);
        }

        $this->collMiMaterials = null;
        foreach ($miMaterials as $miMaterial) {
            $this->addMiMaterial($miMaterial);
        }

        $this->collMiMaterials = $miMaterials;
        $this->collMiMaterialsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related MiMaterial objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related MiMaterial objects.
     * @throws PropelException
     */
    public function countMiMaterials(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMiMaterialsPartial && !$this->isNew();
        if (null === $this->collMiMaterials || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMiMaterials) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMiMaterials());
            }

            $query = ChildMiMaterialQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByInstruction($this)
                ->count($con);
        }

        return count($this->collMiMaterials);
    }

    /**
     * Method called to associate a ChildMiMaterial object to this object
     * through the ChildMiMaterial foreign key attribute.
     *
     * @param  ChildMiMaterial $l ChildMiMaterial
     * @return $this|\BossEdu\Model\Instruction The current object (for fluent API support)
     */
    public function addMiMaterial(ChildMiMaterial $l)
    {
        if ($this->collMiMaterials === null) {
            $this->initMiMaterials();
            $this->collMiMaterialsPartial = true;
        }

        if (!$this->collMiMaterials->contains($l)) {
            $this->doAddMiMaterial($l);

            if ($this->miMaterialsScheduledForDeletion and $this->miMaterialsScheduledForDeletion->contains($l)) {
                $this->miMaterialsScheduledForDeletion->remove($this->miMaterialsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildMiMaterial $miMaterial The ChildMiMaterial object to add.
     */
    protected function doAddMiMaterial(ChildMiMaterial $miMaterial)
    {
        $this->collMiMaterials[]= $miMaterial;
        $miMaterial->setInstruction($this);
    }

    /**
     * @param  ChildMiMaterial $miMaterial The ChildMiMaterial object to remove.
     * @return $this|ChildInstruction The current object (for fluent API support)
     */
    public function removeMiMaterial(ChildMiMaterial $miMaterial)
    {
        if ($this->getMiMaterials()->contains($miMaterial)) {
            $pos = $this->collMiMaterials->search($miMaterial);
            $this->collMiMaterials->remove($pos);
            if (null === $this->miMaterialsScheduledForDeletion) {
                $this->miMaterialsScheduledForDeletion = clone $this->collMiMaterials;
                $this->miMaterialsScheduledForDeletion->clear();
            }
            $this->miMaterialsScheduledForDeletion[]= clone $miMaterial;
            $miMaterial->setInstruction(null);
        }

        return $this;
    }

    /**
     * Clears out the collPresentations collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPresentations()
     */
    public function clearPresentations()
    {
        $this->collPresentations = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPresentations collection loaded partially.
     */
    public function resetPartialPresentations($v = true)
    {
        $this->collPresentationsPartial = $v;
    }

    /**
     * Initializes the collPresentations collection.
     *
     * By default this just sets the collPresentations collection to an empty array (like clearcollPresentations());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPresentations($overrideExisting = true)
    {
        if (null !== $this->collPresentations && !$overrideExisting) {
            return;
        }

        $collectionClassName = PresentationTableMap::getTableMap()->getCollectionClassName();

        $this->collPresentations = new $collectionClassName;
        $this->collPresentations->setModel('\BossEdu\Model\Presentation');
    }

    /**
     * Gets an array of ChildPresentation objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildInstruction is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPresentation[] List of ChildPresentation objects
     * @throws PropelException
     */
    public function getPresentations(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPresentationsPartial && !$this->isNew();
        if (null === $this->collPresentations || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPresentations) {
                // return empty collection
                $this->initPresentations();
            } else {
                $collPresentations = ChildPresentationQuery::create(null, $criteria)
                    ->filterByInstruction($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPresentationsPartial && count($collPresentations)) {
                        $this->initPresentations(false);

                        foreach ($collPresentations as $obj) {
                            if (false == $this->collPresentations->contains($obj)) {
                                $this->collPresentations->append($obj);
                            }
                        }

                        $this->collPresentationsPartial = true;
                    }

                    return $collPresentations;
                }

                if ($partial && $this->collPresentations) {
                    foreach ($this->collPresentations as $obj) {
                        if ($obj->isNew()) {
                            $collPresentations[] = $obj;
                        }
                    }
                }

                $this->collPresentations = $collPresentations;
                $this->collPresentationsPartial = false;
            }
        }

        return $this->collPresentations;
    }

    /**
     * Sets a collection of ChildPresentation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $presentations A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildInstruction The current object (for fluent API support)
     */
    public function setPresentations(Collection $presentations, ConnectionInterface $con = null)
    {
        /** @var ChildPresentation[] $presentationsToDelete */
        $presentationsToDelete = $this->getPresentations(new Criteria(), $con)->diff($presentations);

        
        $this->presentationsScheduledForDeletion = $presentationsToDelete;

        foreach ($presentationsToDelete as $presentationRemoved) {
            $presentationRemoved->setInstruction(null);
        }

        $this->collPresentations = null;
        foreach ($presentations as $presentation) {
            $this->addPresentation($presentation);
        }

        $this->collPresentations = $presentations;
        $this->collPresentationsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Presentation objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Presentation objects.
     * @throws PropelException
     */
    public function countPresentations(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPresentationsPartial && !$this->isNew();
        if (null === $this->collPresentations || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPresentations) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPresentations());
            }

            $query = ChildPresentationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByInstruction($this)
                ->count($con);
        }

        return count($this->collPresentations);
    }

    /**
     * Method called to associate a ChildPresentation object to this object
     * through the ChildPresentation foreign key attribute.
     *
     * @param  ChildPresentation $l ChildPresentation
     * @return $this|\BossEdu\Model\Instruction The current object (for fluent API support)
     */
    public function addPresentation(ChildPresentation $l)
    {
        if ($this->collPresentations === null) {
            $this->initPresentations();
            $this->collPresentationsPartial = true;
        }

        if (!$this->collPresentations->contains($l)) {
            $this->doAddPresentation($l);

            if ($this->presentationsScheduledForDeletion and $this->presentationsScheduledForDeletion->contains($l)) {
                $this->presentationsScheduledForDeletion->remove($this->presentationsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPresentation $presentation The ChildPresentation object to add.
     */
    protected function doAddPresentation(ChildPresentation $presentation)
    {
        $this->collPresentations[]= $presentation;
        $presentation->setInstruction($this);
    }

    /**
     * @param  ChildPresentation $presentation The ChildPresentation object to remove.
     * @return $this|ChildInstruction The current object (for fluent API support)
     */
    public function removePresentation(ChildPresentation $presentation)
    {
        if ($this->getPresentations()->contains($presentation)) {
            $pos = $this->collPresentations->search($presentation);
            $this->collPresentations->remove($pos);
            if (null === $this->presentationsScheduledForDeletion) {
                $this->presentationsScheduledForDeletion = clone $this->collPresentations;
                $this->presentationsScheduledForDeletion->clear();
            }
            $this->presentationsScheduledForDeletion[]= clone $presentation;
            $presentation->setInstruction(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Instruction is new, it will return
     * an empty collection; or if this Instruction has previously
     * been saved, it will retrieve related Presentations from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Instruction.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPresentation[] List of ChildPresentation objects
     */
    public function getPresentationsJoinPerson(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPresentationQuery::create(null, $criteria);
        $query->joinWith('Person', $joinBehavior);

        return $this->getPresentations($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aElHave) {
            $this->aElHave->removeInstruction($this);
        }
        $this->id = null;
        $this->class = null;
        $this->start_date = null;
        $this->end_date = null;
        $this->event_code = null;
        $this->lecture_code = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
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
            if ($this->collPeople) {
                foreach ($this->collPeople as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPiLinks) {
                foreach ($this->collPiLinks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collIsrLinks) {
                foreach ($this->collIsrLinks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMiMaterials) {
                foreach ($this->collMiMaterials as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPresentations) {
                foreach ($this->collPresentations as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collPeople = null;
        $this->collPiLinks = null;
        $this->collIsrLinks = null;
        $this->collMiMaterials = null;
        $this->collPresentations = null;
        $this->aElHave = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(InstructionTableMap::DEFAULT_STRING_FORMAT);
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
