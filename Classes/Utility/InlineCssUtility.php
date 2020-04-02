<?php
namespace Hostinghelden\HostingheldenTemplate\Utility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\DebugUtility as DU;

/**
 * Usage:
 * use the ?nocss=1 argument for excluding the inline css
 * handy for grunt penthouse task
 *
 * link: view-source:https://dummy.hostinghelden.at/?nocss=1
 *
 */

class InlineCssUtility {

  protected $apiurl = "http://localhost:5555/";
  protected $inlineurl = "http://localhost:5555/inline/";

  protected $criticalDir = "dist/css/critical_new";
  protected $buildCss = "dist/css/build-new.min.css";

  private function serviceAvailable() {
    return !!strpos(@get_headers($this->apiurl)[0], "200");
  }

  private function errorCheck($str) {
    return !strpos($str, "ERROR:");
  }


  public function render($cObj, $conf) {

    if (GeneralUtility::_GET("nocss")) {
      return "";
    }

    if (!isset($conf["enable"]) || $conf['enable'] == 0) {
      return "critical css disabled";
    }

    $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
    $storage = $resourceFactory->getDefaultStorage();
    $pid = $GLOBALS['TSFE']->id;
    $filename = $this->criticalDir."/$pid.min.css";

    if ($storage->hasFile($filename)) {
      $file = $storage->getFile($filename);
      $css = $file->getContents();
    } else {
      if ($storage->hasFile($this->buildCss)) {
        $buildcss = $storage->getFile($this->buildCss);
        if ($this->serviceAvailable()) {
          $url = $GLOBALS['TSFE']->cObj->typoLink_URL([
            'forceAbsoluteUrl' => 1,
            'forceAbsoluteUrl.scheme' => 'https',
            'no_cache' => 1,
            'additionalParams' => "&nocss=1",
            'parameter' => $pid

          ]);
          $storageConf = $storage->getConfiguration();
          $bucket = $storageConf["bucket"];
          $protocol = $storageConf["protocol"];
          $cssurl = $protocol.$bucket.'.s3.amazonaws.com/'.$this->buildCss;
          $args = [
            'url' => $url,
            'css' => $cssurl
          ];
          if (isset($conf["width"])) {
            $args['width'] = $conf["width"];
          }
          if (isset($conf["renderWaitTime"])) {
            $args['renderWaitTime'] = $conf["renderWaitTime"];
          }
          $fields = http_build_query($args);

          $ch = \curl_init($this->apiurl);
          \curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          \curl_setopt($ch, CURLOPT_POSTFIELDS, $fields );
          $css = \curl_exec($ch);
          \curl_close($ch);
          if ($this->errorCheck($css)) {
            $folder = $storage->getFolder($this->criticalDir);
            $file = $storage->createFile("$pid.min.css", $folder);
            $storage->setFileContents($file, $css);
            // ELSE: return $css with the error message
          }
        } else {
          return "critical css service not available.";
        }
      } else {
        return "build css not found.";
      }
    }
    return $css;
  }

  public function inline($cObj, $conf) {
    $url = $GLOBALS['TSFE']->cObj->typoLink_URL([
      'forceAbsoluteUrl' => 1,
      'no_cache' => 1,
      'additionalParams' => "&inline_css=1",
      'parameter' => $conf["pid"]
    ]);

    $ch = \curl_init($this->inlineurl);
    $fields = http_build_query([
      'url' => $url
    ]);
    \curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    \curl_setopt($ch, CURLOPT_POSTFIELDS, $fields );
    $html = \curl_exec($ch);
    \curl_close($ch);
    if ($this->errorCheck($html)) {
      return $html;
    } else {
      echo "ERROR";
    }
  }
}

