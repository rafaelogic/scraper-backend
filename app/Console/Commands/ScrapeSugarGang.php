<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ScrapeSugarGang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will get all shopify store products';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $page = 1;

        $this->info('Scraping products from Sugar Gang...');

        while ($products = $this->fetchProducts($page)) {
            DB::table('products')->raw(function ($collection)  use ($products) {
                $collection->insertMany($products);
            });
            $page++;
        }

        $this->newLine();
        $this->info('Done!');

        return Command::SUCCESS;
    }

    protected function fetchProducts(int $page = 1): array
    {
        $progressBar = $this->output->createProgressBar(250);

        $products = collect();
        $response = Http::get(config('shopifystore.url') . 'products.json?limit=250&page=' . $page);

        $currentProduct = [];

        if ($response->successful()) {
            $data = $response->json();

            $this->newLine();
            $this->info('Processing 250 products on page ' . $page);

            try {
                if ($data) {
                    foreach ($data['products'] as $product) {
                        $progressBar->advance();

                        $currentProduct = $product;
                        preg_match("/Inhaltsstoffe|Zutaten:(.*)/", $product['body_html'], $matches);

                        $ingredients = '';

                        if ($matches) {
                            $ingredients = $matches[1] ?? $matches[0];
                            $ingredients = str_replace('</p>', '', $ingredients);
                        }

                        $products->push([
                            'title' => $product['title'],
                            'price' => $product['variants'][0]['price'],
                            'quantity' => 0,
                            'image' => $product['images'][0]['src'] ?? $product['variants'][0]['featured_image']['src'],
                            'ingredients' => $ingredients,
                            'sku' => $product['variants'][0]['sku'],
                        ]);
                    }
                }
            } catch (\Exception $e) {
                $this->error(json_encode([
                    'index' => count($data) + 1,
                    'product' => json_encode($currentProduct)
                ]));
                $this->error($e);
            }
        }

        $progressBar->finish();
        return $products->toArray();
    }
}
