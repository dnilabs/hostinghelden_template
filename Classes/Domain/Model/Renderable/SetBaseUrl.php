<?php
namespace Hostinghelden\HostingheldenTemplate\Domain\Model\Renderable;
class SetBaseUrl {
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
?>
