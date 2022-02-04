<?php

namespace App\Service;

use App\Repository\ArticleTranslationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;

class NavigationService
{
    public const LANGS = [
        ["title" => 'Français', 'locale' => 'fr'],
        ["title" => 'Deutsch', 'locale' => 'de'],
        ["title" => 'Русский', 'locale' => 'ru'],
        ["title" => '大和', 'locale' => 'ja'],
        ["title" => 'English', 'locale' => 'en'],
    ];
    private ?Request $request;
    private UrlGeneratorInterface $urlGenerator;
    private ArticleTranslationRepository $articleRepos;
    private string $currentLocale;

    /**
     * NavigationService constructor.
     * @param RequestStack $request
     * @param UrlGeneratorInterface $urlGenerator
     * @param ArticleTranslationRepository $translationRepos
     */
    public function __construct(
        RequestStack $request,
        UrlGeneratorInterface $urlGenerator,
        ArticleTranslationRepository $translationRepos
    ) {
        $this->request = $request->getMainRequest();
        $this->currentLocale = $this->request ? $this->request->getLocale() : 'fr';
        $this->urlGenerator = clone $urlGenerator;
        $this->articleRepos = $translationRepos;
    }

    public function langs(): array
    {
        $languages = [];
        foreach (self::LANGS as $key => $lang) {
            if ($lang['locale'] !== $this->currentLocale) {
                $languages[$key] = $lang;
                $languages[$key]['path'] = $this->generateUrl($lang['locale']);
            }
        }
        return $languages;
    }

    /**
     * @param string $locale
     * @return string
     */
    public function generateUrl(string $locale): string
    {
        $this->urlGenerator->setContext((new RequestContext())
            ->setParameter('_locale', $locale));
        $request = $this->request;
        if (array_key_exists('slug', $request->get('_route_params'))) {
            $url = $this->urlGenerator->generate(
                $request->get('_route'),
                ['slug' => $this->getSlugByLocale($locale)]
            );
        } else {
            $url = $this->urlGenerator->generate($request->get('_route'));
        }
        return $url;
    }

    /**
     * @param string $locale
     * @return string|mixed
     */
    private function getSlugByLocale(string $locale)
    {
        $slug = "";
        if (strpos($this->request->get('_route'), 'article_') !== false) {
            $currentTranslation = $this->articleRepos
                ->findOneBy([
                    'slug' => $this->request->get('_route_params')['slug']
                ])->getTranslatable();
            $slug = $this->articleRepos
                ->findOneBy(['translatable' => $currentTranslation, 'locale' => $locale])->getSlug();
        }

        if (
            strpos($this->request->get('_route'), 'artist_') !== false ||
            strpos($this->request->get('_route'), 'page_') !== false
        ) {
            $slug = $this->request->get('_route_params')['slug'];
        }
        return $slug;
    }
}
