<?php

namespace App\Service;

use App\Repository\ArticleTranslationRepository;
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
    private RequestStack $request;
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
        $this->request = $request;
        $this->currentLocale = $request->getCurrentRequest()->getLocale();
        $this->urlGenerator = $urlGenerator;
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
        $request = $this->request->getCurrentRequest();
        if (array_key_exists('slug', $request->get('_route_params'))) {
            $url = $this->urlGenerator->generate(
                $request->get('_route'),
                ['slug' => $this->getSlugByLocale($locale)]
            );
        } else {
            $url = $this->urlGenerator->generate($request->get('_route'));
        }
//        reset context to current locale
        $this->urlGenerator->setContext((new RequestContext())
            ->setParameter('_locale', $request->getLocale()));
        return $url;
    }

    /**
     * @param string $locale
     * @return string|mixed
     */
    private function getSlugByLocale(string $locale)
    {
        $slug = "";
        if (strpos($this->request->getCurrentRequest()->get('_route'), 'article_') !== false) {
            $currentTranslation = $this->articleRepos
                ->findOneBy([
                    'slug' => $this->request->getCurrentRequest()->get('_route_params')['slug']
                ])->getTranslatable();
            $slug = $this->articleRepos
                ->findOneBy(['translatable' => $currentTranslation, 'locale' => $locale])->getSlug();
        }

        if (strpos($this->request->getCurrentRequest()->get('_route'), 'artist_') !== false) {
            $slug = $this->request->getCurrentRequest()->get('_route_params')['slug'];
        }
        return $slug;
    }
}
