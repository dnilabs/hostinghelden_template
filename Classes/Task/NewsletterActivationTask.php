<?php
namespace Hostinghelden\HostingheldenTemplate\Task;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction;
use TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface as cmi;
use Hostinghelden\HostingheldenTemplate\Service\EmailService;

class NewsletterActivationTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {
  protected $emailService = NULL;

  public function execute() {
    $emailService = GeneralUtility::makeInstance(EmailService::class);
    $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);
    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_address');

    $queryBuilder->getRestrictions()->removeByType(HiddenRestriction::class);

    $allsettings = $configurationManager->getConfiguration(
      cmi::CONFIGURATION_TYPE_FULL_TYPOSCRIPT,
      'base_template'
    );
    $settings = $allsettings["plugin."]["tx_basetemplate_newsletter."];
    $confirmpid = $settings['confirmpid'];
    $confirmurl = $settings['confirmurl'];
    $sender = $settings['sender'];

    $statement = $queryBuilder
      ->select('uid', 'email')
      ->from('tt_address')
      ->where(
        $queryBuilder->expr()->eq('hidden', 1)
      )
      ->andWhere(
        $queryBuilder->expr()->comparison(
          $queryBuilder->expr()->length('description'),
          ExpressionBuilder::EQ,
          $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT)
        )
      )
      ->setMaxResults(50)
      ->execute();

    while ($row = $statement->fetch()) {
      // Do something with that single row
      $token = bin2hex(random_bytes(16));
      $uid = $row["uid"];
      $email = $row["email"];

      // update activationcode
      $queryBuilder
        ->update('tt_address')
        ->where(
          $queryBuilder->expr()->eq('uid', $uid)
        )
        ->set('description', $token)
        ->execute();

      // email
      $emailService->sendTemplateEmail(
        [ $email ],
        [ $sender ],
        "Einwilligungserklärung Newsletter",
        "NewsletterAktivierung",
        [
          "confirmpid" => $confirmpid,
          "confirmurl" => $confirmurl,
          "token" => $token
        ],
        []
      );
    }

    return true;
  }


}
