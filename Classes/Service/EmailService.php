<?php
namespace Hostinghelden\HostingheldenTemplate\Service;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Core\Mail\MailMessage;

class EmailService {

  protected $emailView;

  function __construct() {
    $emailView = new StandaloneView;
    $emailView->setFormat('html');
    $emailView->setTemplateRootPaths([
      0 => 'typo3conf/ext/hostinghelden_template/Resources/Private/Templates/Email'
    ]);
    $emailView->setPartialRootPaths([
      0 => 'typo3conf/ext/hostinghelden_template/Resources/Private/Partials/Email'
    ]);
    $emailView->setLayoutRootPaths([
      0 => 'typo3conf/ext/hostinghelden_template/Resources/Private/Layouts/Email',
    ]);
    $this->emailView = $emailView;
  }

  public function setEmailView($emailView) {
    $this->emailView = $emailView;
  }

  public function getEmailView() {
    return $this->emailView;
  }

  public function sendTemplateEmail(
    array $recipient,
    array $sender,
    $subject,
    $templateName,
    array $variables = array(),
    array $attachments = array()
  ) {

    $emailView = $this->getEmailView();

    $emailView->setTemplate($templateName);
    $emailView->assignMultiple($variables);
    $emailBody = $emailView->render();

    $message = new MailMessage;
    $message->setTo($recipient)->setFrom($sender)->setSubject($subject);

    if (count($attachments)) {
      foreach ($attachments as $file) {
        $attachment = \Swift_Attachment::fromPath($file->getOriginalResource()->getPublicUrl());
        $message->attach($attachment);
      }
    }

    // HTML Email
    $message->setBody($emailBody, 'text/html');
    return $message->send();
  }

}
?>
