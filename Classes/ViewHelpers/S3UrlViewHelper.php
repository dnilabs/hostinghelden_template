<?php
namespace Hostinghelden\HostingheldenTemplate\ViewHelpers;
use Hostinghelden\HostingheldenTemplate\Utility\S3UrlUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;

class S3UrlViewHelper extends AbstractViewHelper implements CompilableInterface {

    /**
     * Render
     */
    public function render()
    {
        $S3UrlUtility = GeneralUtility::makeInstance(S3UrlUtility::class);
        return $S3UrlUtility->getPublicUrl();
    }

}

