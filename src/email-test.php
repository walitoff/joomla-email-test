<?php
/**
 * Joomla Email Test CLI Tool
 *
 * A command-line utility for testing email functionality in Joomla sites.
 * This tool sends a test email using the configured Joomla email settings,
 * allowing administrators to verify that their email configuration is working correctly.
 *
 * Features:
 * - Supports Joomla 3.x, 4.x, and 5.x
 * - Uses Joomla's native email configuration
 * - Command-line interface for easy automation
 * - Customizable email subject and body
 *
 * Requirements:
 * - PHP 7.4 or newer
 * - Joomla 3.0 or newer
 * - Must be run from Joomla root directory
 * - CLI environment (command line)
 *
 * Usage: php email-test.php email-recipient [email-subject] [email-body]
 *
 * Parameters:
 * - email-recipient: Email address to send the test email to (required)
 * - email-subject: Custom email subject (optional, default: "Test email from Joomla")
 * - email-body: Custom email body in plain text (optional, default: "This is a test email from Joomla.")
 *
 * Examples:
 * - php email-test.php user@example.org
 * - php email-test.php user@example.org "Test email from Joomla"
 * - php email-test.php user@example.org "My Test Subject" "This is my custom test message."
 *
 * @author Ramil Valitov <ramil@walitoff.com>
 * @link https://walitoff.com
 */

// Checking if PHP is running in CLI mode
if (php_sapi_name() != 'cli') {
    exit('This application must be run on the command line.');
}

// Show help
if (empty($argv[1])) {
    echo <<<HELP
Joomla Email Test CLI Tool

A command-line utility for testing email functionality in Joomla sites.
This tool sends a test email using your Joomla's configured email settings.

Usage: php email-test.php email-recipient [email-subject] [email-body]

Arguments:
  email-recipient    Email address to send the test email to (required)
  email-subject      Custom email subject (optional)
                     Default: "Test email from Joomla"
  email-body         Custom email body in plain text format (optional)
                     Default: "This is a test email from Joomla."

Examples:
  php email-test.php user@example.org
  php email-test.php user@example.org "My Test Subject"
  php email-test.php user@example.org "My Test Subject" "This is my custom test message."

Requirements:
  - PHP 7.4 or newer
  - Joomla 3.0 or newer (supports Joomla 3.x, 4.x, and 5.x)
  - Must be run from Joomla root directory
  - CLI environment (command line)

Note: The tool uses your Joomla site's email configuration (SMTP, sendmail, etc.)
      as defined in the Global Configuration.

HELP;
    exit('Please provide email recipient as a first argument.' . PHP_EOL);
}

// Check a PHP version, we need 7.4 minimum
if (version_compare(PHP_VERSION, '7.4.0') < 0) {
    echo 'Detected PHP ' . PHP_VERSION . PHP_EOL;
    exit('This application requires PHP 7.4 or newer.' . PHP_EOL);
}

// Check that we are in Joomla root folder
if (!file_exists('configuration.php')) {
    exit('We are not in Joomla root folder.' . PHP_EOL);
}

// Get email recipient from command line
$emailRecipient = $argv[1];

// Get an optional email subject from command line
if (empty($argv[2])) {
    $emailSubject = 'Test email from Joomla';
} else {
    $emailSubject = $argv[2];
}

// Get an optional email body from command line
if (empty($argv[3])) {
    $emailBody = 'This is a test email from Joomla.';
} else {
    $emailBody = $argv[3];
}

// Include Joomla defines
try {
    define('_JEXEC', 1);
    define('JPATH_BASE', __DIR__);
    require_once JPATH_BASE . '/includes/defines.php';
    require_once JPATH_BASE . '/includes/framework.php';
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
    exit('Joomla framework not loaded.' . PHP_EOL);
}

if (!defined('JVERSION')) {
    exit('Failed to detect Joomla version.' . PHP_EOL);
}

//Check if Joomla version is supported
if (version_compare(JVERSION, '3.0.0', '<')) {
    echo 'Detected Joomla ' . JVERSION . PHP_EOL;
    exit('This application requires Joomla 3.0 or newer.' . PHP_EOL);
}
if (version_compare(JVERSION, '6.0.0', '>=')) {
    echo 'Detected Joomla ' . JVERSION . PHP_EOL;
    echo 'This application was not tested with Joomla 6.0 or newer.' . PHP_EOL;
}
$isJoomla4Plus = version_compare(JVERSION, '4.0.0', '>=');

// Get Joomla application
try {
    if ($isJoomla4Plus) {
        // For Joomla 4+ CLI usage, bootstrap the application properly
        // Boot the DI container
        $container = \Joomla\CMS\Factory::getContainer();

        // Set up session aliases for CLI compatibility
        $container->alias('session.web', 'session.web.site')
            ->alias('session', 'session.web.site')
            ->alias('JSession', 'session.web.site')
            ->alias(\Joomla\CMS\Session\Session::class, 'session.web.site')
            ->alias(\Joomla\Session\Session::class, 'session.web.site')
            ->alias(\Joomla\Session\SessionInterface::class, 'session.web.site');

        // Create and configure the application
        $app = $container->get(\Joomla\CMS\Application\SiteApplication::class);

        // Set the application in the factory
        \Joomla\CMS\Factory::$application = $app;

        // Create extension namespace map
        $app->createExtensionNamespaceMap();
    } else {
        $app = JFactory::getApplication('site');
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
    exit('Joomla application not loaded.' . PHP_EOL);
}

echo 'Detected PHP ' . PHP_VERSION . PHP_EOL;
echo 'Detected Joomla ' . JVERSION . PHP_EOL;

// Show email parameters
echo 'Email recipient: ' . $emailRecipient . PHP_EOL;
echo 'Email subject: ' . $emailSubject . PHP_EOL;
echo 'Email body: ' . $emailBody . PHP_EOL;

// Send email
try {
    if ($isJoomla4Plus) {
        $mailer = \Joomla\CMS\Factory::getMailer();
    } else {
        $mailer = JFactory::getMailer();
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
    exit('Joomla mailer not loaded.' . PHP_EOL);
}
try {
    $mailer->setSender(array($app->getCfg('mailfrom'), $app->getCfg('fromname')));
    $mailer->addRecipient($emailRecipient);
    $mailer->setSubject($emailSubject);
    $mailer->setBody($emailBody);
    $mailer->isHTML(false);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
    exit('Failed to set email parameters.' . PHP_EOL);
}
try {
    $mailer->send();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
    exit('Failed to send email.' . PHP_EOL);
}

echo 'Email sent. Check the mailbox.' . PHP_EOL;
