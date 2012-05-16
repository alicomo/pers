<?php

class sfDatabaseBackupTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('hostname', null, sfCommandOption::PARAMETER_REQUIRED, 'The hostname', null),
    ));
 
    $this->namespace = 'admin-task';
    $this->name = 'backup';
    $this->briefDescription = 'Makes a backup of the database (mysql)';
 
    $this->detailedDescription = <<<EOF
The [db:backup|INFO] task makes a backup file of the database:
 
  [./symfony admin-task:backup]
EOF;
  }
  
  protected function execute($arguments = array(), $options = array())
  {
  	$configuration = new ProjectConfiguration();
  	$filesystem = new sfTaskExtendedFilesystem();
  	
  	$dbs = sfYaml::load(sfConfig::get('sf_config_dir') . DIRECTORY_SEPARATOR . 'databases.yml');
    $dbInfos = $dbs['all']['doctrine']['param'];
    $filename = 'db'
               . ( ! empty($options['hostname'])
                   ? '_[' . $options['hostname'] . ']_'
                   : '_')
               . 'backup_' . date('Ymd_his');
  	$cmd = preg_replace('~(\w+):host=(.*);dbname=(.*)~',
                        'mysqldump -h \\2 -u ' . escapeshellarg($dbInfos['username']) . ' --password=' . escapeshellarg($dbInfos['password']) . ' \\3 > ' . escapeshellarg(sfConfig::get('sf_data_dir') . DIRECTORY_SEPARATOR . 'backup/' . $filename . '.sql'), $dbInfos['dsn']);
  	
  	$filesystem->execute($cmd);
  	
  	$zip = new ZipArchive();
  	
    if ($zip->open(sfConfig::get('sf_data_dir') . DIRECTORY_SEPARATOR . 'backup/' . $filename . '.zip', ZIPARCHIVE::CREATE) !== true) {
      throw new Exception('Cannot open zip archive');
    }
    
    $zip->addFile(sfConfig::get('sf_data_dir') . DIRECTORY_SEPARATOR . 'backup/' . $filename . '.sql', $filename . '.sql');
    $zip->close();
      
    $this->logSection('db', 'Dumped Database');
    return 'Dumped Database';
  }
}