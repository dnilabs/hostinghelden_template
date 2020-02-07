<?php
declare(strict_types = 1);

namespace Hostinghelden\Hostinghelden\Slot;

use TYPO3\CMS\Seo\Canonical\CanonicalGenerator;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Frontend\Page\PageRepository;
use TYPO3\CMS\Frontend\Utility\CanonicalizationUtility;
class CanonicalSlot
{
    /**
     * @var Dispatcher
     */
    protected $signalSlotDispatcher;
    /**
     * @var CanonicalGenerator
     */
    protected $canonicalGenerator;

    /**
     * CanonicalGenerator constructor
     *
     * @param Dispatcher $signalSlotDispatcher
     */
    public function __construct(Dispatcher $signalSlotDispatcher = null)
    {
        if ($signalSlotDispatcher === null) {
            $signalSlotDispatcher = GeneralUtility::makeInstance(Dispatcher::class);
        }
        $this->signalSlotDispatcher = $signalSlotDispatcher;
        $this->canonicalGenerator = GeneralUtility::makeInstance(CanonicalGenerator::class);
    }

    /**
     * @return string
     */
    public function renderCanonical(): string
    {
        if (empty($href)) {
            // 1) Check if page show content from other page
            $href = $canonicalGenerator->checkContentFromPid();
        }
        if (empty($href)) {
            // 2) Check if page has canonical URL set
            $href = $canonicalGenerator->checkForCanonicalLink();
        }
        if (empty($href)) {
            // 3) Fallback, create canonical URL
            /* $href = $this->checkDefaultCanonical(); */
        }
        if (!empty($href)) {
            $canonical = '<link ' . GeneralUtility::implodeAttributes([
                    'rel' => 'canonical',
                    'href' => $href
                ], true) . '/>' . LF;
            $this->typoScriptFrontendController->additionalHeaderData[] = $canonical;
            return $canonical;
        }
        return '';
    }
}
