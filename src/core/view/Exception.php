<?php
/**
 * Created by PhpStorm.
 * User: wind
 * Date: 11/10/2016
 * Time: 11:11 SA
 */

namespace EXP\Core\View;

interface Throwable
{

    /**
     * Gets the message
     * @link http://php.net/manual/en/throwable.getmessage.php
     * @return string
     * @since 7.0
     */
    public function getMessage();

    /**
     * Gets the exception code
     * @link http://php.net/manual/en/throwable.getcode.php
     * @return int <p>
     * Returns the exception code as integer in
     * {@see Exception} but possibly as other type in
     * {@see Exception} descendants (for example as
     * string in {@see PDOException}).
     * </p>
     * @since 7.0
     */
    public function getCode();

    /**
     * Gets the file in which the exception occurred
     * @link http://php.net/manual/en/throwable.getfile.php
     * @return string Returns the name of the file from which the object was thrown.
     * @since 7.0
     */
    public function getFile();

    /**
     * Gets the line on which the object was instantiated
     * @link http://php.net/manual/en/throwable.getline.php
     * @return int Returns the line number where the thrown object was instantiated.
     * @since 7.0
     */
    public function getLine();

    /**
     * Gets the stack trace
     * @link http://php.net/manual/en/throwable.gettrace.php
     * @return array <p>
     * Returns the stack trace as an array in the same format as
     * {@see debug_backtrace()}.
     * </p>
     * @since 7.0
     */
    public function getTrace();

    /**
     * Gets the stack trace as a string
     * @link http://php.net/manual/en/throwable.gettraceasstring.php
     * @return string Returns the stack trace as a string.
     * @since 7.0
     */
    public function getTraceAsString();

    /**
     * Returns the previous Throwable
     * @link http://php.net/manual/en/throwable.getprevious.php
     * @return Throwable Returns the previous {@see Throwable} if available, or <b>NULL</b> otherwise.
     * @since 7.0
     */
    public function getPrevious();

    /**
     * Gets a string representation of the thrown object
     * @link http://php.net/manual/en/throwable.tostring.php
     * @return string <p>Returns the string representation of the thrown object.</p>
     * @since 7.0
     */
    public function __toString();
}
/**
 * Exception is the base class for
 * all Exceptions.
 * @link http://php.net/manual/en/class.exception.php
 */
class Exception implements Throwable {
    protected $message;
    protected $code;
    protected $file;
    protected $line;


    /**
     * Clone the exception
     * @link http://php.net/manual/en/exception.clone.php
     * @return void
     * @since 5.1.0
     */
    final private function __clone() { }

    /**
     * Construct the exception. Note: The message is NOT binary safe.
     * @link http://php.net/manual/en/exception.construct.php
     * @param string $message [optional] The Exception message to throw.
     * @param int $code [optional] The Exception code.
     * @param Exception $previous [optional] The previous exception used for the exception chaining. Since 5.3.0
     * @since 5.1.0
     */
    public function __construct($message = "", $code = 0, Exception $previous = null) { }

    /**
     * Gets the Exception message
     * @link http://php.net/manual/en/exception.getmessage.php
     * @return string the Exception message as a string.
     * @since 5.1.0
     */
    final public function getMessage() { }

    /**
     * Gets the Exception code
     * @link http://php.net/manual/en/exception.getcode.php
     * @return mixed|int the exception code as integer in
     * <b>Exception</b> but possibly as other type in
     * <b>Exception</b> descendants (for example as
     * string in <b>PDOException</b>).
     * @since 5.1.0
     */
    final public function getCode() { }

    /**
     * Gets the file in which the exception occurred
     * @link http://php.net/manual/en/exception.getfile.php
     * @return string the filename in which the exception was created.
     * @since 5.1.0
     */
    final public function getFile() { }

    /**
     * Gets the line in which the exception occurred
     * @link http://php.net/manual/en/exception.getline.php
     * @return int the line number where the exception was created.
     * @since 5.1.0
     */
    final public function getLine() { }

    /**
     * Gets the stack trace
     * @link http://php.net/manual/en/exception.gettrace.php
     * @return array the Exception stack trace as an array.
     * @since 5.1.0
     */
    final public function getTrace() { }

    /**
     * Returns previous Exception
     * @link http://php.net/manual/en/exception.getprevious.php
     * @return Exception the previous <b>Exception</b> if available
     * or null otherwise.
     * @since 5.3.0
     */
    final public function getPrevious() { }

    /**
     * Gets the stack trace as a string
     * @link http://php.net/manual/en/exception.gettraceasstring.php
     * @return string the Exception stack trace as a string.
     * @since 5.1.0
     */
    final public function getTraceAsString() { }

    /**
     * String representation of the exception
     * @link http://php.net/manual/en/exception.tostring.php
     * @return string the string representation of the exception.
     * @since 5.1.0
     */
    public function __toString() { }
}