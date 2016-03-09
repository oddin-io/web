<?php

namespace BossEdu\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use BossEdu\Model\Doubt as ChildDoubt;
use BossEdu\Model\DoubtQuery as ChildDoubtQuery;
use BossEdu\Model\Instruction as ChildInstruction;
use BossEdu\Model\InstructionQuery as ChildInstructionQuery;
use BossEdu\Model\MpMaterial as ChildMpMaterial;
use BossEdu\Model\MpMaterialQuery as ChildMpMaterialQuery;
use BossEdu\Model\Person as ChildPerson;
use BossEdu\Model\PersonQuery as ChildPersonQuery;
use BossEdu\Model\Presentation as ChildPresentation;
use BossEdu\Model\PresentationQuery as ChildPresentationQuery;
use BossEdu\Model\Map\DoubtTableMap;
use BossEdu\Model\Map\MpMaterialTableMap;
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
 * Base class that represents a row from the 'presentation' table.
 *
 * 
 *
* @package    propel.generator.BossEdu.Model.Base
*/
abstract class Presentation implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\BossEdu\\Model\\Map\\PresentationTableMap';


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
     * The value for the status field.
     * 
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $status;

    /**
     * The value for the subject field.
     * 
     * Note: this column has a database default value of: 'Class X'
     * @var        string
     */
    protected $subject;

    /**
     * The value for the created_at field.
     * 
     * Note: this column has a database default value of: '2016-03-09 18:50:28'
     * @var        \DateTime
     */
    protected $created_at;

    /**
     * The value for the instruction_id field.
     * 
     * @var        int
     */
    protected $instruction_id;

    /**
     * The value for the person_id field.
     * 
     * @var        int
     */
    protected $person_id;

    /**
     * @var        ChildInstruction
     */
    protected $aInstruction;

    /**
     * @var        ChildPerson
     */
    protected $aPerson;

    /**
     * @var        ObjectCollection|ChildMpMaterial[] Collection to store aggregation of ChildMpMaterial objects.
     */
    protected $collMpMaterials;
    protected $collMpMaterialsPartial;

    /**
     * @var        ObjectCollection|ChildDoubt[] Collection to store aggregation of ChildDoubt objects.
     */
    protected $collDoubts;
    protected $collDoubtsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMpMaterial[]
     */
    protected $mpMaterialsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDoubt[]
     */
    protected $doubtsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->status = 0;
        $this->subject = 'Class X';
        $this->created_at = PropelDateTime::newInstance('2016-03-09 18:50:28', null, 'DateTime');
    }

    /**
     * Initializes internal state of BossEdu\Model\Base\Presentation object.
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
     * Compares this with another <code>Presentation</code> instance.  If
     * <code>obj</code> is an instance of <code>Presentation</code>, delegates to
     * <code>equals(Presentation)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Presentation The current object, for fluid interface
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
     * Get the [status] column value.
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the [subject] column value.
     * 
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->created_at;
        } else {
            return $this->created_at instanceof \DateTime ? $this->created_at->format($format) : null;
        }
    }

    /**
     * Get the [instruction_id] column value.
     * 
     * @return int
     */
    public function getInstructionId()
    {
        return $this->instruction_id;
    }

    /**
     * Get the [person_id] column value.
     * 
     * @return int
     */
    public function getPersonId()
    {
        return $this->person_id;
    }

    /**
     * Set the value of [id] column.
     * 
     * @param int $v new value
     * @return $this|\BossEdu\Model\Presentation The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PresentationTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [status] column.
     * 
     * @param int $v new value
     * @return $this|\BossEdu\Model\Presentation The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[PresentationTableMap::COL_STATUS] = true;
        }

        return $this;
    } // setStatus()

    /**
     * Set the value of [subject] column.
     * 
     * @param string $v new value
     * @return $this|\BossEdu\Model\Presentation The current object (for fluent API support)
     */
    public function setSubject($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->subject !== $v) {
            $this->subject = $v;
            $this->modifiedColumns[PresentationTableMap::COL_SUBJECT] = true;
        }

        return $this;
    } // setSubject()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\BossEdu\Model\Presentation The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ( ($dt != $this->created_at) // normalized values don't match
                || ($dt->format('Y-m-d H:i:s') === '2016-03-09 18:50:28') // or the entered value matches the default
                 ) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PresentationTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Set the value of [instruction_id] column.
     * 
     * @param int $v new value
     * @return $this|\BossEdu\Model\Presentation The current object (for fluent API support)
     */
    public function setInstructionId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->instruction_id !== $v) {
            $this->instruction_id = $v;
            $this->modifiedColumns[PresentationTableMap::COL_INSTRUCTION_ID] = true;
        }

        if ($this->aInstruction !== null && $this->aInstruction->getId() !== $v) {
            $this->aInstruction = null;
        }

        return $this;
    } // setInstructionId()

    /**
     * Set the value of [person_id] column.
     * 
     * @param int $v new value
     * @return $this|\BossEdu\Model\Presentation The current object (for fluent API support)
     */
    public function setPersonId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->person_id !== $v) {
            $this->person_id = $v;
            $this->modifiedColumns[PresentationTableMap::COL_PERSON_ID] = true;
        }

        if ($this->aPerson !== null && $this->aPerson->getId() !== $v) {
            $this->aPerson = null;
        }

        return $this;
    } // setPersonId()

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
            if ($this->status !== 0) {
                return false;
            }

            if ($this->subject !== 'Class X') {
                return false;
            }

            if ($this->created_at && $this->created_at->format('Y-m-d H:i:s') !== '2016-03-09 18:50:28') {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PresentationTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PresentationTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PresentationTableMap::translateFieldName('Subject', TableMap::TYPE_PHPNAME, $indexType)];
            $this->subject = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PresentationTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PresentationTableMap::translateFieldName('InstructionId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->instruction_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PresentationTableMap::translateFieldName('PersonId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->person_id = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = PresentationTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\BossEdu\\Model\\Presentation'), 0, $e);
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
        if ($this->aInstruction !== null && $this->instruction_id !== $this->aInstruction->getId()) {
            $this->aInstruction = null;
        }
        if ($this->aPerson !== null && $this->person_id !== $this->aPerson->getId()) {
            $this->aPerson = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(PresentationTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPresentationQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aInstruction = null;
            $this->aPerson = null;
            $this->collMpMaterials = null;

            $this->collDoubts = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Presentation::setDeleted()
     * @see Presentation::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PresentationTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPresentationQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PresentationTableMap::DATABASE_NAME);
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
                PresentationTableMap::addInstanceToPool($this);
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

            if ($this->aInstruction !== null) {
                if ($this->aInstruction->isModified() || $this->aInstruction->isNew()) {
                    $affectedRows += $this->aInstruction->save($con);
                }
                $this->setInstruction($this->aInstruction);
            }

            if ($this->aPerson !== null) {
                if ($this->aPerson->isModified() || $this->aPerson->isNew()) {
                    $affectedRows += $this->aPerson->save($con);
                }
                $this->setPerson($this->aPerson);
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

            if ($this->mpMaterialsScheduledForDeletion !== null) {
                if (!$this->mpMaterialsScheduledForDeletion->isEmpty()) {
                    \BossEdu\Model\MpMaterialQuery::create()
                        ->filterByPrimaryKeys($this->mpMaterialsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->mpMaterialsScheduledForDeletion = null;
                }
            }

            if ($this->collMpMaterials !== null) {
                foreach ($this->collMpMaterials as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->doubtsScheduledForDeletion !== null) {
                if (!$this->doubtsScheduledForDeletion->isEmpty()) {
                    \BossEdu\Model\DoubtQuery::create()
                        ->filterByPrimaryKeys($this->doubtsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->doubtsScheduledForDeletion = null;
                }
            }

            if ($this->collDoubts !== null) {
                foreach ($this->collDoubts as $referrerFK) {
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

        $this->modifiedColumns[PresentationTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PresentationTableMap::COL_ID . ')');
        }
        if (null === $this->id) {
            try {                
                $dataFetcher = $con->query("SELECT nextval('presentation_id_seq')");
                $this->id = $dataFetcher->fetchColumn();
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', 0, $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PresentationTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PresentationTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'status';
        }
        if ($this->isColumnModified(PresentationTableMap::COL_SUBJECT)) {
            $modifiedColumns[':p' . $index++]  = 'subject';
        }
        if ($this->isColumnModified(PresentationTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(PresentationTableMap::COL_INSTRUCTION_ID)) {
            $modifiedColumns[':p' . $index++]  = 'instruction_id';
        }
        if ($this->isColumnModified(PresentationTableMap::COL_PERSON_ID)) {
            $modifiedColumns[':p' . $index++]  = 'person_id';
        }

        $sql = sprintf(
            'INSERT INTO presentation (%s) VALUES (%s)',
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
                    case 'status':                        
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_INT);
                        break;
                    case 'subject':                        
                        $stmt->bindValue($identifier, $this->subject, PDO::PARAM_STR);
                        break;
                    case 'created_at':                        
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'instruction_id':                        
                        $stmt->bindValue($identifier, $this->instruction_id, PDO::PARAM_INT);
                        break;
                    case 'person_id':                        
                        $stmt->bindValue($identifier, $this->person_id, PDO::PARAM_INT);
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
        $pos = PresentationTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getStatus();
                break;
            case 2:
                return $this->getSubject();
                break;
            case 3:
                return $this->getCreatedAt();
                break;
            case 4:
                return $this->getInstructionId();
                break;
            case 5:
                return $this->getPersonId();
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

        if (isset($alreadyDumpedObjects['Presentation'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Presentation'][$this->hashCode()] = true;
        $keys = PresentationTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getStatus(),
            $keys[2] => $this->getSubject(),
            $keys[3] => $this->getCreatedAt(),
            $keys[4] => $this->getInstructionId(),
            $keys[5] => $this->getPersonId(),
        );
        if ($result[$keys[3]] instanceof \DateTime) {
            $result[$keys[3]] = $result[$keys[3]]->format('c');
        }
        
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aInstruction) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'instruction';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'instruction';
                        break;
                    default:
                        $key = 'Instruction';
                }
        
                $result[$key] = $this->aInstruction->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aPerson) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'person';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'person';
                        break;
                    default:
                        $key = 'Person';
                }
        
                $result[$key] = $this->aPerson->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collMpMaterials) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'mpMaterials';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'mp_materials';
                        break;
                    default:
                        $key = 'MpMaterials';
                }
        
                $result[$key] = $this->collMpMaterials->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collDoubts) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'doubts';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'doubts';
                        break;
                    default:
                        $key = 'Doubts';
                }
        
                $result[$key] = $this->collDoubts->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\BossEdu\Model\Presentation
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PresentationTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\BossEdu\Model\Presentation
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setStatus($value);
                break;
            case 2:
                $this->setSubject($value);
                break;
            case 3:
                $this->setCreatedAt($value);
                break;
            case 4:
                $this->setInstructionId($value);
                break;
            case 5:
                $this->setPersonId($value);
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
        $keys = PresentationTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setStatus($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setSubject($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCreatedAt($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setInstructionId($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setPersonId($arr[$keys[5]]);
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
     * @return $this|\BossEdu\Model\Presentation The current object, for fluid interface
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
        $criteria = new Criteria(PresentationTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PresentationTableMap::COL_ID)) {
            $criteria->add(PresentationTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PresentationTableMap::COL_STATUS)) {
            $criteria->add(PresentationTableMap::COL_STATUS, $this->status);
        }
        if ($this->isColumnModified(PresentationTableMap::COL_SUBJECT)) {
            $criteria->add(PresentationTableMap::COL_SUBJECT, $this->subject);
        }
        if ($this->isColumnModified(PresentationTableMap::COL_CREATED_AT)) {
            $criteria->add(PresentationTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(PresentationTableMap::COL_INSTRUCTION_ID)) {
            $criteria->add(PresentationTableMap::COL_INSTRUCTION_ID, $this->instruction_id);
        }
        if ($this->isColumnModified(PresentationTableMap::COL_PERSON_ID)) {
            $criteria->add(PresentationTableMap::COL_PERSON_ID, $this->person_id);
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
        $criteria = ChildPresentationQuery::create();
        $criteria->add(PresentationTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \BossEdu\Model\Presentation (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setStatus($this->getStatus());
        $copyObj->setSubject($this->getSubject());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setInstructionId($this->getInstructionId());
        $copyObj->setPersonId($this->getPersonId());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getMpMaterials() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMpMaterial($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDoubts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDoubt($relObj->copy($deepCopy));
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
     * @return \BossEdu\Model\Presentation Clone of current object.
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
     * Declares an association between this object and a ChildInstruction object.
     *
     * @param  ChildInstruction $v
     * @return $this|\BossEdu\Model\Presentation The current object (for fluent API support)
     * @throws PropelException
     */
    public function setInstruction(ChildInstruction $v = null)
    {
        if ($v === null) {
            $this->setInstructionId(NULL);
        } else {
            $this->setInstructionId($v->getId());
        }

        $this->aInstruction = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildInstruction object, it will not be re-added.
        if ($v !== null) {
            $v->addPresentation($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildInstruction object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildInstruction The associated ChildInstruction object.
     * @throws PropelException
     */
    public function getInstruction(ConnectionInterface $con = null)
    {
        if ($this->aInstruction === null && ($this->instruction_id !== null)) {
            $this->aInstruction = ChildInstructionQuery::create()->findPk($this->instruction_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aInstruction->addPresentations($this);
             */
        }

        return $this->aInstruction;
    }

    /**
     * Declares an association between this object and a ChildPerson object.
     *
     * @param  ChildPerson $v
     * @return $this|\BossEdu\Model\Presentation The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPerson(ChildPerson $v = null)
    {
        if ($v === null) {
            $this->setPersonId(NULL);
        } else {
            $this->setPersonId($v->getId());
        }

        $this->aPerson = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPerson object, it will not be re-added.
        if ($v !== null) {
            $v->addPresentation($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPerson object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPerson The associated ChildPerson object.
     * @throws PropelException
     */
    public function getPerson(ConnectionInterface $con = null)
    {
        if ($this->aPerson === null && ($this->person_id !== null)) {
            $this->aPerson = ChildPersonQuery::create()->findPk($this->person_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPerson->addPresentations($this);
             */
        }

        return $this->aPerson;
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
        if ('MpMaterial' == $relationName) {
            return $this->initMpMaterials();
        }
        if ('Doubt' == $relationName) {
            return $this->initDoubts();
        }
    }

    /**
     * Clears out the collMpMaterials collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMpMaterials()
     */
    public function clearMpMaterials()
    {
        $this->collMpMaterials = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collMpMaterials collection loaded partially.
     */
    public function resetPartialMpMaterials($v = true)
    {
        $this->collMpMaterialsPartial = $v;
    }

    /**
     * Initializes the collMpMaterials collection.
     *
     * By default this just sets the collMpMaterials collection to an empty array (like clearcollMpMaterials());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMpMaterials($overrideExisting = true)
    {
        if (null !== $this->collMpMaterials && !$overrideExisting) {
            return;
        }

        $collectionClassName = MpMaterialTableMap::getTableMap()->getCollectionClassName();

        $this->collMpMaterials = new $collectionClassName;
        $this->collMpMaterials->setModel('\BossEdu\Model\MpMaterial');
    }

    /**
     * Gets an array of ChildMpMaterial objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPresentation is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildMpMaterial[] List of ChildMpMaterial objects
     * @throws PropelException
     */
    public function getMpMaterials(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMpMaterialsPartial && !$this->isNew();
        if (null === $this->collMpMaterials || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMpMaterials) {
                // return empty collection
                $this->initMpMaterials();
            } else {
                $collMpMaterials = ChildMpMaterialQuery::create(null, $criteria)
                    ->filterByPresentation($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collMpMaterialsPartial && count($collMpMaterials)) {
                        $this->initMpMaterials(false);

                        foreach ($collMpMaterials as $obj) {
                            if (false == $this->collMpMaterials->contains($obj)) {
                                $this->collMpMaterials->append($obj);
                            }
                        }

                        $this->collMpMaterialsPartial = true;
                    }

                    return $collMpMaterials;
                }

                if ($partial && $this->collMpMaterials) {
                    foreach ($this->collMpMaterials as $obj) {
                        if ($obj->isNew()) {
                            $collMpMaterials[] = $obj;
                        }
                    }
                }

                $this->collMpMaterials = $collMpMaterials;
                $this->collMpMaterialsPartial = false;
            }
        }

        return $this->collMpMaterials;
    }

    /**
     * Sets a collection of ChildMpMaterial objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $mpMaterials A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPresentation The current object (for fluent API support)
     */
    public function setMpMaterials(Collection $mpMaterials, ConnectionInterface $con = null)
    {
        /** @var ChildMpMaterial[] $mpMaterialsToDelete */
        $mpMaterialsToDelete = $this->getMpMaterials(new Criteria(), $con)->diff($mpMaterials);

        
        $this->mpMaterialsScheduledForDeletion = $mpMaterialsToDelete;

        foreach ($mpMaterialsToDelete as $mpMaterialRemoved) {
            $mpMaterialRemoved->setPresentation(null);
        }

        $this->collMpMaterials = null;
        foreach ($mpMaterials as $mpMaterial) {
            $this->addMpMaterial($mpMaterial);
        }

        $this->collMpMaterials = $mpMaterials;
        $this->collMpMaterialsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related MpMaterial objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related MpMaterial objects.
     * @throws PropelException
     */
    public function countMpMaterials(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMpMaterialsPartial && !$this->isNew();
        if (null === $this->collMpMaterials || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMpMaterials) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMpMaterials());
            }

            $query = ChildMpMaterialQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPresentation($this)
                ->count($con);
        }

        return count($this->collMpMaterials);
    }

    /**
     * Method called to associate a ChildMpMaterial object to this object
     * through the ChildMpMaterial foreign key attribute.
     *
     * @param  ChildMpMaterial $l ChildMpMaterial
     * @return $this|\BossEdu\Model\Presentation The current object (for fluent API support)
     */
    public function addMpMaterial(ChildMpMaterial $l)
    {
        if ($this->collMpMaterials === null) {
            $this->initMpMaterials();
            $this->collMpMaterialsPartial = true;
        }

        if (!$this->collMpMaterials->contains($l)) {
            $this->doAddMpMaterial($l);

            if ($this->mpMaterialsScheduledForDeletion and $this->mpMaterialsScheduledForDeletion->contains($l)) {
                $this->mpMaterialsScheduledForDeletion->remove($this->mpMaterialsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildMpMaterial $mpMaterial The ChildMpMaterial object to add.
     */
    protected function doAddMpMaterial(ChildMpMaterial $mpMaterial)
    {
        $this->collMpMaterials[]= $mpMaterial;
        $mpMaterial->setPresentation($this);
    }

    /**
     * @param  ChildMpMaterial $mpMaterial The ChildMpMaterial object to remove.
     * @return $this|ChildPresentation The current object (for fluent API support)
     */
    public function removeMpMaterial(ChildMpMaterial $mpMaterial)
    {
        if ($this->getMpMaterials()->contains($mpMaterial)) {
            $pos = $this->collMpMaterials->search($mpMaterial);
            $this->collMpMaterials->remove($pos);
            if (null === $this->mpMaterialsScheduledForDeletion) {
                $this->mpMaterialsScheduledForDeletion = clone $this->collMpMaterials;
                $this->mpMaterialsScheduledForDeletion->clear();
            }
            $this->mpMaterialsScheduledForDeletion[]= clone $mpMaterial;
            $mpMaterial->setPresentation(null);
        }

        return $this;
    }

    /**
     * Clears out the collDoubts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDoubts()
     */
    public function clearDoubts()
    {
        $this->collDoubts = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDoubts collection loaded partially.
     */
    public function resetPartialDoubts($v = true)
    {
        $this->collDoubtsPartial = $v;
    }

    /**
     * Initializes the collDoubts collection.
     *
     * By default this just sets the collDoubts collection to an empty array (like clearcollDoubts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDoubts($overrideExisting = true)
    {
        if (null !== $this->collDoubts && !$overrideExisting) {
            return;
        }

        $collectionClassName = DoubtTableMap::getTableMap()->getCollectionClassName();

        $this->collDoubts = new $collectionClassName;
        $this->collDoubts->setModel('\BossEdu\Model\Doubt');
    }

    /**
     * Gets an array of ChildDoubt objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPresentation is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDoubt[] List of ChildDoubt objects
     * @throws PropelException
     */
    public function getDoubts(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDoubtsPartial && !$this->isNew();
        if (null === $this->collDoubts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDoubts) {
                // return empty collection
                $this->initDoubts();
            } else {
                $collDoubts = ChildDoubtQuery::create(null, $criteria)
                    ->filterByPresentation($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDoubtsPartial && count($collDoubts)) {
                        $this->initDoubts(false);

                        foreach ($collDoubts as $obj) {
                            if (false == $this->collDoubts->contains($obj)) {
                                $this->collDoubts->append($obj);
                            }
                        }

                        $this->collDoubtsPartial = true;
                    }

                    return $collDoubts;
                }

                if ($partial && $this->collDoubts) {
                    foreach ($this->collDoubts as $obj) {
                        if ($obj->isNew()) {
                            $collDoubts[] = $obj;
                        }
                    }
                }

                $this->collDoubts = $collDoubts;
                $this->collDoubtsPartial = false;
            }
        }

        return $this->collDoubts;
    }

    /**
     * Sets a collection of ChildDoubt objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $doubts A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPresentation The current object (for fluent API support)
     */
    public function setDoubts(Collection $doubts, ConnectionInterface $con = null)
    {
        /** @var ChildDoubt[] $doubtsToDelete */
        $doubtsToDelete = $this->getDoubts(new Criteria(), $con)->diff($doubts);

        
        $this->doubtsScheduledForDeletion = $doubtsToDelete;

        foreach ($doubtsToDelete as $doubtRemoved) {
            $doubtRemoved->setPresentation(null);
        }

        $this->collDoubts = null;
        foreach ($doubts as $doubt) {
            $this->addDoubt($doubt);
        }

        $this->collDoubts = $doubts;
        $this->collDoubtsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Doubt objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Doubt objects.
     * @throws PropelException
     */
    public function countDoubts(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDoubtsPartial && !$this->isNew();
        if (null === $this->collDoubts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDoubts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDoubts());
            }

            $query = ChildDoubtQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPresentation($this)
                ->count($con);
        }

        return count($this->collDoubts);
    }

    /**
     * Method called to associate a ChildDoubt object to this object
     * through the ChildDoubt foreign key attribute.
     *
     * @param  ChildDoubt $l ChildDoubt
     * @return $this|\BossEdu\Model\Presentation The current object (for fluent API support)
     */
    public function addDoubt(ChildDoubt $l)
    {
        if ($this->collDoubts === null) {
            $this->initDoubts();
            $this->collDoubtsPartial = true;
        }

        if (!$this->collDoubts->contains($l)) {
            $this->doAddDoubt($l);

            if ($this->doubtsScheduledForDeletion and $this->doubtsScheduledForDeletion->contains($l)) {
                $this->doubtsScheduledForDeletion->remove($this->doubtsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildDoubt $doubt The ChildDoubt object to add.
     */
    protected function doAddDoubt(ChildDoubt $doubt)
    {
        $this->collDoubts[]= $doubt;
        $doubt->setPresentation($this);
    }

    /**
     * @param  ChildDoubt $doubt The ChildDoubt object to remove.
     * @return $this|ChildPresentation The current object (for fluent API support)
     */
    public function removeDoubt(ChildDoubt $doubt)
    {
        if ($this->getDoubts()->contains($doubt)) {
            $pos = $this->collDoubts->search($doubt);
            $this->collDoubts->remove($pos);
            if (null === $this->doubtsScheduledForDeletion) {
                $this->doubtsScheduledForDeletion = clone $this->collDoubts;
                $this->doubtsScheduledForDeletion->clear();
            }
            $this->doubtsScheduledForDeletion[]= clone $doubt;
            $doubt->setPresentation(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Presentation is new, it will return
     * an empty collection; or if this Presentation has previously
     * been saved, it will retrieve related Doubts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Presentation.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildDoubt[] List of ChildDoubt objects
     */
    public function getDoubtsJoinPerson(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDoubtQuery::create(null, $criteria);
        $query->joinWith('Person', $joinBehavior);

        return $this->getDoubts($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aInstruction) {
            $this->aInstruction->removePresentation($this);
        }
        if (null !== $this->aPerson) {
            $this->aPerson->removePresentation($this);
        }
        $this->id = null;
        $this->status = null;
        $this->subject = null;
        $this->created_at = null;
        $this->instruction_id = null;
        $this->person_id = null;
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
            if ($this->collMpMaterials) {
                foreach ($this->collMpMaterials as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDoubts) {
                foreach ($this->collDoubts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collMpMaterials = null;
        $this->collDoubts = null;
        $this->aInstruction = null;
        $this->aPerson = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PresentationTableMap::DEFAULT_STRING_FORMAT);
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
