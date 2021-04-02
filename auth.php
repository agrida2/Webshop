
<?php
#creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie
session_start();
#MySQL make connection to database
$connect = mysqli_connect("localhost", "root", "", "testing");



#Checks if the sessions is add to cart
if (isset($_POST["add_to_cart"])) {
    if (isset($_SESSION["shopping_cart"])) {   
        # getting the array id
        $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
        # checking if the item is added 
        if (!in_array($_GET["id"], $item_array_id)) {      
            #counts the amount objects you put in the shopping cart
            $count = count($_SESSION["shopping_cart"]);

            $item_array = array(
                'item_id'            =>    $_GET["id"],
                'item_name'            =>    $_POST["hidden_name"],
                'item_price'        =>    $_POST["hidden_price"],
                'item_quantity'        =>    $_POST["quantity"]
            );
            $_SESSION["shopping_cart"][$count] = $item_array;
            $_SESSION['Added'] = "Item added to shopingcart";

        } else {
            $_SESSION['Already added'] = "Item already added to shopingcart";
        }
    } else {
        $item_array = array(
            'item_id'            =>    $_GET["id"],
            'item_name'            =>    $_POST["hidden_name"],
            'item_price'        =>    $_POST["hidden_price"],
            'item_quantity'        =>    $_POST["quantity"]
        );
        $_SESSION["shopping_cart"][0] = $item_array;
    }
}

if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete") {
        foreach ($_SESSION["shopping_cart"] as $keys => $values) {
            if ($values["item_id"] == $_GET["id"]) {
                unset($_SESSION["shopping_cart"][$keys]);
                $_SESSION['Deleted'] = "Item Removed";
            }
        }
    }
}

?>