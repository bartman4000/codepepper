<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Controller;


use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\CheckoutService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    /**
     * @Route("/checkout", methods={"POST"})
     */
    public function index(Request $request, ObjectManager $em, CheckoutService $checkout): JsonResponse
    {
        /** @var ProductRepository $productRepo */
        $productRepo = $em->getRepository(Product::class);
        $skus = json_decode($request->getContent(), true);

        $products = [];
        foreach ($skus as $sku) {
            $product = $productRepo->findOneBySku($sku);
            if (!$product) {
                continue;
            }
            $products[] = $product;
        }

        $total = $checkout->calculate($products);
        return $this->json(['total' => $total]);
    }
}