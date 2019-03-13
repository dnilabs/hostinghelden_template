<?php
namespace Hostinghelden\HostingheldenTemplate\Task;


class DeleteCriticalTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {

  public function execute() {

    $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
    /* $resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\ResourceFactory'); */

    $storage = $resourceFactory->getDefaultStorage();

    if ($storage->hasFolder("dist/css/critical_new")) {
      $files = $storage->getFileIdentifiersInFolder("dist/css/critical_new/");
      foreach($files as $fileidentifier) {
        /* echo "Delete File: " . $fileidentifier; */
        $file = $storage->getFile($fileidentifier);
        $storage->deleteFile($file);
      }

      /* doesnt work */
      /* $folder = $storage->getFolder("dist/css/critical"); */
      /* $storage->deleteFolder($folder, true); */
      /* $storage->createFolder("critical", "dist/css"); */
    }
    return true;
  }


}
