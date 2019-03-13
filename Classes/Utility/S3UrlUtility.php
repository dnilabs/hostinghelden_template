<?php
namespace Hostinghelden\HostingheldenTemplate\Utility;
use TYPO3\CMS\Core\Utility\DebugUtility as DU;

/**
 * Usage:
 * mediaurl = USER
 * mediaurl.userFunc = Base\BaseTemplate\Utility\S3UrlUtility->getPublicUrl
 *
 */

class S3UrlUtility {
  public function getPublicUrl() {
    $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
    $storage = $resourceFactory->getDefaultStorage();
    $storageConf =  $storage->getConfiguration();
    return $storageConf["protocol"].$storageConf["publicBaseUrl"] . "/";
  }
}
