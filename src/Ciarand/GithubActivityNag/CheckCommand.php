<?php

namespace Ciarand\GithubActivityNag;

// Symfony components
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

// Guzzle components
use Guzzle\Http\Client;

// Native PHP stuff I don't want to prepend with \
use DateTime;
use DateTimeZone;

// Naggers
use Ciarand\GithubActivityNag\Naggers\ExitCode;
use Ciarand\GithubActivityNag\Naggers\HipChat;
use Ciarand\GithubActivityNag\Naggers\Pushover;

class CheckCommand extends Command
{

    protected $githubName;
    protected $apiPayload;
    protected $acceptableEvents = array(
        'PushEvent',
        'PullRequestEvent',
        'CreateEvent',
    );
    protected $nagger;

    protected function configure()
    {
        $this
            ->setName('check')
            ->setDescription("Check Github's API for a user's last contribution")
            ->addOption(
                'nagger',
                'nag',
                InputOption::VALUE_REQUIRED,
                'The nagger to use. Defaults to exit code (1 if the user needs to be nagged)',
                'ExitCode'
            )
            ->addOption(
                'debug',
                'd',
                InputOption::VALUE_REQUIRED,
                "Whether to assume the user is lazy for debugging purposes",
                false
            )
        ;
    }

    /**
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this
            ->init($input)
            ->makeApiCall()
            ->nagger->run(
                $input->getOption('debug') ?: $this->isLazy()
            )
        ;
    }

    protected function init(InputInterface $input)
    {
        $this->config = Yaml::parse(file_get_contents('config.yml'));
        $this->githubName = $this->config['github_username'];
        $nagger = $input->getOption('nagger');
        $naggerClass = "Ciarand\GithubActivityNag\Naggers\\$nagger";
        $this->nagger = new $naggerClass(
            $this->config[strtolower($nagger)]
        );
        return $this;
    }

    protected function isLazy()
    {
        $events = $this->filterLazyEvents();
        $event = reset($events);
        $localTimezone = new DateTimeZone('America/Los_Angeles');
        $lastEventDate = DateTime::createFromFormat(
            'Y-m-d\TH:i:sZ',
            $event['created_at'],
            new DateTimeZone('UTC')
        );

        $lastEventDate->setTimezone($localTimezone);
        $currentDate = new DateTime("now", $localTimezone);

        return $lastEventDate->format('Y-m-d') !== $currentDate->format('Y-m-d');
    }

    protected function filterLazyEvents()
    {
        // Payload is an array of objects, so filter it by "ignoredEvents"
        return array_filter(
            $this->apiPayload,
            function ($obj) {
                if (in_array($obj['type'], $this->acceptableEvents)) {
                    return $obj;
                }
            }
        );
    }

    protected function makeApiCall()
    {
        // Create a client and provide a base URL
        $client = new Client('https://api.github.com');

        $endPoint = '/users/' . urlencode($this->githubName) . '/events';
        $this->apiPayload = $client->get($endPoint)->send()->json();
        // Return $this for method chaining
        return $this;
    }
}
