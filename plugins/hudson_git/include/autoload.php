<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
function autoloadec87486790e99b91dbf478867ea37115($class) {
    static $classes = null;
    if ($classes === null) {
        $classes = array(
            'hudson_gitplugin' => '/hudson_gitPlugin.class.php',
            'tuleap\\hudsongit\\hook\\hookcontroller' => '/HudsonGit/Hook/HookController.php',
            'tuleap\\hudsongit\\hook\\hookdao' => '/HudsonGit/Hook/HookDao.php',
            'tuleap\\hudsongit\\hook\\hookpresenter' => '/HudsonGit/Hook/HookPresenter.php',
            'tuleap\\hudsongit\\hook\\hooktriggercontroller' => '/HudsonGit/Hook/HookTriggerController.php',
            'tuleap\\hudsongit\\job\\hudsonjoburlfilenotfoundexception' => '/HudsonGit/Job/CannotCreateJobException.php',
            'tuleap\\hudsongit\\job\\job' => '/HudsonGit/Job/Job.php',
            'tuleap\\hudsongit\\job\\jobdao' => '/HudsonGit/Job/JobDao.php',
            'tuleap\\hudsongit\\job\\jobmanager' => '/HudsonGit/Job/JobManager.php',
            'tuleap\\hudsongit\\logger' => '/Logger.php',
            'tuleap\\hudsongit\\plugin\\plugindescriptor' => '/HudsonGit/Plugin/PluginDescriptor.php',
            'tuleap\\hudsongit\\plugin\\plugininfo' => '/HudsonGit/Plugin/PluginInfo.php',
            'tuleap\\hudsongit\\pollingresponse' => '/HudsonGit/PollingResponse.php',
            'tuleap\\hudsongit\\pollingresponsefactory' => '/HudsonGit/PollingResponseFactory.php'
        );
    }
    $cn = strtolower($class);
    if (isset($classes[$cn])) {
        require dirname(__FILE__) . $classes[$cn];
    }
}
spl_autoload_register('autoloadec87486790e99b91dbf478867ea37115');
// @codeCoverageIgnoreEnd
