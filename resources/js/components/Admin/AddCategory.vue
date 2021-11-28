<template>
<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Register Book Category</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" @submit="formSubmit">
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" v-model="name" class="form-control" id="name" placeholder="Enter Book Category Name" required>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Save as New Category</button>
                </div>
              </form>
            </div>
</template>

<script>
    export default {
            data () {
            return {
                name: '',
            }
        },
        mounted() {
        },
        methods: {
            formSubmit: function(e){
                e.preventDefault();
                if(this.name != ''){
                    axios.post('/_bookcafe/add',{
                        name : this.name
                    })
                    .then(response => {
                        swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: response.data.message,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    this.name = '';
                    })
                    .catch(error => {
                        console.log(error)
                    })
                }
            }
        }
    }
</script>
