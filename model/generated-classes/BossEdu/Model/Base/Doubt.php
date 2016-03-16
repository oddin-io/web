<?php

namespace BossEdu\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use BossEdu\Model\Contribution as ChildContribution;
use BossEdu\Model\ContributionQuery as ChildContributionQuery;
use BossEdu\Model\Doubt as ChildDoubt;
use BossEdu\Model\DoubtQuery as ChildDoubtQuery;
use BossEdu\Model\PdLike as ChildPdLike;
use BossEdu\Model\PdLikeQuery as ChildPdLikeQuery;
use BossEdu\Model\Person as ChildPerson;
use BossEdu\Model\PersonQuery as ChildPersonQuery;
use BossEdu\Model\Presentation as ChildPresentation;
use BossEdu\Model\PresentationQuery as ChildPresentationQuery;
use BossEdu\Model\Map\ContributionTableMap;
use BossEdu\Model\Map\DoubtTableMap;
use BossEdu\Model\Map\PdLikeTableMap;
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
 * Base class that represents a row from the 'doubt' table.
 *
 * 
 *
* @package    propel.generator.BossEdu.Model.Base
*/
abstract class Doubt implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\BossEdu\\Model\\Map\\DoubtTableMap';


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
     * The value for the text field.
     * 
     * @var        string
     */
    protected $text;

    /**
     * The value for the created_at field.
     * 
     * Note: this column has a database default value of: '2016-03-09 18:50:28'
     * @var        \DateTime
     */
    protected $created_at;

    /**
     * The value for the anonymous field.
     * 
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $anonymous;

    /**
     * The value for the understand field.
     * 
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $understand;

    /**
     * The value for the presentation_id field.
     * 
     * @var        int
     */
    protected $presentation_id;

    /**
     * The value for the person_id field.
     * 
     * @var        int
     */
    protected $person_id;

    /**
     * @var        ChildPresentation
     */
    protected $aPresentation;

    /**
     * @var        ChildPerson
     */
    protected $aPerson;

    /**
     * @var        ObjectCollection|ChildPdLike[] Collection to store aggregation of ChildPdLike objects.
     */
    protected $collPdLikes;
    protected $collPdLikesPartial;

    /**
     * @var        ObjectCollection|ChildContribution[] Collection to store aggregation of ChildContribution objects.
     */
    protected $collContributions;
    protected $collContributionsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPdLike[]
     */
    protected $pdLikesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildContribution[]
     */
    protected $contributionsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->status = 0;
        $this->created_at = PropelDateTime::newInstance('2016-03-09 18:50:28', null, 'DateTime');
        $this->anonymous = false;
        $this->understand = false;
    }

    /**
     * Initializes internal state of BossEdu\Model\Base\Doubt object.
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
     * Compares this with another <code>Doubt</code> instance.  If
     * <code>obj</code> is an instance of <code>Doubt</code>, delegates to
     * <code>equals(Doubt)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Doubt The current object, for fluid interface
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
     * Get the [text] column value.
     * 
     * @return string
     */
    public function getText()
    {
        return $this->text;
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
     * Get the [anonymous] column value.
     * 
     * @return boolean
     */
    public function getAnonymous()
    {
        return $this->anonymous;
    }

    /**
     * Get the [anonymous] column value.
     * 
     * @return boolean
     */
    public function isAnonymous()
    {
        return $this->getAnonymous();
    }

    /**
     * Get the [understand] column value.
     * 
     * @return boolean
     */
    public function getUnderstand()
    {
        return $this->understand;
    }

    /**
     * Get the [understand] column value.
     * 
     * @return boolean
     */
    public function isUnderstand()
    {
        return $this->getUnderstand();
    }

    /**
     * Get the [presentation_id] column value.
     * 
     * @return int
     */
    public function getPresentationId()
    {
        return $this->presentation_id;
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
     * @return $this|\BossEdu\Model\Doubt The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[DoubtTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [status] column.
     * 
     * @param int $v new value
     * @return $this|\BossEdu\Model\Doubt The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[DoubtTableMap::COL_STATUS] = true;
        }

        return $this;
    } // setStatus()

    /**
     * Set the value of [text] column.
     * 
     * @param string $v new value
     * @return $this|\BossEdu\Model\Doubt The current object (for fluent API support)
     */
    public function setText($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->text !== $v) {
            $this->text = $v;
            $this->modifiedColumns[DoubtTableMap::COL_TEXT] = true;
        }

        return $this;
    } // setText()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\BossEdu\Model\Doubt The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ( ($dt != $this->created_at) // normalized values don't match
                || ($dt->format('Y-m-d H:i:s') === '2016-03-09 18:50:28') // or the entered value matches the default
                 ) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[DoubtTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of the [anonymous] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * 
     * @param  boolean|integer|string $v The new value
     * @return $this|\BossEdu\Model\Doubt The current object (for fluent API support)
     */
    public function setAnonymous($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->anonymous !== $v) {
            $this->anonymous = $v;
            $this->modifiedColumns[DoubtTableMap::COL_ANONYMOUS] = true;
        }

        return $this;
    } // setAnonymous()

    /**
     * Sets the value of the [understand] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * 
     * @param  boolean|integer|string $v The new value
     * @return $this|\BossEdu\Model\Doubt The current object (for fluent API support)
     */
    public function setUnderstand($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->understand !== $v) {
            $this->understand = $v;
            $this->modifiedColumns[DoubtTableMap::COL_UNDERSTAND] = true;
        }

        return $this;
    } // setUnderstand()

    /**
     * Set the value of [presentation_id] column.
     * 
     * @param int $v new value
     * @return $this|\BossEdu\Model\Doubt The current object (for fluent API support)
     */
    public function setPresentationId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->presentation_id !== $v) {
            $this->presentation_id = $v;
            $this->modifiedColumns[DoubtTableMap::COL_PRESENTATION_ID] = true;
        }

        if ($this->aPresentation !== null && $this->aPresentation->getId() !== $v) {
            $this->aPresentation = null;
        }

        return $this;
    } // setPresentationId()

    /**
     * Set the value of [person_id] column.
     * 
     * @param int $v new value
     * @return $this|\BossEdu\Model\Doubt The current object (for fluent API support)
     */
    public function setPersonId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->person_id !== $v) {
            $this->person_id = $v;
            $this->modifiedColumns[DoubtTableMap::COL_PERSON_ID] = true;
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

            if ($this->created_at && $this->created_at->format('Y-m-d H:i:s') !== '2016-03-09 18:50:28') {
                return false;
            }

            if ($this->anonymous !== false) {
                return false;
            }

            if ($this->understand !== false) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : DoubtTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : DoubtTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : DoubtTableMap::translateFieldName('Text', TableMap::TYPE_PHPNAME, $indexType)];
            $this->text = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : DoubtTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : DoubtTableMap::translateFieldName('Anonymous', TableMap::TYPE_PHPNAME, $indexType)];
            $this->anonymous = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : DoubtTableMap::translateFieldName('Understand', TableMap::TYPE_PHPNAME, $indexType)];
            $this->understand = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : DoubtTableMap::translateFieldName('PresentationId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->presentation_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : DoubtTableMap::translateFieldName('PersonId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->person_id = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = DoubtTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\BossEdu\\Model\\Doubt'), 0, $e);
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
        if ($this->aPresentation !== null && $this->presentation_id !== $this->aPresentation->getId()) {
            $this->aPresentation = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(DoubtTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildDoubtQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPresentation = null;
            $this->aPerson = null;
            $this->collPdLikes = null;

            $this->collContributions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Doubt::setDeleted()
     * @see Doubt::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(DoubtTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildDoubtQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(DoubtTableMap::DATABASE_NAME);
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
                DoubtTableMap::addInstanceToPool($this);
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

            if ($this->aPresentation !== null) {
                if ($this->aPresentation->isModified() || $this->aPresentation->isNew()) {
                    $affectedRows += $this->aPresentation->save($con);
                }
                $this->setPresentation($this->aPresentation);
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

            if ($this->pdLikesScheduledForDeletion !== null) {
                if (!$this->pdLikesScheduledForDeletion->isEmpty()) {
                    \BossEdu\Model\PdLikeQuery::create()
                        ->filterByPrimaryKeys($this->pdLikesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pdLikesScheduledForDeletion = null;
                }
            }

            if ($this->collPdLikes !== null) {
                foreach ($this->collPdLikes as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->contributionsScheduledForDeletion !== null) {
                if (!$this->contributionsScheduledForDeletion->isEmpty()) {
                    \BossEdu\Model\ContributionQuery::create()
                        ->filterByPrimaryKeys($this->contributionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contributionsScheduledForDeletion = null;
                }
            }

            if ($this->collContributions !== null) {
                foreach ($this->collContributions as $referrerFK) {
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

        $this->modifiedColumns[DoubtTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . DoubtTableMap::COL_ID . ')');
        }
        if (null === $this->id) {
            try {                
                $dataFetcher = $con->query("SELECT nextval('doubt_id_seq')");
                $this->id = $dataFetcher->fetchColumn();
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', 0, $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(DoubtTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(DoubtTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'status';
        }
        if ($this->isColumnModified(DoubtTableMap::COL_TEXT)) {
            $modifiedColumns[':p' . $index++]  = 'text';
        }
        if ($this->isColumnModified(DoubtTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(DoubtTableMap::COL_ANONYMOUS)) {
            $modifiedColumns[':p' . $index++]  = 'anonymous';
        }
        if ($this->isColumnModified(DoubtTableMap::COL_UNDERSTAND)) {
            $modifiedColumns[':p' . $index++]  = 'understand';
        }
        if ($this->isColumnModified(DoubtTableMap::COL_PRESENTATION_ID)) {
            $modifiedColumns[':p' . $index++]  = 'presentation_id';
        }
        if ($this->isColumnModified(DoubtTableMap::COL_PERSON_ID)) {
            $modifiedColumns[':p' . $index++]  = 'person_id';
        }

        $sql = sprintf(
            'INSERT INTO doubt (%s) VALUES (%s)',
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
                    case 'text':                        
                        $stmt->bindValue($identifier, $this->text, PDO::PARAM_STR);
                        break;
                    case 'created_at':                        
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'anonymous':                        
                        $stmt->bindValue($identifier, $this->anonymous, PDO::PARAM_BOOL);
                        break;
                    case 'understand':                        
                        $stmt->bindValue($identifier, $this->understand, PDO::PARAM_BOOL);
                        break;
                    case 'presentation_id':                        
                        $stmt->bindValue($identifier, $this->presentation_id, PDO::PARAM_INT);
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
        $pos = DoubtTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getText();
                break;
            case 3:
                return $this->getCreatedAt();
                break;
            case 4:
                return $this->getAnonymous();
                break;
            case 5:
                return $this->getUnderstand();
                break;
            case 6:
                return $this->getPresentationId();
                break;
            case 7:
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

        if (isset($alreadyDumpedObjects['Doubt'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Doubt'][$this->hashCode()] = true;
        $keys = DoubtTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getStatus(),
            $keys[2] => $this->getText(),
            $keys[3] => $this->getCreatedAt(),
            $keys[4] => $this->getAnonymous(),
            $keys[5] => $this->getUnderstand(),
            $keys[6] => $this->getPresentationId(),
            $keys[7] => $this->getPersonId(),
        );
        if ($result[$keys[3]] instanceof \DateTime) {
            $result[$keys[3]] = $result[$keys[3]]->format('c');
        }
        
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aPresentation) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'presentation';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'presentation';
                        break;
                    default:
                        $key = 'Presentation';
                }
        
                $result[$key] = $this->aPresentation->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
            if (null !== $this->collPdLikes) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'pdLikes';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'pd_likes';
                        break;
                    default:
                        $key = 'PdLikes';
                }
        
                $result[$key] = $this->collPdLikes->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collContributions) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'contributions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'contributions';
                        break;
                    default:
                        $key = 'Contributions';
                }
        
                $result[$key] = $this->collContributions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\BossEdu\Model\Doubt
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = DoubtTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\BossEdu\Model\Doubt
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
                $this->setText($value);
                break;
            case 3:
                $this->setCreatedAt($value);
                break;
            case 4:
                $this->setAnonymous($value);
                break;
            case 5:
                $this->setUnderstand($value);
                break;
            case 6:
                $this->setPresentationId($value);
                break;
            case 7:
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
        $keys = DoubtTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setStatus($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setText($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCreatedAt($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setAnonymous($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setUnderstand($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setPresentationId($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setPersonId($arr[$keys[7]]);
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
     * @return $this|\BossEdu\Model\Doubt The current object, for fluid interface
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
        $criteria = new Criteria(DoubtTableMap::DATABASE_NAME);

        if ($this->isColumnModified(DoubtTableMap::COL_ID)) {
            $criteria->add(DoubtTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(DoubtTableMap::COL_STATUS)) {
            $criteria->add(DoubtTableMap::COL_STATUS, $this->status);
        }
        if ($this->isColumnModified(DoubtTableMap::COL_TEXT)) {
            $criteria->add(DoubtTableMap::COL_TEXT, $this->text);
        }
        if ($this->isColumnModified(DoubtTableMap::COL_CREATED_AT)) {
            $criteria->add(DoubtTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(DoubtTableMap::COL_ANONYMOUS)) {
            $criteria->add(DoubtTableMap::COL_ANONYMOUS, $this->anonymous);
        }
        if ($this->isColumnModified(DoubtTableMap::COL_UNDERSTAND)) {
            $criteria->add(DoubtTableMap::COL_UNDERSTAND, $this->understand);
        }
        if ($this->isColumnModified(DoubtTableMap::COL_PRESENTATION_ID)) {
            $criteria->add(DoubtTableMap::COL_PRESENTATION_ID, $this->presentation_id);
        }
        if ($this->isColumnModified(DoubtTableMap::COL_PERSON_ID)) {
            $criteria->add(DoubtTableMap::COL_PERSON_ID, $this->person_id);
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
        $criteria = ChildDoubtQuery::create();
        $criteria->add(DoubtTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \BossEdu\Model\Doubt (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setStatus($this->getStatus());
        $copyObj->setText($this->getText());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setAnonymous($this->getAnonymous());
        $copyObj->setUnderstand($this->getUnderstand());
        $copyObj->setPresentationId($this->getPresentationId());
        $copyObj->setPersonId($this->getPersonId());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPdLikes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPdLike($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getContributions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContribution($relObj->copy($deepCopy));
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
     * @return \BossEdu\Model\Doubt Clone of current object.
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
     * Declares an association between this object and a ChildPresentation object.
     *
     * @param  ChildPresentation $v
     * @return $this|\BossEdu\Model\Doubt The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPresentation(ChildPresentation $v = null)
    {
        if ($v === null) {
            $this->setPresentationId(NULL);
        } else {
            $this->setPresentationId($v->getId());
        }

        $this->aPresentation = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPresentation object, it will not be re-added.
        if ($v !== null) {
            $v->addDoubt($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPresentation object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPresentation The associated ChildPresentation object.
     * @throws PropelException
     */
    public function getPresentation(ConnectionInterface $con = null)
    {
        if ($this->aPresentation === null && ($this->presentation_id !== null)) {
            $this->aPresentation = ChildPresentationQuery::create()->findPk($this->presentation_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPresentation->addDoubts($this);
             */
        }

        return $this->aPresentation;
    }

    /**
     * Declares an association between this object and a ChildPerson object.
     *
     * @param  ChildPerson $v
     * @return $this|\BossEdu\Model\Doubt The current object (for fluent API support)
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
            $v->addDoubt($this);
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
                $this->aPerson->addDoubts($this);
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
        if ('PdLike' == $relationName) {
            return $this->initPdLikes();
        }
        if ('Contribution' == $relationName) {
            return $this->initContributions();
        }
    }

    /**
     * Clears out the collPdLikes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPdLikes()
     */
    public function clearPdLikes()
    {
        $this->collPdLikes = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPdLikes collection loaded partially.
     */
    public function resetPartialPdLikes($v = true)
    {
        $this->collPdLikesPartial = $v;
    }

    /**
     * Initializes the collPdLikes collection.
     *
     * By default this just sets the collPdLikes collection to an empty array (like clearcollPdLikes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPdLikes($overrideExisting = true)
    {
        if (null !== $this->collPdLikes && !$overrideExisting) {
            return;
        }

        $collectionClassName = PdLikeTableMap::getTableMap()->getCollectionClassName();

        $this->collPdLikes = new $collectionClassName;
        $this->collPdLikes->setModel('\BossEdu\Model\PdLike');
    }

    /**
     * Gets an array of ChildPdLike objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildDoubt is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPdLike[] List of ChildPdLike objects
     * @throws PropelException
     */
    public function getPdLikes(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPdLikesPartial && !$this->isNew();
        if (null === $this->collPdLikes || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPdLikes) {
                // return empty collection
                $this->initPdLikes();
            } else {
                $collPdLikes = ChildPdLikeQuery::create(null, $criteria)
                    ->filterByDoubt($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPdLikesPartial && count($collPdLikes)) {
                        $this->initPdLikes(false);

                        foreach ($collPdLikes as $obj) {
                            if (false == $this->collPdLikes->contains($obj)) {
                                $this->collPdLikes->append($obj);
                            }
                        }

                        $this->collPdLikesPartial = true;
                    }

                    return $collPdLikes;
                }

                if ($partial && $this->collPdLikes) {
                    foreach ($this->collPdLikes as $obj) {
                        if ($obj->isNew()) {
                            $collPdLikes[] = $obj;
                        }
                    }
                }

                $this->collPdLikes = $collPdLikes;
                $this->collPdLikesPartial = false;
            }
        }

        return $this->collPdLikes;
    }

    /**
     * Sets a collection of ChildPdLike objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $pdLikes A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildDoubt The current object (for fluent API support)
     */
    public function setPdLikes(Collection $pdLikes, ConnectionInterface $con = null)
    {
        /** @var ChildPdLike[] $pdLikesToDelete */
        $pdLikesToDelete = $this->getPdLikes(new Criteria(), $con)->diff($pdLikes);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->pdLikesScheduledForDeletion = clone $pdLikesToDelete;

        foreach ($pdLikesToDelete as $pdLikeRemoved) {
            $pdLikeRemoved->setDoubt(null);
        }

        $this->collPdLikes = null;
        foreach ($pdLikes as $pdLike) {
            $this->addPdLike($pdLike);
        }

        $this->collPdLikes = $pdLikes;
        $this->collPdLikesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PdLike objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PdLike objects.
     * @throws PropelException
     */
    public function countPdLikes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPdLikesPartial && !$this->isNew();
        if (null === $this->collPdLikes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPdLikes) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPdLikes());
            }

            $query = ChildPdLikeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDoubt($this)
                ->count($con);
        }

        return count($this->collPdLikes);
    }

    /**
     * Method called to associate a ChildPdLike object to this object
     * through the ChildPdLike foreign key attribute.
     *
     * @param  ChildPdLike $l ChildPdLike
     * @return $this|\BossEdu\Model\Doubt The current object (for fluent API support)
     */
    public function addPdLike(ChildPdLike $l)
    {
        if ($this->collPdLikes === null) {
            $this->initPdLikes();
            $this->collPdLikesPartial = true;
        }

        if (!$this->collPdLikes->contains($l)) {
            $this->doAddPdLike($l);

            if ($this->pdLikesScheduledForDeletion and $this->pdLikesScheduledForDeletion->contains($l)) {
                $this->pdLikesScheduledForDeletion->remove($this->pdLikesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPdLike $pdLike The ChildPdLike object to add.
     */
    protected function doAddPdLike(ChildPdLike $pdLike)
    {
        $this->collPdLikes[]= $pdLike;
        $pdLike->setDoubt($this);
    }

    /**
     * @param  ChildPdLike $pdLike The ChildPdLike object to remove.
     * @return $this|ChildDoubt The current object (for fluent API support)
     */
    public function removePdLike(ChildPdLike $pdLike)
    {
        if ($this->getPdLikes()->contains($pdLike)) {
            $pos = $this->collPdLikes->search($pdLike);
            $this->collPdLikes->remove($pos);
            if (null === $this->pdLikesScheduledForDeletion) {
                $this->pdLikesScheduledForDeletion = clone $this->collPdLikes;
                $this->pdLikesScheduledForDeletion->clear();
            }
            $this->pdLikesScheduledForDeletion[]= clone $pdLike;
            $pdLike->setDoubt(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Doubt is new, it will return
     * an empty collection; or if this Doubt has previously
     * been saved, it will retrieve related PdLikes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Doubt.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPdLike[] List of ChildPdLike objects
     */
    public function getPdLikesJoinPerson(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPdLikeQuery::create(null, $criteria);
        $query->joinWith('Person', $joinBehavior);

        return $this->getPdLikes($query, $con);
    }

    /**
     * Clears out the collContributions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addContributions()
     */
    public function clearContributions()
    {
        $this->collContributions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collContributions collection loaded partially.
     */
    public function resetPartialContributions($v = true)
    {
        $this->collContributionsPartial = $v;
    }

    /**
     * Initializes the collContributions collection.
     *
     * By default this just sets the collContributions collection to an empty array (like clearcollContributions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContributions($overrideExisting = true)
    {
        if (null !== $this->collContributions && !$overrideExisting) {
            return;
        }

        $collectionClassName = ContributionTableMap::getTableMap()->getCollectionClassName();

        $this->collContributions = new $collectionClassName;
        $this->collContributions->setModel('\BossEdu\Model\Contribution');
    }

    /**
     * Gets an array of ChildContribution objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildDoubt is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildContribution[] List of ChildContribution objects
     * @throws PropelException
     */
    public function getContributions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collContributionsPartial && !$this->isNew();
        if (null === $this->collContributions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContributions) {
                // return empty collection
                $this->initContributions();
            } else {
                $collContributions = ChildContributionQuery::create(null, $criteria)
                    ->filterByDoubt($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collContributionsPartial && count($collContributions)) {
                        $this->initContributions(false);

                        foreach ($collContributions as $obj) {
                            if (false == $this->collContributions->contains($obj)) {
                                $this->collContributions->append($obj);
                            }
                        }

                        $this->collContributionsPartial = true;
                    }

                    return $collContributions;
                }

                if ($partial && $this->collContributions) {
                    foreach ($this->collContributions as $obj) {
                        if ($obj->isNew()) {
                            $collContributions[] = $obj;
                        }
                    }
                }

                $this->collContributions = $collContributions;
                $this->collContributionsPartial = false;
            }
        }

        return $this->collContributions;
    }

    /**
     * Sets a collection of ChildContribution objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $contributions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildDoubt The current object (for fluent API support)
     */
    public function setContributions(Collection $contributions, ConnectionInterface $con = null)
    {
        /** @var ChildContribution[] $contributionsToDelete */
        $contributionsToDelete = $this->getContributions(new Criteria(), $con)->diff($contributions);

        
        $this->contributionsScheduledForDeletion = $contributionsToDelete;

        foreach ($contributionsToDelete as $contributionRemoved) {
            $contributionRemoved->setDoubt(null);
        }

        $this->collContributions = null;
        foreach ($contributions as $contribution) {
            $this->addContribution($contribution);
        }

        $this->collContributions = $contributions;
        $this->collContributionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Contribution objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Contribution objects.
     * @throws PropelException
     */
    public function countContributions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collContributionsPartial && !$this->isNew();
        if (null === $this->collContributions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContributions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getContributions());
            }

            $query = ChildContributionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDoubt($this)
                ->count($con);
        }

        return count($this->collContributions);
    }

    /**
     * Method called to associate a ChildContribution object to this object
     * through the ChildContribution foreign key attribute.
     *
     * @param  ChildContribution $l ChildContribution
     * @return $this|\BossEdu\Model\Doubt The current object (for fluent API support)
     */
    public function addContribution(ChildContribution $l)
    {
        if ($this->collContributions === null) {
            $this->initContributions();
            $this->collContributionsPartial = true;
        }

        if (!$this->collContributions->contains($l)) {
            $this->doAddContribution($l);

            if ($this->contributionsScheduledForDeletion and $this->contributionsScheduledForDeletion->contains($l)) {
                $this->contributionsScheduledForDeletion->remove($this->contributionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildContribution $contribution The ChildContribution object to add.
     */
    protected function doAddContribution(ChildContribution $contribution)
    {
        $this->collContributions[]= $contribution;
        $contribution->setDoubt($this);
    }

    /**
     * @param  ChildContribution $contribution The ChildContribution object to remove.
     * @return $this|ChildDoubt The current object (for fluent API support)
     */
    public function removeContribution(ChildContribution $contribution)
    {
        if ($this->getContributions()->contains($contribution)) {
            $pos = $this->collContributions->search($contribution);
            $this->collContributions->remove($pos);
            if (null === $this->contributionsScheduledForDeletion) {
                $this->contributionsScheduledForDeletion = clone $this->collContributions;
                $this->contributionsScheduledForDeletion->clear();
            }
            $this->contributionsScheduledForDeletion[]= clone $contribution;
            $contribution->setDoubt(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Doubt is new, it will return
     * an empty collection; or if this Doubt has previously
     * been saved, it will retrieve related Contributions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Doubt.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildContribution[] List of ChildContribution objects
     */
    public function getContributionsJoinPerson(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildContributionQuery::create(null, $criteria);
        $query->joinWith('Person', $joinBehavior);

        return $this->getContributions($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aPresentation) {
            $this->aPresentation->removeDoubt($this);
        }
        if (null !== $this->aPerson) {
            $this->aPerson->removeDoubt($this);
        }
        $this->id = null;
        $this->status = null;
        $this->text = null;
        $this->created_at = null;
        $this->anonymous = null;
        $this->understand = null;
        $this->presentation_id = null;
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
            if ($this->collPdLikes) {
                foreach ($this->collPdLikes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContributions) {
                foreach ($this->collContributions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collPdLikes = null;
        $this->collContributions = null;
        $this->aPresentation = null;
        $this->aPerson = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(DoubtTableMap::DEFAULT_STRING_FORMAT);
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
