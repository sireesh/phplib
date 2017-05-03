<?php

/**
 * Created by PhpStorm.
 * User: sireesh
 * Date: 25/04/16
 *
 * php_logger class:
 * - contains lfile, lwrite and lclose public methods
 * - lfile sets path and name of log file
 * - lwrite writes message to the log file (and implicitly opens log file)
 * - lclose closes log file
 * - first call of lwrite method will open log file implicitly
 * - message is written with the following format: [d/M/Y:H:i:s] message
 */

class php_logger {

    /**
     *  The log file name and file pointer
     *  declare log file and file pointer as private properties
     *
     * @var string
     */
    private $log_file, $fp;

    /**
     * set log file (path and name)
     *
     * @param $path   path  File name with full path
     *
     * @access  public
     *
     */
    public function lfile($path) {
        $this->log_file = $path;
    } // End of lfile method

    /**
     * write message to the log file
     *
     * @param $message logging message
     *
     * @access  public
     *
     */
    public function lwrite($message) {
        // if file pointer doesn't exist, then open log file
        if (!is_resource($this->fp)) {
            $this->lopen();
        }
        // define script name (Now no need we are doing in single index.php file only)
        //$script_name = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
        // define current time and suppress E_WARNING if using the system TZ settings
        // (don't forget to set the INI setting date.timezone)
        $time = @date('[d/M/Y:H:i:s]');
        // write current time, script name and message to the log file
        fwrite($this->fp, "$time $message" . PHP_EOL);
    } // End of lwrite method

    /**
     * close log file (it's always a good idea to close a file when you're done with it)
     *
     *
     * @access  public
     *
     */
    public function lclose() {
        fclose($this->fp);
    } // End of lclose method

    /**
     * open log file
     *
     *
     * @access  private
     *
     */
    private function lopen() {
        // in case of Windows set default log file
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $log_file_default = 'c:/dashboardLog.log';
        }
        // set default log file for Linux and other systems
        else {
            $log_file_default = '/tmp/dashboardLog.log';
        }
        // define log file from lfile method or use previously set default
        $lfile = $this->log_file ? $this->log_file : $log_file_default;
        // open log file for writing only and place file pointer at the end of the file
        // (if the file does not exist, try to create it)
        $this->fp = fopen($lfile, 'a') or exit("Can't open $lfile!");
    } // End of lopen method

} //End of php_logger class
