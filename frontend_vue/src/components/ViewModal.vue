<template>
    <div class="modal" tabindex="-1" role="dialog" style="display: block;">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">View Product Details</h5>
            <button type="button" class="close" @click="$emit('close')" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p><strong>ID:</strong> {{ product.id }}</p>
            <p><strong>Name:</strong> {{ product.name }}</p>
            <p><strong>Description:</strong> {{ product.description }}</p>
            <p><strong>Price:</strong> {{ product.price }}</p>
            <p><strong>Quantity:</strong> {{ product.quantity }}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="$emit('close')">Close</button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'ViewModal',
    props: {
      product: {
        type: Object,
        required: true
      }
    }
  }
  </script>
  
  <style>
  .modal {
    display: none;
    background-color: rgba(0, 0, 0, 0.5);
  }
  .modal.show {
    display: block;
  }
  </style>
  