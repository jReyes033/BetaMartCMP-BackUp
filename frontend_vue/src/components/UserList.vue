<template>
  <div class="UserList">
    <h2>User List</h2>
    <button class="btn btn-primary add-user-button m-2" @click="addUser()">Add User</button>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead class="thead-dark">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="account in accounts" :key="account.id">
            <td>{{ account.id }}</td>
            <td>{{ account.name }}</td>
            <td>{{ account.email }}</td>
            <td>
              <button class="btn btn-warning btn-sm m-1" @click="editAccount(account)">Edit</button>
              <button class="btn btn-danger btn-sm m-1" @click="confirmDeleteUser(account)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <Modal v-if="showEditModal" @close="showEditModal = false">
    <template v-slot:header>
      <h5>Edit Account Details</h5>
    </template>
    <template v-slot:body>
      <form @submit.prevent="saveAccount">
        <div class="form-group">
          <label for="accountName">Name</label>
          <input type="text" class="form-control" id="accountName" v-model="editAccountData.name">
        </div>
        <div class="form-group">
          <label for="accountEmail">Email</label>
          <input type="text" class="form-control" id="accountEmail" v-model="editAccountData.email">
        </div>
        <div class="form-group">
          <label for="accountPassword">Password</label>
          <input type="password" class="form-control" id="accountPassword" v-model="editAccountData.password">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
      </form>
    </template>
  </Modal>

  <Modal v-if="showAddModal" @close="showAddModal = false">
    <template v-slot:header>
      <h5>Add New Account</h5>
    </template>
    <template v-slot:body>
      <form @submit.prevent="postAccount">
        <div class="form-group">
          <label for="accountName">Name</label>
          <input type="text" class="form-control" id="accountName" v-model="newAccountData.name">
        </div>
        <div class="form-group">
          <label for="accountEmail">Email</label>
          <input type="text" class="form-control" id="accountEmail" v-model="newAccountData.email">
        </div>
        <div class="form-group">
          <label for="accountPassword">Password</label>
          <input type="password" class="form-control" id="accountPassword" v-model="newAccountData.password">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
      </form>
    </template>
  </Modal>
</template>



<script>
import Swal from 'sweetalert2';
import Modal from './EditModal.vue';
// import ViewModal from './ViewModal.vue';
import axios from 'axios';

export default {
  name: 'UserList',
  components: {
    Modal,
    // ViewModal
  },
  data() {
    return {
      accounts: [],
      showAddModal: false,
      showEditModal: false,
      editAccountData: {
        id: null,
        name: '',
        email: '',
        password: ''
      },
      newAccountData: {
        name: '',
        email: '',
        password: ''
      }
    };
  },
  mounted() {
    this.fetchAccounts(); // Adjusted method name
  },
  methods: {
    async postAccount() {
      try {
        await axios.post('http://127.0.0.1:8000/api/account', this.newAccountData);
        this.showAddModal = false;
      } catch (error) {
        if (error.response && error.response.status === 500) {
          alert('Email already taken.');
        } else if (error.response && error.response.status === 400) {
          alert(error.response.request.response);
        } else {
          console.error('There was an error adding the account:', error);
        }
      }
      this.fetchAccounts();
    },
    fetchAccounts() {
      fetch('http://127.0.0.1:8000/api/account', {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
        },
      })
    },
    editAccount(account) {
      this.editAccountData = { ...account };
      this.showEditModal = true;
    },
    async saveAccount() {
      try {
        await axios.put(`http://127.0.0.1:8000/api/account/${this.editAccountData.id}/edit`, this.editAccountData);
        this.showEditModal = false;
        this.fetchAccounts();
      } catch (error) {
        console.error('There was an error saving the account:', error);
      }
    },
    confirmDeleteUser(account) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteAccount(account);
        }
      });
    },
    async deleteAccount(account) {
      await axios.delete(`http://127.0.0.1:8000/api/account/${account.id}/delete`);
      this.fetchAccounts();
    },
    addUser() {
      this.showAddModal = true;
    }
  }
}
</script>
