<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfExtendedFilesystem provides basic utility to manipulate the file system.
 *
 * @package    symfony
 * @subpackage util
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfFilesystem.class.php 27816 2010-02-10 15:46:46Z FabianLange $
 */
 
class sfTaskExtendedFilesystem extends sfFilesystem
{
    public function removeAll($directory, $removeParent = false)
    {
        if ( ! is_dir($directory)) {
            return false;
        }
        
        $dirHandle = opendir($directory);
        
        while (false !== ($file = readdir($dirHandle))) {
            if ($file != '.' && $file != '..') {
                if (is_dir($directory . DIRECTORY_SEPARATOR . $file)) {
                    $this->removeAll($directory . DIRECTORY_SEPARATOR . $file, true);
                } else {
                    $this->remove($directory . DIRECTORY_SEPARATOR . $file);
                }
            }
        }
        
        closedir($dirHandle);
        
        if ($removeParent) {
            $this->remove($directory);
        }
    }
    
  /**
   * Executes a shell command.
   *
   * @param string $cmd            The command to execute on the shell
   * @param array  $stdoutCallback A callback for stdout output
   * @param array  $stderrCallback A callback for stderr output
   *
   * @return array An array composed of the content output and the error output
   */
  public function execute($cmd, $stdoutCallback = null, $stderrCallback = null)
  {
    $this->logSection('exec ', $cmd);

    $descriptorspec = array(
      1 => array('pipe', 'w'), // stdout
      2 => array('pipe', 'w'), // stderr
    );

    $process = proc_open($cmd, $descriptorspec, $pipes);
    if (!is_resource($process))
    {
      throw new RuntimeException('Unable to execute the command.');
    }

    stream_set_blocking($pipes[1], false);
    stream_set_blocking($pipes[2], false);

    $output = '';
    $err = '';
    while (!feof($pipes[1]))
    {
      foreach ($pipes as $key => $pipe)
      {
        if (!$line = fread($pipe, 128))
        {
          continue;
        }

        if (1 == $key)
        {
          // stdout
          $output .= $line;
          if ($stdoutCallback)
          {
            call_user_func($stdoutCallback, $line);
          }
        }
        else
        {
          // stderr
          $err .= $line;
          if ($stderrCallback)
          {
            call_user_func($stderrCallback, $line);
          }
        }
      }

      sleep(0.1);
    }

    fclose($pipes[1]);
    fclose($pipes[2]);

    if (($return = proc_close($process)) > 0)
    {
      throw new RuntimeException('Problem executing command.' . PHP_EOL . $err, $return);
    }

    return array($output, $err);
  }
}