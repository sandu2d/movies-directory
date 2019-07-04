<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Award;
use App\Entity\AwardCategory;
use App\Entity\Country;
use App\Entity\Director;
use App\Entity\Genre;
use App\Entity\Language;
use App\Entity\Movie;
use App\Form\ActorType;
use App\Form\AwardCategoryType;
use App\Form\AwardType;
use App\Form\CountryType;
use App\Form\DirectorType;
use App\Form\GenreType;
use App\Entity\MovieAward;
use App\Form\LanguageType;
use App\Form\MovieType;
use App\Traits\Map\Actor as ActorMap;
use App\Traits\Map\Award as AwardMap;
use App\Traits\Map\Director as DirectorMap;
use App\Traits\Map\Movie as MovieMap;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;
use App\Form\MovieAwardType;

class AdminController extends AbstractController
{
    use ActorMap;
    use DirectorMap;
    use MovieMap;
    use AwardMap;

    /**
     * @Route("/admin", name="admin", methods={"GET"})
     */
    public function index(TranslatorInterface $translator)
    {
        return $this->render('admin/index.html.twig', [
            'title' => $translator->trans('admin.dashboard.title'),
            'page' => 'dashboard',
        ]);
    }

    /**
     * View list of movies
     *
     * @Route("/admin/movies", name="admin.movies", methods={"GET"})
     */
    public function movies(TranslatorInterface $translator)
    {
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findAll();

        $translator->setLocale('ro');

        return $this->render('admin/movies/movies.html.twig', [
            'title' => $translator->trans('admin.movies.index.title'),
            'page' => 'movies',
            'movies' => $this->mapCollectionMovie($movies),
        ]);
    }

    /**
     * Create a movie
     *
     * @Route("/admin/movies/create", name="admin.movies.create", methods={"GET"})
     */
    public function moviesCreate(FormInterface $form = null, TranslatorInterface $translator)
    {
        $movie = new Movie();
        $form = $form ?? $this->createForm(MovieType::class, $movie, [
            'action' => $this->generateUrl('admin.movies.actions.create'),
        ]);

        return $this->render('admin/movies/create.html.twig', [
            'title' => $translator->trans('admin.movies.create.title'),
            'page' => 'movies',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Edit a movie
     *
     * @Route("/admin/movies/edit/{movieId}", name="admin.movies.edit", methods={"GET"})
     */
    public function moviesEdit(string $movieId, TranslatorInterface $translator)
    {
        $movie = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->find($movieId);

        $movie->setPoster(
            new File($this->getParameter('posters_directory') . '/' . $movie->getPoster())
        );

        $form = $this->createForm(MovieType::class, $movie, [
            'action' => $this->generateUrl('admin.movies.actions.edit', [
                'movieId' => $movieId,
            ]),
            'isEdit' => true,
        ]);

        return $this->render('admin/movies/edit.html.twig', [
            'title' => $translator->trans('admin.movies.edit.title'),
            'page' => 'movies',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Remove a movie
     *
     * @Route("/admin/movies/remove/{movieId}", name="admin.movies.remove", methods={"GET"})
     */
    public function moviesRemove(string $movieId)
    {
        return $this->forward('App\Controller\MovieController::remove', [
            'movieId' => $movieId,
        ]);
    }

    /**
     * View list of movies` awards
     *
     * @param string $movieId
     * @Route("/admin/movies/{movieId}/awards", name="admin.movies.awards", methods={"GET"})
     */
    public function moviesAwards(string $movieId)
    {
        $movie = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->find($movieId);

        $awards = $movie->getMovieAwards();

        return $this->render('admin/movies/awards/awards.html.twig', [
            'title' => $movie->getName() . ' - awards',
            'page' => 'movies',
            'awards' => $awards,
            'movie' => $movie,
        ]);
    }

    /**
     * Create an award for the movie
     *
     * @param string $movieId
     * @Route("/admin/movies/{movieId}/awards/create", name="admin.movies.awards.create", methods={"GET"})
     */
    public function moviesAwardsCreate(string $movieId)
    {
        $movieAward = new MovieAward();
        $form = $this->createForm(MovieAwardType::class, $movieAward, [
            'action' => $this->generateUrl('admin.movies.awards.actions.create', [
                'movieId' => $movieId,
            ]),
        ]);

        return $this->render('admin/movies/awards/create.html.twig', [
            'title' => 'Add an award',
            'page' => 'movies',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Edit an award for the movie
     *
     * @param string $movieId
     * @Route("/admin/movies/{movieId}/awards/edit/{awardId}", name="admin.movies.awards.edit", methods={"GET"})
     */
    public function moviesAwardsEdit(string $movieId, string $awardId)
    {
        $movieAward = $this->getDoctrine()
            ->getRepository(MovieAward::class)
            ->find($awardId);

        $form = $this->createForm(MovieAwardType::class, $movieAward, [
            'action' => $this->generateUrl('admin.movies.awards.actions.edit', [
                'movieId' => $movieId,
                'awardId' => $awardId,
            ]),
            'isEdit' => true,
        ]);

        return $this->render('admin/movies/awards/edit.html.twig', [
            'title' => 'Edit an award',
            'page' => 'movies',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Remove an award for the movie
     *
     * @param string $movieId
     * @Route("/admin/movies/{movieId}/awards/remove/{awardId}", name="admin.movies.awards.remove", methods={"GET"})
     */
    public function moviesAwardsRemove(string $movieId, string $awardId)
    {
        return $this->forward('App\Controller\MovieAwardController::remove', [
            'movieId' => $movieId,
            'awardId' => $awardId,
        ]);
    }

    /**
     * View list of actors
     *
     * @Route("/admin/actors", name="admin.actors", methods={"GET"})
     */
    public function actors()
    {
        $actors = $this->getDoctrine()
            ->getRepository(Actor::class)
            ->findAll();

        return $this->render('admin/actors/actors.html.twig', [
            'title' => 'Actors list',
            'page' => 'actors',
            'actors' => $this->mapCollectionActor($actors),
        ]);
    }

    /**
     * Create an actor
     *
     * @Route("/admin/actors/create", name="admin.actors.create", methods={"GET"})
     */
    public function actorsCreate()
    {
        $actor = new Actor();
        $form = $this->createForm(ActorType::class, $actor, [
            'action' => $this->generateUrl('admin.actors.actions.create'),
        ]);

        return $this->render('admin/actors/create.html.twig', [
            'title' => 'Add an actor',
            'page' => 'actors',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Edit an actor
     *
     * @Route("/admin/actors/edit/{actorId}", name="admin.actors.edit", methods={"GET"})
     */
    public function actorsEdit(string $actorId)
    {
        $actor = $this->getDoctrine()
            ->getRepository(Actor::class)
            ->find($actorId);

        $form = $this->createForm(ActorType::class, $actor, [
            'action' => $this->generateUrl('admin.actors.actions.edit', [
                'actorId' => $actorId,
            ]),
            'isEdit' => true,
        ]);

        return $this->render('admin/actors/edit.html.twig', [
            'title' => 'Edit an actor',
            'page' => 'actors',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Remove an actor
     *
     * @Route("/admin/actors/remove/{actorId}", name="admin.actors.remove", methods={"GET"})
     */
    public function actorsRemove(string $actorId)
    {
        return $this->forward('App\Controller\ActorController::remove', [
            'actorId' => $actorId,
        ]);
    }

    /**
     * View languages page
     *
     * @Route("/admin/languages", name="admin.languages", methods={"GET"})
     */
    public function languages()
    {
        $languages = $this->getDoctrine()
            ->getRepository(Language::class)
            ->findAll();

        return $this->render('admin/languages/index.html.twig', [
            'title' => 'Languages list',
            'page' => 'languages',
            'languages' => $languages,
        ]);
    }

    /**
     * Create language page
     *
     * @Route("/admin/languages/create", name="admin.languages.create", methods={"GET"})
     */
    public function languagesCreate()
    {
        $lang = new Language();
        $form = $this->createForm(LanguageType::class, $lang, [
            'action' => $this->generateUrl('admin.languages.actions.create'),
        ]);

        return $this->render('admin/languages/create.html.twig', [
            'title' => 'Add a language',
            'page' => 'languages',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Edit language page
     *
     * @Route("/admin/languages/edit/{langId}", name="admin.languages.edit", methods={"GET"})
     */
    public function languagesEdit(string $langId)
    {
        $lang = $this->getDoctrine()
            ->getRepository(Language::class)
            ->find($langId);

        $form = $this->createForm(LanguageType::class, $lang, [
            'action' => $this->generateUrl('admin.languages.actions.edit', [
                'langId' => $langId,
            ]),
            'isEdit' => true,
        ]);

        return $this->render('admin/languages/edit.html.twig', [
            'title' => 'Edit a language',
            'page' => 'languages',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Remove a language
     *
     * @Route("/admin/languages/remove/{langId}", name="admin.languages.remove", methods={"GET"})
     */
    public function languagesRemove(string $langId)
    {
        return $this->forward('App\Controller\LanguageController::remove', [
            'langId' => $langId,
        ]);
    }

    /**
     * List of countries
     *
     * @Route("/admin/countries", name="admin.countries", methods={"GET"})
     */
    public function countries()
    {
        $countries = $this->getDoctrine()
            ->getRepository(Country::class)
            ->findAll();

        return $this->render('admin/countries/index.html.twig', [
            'title' => 'Countries list',
            'page' => 'countries',
            'countries' => $countries,
        ]);
    }

    /**
     * Create country page
     *
     * @Route("/admin/countries/create", name="admin.countries.create", methods={"GET"})
     */
    public function countriesCreate()
    {
        $country = new Country();
        $form = $this->createForm(CountryType::class, $country, [
            'action' => $this->generateUrl('admin.countries.actions.create'),
        ]);

        return $this->render('admin/countries/create.html.twig', [
            'title' => 'Add a country',
            'page' => 'countries',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Edit country page
     *
     * @Route("/admin/countries/edit/{countryId}", name="admin.countries.edit", methods={"GET"})
     */
    public function countriesEdit(string $countryId)
    {
        $country = $this->getDoctrine()
            ->getRepository(Country::class)
            ->find($countryId);

        $form = $this->createForm(CountryType::class, $country, [
            'action' => $this->generateUrl('admin.countries.actions.edit', [
                'countryId' => $countryId,
            ]),
            'isEdit' => true,
        ]);

        return $this->render('admin/countries/edit.html.twig', [
            'title' => 'Edit a country',
            'page' => 'countries',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Remove a country
     *
     * @Route("/admin/countries/remove/{countryId}", name="admin.countries.remove", methods={"GET"})
     */
    public function countriesRemove(string $countryId)
    {
        return $this->forward('App\Controller\CountryController::remove', [
            'countryId' => $countryId,
        ]);
    }

    /**
     * List of genres
     *
     * @Route("/admin/genres", name="admin.genres", methods={"GET"})
     */
    public function genres()
    {
        $genres = $this->getDoctrine()
            ->getRepository(Genre::class)
            ->findAll();

        return $this->render('admin/genres/index.html.twig', [
            'title' => 'Genres list',
            'page' => 'genres',
            'genres' => $genres,
        ]);
    }

    /**
     * Create genre page
     *
     * @Route("/admin/genres/create", name="admin.genres.create", methods={"GET"})
     */
    public function genresCreate()
    {
        $genre = new Genre();
        $form = $this->createForm(GenreType::class, $genre, [
            'action' => $this->generateUrl('admin.genres.actions.create'),
        ]);

        return $this->render('admin/genres/create.html.twig', [
            'title' => 'Add a genre',
            'page' => 'genres',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Edit genre page
     *
     * @Route("/admin/genres/edit/{genreId}", name="admin.genres.edit", methods={"GET"})
     */
    public function genresEdit(string $genreId)
    {
        $genre = $this->getDoctrine()
            ->getRepository(Genre::class)
            ->find($genreId);

        $form = $this->createForm(GenreType::class, $genre, [
            'action' => $this->generateUrl('admin.genres.actions.edit', [
                'genreId' => $genreId,
            ]),
            'isEdit' => true,
        ]);

        return $this->render('admin/genres/edit.html.twig', [
            'title' => 'Edit a genre',
            'page' => 'genres',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Remove a genre
     *
     * @Route("/admin/genres/remove/{genreId}", name="admin.genres.remove", methods={"GET"})
     */
    public function genresRemove(string $genreId)
    {
        return $this->forward('App\Controller\GenreController::remove', [
            'genreId' => $genreId,
        ]);
    }

    /**
     * List of directors
     *
     * @Route("/admin/directors", name="admin.directors", methods={"GET"})
     */
    public function directors()
    {
        $directors = $this->getDoctrine()
            ->getRepository(Director::class)
            ->findAll();

        return $this->render('admin/directors/index.html.twig', [
            'title' => 'Directors list',
            'page' => 'directors',
            'directors' => $this->mapCollectionDirector($directors),
        ]);
    }

    /**
     * Create director page
     *
     * @Route("/admin/directors/create", name="admin.directors.create", methods={"GET"})
     */
    public function directorsCreate()
    {
        $director = new Director();
        $form = $this->createForm(DirectorType::class, $director, [
            'action' => $this->generateUrl('admin.directors.actions.create'),
        ]);

        return $this->render('admin/directors/create.html.twig', [
            'title' => 'Add a director',
            'page' => 'directors',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Edit director page
     *
     * @Route("/admin/directors/edit/{directorId}", name="admin.directors.edit", methods={"GET"})
     */
    public function directorsEdit(string $directorId)
    {
        $director = $this->getDoctrine()
            ->getRepository(Director::class)
            ->find($directorId);

        $form = $this->createForm(DirectorType::class, $director, [
            'action' => $this->generateUrl('admin.directors.actions.edit', [
                'directorId' => $directorId,
            ]),
            'isEdit' => true,
        ]);

        return $this->render('admin/directors/edit.html.twig', [
            'title' => 'Edit a director',
            'page' => 'directors',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Remove a director
     *
     * @Route("/admin/directors/remove/{directorId}", name="admin.directors.remove", methods={"GET"})
     */
    public function directorsRemove(string $directorId)
    {
        return $this->forward('App\Controller\DirectorController::remove', [
            'directorId' => $directorId,
        ]);
    }

    /**
     * List of awards
     *
     * @Route("/admin/awards", name="admin.awards", methods={"GET"})
     */
    public function awards()
    {
        $awards = $this->getDoctrine()
            ->getRepository(Award::class)
            ->findAll();

        return $this->render('admin/awards/index.html.twig', [
            'title' => 'Awards list',
            'page' => 'awards',
            'awards' => $this->mapCollectionAward($awards),
        ]);
    }

    /**
     * Create award page
     *
     * @Route("/admin/awards/create", name="admin.awards.create", methods={"GET"})
     */
    public function awardsCreate()
    {
        $award = new Award();
        $form = $this->createForm(AwardType::class, $award, [
            'action' => $this->generateUrl('admin.awards.actions.create'),
        ]);

        return $this->render('admin/awards/create.html.twig', [
            'title' => 'Add an award',
            'page' => 'awards',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Edit award page
     *
     * @Route("/admin/awards/edit/{awardId}", name="admin.awards.edit", methods={"GET"})
     */
    public function awardsEdit(string $awardId)
    {
        $award = $this->getDoctrine()
            ->getRepository(Award::class)
            ->find($awardId);

        $form = $this->createForm(AwardType::class, $award, [
            'action' => $this->generateUrl('admin.awards.actions.edit', [
                'awardId' => $awardId,
            ]),
            'isEdit' => true,
        ]);

        return $this->render('admin/awards/edit.html.twig', [
            'title' => 'Edit an award',
            'page' => 'awards',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Remove a award
     *
     * @Route("/admin/awards/remove/{awardId}", name="admin.awards.remove", methods={"GET"})
     */
    public function awardsRemove(string $awardId)
    {
        return $this->forward('App\Controller\AwardController::remove', [
            'awardId' => $awardId,
        ]);
    }

    /**
     * List of awardscategory
     *
     * @Route("/admin/awardscategory", name="admin.awardscategory", methods={"GET"})
     */
    public function awardscategory()
    {
        $awardscategory = $this->getDoctrine()
            ->getRepository(AwardCategory::class)
            ->findAll();

        return $this->render('admin/awardscategory/index.html.twig', [
            'title' => 'Awards category list',
            'page' => 'awardscategory',
            'awardscategory' => $awardscategory,
        ]);
    }

    /**
     * Create award category page
     *
     * @Route("/admin/awardscategory/create", name="admin.awardscategory.create", methods={"GET"})
     */
    public function awardscategoryCreate()
    {
        $awardscategory = new AwardCategory();
        $form = $this->createForm(AwardCategoryType::class, $awardscategory, [
            'action' => $this->generateUrl('admin.awardscategory.actions.create'),
        ]);

        return $this->render('admin/awardscategory/create.html.twig', [
            'title' => 'Add an award category',
            'page' => 'awardscategory',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Edit award category page
     *
     * @Route("/admin/awardscategory/edit/{awardscategoryId}", name="admin.awardscategory.edit", methods={"GET"})
     */
    public function awardscategoryEdit(string $awardscategoryId)
    {
        $awardscategory = $this->getDoctrine()
            ->getRepository(AwardCategory::class)
            ->find($awardscategoryId);

        $form = $this->createForm(AwardCategoryType::class, $awardscategory, [
            'action' => $this->generateUrl('admin.awardscategory.actions.edit', [
                'awardscategoryId' => $awardscategoryId,
            ]),
            'isEdit' => true,
        ]);

        return $this->render('admin/awardscategory/edit.html.twig', [
            'title' => 'Edit a director',
            'page' => 'awardscategory',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Remove an award category
     *
     * @Route("/admin/awardscategory/remove/{awardscategoryId}", name="admin.awardscategory.remove", methods={"GET"})
     */
    public function awardscategoryRemove(string $awardscategoryId)
    {
        return $this->forward('App\Controller\AwardCategoryController::remove', [
            'awardscategoryId' => $awardscategoryId,
        ]);
    }
}
