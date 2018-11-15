<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Controller;


use App\Entity\Product;
use App\Entity\Rule;
use App\Repository\ProductRepository;
use App\Repository\RuleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PricingController extends AbstractController
{
    /**
     * @Route("/product", methods={"POST"})
     */
    public function index(Request $request, ObjectManager $em): JsonResponse
    {
        /** @var ProductRepository $productRepo */
        $productRepo = $em->getRepository(Product::class);

        /** @var RuleRepository $ruleRepo */
        $ruleRepo = $em->getRepository(Rule::class);

        $serializer = new Serializer([new ObjectNormalizer(), new ArrayDenormalizer()],[new JsonEncoder()]);

        try {
            /** @var Product $product */
            $product = $serializer->deserialize($request->getContent(), Product::class, 'json', []);
        } catch (NotEncodableValueException $e) {
            return $this->json(['error' => 'Bad data format: '.$e->getMessage()], 400);
        }

        if(!$product instanceof Product) {
            return $this->json(['error' => 'Bad data format for Product entity'], 400);
        }

        $sku = $product->getSku();
        $price = $product->getPrice();
        $rules = $product->getRules();

        $oldProduct = $productRepo->findOneBySku($sku);
        if($oldProduct) {

            $oldRules = $ruleRepo->findAllForProductId($oldProduct->getId());
            foreach ($oldRules as $oldRule) {
                $em->remove($oldRule);
            }

            $this->linkRules($rules, $oldProduct);
            $oldProduct->setPrice($price);
            $oldProduct->setRules($rules);
        } else {
            $this->linkRules($rules, $product);
            $em->persist($product);
        }

        $em->flush();
        $id = $product->getId() ?? $oldProduct->getId();
        return $this->json(['id' => $id]);
    }

    private function linkRules(Collection &$rules, Product $product)
    {
        $rules->map(function (Rule $rule) use ($product) {
            $rule->setProduct($product);
            return $rule;
        });
    }
}