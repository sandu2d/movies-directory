<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\Language;

class ExtractMovieDetailsFromOmdbCommand extends Command
{
    protected static $defaultName = 'app:movie:extract';
    private $container;


    public function __construct(
        ContainerInterface $container
    ) {
        parent::__construct();

        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setDescription('Extract data about movie from omdb service. Example: {command} title Matrix')
            ->addArgument('type', InputArgument::REQUIRED, 'Type: [title/t/id/i]')
            ->addArgument('value', InputArgument::REQUIRED, 'Value')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $type = $input->getArgument('type');
        $value = $input->getArgument('value');
        $httpClient = new CurlHttpClient();

        $result = [
            "name" => "The Matrix",
            "description" => "Thomas A. Anderson is a man living two lives.",
            "year" => 1999,
            "genre" => [
              0 => "Action",
              1 => "Sci-Fi",
            ],
            "imdbrate" => "8.7",
            "actors" => [
              0 => "Keanu Reeves",
              1 => "Laurence Fishburne",
              2 => "Carrie-Anne Moss",
              3 => "Hugo Weaving",
            ],
            "language" => "English",
            "country" => "USA",
            "poster" => "https://m.media-amazon.com/images/M/MV5BNzQzOTk3OTAtNDQ0Zi00ZTVkLWI0MTEtMDllZjNkYzNjNTc4L2ltYWdlXkEyXkFqcGdeQXVyNjU0OTQ0OTY@._V1_SX300.jpg",
        ];

        $this->uploadMovie($result);
        exit;

        switch ($type) {
            case 't':
            case 'title': {
                $type = 't';
                break;
            }
            case 'i':
            case 'id': {
                $type = 'i';
                break;
            }
            default: {
                $io->note('You sent incorrect type. Choose title or id.');
                exit;
            }
        }

        $output->writeln([
            "Type: {$type}",
            "Value: {$value}",
            '',
            'Start request to omdb',
        ]);

        $response = $httpClient->request('GET', "http://www.omdbapi.com/?{$type}={$value}&plot=full&apikey=453563ad");
        $result = $response->toArray();
        
        if ($result['Response'] == 'False') {
            $io->note($result['Error']);
            exit;
        }

        $output->writeln([
            'The movie was found',
            'Data is uploading to DB'
        ]);

        $movie = $this->uploadMovie([
            'name' => $result['Title'],
            'description' => $result['Plot'],
            'year' => (int) $result['Year'],
            'genre' => $this->explodeString($result['Genre']),
            'imdbrate' => $result['imdbRating'],
            'actors' => $this->explodeString($result['Actors']),
            'language' => $result['Language'],
            'country' => $result['Country'],
            'poster' => $result['Poster'],
        ]);
    }

    private function uploadMovie(array $details) {
        $language = $this->container
            ->get('doctrine')
            ->getRepository(Language::class)
            ->findOneBy([
                'name' => $details['language'],
            ]);

        dump(
            $language ? $language->getName : 'not found'
        );
    }

    private function explodeString(string $text)
    {
        $array = explode(',', $text);
        $result = [];

        foreach ($array as $elem) {
            $result[] = trim($elem);
        }

        return $result;
    }
}
