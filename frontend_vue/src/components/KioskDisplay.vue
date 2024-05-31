<template>
  <div class="KioskDisplay">
    <button class="btn btn-info btn-sm m-1" @click="showCartModal = true">Check out</button>
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead class="thead-dark">
          <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Category</th>
            <th>Price</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in kioskProducts.products" :key="product.id">
            <td>{{ product.name }}</td>
            <td>{{ product.description }}</td>
            <td>{{ product.category }}</td>
            <td>{{ product.price }}</td>
            <td>
              <button class="btn btn-success btn-sm m-1" @click="addToCart(product)">Add to Cart</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <Modal v-if="showCartModal" @close="showCartModal = false">
      <template v-slot:header>
        <h5>Your Cart</h5>
      </template>
      <template v-slot:body>
        <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead class="thead-dark">
          <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Category</th>
            <th>Price</th>
            <th>Quantity</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="cartProduct in cart" :key="cartProduct.id">
            <td>{{ cartProduct.name }}</td>
            <td>{{ cartProduct.description }}</td>
            <td>{{ cartProduct.category }}</td>
            <td>{{ cartProduct.price }}</td>
            <td>{{ cartProduct.quantity }}</td>
            <!-- <td>
              <button class="btn btn-warning btn-sm m-1" @click="deleteFromCart(cartProduct)">Delete</button>
            </td> -->
          </tr>
        </tbody>
      </table>
      <button class="btn btn-success btn-sm m-1" @click="checkOutItems()">Check out Items</button>
    </div>
      </template>
    </Modal>
  </div>
</template>

<script>
// import axios from 'axios';
import Modal from './CartModal.vue';

export default {
  name: 'KioskDisplay',
  components: {
    Modal
  },
  data() {
    return {
      kioskProducts: [],
      cart: [],
      showCartModal: false
    };
  },
  mounted() {
    this.fetchProducts();
  },
  methods: {
    fetchProducts() {
      fetch('http://127.0.0.1:8000/api/products', {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
        },
      })
        .then(response => response.json())
        .then(data => {
          this.kioskProducts = data;
        })
        .catch(error => {
          console.error('Error fetching products:', error);
        });
    },
    addToCart(product) {
      const element = this.cart.find(cartProduct => cartProduct.id === product.id)
      
      if (element) {
        element.quantity++;
      } else {
        this.cart.push({...product, quantity: 1});
      }
    },
    deleteFromCart(cartProduct) {
      // this.cart.splice(cartProduct.id);
      console.log(this.cart);
      console.log(cartProduct);
    },
    checkOutItems() {
      this.cart = [];
    }

  }
}
</script>

<style>
.ProductList {
  padding: 20px;
}

.ProductList h2 {
  text-align: center;
  margin-bottom: 20px;
}

.table-responsive {
  margin: auto;
  max-width: 80%;
}

.table {
  border-collapse: collapse;
}

.table thead th,
.table tbody td {
  text-align: center;
  vertical-align: middle;
  border: 1px solid black;
  /* Adding black grid lines */
}

.table tbody tr:hover {
  background-color: #f5f5f5;
}

.btn-info {
  color: white;
  background-color: #17a2b8;
  border-color: #17a2b8;
}

.btn-warning {
  color: white;
  background-color: #ffc107;
  border-color: #ffc107;
}

.btn-danger {
  color: white;
  background-color: #dc3545;
  border-color: #dc3545;
}

.btn-secondary {
  color: white;
  background-color: #6c757d;
  border-color: #6c757d;
}

.btn-sm {
  padding: 0.25rem 0.5rem;
  font-size: 0.875rem;
  line-height: 1.5;
  border-radius: 0.2rem;
}
</style>
