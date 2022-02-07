<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Table</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addNew">Add New
                      <i class="fa fa-user-plus fa-fw"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>User Type</th>
                      <th>Email</th>
                      <th>Joined</th>
                      <th>Status</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>admin</td>
                      <td>admin@gmail.com</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>
                          <a href="#">
                              <i class="fa fa-edit"></i>
                          </a>
                          |
                          <a href="#">
                              <i class="fa fa-trash red"></i>
                          </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Input Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form @submit.prevent="editmode ? updateUser() : createUser()">
            <div class="modal-body">
                <div class="form-group">
                    <label>Name</label>
                    <input v-model="form.name" type="text" name="name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input v-model="form.email" type="text" name="email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                    <has-error :form="form" field="email"></has-error>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input v-model="form.password" type="text" name="password" class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                    <has-error :form="form" field="password"></has-error>
                </div>
                <div class="form-group">
                    <label>User Role</label>
                    <select v-model="form.type" type="text" name="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                        <option value="">Select User Role</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                    <has-error :form="form" field="type"></has-error>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select v-model="form.status" type="text" name="status" class="form-control" :class="{ 'is-invalid': form.errors.has('status') }">
                        <option value="">Select User Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <has-error :form="form" field="status"></has-error>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Create
                    <i class="fas fa-plus-circle fa-fw"></i>
                </button>
            </div>
            </form>
            </div>
        </div>
        </div>
    </div>
</template>


<script>
    export default {
       data(){
           return{
               editmode: false,
               users:{},
               form: new Form({
                   id:'',
                   name: '',
                   email: '',
                   password: '',
                   type: '',
                   status: '',
                   created_at:''
               })
           }
       },

       methods:{
           loadUsers(){
               this.$Progress.start();

               if(this.$gate.isAdmin()){
                   axios.get("api/user").then(({ data}) => (this.users = data.data));
               }

               this.$Progress.finish();
           },

           createUser(){
               this.$Progress.start();
               this.form.post('api/user')
               .then((response) => {
                   addNew.hide();
                   Toast.fire({
                        icon: 'success',
                        title: 'User Created Successfully'
                        })
                   this.$Progress.finish();
               })
           },

           updateUser(){

               this.$Progress.start();
               this.form.put('api/user/'+this.form.id)
               .then((response) => {
                   addNew.hide();
                   Toast.fire({
                        icon: 'success',
                        title: response.data.message
                        });
                        this.$Progress.finish();
                        this.loadUsers();
               })
               .catch(()=>{
                   this.$Progress.fail();
               });
           },

           editModal(user){
               this.editmode = true;
               this.form.reset();
               addNew.show();
               this.form.fill(user);
           },

           newModal(){
               this.editmode = false;
               this.form.reset();
               addNew.show();
           },

           deleteUser(id){
               Swal.fire({
                    title: 'Are you sure?',
                    text: "You cannot change this later!",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {

                         if (result.value) {
                                this.form.delete('api/user/'+id).then(()=>{
                                        Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        );

                                    this.loadUsers();
                                }).catch((data)=> {
                                  Swal.fire("Failed!", data.message, "warning");
                              });
                         }
               })
           }
       },

       mounted(){
           console.log('User Component Mounted..')
       },

       created(){
           this.$Progress.start();
           this.loadUsers();
           this.$Progress.finish();

           this.$Progress.start();
           Fire.$on('searching',()=>{
               let query = this.$parent.search;
               axios.get('aoi/search?q=' + query)
               .then((data)=>{
                   this.users = data.data
               })
               .catch(()=>{

               })
           })
           this.loadUsers();
           Fire.$on('AfterCreate',()=>{
               this.loadUsers();
           });

           this.$Progress.finish();
       }
    }
</script>
