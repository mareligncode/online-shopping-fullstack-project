document.getElementById("year").textContent = new Date().getFullYear();

// Dark Mode Toggle Functionality
const darkModeToggle = document.getElementById("darkModeToggle");

// Check localStorage for user's preference on page load
document.addEventListener("DOMContentLoaded", () => {
  if (localStorage.getItem("darkMode") === "enabled") {
    document.body.classList.add("dark-mode");
    darkModeToggle.checked = true;
  }
});

// Toggle dark mode on button click
darkModeToggle.addEventListener("change", () => {
  const body = document.body;
  body.classList.toggle("dark-mode");

  // Save the user's preference in localStorage
  if (body.classList.contains("dark-mode")) {
    localStorage.setItem("darkMode", "enabled");
  } else {
    localStorage.setItem("darkMode", "disabled");
  }
});

const products = {
  Jeans: [
    {
      name: "Jeans Style 1",
      price: "1500ETB",
      image: "images/jeans1.jpg",
    },
    { name: "Jeans Style 2", price: "1500ETB", image: "images/jeans2.jpg" },
  ],
  Shirt: [
    { name: "Shirt Style 1", price: "2000ETB", image: "images/shirt1.jpg" },
    { name: "Shirt Style 2", price: "2500ETB", image: "images/shirt2.jpg" },
  ],
  Jacket: [
    { name: "Jacket Style 1", price: "3000ETB", image: "images/jacket1.jpg" },
    { name: "Jacket Style 2", price: "2500ETB", image: "images/jacket2.jpg" },
  ],
  Shoes: [
    { name: "Shoes Style 1", price: "3300ETB", image: "images/shoes1.jpg" },
    { name: "Shoes Style 2", price: "3500ETB", image: "images/shoes2.jpg" },
  ],
  "T-Shirt": [
    { name: "T-Shirt Style 1", price: "$10", image: "images/t-shirt1.jpg" },
    { name: "T-Shirt Style 2", price: "$12", image: "images/t-shirt3.jpg" },
  ],
  Belt: [
    { name: "Belt Style 1", price: "$15", image: "images/belt1.jpg" },
    { name: "Belt Style 2", price: "$18", image: "images/belt2.jpg" },
  ],
};

document.querySelectorAll(".load-more").forEach((button) => {
  button.addEventListener("click", function () {
    const type = this.getAttribute("data-type");
    const productContainer = this.parentElement;

    products[type].forEach((product) => {
      const card = `
              <div class="col-sm-4 mb-4">
                  <div class="card">
                      <img src="${product.image}" class="card-img-top" alt="${product.name}">
                      <div class="card-body">
                          <h5 class="card-title">${product.name}</h5>
                          <p class="card-text">${product.price} midium quality</p>
                      </div>
                  </div>
              </div>
          `;
      productContainer.insertAdjacentHTML("beforeend", card);
    });
  });
});

document.getElementById("product-type").addEventListener("change", function () {
  const selectedType = this.value;
  const selectedProduct = products[selectedType][0]; // Get the first style for the price
  document.getElementById("price").value = selectedProduct.price;
});

document.getElementById("submit").addEventListener("click", () => {
  const size = document.getElementById("size").value;
  const quality = document.getElementById("quality").value;
  const productType = document.getElementById("product-type").value;
  const price = document.getElementById("price").value;
  x = `Selected Size: ${size}, Quality: ${quality}, Product Type: ${productType}, Price: ${price}`;
  document.getElementById("pro").innerHTML = x + " thank you";
});
