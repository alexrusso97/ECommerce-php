<?php

class Product
{
    public $quantity;
    public $userId;
    public $title;
    public $description;
    public $id;
    public $price;
    public $image;
    public $thumbnail;
}

class Products
{
    protected $url;
    protected $data;

    public $products = array();

    public function __construct()
    {
        $this->url = "https://mockend.up.railway.app/api/products";
        $response = file_get_contents($this->url);
        $this->data = json_decode($response, true);

        foreach ($this->data as $valore) {
            $product = new Product();
            $product->quantity = $valore['qty'];
            $product->userId = $valore['userId'];
            $product->title = $valore['title'];
            $product->description = $valore['description'];
            $product->id = $valore['id'];
            $product->price = $valore['price'];
            $product->image = $valore['image'];
            $product->thumbnail = $valore['thumbnail'];
            $this->addProduct($product);
        }
    }

    function addProduct($product)
    {
        $this->products[] = $product;
    }

    function removeProduct($productid)
    {
        foreach ($this->products as $key => $product) {
            if ($product->id == $productid) {
                unset($this->products[$key]);
            }
        }
    }

}

function generateProductCard($product) {
    $card = '<div class="card">';
    $card .= '<img src="' . $product->thumbnail . '" alt="' . $product->title . '">';
    $card .= '<h3>' . $product->title . '</h3>';
    $card .= '<p>' . $product->description . '</p>';
    $card .= '<p>Price: $' . $product->price . '</p>';
    $card .= '<p>Quantity: ' . $product->quantity . '</p>';
    $card .= '<button>Add to cart</button>';
    $card .= '</div>';
    echo '<link rel="stylesheet" href="style.css">';
    return $card;
}

$products = new Products();

$productCards = '';
foreach ($products->products as $product) {
    $productCards .= generateProductCard($product);
}

echo $productCards;
?>
