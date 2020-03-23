<?php
namespace Hostinghelden\HostingheldenTemplate\Domain\Model\Renderable;

class setUniqueHash {
  /**
   * @param \TYPO3\CMS\Form\Domain\Runtime\FormRuntime $formRuntime
   * @param \TYPO3\CMS\Form\Domain\Model\Renderable\RenderableInterface $renderable
   * @param mixed $elementValue submitted value of the element *before post processing*
   * @param array $requestArguments submitted raw request values
   * @return void
   */
  public function afterSubmit(
    \TYPO3\CMS\Form\Domain\Runtime\FormRuntime $formRuntime,
    \TYPO3\CMS\Form\Domain\Model\Renderable\RenderableInterface $renderable,
    $elementValue, array $requestArguments = []
  ) {
    $identifier = $renderable->getIdentifier();

    if($identifier == 'uniquehash') {
      $token = bin2hex(random_bytes(16));
      $elementValue = $token;
    }

    return $elementValue;
  }
}

class setBaseUrl {
  /**
   * @param \TYPO3\CMS\Form\Domain\Runtime\FormRuntime $formRuntime
   * @param \TYPO3\CMS\Form\Domain\Model\Renderable\RenderableInterface $renderable
   * @param mixed $elementValue submitted value of the element *before post processing*
   * @param array $requestArguments submitted raw request values
   * @return void
   */

  public function afterSubmit(
    \TYPO3\CMS\Form\Domain\Runtime\FormRuntime $formRuntime,
    \TYPO3\CMS\Form\Domain\Model\Renderable\RenderableInterface $renderable,
    $elementValue, array $requestArguments = []
  ) {
    $identifier = $renderable->getIdentifier();
    if($identifier == 'confirmurl')
    {
      $verifypid = $requestArguments['confirmurl'];
      $url = $GLOBALS['TSFE']->cObj->typoLink_URL(
        array(
          'parameter' => $verifypid,
          'forceAbsoluteUrl' => true,
        )
      );
      $elementValue = $url;
    }

    return $elementValue;
  }
}


class getPostParameter {
  /**
   * @param \TYPO3\CMS\Form\Domain\Model\Renderable\RenderableInterface $renderable
   * @return void
   */
  public function afterBuildingFinished(\TYPO3\CMS\Form\Domain\Model\Renderable\RenderableInterface $renderable) {
    $identifier = $renderable->getIdentifier();
    if($identifier == 'hash') {
      $GPvariable = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('uniquehash');
      $renderable->setDefaultValue($GPvariable);
    }
    return $elementValue;
  }
}


?>
