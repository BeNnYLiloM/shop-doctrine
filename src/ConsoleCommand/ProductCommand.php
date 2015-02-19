<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ProductCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('Product')
            ->addArgument(
                'name',
                InputArgument::OPTIONAL,
                'Name of product.'
            )
            ->addArgument(
                'price',
                InputArgument::OPTIONAL,
                'Price of product.'
            )
            ->addArgument(
                'amount',
                InputArgument::OPTIONAL,
                'Amount of product.'
            )
            ->addArgument(
                'product-id',
                InputArgument::OPTIONAL,
                'ID of product'
            )
            ->addArgument(
                'order-id',
                InputArgument::OPTIONAL,
                'ID of order'
            )
            ->addArgument(
                'order-product-id',
                InputArgument::OPTIONAL,
                'ID of the record in the table OrderProduct.'
            )
            ->addOption(
                'add',
                null,
                InputOption::VALUE_NONE,
                'Add product to the table.'
            )
            ->addOption(
                'order',
                null,
                InputOption::VALUE_NONE,
                'Order product'
            )
            ->addOption(
                'del-order',
                null,
                InputOption::VALUE_NONE,
                'Remove the product from order.'
            )
            ->addOption(
                'list',
                null,
                InputOption::VALUE_NONE,
                'List of products.'
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        if($input->getOption('add')){
            if(!$input->getArgument('name')){
                $output->writeln('<error>You did not specify the product name.</error>');
                die;
            }
            if(!$input->getArgument('price')){
                $output->writeln('<error>You did not specify the product price.</error>');
                die;
            }
            if(!$input->getArgument('amount')){
                $output->writeln('<error>You did not specify the product amount.</error>');
                die;
            }

            $product = new Product();
            $product->setName($input->getArgument('name'));
            $product->setPrice($input->getArgument('price'));
            $product->setAmount($input->getArgument('amount'));

            $GLOBALS['entityManager']->persist($product);
            $GLOBALS['entityManager']->flush();
        }

        if($input->getOption('order')){
            if(!$input->getArgument('product-id')){
                $output->writeln('<error>You did not specify the product ID.</error>');
                die;
            }
            if(!$input->getArgument('amount')){
                $output->writeln('<error>You did not specify the product amount for order.</error>');
                die;
            }
            if($input->getArgument('order-id')){
                $order = $GLOBALS['entityManager']->find('Order', $input->getArgument('order-id'));
                if($order){
                    $product = $GLOBALS['entityManager']->find('Product', $input->getArgument('product-id'));

                    $cart = new OrderProduct();
                    $cart->setOrder($order);
                    $cart->setProduct($product);
                    $cart->setCount($input->getArgument('amount'));

                    $GLOBALS['entityManager']->persist($cart);
                    $GLOBALS['entityManager']->flush();
                } else {
                    $output->writeln('<error>Order with ID: `'.$input->getArgument('order-id').'` not found!</error>');
                    die;
                }
            } else {
                $newOrder = new Order();
                $newOrder->setCreated(new DateTime('now'));

                $GLOBALS['entityManager']->persist($newOrder);
                $GLOBALS['entityManager']->flush();

                $product = $GLOBALS['entityManager']->find('Product', $input->getArgument('product-id'));
                if($product == false){
                    $output->writeln('<error>Not found product by id `'.$input->getArgument('product-id').'`</error>');
                    die;
                }

                $cart = new OrderProduct();
                $cart->setOrder($newOrder);
                $cart->setProduct($product);
                $cart->setCount($input->getArgument('amount'));

                $GLOBALS['entityManager']->persist($cart);
                $GLOBALS['entityManager']->flush();
            }
        }

        if($input->getOption('del-order')){
            if(!$input->getArgument('order-product-id')){
                $output->writeln('<error>You must specify the ID of the goods in your shopping cart.</error>');
                die;
            }
            $orderProduct = $GLOBALS['entityManager']->find('OrderProduct', $input->getArgument('order-product-id'));
            if($orderProduct){
                $GLOBALS['entityManager']->remove($orderProduct);
                $GLOBALS['entityManager']->flush();
            } else {
                $output->writeln('<error>Product with ID `'.$input->getArgument('order-product-id').'` was not found in your shopping cart.</error>');
                die;
            }
        }

        if($input->getOption('list')){
            $productRepository = $GLOBALS['entityManager']->getRepository('Product');
            $products = $productRepository->findAll();

            foreach($products as $product) {
                echo sprintf("%s (ID product '%d' price of %d rub. Amount product '%d')\n", $product->getName(), $product->getId(), $product->getPrice(), $product->getAmount());
            }
        }
    }
}