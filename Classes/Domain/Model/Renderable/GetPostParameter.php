<?php
namespace Hostinghelden\HostingheldenTemplate\Domain\Model\Renderable;
class GetPostParameter {
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
