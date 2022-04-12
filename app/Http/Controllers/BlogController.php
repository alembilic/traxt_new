<?php

namespace App\Http\Controllers;

use App\Core\EntityManagerFresher;
use App\Entities\BlogPost;
use Doctrine\Common\Collections\Criteria;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogController extends BaseWebController
{
    use EntityManagerFresher;

    public function index(): View
    {
        $mainPost = $this->getRepository(BlogPost::class)
            ->matching(Criteria::create()->setMaxResults(1))
            ->first();
        $posts = $this->getRepository(BlogPost::class)
            ->matching(Criteria::create()->setMaxResults(15)->setFirstResult(1));

        return view('promo.blog_index', [
            'mainPost' => $mainPost,
            'posts' => $posts,
        ]);
    }

    /**
     * Shows blog post details page.
     *
     * @param string $urlCode url code
     *
     * @return View
     */
    public function show(string $urlCode): View
    {
        $post = $this->getRepository(BlogPost::class)->findOneBy([BlogPost::URL_CODE => $urlCode]);

        if (!$post) {
            throw new NotFoundHttpException();
        }

        return view('promo.blog_detail', [
            'post' => $post,
        ]);
    }
}
