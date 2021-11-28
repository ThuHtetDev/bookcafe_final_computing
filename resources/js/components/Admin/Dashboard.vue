<template>
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Admin</span>
                <span class="info-box-number">
                  {{datas.current_admin_count}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
               <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Member</span>
                <span class="info-box-number"> {{datas.current_member_count}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1">
              <i class="fas fa-indent"></i>
              </span>

              <div class="info-box-content">
                <span class="info-box-text">Category</span>
                <span class="info-box-number">{{datas.category_count}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1">
              <i class="fas fa-tasks"></i>
              </span>

              <div class="info-box-content">
                <span class="info-box-text">Current Book Count</span>
                <span class="info-box-number">{{datas.current_book_count}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

           <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1">
                <i class="fas fa-tasks"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Published Book Count</span>
                <span class="info-box-number">{{datas.publish_book_count}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

           <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1">
                <i class="fas fa-tasks"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pending Book Count</span>
                <span class="info-box-number">{{datas.pending_book_count}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1">  <i class="fas fa-tasks"></i></i></span>

              <div class="info-box-content">
                <span class="info-box-secondry">Books In Rent</span>
                <span class="info-box-number">{{datas.current_rent_count}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

        <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1">  <i class="fas fa-tasks"></i></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Books In Queue</span>
                <span class="info-box-number">{{datas.current_queue_count}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        <!-- /.col -->

        </div>
        <!-- /.row -->


      <div class="row" v-if="maxRentedBook.length > 0">
          <div class="col-md-12 text-center">
            <h3>Best Rented Book</h3>
          </div>
          <div class="col-12 col-sm-6 col-md-3" v-for="(data,index) in maxRentedBook" :key="index">
            <div class="info-box">
              <div class="info-box-content">
                <span class="info-box-text">{{data.name}}</span>
                <p>ID => {{data.id}}</p>
                <span class="info-box-number">
                  Rent Time => {{data.count}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
      </div>

       <div class="row" v-if="maxRentedUser.length > 0">
          <div class="col-md-12 text-center">
            <h3>The Most Rented Users</h3>
          </div>
          <div class="col-12 col-sm-6 col-md-3" v-for="(data,index) in maxRentedUser" :key="index">
            <div class="info-box">
              <div class="info-box-content">
                <span class="info-box-text">{{data.name}}</span>
                <p>ID => {{data.id}}</p>
                <span class="info-box-number">
                  Rent Time => {{data.count}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
      </div>

      <div class="row" v-if="maxUploadedBookUser.length > 0">
          <div class="col-md-12 text-center">
            <h3>The Most Book Upload Users</h3>
          </div>
          <div class="col-12 col-sm-6 col-md-3" v-for="(data,index) in maxUploadedBookUser" :key="index">
            <div class="info-box">
              <div class="info-box-content">
                <span class="info-box-text">{{data.name}}</span>
                <p>ID => {{data.id}}</p>
                <span class="info-box-number">
                  Uploaded Time => {{data.count}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
      </div>

    <div class="row" v-if="maxRentedBookThisMonth.length > 0">
          <div class="col-md-12 text-center">
            <h3>The Best 10 Rent Books For This Month</h3>
          </div>
          <div class="col-12 col-sm-6 col-md-3" v-for="(data,index) in maxRentedBookThisMonth" :key="index">
            <div class="info-box">
              <div class="info-box-content">
                <span class="info-box-text">{{data.name}}</span>
                <p>ID => {{data.id}}</p>
                <span class="info-box-number">
                  Rented Time => {{data.count}}
                </span>
              </div>
            </div>
          </div>
      </div>
      <div v-else>
         <div class="col-md-12 text-center">
            <h3>The Best 10 Rent Books For This Month is currently empty</h3>
          </div>
      </div>
        <!-- <div class="row">
          <div class="col-md-12 text-center">
            <h1>Best For one month</h1>
          </div>
          <div class="col-md-12">
            <div class="info-box mb-3 bg-info">
              <span class="info-box-icon"><i class="far fa-comment"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Direct Messages</span>
                <span class="info-box-number">163,921</span>
              </div>
            </div>
          </div>
          </div> -->
        </div>
    </section>
</template>

<script>
    export default {
         data () {
            return {
                datas : [],
                maxRentedBook: '',
                maxRentedUser: '',
                maxUploadedBookUser: '',
                maxRentedBookThisMonth: ''
            }
        },
        mounted(){
          this.$Progress.start();
          this.getData();
        },
        methods: {
               getData: function(){
                axios.get('/_bookcafe/admin/dashboard').then(response => {
                  this.datas = response.data;
                  this.maxRentedBook = this.datas.max_rented_book
                  this.maxRentedUser = this.datas.max_rented_user
                  this.maxUploadedBookUser = this.datas.max_uploaded_bookuser
                  this.maxRentedBookThisMonth = this.datas.max_rented_book_this_month
                  this.$Progress.finish();
                })
                .catch(error => {
                    console.log(error)
                })
            }
        }
    }
</script>