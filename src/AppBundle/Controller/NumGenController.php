<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 13/01/17
 * Time: 16:45
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NumGenController extends Controller
{

    /**
     * @Route("/luckynum/{max}")
     */

    public function showNoAction($max)
    {
        /*if (!$max)
            throw $this->createNotFoundException('Please set a max value');*/

        $no = mt_rand(0,$max);

        $blog_posts = [
            ['title' => 'Post 1', 'body' => 'hahahahaha'],
            ['title' => 'Post 2', 'body' => 'hehehehehe']
        ];

        if ($max == 100){
            return $this->render('lucky/luckynum.html.twig', array(
                'number' => $no
            ));
        }
        return $this->render('lucky/index.html.twig', array(
            'blog_entries' => $blog_posts
        ));
    }
}