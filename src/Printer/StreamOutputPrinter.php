<?php


namespace miamioh\BehatSensuFormatter\Printer;

use Behat\Testwork\Output\Printer\OutputPrinter as PrinterInterface;

/**
 * Description of StreamOutputPrinter
 *
 * @author kidddw
 */
class StreamOutputPrinter implements PrinterInterface   {

    /**
     * Sets output path.
     *
     * @param string $path
     */
    public function setOutputPath($path)
    {
        // TODO: Implement setOutputPath() method.
    }


    /**
     * Sets output styles.
     *
     * @param array $styles
     */
    public function setOutputStyles(array $styles)
    {
        // TODO: Implement setOutputStyles() method.
    }



    /**
     * Forces output to be decorated.
     *
     * @param Boolean $decorated
     */
    public function setOutputDecorated($decorated)
    {
        // TODO: Implement setOutputDecorated() method.
    }


    /**
     * Sets output verbosity level.
     *
     * @param integer $level
     */
    public function setOutputVerbosity($level)
    {
        // TODO: Implement setOutputVerbosity() method.
    }


    /**
     * Writes message(s) to output stream.
     *
     * @param string|array $messages message or array of messages
     */
    public function write($messages)
    {
        print_r($messages);

    }


    /**
     * Writes newlined message(s) to output stream.
     *
     * @param string|array $messages message or array of messages
     */
    public function writeln($messages = '')
    {
        $this->write($messages);
        print_r("\n");

    }


    /**
     * Clear output stream, so on next write formatter will need to init (create) it again.
     */
    public function flush()
    {
        // TODO: Implement flush() method.
    }

        /**
     * Returns output verbosity level.
     *
     * @return integer
     *
     * @deprecated since 3.1, to be removed in 4.0
     */
    public function getOutputVerbosity()
    {
        // TODO: Implement getOutputVerbosity() method.
    }
       /**
     * Returns output path.
     *
     * @return null|string
     *
     * @deprecated since 3.1, to be removed in 4.0
     */
    public function getOutputPath()
    {
        // TODO: Implement getOutputPath() method.
    }

    /**
     * Returns output styles.
     *
     * @return array
     *
     * @deprecated since 3.1, to be removed in 4.0
     */
    public function getOutputStyles()
    {
        // TODO: Implement getOutputStyles() method.
    }
    /**
     * Returns output decoration status.
     *
     * @return null|Boolean
     *
     * @deprecated since 3.1, to be removed in 4.0
     */
    public function isOutputDecorated()
    {
        // TODO: Implement isOutputDecorated() method.
    }


}
