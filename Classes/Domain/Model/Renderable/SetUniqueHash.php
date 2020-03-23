<?php
namespace Hostinghelden\HostingheldenTemplate\Domain\Model\Renderable;
class SetUniqueHash {
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
?>
