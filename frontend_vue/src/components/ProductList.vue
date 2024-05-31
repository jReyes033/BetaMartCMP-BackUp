<template>
  <div class="ProductList">
    <h2>Product List</h2>
    <button class="btn btn-primary add-user-button m-2" @click="addProduct()">Add Product</button>
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead class="thead-dark">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Category</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in products.products" :key="product.id">
            <td>{{ product.id }}</td>
            <td>{{ product.name }}</td>
            <td>{{ product.description }}</td>
            <td>{{ product.category }}</td>
            <td>{{ product.price }}</td>
            <td>
              <button class="btn btn-secondary btn-sm" @click="decreaseQuantity(product)">-</button>
              {{ product.quantity }}
              <button class="btn btn-secondary btn-sm" @click="increaseQuantity(product)">+</button>
            </td>
            <td>
              <button class="btn btn-warning btn-sm m-1" @click="editProduct(product)">Edit</button>
              <button class="btn btn-danger btn-sm m-1" @click="confirmDelete(product)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <Modal v-if="showEditModal" @close="showEditModal = false">
      <template v-slot:header>
        <h5>Edit Product Details</h5>
      </template>
      <template v-slot:body>
        <form @submit.prevent="saveProduct">
          <div class="form-group">
            <label for="productName">Name</label>
            <input type="text" class="form-control" id="productName" v-model="editProductData.name">
          </div>
          <div class="form-group">
            <label for="productDescription">Description</label>
            <input type="text" class="form-control" id="productDescription" v-model="editProductData.description">
          </div>
          <div class="form-group">
            <label for="productcategory">Category</label>
            <input type="text" class="form-control" id="productcategory" v-model="editProductData.category">
          </div>
          <div class="form-group">
            <label for="productPrice">Price</label>
            <input type="number" class="form-control" id="productPrice" v-model="editProductData.price" step="0.01">
          </div>
          <div class="form-group">
            <label for="productQuantity">Quantity</label>
            <input type="number" class="form-control" id="productQuantity" v-model="editProductData.quantity">
          </div>
          <button type="submit" class="btn btn-primary">Save</button>
        </form>
      </template>
    </Modal>

    <Modal v-if="showAddModal" @close="showAddModal = false">
      <template v-slot:header>
        <h5>Add New Product</h5>
      </template>
      <template v-slot:body>
        <form @submit.prevent="postProduct">
          <div class="form-group">
            <label for="newProductName">Name</label>
            <input type="text" class="form-control" id="newProductName" v-model="newProductData.name">
          </div>
          <div class="form-group">
            <label for="newProductDescription">Description</label>
            <input type="text" class="form-control" id="newProductDescription" v-model="newProductData.description">
          </div>
          <div class="form-group">
            <label for="newProductCategory">Category</label>
            <input type="text" class="form-control" id="newProductCategory" v-model="newProductData.category">
          </div>
          <div class="form-group">
            <label for="newProductPrice">Price</label>
            <input type="number" class="form-control" id="newProductPrice" v-model="newProductData.price" step="0.01">
          </div>
          <div class="form-group">
            <label for="newProductQuantity">Quantity</label>
            <input type="number" class="form-control" id="newProductQuantity" v-model="newProductData.quantity">
          </div>
          <button type="submit" class="btn btn-primary">Add</button>
        </form>
      </template>
    </Modal>

    <ViewModal v-if="showViewModal" :product="viewProductData" @close="showViewModal = false" />

  </div>
</template>

<script>
import Modal from './EditModal.vue';
import ViewModal from './ViewModal.vue';
import axios from 'axios';

export default {
  name: 'ProductList',
  components: {
    Modal,
    ViewModal
  },
  data() {
    return {
      products: [],
      showAddModal: false,
      showEditModal: false,
      newProductData: {
        name: '',
        description: '',
        category: '',
        price: 0.00,
        quantity: 0,
      },
      viewProductData: {
        id: null,
        name: '',
        description: '',
        category: '',
        price: 0.00,
        quantity: 0,
      },
      editProductData: {
        id: null,
        name: '',
        description: '',
        category: '',
        price: 0.00,
        quantity: 0,
      }
    };
  },
  mounted() {
    this.fetchProducts();
  },
  methods: {
    async postProduct() {
      try {
        await axios.post('http://127.0.0.1:8000/api/products', this.newProductData);
        this.showAddModal = false;
      } catch (error) {
        console.error('There was an error adding the product:', error);
      }
      this.fetchProducts();
    },
    fetchProducts() {
      fetch('http://127.0.0.1:8000/api/products', {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
        },
      })
        .then(response => response.json())
        .then(data => {
          this.products = data;
        })
        .catch(error => {
          console.error('Error fetching products:', error);
        });
    },
    addProduct() {
      this.showAddModal = true;
    },
    editProduct(product) {
      this.editProductData = { ...product };
      this.showEditModal = true;
    },
    async saveProduct() {
      try {
        // Make the API call to save the product data
        await axios.put(`http://127.0.0.1:8000/api/products/${this.editProductData.id}/edit`, this.editProductData);

        // Hide the edit modal
        this.showEditModal = false;

        this.fetchProducts();

      } catch (error) {
        console.error('There was an error saving the product:', error);
      }
    },
    confirmDelete(product) {
      const confirmMessage = `Are you sure you want to delete product id: ${product.id} product name: ${product.name} product description: ${product.description} price: ${product.price}?`;
      if (window.confirm(confirmMessage)) {
        this.deleteProduct(product);
      }
    },
    async deleteProduct(product) {
      const index = this.products.products.findIndex(p => p.id === product.id);
      if (index !== -1) {
        this.products.products.splice(index, 1);
        try {
          await axios.delete(`http://127.0.0.1:8000/api/products/${product.id}/delete`);
        } catch (error) {
          console.error('There was an error saving the product:', error);
        }
      }
    },
    async increaseQuantity(product) {
      product.quantity++;
      try {
        await axios.put(`http://127.0.0.1:8000/api/products/${product.id}/edit`, product);
      } catch (error) {
        console.error('There was an error increasing the product quantity', error);
      }
    },
    async decreaseQuantity(product) {
      if (product.quantity > 0) {
        product.quantity--;
        try {
          await axios.put(`http://127.0.0.1:8000/api/products/${product.id}/edit`, product);
        } catch (error) {
          console.error('There was an error increasing the product quantity', error);
        }
      }
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
