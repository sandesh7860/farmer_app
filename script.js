// Initialize an empty shopping cart (using localStorage for persistence)
let cart = JSON.parse(localStorage.getItem('cart')) || [];

// Function to add a product to the cart
// Function to add item to cart
function addToCart(product) {
    const data = {
        userId: 1, // Example user ID
        productId: 1, // Example product ID
        productName: product.name,
        productPrice: product.price
    };

    fetch('add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.text())
    .then(result => {
        console.log(result); // Log the response from the server
        alert(`Added ${product.name} to cart!`);
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to add item to cart.');
    });
}

// Function to display cart items
function displayCart() {
    const cartContainer = document.getElementById('cartContainer');
    cartContainer.innerHTML = ''; // Clear previous content

    if (cart.length === 0) {
        cartContainer.textContent = 'Your cart is empty.';
    } else {
        const cartItems = cart.map(product => product.name);
        const cartList = document.createElement('ul');

        cartItems.forEach(item => {
            const listItem = document.createElement('li');
            listItem.textContent = item;
            cartList.appendChild(listItem);
        });

        cartContainer.appendChild(cartList);
    }
}

// Function to display products based on category
function showProducts() {
    const selectedCategory = document.getElementById("category").value;
    const container = document.getElementById('productContainer');
    container.innerHTML = ""; // Clear previous content

    if (products[selectedCategory]) {
        const productsList = products[selectedCategory];

        productsList.forEach((product, index) => {
            if (index < productCount) {
                const productElement = createProductElement(product);
                container.appendChild(productElement);
            }
        });
    } else {
        container.textContent = "No products found.";
    }
}

// Helper function to create product HTML element
function createProductElement(product) {
    const productDiv = document.createElement('div');
    productDiv.classList.add('product');

    // You can replace this with the actual image path
    const img = document.createElement('img');
    img.src = `path_to_your_image.jpg`; // Replace with actual image path
    img.alt = product.name;
    productDiv.appendChild(img);

    const nameHeading = document.createElement('h3');
    nameHeading.textContent = product.name;
    productDiv.appendChild(nameHeading);

    const priceParagraph = document.createElement('p');
    priceParagraph.textContent = `$${product.price.toFixed(2)}`;
    productDiv.appendChild(priceParagraph);

    const addToCartButton = document.createElement('button');
    addToCartButton.textContent = "Add to Cart";
    addToCartButton.addEventListener('click', () => addToCart(product));
    productDiv.appendChild(addToCartButton);

    return productDiv;
}

// Function to load more products
function showMore() {
    const selectedCategory = document.getElementById("category").value;
    const container = document.getElementById('productContainer');
    const productsList = products[selectedCategory];

    for (let i = productCount; i < productCount + 3 && i < productsList.length; i++) {
        const productElement = createProductElement(productsList[i]);
        container.appendChild(productElement);
    }

    productCount += 3;

    // Check if all products have been displayed
    if (productCount >= productsList.length) {
        const showMoreButton = document.getElementById('showMoreContainer');
        showMoreButton.style.display = 'none'; // Hide the "Show More" button
    }
}

// Function to handle checkout
function checkout() {
    if (cart.length === 0) {
        alert('Your cart is empty. Add some items before checking out.');
        return;
    }

    // Here you can implement your payment logic (e.g., redirect to a payment page)
    // For simplicity, we'll just clear the cart and display a success message
    cart = [];
    localStorage.setItem('cart', JSON.stringify(cart));
    displayCart(); // Update cart display after clearing

    alert('Checkout successful! Thank you for shopping.');
}




// Initial call to display cart items and show default products
displayCart();
showProducts();

function displayCartItems() {
    // Make an AJAX request to fetch cart items
    fetch('get_cart_items.php')
        .then(response => response.text())
        .then(data => {
            // Display cart items in the cartContainer element
            const cartContainer = document.getElementById('cartContainer');
            cartContainer.innerHTML = data; // Update cart content
        })
        .catch(error => console.error('Error fetching cart items:', error));
}

// Call displayCartItems() when the cart page loads or when needed
displayCartItems();

